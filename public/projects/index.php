<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/12/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';

$pageTitle = "Nickolas Patino | Projects";
$pageDescription = "Projects by Nickolas Patino, including Kniraven.com, local business websites, PHP/MySQL web applications, admin tools, quote workflows, JavaScript tools, browser games, and interactive web development work.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $projectRoot . '/src/head.php'; ?>

    <style>
        @layer kn.structure {
            .kn-projects-grid {
                grid-template-columns: 1fr;
            }

            @media (min-width: 42rem) {
                .kn-projects-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
        }
    </style>
</head>

<body>
    <header class="kn-site-header">
        <div class="kn-container kn-site-header-inner">
            <?php require_once $projectRoot . '/src/nav.php'; ?>
        </div>
    </header>

    <main>
        <section class="kn-hero">
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-page-hero-content">
                        <p class="kn-small-text kn-text-primary">
                            Business Websites • PHP/MySQL Apps • Admin Tools • JavaScript Tools • Browser Games
                        </p>

                        <h1>Selected projects.</h1>

                        <p class="kn-lead">
                            Websites, business tools, interactive applications, and game-related projects built with HTML, CSS, JavaScript, PHP, and SQL.
                        </p>
                    </div>

                    <div class="kn-grid kn-projects-grid">
                        <article class="kn-card kn-card-equal kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/kniraven.png"
                                    alt="Kniraven.com website screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h2>Kniraven.com</h2>

                                <p>
                                    A production website for Kniraven LLC with account flows, session management, OAuth login, custom CAPTCHA, Stripe API payments, store pages, dev log publishing, support pages, and responsive accessible layouts.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    PHP • MySQL • Stripe API • OAuth • Sessions • Custom CAPTCHA • AWS EC2
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <div class="kn-stack kn-stack-tight kn-full-width">
                                    <div class="kn-button-group kn-justify-center">
                                        <a href="/projects/kniraven/" class="kn-button kn-button-primary">Case Study</a>
                                        <a href="https://kniraven.com" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Live Site</a>
                                    </div>

                                    <p class="kn-small-text kn-text-muted kn-text-center">
                                        Source code is private because this is a live business website with account, payment, and original IP features.
                                    </p>
                                </div>
                            </div>
                        </article>

                        <article class="kn-card kn-card-equal kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/kails-landscaping.jpg"
                                    alt="Kail’s Landscaping website screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h2>Kail’s Landscaping</h2>

                                <p>
                                    A local business website with quote request intake, customer follow-up links, admin CRM screens, editable service cards, image uploads, and document tools.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    PHP • MySQL • Admin CRM • Quote Requests • Content Editor
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <div class="kn-stack kn-stack-tight kn-full-width">
                                    <div class="kn-button-group kn-justify-center">
                                        <a href="/projects/kails-landscaping/" class="kn-button kn-button-primary">Case Study</a>
                                        <a href="https://kailslandscaping.com" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Live Site</a>
                                    </div>

                                    <div class="kn-button-group kn-justify-center">
                                        <a href="https://github.com/kniraven-llc/kailslandscaping.com" class="kn-button kn-button-ghost" target="_blank" rel="noopener">GitHub</a>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="kn-card kn-card-equal kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/employeemanager.png"
                                    alt="Employee Manager project screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h2>Employee Manager</h2>

                                <p>
                                    A database-backed CRUD application for maintaining employee records, manager relationships, searchable lists, sortable columns, and responsive admin views.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    PHP • MySQL • CRUD • Forms
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <div class="kn-stack kn-stack-tight kn-full-width">
                                    <div class="kn-button-group kn-justify-center">
                                        <a href="/projects/employee-manager/" class="kn-button kn-button-primary">Case Study</a>
                                        <a href="/demos/employee-manager/" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Live Demo</a>
                                    </div>

                                    <div class="kn-button-group kn-justify-center">
                                        <a href="https://github.com/kniraven/nickolaspatino.com/tree/main/public/demos/employee-manager" class="kn-button kn-button-ghost" target="_blank" rel="noopener">GitHub</a>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="kn-card kn-card-equal kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/monstermaker.png"
                                    alt="5E Monster Maker project screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h2>5E Monster Maker</h2>

                                <p>
                                    An interactive TTRPG creation tool for building 5E monster stat blocks with dynamic calculations, feature controls, visual themes, and image export.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    JavaScript • PHP • Bootstrap • HTML2Canvas
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <div class="kn-stack kn-stack-tight kn-full-width">
                                    <div class="kn-button-group kn-justify-center">
                                        <a href="/projects/monster-maker/" class="kn-button kn-button-primary">Case Study</a>
                                        <a href="/demos/monster-maker/" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Live Demo</a>
                                    </div>

                                    <div class="kn-button-group kn-justify-center">
                                        <a href="https://github.com/kniraven/nickolaspatino.com/tree/main/public/demos/monster-maker" class="kn-button kn-button-ghost" target="_blank" rel="noopener">GitHub</a>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="kn-card kn-card-equal kn-stack">
                            <div class="kn-card-media kn-aspect-video">
                                <img
                                    src="/assets/images/projects/goblinslayer.png"
                                    alt="Goblin Slayer browser game screenshot"
                                >
                            </div>

                            <div class="kn-stack">
                                <h2>Goblin Slayer Game</h2>

                                <p>
                                    A browser-based JavaScript game prototype with keyboard and touch controls, sprite movement, animation states, collision logic, and wave-based enemies.
                                </p>

                                <p class="kn-small-text kn-text-muted">
                                    JavaScript • HTML • CSS • Browser Game
                                </p>
                            </div>

                            <div class="kn-card-actions">
                                <div class="kn-stack kn-stack-tight kn-full-width">
                                    <div class="kn-button-group kn-justify-center">
                                        <a href="/projects/goblin-slayer/" class="kn-button kn-button-primary">Case Study</a>
                                        <a href="/demos/goblin-slayer/" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Live Demo</a>
                                    </div>

                                    <div class="kn-button-group kn-justify-center">
                                        <a href="https://github.com/kniraven/nickolaspatino.com/tree/main/public/demos/goblin-slayer" class="kn-button kn-button-ghost" target="_blank" rel="noopener">GitHub</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <article class="kn-card kn-stack">
                    <div class="kn-text-block">
                        <h2>Have a role or project in mind?</h2>

                        <p>
                            Send a message about employment opportunities, local business websites, admin tools, quote workflows, Excel/VBA automation, reporting, game content, livestreaming, or video editing.
                        </p>
                    </div>

                    <div class="kn-button-group">
                        <a href="/contact.php" class="kn-button kn-button-primary">Contact Me</a>
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