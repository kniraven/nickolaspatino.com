<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 04/09/2019
    Updated: 06/12/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';

$pageTitle = "Nickolas Patino | Web Developer & Automation-Focused Problem Solver";
$pageDescription = "Nickolas Patino builds websites, tools, workflows, and practical digital systems for small businesses, local organizations, and teams.";
$pageCss = "home";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $projectRoot . '/src/head.php'; ?>
</head>

<body>
    <header class="kn-site-header">
        <div class="kn-container kn-site-header-inner">
            <?php require_once $projectRoot . '/src/nav.php'; ?>
        </div>
    </header>

    <main>
        <!-- Above the Fold / Hero -->
        <section class="kn-hero">
            <div class="kn-container">
                <div class="kn-split kn-split-main">
                    <div class="kn-stack kn-stack-loose">
                        <div class="kn-stack">
                            <p class="kn-small-text kn-text-primary">
                                Websites • Automation • Small Business Tech • Practical Digital Tools
                            </p>

                            <h1>Web developer and automation-focused problem solver.</h1>

                            <p class="kn-lead">
                                I build clean websites, useful tools, and practical digital systems for small businesses, local organizations, and teams that need reliable technical help.
                            </p>

                            <p>
                                My background combines web development, business operations, reporting, documentation, Excel/VBA automation, and process improvement. I care about making technology useful, organized, and easier to work with.
                            </p>
                        </div>

                        <div class="kn-button-group">
                            <a href="/services.php" class="kn-button kn-button-primary">Hire Me for Services</a>
                            <a href="/projects/" class="kn-button kn-button-secondary">View My Work</a>
                            <a href="/resume.php" class="kn-button kn-button-ghost">Resume for Employers</a>
                        </div>
                    </div>

                    <aside class="kn-card kn-stack kn-stack-tight">
                        <div class="kn-media-frame kn-aspect-square">
                            <img
                                src="/assets/images/portrait.png"
                                alt="Nickolas Patino"
                            >
                        </div>

                        <div class="kn-text-block">
                            <h2>Nickolas Patino</h2>

                            <p>
                                Based near Madison, Wisconsin. Available for web development roles, freelance website work, automation projects, and practical small business tech help.
                            </p>
                        </div>

                        <div class="kn-button-group">
                            <a href="/contact.php#contact-form" class="kn-button kn-button-primary">Send a Message</a>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <!-- Audience Paths -->
        <section>
            <div class="kn-container">
                <div class="kn-grid">
                    <article class="kn-card kn-stack">
                        <h2>For Employers</h2>

                        <p>
                            I am looking for web development work where I can contribute to websites, internal tools, documentation, automation, and business-facing technical projects.
                        </p>

                        <p>
                            I am strongest where development meets real operations: forms, data, reporting, workflow cleanup, user-facing pages, and practical systems people actually need to use.
                        </p>

                        <div class="kn-card-actions">
                            <a href="/resume.php" class="kn-button kn-button-primary">View Resume</a>
                            <a href="/projects/" class="kn-button kn-button-secondary">View Projects</a>
                        </div>
                    </article>

                    <article class="kn-card kn-stack">
                        <h2>For Small Businesses</h2>

                        <p>
                            I help small businesses, solo LLCs, creators, and local organizations with practical web and technology projects.
                        </p>

                        <p>
                            That can include websites, website refreshes, forms, content cleanup, Excel automation, reporting templates, workflow cleanup, and lightweight internal tools.
                        </p>

                        <div class="kn-card-actions">
                            <a href="/services.php" class="kn-button kn-button-primary">View Services</a>
                            <a href="/contact.php#contact-form" class="kn-button kn-button-secondary">Start a Conversation</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- What I Do -->
        <section>
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-section-header">
                        <h2>What I Do</h2>

                        <p>
                            I focus on practical technology work that helps people look more professional, reduce manual effort, and make better use of their digital systems.
                        </p>
                    </div>

                    <div class="kn-card-grid">
                        <article class="kn-card kn-stack">
                            <h3>Web Development</h3>

                            <p>
                                Responsive websites, landing pages, portfolio sites, business pages, forms, and frontend improvements using HTML, CSS, JavaScript, PHP, and SQL.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Automation &amp; Workflows</h3>

                            <p>
                                Excel/VBA automation, reporting templates, data cleanup, workflow documentation, and practical process improvement for repetitive business tasks.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Small Business Tech Help</h3>

                            <p>
                                Website updates, content organization, contact forms, basic SEO structure, troubleshooting, maintenance, and lightweight internal tools.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Projects -->
        <section id="featured-projects">
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-cluster">
                        <div class="kn-section-header">
                            <h2>Featured Projects</h2>

                            <p>
                                These projects show production website work, business-focused web applications, payment/account functionality, and interactive frontend development.
                            </p>
                        </div>

                        <a href="/projects/" class="kn-button kn-button-secondary">View All Projects</a>
                    </div>

                    <div class="kn-card-grid">
                        <article class="kn-card kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/kniraven.png"
                                    alt="Kniraven.com website screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h3>Kniraven.com</h3>

                                <p>
                                    A production brand, store, account, and community platform for Kniraven LLC with user login, sessions, OAuth, custom CAPTCHA, Stripe payments, support pages, and dev log publishing.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    PHP • MySQL • Stripe API • OAuth • Sessions • AWS EC2
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <a href="/projects/kniraven/" class="kn-button kn-button-primary">Case Study</a>
                                <a href="https://kniraven.com" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Live Site</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/kails-landscaping.jpg"
                                    alt="Kail’s Landscaping website screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h3>Kail’s Landscaping</h3>

                                <p>
                                    A local business website and quote management system with customer intake, request follow-up, admin CRM screens, editable content, image uploads, and document tools.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    PHP • MySQL • Admin CRM • Quote Requests • Content Editor
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <a href="/projects/kails-landscaping/" class="kn-button kn-button-primary">Case Study</a>
                                <a href="https://kailslandscaping.com" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Live Site</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/monstermaker.png"
                                    alt="Monster Maker project screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h3>5E Monster Maker</h3>

                                <p>
                                    An interactive TTRPG monster creation tool with dynamic stat blocks, rules-based calculations, visual theme controls, and image export.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    JavaScript • UI Logic • TTRPG Tool • HTML2Canvas
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <a href="/projects/monster-maker/" class="kn-button kn-button-primary">Case Study</a>
                                <a href="/demos/monster-maker/" class="kn-button kn-button-secondary">Live Demo</a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- Professional Edge -->
        <section>
            <div class="kn-container">
                <div class="kn-card">
                    <div class="kn-split kn-split-sidebar">
                        <div class="kn-stack">
                            <h2>Business experience behind the code</h2>

                            <p>
                                A lot of technology problems are really workflow problems, communication problems, data problems, or process problems. My background helps me think beyond the screen and understand how a tool will actually be used.
                            </p>

                            <p>
                                I bring experience in business process improvement, reporting, documentation, automation, and practical operations support into the way I build websites and tools.
                            </p>
                        </div>

                        <div class="kn-stack">
                            <a href="/resume.php" class="kn-button kn-button-primary kn-full-width">Review My Background</a>
                            <a href="/services.php" class="kn-button kn-button-secondary kn-full-width">See How I Can Help</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education -->
        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-media">
                    <div class="kn-media-frame kn-graphic-plate">
                        <img
                            src="/assets/images/madisoncollege300x200.png"
                            alt="Madison Area Technical College logo"
                        >
                    </div>

                    <div class="kn-stack">
                        <h2>Education</h2>

                        <p>
                            <strong>Associate's Degree in IT: Web Application Development</strong><br>
                            Madison Area Technical College<br>
                            <strong>GPA:</strong> 4.0
                        </p>

                        <p>
                            Coursework included web development, database management, UX/UI design, accessibility, and practical software development fundamentals.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact CTA -->
        <section>
            <div class="kn-container">
                <article class="kn-card kn-stack">
                    <div class="kn-text-block">
                        <h2>Need a website, a developer, or practical tech help?</h2>

                        <p>
                            I am available for web development opportunities, small business website work, automation projects, and practical technology support. Use the contact form to send details about what you need.
                        </p>
                    </div>

                    <div class="kn-button-group">
                        <a href="/contact.php#contact-form" class="kn-button kn-button-primary">Send a Message</a>
                        <a href="/services.php" class="kn-button kn-button-secondary">View Services</a>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <footer class="kn-site-footer">
        <div class="kn-container kn-site-footer-inner">
            <?php require_once $projectRoot . '/src/footer.php'; ?>
        </div>
    </footer>
</body>
</html>