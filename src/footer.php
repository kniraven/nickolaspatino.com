<?php
/**
 * Footer content for NickolasPatino.com
 *
 * This file assumes it is being included inside:
 *
 * <footer class="kn-site-footer">
 *     <div class="kn-container kn-site-footer-inner">
 *         <?php require_once $projectRoot . '/src/footer.php'; ?>
 *     </div>
 * </footer>
 */
?>

<div class="kn-stack">
    <p class="kn-small-text">
        © 2018-<?= date("Y"); ?> Nickolas D. Patino. All rights reserved.
    </p>

    <p class="kn-small-text kn-text-muted">
        Web developer and automation-focused problem solver based near Madison, Wisconsin.
    </p>
</div>

<nav class="kn-inline-list kn-noprint" aria-label="Footer navigation">
    <a class="kn-site-nav-link" href="/">Home</a>
    <a class="kn-site-nav-link" href="/projects/">Projects</a>
    <a class="kn-site-nav-link" href="/services.php">Services</a>
    <a class="kn-site-nav-link" href="/resume.php">Resume</a>
    <a class="kn-site-nav-link" href="/about.php">About</a>
    <a class="kn-site-nav-link" href="/blog/">Blog</a>
    <a class="kn-site-nav-link" href="/contact.php">Contact</a>

    <a
        class="kn-site-nav-link"
        href="https://www.linkedin.com/in/nickolaspatino"
        target="_blank"
        rel="noopener"
        aria-label="LinkedIn profile opens in a new tab"
    >
        LinkedIn
    </a>
</nav>

<script src="/assets/js/kn-grid-snakes.js" defer></script>