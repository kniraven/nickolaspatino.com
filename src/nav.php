<?php
/**
 * Main navigation for NickolasPatino.com
 *
 * This file assumes it is being included inside:
 *
 * <header class="kn-site-header">
 *     <div class="kn-container kn-site-header-inner">
 *         <?php require_once $projectRoot . '/src/nav.php'; ?>
 *     </div>
 * </header>
 */


/* =========================================================
   Current page helpers
   ========================================================= */

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

if (!function_exists('kn_nav_is_active')) {
    function kn_nav_is_active(string $currentPath, string $targetPath): bool
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

if (!function_exists('kn_nav_current_attr')) {
    function kn_nav_current_attr(string $currentPath, string $targetPath): string
    {
        return kn_nav_is_active($currentPath, $targetPath) ? ' aria-current="page"' : '';
    }
}
?>

<a class="kn-site-brand" href="/" aria-label="Nickolas Patino home">
    <img
        src="/assets/images/logo-48x48.png"
        alt=""
        class="kn-site-brand-logo"
        width="48"
        height="48"
        aria-hidden="true"
    >
    <span>Nickolas&nbsp;Patino</span>
</a>

<nav class="kn-site-nav kn-noprint" aria-label="Main navigation">
    <button
        class="kn-nav-toggle"
        type="button"
        aria-controls="site-nav-list"
        aria-expanded="false"
        data-nav-toggle
    >
        <span class="kn-visually-hidden">Toggle navigation</span>
        <span aria-hidden="true">Menu</span>
    </button>

    <ul class="kn-site-nav-list" id="site-nav-list">
        <li>
            <a class="kn-site-nav-link" href="/"<?= kn_nav_current_attr($currentPath, '/') ?>>
                Home
            </a>
        </li>

        <li>
            <a class="kn-site-nav-link" href="/projects/"<?= kn_nav_current_attr($currentPath, '/projects') ?>>
                Projects
            </a>
        </li>

        <li>
            <a class="kn-site-nav-link" href="/resume.php"<?= kn_nav_current_attr($currentPath, '/resume.php') ?>>
                Resume
            </a>
        </li>

        <li>
            <a class="kn-site-nav-link" href="/services.php"<?= kn_nav_current_attr($currentPath, '/services.php') ?>>
                Services
            </a>
        </li>

        <li>
            <a class="kn-site-nav-link" href="/about.php"<?= kn_nav_current_attr($currentPath, '/about.php') ?>>
                About
            </a>
        </li>

        <li>
            <a class="kn-site-nav-link" href="/blog/"<?= kn_nav_current_attr($currentPath, '/blog') ?>>
                Blog
            </a>
        </li>

        <li>
            <a class="kn-site-nav-link" href="/contact.php"<?= kn_nav_current_attr($currentPath, '/contact.php') ?>>
                Contact
            </a>
        </li>

        <li>
            <a class="kn-site-nav-link" href="/business-cards.php"<?= kn_nav_current_attr($currentPath, '/business-cards.php') ?>>
                Card
            </a>
        </li>

        <li>
            <a
                class="kn-site-nav-link"
                href="https://www.linkedin.com/in/nickolaspatino"
                target="_blank"
                rel="noopener"
                aria-label="LinkedIn profile opens in a new tab"
            >
                LinkedIn
            </a>
        </li>
    </ul>
</nav>