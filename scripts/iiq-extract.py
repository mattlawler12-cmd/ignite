#!/usr/bin/env python3
"""
Extract user-visible strings from either:
- a Claude Design SPA export (HTML shell + js/*.js bundle), or
- a rendered HTML page (e.g. fetched from staging)

Output: one unique string per line, length >= 4, sorted.
"""
import sys, re, html, os, glob
from html.parser import HTMLParser

SKIP_TAGS = {"script","style","noscript","template","head"}

class TextExtract(HTMLParser):
    def __init__(self):
        super().__init__()
        self.skip = 0
        self.out = []
    def handle_starttag(self, tag, attrs):
        if tag in SKIP_TAGS: self.skip += 1
    def handle_endtag(self, tag):
        if tag in SKIP_TAGS and self.skip: self.skip -= 1
    def handle_data(self, data):
        if self.skip: return
        for s in re.split(r"\s*\n\s*", data):
            s = re.sub(r"\s+", " ", html.unescape(s)).strip()
            if len(s) >= 4 and re.search(r"[A-Za-z]", s):
                self.out.append(s)

# Match string literals: 'single', "double", `template` (no interpolation only)
JS_STR_RE = re.compile(
    r'''(?<![A-Za-z0-9_$])'((?:[^'\\\n]|\\.)*)'  |  '''
    r'''(?<![A-Za-z0-9_$])"((?:[^"\\\n]|\\.)*)"  |  '''
    r'''(?<![A-Za-z0-9_$])`((?:[^`\\$]|\\.)*)`''',
    re.VERBOSE
)

CODE_TOKENS = (
    "React.createElement", "createElement", "useEffect", "useRef", "useState",
    "function ", "return ", "const ", " let ", " var ",
    "transform:", "translate(", "rotate(", "scale(",
    "var(--", "rgba(", "oklch(", "hsla(",
    "strokeWidth", "fillRule", "viewBox",
    "ResizeObserver", "matchMedia", "ctx.", "canvas.",
)

def looks_like_copy(s):
    """Strict heuristic: this looks like user-visible English copy, not code."""
    if len(s) < 4 or len(s) > 250: return False
    if not re.search(r"[A-Za-z]", s): return False
    # Code/JSX residue
    if any(t in s for t in CODE_TOKENS): return False
    # Brace/semicolon/equals = almost certainly code
    if re.search(r"[{};=<>]", s): return False
    # SVG path data: starts with M/L/H/V/A/C/S/T/Q/Z and is mostly numbers
    if re.match(r"^[MLHVZACSTQmlhvzacstq][\d.,\s-]+", s): return False
    # CSS key:value list
    if s.count(":") >= 1 and any(u in s for u in ("px","em","rem","%","vw","vh","ms ")): return False
    # Bare identifiers
    if re.fullmatch(r"[A-Za-z_$][A-Za-z0-9_$]{0,60}", s): return False
    if re.fullmatch(r"[a-z]+(-[a-z0-9]+)+", s): return False  # kebab class/token
    if re.fullmatch(r"[A-Z]+(_[A-Z0-9]+)+", s): return False  # CONST
    # URLs / paths
    if s.startswith(("http://","https://","mailto:","tel:","//","./","../","/")): return False
    if re.fullmatch(r"[\w./-]+\.(png|jpg|jpeg|svg|gif|webp|js|css|html|woff2?|ttf|otf)", s): return False
    # Numeric / hex / units
    if re.fullmatch(r"-?\d+(\.\d+)?(px|em|rem|%|vw|vh|s|ms|deg)?", s): return False
    if re.fullmatch(r"#?[0-9A-Fa-f]{3,8}", s): return False
    # Whitespace-only or punctuation-only
    if re.fullmatch(r"[\d\W_]+", s): return False
    # Word-density check: at least 60% alphabetic+space
    alpha_space = sum(1 for c in s if c.isalpha() or c == " ")
    if alpha_space / len(s) < 0.6: return False
    # Must have at least one space OR be capitalized headline >= 6 chars
    if " " not in s:
        if len(s) < 6: return False
        if not s[0].isupper(): return False
    return True

def extract_from_html(text):
    p = TextExtract()
    p.feed(text)
    return p.out

def _decode_js_str(s):
    s = s.replace("\\n"," ").replace("\\t"," ").replace("\\'", "'").replace('\\"','"').replace("\\`","`")
    # Decode \uXXXX escapes
    s = re.sub(r"\\u([0-9a-fA-F]{4})", lambda m: chr(int(m.group(1), 16)), s)
    s = re.sub(r"\\x([0-9a-fA-F]{2})", lambda m: chr(int(m.group(1), 16)), s)
    s = re.sub(r"\s+", " ", s).strip()
    return s

CSS_VALUE_RE = re.compile(r"^(?:\d+(?:\.\d+)?(?:px|em|rem|fr|%|vw|vh|ms|s|deg)\s*){1,}$")
CSS_SHORT_RE = re.compile(r"^\d+(?:\.\d+)?\s+\d+(?:\.\d+)?(?:\s+\d+(?:\.\d+)?){0,2}$")

def extract_from_js(text):
    out = []
    text = re.sub(r"/\*[\s\S]*?\*/", "", text)
    text = re.sub(r"^[ \t]*//.*$", "", text, flags=re.MULTILINE)
    for m in JS_STR_RE.finditer(text):
        s = m.group(1) or m.group(2) or m.group(3) or ""
        s = _decode_js_str(s)
        if not looks_like_copy(s): continue
        # Reject CSS-value-style strings post-decode
        if CSS_VALUE_RE.match(s) or CSS_SHORT_RE.match(s): continue
        if re.match(r"^repeat\(", s): continue
        out.append(s)
    return out

def main():
    if len(sys.argv) < 2:
        # Read HTML from stdin (used for staging fetch via curl pipe)
        text = sys.stdin.read()
        items = extract_from_html(text)
    else:
        target = sys.argv[1]
        items = []
        if os.path.isfile(target) and target.endswith(".html"):
            # Single HTML file — also pull strings from sibling js/*.js for SPA exports
            with open(target, encoding="utf-8", errors="ignore") as f:
                items.extend(extract_from_html(f.read()))
            jsdir = os.path.join(os.path.dirname(target), "js")
            if os.path.isdir(jsdir):
                page_name = os.path.basename(target).replace(".html","")
                # Load page-specific JS if there's a name match, plus shared chunks
                # Naming: <Page>.js is page-specific; SectionsA/B.js, Nav.js, etc. are shared
                for jsf in sorted(glob.glob(os.path.join(jsdir, "*.js"))):
                    with open(jsf, encoding="utf-8", errors="ignore") as f:
                        items.extend(extract_from_js(f.read()))
        else:
            # Directory — extract from all html + all js
            for root, _, files in os.walk(target):
                for fn in files:
                    p = os.path.join(root, fn)
                    if fn.endswith(".html"):
                        with open(p, encoding="utf-8", errors="ignore") as f:
                            items.extend(extract_from_html(f.read()))
                    elif fn.endswith(".js"):
                        with open(p, encoding="utf-8", errors="ignore") as f:
                            items.extend(extract_from_js(f.read()))

    seen = set()
    for s in items:
        if s not in seen:
            seen.add(s)
            print(s)

if __name__ == "__main__":
    main()
