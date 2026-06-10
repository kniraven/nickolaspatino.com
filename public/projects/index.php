
<!--
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
-->

<?php
    $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
    $pageLocked = "";

    require_once $projectRoot . '/config/session.php';

    $pageTitle = "Nickolas Patino | Projects";
    $pageDescription = "Projects by Nickolas Patino, including PHP/MySQL web applications, JavaScript tools, browser games, and interactive web development work.";
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
        <section class="hero">
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="page-hero-content">
                        <p class="small-text text-primary">
                            Web Applications • JavaScript Tools • Browser Games
                        </p>

                        <h1>Selected projects.</h1>

                        <p class="lead">
                            Web applications, interactive tools, and browser-based projects built with HTML, CSS, JavaScript, PHP, and SQL.
                        </p>
                    </div>

                    <div class="grid">
                        <article class="card card-equal stack">
                            <div class="card-media aspect-video">
                                <img
                                    src="/assets/images/projects/employeemanager.png"
                                    alt="Employee Manager project screenshot"
                                >
                            </div>

                            <div class="stack">
                                <h2>Employee Manager</h2>

                                <p>
                                    A PHP/MySQL CRUD application for managing employee records through an administrative interface.
                                </p>

                                <p class="small-text text-muted">
                                    PHP • MySQL • CRUD • Forms
                                </p>
                            </div>

                            <div class="card-actions">
                                <div class="stack stack-tight full-width">
                                    <div class="button-group justify-center">
                                        <a href="/projects/employee-manager/" class="button button-primary">Case Study</a>
                                        <a href="/demos/employee-manager/" class="button button-secondary" target="_blank" rel="noopener">Live Demo</a>
                                    </div>

                                    <div class="button-group justify-center">
                                        <a href="https://github.com/kniraven/employee-manager" class="button button-ghost" target="_blank" rel="noopener">GitHub</a>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="card card-equal stack">
                            <div class="card-media aspect-video">
                                <img
                                    src="/assets/images/projects/monstermaker.png"
                                    alt="5E Monster Maker project screenshot"
                                >
                            </div>

                            <div class="stack">
                                <h2>5E Monster Maker</h2>

                                <p>
                                    An interactive TTRPG monster creation tool with dynamic stat blocks, calculations, theme options, and image export.
                                </p>

                                <p class="small-text text-muted">
                                    JavaScript • PHP • Bootstrap • HTML2Canvas
                                </p>
                            </div>

                            <div class="card-actions">
                                <div class="stack stack-tight full-width">
                                    <div class="button-group justify-center">
                                        <a href="/projects/monster-maker/" class="button button-primary">Case Study</a>
                                        <a href="/demos/monster-maker/" class="button button-secondary" target="_blank" rel="noopener">Live Demo</a>
                                    </div>

                                    <div class="button-group justify-center">
                                        <a href="https://github.com/kniraven/monster-maker" class="button button-ghost" target="_blank" rel="noopener">GitHub</a>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="card card-equal stack">
                            <div class="card-media aspect-video">
                                <img
                                    src="/assets/images/projects/goblinslayer.png"
                                    alt="Goblin Slayer browser game screenshot"
                                >
                            </div>

                            <div class="stack">
                                <h2>Goblin Slayer Game</h2>

                                <p>
                                    A browser-based JavaScript game prototype with responsive controls, sprite movement, animation, and enemy waves.
                                </p>

                                <p class="small-text text-muted">
                                    JavaScript • HTML • CSS • Browser Game
                                </p>
                            </div>

                            <div class="card-actions">
                                <div class="stack stack-tight full-width">
                                    <div class="button-group justify-center">
                                        <a href="/projects/goblin-slayer/" class="button button-primary">Case Study</a>
                                        <a href="/demos/goblin-slayer/" class="button button-secondary" target="_blank" rel="noopener">Live Demo</a>
                                    </div>

                                    <div class="button-group justify-center">
                                        <a href="https://github.com/kniraven/goblin-slayer" class="button button-ghost" target="_blank" rel="noopener">GitHub</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <article class="card stack">
                    <div class="text-block">
                        <h2>Have a role or project in mind?</h2>

                        <p>
                            Send a message about web development work, a website update, automation help, or a technical project.
                        </p>
                    </div>

                    <div class="button-group">
                        <a href="/contact.php" class="button button-primary">Contact Me</a>
                        <a href="/services.php" class="button button-secondary">View Services</a>
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

