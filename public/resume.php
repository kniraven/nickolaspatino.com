<!--
    Author: Nickolas Patino
    Created: 06/08/2026
    Updated: 06/08/2026
-->

<?php
    $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
    $pageLocked = "";

    require_once $projectRoot . '/config/session.php';

    $pageTitle = "Nickolas Patino | Resume";
    $pageDescription = "Resume for Nickolas Patino: web developer, automation-focused problem solver, and operations professional based near Madison, Wisconsin.";
    $pageCss = "resume";
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
        <section>
            <div class="container">
                <nav aria-label="Resume links">
                    <a href="/assets/files/nickolas-patino-resume.pdf" class="button button-primary" target="_blank" rel="noopener">Download PDF</a>
                    <a href="/contact.php" class="button button-secondary">Contact Me</a>
                </nav>

                <article id="resume" aria-label="Resume for Nickolas Patino">
                    <header>
                        <h1>Nickolas Patino</h1>

                        <p>
                            Web Developer • Internal Tools • Workflow Automation • Operations Support
                        </p>

                        <address>
                            DeForest, WI 53532 •
                            <a href="mailto:nickolas@kniraven.com">nickolas@kniraven.com</a> •
                            <a href="https://nickolaspatino.com">NickolasPatino.com</a>
                        </address>
                    </header>

                    <section>
                        <h2>Professional Summary</h2>

                        <p>
                            Web developer and automation-focused operations professional with experience building live websites, browser-based tools, web forms, Excel/VBA automations, workflow documentation, and process improvements. Technical background includes HTML, CSS, JavaScript, PHP, SQL, Bootstrap, Git, authentication/session workflows, OAuth login, Stripe API integration, Microsoft Graph email automation, and AWS-hosted deployment workflows.
                        </p>
                    </section>

                    <section>
                        <h2>Technical Skills</h2>

                        <dl>
                            <dt>Web Development &amp; Integrations</dt>
                            <dd>HTML, CSS, JavaScript, PHP, SQL, Bootstrap, responsive design, web forms, internal tools, browser-based utilities, accessibility-conscious implementation, OAuth, session management, Microsoft Graph API, Stripe API</dd>

                            <dt>Automation &amp; Data</dt>
                            <dd>Excel, VBA, Power Automate, Microsoft Forms, advanced formulas, pivot tables, data validation, workflow automation, reconciliations, reporting support, data quality review</dd>

                            <dt>Tools &amp; Platforms</dt>
                            <dd>Git, GitHub, GitLab, VS Code, Apache, XAMPP, LAMPP, phpMyAdmin, AWS EC2, Route 53, SharePoint, JIRA, ServiceNow</dd>

                            <dt>Business &amp; Reporting Systems</dt>
                            <dd>Power BI, Hyperion, Smart View, Oracle Fusion</dd>
                        </dl>
                    </section>

                    <section>
                        <h2>Selected Web &amp; Project Experience</h2>

                        <section>
                            <header>
                                <div>
                                    <h3>Founder / Web Developer</h3>
                                    <p>Kniraven LLC / Kniraven.com • DeForest, WI</p>
                                </div>

                                <p>Aug 2024 – Present</p>
                            </header>

                            <ul>
                                <li>Build and maintain Kniraven.com using HTML, CSS, JavaScript, PHP, Bootstrap, Apache, AWS EC2, Route 53, and a LAMPP production environment.</li>
                                <li>Implement session-based accounts, OAuth login, password reset workflows, Microsoft Graph API email automation, and Stripe API checkout functionality.</li>
                                <li>Maintain a private GitHub-based deployment workflow using local XAMPP development, domain-specific repositories, and Windows batch scripts to push approved production updates.</li>
                            </ul>
                        </section>

                        <section>
                            <header>
                                <div>
                                    <h3>Freelance TTRPG Designer &amp; Web Tool Developer</h3>
                                    <p>Aether Studios • Greer, SC</p>
                                </div>

                                <p>Feb 2022 – Aug 2024</p>
                            </header>

                            <ul>
                                <li>Built a browser-based 5e stat block generator using PHP, HTML, CSS, JavaScript, and Bootstrap 5 for both internal Aether Studios production and audience-created third-party content.</li>
                                <li>Developed validation, formatting, and quick-start documentation to standardize 5e stat block creation and reduce manual review/rework.</li>
                                <li>Produced 5e monster stat blocks, subclasses, vehicle systems, and Kickstarter-linked TTRPG content for Aether Studios projects.</li>
                                <li>Contributed to Space Bug Prairie, which raised $7,204 on a $2,000 goal, funding at 360% of target.</li>
                                <li>Contributed to Mimic Village, which raised $10,306 on a $1,500 goal, funding at 687% of target.</li>
                            </ul>
                        </section>

                        <section>
                            <header>
                                <div>
                                    <h3>Lead Designer &amp; Project Manager</h3>
                                    <p>Guldan Stories LLC • Madison, WI</p>
                                </div>

                                <p>Jul 2025 – Present</p>
                            </header>

                            <ul>
                                <li>Lead a small contractor team creating an original three-part adventure module and campaign setting supplement for Guldan Stories LLC’s in-development game, Lucid: The Dreaming.</li>
                                <li>Manage scope, milestones, documentation, publisher reviews, versioning, and monthly client progress updates.</li>
                                <li>Build project materials for web delivery using HTML, CSS, JavaScript, PHP, and Bootstrap 5.</li>
                            </ul>
                        </section>
                    </section>

                    <section>
                        <h2>Professional Experience</h2>

                        <section>
                            <header>
                                <div>
                                    <h3>Financial Analyst</h3>
                                    <p>QBE North America • Madison / Sun Prairie, WI</p>
                                </div>

                                <p>Oct 2024 – Jun 2026</p>
                            </header>

                            <ul>
                                <li>Supported FP&amp;A consolidations, reporting, KPI loading, cross-system financial data movement, reconciliations, hierarchy/mapping maintenance, and variance investigation.</li>
                                <li>Reconciled financial values across Oracle Fusion, Hyperion, Power BI, and SAS-derived reporting outputs.</li>
                                <li>Produced recurring KPI reports and ad-hoc reporting for senior stakeholders using Excel, Smart View, think-cell, pivot tables, cube member formulas, and advanced formulas.</li>
                                <li>Built a Microsoft Forms / Power Automate / SharePoint workflow for Management Unit hierarchy update requests.</li>
                                <li>Refactored a quarterly external-reporting workbook with VBA, reducing preparation time from 30+ minutes to about 30 seconds.</li>
                            </ul>
                        </section>

                        <section>
                            <header>
                                <div>
                                    <h3>Billing Team Lead / Process Improvement Specialist</h3>
                                    <p>QBE North America • Madison / Sun Prairie, WI</p>
                                </div>

                                <p>Aug 2019 – Oct 2024</p>
                            </header>

                            <ul>
                                <li>Managed process improvement intake, documentation, workflow support, automation, KPI tracking, stakeholder coordination, and change support across multiple operations teams.</li>
                                <li>Built web forms, Excel tools, VBA automations, and local HTML/CSS/JavaScript tools to reduce manual work and improve process efficiency.</li>
                                <li>Managed a SharePoint-based Process Optimization and Change Management Portal used across billing, collections, claims administration, accounts payable, property, operations, and procurement teams.</li>
                                <li>Automated more than 60% of manual billing processes, contributing to average annual savings of 3.7 FTE and approximately $150,000 yearly.</li>
                                <li>Supported offshore transition efforts that reduced costs by at least 20% without impacting service quality.</li>
                            </ul>
                        </section>

                        <section>
                            <header>
                                <div>
                                    <h3>Claims Support Representative</h3>
                                    <p>QBE North America • Madison / Sun Prairie, WI</p>
                                </div>

                                <p>Aug 2017 – Aug 2019</p>
                            </header>

                            <ul>
                                <li>Supported claims payment administration, invoice reconciliation, payment issuance and voids, returned and uncashed check follow-up, queue management, and claims-related system support.</li>
                                <li>Built a bulk payment reconciliation tool and configured a secure SharePoint-based platform for financial information sharing with an external contractor.</li>
                                <li>Achieved 100% SLA compliance for the first time in two years despite a 10% staff cut; cut bulk payment reconciliation processing time by 60% and saved 80+ hours monthly.</li>
                            </ul>
                        </section>
                    </section>

                    <section>
                        <h2>Education</h2>

                        <section>
                            <header>
                                <div>
                                    <h3>Associate of Science, IT Web Software Development</h3>
                                    <p>Madison Area Technical College • Madison, WI</p>
                                </div>

                                <p>Coursework completed Fall 2024 • GPA: 4.0</p>
                            </header>

                            <p>
                                <strong>Relevant Coursework:</strong> JavaScript, Advanced JavaScript, Website Development with HTML5, Advanced Website Development, PHP with MySQL, Advanced PHP and MySQL Web Development, SQL Database Programming, Java, Advanced Java, UI/UX for Developers, Agile Practices, IT Security Awareness, and Foundations of Software Quality.
                            </p>

                            <p>
                                <strong>Certification:</strong> Software Quality Fundamentals, Madison Area Technical College.
                            </p>
                        </section>
                    </section>
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