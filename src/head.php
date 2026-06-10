<?php
/**
 * Shared document head for NickolasPatino.com
 *
 * Expected variables that may be set before requiring this file:
 *
 * $pageTitle        string  Page title
 * $pageDescription  string  Meta description
 * $pageContent      string  Legacy fallback for meta description
 * $pageCss          string|array  Page-specific CSS file name(s), without path
 * $additionalCss    array   Extra CSS paths
 * $additionalJs     array   Extra JS paths
 * $additionalHead   string  Extra raw head content
 *
 * Example:
 * $pageTitle = "Nickolas Patino | Web Developer";
 * $pageDescription = "Nickolas Patino is a web developer...";
 * $pageCss = "home";
 * require_once $projectRoot . "/src/head.php";
 */


/* =========================================================
   Defaults
   ========================================================= */

$pageTitle = $pageTitle ?? "Nickolas Patino | Web Developer";

$pageDescription = $pageDescription
    ?? $pageContent
    ?? "Nickolas Patino is a web developer and automation-focused problem solver.";

$pageCss = $pageCss ?? null;
$additionalCss = $additionalCss ?? [];
$additionalJs = $additionalJs ?? [];
$additionalHead = $additionalHead ?? "";


/* =========================================================
   Helper functions
   ========================================================= */

if (!function_exists('asset_version')) {
    /**
     * Adds a filemtime cache-busting query string when possible.
     * Example output: /assets/css/theme.css?v=1717780000
     */
    function asset_version(string $publicPath): string
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';

        if ($documentRoot !== '') {
            $filePath = rtrim($documentRoot, DIRECTORY_SEPARATOR) . $publicPath;

            if (is_file($filePath)) {
                return $publicPath . '?v=' . filemtime($filePath);
            }
        }

        return $publicPath;
    }
}

if (!function_exists('html_attr')) {
    /**
     * Escapes a value for safe use in HTML attributes.
     */
    function html_attr(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('normalize_page_css')) {
    /**
     * Converts page CSS input into an array.
     */
    function normalize_page_css(string|array|null $pageCss): array
    {
        if ($pageCss === null || $pageCss === '') {
            return [];
        }

        if (is_string($pageCss)) {
            return [$pageCss];
        }

        return $pageCss;
    }
}


/* =========================================================
   Normalize optional assets
   ========================================================= */

$pageCssFiles = normalize_page_css($pageCss);

if (!is_array($additionalCss)) {
    $additionalCss = [$additionalCss];
}

if (!is_array($additionalJs)) {
    $additionalJs = [$additionalJs];
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= html_attr($pageTitle) ?></title>
<meta name="description" content="<?= html_attr($pageDescription) ?>">

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">

<!-- Core CSS -->
<link rel="stylesheet" href="<?= html_attr(asset_version('/assets/css/structure.css')) ?>">
<link rel="stylesheet" href="<?= html_attr(asset_version('/assets/css/theme.css')) ?>">

<!-- Page-specific CSS -->
<?php foreach ($pageCssFiles as $cssFile): ?>
    <?php
        $cssFile = trim((string) $cssFile);

        if ($cssFile === '') {
            continue;
        }

        /*
         * Allows either:
         * $pageCss = "home";
         * or:
         * $pageCss = "home.css";
         */
        $cssFile = str_ends_with($cssFile, '.css') ? $cssFile : $cssFile . '.css';
        $cssPath = '/assets/css/pages/' . ltrim($cssFile, '/');
    ?>
    <link rel="stylesheet" href="<?= html_attr(asset_version($cssPath)) ?>">
<?php endforeach; ?>

<!-- Additional CSS -->
<?php foreach ($additionalCss as $cssPath): ?>
    <?php
        $cssPath = trim((string) $cssPath);

        if ($cssPath === '') {
            continue;
        }

        $cssPath = '/' . ltrim($cssPath, '/');
    ?>
    <link rel="stylesheet" href="<?= html_attr(asset_version($cssPath)) ?>">
<?php endforeach; ?>

<!-- Main JavaScript -->
<script src="<?= html_attr(asset_version('/assets/js/kniraven.js')) ?>" defer></script>

<!-- Additional JavaScript -->
<?php foreach ($additionalJs as $jsPath): ?>
    <?php
        $jsPath = trim((string) $jsPath);

        if ($jsPath === '') {
            continue;
        }

        $jsPath = '/' . ltrim($jsPath, '/');
    ?>
    <script src="<?= html_attr(asset_version($jsPath)) ?>" defer></script>
<?php endforeach; ?>

<!-- Additional page-specific head content -->
<?= $additionalHead ?>