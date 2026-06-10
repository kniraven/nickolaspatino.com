<!--
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
-->

<?php
    $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
    $pageLocked = "";

    require_once $projectRoot . '/config/session.php';

    $pageTitle = "Nickolas Patino | 5E Monster Maker Case Study";
    $pageDescription = "Case study for 5E Monster Maker, an interactive TTRPG monster stat block builder with editable fields, monster options, custom actions, CR calculation, theme customization, save/load, and image export.";
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
                                JavaScript • PHP • Bootstrap • TTRPG Tool • HTML2Canvas
                            </p>

                            <h1>5E Monster Maker</h1>

                            <p class="lead">
                                An interactive monster stat block builder for creating, editing, saving, loading, styling, and exporting 5E-compatible TTRPG monsters.
                            </p>

                            <div class="button-group">
                                <a href="/demos/monster-maker/" class="button button-primary" target="_blank" rel="noopener">Live Demo</a>
                                <a href="https://github.com/kniraven/nickolaspatino.com/tree/main/public/demos/monster-maker" class="button button-secondary" target="_blank" rel="noopener">GitHub</a>
                                <a href="/projects/" class="button button-ghost">Back to Projects</a>
                            </div>
                        </div>

                        <aside class="card stack">
                            <h2>Project Summary</h2>

                            <dl>
                                <dt>Type</dt>
                                <dd>Interactive TTRPG web tool</dd>

                                <dt>Role</dt>
                                <dd>Developer</dd>

                                <dt>Technologies</dt>
                                <dd>PHP, JavaScript, HTML, CSS, Bootstrap, JSON, HTML2Canvas</dd>

                                <dt>Core Features</dt>
                                <dd>Editable stat block, monster options, custom features, CR calculation, theme controls, save/load, and image export</dd>
                            </dl>
                        </aside>
                    </div>

                    <div class="media-frame aspect-video">
                        <img
                            src="/assets/images/projects/monstermaker.png"
                            alt="5E Monster Maker project screenshot"
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
                                5E Monster Maker is a browser-based tool for building tabletop monster stat blocks. The user edits the stat block directly, opens modal controls for larger option groups, adjusts monster features, changes the visual theme, and exports the finished monster.
                            </p>
                        </div>

                        <div class="grid">
                            <article class="card stack">
                                <h3>Editable Stat Block</h3>

                                <p>
                                    Monster name, image, description, size, type, alignment, armor class, hit points, speed, abilities, skills, senses, languages, and features can be edited through the interface.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Rules-Oriented Controls</h3>

                                <p>
                                    The tool includes controls for skills, damage types, conditions, senses, traits, actions, bonus actions, reactions, legendary actions, spellcasting, and movement speeds.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Exportable Output</h3>

                                <p>
                                    Finished monsters can be saved, loaded, styled, and downloaded as an image.
                                </p>
                            </article>
                        </div>
                    </article>

                    <aside class="card stack">
                        <h2>Monster Fields</h2>

                        <ul class="feature-list">
                            <li>Name, image, and description</li>
                            <li>Size, type, subtype, and alignment</li>
                            <li>Armor class and hit points</li>
                            <li>Walking, climbing, digging, flying, and swimming speed</li>
                            <li>Strength, Dexterity, Constitution, Intelligence, Wisdom, and Charisma</li>
                            <li>Skills, resistances, immunities, senses, and languages</li>
                            <li>Challenge rating, XP, and proficiency bonus</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="section-header">
                        <h2>Application Features</h2>

                        <p>
                            The project combines a live stat block preview with modular controls for editing monster rules and presentation.
                        </p>
                    </div>

                    <div class="card-grid">
                        <article class="card stack">
                            <h3>Inline Editing</h3>

                            <p>
                                Clickable stat block fields open the relevant input or control set, allowing changes directly from the rendered monster sheet.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Monster Options Modal</h3>

                            <p>
                                Skills, damage resistances, damage immunities, condition immunities, senses, and languages are managed through tabbed modal controls.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Feature Builder</h3>

                            <p>
                                Traits, actions, bonus actions, reactions, legendary actions, and spellcasting options are managed through a dedicated feature interface.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Action Generation</h3>

                            <p>
                                Custom action forms support attacks, melee and ranged ranges, multiattack options, saving throws, areas of effect, damage dice, damage types, and description text.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Challenge Rating</h3>

                            <p>
                                Challenge rating and proficiency bonus update as monster statistics and combat-relevant values change.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Theme Controls</h3>

                            <p>
                                The stat block can be restyled with custom line, background, and text colors, plus texture options such as papyrus, sci-fi, brick, and water.
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
                                The application uses PHP partials for page sections and JavaScript modules for interaction logic. The main page loads the control panel, stat block, option modals, feature modals, speed controls, theme logic, save/load behavior, layout balancing, and screenshot export.
                            </p>
                        </div>

                        <div class="grid">
                            <article class="card stack">
                                <h3>PHP Partials</h3>

                                <p>
                                    The interface is split into reusable PHP sections for monster controls, the stat block, base stat inputs, monster options, monster features, speed controls, and small-screen handling.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>JavaScript Modules</h3>

                                <p>
                                    JavaScript modules initialize editable fields, modal interactions, feature builders, CR updates, save/load behavior, screenshot export, and layout rebalancing.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Scoped Styling</h3>

                                <p>
                                    The tool uses a scoped Bootstrap build and custom Monster Maker CSS so the demo styling can coexist with the surrounding website.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="card stack">
                        <h2>Representative Files</h2>

                        <ul class="feature-list">
                            <li><code>index.php</code></li>
                            <li><code>monsterModule.js</code></li>
                            <li><code>themes.js</code></li>
                            <li><code>php/statblock.php</code></li>
                            <li><code>php/monstercontrols.php</code></li>
                            <li><code>php/monsteroptions.php</code></li>
                            <li><code>php/monsterfeatures.php</code></li>
                            <li><code>js/calculateCR.js</code></li>
                            <li><code>js/actions.js</code></li>
                            <li><code>js/saveAndLoad.js</code></li>
                            <li><code>js/saveImage.js</code></li>
                            <li><code>js/verticalRebalance.js</code></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="section-header">
                        <h2>Monster Creation Workflow</h2>

                        <p>
                            The tool is built around editing a visible stat block instead of filling out one long static form.
                        </p>
                    </div>

                    <div class="grid">
                        <article class="card stack">
                            <h3>1. Edit Core Stats</h3>

                            <p>
                                The user starts from a default monster and edits identity, description, defensive stats, movement, ability scores, and basic rules text.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>2. Configure Options</h3>

                            <p>
                                Skills, damage handling, condition immunities, senses, and languages are selected through modal controls.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>3. Add Features</h3>

                            <p>
                                Traits, attacks, bonus actions, reactions, legendary actions, and spellcasting can be added or adjusted.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>4. Style the Sheet</h3>

                            <p>
                                Theme controls allow the user to change colors and textures before saving or exporting the finished stat block.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>5. Save or Load</h3>

                            <p>
                                The stat block can be saved to a text file and loaded back into the tool later.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>6. Export Image</h3>

                            <p>
                                The printable area can be captured and downloaded as a PNG image.
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
                            <h2>Design Notes</h2>

                            <p>
                                The project is desktop-focused because the stat block, controls, modals, and export area need enough horizontal space to remain usable. Smaller screens receive a message instead of a compressed version of the full interface.
                            </p>
                        </div>

                        <div class="grid">
                            <article class="card stack">
                                <h3>Live Preview</h3>

                                <p>
                                    The stat block remains visible while the user changes monster values, making the tool feel closer to editing a finished sheet than filling out a disconnected form.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Modal Organization</h3>

                                <p>
                                    Complex option groups are separated into modal panels so the main screen can stay focused on the monster sheet and primary controls.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Layout Rebalancing</h3>

                                <p>
                                    Feature distribution and resize handling help keep the stat block layout balanced as content grows.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="card stack">
                        <h2>Asset Support</h2>

                        <ul class="feature-list">
                            <li>Default mimic artwork</li>
                            <li>Papyrus texture</li>
                            <li>Sci-fi texture</li>
                            <li>Brick texture</li>
                            <li>Water texture</li>
                            <li>Paper texture</li>
                            <li>Preset trait data</li>
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
                        <a href="/demos/monster-maker/" class="button button-primary" target="_blank" rel="noopener">Live Demo</a>
                        <a href="https://github.com/kniraven/nickolaspatino.com/tree/main/public/demos/monster-maker" class="button button-secondary" target="_blank" rel="noopener">GitHub</a>
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
