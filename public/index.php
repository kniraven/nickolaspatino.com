
<!--
    Author: Nickolas Patino
    Created: 04/09/2019
    Updated: 06/09/2026
-->

<?php
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
    <header class="site-header">
        <div class="container site-header-inner">
            <?php require_once $projectRoot . '/src/nav.php'; ?>
        </div>
    </header>

    <main>
        <!-- Above the Fold / Hero -->
        <section class="hero">
            <div class="container">
                <div class="split split-main">
                    <div class="stack stack-loose">
                        <div class="stack">
                            <p class="small-text text-primary">
                                Websites • Automation • Small Business Tech • Practical Digital Tools
                            </p>

                            <h1>Web developer and automation-focused problem solver.</h1>

                            <p class="lead">
                                I build clean websites, useful tools, and practical digital systems for small businesses, local organizations, and teams that need reliable technical help.
                            </p>

                            <p>
                                My background combines web development, business operations, reporting, documentation, Excel/VBA automation, and process improvement. I care about making technology useful, organized, and easier to work with.
                            </p>
                        </div>

                        <div class="button-group">
                            <a href="/services.php" class="button button-primary">Hire Me for Services</a>
                            <a href="/projects/" class="button button-secondary">View My Work</a>
                            <a href="/resume.php" class="button button-ghost">Resume for Employers</a>
                        </div>
                    </div>

                    <aside class="card stack stack-tight">
                        <div class="media-frame aspect-square">
                            <img
                                src="/assets/images/portrait.png"
                                alt="Nickolas Patino"
                            >
                        </div>

                        <div class="text-block">
                            <h2>Nickolas Patino</h2>

                            <p>
                                Based near Madison, Wisconsin. Available for web development roles, freelance website work, automation projects, and practical small business tech help.
                            </p>
                        </div>

                        <div class="button-group">
                            <a href="/contact.php" class="button button-primary">Contact Me</a>
                            <a href="mailto:nickolas@kniraven.com" class="button button-secondary">Email Directly</a>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <!-- Audience Paths -->
        <section>
            <div class="container">
                <div class="grid">
                    <article class="card stack">
                        <h2>For Employers</h2>

                        <p>
                            I am looking for web development work where I can contribute to websites, internal tools, documentation, automation, and business-facing technical projects.
                        </p>

                        <p>
                            I am strongest where development meets real operations: forms, data, reporting, workflow cleanup, user-facing pages, and practical systems people actually need to use.
                        </p>

                        <div class="card-actions">
                            <a href="/resume.php" class="button button-primary">View Resume</a>
                            <a href="/projects/" class="button button-secondary">View Projects</a>
                        </div>
                    </article>

                    <article class="card stack">
                        <h2>For Small Businesses</h2>

                        <p>
                            I help small businesses, solo LLCs, creators, and local organizations with practical web and technology projects.
                        </p>

                        <p>
                            That can include websites, website refreshes, forms, content cleanup, Excel automation, reporting templates, workflow cleanup, and lightweight internal tools.
                        </p>

                        <div class="card-actions">
                            <a href="/services.php" class="button button-primary">View Services</a>
                            <a href="/contact.php" class="button button-secondary">Start a Conversation</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- What I Do -->
        <section>
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="section-header">
                        <h2>What I Do</h2>

                        <p>
                            I focus on practical technology work that helps people look more professional, reduce manual effort, and make better use of their digital systems.
                        </p>
                    </div>

                    <div class="card-grid">
                        <article class="card stack">
                            <h3>Web Development</h3>

                            <p>
                                Responsive websites, landing pages, portfolio sites, business pages, forms, and frontend improvements using HTML, CSS, JavaScript, PHP, and SQL.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Automation &amp; Workflows</h3>

                            <p>
                                Excel/VBA automation, reporting templates, data cleanup, workflow documentation, and practical process improvement for repetitive business tasks.
                            </p>
                        </article>

                        <article class="card stack">
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
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="cluster">
                        <div class="section-header">
                            <h2>Featured Projects</h2>

                            <p>
                                These projects show my experience with business-style web applications, interactive tools, game-related systems, and frontend/backend development.
                            </p>
                        </div>

                        <a href="/projects/" class="button button-secondary">View All Projects</a>
                    </div>

                    <div class="card-grid">
                        <article class="card stack">
                            <div class="card-media aspect-video">
                                <img
                                    src="/assets/images/projects/employeemanager.png"
                                    alt="Employee Manager project screenshot"
                                >
                            </div>

                            <div class="stack">
                                <h3>Employee Manager</h3>

                                <p>
                                    A PHP/MySQL CRUD application for managing employee records through a practical administrative interface.
                                </p>

                                <p class="small-text text-muted">
                                    PHP • MySQL • CRUD • Forms • Business App
                                </p>
                            </div>

                            <div class="card-actions">
                                <a href="/projects/employee-manager/" class="button button-primary">Case Study</a>
                                <a href="/demos/employee-manager/" class="button button-secondary">Live Demo</a>
                            </div>
                        </article>

                        <article class="card stack">
                            <div class="card-media aspect-video">
                                <img
                                    src="/assets/images/projects/monstermaker.png"
                                    alt="Monster Maker project screenshot"
                                >
                            </div>

                            <div class="stack">
                                <h3>5E Monster Maker</h3>

                                <p>
                                    An interactive TTRPG monster creation tool with dynamic stat blocks, rules-based calculations, and image export.
                                </p>

                                <p class="small-text text-muted">
                                    JavaScript • UI Logic • TTRPG Tool • HTML2Canvas
                                </p>
                            </div>

                            <div class="card-actions">
                                <a href="/projects/monster-maker/" class="button button-primary">Case Study</a>
                                <a href="/demos/monster-maker/" class="button button-secondary">Live Demo</a>
                            </div>
                        </article>

                        <article class="card stack">
                            <div class="card-media aspect-video">
                                <img
                                    src="/assets/images/projects/goblinslayer.png"
                                    alt="Goblin Slayer browser game screenshot"
                                >
                            </div>

                            <div class="stack">
                                <h3>Goblin Slayer Game</h3>

                                <p>
                                    A browser-based JavaScript game prototype with responsive controls, sprite movement, animation, and wave-based enemy behavior.
                                </p>

                                <p class="small-text text-muted">
                                    JavaScript • Browser Game • DOM • Animation
                                </p>
                            </div>

                            <div class="card-actions">
                                <a href="/projects/goblin-slayer/" class="button button-primary">Case Study</a>
                                <a href="/demos/goblin-slayer/" class="button button-secondary">Live Demo</a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- Professional Edge -->
        <section>
            <div class="container">
                <div class="card">
                    <div class="split split-sidebar">
                        <div class="stack">
                            <h2>Business experience behind the code</h2>

                            <p>
                                A lot of technology problems are really workflow problems, communication problems, data problems, or process problems. My background helps me think beyond the screen and understand how a tool will actually be used.
                            </p>

                            <p>
                                I bring experience in business process improvement, reporting, documentation, automation, and practical operations support into the way I build websites and tools.
                            </p>
                        </div>

                        <div class="stack">
                            <a href="/resume.php" class="button button-primary full-width">Review My Background</a>
                            <a href="/services.php" class="button button-secondary full-width">See How I Can Help</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education -->
        <section>
            <div class="container">
                <div class="split split-media">
                    <div class="media-frame graphic-plate">
                        <img
                            src="/assets/images/madisoncollege300x200.png"
                            alt="Madison Area Technical College logo"
                        >
                    </div>

                    <div class="stack">
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
            <div class="container">
                <article class="card stack">
                    <div class="text-block">
                        <h2>Need a website, a developer, or practical tech help?</h2>

                        <p>
                            I am available for web development opportunities, small business website work, automation projects, and practical technology support.
                        </p>

                        <p>
                            <strong>Email:</strong>
                            <a href="mailto:nickolas@kniraven.com">nickolas@kniraven.com</a>
                        </p>
                    </div>

                    <div class="button-group">
                        <a href="/contact.php" class="button button-primary">Contact Me</a>
                        <a href="mailto:nickolas@kniraven.com" class="button button-secondary">Email Directly</a>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container site-footer-inner">
            <?php require_once $projectRoot . '/src/footer.php'; ?>
        </div>
    </footer>
</body>
</html>
