<!--
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
-->

<?php
    $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
    $pageLocked = "";

    require_once $projectRoot . '/config/session.php';

    $pageTitle = "Nickolas Patino | Services";
    $pageDescription = "Services from Nickolas Patino including web development, website refreshes, internal tools, workflow automation, livestreaming, video, editing, and practical small business technology help.";
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
        <!-- Services Hero / Offerings -->
        <section class="hero">
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="page-hero-content">
                        <p class="small-text text-primary">
                            Websites • Automation • Internal Tools • Streaming • Video • Editing
                        </p>

                        <h1>Services that make your digital work easier.</h1>

                        <p class="lead">
                            Practical help with websites, internal tools, automation, livestreaming, video, editing, and small business technology.
                        </p>

                        <div class="button-group">
                            <a href="/contact.php" class="button button-primary">Start a Conversation</a>
                            <a href="/projects/" class="button button-secondary">View Projects</a>
                        </div>
                    </div>

                    <div class="card-grid">
                        <article class="card stack">
                            <h2>Web Development</h2>

                            <p>
                                Clean, responsive websites and pages for businesses, portfolios, services, campaigns, projects, and personal brands.
                            </p>

                            <ul class="feature-list">
                                <li>HTML, CSS, JavaScript, PHP, and SQL</li>
                                <li>Responsive layouts and mobile-friendly pages</li>
                                <li>Forms, landing pages, and content pages</li>
                            </ul>
                        </article>

                        <article class="card stack">
                            <h2>Website Refreshes</h2>

                            <p>
                                Improvements to existing websites that need better structure, clearer content, cleaner layouts, or stronger presentation.
                            </p>

                            <ul class="feature-list">
                                <li>Page cleanup and reorganization</li>
                                <li>Content and navigation improvements</li>
                                <li>Readability and usability cleanup</li>
                            </ul>
                        </article>

                        <article class="card stack">
                            <h2>Internal Tools</h2>

                            <p>
                                Lightweight tools that organize information, reduce repetitive work, or make internal processes easier to manage.
                            </p>

                            <ul class="feature-list">
                                <li>Browser-based utilities</li>
                                <li>Administrative forms and workflows</li>
                                <li>Small PHP/MySQL tools and prototypes</li>
                            </ul>
                        </article>

                        <article class="card stack">
                            <h2>Automation</h2>

                            <p>
                                Practical automation and workflow cleanup for teams spending too much time on repetitive manual work.
                            </p>

                            <ul class="feature-list">
                                <li>Excel/VBA automation</li>
                                <li>Reporting templates and data cleanup</li>
                                <li>Forms, SharePoint, and Power Automate support</li>
                            </ul>
                        </article>

                        <article class="card stack">
                            <h2>Streaming &amp; Video</h2>

                            <p>
                                Support for livestreaming, recorded video, editing, and creator-facing content workflows.
                            </p>

                            <ul class="feature-list">
                                <li>Livestream planning and setup support</li>
                                <li>Video editing and content cleanup</li>
                                <li>Short-form clips and presentation polish</li>
                            </ul>
                        </article>

                        <article class="card stack">
                            <h2>Small Business Tech</h2>

                            <p>
                                Practical technical help for small businesses, solo LLCs, creators, and local organizations.
                            </p>

                            <ul class="feature-list">
                                <li>Website updates and troubleshooting</li>
                                <li>Digital organization and documentation</li>
                                <li>Simple systems that are easy to maintain</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- How I Work -->
        <section>
            <div class="container">
                <div class="stack stack-roomy">
                    <div class="split split-sidebar align-start">
                        <div class="section-header">
                            <h2>How I Work</h2>

                            <p>
                                I prefer clear, practical projects with a defined goal. The process does not need to be complicated, but it does need to be organized.
                            </p>
                        </div>

                        <aside class="card stack">
                            <h3>Good Starting Point</h3>

                            <p>
                                Send what you have, what is not working, what you want improved, and any deadline or important constraint.
                            </p>

                            <a href="/contact.php" class="button button-primary">Contact Me</a>
                        </aside>
                    </div>

                    <div class="grid">
                        <article class="card stack">
                            <h3>1. Define the Need</h3>

                            <p>
                                We clarify the problem, what already exists, and what a successful outcome should look like.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>2. Build the Solution</h3>

                            <p>
                                I create the page, tool, workflow, edit, document, or technical improvement with practical usability in mind.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>3. Review and Refine</h3>

                            <p>
                                We review the work, clean up issues, adjust details, and make sure the result is useful and understandable.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>4. Hand Off Clearly</h3>

                            <p>
                                I provide clear notes, files, instructions, or next steps so the work can be used, maintained, or expanded later.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section>
            <div class="container">
                <article class="card stack">
                    <div class="text-block">
                        <h2>Need practical help with a website, workflow, or content project?</h2>

                        <p>
                            Send a message with what you are working on, what you need fixed or built, and the best next step.
                        </p>
                    </div>

                    <div class="button-group">
                        <a href="/contact.php" class="button button-primary">Start a Conversation</a>
                        <a href="/projects/" class="button button-secondary">View Projects</a>
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
