<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/12/2026
    Updated: 06/12/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';

$pageTitle = "Nickolas Patino | Kniraven.com Case Study";
$pageDescription = "Case study for Kniraven.com, a production PHP/MySQL brand platform for Kniraven LLC with user accounts, session management, OAuth login, custom CAPTCHA, Stripe API payments, store functionality, dev log publishing, support pages, accessibility, and mobile-friendly responsive design.";
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
                        <div class="kn-page-hero-content kn-stack">
                            <p class="kn-small-text kn-text-primary">
                                PHP • MySQL • Stripe API • OAuth • Sessions • Custom CAPTCHA • AWS EC2 • Brand Platform
                            </p>

                            <h1>Kniraven.com Brand, Store, Account &amp; Community Platform</h1>

                            <p class="kn-lead">
                                A production website for Kniraven LLC that combines brand presentation, user accounts, store functionality, Stripe payments, dev log publishing, support pages, business information, product discovery, and community-facing game content into one full-stack platform.
                            </p>

                            <p>
                                I built and maintain the site as both the owner of Kniraven LLC and the lead developer responsible for its public pages, account-aware user flows, payment-connected store structure, accessibility-minded layout, mobile-friendly interface, and production deployment on AWS EC2.
                            </p>

                            <p>
                                The project supports a real creative business rather than a fictional demo. It brings together product pages for tabletop and real-life RPG concepts, lore and worldbuilding sections, a storefront, account registration, login behavior, support paths, contact workflows, partnership inquiries, beta interest collection, and public update publishing.
                            </p>

                            <div class="kn-button-group">
                                <a href="https://kniraven.com" class="kn-button kn-button-primary" target="_blank" rel="noopener">Live Site</a>
                                <a href="/projects/" class="kn-button kn-button-ghost">Back to Projects</a>
                            </div>
                        </div>

                        <aside class="kn-card kn-stack">
                            <h2>Project Summary</h2>

                            <dl>
                                <dt>Type</dt>
                                <dd>Production brand website, store, account system, and community platform</dd>

                                <dt>Role</dt>
                                <dd>Founder, owner, creator, and lead developer for Kniraven LLC</dd>

                                <dt>Technologies</dt>
                                <dd>PHP, MySQL, HTML, CSS, JavaScript, Stripe API, OAuth, Apache, AWS EC2</dd>

                                <dt>Core Features</dt>
                                <dd>User login system, session management, OAuth login, custom CAPTCHA, Stripe payments, store pages, news and dev log publishing, support pages, contact forms, beta signup, accessible markup, and mobile-friendly layouts</dd>

                                <dt>Repository</dt>
                                <dd>Private GitHub repository because the site supports a real business, user accounts, payment functionality, and original intellectual property</dd>
                            </dl>
                        </aside>
                    </div>

                    <div class="kn-media-frame kn-aspect-video">
                        <img
                            src="/assets/images/projects/kniraven.png"
                            alt="Kniraven.com website screenshot"
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
                                Kniraven.com is the production web platform for Kniraven LLC. The site presents the Kniraven brand, tabletop RPG content, real-life RPG concepts, lore, store products, news updates, support options, business information, and community entry points.
                            </p>

                            <p>
                                The project is more than a static portfolio piece. It is a live business website with account-aware functionality, payment integration, content publishing, support flows, responsive design, accessibility-focused markup, and a private codebase maintained for an active creative business.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>Brand Platform</h3>

                                <p>
                                    The public website introduces Kniraven LLC, explains the brand’s games and creative products, and gives visitors a central place to explore the company’s worldbuilding, store, news, and support options.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>User Accounts</h3>

                                <p>
                                    The site includes registration and login flows with session-managed account functionality, OAuth login support, password recovery, and custom anti-spam protections.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Store and Payments</h3>

                                <p>
                                    The store presents products and connects payment-related functionality through Stripe API integration for real business use.
                                </p>
                            </article>
                        </div>
                    </article>

                    <aside class="kn-card kn-stack">
                        <h2>Public Pages</h2>

                        <ul class="kn-feature-list">
                            <li>Homepage</li>
                            <li>Games overview pages</li>
                            <li>TTRPG product pages</li>
                            <li>RLRPG product pages</li>
                            <li>Lore and worldbuilding pages</li>
                            <li>Store pages</li>
                            <li>News and dev log</li>
                            <li>Contact page</li>
                            <li>Partnership inquiry page</li>
                            <li>Bug report page</li>
                            <li>Beta signup page</li>
                            <li>Press kit page</li>
                            <li>Support and donation pages</li>
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
                            The public-facing side of Kniraven.com is organized around brand credibility, product discovery, community growth, and clear paths for visitors to take action.
                        </p>
                    </div>

                    <div class="kn-card-grid">
                        <article class="kn-card kn-stack">
                            <h3>Brand and Business Identity</h3>

                            <p>
                                The site establishes Kniraven LLC as the company behind the games, lore, products, updates, and community-facing content.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Game Product Pages</h3>

                            <p>
                                Dedicated pages explain the tabletop RPG and real-life RPG concepts, including system ideas, product positioning, and planned player experiences.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Storefront</h3>

                            <p>
                                Product pages and store flows support real merchandise and digital-product presentation for customers and supporters.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>News and Dev Log</h3>

                            <p>
                                The news and development log gives the site a publishing channel for updates, progress notes, product announcements, and development history.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Support Paths</h3>

                            <p>
                                Visitors can find contact options, partnership inquiries, bug reporting, beta signup, donation information, and future support opportunities.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Mobile-Friendly Layout</h3>

                            <p>
                                The public pages are structured for desktop and smaller screens so visitors can browse the site from phones, tablets, laptops, and desktop monitors.
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
                            <h2>Account and Login System</h2>

                            <p>
                                Kniraven.com includes user-facing account functionality to support authenticated experiences as the platform grows.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>Session Management</h3>

                                <p>
                                    The site uses session handling to support login state, account-aware navigation, protected actions, and authenticated user flows.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>OAuth Login</h3>

                                <p>
                                    OAuth login support gives users an alternate authentication path and demonstrates integration with third-party identity workflows.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Custom CAPTCHA</h3>

                                <p>
                                    Registration includes custom CAPTCHA-style anti-spam protection to reduce automated account creation and form abuse.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h2>Account Features</h2>

                        <ul class="kn-feature-list">
                            <li>User registration</li>
                            <li>User login</li>
                            <li>Session-managed state</li>
                            <li>OAuth login support</li>
                            <li>Password recovery flow</li>
                            <li>Custom CAPTCHA challenge</li>
                            <li>Account-aware page behavior</li>
                            <li>Private areas for future expansion</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

        <section>
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-section-header">
                        <h2>Store and Payment Functionality</h2>

                        <p>
                            The commerce side of the site supports Kniraven LLC’s ability to present products, accept support, and process payment-related actions through Stripe.
                        </p>
                    </div>

                    <div class="kn-card-grid">
                        <article class="kn-card kn-stack">
                            <h3>Product Listings</h3>

                            <p>
                                Store pages present products with names, descriptions, prices, and customer-facing purchase actions.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Stripe API Integration</h3>

                            <p>
                                Stripe API functionality supports payment processing for real business use while keeping payment handling separate from the public portfolio source code.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Support and Donations</h3>

                            <p>
                                Support pages provide paths for visitors to financially support the project and connect with the business.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Account-Aware Commerce</h3>

                            <p>
                                The account system creates a foundation for user-specific store, order, subscription, and support functionality as the platform develops.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Private Business Logic</h3>

                            <p>
                                Payment and account-related code is kept in a private repository because it supports a real business and should not be exposed as a public demo.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h3>Production Use Case</h3>

                            <p>
                                Unlike a mock checkout exercise, the store exists as part of a live brand website with real product and business requirements.
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
                            <h2>Content and Community Platform</h2>

                            <p>
                                Kniraven.com is designed to support a growing creative ecosystem rather than a single one-page website.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>Development Updates</h3>

                                <p>
                                    The dev log gives the project a structured place for announcements, release notes, progress updates, and development history.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Worldbuilding Content</h3>

                                <p>
                                    Lore and game pages organize fictional setting material, tabletop RPG concepts, real-life RPG ideas, and related product information.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Community Entry Points</h3>

                                <p>
                                    Contact, partnership, bug report, beta signup, support, and business pages create clear paths for different types of visitors.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h2>Content Areas</h2>

                        <ul class="kn-feature-list">
                            <li>News posts</li>
                            <li>Development log posts</li>
                            <li>TTRPG information</li>
                            <li>RLRPG information</li>
                            <li>Lore pages</li>
                            <li>Store products</li>
                            <li>Support pages</li>
                            <li>Partnership inquiries</li>
                            <li>Bug reports</li>
                            <li>Beta interest collection</li>
                            <li>Business information</li>
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
                                The project uses PHP route files, shared layout includes, MySQL-backed functionality, account/session handling, Stripe integration, reusable page structure, and production deployment practices.
                            </p>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h3>PHP/MySQL Structure</h3>

                                <p>
                                    The site is built with PHP, MySQL, shared source files, reusable headers and footers, account-aware logic, and database-backed functionality.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Security-Aware Features</h3>

                                <p>
                                    The project uses session management, authentication flows, custom CAPTCHA, account protections, and private source control for sensitive business logic.
                                </p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h3>Responsive and Accessible Markup</h3>

                                <p>
                                    Pages are built with mobile-friendly layouts, semantic structure, skip-link support, readable content hierarchy, and accessibility-minded navigation patterns.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h2>Technical Areas</h2>

                        <ul class="kn-feature-list">
                            <li><code>PHP</code></li>
                            <li><code>MySQL</code></li>
                            <li><code>HTML</code></li>
                            <li><code>CSS</code></li>
                            <li><code>JavaScript</code></li>
                            <li><code>Stripe API</code></li>
                            <li><code>OAuth</code></li>
                            <li><code>Sessions</code></li>
                            <li><code>Custom CAPTCHA</code></li>
                            <li><code>Apache</code></li>
                            <li><code>AWS EC2</code></li>
                            <li><code>Git</code></li>
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
                            This project was built for Kniraven LLC as a real business platform, not just a practice demo. It combines brand development, product presentation, commerce, account features, publishing tools, support workflows, and production deployment into a single public site.
                        </p>
                    </div>

                    <aside class="kn-card kn-stack">
                        <h3>Included Work</h3>

                        <ul class="kn-feature-list">
                            <li>Production brand website</li>
                            <li>Homepage and navigation structure</li>
                            <li>TTRPG product pages</li>
                            <li>RLRPG product pages</li>
                            <li>Lore and worldbuilding pages</li>
                            <li>User registration and login</li>
                            <li>Session management</li>
                            <li>OAuth login support</li>
                            <li>Custom CAPTCHA</li>
                            <li>Store and product pages</li>
                            <li>Stripe API payment integration</li>
                            <li>News and dev log publishing</li>
                            <li>Contact and partnership pages</li>
                            <li>Bug report page</li>
                            <li>Beta signup page</li>
                            <li>Support and donation pages</li>
                            <li>Responsive layout work</li>
                            <li>Accessibility-focused structure</li>
                            <li>AWS EC2 production deployment</li>
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
                            Open the live site or return to the project list. The source code is private because this is a live business platform with account, payment, and original intellectual property features.
                        </p>
                    </div>

                    <div class="kn-button-group">
                        <a href="https://kniraven.com" class="kn-button kn-button-primary" target="_blank" rel="noopener">Live Site</a>
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