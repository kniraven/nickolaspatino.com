<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/11/2026
    Updated: 06/11/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';

$pageTitle = "Nickolas Patino | Kail’s Landscaping Case Study";
$pageDescription = "Case study for Kail’s Landscaping, a custom PHP/MySQL local business website with quote request intake, customer request follow-up, admin CRM tools, editable website content, image uploads, and business document workflows.";
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
        <section class="kn-hero">
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-split kn-split-sidebar kn-align-start">
                        <div class="kn-page-hero-content">
                            <p class="kn-small-text kn-text-primary">
                                PHP • MySQL • Admin CRM • Quote Requests • Content Editor • Local Business Website
                            </p>

                            <h1>Kail’s Landscaping Website &amp; Quote Management System</h1>

                            <p class="kn-lead">
                                A custom website and quote management system for a local landscaping business serving the DeForest, Windsor, and Sun Prairie area.
                            </p>

                            <div class="kn-button-group">
                                <a href="https://kailslandscaping.com" class="kn-button kn-button-primary" target="_blank" rel="noopener">Live Site</a>
                                <a href="https://github.com/kniraven-llc/kailslandscaping.com" class="kn-button kn-button-secondary" target="_blank" rel="noopener">GitHub</a>
                                <a href="/projects/" class="kn-button kn-button-ghost">Back to Projects</a>
                            </div>
                        </div>

                        <aside class="kn-card kn-stack">
                            <h2>Project Summary</h2>

                            <dl>
                                <dt>Type</dt>
                                <dd>Local business website and quote management system</dd>

                                <dt>Role</dt>
                                <dd>Developer</dd>

                                <dt>Technologies</dt>
                                <dd>PHP, MySQL, HTML, CSS, JavaScript, Bootstrap, Apache</dd>

                                <dt>Core Features</dt>
                                <dd>Public service website, quote request intake, customer follow-up pages, admin CRM tools, content editor, image uploads, document tools, and business identity settings</dd>
                            </dl>
                        </aside>
                    </div>

                    <div class="kn-media-frame kn-aspect-video">
                        <img
                            src="/assets/images/projects/kails-landscaping.jpg"
                            alt="Kail’s Landscaping website screenshot"
                        >
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-sidebar kn-align-start">
                    <article class="kn-stack">
                        <div class="kn-section-header">
                            <h2>Overview</h2>

                            <p>
                                Kail’s Landscaping is a custom PHP/MySQL website for a local outdoor-services business. The public site presents the business, service area, contact information, service cards, quote request form, and customer request follow-up options.
                            </p>

                            <p>
                                The private admin side supports client management, quote request tracking, request status updates, editable website content, service card management, image uploads, theme color controls, business document tools, and business identity settings.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>Public Website</h3>

                                <p>
                                    The public homepage explains the business, lists services, shows contact information, and gives customers a clear way to request work.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Quote Intake</h3>

                                <p>
                                    Customers can submit quote requests with contact information, preferred contact method, service selection, city or area, and project details.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Request Follow-Up</h3>

                                <p>
                                    Customers receive request information and can return later using a request number and access key to view or add details.
                                </p>
                            </article>
                        </div>
                    </article>

                    <aside class="kn-card kn-stack">
                        <h2>Public Pages</h2>

                        <ul class="kn-feature-list">
                            <li>Homepage</li>
                            <li>Quote request form</li>
                            <li>Request confirmation page</li>
                            <li>Existing request lookup</li>
                            <li>Customer request update page</li>
                            <li>Printable document pages</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-section-header">
                        <h2>Public Website Features</h2>

                        <p>
                            The customer-facing website is organized around the information a local service business needs visitors to find quickly.
                        </p>
                    </div>

                    <div class="kn-card-grid">
                        <article class="kn-card kn-stack">
                            <h3>Local Service Positioning</h3>

                            <p>
                                The homepage identifies the business, explains the outdoor services offered, and lists the local service area.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Service Cards</h3>

                            <p>
                                Editable service cards show the business’s active services in a format that is easy for customers to scan.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Quick Contact Information</h3>

                            <p>
                                Phone, email, service area, and business hours are presented near the quote request path.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Quote Request Form</h3>

                            <p>
                                The form collects customer contact details, preferred contact method, service needed, and project details.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Existing Request Lookup</h3>

                            <p>
                                Customers can return to an existing request using a request number and access key.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Mobile-Friendly Layout</h3>

                            <p>
                                The public pages are structured for use on desktop and smaller screens.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-sidebar kn-align-start">
                    <div class="kn-stack">
                        <div class="kn-section-header">
                            <h2>Quote Request Workflow</h2>

                            <p>
                                The quote request workflow turns a customer form submission into a trackable business request.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>Validated Submission</h3>

                                <p>
                                    The form uses server-side validation for required fields, contact method requirements, selected service, message details, CSRF token, and spam honeypot handling.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Client Record Handling</h3>

                                <p>
                                    Submitted customer information can be used to create or update client records so repeat contacts are easier to manage.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Request Number and Access Key</h3>

                                <p>
                                    Each quote request is assigned a request number and customer access key for follow-up.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h2>Request Data</h2>

                        <ul class="kn-feature-list">
                            <li>Name</li>
                            <li>Phone or email</li>
                            <li>Preferred contact method</li>
                            <li>City or service area</li>
                            <li>Service requested</li>
                            <li>Project details</li>
                            <li>Status</li>
                            <li>Request comments</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-section-header">
                        <h2>Admin and Business Tools</h2>

                        <p>
                            The admin side is designed around the business owner’s operational needs: reviewing requests, managing clients, updating website content, and preparing business documents.
                        </p>
                    </div>

                    <div class="kn-card-grid">
                        <article class="kn-card kn-stack">
                            <h3>Admin Login</h3>

                            <p>
                                Admin pages are structured behind a login workflow for managing the business system.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Client Management</h3>

                            <p>
                                Admin screens support client lists, client details, and client editing.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Request Management</h3>

                            <p>
                                Quote requests can be reviewed, edited, commented on, and tracked through status changes.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Status Settings</h3>

                            <p>
                                Request status settings support consistent handling of work as it moves through the business process.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Document Tools</h3>

                            <p>
                                The system includes document editing and print views for customer-facing business paperwork.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>System Check</h3>

                            <p>
                                A system check page validates expected database tables, columns, public routes, and shared source files.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-sidebar kn-align-start">
                    <div class="kn-stack">
                        <div class="kn-section-header">
                            <h2>Website Content Editor</h2>

                            <p>
                                The website editor gives the site owner a way to manage business content without changing PHP files.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>Editable Content</h3>

                                <p>
                                    Business identity, navigation text, hero content, quick contact text, about content, footer text, SEO text, and contact form labels are editable through admin screens.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Service Card Management</h3>

                                <p>
                                    Services can be added, edited, hidden, removed, reordered, and paired with optional service images.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Theme and Image Controls</h3>

                                <p>
                                    Admin tools support theme color editing and image replacement for the logo, hero image, favicon, and service images.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h2>Editable Areas</h2>

                        <ul class="kn-feature-list">
                            <li>Business identity</li>
                            <li>Navigation</li>
                            <li>Hero content</li>
                            <li>Quick contact box</li>
                            <li>Service section</li>
                            <li>Service cards</li>
                            <li>About content</li>
                            <li>Contact form labels</li>
                            <li>Footer</li>
                            <li>SEO metadata</li>
                            <li>Theme colors</li>
                            <li>Website images</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-sidebar kn-align-start">
                    <div class="kn-stack">
                        <div class="kn-section-header">
                            <h2>Technical Implementation</h2>

                            <p>
                                The project uses PHP route files, shared source helpers, MySQL data storage, admin authentication, reusable layout files, content defaults, and database helper functions.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>PHP/MySQL Structure</h3>

                                <p>
                                    Public pages, admin pages, database helpers, content helpers, layout files, and session handling are separated into project folders.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Security Controls</h3>

                                <p>
                                    The project uses server-side validation, prepared statements, password hashing, session handling, CSRF validation, honeypot spam reduction, and public request access tokens.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Upload Validation</h3>

                                <p>
                                    Image uploads are checked for file type, MIME type, file size, dimensions, aspect ratio, and upload errors before replacing public assets.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h2>Project Folders</h2>

                        <ul class="kn-feature-list">
                            <li><code>config/</code></li>
                            <li><code>public/</code></li>
                            <li><code>public/assets/</code></li>
                            <li><code>src/Admin/</code></li>
                            <li><code>src/Content/</code></li>
                            <li><code>src/Database/</code></li>
                            <li><code>src/Layout/</code></li>
                            <li><code>src/Session/</code></li>
                            <li><code>storage/</code></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-sidebar kn-align-start">
                    <div class="kn-section-header">
                        <h2>Project Scope</h2>

                        <p>
                            This project was built for a local service business that needed a public web presence and a practical way to manage quote requests, customers, content, and business documents.
                        </p>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h3>Included Work</h3>

                        <ul class="kn-feature-list">
                            <li>Local business homepage</li>
                            <li>Quote request form</li>
                            <li>Customer follow-up flow</li>
                            <li>Admin client tools</li>
                            <li>Admin request tools</li>
                            <li>Website content editor</li>
                            <li>Service card editor</li>
                            <li>Theme color editor</li>
                            <li>Image upload handling</li>
                            <li>Document editing and printing</li>
                            <li>Business card generation</li>
                            <li>System check page</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <article class="kn-card kn-stack">
                    <div class="kn-text-block">
                        <h2>View the project.</h2>

                        <p>
                            Open the live site, review the source code, or return to the project list.
                        </p>
                    </div>

                    <div class="kn-button-group">
                        <a href="https://kailslandscaping.com" class="kn-button kn-button-primary" target="_blank" rel="noopener">Live Site</a>
                        <a href="https://github.com/kniraven-llc/kailslandscaping.com" class="kn-button kn-button-secondary" target="_blank" rel="noopener">GitHub</a>
                        <a href="/projects/" class="kn-button kn-button-ghost">Back to Projects</a>
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