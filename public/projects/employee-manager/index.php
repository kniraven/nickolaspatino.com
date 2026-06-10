```php
<!--
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
-->

<?php
    $projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
    $pageLocked = "";

    require_once $projectRoot . '/config/session.php';

    $pageTitle = "Nickolas Patino | Employee Manager Case Study";
    $pageDescription = "Case study for Employee Manager, a PHP/MySQL CRUD web application for managing employee records, search, sorting, manager assignment, and responsive administrative views.";
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
                                PHP • MySQL • PDO • CRUD • Admin Interface
                            </p>

                            <h1>Employee Manager</h1>

                            <p class="lead">
                                A database-backed employee management application for creating, viewing, searching, editing, and deleting employee records.
                            </p>

                            <div class="button-group">
                                <a href="/demos/employee-manager/" class="button button-primary" target="_blank" rel="noopener">Live Demo</a>
                                <a href="https://github.com/kniraven/employee-manager" class="button button-secondary" target="_blank" rel="noopener">GitHub</a>
                                <a href="/projects/" class="button button-ghost">Back to Projects</a>
                            </div>
                        </div>

                        <aside class="card stack">
                            <h2>Project Summary</h2>

                            <dl>
                                <dt>Type</dt>
                                <dd>Business web application</dd>

                                <dt>Role</dt>
                                <dd>Developer</dd>

                                <dt>Technologies</dt>
                                <dd>PHP, MySQL, PDO, HTML, CSS, Tailwind CSS</dd>

                                <dt>Core Features</dt>
                                <dd>Employee records, search, sorting, create/read/update/delete workflows, manager assignment, and responsive views</dd>
                            </dl>
                        </aside>
                    </div>

                    <div class="media-frame aspect-video">
                        <img
                            src="/assets/images/projects/employeemanager.png"
                            alt="Employee Manager application screenshot"
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
                                Employee Manager is a small administrative web application for maintaining employee records. It includes a searchable employee list, individual detail views, add/edit forms, delete actions, and manager relationships between employees.
                            </p>
                        </div>

                        <div class="grid">
                            <article class="card stack">
                                <h3>Employee Directory</h3>

                                <p>
                                    The main screen displays employee records with names, email addresses, positions, teams, managers, hire dates, termination dates, and record actions.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Search and Sorting</h3>

                                <p>
                                    The list supports text search across employee fields and sortable table headers for reviewing records in different orders.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Record Management</h3>

                                <p>
                                    Create, read, update, and delete screens provide the core administrative workflow for employee data.
                                </p>
                            </article>
                        </div>
                    </article>

                    <aside class="card stack">
                        <h2>Employee Fields</h2>

                        <ul class="feature-list">
                            <li>First name</li>
                            <li>Last name</li>
                            <li>Email</li>
                            <li>Position</li>
                            <li>Team</li>
                            <li>Manager</li>
                            <li>Hire date</li>
                            <li>Termination date</li>
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
                            The application is organized around common employee-record workflows used in administrative tools.
                        </p>
                    </div>

                    <div class="card-grid">
                        <article class="card stack">
                            <h3>Employee List</h3>

                            <p>
                                The index page lists employee records and provides direct links to view, edit, and delete each record.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Search</h3>

                            <p>
                                The search form filters employee records by name, email, position, team, manager, hire date, and termination date.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Sortable Columns</h3>

                            <p>
                                Table headers support sorting by employee fields, with direction toggling between ascending and descending order.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Add Employee</h3>

                            <p>
                                The create form collects employee details and inserts a new record into the database.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Edit Employee</h3>

                            <p>
                                The update form loads an existing employee record, allows changes, and saves the updated data.
                            </p>
                        </article>

                        <article class="card stack">
                            <h3>Responsive Views</h3>

                            <p>
                                Desktop users receive a table layout, while smaller screens receive stacked employee cards.
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
                                The project uses PHP pages connected to a MySQL database through a shared database configuration. Employee records are queried with PDO, and the interface is split across list, create, read, update, and delete screens.
                            </p>
                        </div>

                        <div class="grid">
                            <article class="card stack">
                                <h3>PHP and PDO</h3>

                                <p>
                                    The application uses prepared PDO statements for insert, update, read, and delete operations.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Manager Relationship</h3>

                                <p>
                                    Employee records can reference another employee as a manager, and list/detail views join employee records back to manager names.
                                </p>
                            </article>

                            <article class="card stack">
                                <h3>Responsive Interface</h3>

                                <p>
                                    The demo uses a desktop table for larger screens and a card-based layout for mobile screens.
                                </p>
                            </article>
                        </div>
                    </div>

                    <aside class="card stack">
                        <h2>Project Files</h2>

                        <ul class="feature-list">
                            <li><code>index.php</code></li>
                            <li><code>create.php</code></li>
                            <li><code>read.php</code></li>
                            <li><code>update.php</code></li>
                            <li><code>delete.php</code></li>
                            <li><code>includes/header.php</code></li>
                            <li><code>includes/footer.php</code></li>
                            <li><code>assets/css/styles.css</code></li>
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
                            This project is a focused CRUD application. It is designed around employee data entry, review, search, sorting, and record maintenance rather than a full HR platform.
                        </p>
                    </div>

                    <aside class="card stack">
                        <h3>Included Screens</h3>

                        <ul class="feature-list">
                            <li>Employee list</li>
                            <li>Add employee</li>
                            <li>Employee details</li>
                            <li>Edit employee</li>
                            <li>Delete employee action</li>
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
                        <a href="/demos/employee-manager/" class="button button-primary" target="_blank" rel="noopener">Live Demo</a>
                        <a href="https://github.com/kniraven/employee-manager" class="button button-secondary" target="_blank" rel="noopener">GitHub</a>
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
```
