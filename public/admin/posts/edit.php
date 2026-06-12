<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/10/2026
    Updated: 06/10/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "admin";

require_once $projectRoot . '/config/session.php';
require_once $projectRoot . '/config/nickolaspatino_db.php';
require_once $projectRoot . '/src/admin_auth.php';

$pageTitle = "Nickolas Patino | Edit Blog Post";
$pageDescription = "Edit a blog post for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminEditPostHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function renderAdminEditPostHelp(string $id, string $text): string
{
    $safeId = preg_replace('/[^a-zA-Z0-9_-]/', '', $id) ?: 'kn-field-help';
    $safeText = escapeAdminEditPostHtml($text);

    return '
        <span
            class="kn-field-help"
            tabindex="0"
            aria-describedby="' . $safeId . '"
            aria-label="Field help"
        >
            <span class="kn-field-help-icon" aria-hidden="true">ⓘ</span>
            <span id="' . $safeId . '" class="kn-field-help-tooltip" role="tooltip">
                ' . $safeText . '
            </span>
        </span>
    ';
}

function cleanAdminEditPostText(string $value): string
{
    return trim(strip_tags($value));
}

function sendAdminEditPostJson(array $payload, int $statusCode = 200): never
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($payload);

    exit();
}

function isValidAdminEditPostCsrfToken(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

function sanitizeAdminEditPostHtml(string $html): string
{
    $html = str_replace("\0", '', $html);

    $html = preg_replace(
        '#<(script|style|iframe|object|embed|form|input|button|meta|link|base)[^>]*>.*?</\1>#is',
        '',
        $html
    ) ?? $html;

    $html = preg_replace(
        '#<(script|style|iframe|object|embed|form|input|button|meta|link|base)[^>]*/?>#is',
        '',
        $html
    ) ?? $html;

    $allowedTags = '<p><br><strong><b><em><i><u><s><a><ul><ol><li><blockquote><pre><code><h2><h3><h4><hr><img><figure><figcaption>';

    $html = strip_tags($html, $allowedTags);

    $html = preg_replace('/\s+on[a-z]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $html) ?? $html;
    $html = preg_replace('/\s+style\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $html) ?? $html;
    $html = preg_replace('/\s+(href|src)\s*=\s*("|\')\s*(javascript:|data:|vbscript:)[^"\']*\2/i', '', $html) ?? $html;
    $html = preg_replace('/\s+(href|src)\s*=\s*(javascript:|data:|vbscript:)[^\s>]*/i', '', $html) ?? $html;

    return trim($html);
}

function makeAdminEditPostSlug(string $value): string
{
    $slug = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug) ?? '';
    $slug = trim($slug, '-');

    if ($slug === '') {
        $slug = 'post-' . date('YmdHis');
    }

    return substr($slug, 0, 190);
}

function makeUniqueAdminEditPostSlug(PDO $pdo, string $baseSlug, int $postId): string
{
    $baseSlug = substr($baseSlug, 0, 180);
    $slug = $baseSlug;
    $counter = 2;

    while (true) {
        $slugStatement = $pdo->prepare("
            SELECT COUNT(*)
            FROM blog_posts
            WHERE slug = :slug
                AND id != :id
        ");

        $slugStatement->execute([
            ':slug' => $slug,
            ':id' => $postId,
        ]);

        if ((int) $slugStatement->fetchColumn() === 0) {
            return $slug;
        }

        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }
}

function convertAdminEditPostDateTime(?string $value): ?string
{
    $value = trim((string) $value);

    if ($value === '') {
        return null;
    }

    $date = DateTime::createFromFormat('Y-m-d\TH:i', $value);

    if (!$date) {
        return null;
    }

    return $date->format('Y-m-d H:i:s');
}

function formatAdminEditPostDateTimeInput(?string $value): string
{
    if (!$value) {
        return '';
    }

    $timestamp = strtotime($value);

    if (!$timestamp) {
        return '';
    }

    return date('Y-m-d\TH:i', $timestamp);
}

function formatAdminEditPostDisplayDate(?string $value): string
{
    if (!$value) {
        return 'Not set';
    }

    $timestamp = strtotime($value);

    if (!$timestamp) {
        return 'Not set';
    }

    return date('M j, Y g:i A', $timestamp);
}

function normalizeAdminEditPostMediaExtension(string $extension): string
{
    $extension = strtolower(trim($extension));

    if ($extension === 'jpeg') {
        return 'jpg';
    }

    return $extension;
}

function makeAdminEditPostMediaFileName(string $extension): string
{
    return date('YmdHis') . '-' . bin2hex(random_bytes(8)) . '.' . $extension;
}

function handleAdminEditPostMediaUpload(PDO $pdo, array $currentUser): never
{
    $errors = [];
    $csrfToken = $_POST['csrf_token'] ?? '';
    $altText = cleanAdminEditPostText($_POST['alt_text'] ?? '');

    if (!isValidAdminEditPostCsrfToken($csrfToken)) {
        $errors[] = 'Your session expired. Please refresh the page and try again.';
    }

    if ($altText !== '' && strlen($altText) > 255) {
        $errors[] = 'Alt text must be 255 characters or fewer.';
    }

    if (empty($_FILES['media_file']) || !is_array($_FILES['media_file'])) {
        $errors[] = 'Choose an image to upload.';
    }

    if ($errors) {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => $errors,
        ], 422);
    }

    $file = $_FILES['media_file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file is larger than the server allows.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file is larger than the form allows.',
            UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'Choose an image to upload.',
            UPLOAD_ERR_NO_TMP_DIR => 'The server is missing a temporary upload folder.',
            UPLOAD_ERR_CANT_WRITE => 'The server could not write the uploaded file.',
            UPLOAD_ERR_EXTENSION => 'A server extension blocked the upload.',
        ];

        sendAdminEditPostJson([
            'success' => false,
            'errors' => [$uploadErrors[$file['error']] ?? 'The upload failed.'],
        ], 422);
    }

    $maxFileSizeBytes = 5 * 1024 * 1024;

    if ((int) $file['size'] > $maxFileSizeBytes) {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['File size must be 5 MB or smaller.'],
        ], 422);
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['The uploaded file could not be verified.'],
        ], 422);
    }

    $allowedMimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']) ?: '';

    if (!array_key_exists($mimeType, $allowedMimeTypes)) {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['Only JPG, PNG, GIF, and WEBP images are allowed.'],
        ], 422);
    }

    $imageInfo = @getimagesize($file['tmp_name']);

    if (!$imageInfo) {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['The uploaded file is not a valid image.'],
        ], 422);
    }

    $imageWidth = (int) $imageInfo[0];
    $imageHeight = (int) $imageInfo[1];

    $originalFileName = basename((string) $file['name']);
    $extension = normalizeAdminEditPostMediaExtension($allowedMimeTypes[$mimeType]);

    $uploadYear = date('Y');
    $uploadMonth = date('m');

    $uploadDirectory = $_SERVER['DOCUMENT_ROOT']
        . DIRECTORY_SEPARATOR . 'assets'
        . DIRECTORY_SEPARATOR . 'uploads'
        . DIRECTORY_SEPARATOR . 'blog'
        . DIRECTORY_SEPARATOR . $uploadYear
        . DIRECTORY_SEPARATOR . $uploadMonth;

    if (!is_dir($uploadDirectory)) {
        @mkdir($uploadDirectory, 0775, true);
    }

    if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory)) {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['The upload folder is missing or not writable.'],
        ], 500);
    }

    $storedFileName = makeAdminEditPostMediaFileName($extension);
    $targetPath = $uploadDirectory . DIRECTORY_SEPARATOR . $storedFileName;
    $publicFilePath = '/assets/uploads/blog/' . $uploadYear . '/' . $uploadMonth . '/' . $storedFileName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['The image could not be saved.'],
        ], 500);
    }

    try {
        $insertMediaStatement = $pdo->prepare("
            INSERT INTO blog_media (
                uploaded_by_user_id,
                file_path,
                file_name,
                original_file_name,
                mime_type,
                file_extension,
                file_size_bytes,
                width,
                height,
                alt_text,
                status
            ) VALUES (
                :uploaded_by_user_id,
                :file_path,
                :file_name,
                :original_file_name,
                :mime_type,
                :file_extension,
                :file_size_bytes,
                :width,
                :height,
                :alt_text,
                'active'
            )
        ");

        $insertMediaStatement->execute([
            ':uploaded_by_user_id' => (int) $currentUser['id'],
            ':file_path' => $publicFilePath,
            ':file_name' => $storedFileName,
            ':original_file_name' => $originalFileName,
            ':mime_type' => $mimeType,
            ':file_extension' => $extension,
            ':file_size_bytes' => (int) $file['size'],
            ':width' => $imageWidth,
            ':height' => $imageHeight,
            ':alt_text' => $altText !== '' ? $altText : null,
        ]);

        sendAdminEditPostJson([
            'success' => true,
            'media_id' => (int) $pdo->lastInsertId(),
            'file_path' => $publicFilePath,
            'alt_text' => $altText,
        ]);
    } catch (Throwable $exception) {
        if (file_exists($targetPath)) {
            @unlink($targetPath);
        }

        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['The media record could not be saved. Please try again.'],
        ], 500);
    }
}

function syncAdminEditPostInlineMedia(PDO $pdo, int $postId, string $contentHtml): void
{
    $deleteInlineMediaStatement = $pdo->prepare("
        DELETE FROM blog_post_media
        WHERE post_id = :post_id
            AND usage_type = 'inline'
    ");

    $deleteInlineMediaStatement->execute([
        ':post_id' => $postId,
    ]);

    preg_match_all('/<img[^>]+src\s*=\s*["\']([^"\']+)["\']/i', $contentHtml, $matches);

    if (empty($matches[1])) {
        return;
    }

    $imagePaths = array_values(array_unique($matches[1]));

    $findMediaStatement = $pdo->prepare("
        SELECT id
        FROM blog_media
        WHERE file_path = :file_path
        LIMIT 1
    ");

    $insertPostMediaStatement = $pdo->prepare("
        INSERT IGNORE INTO blog_post_media (
            post_id,
            media_id,
            usage_type,
            sort_order
        ) VALUES (
            :post_id,
            :media_id,
            'inline',
            :sort_order
        )
    ");

    foreach ($imagePaths as $index => $imagePath) {
        $findMediaStatement->execute([
            ':file_path' => $imagePath,
        ]);

        $mediaId = (int) $findMediaStatement->fetchColumn();

        if ($mediaId <= 0) {
            continue;
        }

        $insertPostMediaStatement->execute([
            ':post_id' => $postId,
            ':media_id' => $mediaId,
            ':sort_order' => $index,
        ]);
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (($_GET['action'] ?? '') === 'upload-media') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendAdminEditPostJson([
            'success' => false,
            'errors' => ['Invalid upload request.'],
        ], 405);
    }

    handleAdminEditPostMediaUpload($pdo, $currentUser);
}

$postId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;
}

if ($postId <= 0) {
    header('Location: /admin/posts/', true, 303);
    exit();
}

$postStatement = $pdo->prepare("
    SELECT
        id,
        author_user_id,
        category_id,
        featured_media_id,
        title,
        slug,
        excerpt,
        content_html,
        content_text,
        status,
        is_featured,
        allow_indexing,
        seo_title,
        seo_description,
        canonical_url,
        published_at,
        created_at,
        updated_at,
        deleted_at
    FROM blog_posts
    WHERE id = :id
        AND deleted_at IS NULL
    LIMIT 1
");

$postStatement->execute([
    ':id' => $postId,
]);

$post = $postStatement->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header('Location: /admin/posts/?missing=1', true, 303);
    exit();
}

$categoriesStatement = $pdo->query("
    SELECT
        id,
        name
    FROM blog_categories
    WHERE is_active = 1
    ORDER BY sort_order ASC, name ASC
");

$categories = $categoriesStatement->fetchAll(PDO::FETCH_ASSOC);

$categoryIds = [];

foreach ($categories as $category) {
    $categoryIds[] = (int) $category['id'];
}

$validStatuses = [
    'draft',
    'published',
    'scheduled',
    'archived',
];

$errors = [];

$title = $post['title'];
$slug = $post['slug'];
$excerpt = $post['excerpt'] ?? '';
$contentHtml = $post['content_html'];
$status = $post['status'];
$categoryId = $post['category_id'] ? (int) $post['category_id'] : 0;
$publishedAtInput = formatAdminEditPostDateTimeInput($post['published_at']);
$seoTitle = $post['seo_title'] ?? '';
$seoDescription = $post['seo_description'] ?? '';
$canonicalUrl = $post['canonical_url'] ?? '';
$isFeatured = (bool) $post['is_featured'];
$allowIndexing = (bool) $post['allow_indexing'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';

    $title = cleanAdminEditPostText($_POST['title'] ?? '');
    $slug = cleanAdminEditPostText($_POST['slug'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $contentHtml = trim($_POST['content_html'] ?? '');
    $status = cleanAdminEditPostText($_POST['status'] ?? 'draft');
    $categoryId = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
    $publishedAtInput = trim($_POST['published_at'] ?? '');
    $seoTitle = cleanAdminEditPostText($_POST['seo_title'] ?? '');
    $seoDescription = cleanAdminEditPostText($_POST['seo_description'] ?? '');
    $canonicalUrl = trim($_POST['canonical_url'] ?? '');
    $isFeatured = isset($_POST['is_featured']) && $_POST['is_featured'] === '1';
    $allowIndexing = isset($_POST['allow_indexing']) && $_POST['allow_indexing'] === '1';

    if (!isValidAdminEditPostCsrfToken($csrfToken)) {
        $errors[] = 'Your session expired. Please refresh the page and try again.';
    }

    if ($title === '') {
        $errors[] = 'Title is required.';
    }

    if (strlen($title) > 190) {
        $errors[] = 'Title must be 190 characters or fewer.';
    }

    if ($slug !== '' && strlen($slug) > 190) {
        $errors[] = 'Slug must be 190 characters or fewer.';
    }

    if (!in_array($status, $validStatuses, true)) {
        $errors[] = 'Choose a valid post status.';
    }

    if ($categoryId > 0 && !in_array($categoryId, $categoryIds, true)) {
        $errors[] = 'Choose a valid category.';
    }

    if ($seoTitle !== '' && strlen($seoTitle) > 190) {
        $errors[] = 'SEO title must be 190 characters or fewer.';
    }

    if ($seoDescription !== '' && strlen($seoDescription) > 300) {
        $errors[] = 'SEO description must be 300 characters or fewer.';
    }

    if ($canonicalUrl !== '' && strlen($canonicalUrl) > 500) {
        $errors[] = 'Canonical URL must be 500 characters or fewer.';
    }

    if ($canonicalUrl !== '' && !filter_var($canonicalUrl, FILTER_VALIDATE_URL)) {
        $errors[] = 'Canonical URL must be a valid full URL.';
    }

    $sanitizedContentHtml = sanitizeAdminEditPostHtml($contentHtml);
    $contentText = trim(html_entity_decode(strip_tags($sanitizedContentHtml), ENT_QUOTES, 'UTF-8'));

    if ($contentText === '') {
        $errors[] = 'Post content is required.';
    }

    $publishedAt = null;

    if ($status === 'published') {
        $publishedAt = convertAdminEditPostDateTime($publishedAtInput);

        if (!$publishedAt) {
            $publishedAt = $post['published_at'] ?: date('Y-m-d H:i:s');
        }
    }

    if ($status === 'scheduled') {
        $publishedAt = convertAdminEditPostDateTime($publishedAtInput);

        if (!$publishedAt) {
            $errors[] = 'Scheduled posts need a valid publish date and time.';
        }
    }

    if ($status === 'archived') {
        $publishedAt = convertAdminEditPostDateTime($publishedAtInput);
    }

    if ($status === 'draft') {
        $publishedAt = null;
    }

    if (!$errors) {
        $baseSlug = makeAdminEditPostSlug($slug !== '' ? $slug : $title);
        $uniqueSlug = makeUniqueAdminEditPostSlug($pdo, $baseSlug, $postId);

        $oldSlug = $post['slug'];
        $categoryValue = $categoryId > 0 ? $categoryId : null;
        $excerptValue = trim($excerpt) !== '' ? trim($excerpt) : null;
        $seoTitleValue = $seoTitle !== '' ? $seoTitle : null;
        $seoDescriptionValue = $seoDescription !== '' ? $seoDescription : null;
        $canonicalUrlValue = $canonicalUrl !== '' ? $canonicalUrl : null;

        try {
            $pdo->beginTransaction();

            $updatePostStatement = $pdo->prepare("
                UPDATE blog_posts
                SET
                    category_id = :category_id,
                    title = :title,
                    slug = :slug,
                    excerpt = :excerpt,
                    content_html = :content_html,
                    content_text = :content_text,
                    status = :status,
                    is_featured = :is_featured,
                    allow_indexing = :allow_indexing,
                    seo_title = :seo_title,
                    seo_description = :seo_description,
                    canonical_url = :canonical_url,
                    published_at = :published_at
                WHERE id = :id
                LIMIT 1
            ");

            $updatePostStatement->execute([
                ':category_id' => $categoryValue,
                ':title' => $title,
                ':slug' => $uniqueSlug,
                ':excerpt' => $excerptValue,
                ':content_html' => $sanitizedContentHtml,
                ':content_text' => $contentText,
                ':status' => $status,
                ':is_featured' => $isFeatured ? 1 : 0,
                ':allow_indexing' => $allowIndexing ? 1 : 0,
                ':seo_title' => $seoTitleValue,
                ':seo_description' => $seoDescriptionValue,
                ':canonical_url' => $canonicalUrlValue,
                ':published_at' => $publishedAt,
                ':id' => $postId,
            ]);

            $revisionNumberStatement = $pdo->prepare("
                SELECT COALESCE(MAX(revision_number), 0) + 1
                FROM blog_post_revisions
                WHERE post_id = :post_id
            ");

            $revisionNumberStatement->execute([
                ':post_id' => $postId,
            ]);

            $revisionNumber = (int) $revisionNumberStatement->fetchColumn();

            $insertRevisionStatement = $pdo->prepare("
                INSERT INTO blog_post_revisions (
                    post_id,
                    editor_user_id,
                    revision_number,
                    title,
                    excerpt,
                    content_html,
                    content_text,
                    seo_title,
                    seo_description,
                    revision_note
                ) VALUES (
                    :post_id,
                    :editor_user_id,
                    :revision_number,
                    :title,
                    :excerpt,
                    :content_html,
                    :content_text,
                    :seo_title,
                    :seo_description,
                    :revision_note
                )
            ");

            $insertRevisionStatement->execute([
                ':post_id' => $postId,
                ':editor_user_id' => (int) $currentUser['id'],
                ':revision_number' => $revisionNumber,
                ':title' => $title,
                ':excerpt' => $excerptValue,
                ':content_html' => $sanitizedContentHtml,
                ':content_text' => $contentText,
                ':seo_title' => $seoTitleValue,
                ':seo_description' => $seoDescriptionValue,
                ':revision_note' => 'Post updated',
            ]);

            syncAdminEditPostInlineMedia($pdo, $postId, $sanitizedContentHtml);

            if ($oldSlug !== $uniqueSlug) {
                $insertRedirectStatement = $pdo->prepare("
                    INSERT INTO blog_redirects (
                        old_path,
                        new_path,
                        http_status
                    ) VALUES (
                        :old_path,
                        :new_path,
                        301
                    )
                    ON DUPLICATE KEY UPDATE
                        new_path = VALUES(new_path),
                        http_status = VALUES(http_status)
                ");

                $insertRedirectStatement->execute([
                    ':old_path' => '/blog/' . $oldSlug,
                    ':new_path' => '/blog/' . $uniqueSlug,
                ]);
            }

            $pdo->commit();

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header('Location: /admin/posts/edit.php?id=' . $postId . '&updated=1', true, 303);
            exit();
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $errors[] = 'The post could not be updated. Please check the form and try again.';
        }
    }
}

$csrfToken = $_SESSION['csrf_token'];
$editorContentHtml = sanitizeAdminEditPostHtml($contentHtml);
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
                <div class="kn-split kn-split-sidebar kn-align-start">
                    <div class="kn-stack kn-stack-roomy">
                        <div class="kn-page-hero-content">
                            <p class="kn-small-text kn-text-primary">
                                Blog Admin
                            </p>

                            <h1>Edit post.</h1>

                            <p class="kn-lead">
                                Update this blog post's content, publishing status, and search metadata.
                            </p>

                            <div class="kn-button-group">
                                <a href="/admin/posts/" class="kn-button kn-button-secondary">Manage Posts</a>
                                <a href="/admin/posts/preview.php?id=<?php echo escapeAdminEditPostHtml((string) $postId); ?>" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Preview</a>

                                <?php if ($post['status'] === 'published'): ?>
                                    <a href="/blog/<?php echo escapeAdminEditPostHtml($post['slug']); ?>" class="kn-button kn-button-ghost" target="_blank" rel="noopener">View Public</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (isset($_GET['updated']) && $_GET['updated'] === '1'): ?>
                            <article class="kn-card kn-stack">
                                <h2>Post Updated</h2>

                                <p>
                                    The post was saved successfully.
                                </p>
                            </article>
                        <?php endif; ?>

                        <?php if ($errors): ?>
                            <article class="kn-card kn-stack">
                                <h2>Post Not Updated</h2>

                                <ul class="kn-feature-list">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo escapeAdminEditPostHtml($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        <?php endif; ?>

                        <form class="kn-form kn-stack" method="post" action="/admin/posts/edit.php?id=<?php echo escapeAdminEditPostHtml((string) $postId); ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeAdminEditPostHtml($csrfToken); ?>">
                            <input type="hidden" name="post_id" value="<?php echo escapeAdminEditPostHtml((string) $postId); ?>">

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2>Post Content</h2>
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label for="title">Title</label>

                                        <?php echo renderAdminEditPostHelp('help-title', 'Write a clear headline that tells readers what this post is about.'); ?>
                                    </div>

                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        maxlength="190"
                                        required
                                        value="<?php echo escapeAdminEditPostHtml($title); ?>"
                                    >
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label for="slug">Slug</label>

                                        <?php echo renderAdminEditPostHelp('help-slug', 'Optional. This controls the post URL. Change it only when you intentionally want a new URL.'); ?>
                                    </div>

                                    <input
                                        type="text"
                                        id="slug"
                                        name="slug"
                                        maxlength="190"
                                        value="<?php echo escapeAdminEditPostHtml($slug); ?>"
                                    >
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label for="excerpt">Excerpt</label>

                                        <?php echo renderAdminEditPostHelp('help-excerpt', 'Write one or two short sentences. This shows on the blog list and helps readers decide if they want to read the full post.'); ?>
                                    </div>

                                    <textarea
                                        id="excerpt"
                                        name="excerpt"
                                        rows="3"
                                        placeholder="Short summary for blog listings and previews"
                                    ><?php echo escapeAdminEditPostHtml($excerpt); ?></textarea>
                                </div>

                                <div class="kn-form-field" data-wysiwyg>
                                    <div class="kn-field-label-row">
                                        <label for="content_html">Content</label>

                                        <?php echo renderAdminEditPostHelp('help-content', 'Use Visual mode to edit normally, HTML mode to edit the saved markup, and Image to upload inline images.'); ?>
                                    </div>

                                    <div class="kn-card kn-stack kn-stack-tight" data-wysiwyg-toolbar>
                                        <div class="kn-button-group">
                                            <button class="kn-button kn-button-primary" type="button" data-action="toggle-editor-mode">Show HTML</button>

                                            <button class="kn-button kn-button-secondary" type="button" data-command="formatBlock" data-value="p">P</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="formatBlock" data-value="h2">H2</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="formatBlock" data-value="h3">H3</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="formatBlock" data-value="blockquote">Quote</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="formatBlock" data-value="pre">Code</button>
                                        </div>

                                        <div class="kn-button-group">
                                            <button class="kn-button kn-button-secondary" type="button" data-command="bold"><strong>B</strong></button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="italic"><em>I</em></button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="underline"><u>U</u></button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="insertUnorderedList">• List</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="insertOrderedList">1. List</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="createLink">Link</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-command="insertHorizontalRule">Rule</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="toggle-emoji-panel">Emoji</button>
                                            <button class="kn-button kn-button-primary" type="button" data-action="upload-image">Image</button>
                                        </div>

                                        <div class="kn-button-group" data-emoji-panel hidden>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="😀" aria-label="Insert grinning emoji">😀</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="😎" aria-label="Insert cool emoji">😎</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="😂" aria-label="Insert laugh emoji">😂</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🔥" aria-label="Insert fire emoji">🔥</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="✨" aria-label="Insert sparkles emoji">✨</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="💜" aria-label="Insert purple heart emoji">💜</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🧠" aria-label="Insert brain emoji">🧠</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="💻" aria-label="Insert laptop emoji">💻</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🛠️" aria-label="Insert tools emoji">🛠️</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="⚙️" aria-label="Insert gear emoji">⚙️</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🚀" aria-label="Insert rocket emoji">🚀</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="📌" aria-label="Insert pin emoji">📌</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="✅" aria-label="Insert check emoji">✅</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="❌" aria-label="Insert x emoji">❌</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="⚠️" aria-label="Insert warning emoji">⚠️</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🎮" aria-label="Insert game emoji">🎮</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🎲" aria-label="Insert dice emoji">🎲</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🐦" aria-label="Insert bird emoji">🐦</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="🛡️" aria-label="Insert shield emoji">🛡️</button>
                                            <button class="kn-button kn-button-secondary" type="button" data-action="insert-emoji" data-emoji-value="⚔️" aria-label="Insert swords emoji">⚔️</button>
                                        </div>
                                    </div>

                                    <div
                                        class="kn-card"
                                        data-editor-shell
                                        style="height: 24rem; min-height: 24rem; max-height: 24rem; width: 100%; box-sizing: border-box; overflow: hidden; padding: 0;"
                                    >
                                        <div
                                            contenteditable="true"
                                            data-wysiwyg-editor
                                            data-target="content_html"
                                            data-upload-endpoint="/admin/posts/edit.php?id=<?php echo escapeAdminEditPostHtml((string) $postId); ?>&action=upload-media"
                                            data-csrf-token="<?php echo escapeAdminEditPostHtml($csrfToken); ?>"
                                            aria-label="Blog post content editor"
                                            role="textbox"
                                            aria-multiline="true"
                                        ><?php echo $editorContentHtml !== '' ? $editorContentHtml : '<p><br></p>'; ?></div>

                                        <textarea
                                            id="content_html"
                                            name="content_html"
                                            rows="18"
                                        ><?php echo escapeAdminEditPostHtml($editorContentHtml); ?></textarea>
                                    </div>

                                    <p class="kn-small-text kn-text-muted">
                                        Basic HTML is allowed: paragraphs, headings, bold, italic, lists, links, quotes, code, horizontal rules, and uploaded images.
                                    </p>
                                </div>
                            </article>

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2>Publishing</h2>
                                </div>

                                <div class="kn-form-row">
                                    <div class="kn-form-field">
                                        <div class="kn-field-label-row">
                                            <label for="status">Status</label>

                                            <?php echo renderAdminEditPostHelp('help-status', 'Draft is hidden. Published is public. Scheduled goes live later. Archived hides an old post without deleting it.'); ?>
                                        </div>

                                        <select id="status" name="status">
                                            <option value="draft" <?php echo $status === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                            <option value="published" <?php echo $status === 'published' ? 'selected' : ''; ?>>Published</option>
                                            <option value="scheduled" <?php echo $status === 'scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                            <option value="archived" <?php echo $status === 'archived' ? 'selected' : ''; ?>>Archived</option>
                                        </select>
                                    </div>

                                    <div class="kn-form-field">
                                        <div class="kn-field-label-row">
                                            <label for="category_id">Category</label>

                                            <?php echo renderAdminEditPostHelp('help-category', 'Pick one broad topic for this post. Use categories for big groups like Web Development, Projects, or Career.'); ?>
                                        </div>

                                        <select id="category_id" name="category_id">
                                            <option value="0">Uncategorized</option>

                                            <?php foreach ($categories as $category): ?>
                                                <option
                                                    value="<?php echo escapeAdminEditPostHtml((string) $category['id']); ?>"
                                                    <?php echo (int) $category['id'] === $categoryId ? 'selected' : ''; ?>
                                                >
                                                    <?php echo escapeAdminEditPostHtml($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label for="published_at">Publish Date and Time</label>

                                        <?php echo renderAdminEditPostHelp('help-published-at', 'For published posts, leave this blank to keep or set publish time automatically. For scheduled posts, choose the future date and time.'); ?>
                                    </div>

                                    <input
                                        type="datetime-local"
                                        id="published_at"
                                        name="published_at"
                                        value="<?php echo escapeAdminEditPostHtml($publishedAtInput); ?>"
                                    >

                                    <p class="kn-small-text kn-text-muted">
                                        Leave blank for published posts to use the existing publish date or current date and time. Scheduled posts require this field.
                                    </p>
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label>
                                            <input
                                                type="checkbox"
                                                name="is_featured"
                                                value="1"
                                                <?php echo $isFeatured ? 'checked' : ''; ?>
                                            >
                                            Feature this post
                                        </label>

                                        <?php echo renderAdminEditPostHelp('help-featured', 'Use this for posts you want to highlight. Featured posts may appear more prominently on the blog.'); ?>
                                    </div>
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label>
                                            <input
                                                type="checkbox"
                                                name="allow_indexing"
                                                value="1"
                                                <?php echo $allowIndexing ? 'checked' : ''; ?>
                                            >
                                            Allow search engines to index this post
                                        </label>

                                        <?php echo renderAdminEditPostHelp('help-indexing', 'Leave this checked for normal public posts. Uncheck it only if you do not want search engines to show this post.'); ?>
                                    </div>
                                </div>
                            </article>

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2>SEO</h2>

                                    <p class="kn-small-text kn-text-muted">
                                        SEO fields are optional, but they can help control how the post appears in search results and link previews.
                                    </p>
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label for="seo_title">SEO Title</label>

                                        <?php echo renderAdminEditPostHelp('help-seo-title', 'Optional. Use this when the Google/search title should be different from the post title. Keep it clear, useful, and focused on the main topic.'); ?>
                                    </div>

                                    <input
                                        type="text"
                                        id="seo_title"
                                        name="seo_title"
                                        maxlength="190"
                                        value="<?php echo escapeAdminEditPostHtml($seoTitle); ?>"
                                        placeholder="Optional custom search result title"
                                    >
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label for="seo_description">SEO Description</label>

                                        <?php echo renderAdminEditPostHelp('help-seo-description', 'Optional. Write one or two short sentences that explain why someone should click this result. Do not stuff it with repeated keywords.'); ?>
                                    </div>

                                    <textarea
                                        id="seo_description"
                                        name="seo_description"
                                        rows="3"
                                        maxlength="300"
                                        placeholder="Optional custom search result description"
                                    ><?php echo escapeAdminEditPostHtml($seoDescription); ?></textarea>
                                </div>

                                <div class="kn-form-field">
                                    <div class="kn-field-label-row">
                                        <label for="canonical_url">Canonical URL</label>

                                        <?php echo renderAdminEditPostHelp('help-canonical-url', 'Optional. Only use this if the same content exists somewhere else and that other URL should be treated as the main version. Usually leave this blank.'); ?>
                                    </div>

                                    <input
                                        type="url"
                                        id="canonical_url"
                                        name="canonical_url"
                                        maxlength="500"
                                        value="<?php echo escapeAdminEditPostHtml($canonicalUrl); ?>"
                                        placeholder="Optional full canonical URL"
                                    >
                                </div>
                            </article>

                            <div class="kn-button-group">
                                <button class="kn-button kn-button-primary" type="submit">Save Changes</button>
                                <a href="/admin/posts/" class="kn-button kn-button-ghost">Cancel</a>
                            </div>
                        </form>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Post Details</h2>

                            <dl>
                                <dt>Status</dt>
                                <dd><?php echo escapeAdminEditPostHtml(ucfirst($post['status'])); ?></dd>

                                <dt>Created</dt>
                                <dd><?php echo escapeAdminEditPostHtml(formatAdminEditPostDisplayDate($post['created_at'])); ?></dd>

                                <dt>Updated</dt>
                                <dd><?php echo escapeAdminEditPostHtml(formatAdminEditPostDisplayDate($post['updated_at'])); ?></dd>

                                <dt>Published</dt>
                                <dd><?php echo escapeAdminEditPostHtml(formatAdminEditPostDisplayDate($post['published_at'])); ?></dd>
                            </dl>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminEditPostHtml($currentUser['display_name']); ?>.
                            </p>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/posts/" class="kn-button kn-button-primary kn-full-width">Manage Posts</a>
                                <a href="/admin/" class="kn-button kn-button-secondary kn-full-width">Dashboard</a>
                                <a href="/admin/logout.php" class="kn-button kn-button-ghost kn-full-width">Log Out</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Revision Tracking</h2>

                            <p>
                                Each save creates a revision record for this post.
                            </p>
                        </article>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <footer class="kn-site-footer">
        <div class="kn-container kn-site-footer-inner">
            <?php require_once $projectRoot . '/src/footer.php'; ?>
        </div>
    </footer>

    <script src="/assets/js/admin-wysiwyg.js?v=<?php echo date('YmdHi'); ?>"></script>
</body>
</html>