<!--
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
-->

<?php
    $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
    $pageLocked = "";

    require_once $projectRoot . '/config/session.php';

    $pageTitle = "Nickolas Patino | Goblin Slayer Game Case Study";
    $pageDescription = "Case study for Goblin Slayer Game, a browser-based JavaScript game prototype using HTML, CSS, JavaScript, sprite sheets, difficulty settings, enemy spawning, collision scoring, and responsive browser controls.";
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
                    <div class="split split-sidebar align-start">
                        <div class="page-hero-content">
                            <p class="small-text text-primary">
                                JavaScript • HTML • CSS • Browser Game
                            </p>

                            <h1>Goblin Slayer Game</h1>

                            <p class="lead">
                                A browser-based JavaScript game prototype where the player moves across the bottom of the screen to stop falling goblins.
                            </p>

                            <div class="button-group">
                                <a href="/demos/goblin-slayer/" class="button button-primary" target="_blank" rel="noopener">Live Demo</a>
                                <a href="https://github.com/kniraven/goblin-slayer" class="button button-secondary" target="_blank" rel="noopener">GitHub</a>
                                <a href="/projects/" class="button button-ghost">Back to Projects</a>
                            </div>
                        </div>

                        <aside class="card stack">
                            <h2>Project Summary</h2>

                            <dl>
                                <dt>Type</dt>
                                <dd>Browser game prototype</dd>

                                <dt>Role</dt>
                                <dd>Developer</dd>

                                <dt>Technologies</dt>
                                <dd>HTML, CSS, JavaScript</dd>

                                <dt>Core Features</dt>
                                <dd>Difficulty selection, score tracking, sprite animation, enemy spawning, pause/resume, and responsive controls</dd>
                            </dl>
                        </aside>
                    </div>

                    <div class="media-frame aspect-video">
                        <img
                            src="/assets/images/projects/goblinslayer.png"
                            alt="Goblin Slayer browser game screenshot"
                        >
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="split split-sidebar align-start">
                    <article class="stack">
                        <div class="section-header">
                            <h2>Overview</h2>

                            <p>
                                Goblin Slayer Game is a compact browser game built with standard web files instead of a dedicated game engine. The demo includes a score display, difficulty selector, start button, pause button, animated player sprite, animated enemy sprites, and a scrolling dirt background.
                            </p>
                        </div>

                        <div class="grid">
                            <article class="card stack">
                                <h3>Game Objective</h3>

                                <p>
                                    Goblins fall from the top of the play area. The player moves left or right to intercept them before they pass through.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Difficulty Settings</h3>

                                <p>
                                    Easy, medium, and hard modes adjust enemy speed and the maximum number of active enemies.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Score Tracking</h3>

                                <p>
                                    The score increases when an enemy reaches the player collision area and is reset back into play.
                                </p>
                            </article>
                        </div>
                    </article>

                    <aside class="card stack">
                        <h2>Demo Files</h2>

                        <ul class="feature-list">
                            <li><code>index.html</code></li>
                            <li><code>css/styles.css</code></li>
                            <li><code>js/game.js</code></li>
                            <li><code>images/dirt.png</code></li>
                            <li><code>images/Human-Soldier-Red.png</code></li>
                            <li><code>images/Orc-Peon-Cyan.png</code></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="section-header">
                        <h2>Gameplay Features</h2>

                        <p>
                            The prototype focuses on the core pieces needed for a playable browser action game.
                        </p>
                    </div>

                    <div class="card-grid">
                        <article class="card stack">
                            <h3>Player Movement</h3>

                            <p>
                                The player can move left and right using keyboard input, mouse input, or touch input.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Enemy Spawning</h3>

                            <p>
                                Enemy sprites spawn from the top of the play area at timed intervals until the active enemy limit is reached.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Sprite Animation</h3>

                            <p>
                                Player and enemy animation frames are pulled from sprite sheets using JavaScript-controlled background positioning.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Collision Scoring</h3>

                            <p>
                                Enemy position is checked against the player position. Successful contact increases the score and resets the enemy.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Pause and Resume</h3>

                            <p>
                                The pause button stops enemy spawning, movement, animation, and background scrolling until the game resumes.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Scrolling Background</h3>

                            <p>
                                The tiled dirt background scrolls during play to create a sense of motion.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="split split-sidebar align-start">
                    <div class="stack">
                        <div class="section-header">
                            <h2>Technical Implementation</h2>

                            <p>
                                The project uses a simple static page structure with separate CSS and JavaScript files. The game area is a square responsive container, with the player and enemies positioned absolutely inside it.
                            </p>
                        </div>

                        <div class="grid">
                            <article class="card stack">
                                <h3>HTML</h3>

                                <p>
                                    The page defines the game container, score display, difficulty selector, start and pause controls, game area, and player element.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>CSS</h3>

                                <p>
                                    CSS handles the page layout, responsive game area, tiled dirt background, and sprite sheet sizing for the player and enemy elements.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>JavaScript</h3>

                                <p>
                                    JavaScript manages game state, input handling, difficulty settings, enemy spawning, sprite animation, collision checks, score updates, pause behavior, and background scrolling.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="card stack">
                        <h2>Controls</h2>

                        <ul class="feature-list">
                            <li><strong>Keyboard:</strong> Arrow keys or A/D</li>
                            <li><strong>Mouse:</strong> Hold and move left or right side of the game area</li>
                            <li><strong>Touch:</strong> Tap/press left or right side of the game area</li>
                            <li><strong>Start:</strong> Begins a new game with the selected difficulty</li>
                            <li><strong>Pause:</strong> Toggles pause and resume</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="split split-sidebar align-start">
                    <div class="section-header">
                        <h2>Project Scope</h2>

                        <p>
                            This is a playable prototype rather than a full production game. The scope is focused on browser-based movement, simple enemy behavior, sprite animation, difficulty settings, and a working score loop.
                        </p>
                    </div>

                    <aside class="card stack">
                        <h3>Possible Next Steps</h3>

                        <ul class="feature-list">
                            <li>Game over state</li>
                            <li>Health or lives system</li>
                            <li>Sound effects</li>
                            <li>Start screen and instructions panel</li>
                            <li>Improved mobile interface</li>
                            <li>Additional enemy types or obstacles</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <article class="card stack">
                    <div class="text-block">
                        <h2>View the project.</h2>

                        <p>
                            Open the live demo, review the source code, or return to the project list.
                        </p>
                    </div>

                    <div class="button-group">
                        <a href="/demos/goblin-slayer/" class="button button-primary" target="_blank" rel="noopener">Live Demo</a>
                        <a href="https://github.com/kniraven/goblin-slayer" class="button button-secondary" target="_blank" rel="noopener">GitHub</a>
                        <a href="/projects/" class="button button-ghost">Back to Projects</a>
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
