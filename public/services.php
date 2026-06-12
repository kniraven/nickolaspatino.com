<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';

$pageTitle = "Nickolas Patino | Services";
$pageDescription = "Local business websites, artist pages, portfolios, personal brands, game design content, event livestreaming, video editing, Excel/VBA automation, and recurring report reconciliation services from Nickolas Patino.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $projectRoot . '/src/head.php'; ?>

    <style>
        @layer kn.structure {
            .kn-services-grid {
                grid-template-columns: 1fr;
            }

            @media (min-width: 42rem) {
                .kn-services-grid {
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
        <!-- Services Hero / Offerings -->
        <section class="kn-hero">
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-page-hero-content">
                        <p class="kn-small-text kn-text-primary">
                            Local Websites • Game Content • Event Streaming • Video Editing • Excel/VBA • Reporting
                        </p>

                        <h1>Practical services for websites, content, events, and recurring work.</h1>

                        <p class="kn-lead">
                            I help local businesses, artists, creators, game designers, streamers, and teams turn rough ideas, unfinished work, scattered files, footage, spreadsheets, and reports into finished systems people can use.
                        </p>

                        <div class="kn-button-group">
                            <a href="/contact.php" class="kn-button kn-button-primary">Start a Conversation</a>
                            <a href="/projects/" class="kn-button kn-button-secondary">View Projects</a>
                        </div>
                    </div>

                    <div class="kn-card-grid kn-services-grid">
                        <article class="kn-card kn-stack">
                            <h2>Business Websites</h2>

                            <p>
                                Websites for local businesses, artists, portfolios, personal brands, gaming groups, and creative projects that need to look credible, explain the offer clearly, and make the next step easy.
                            </p>

                            <ul class="kn-feature-list">
                                <li>Mobile-friendly, responsive page design</li>
                                <li>Accessibility-conscious structure and markup</li>
                                <li>Admin pages or CMS workflows for easier content updates</li>
                            </ul>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Game Design &amp; Content</h2>

                            <p>
                                TTRPG and game content support for turning concepts, notes, lore, mechanics, or unfinished drafts into organized, playable material with clear rules and table-ready presentation.
                            </p>

                            <ul class="kn-feature-list">
                                <li>Campaign modules, encounters, factions, settings, and worldbuilding</li>
                                <li>Rule adherence, mechanics cleanup, balance review, and formatting</li>
                                <li>Stat blocks, items, abilities, lore text, and release-ready documents</li>
                            </ul>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Livestreaming &amp; Video Editing</h2>

                            <p>
                                Event streaming and editing support for people who need live coverage, cleaner footage, stronger pacing, and videos shaped around viewer retention and a clear call to action.
                            </p>

                            <ul class="kn-feature-list">
                                <li>On-site event streaming with my livestreaming backpack setup</li>
                                <li>Edited footage cut for pacing, clarity, retention, and viewer interest</li>
                                <li>Finished videos, clips, highlights, and CTA-focused edits</li>
                            </ul>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Excel/VBA &amp; Reporting</h2>

                            <p>
                                Automation and reporting support for recurring reports, reconciliations, data checks, and spreadsheet-heavy processes that need to be faster, cleaner, and easier to repeat.
                            </p>

                            <ul class="kn-feature-list">
                                <li>Excel/VBA automation for recurring reports and manual refresh steps</li>
                                <li>Reconciliation support for financial data, invoices, access lists, and operational records</li>
                                <li>Reporting templates with formulas, summaries, validation, and handoff documentation</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- How I Work -->
        <section>
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-split kn-split-sidebar kn-align-start">
                        <div class="kn-section-header">
                            <h2>How I Work</h2>

                            <p>
                                I can start from a rough idea, an existing file, a broken workflow, or a blank page. The important part is defining the goal, constraints, and finished result before the build starts.
                            </p>
                        </div>

                        <aside class="kn-card kn-stack">
                            <h3>Good Starting Point</h3>

                            <p>
                                You do not need a finished plan. Send the idea, goal, problem, event, content need, report requirement, or existing material you have. I can help turn that into a clear deliverable.
                            </p>

                            <a href="/contact.php" class="kn-button kn-button-primary">Contact Me</a>
                        </aside>
                    </div>

                    <div class="kn-grid">
                        <article class="kn-card kn-stack">
                            <h3>1. Clarify the Goal</h3>

                            <p>
                                We define what needs to exist, what problem it should solve, who will use it, and what a successful result looks like.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>2. Define the Deliverable</h3>

                            <p>
                                We agree on the specific website, content package, event stream, video edit, report, automation, or documentation being delivered.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>3. Build and Test</h3>

                            <p>
                                I build the work, check the obvious failure points, and clean up layout, wording, usability, pacing, accuracy, and handoff issues.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>4. Hand Off the Work</h3>

                            <p>
                                You receive the finished files, notes, instructions, or next steps needed to use, maintain, repeat, or expand the work later.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section>
            <div class="kn-container">
                <article class="kn-card kn-stack">
                    <div class="kn-text-block">
                        <h2>Need a website, game document, event stream, video edit, report, or spreadsheet built?</h2>

                        <p>
                            Send the idea, problem, file, footage, report, workflow, or outcome you want. Starting from scratch is fine.
                        </p>
                    </div>

                    <div class="kn-button-group">
                        <a href="/contact.php" class="kn-button kn-button-primary">Start a Conversation</a>
                        <a href="/projects/" class="kn-button kn-button-secondary">View Projects</a>
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