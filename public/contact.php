
<!--
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
-->

<?php
    $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
    $pageLocked = "";

    require_once $projectRoot . '/config/session.php';

    $pageTitle = "Nickolas Patino | Contact";
    $pageDescription = "Contact Nickolas Patino for web development, internal tools, workflow automation, livestreaming, video, editing, and practical small business technology help.";
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
                <div class="split split-sidebar align-start">
                    <div class="stack stack-roomy">
                        <div class="page-hero-content">
                            <p class="small-text text-primary">
                                Web Development • Automation • Streaming • Video • Editing
                            </p>

                            <h1>Contact me.</h1>

                            <p class="lead">
                                Reach out about hiring, freelance work, websites, internal tools, workflow automation, livestreaming, video projects, or editing.
                            </p>
                        </div>

                        <article class="card stack">
                            <div class="text-block">
                                <h2 id="contact-form">Send a Message</h2>

                                <p>
                                    Send a clear message about what you need, what you are working on, and the best next step.
                                </p>
                            </div>

                            <form class="form" method="post" action="/contact-submit.php">
                                <div class="form-row">
                                    <div class="form-field">
                                        <label for="full_name">Name</label>
                                        <input
                                            type="text"
                                            id="full_name"
                                            name="full_name"
                                            autocomplete="name"
                                            maxlength="120"
                                            required
                                        >
                                    </div>

                                    <div class="form-field">
                                        <label for="email">Email</label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            autocomplete="email"
                                            maxlength="160"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="form-field">
                                    <label for="organization">Company / Organization</label>
                                    <input
                                        type="text"
                                        id="organization"
                                        name="organization"
                                        autocomplete="organization"
                                        maxlength="160"
                                        placeholder="Optional"
                                    >
                                </div>

                                <div class="form-field">
                                    <label for="reason">Reason for Contact</label>
                                    <select id="reason" name="reason" required>
                                        <option value="">Select a reason</option>
                                        <option value="employer_hiring">Employer / hiring conversation</option>
                                        <option value="website_project">Website or web development project</option>
                                        <option value="automation_project">Internal tool or automation project</option>
                                        <option value="small_business_tech">Small business tech help</option>
                                        <option value="streaming_video_editing">Livestreaming, video, or editing project</option>
                                        <option value="project_collaboration">Project collaboration</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="form-field">
                                    <label for="message">Message</label>
                                    <textarea
                                        id="message"
                                        name="message"
                                        maxlength="4000"
                                        required
                                        placeholder="Tell me what you need, what you are working on, and the best next step."
                                    ></textarea>
                                </div>

                                <div class="visually-hidden" aria-hidden="true">
                                    <label for="website">Website</label>
                                    <input
                                        type="text"
                                        id="website"
                                        name="website"
                                        tabindex="-1"
                                        autocomplete="off"
                                    >
                                </div>

                                <input type="hidden" name="form_source" value="nickolaspatino_contact_page">

                                <button class="button button-primary" type="submit">Send Message</button>
                            </form>
                        </article>
                    </div>

                    <aside class="stack">
                        <article class="card stack">
                            <h2>Contact Details</h2>

                            <p>
                                <strong>Email:</strong>
                                <a href="mailto:nickolas@kniraven.com">nickolas@kniraven.com</a>
                            </p>

                            <p>
                                <strong>Location:</strong> DeForest / Madison, Wisconsin area
                            </p>
                        </article>

                        <article class="card stack">
                            <h2>Good Fits</h2>

                            <ul class="feature-list">
                                <li>Web development roles</li>
                                <li>Business, portfolio, and service websites</li>
                                <li>Internal tools and workflow automation</li>
                                <li>Excel/VBA and reporting process improvement</li>
                                <li>Livestreaming, video, and editing projects</li>
                                <li>Technical help for small businesses and creators</li>
                            </ul>
                        </article>

                        <article class="card stack">
                            <h2>What to Include</h2>

                            <ul class="feature-list">
                                <li>The type of work or opportunity</li>
                                <li>Your goal or problem to solve</li>
                                <li>Any timeline or deadline</li>
                                <li>Relevant links, assets, files, or existing systems</li>
                                <li>The best way to follow up</li>
                            </ul>
                        </article>
                    </aside>
                </div>
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