<?php
/**
 * WP-CLI command: wp igniteiq:seed
 *
 * Seeds default ACF flexible-content rows for the IgniteIQ marketing site
 * (front-page, how-it-works, ontology, company, contact, signin).
 *
 * Usage:
 *   wp igniteiq seed
 *   wp igniteiq seed --force
 *   wp igniteiq seed --page=ontology
 *
 * @package IgniteIQ
 */

if (!defined('ABSPATH')) { exit; }

if (!class_exists('IgniteIQ_CLI')) {

    /**
     * IgniteIQ content seeder.
     *
     * Defined unconditionally so the admin migration tool can call
     * `IgniteIQ_CLI::default_pages()` outside of a WP-CLI context. The
     * `seed()` method uses WP_CLI helpers and is only safe to call when
     * WP_CLI is loaded.
     */
    class IgniteIQ_CLI {

        /**
         * Seed default page sections.
         *
         * ## OPTIONS
         *
         * [--force]
         * : Overwrite existing page_sections content.
         *
         * [--page=<slug>]
         * : Limit to a single slug (home|how-it-works|ontology|company|contact|signin).
         *
         * @when after_wp_load
         */
        public function seed($args, $assoc_args) {
            if (!function_exists('update_field')) {
                WP_CLI::error('ACF Pro is not active. Aborting.');
                return;
            }

            $force      = !empty($assoc_args['force']);
            $only_slug  = isset($assoc_args['page']) ? sanitize_key($assoc_args['page']) : null;
            $pages      = self::default_pages();

            foreach ($pages as $slug => $rows) {
                if ($only_slug && $slug !== $only_slug) {
                    continue;
                }

                $page_id = $this->find_or_create_page($slug);
                if (!$page_id) {
                    WP_CLI::warning("Could not resolve page for slug: {$slug}");
                    continue;
                }

                $existing = get_field('page_sections', $page_id);
                if (!empty($existing) && !$force) {
                    WP_CLI::warning("Skipping '{$slug}' (id {$page_id}) — already has page_sections. Use --force to overwrite.");
                    continue;
                }

                $ok = update_field('page_sections', $rows, $page_id);
                if ($ok) {
                    WP_CLI::success("Seeded '{$slug}' (id {$page_id}) with " . count($rows) . ' sections.');
                } else {
                    WP_CLI::warning("update_field returned falsy for '{$slug}' (id {$page_id}).");
                }
            }

            WP_CLI::log('Done.');
        }

        /**
         * Resolve page slug → page ID. For 'home', return show_on_front page.
         * Creates a page if missing.
         */
        private function find_or_create_page($slug) {
            if ($slug === 'home') {
                $front = (int) get_option('page_on_front');
                if ($front) {
                    return $front;
                }
                $existing = get_page_by_path('home');
                if ($existing) {
                    return $existing->ID;
                }
                $id = wp_insert_post([
                    'post_title'   => 'Home',
                    'post_name'    => 'home',
                    'post_type'    => 'page',
                    'post_status'  => 'publish',
                ]);
                if (!is_wp_error($id)) {
                    update_option('show_on_front', 'page');
                    update_option('page_on_front', $id);
                    return $id;
                }
                return 0;
            }

            $page = get_page_by_path($slug);
            if ($page) {
                return $page->ID;
            }
            $title = ucwords(str_replace('-', ' ', $slug));
            $id = wp_insert_post([
                'post_title'  => $title,
                'post_name'   => $slug,
                'post_type'   => 'page',
                'post_status' => 'publish',
            ]);
            return is_wp_error($id) ? 0 : $id;
        }

        /**
         * The whole content payload, by slug.
         */
        public static function default_pages() {
            return [
                'home'         => self::page_home(),
                'how-it-works' => self::page_how_it_works(),
                'ontology'     => self::page_ontology(),
                'company'      => self::page_company(),
                'contact'      => self::page_contact(),
                'signin'       => self::page_signin(),
            ];
        }

        // ───────────────────────────────────────────────────────────
        // HOME — App.js render order:
        // HeroStatement → HeroEditorial → WhyItMattersSection (01)
        // → ProblemSection (02) → ArchStackDiagram (03 The stack)
        // → WhatChangesSection (04) → InvestInOutcomesSection (05 The path)
        // → DeploymentSection (06) → CTASection
        // ───────────────────────────────────────────────────────────
        private static function page_home() {
            return [
                // HeroStatement (Hero.js, App.js: showStatement=true, statement='decision')
                [
                    'acf_fc_layout'  => 'hero_statement',
                    'eyebrow'        => '',
                    'headline_lines' => [
                        ['line' => 'The Decision Engine for Modern Trades.'],
                    ],
                    'subhead' => 'Your business makes a thousand decisions a day. IgniteIQ makes every one faster, smarter, and right — running on enterprise-grade infrastructure deployed inside your cloud.',
                    'primary_cta'   => ['label' => '', 'url' => ''],
                    'secondary_cta' => ['label' => '', 'url' => ''],
                    'stats' => [
                        ['value' => '< 7 days', 'label' => 'Time to deployed'],
                        ['value' => '25+',      'label' => 'Systems unified'],
                        ['value' => '100%',     'label' => 'Customer-owned'],
                        ['value' => 'v4.2',     'label' => 'Framework version'],
                    ],
                ],

                // FIDELITY NOTE: the export's home page (App.js) computes a
                // `HeroComp` (HeroEditorial/Cinematic/Split per tweaks.hero) but
                // its JSX return does NOT render that variable — only HeroStatement
                // appears before WhyItMattersSection. So the home page has ONE
                // hero, not two. The "Built by the operators who ran the trucks."
                // headline lives only in the dev tweaks panel as an alternative.

                // WhyItMattersSection (SectionsA.js, index="01" label="Why this matters")
                [
                    'acf_fc_layout' => 'section_prose',
                    '_settings' => [
                        'section_index' => '01',
                        'section_label' => 'Why this matters',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => '',
                    'headline' => "The companies that win the next decade won't be the ones with the best software. They’ll be the ones who own their intelligence.",
                    'style'    => 'single',
                    'paragraphs' => [
                        ['paragraph' => '<p>Every advantage in this industry gets copied. A new tool. A new tactic. A new vendor. The infrastructure underneath your business doesn’t. Owning your intelligence is the only advantage that compounds - and the operators who build it will outlast the ones who rent it.</p>'],
                    ],
                ],

                // ProblemSection (SectionsA.js, index="02" label="The problem")
                [
                    'acf_fc_layout' => 'section_gap_split',
                    '_settings' => [
                        'section_index' => '02',
                        'section_label' => 'The problem',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'       => '',
                    'headline_lead' => 'Every home services business is a decision-making engine.',
                    'headline_gap'  => 'The data underneath is blurry.',
                    'body_left'     => '<p>A $15M HVAC company makes thousands of micro-decisions a day — which job to dispatch, which lead to call back, which technician to send where. The compounding quality of those decisions separates a 12% margin company from a 22% margin company.</p>',
                    'body_right'    => '<p>Today those decisions are made on data spread across 15 to 25 disconnected systems — siloed, duplicated, often contradictory. The AI tools sold into this market promise to fix it and consistently fail. The foundation underneath was never ready.</p>',
                    'pull_quote'    => 'AI without clean, structured data is expensive guessing.',
                    'diagram_key'   => 'operator-stack',
                ],

                // ArchStackDiagram on home (App.js: index="03", label="The stack")
                [
                    'acf_fc_layout' => 'diagram',
                    '_settings' => [
                        'section_index' => '03',
                        'section_label' => 'The stack',
                        'theme_variant' => 'light',
                    ],
                    'diagram_key'    => 'stack',
                    'caption'        => '',
                    'index'          => '03',
                    'label'          => 'The stack',
                    'header_label'   => 'How it all fits together',
                    'headline_left'  => 'One model of your business.',
                    'headline_right' => 'Every product, every object, every system reads from it.',
                    'body'           => 'IgniteIQ deploys a data warehouse inside your cloud, unifies every operational system into a single ontology, and runs AI products on top of it. The whole stack is built to do one thing - make every decision your business makes sharper than the one before it.',
                    'closing_line'   => 'Every decision — faster, smarter, and right.',
                ],

                // WhatChangesSection (SectionsA.js, index="04" label="What changes for you")
                [
                    'acf_fc_layout' => 'section_pillars',
                    '_settings' => [
                        'section_index' => '04',
                        'section_label' => 'What changes for you',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => '',
                    'headline' => 'Better decisions. What changes for you?',
                    'intro'    => 'When data is structured the right way, decisions change. Answers come faster, quality improves, and trust becomes automatic — turning everyday decisions into a competitive advantage.',
                    'columns'  => '3',
                    'style'    => 'bars',
                    'items' => [
                        [
                            'index_number' => '01',
                            'title' => 'Speed',
                            'body'  => 'Decisions in minutes instead of weeks. The data is already modeled, already current, already in your hands — so the answer comes back at the speed of the question.',
                        ],
                        [
                            'index_number' => '02',
                            'title' => 'Quality',
                            'body'  => 'Clean, unified data that understands how your business actually runs and the goals you’re working toward. One model of the business, not fifteen disagreeing systems.',
                        ],
                        [
                            'index_number' => '03',
                            'title' => 'Trust',
                            'body'  => 'A single source of truth. Every answer is traceable to the underlying data, scoped inside your environment, and consistent across every team that asks.',
                        ],
                    ],
                    'scenarios' => [
                        [
                            'tag'  => 'Speed · Dispatch',
                            'body' => 'A dispatcher reroutes a tech because the system saw the higher-margin job before they did. Margin per truck-hour goes up by Friday.',
                        ],
                        [
                            'tag'  => 'Quality · Pricing',
                            'body' => 'A regional price change ships in a day, and the downstream effect on margin is visible by the next service call — not the next quarter.',
                        ],
                        [
                            'tag'  => 'Trust · Marketing',
                            'body' => 'Last week’s spend gets attributed to the channel that actually drove revenue, not the one that claimed it. Next week’s budget shifts in an hour.',
                        ],
                    ],
                ],

                // InvestInOutcomesSection (InvestInOutcomes.js, index="05" label="The path")
                [
                    'acf_fc_layout' => 'section_pillars',
                    '_settings' => [
                        'section_index' => '05',
                        'section_label' => 'The path',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => '',
                    'headline' => 'Invest in outcomes. Not experiments.',
                    'intro'    => 'Growth isn’t built on guesswork - it’s built on clarity, control, and systems that compound. A proven path from fragmented data to operational intelligence in weeks, with value that strengthens at every step.',
                    'columns'  => '3',
                    'style'    => 'bars',
                    'items' => [
                        [
                            'index_number' => '01',
                            'title' => 'CLARITY',
                            'body'  => "We unify your data across FSM's, marketing, call center, operations, and more — cleaning, structuring, and connecting it into a single source of truth. No more conflicting reports or blind spots. You see exactly what’s driving revenue, where you’re losing it, and what actually matters.",
                        ],
                        [
                            'index_number' => '02',
                            'title' => 'CONTROL',
                            'body'  => 'We turn your business into a system you can actively manage — surfacing the exact levers that impact performance across marketing, booking, and operations. Spot issues early, make faster decisions, and align your team around one clear view of reality.',
                        ],
                        [
                            'index_number' => '03',
                            'title' => 'CONFIDENCE',
                            'body'  => 'We give you the insight and predictability to make high-stakes decisions without hesitation — from budget allocation to hiring to expansion. When the data is right and the system is clear, you move with conviction instead of guesswork.',
                        ],
                    ],
                    'scenarios' => [],
                ],

                // DeploymentSection (SectionsA.js, index="06" label="Deployment")
                [
                    'acf_fc_layout' => 'section_stack',
                    '_settings' => [
                        'section_index' => '06',
                        'section_label' => 'Deployment',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => 'Time to live',
                    'headline' => 'What used to take a year. Shipped in a week.',
                    'body'     => 'IgniteIQ deploys real infrastructure - a data warehouse in your cloud, your data unified into the ontology, AI products running on top - in seven days. Not a pilot. Not a slide deck. Production infrastructure from day one.',
                    'layout'   => 'timeline-horizontal',
                    'items' => [
                        ['step' => 'Day 0', 'title' => 'Contract signed',    'body' => 'Workspace provisioned in your cloud.'],
                        ['step' => 'Day 2', 'title' => 'Systems connected',  'body' => '15–25 source systems wired into the warehouse.'],
                        ['step' => 'Day 5', 'title' => 'Ontology activated', 'body' => 'Jobs, leads, technicians, invoices resolved into one model.'],
                        ['step' => 'Day 7', 'title' => 'Live decisions',     'body' => 'Analytics + agents shipping decisions to operators.'],
                    ],
                ],

                // CTASection (SectionsB.js)
                [
                    'acf_fc_layout' => 'cta_banner',
                    '_settings' => [
                        'section_index' => '',
                        'section_label' => 'Get started today',
                        'theme_variant' => 'dark',
                    ],
                    'headline'      => 'Own Your Intelligence.',
                    'body'          => 'Your cloud. Your data. Your Intelligence. Deployed in days, not months - and yours from the moment we ship.',
                    'primary_cta'   => ['label' => 'Get started today', 'url' => '/contact/'],
                    'secondary_cta' => ['label' => 'How it works',      'url' => '/how-it-works/'],
                    'variant'       => 'dark',
                ],
            ];
        }

        // ───────────────────────────────────────────────────────────
        // HOW IT WORKS — Architecture.js render order:
        // ArchHero → ArchTwoHalves (01) → PlatformStackDiagram (02)
        // → ArchHeadless (03) → ArchHowItDeploys (04) → ArchSecurity (05)
        // → ArchCTA
        // ───────────────────────────────────────────────────────────
        private static function page_how_it_works() {
            return [
                // ArchHero (Architecture.js)
                [
                    'acf_fc_layout' => 'hero_editorial',
                    'eyebrow'        => 'Architecture · v4.2',
                    'headline_lines' => [
                        ['line' => 'Built on your cloud.'],
                        ['line' => 'Run on your data.'],
                    ],
                    'body'          => "<p>The IgniteIQ architecture is built around one premise: your warehouse, your data, and the intelligence layer all run inside your cloud account. Modular, replaceable, and continuously compounding it's intelligence.</p>",
                    'primary_cta'   => ['label' => '', 'url' => ''],
                    'secondary_cta' => ['label' => '', 'url' => ''],
                    'dark'          => true,
                    'size_variant'  => 'compact',
                    'stats' => [
                        ['label' => 'Your cloud',           'value' => 'Enterprise grade cloud infrastructure'],
                        ['label' => 'Your data',            'value' => 'Safe. Unified. Clean. Trusted.'],
                        ['label' => 'Runs in your account', 'value' => 'IgniteIQ Ontology Layer'],
                        ['label' => 'Framework version',    'value' => 'v4.2'],
                    ],
                ],

                // ArchTwoHalves (Architecture.js, index="01" label="How it runs")
                // Renders headline + body + ArchOntologyScene diagram below in vertical stack.
                [
                    'acf_fc_layout' => 'section_stacked_prose_diagram',
                    '_settings' => [
                        'section_index' => '01',
                        'section_label' => 'How it runs',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'       => '',
                    'headline'      => 'Your warehouse holds your data. Our intelligence framework runs alongside it.',
                    'body'          => '<p>The IgniteIQ architecture deploys directly into your owned enterprise-grade cloud account — provisioned for you. Every line of business — every job, customer, technician, truck — gets resolved into a single model that lives in your warehouse and is queried by the framework. Your data never leaves your IAM.</p>',
                    'diagram_type'  => 'arch-ontology',
                ],

                // PlatformStackDiagram (PlatformStack.js, index="02" label="The stack")
                // FIDELITY EXCEPTION: the platform-stack diagram component renders
                // its own headline ("The most intelligent infrastructure in home
                // services") and DATA/LOGIC/ACTIONS pillars internally. The
                // `diagram` layout's headline_left/right and body fields are
                // unused for platform-stack rendering; we still populate header
                // metadata so the section index/label render correctly.
                [
                    'acf_fc_layout' => 'diagram',
                    '_settings' => [
                        'section_index' => '02',
                        'section_label' => 'The stack',
                        'theme_variant' => 'light',
                    ],
                    'diagram_key'    => 'platform-stack',
                    'caption'        => '',
                    'index'          => '02',
                    'label'          => 'The stack',
                    'header_label'   => 'The stack',
                    'headline_left'  => 'The most intelligent',
                    'headline_right' => 'infrastructure in home services',
                    'body'           => '',
                    'closing_line'   => '',
                ],

                // ArchHeadless (Architecture.js, index="03" label="Headless by design")
                [
                    'acf_fc_layout' => 'section_contrast',
                    '_settings' => [
                        'section_index' => '03',
                        'section_label' => 'Headless by design',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'         => 'Headless by design',
                    'headline'        => 'The product is the infrastructure.',
                    'headline_accent' => 'The interface is your choice.',
                    'body_left'       => '<p>IgniteIQ is headless by design. In software, <strong>"headless"</strong> means a product where the underlying platform - the data, the logic, the actions - is decoupled from any single user interface. The platform runs underneath; the interface is interchangeable. It can be a dashboard, a spreadsheet, a Slack message, a custom app, or no human surface at all.</p>',
                    'body_right'      => "<p>The IgniteIQ infrastructure runs inside your cloud. The output can live in our studio if you want a place to start. It can flow into the tools your team already uses. It can power custom applications your developers build on top of it. And it can be acted on directly by AI agents and automations without any human surface at all. The platform doesn't depend on the head - and that's the point. The world's largest enterprise software companies are spending years rebuilding their products this way. We started here.</p>",
                    'table_header_old' => 'The old model',
                    'table_header_new' => 'The headless model',
                    'rows' => [
                        ['old_text' => 'A SaaS app you log into',          'new_text' => 'A platform that runs in your cloud'],
                        ['old_text' => 'Seats, licenses, and dashboards',  'new_text' => 'APIs, ontology, and agents'],
                        ['old_text' => 'One UI, take it or leave it',      'new_text' => 'Any interface — or no interface at all'],
                        ['old_text' => 'Your data lives in their product', 'new_text' => 'Your data lives in your warehouse'],
                        ['old_text' => 'You rent the interface',           'new_text' => 'You own the infrastructure'],
                    ],
                ],

                // ArchHowItDeploys (Architecture.js, index="04" label="How it deploys")
                [
                    'acf_fc_layout' => 'section_stack',
                    '_settings' => [
                        'section_index' => '04',
                        'section_label' => 'How it deploys',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => 'From contract to live',
                    'headline' => 'Deployed Fast. Decades of Value.',
                    'body'     => 'Versioned. Auditable. Every deployment ships through the same defined process — and every framework update flows back to every operator on the platform.',
                    'layout'   => 'grid-3col',
                    'items' => [
                        ['step' => 'Day 0',   'title' => 'Workspace provisioned',    'body' => 'Snowflake/BigQuery account stood up under your credentials. Ontology framework v4.2 deployed as code.'],
                        ['step' => 'Day 1–2', 'title' => 'Source systems connected', 'body' => 'CRM, dispatch, accounting, marketing. 15–25 systems. Pipelines land raw data into your warehouse.'],
                        ['step' => 'Day 3–5', 'title' => 'Ontology activated',       'body' => 'Resolution layer maps source records into ontology entities. Identity stitching runs across systems.'],
                        ['step' => 'Day 6–7', 'title' => 'Live decisions',           'body' => 'Armory Intel queries the resolved ontology. Signal monitors it. Agents act on it. All inside your cloud.'],
                        ['step' => 'Ongoing', 'title' => 'Versioned, compounding',   'body' => 'Framework updates ship via git. New entities, edge cases, and patterns flow back from every deployment.'],
                    ],
                ],

                // ArchSecurity (Architecture.js, index="05" label="Security model")
                [
                    'acf_fc_layout' => 'section_pillars',
                    '_settings' => [
                        'section_index' => '05',
                        'section_label' => 'Security model',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => 'Security',
                    'headline' => 'Your data, safe. Secured. Governed.',
                    'intro'    => '',
                    'columns'  => '3',
                    'style'    => 'grid-divided',
                    'items' => [
                        ['index_number' => '01', 'title' => 'Customer cloud isolation', 'body' => 'IgniteIQ never holds your data outside your account. There is no shared multi-tenant warehouse.'],
                        ['index_number' => '02', 'title' => 'Scoped credentials',       'body' => 'The framework reads under a least-privilege role. Read scope is documented and audited per-deployment.'],
                        ['index_number' => '03', 'title' => 'Audit logging',            'body' => 'Every framework query is logged in your warehouse, queryable by you, retained on your terms.'],
                        ['index_number' => '04', 'title' => 'Versioned framework',      'body' => 'You pin the framework version. Updates ship with release notes; you decide when to take them.'],
                        ['index_number' => '05', 'title' => 'SOC 2 in-flight',          'body' => 'Type II audit underway. Standard enterprise controls, security questionnaires, and DPA available.'],
                        ['index_number' => '06', 'title' => 'No PII training',          'body' => 'No customer data is used to train models outside the customer environment. Period.'],
                    ],
                    'scenarios' => [],
                ],

                // ArchCTA (Architecture.js)
                [
                    'acf_fc_layout' => 'cta_banner',
                    '_settings' => [
                        'section_index' => '',
                        'section_label' => 'Ready to deploy',
                        'theme_variant' => 'dark',
                    ],
                    'headline'      => 'Get started today.',
                    'body'          => 'From contract to a live, queryable intelligence engine in seven days. We share security documentation, deployment plans, and a price up front.',
                    'primary_cta'   => ['label' => 'Start the conversation', 'url' => '/contact/'],
                    'secondary_cta' => ['label' => 'Back to overview',       'url' => '/'],
                    'variant'       => 'dark',
                ],
            ];
        }

        // ───────────────────────────────────────────────────────────
        // ONTOLOGY — Ontology.js render order:
        // OntologyHero → WhatIsAnOntology (01) → WhyHomeServices (02)
        // → ArchStackDiagram (03 The flow) → CoreEntities (04)
        // → HowItDeploys (05) → CTASection
        // ───────────────────────────────────────────────────────────
        private static function page_ontology() {
            return [
                // OntologyHero (Ontology.js)
                [
                    'acf_fc_layout' => 'hero_ontology',
                    'eyebrow'       => '● The ontology · v4.2',
                    'headline_segments' => [
                        ['text' => 'Ontology is the',       'muted' => false],
                        ['text' => ' nouns and verbs ',     'muted' => true],
                        ['text' => 'of how your business',  'muted' => false],
                        ['text' => ' actually runs.',       'muted' => true],
                    ],
                    'lede' => "Every home services business runs on a web of interconnected relationships - jobs, customers, technicians, calls, invoices - moving and changing every hour. An ontology is the layer that encodes those relationships into a shared model: the ground truth of how your business is actually operating. It's the difference between a company that runs on assumptions scattered across fifteen systems, and a company that runs on a single, shared definition of itself.",
                ],

                // WhatIsAnOntology (Ontology.js, index="01" label="The concept")
                [
                    'acf_fc_layout' => 'section_pillars',
                    '_settings' => [
                        'section_index' => '01',
                        'section_label' => 'The concept',
                        'theme_variant' => 'sunken',
                    ],
                    'eyebrow'  => '',
                    'headline' => 'Great decisions require three things. The ontology encodes all of them.',
                    'intro'    => '',
                    'columns'  => '3',
                    'style'    => 'bordered',
                    'items' => [
                        ['index_number' => '01', 'title' => 'Data',    'body' => 'The current state of your business. Every job, customer, technician, invoice, and call from every system, resolved into a single set of objects with shared definitions.'],
                        ['index_number' => '02', 'title' => 'Logic',   'body' => 'How your business thinks about those objects. The rules — how margin is calculated, how a callback is defined, how a lead becomes a job — modeled so every tool and every agent applies them the same way.'],
                        ['index_number' => '03', 'title' => 'Actions', 'body' => 'What your business does about it. Dispatching, pricing, reordering, escalating. The ontology models the decisions a business takes so AI and humans can take those decisions inside the same system.'],
                    ],
                    'scenarios' => [],
                ],

                // WhyHomeServices (Ontology.js, index="02" label="Why home services")
                [
                    'acf_fc_layout' => 'section_pillars',
                    '_settings' => [
                        'section_index' => '02',
                        'section_label' => 'Why home services',
                        'theme_variant' => 'dark',
                    ],
                    'eyebrow'  => '',
                    'headline' => "Generic ontologies don't know what a callback costs you.",
                    'intro'    => "The AI tools sold into home services promise to make your business smarter. They can't. The data underneath them is fragmented, contradictory, and shaped for someone else's industry. We didn't start from a blank slate - the IgniteIQ ontology was built next to operators, inside the trucks, on the dispatch board, in the books, and shaped specifically for the economics of HVAC, electrical, plumbing, and the rest of the trades.",
                    'columns'  => '3',
                    'style'    => 'bordered',
                    'items' => [
                        ['index_number' => '01', 'title' => 'The economics are unit-based.',         'body' => 'Margin per job. Cost per lead. Revenue per technician hour. The ontology is wired to the unit economics that actually matter — not adapted from retail or SaaS.'],
                        ['index_number' => '02', 'title' => 'The data is messy and operational.',    'body' => 'Field-typed by techs. Reconciled across CRM, dispatch, accounting. The ontology resolves naming, ID, and timing conflicts that would crash a generic model.'],
                        ['index_number' => '03', 'title' => 'The decisions repeat across operators.', 'body' => 'The 12 core entities — Job, Lead, Customer, Technician, Invoice, Equipment, Channel, Call, Dispatch, Payment, Inventory, Membership — are the operational DNA of every home services business.'],
                    ],
                    'scenarios' => [],
                ],

                // ArchStackDiagram on ontology page (Ontology.js: index="03", headerLabel="The flow")
                [
                    'acf_fc_layout' => 'diagram',
                    '_settings' => [
                        'section_index' => '03',
                        'section_label' => 'The flow',
                        'theme_variant' => 'light',
                    ],
                    'diagram_key'    => 'stack',
                    'caption'        => '',
                    'index'          => '03',
                    'label'          => 'The flow',
                    'header_label'   => 'The flow',
                    'headline_left'  => 'One ontology.',
                    'headline_right' => 'Every product, every model, every system reads from it.',
                    'body'           => 'The IgniteIQ ontology resolves the operational entities of a home services business into a single shared object model. Analytics queries it. Agents act on it. Automations write back through it. Every flow in the diagram is a real edge in your warehouse.',
                    'closing_line'   => 'Your business makes a thousand decisions a day. We make every one faster, smarter, and right.',
                ],

                // CoreEntities — KPI strip (Ontology.js, index="04" label="The 12 core entities")
                [
                    'acf_fc_layout' => 'section_stats',
                    '_settings' => [
                        'section_index' => '04',
                        'section_label' => 'The 12 core entities',
                        'theme_variant' => 'light',
                    ],
                    'headline' => "A home services business isn't simple. The ontology makes it usable.",
                    'style'    => 'bare',
                    'stats' => [
                        ['value' => '200+',       'label' => 'Object types',   'footnote' => "A single mid-size operator runs on hundreds of distinct object types, thousands of relationships, and dozens of source systems that don't agree on what any of them mean. The IgniteIQ ontology resolves all of it — into a model that's queryable, governable, and built to compound as your business grows."],
                        ['value' => '5,000+',     'label' => 'Relationships',  'footnote' => ''],
                        ['value' => '25+',        'label' => 'Source systems', 'footnote' => ''],
                        ['value' => 'Continuous', 'label' => 'Resolution',     'footnote' => ''],
                    ],
                ],

                // CoreEntities — supporting block trio (Ontology.js, same index 04)
                // FIDELITY EXCEPTION: the export renders the KPI strip and the
                // 3-column "One customer, not four / One job / One technician"
                // grid inside the same component. Splitting into two flexible-
                // content rows preserves the copy verbatim using the closest
                // schema layouts (section_stats + section_pillars).
                [
                    'acf_fc_layout' => 'section_pillars',
                    '_settings' => [
                        'section_index' => '04',
                        'section_label' => 'The 12 core entities',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => '',
                    'headline' => '',
                    'intro'    => '',
                    'columns'  => '3',
                    'style'    => 'bordered',
                    'items' => [
                        ['index_number' => '01', 'title' => 'One customer, not four.',           'body' => 'The same homeowner might exist as four different records across CRM, dispatch, billing, and call tracking. The ontology resolves them into a single customer object — with one history, one value, one definition.'],
                        ['index_number' => '02', 'title' => 'One job, across every system.',     'body' => 'A "job" in ServiceTitan is not the same as a "job" in your accounting system or your marketing platform. The ontology reconciles every source into one job object, so every tool downstream — analytics, dispatch, AI agents — speaks the same language.'],
                        ['index_number' => '03', 'title' => 'One technician, with full context.', 'body' => 'Dispatch knows their schedule. Payroll knows their hours. Certifications live somewhere else entirely. The ontology rolls them into one technician object that every part of the business can query.'],
                    ],
                    'scenarios' => [
                        [
                            'tag'  => 'The point',
                            'body' => 'What looks like fifteen disconnected systems on the surface is one business underneath. The ontology is the layer where it finally acts like one.',
                        ],
                    ],
                ],

                // HowItDeploys (Ontology.js, index="05" label="How it deploys")
                [
                    'acf_fc_layout' => 'section_stats',
                    '_settings' => [
                        'section_index' => '05',
                        'section_label' => 'How it deploys',
                        'theme_variant' => 'sunken',
                    ],
                    'headline' => 'The ontology ships into your warehouse as code.',
                    'style'    => 'bare',
                    'stats' => [
                        ['value' => 'Versioned code', 'label' => 'Ships as',     'footnote' => "The IgniteIQ ontology deploys directly into your cloud account — Snowflake, BigQuery, or Databricks — and resolves your operational data in seven days. Every framework update flows back to every operator on the platform, so the ontology gets sharper every month without a re-implementation. Versioned. Auditable. In your warehouse, not ours."],
                        ['value' => 'Your warehouse', 'label' => 'Lives in',     'footnote' => ''],
                        ['value' => '< 7 days',       'label' => 'Time to live', 'footnote' => ''],
                        ['value' => 'Continuous',     'label' => 'Updates',      'footnote' => ''],
                    ],
                ],

                // CTASection (SectionsB.js, shared with home)
                [
                    'acf_fc_layout' => 'cta_banner',
                    '_settings' => [
                        'section_index' => '',
                        'section_label' => 'Get started today',
                        'theme_variant' => 'dark',
                    ],
                    'headline'      => 'Own Your Intelligence.',
                    'body'          => 'Your cloud. Your data. Your Intelligence. Deployed in days, not months - and yours from the moment we ship.',
                    'primary_cta'   => ['label' => 'Get started today', 'url' => '/contact/'],
                    'secondary_cta' => ['label' => 'How it works',      'url' => '/how-it-works/'],
                    'variant'       => 'dark',
                ],
            ];
        }

        // ───────────────────────────────────────────────────────────
        // COMPANY — Company.js render order:
        // CompanyHero → WhatWeAre (01) → FoundingStory (02)
        // → MissionPrinciples (03) → TeamDeep (03 The team) → ContactSection
        // ───────────────────────────────────────────────────────────
        private static function page_company() {
            return [
                // CompanyHero (Company.js)
                [
                    'acf_fc_layout' => 'hero_editorial',
                    'eyebrow'        => '● Company',
                    'headline_lines' => [
                        ['line' => 'Operators who ran the trucks.'],
                        ['line' => 'Architects who modernized the industry. Innovators building what’s next.'],
                    ],
                    'body'          => '',
                    'primary_cta'   => ['label' => '', 'url' => ''],
                    'secondary_cta' => ['label' => '', 'url' => ''],
                    'dark'          => false,
                ],

                // WhatWeAre (Company.js, index="01" label="We’re not an AI company")
                [
                    'acf_fc_layout' => 'section_split',
                    '_settings' => [
                        'section_index' => '01',
                        'section_label' => 'We’re not an AI company',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => '',
                    'headline' => 'We’re not an AI company.',
                    'body'     => '<p>We’re not here to sell you a new flashy tool. We build the infrastructure that makes your systems, tools, and AI actually work. We don’t rent access. We build it. You keep it.</p>',
                    'media_slot'  => 'diagram',
                    'diagram_key' => '',
                    'reverse'  => false,
                ],

                // FoundingStory (Company.js, index="02" label="The founding story")
                [
                    'acf_fc_layout' => 'section_prose',
                    '_settings' => [
                        'section_index' => '02',
                        'section_label' => 'The founding story',
                        'theme_variant' => 'sunken',
                    ],
                    'eyebrow'  => '',
                    'headline' => "We've been on every side of this problem.",
                    'style'    => 'split',
                    'paragraphs' => [
                        ['paragraph' => "<p>Our founder ran an electrical and HVAC company. He built and exited the largest independent customer acquisition agency in the trades. He's sat in the truck, on the dispatch board, and across the table from operators trying to make sense of seven systems that don't talk to each other.</p>"],
                        ['paragraph' => '<p>Two of our senior engineering leaders helped build ServiceTitan from the inside — one as Executive Architect across every API, one as VP of Engineering. They know home services data at the schema level better than almost anyone in the industry.</p>'],
                        ['paragraph' => "<p>We started IgniteIQ because the answer wasn't another app or another dashboard. The answer was a structured model of the business — owned by the operator, deployed in their cloud, and built specifically for the trades. That's the foundation. Everything we ship sits on top of it.</p>"],
                        ['paragraph' => '<p><em>● Founded 2024 · Headquartered remote-first</em></p>'],
                    ],
                ],

                // MissionPrinciples (Company.js, index="03" label="What we believe")
                [
                    'acf_fc_layout' => 'section_pillars',
                    '_settings' => [
                        'section_index' => '03',
                        'section_label' => 'What we believe',
                        'theme_variant' => 'light',
                    ],
                    'eyebrow'  => '',
                    'headline' => 'Three things we believe about the next decade of home services.',
                    'intro'    => '',
                    'columns'  => '3',
                    'style'    => 'top-border',
                    'items' => [
                        ['index_number' => '01', 'title' => 'Your data is yours.',             'body' => 'It lives in your cloud. The vendor that won’t agree to that is renting you back your own business.'],
                        ['index_number' => '02', 'title' => 'Intelligence compounds.',         'body' => 'Every week the system gets sharper. Every decision gets faster. The operators who build on solid foundations outlast every cycle of new tools.'],
                        ['index_number' => '03', 'title' => 'Infrastructure beats interface.', 'body' => 'Dashboards are wallpaper. Foundations are leverage. The companies that win this decade will be the ones that built the foundation, not the ones that licensed the dashboard.'],
                    ],
                    'scenarios' => [],
                ],

                // TeamDeep (Company.js, index="03" label="The team")
                [
                    'acf_fc_layout' => 'section_team',
                    '_settings' => [
                        'section_index' => '03',
                        'section_label' => 'The team',
                        'theme_variant' => 'light',
                    ],
                    'headline'     => 'The only team in the category with this combination.',
                    'avatar_style' => 'square',
                    'members' => [
                        [
                            'name'  => 'Scott Rayden',
                            'role'  => 'Founder & CEO',
                            'bio'   => 'Built and exited an electrical / HVAC company. Ran the largest independent customer acquisition agency in the U.S. — 350 employees, $2B/yr managed media. Six M&A transactions, $150M+ in exit value. Has lived the operator side of the problem and the marketing side of the system gap.',
                            'photo' => false,
                        ],
                        [
                            'name'  => 'Ryan Sciandri',
                            'role'  => 'CTO',
                            'bio'   => 'Former Executive Architect at ServiceTitan. Led API development across every department of the platform. Knows home services data at the schema level better than almost anyone in the industry — and knows where the seams are.',
                            'photo' => false,
                        ],
                        [
                            'name'  => 'Darren Merritt',
                            'role'  => 'VP of Engineering',
                            'bio'   => 'Former VP of Engineering at ServiceTitan. Most recently CPO at PipeDreams, a PE-backed home services roll-up. Brings the operator perspective on what breaks at scale and how to engineer for it.',
                            'photo' => false,
                        ],
                        [
                            'name'  => 'Josh Scott',
                            'role'  => 'Go To Market',
                            'bio'   => 'Leads the deployment motion that turns a signed contract into a live, producing intelligence engine in days, not months. Owns the customer experience from kickoff through compounding production use.',
                            'photo' => false,
                        ],
                        [
                            'name'  => 'Matt Lawler',
                            'role'  => 'Marketing',
                            'bio'   => 'Shapes the product surface that operators actually live in — the Armory dashboards, the agent workflows, the ontology authoring tools. Translates how operators run their business into an interface that runs on top of the framework.',
                            'photo' => false,
                        ],
                    ],
                ],

                // ContactSection (Company.js — same copy as ArchCTA)
                [
                    'acf_fc_layout' => 'cta_banner',
                    '_settings' => [
                        'section_index' => '',
                        'section_label' => 'Ready to deploy',
                        'theme_variant' => 'dark',
                    ],
                    'headline'      => 'Get started today.',
                    'body'          => 'From contract to a live, queryable intelligence engine in seven days. We share security documentation, deployment plans, and a price up front.',
                    'primary_cta'   => ['label' => 'Start the conversation', 'url' => '/contact/'],
                    'secondary_cta' => ['label' => 'Back to overview',       'url' => '/'],
                    'variant'       => 'dark',
                ],
            ];
        }

        // ───────────────────────────────────────────────────────────
        // CONTACT — Contact.js render order:
        // ContactHero → ContactBody (form + offices)
        // ───────────────────────────────────────────────────────────
        private static function page_contact() {
            return [
                // ContactHero (Contact.js)
                [
                    'acf_fc_layout' => 'hero_minimal',
                    'eyebrow'        => '● Contact',
                    'headline_lines' => [
                        ['line' => 'Let’s talk.'],
                        ['line' => 'About your data, your decisions, and what compounds when both are yours.', 'muted' => true],
                    ],
                    'body' => '<p>Tell us a bit about your business. We’ll come back to you within one business day with the right person on our side of the table.</p>',
                ],

                // ContactBody — form + offices side panel
                // FIDELITY EXCEPTION: the export's left column lists offices
                // (San Diego HQ — 1234 Kettner Blvd, Suite 500, San Diego, CA
                // 92101; San Francisco — 600 Montgomery St, 12th Floor, San
                // Francisco, CA 94111) plus hello@igniteiq.com / +1 (619)
                // 555-0114. The `form` layout has no fields for office data,
                // so this content is omitted from the seed and lives in the
                // Contact form template / Site Settings instead.
                [
                    'acf_fc_layout' => 'form',
                    '_settings' => [
                        'section_index' => '01',
                        'section_label' => 'Send us a note',
                        'theme_variant' => 'light',
                    ],
                    'form_type' => 'contact',
                ],
            ];
        }

        // ───────────────────────────────────────────────────────────
        // SIGN IN — SignIn.js
        // ───────────────────────────────────────────────────────────
        private static function page_signin() {
            return [
                [
                    'acf_fc_layout' => 'hero_minimal',
                    'eyebrow'        => '● Customer access',
                    'headline_lines' => [
                        ['line' => 'Welcome back.'],
                        ['line' => 'Your intelligence is waiting.', 'muted' => true],
                    ],
                    'body' => '<p>Sign in to your IgniteIQ workspace to query the ontology, monitor signals, and run agents across your business.</p>',
                ],
                [
                    'acf_fc_layout' => 'form',
                    '_settings' => [
                        'section_index' => '01',
                        'section_label' => 'Sign in',
                        'theme_variant' => 'light',
                    ],
                    'form_type' => 'signin',
                ],
            ];
        }
    }
}

if (defined('WP_CLI') && WP_CLI && class_exists('WP_CLI')) {
    WP_CLI::add_command('igniteiq', 'IgniteIQ_CLI');
}
