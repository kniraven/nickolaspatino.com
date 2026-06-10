<?php
/**
 * Main navigation for NickolasPatino.com
 *
 * This file assumes it is being included inside:
 *
 * <header class="site-header">
 *     <div class="container-wide site-header-inner">
 *         <?php require_once $projectRoot . '/src/nav.php'; ?>
 *     </div>
 * </header>
 */


/* =========================================================
   Current page helpers
   ========================================================= */

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

if (!function_exists('nav_is_active')) {
    function nav_is_active(string $currentPath, string $targetPath): bool
    {
        $currentPath = rtrim($currentPath, '/');
        $targetPath = rtrim($targetPath, '/');

        if ($currentPath === '') {
            $currentPath = '/';
        }

        if ($targetPath === '') {
            $targetPath = '/';
        }

        if ($targetPath === '/') {
            return $currentPath === '/' || $currentPath === '/index.php';
        }

        return $currentPath === $targetPath || str_starts_with($currentPath . '/', $targetPath . '/');
    }
}

if (!function_exists('nav_current_attr')) {
    function nav_current_attr(string $currentPath, string $targetPath): string
    {
        return nav_is_active($currentPath, $targetPath) ? ' aria-current="page"' : '';
    }
}
?>

<a class="site-brand" href="/" aria-label="Nickolas Patino home">
    <img
        src="/assets/images/logo-48x48.png"
        alt=""
        class="site-brand-logo"
        width="48"
        height="48"
        aria-hidden="true"
    >
    <span>Nickolas&nbsp;Patino</span>
</a>

<nav class="site-nav noprint" aria-label="Main navigation">
    <button
        class="nav-toggle"
        type="button"
        aria-controls="site-nav-list"
        aria-expanded="false"
        data-nav-toggle
    >
        <span class="visually-hidden">Toggle navigation</span>
        <span aria-hidden="true">Menu</span>
    </button>

    <ul class="site-nav-list" id="site-nav-list">
        <li>
            <a class="site-nav-link" href="/"<?= nav_current_attr($currentPath, '/') ?>>
                Home
            </a>
        </li>

        <li>
            <a class="site-nav-link" href="/projects/"<?= nav_current_attr($currentPath, '/projects') ?>>
                Projects
            </a>
        </li>

        <li>
            <a class="site-nav-link" href="/services.php"<?= nav_current_attr($currentPath, '/services.php') ?>>
                Services
            </a>
        </li>

        <li>
            <a class="site-nav-link" href="/resume.php"<?= nav_current_attr($currentPath, '/resume.php') ?>>
                Resume
            </a>
        </li>

        <li>
            <a class="site-nav-link" href="/about.php"<?= nav_current_attr($currentPath, '/about.php') ?>>
                About
            </a>
        </li>

        <li>
            <a class="site-nav-link" href="/blog/"<?= nav_current_attr($currentPath, '/blog') ?>>
                Blog
            </a>
        </li>

        <li>
            <a class="site-nav-link" href="/contact.php"<?= nav_current_attr($currentPath, '/contact.php') ?>>
                Contact
            </a>
        </li>

        <li>
            <a
                class="site-nav-link"
                href="https://www.linkedin.com/in/nickolaspatino"
                target="_blank"
                rel="noopener"
                aria-label="LinkedIn profile opens in a new tab"
            >
                <img
                    src="/assets/images/linkedin-48.png"
                    alt=""
                    width="24"
                    height="24"
                    aria-hidden="true"
                >
                <span class="visually-hidden">LinkedIn</span>
            </a>
        </li>
    </ul>
</nav>