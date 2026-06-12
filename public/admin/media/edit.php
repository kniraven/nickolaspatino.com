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

$pageTitle = "Nickolas Patino | Edit Media";
$pageDescription = "Edit blog media for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminMediaEditHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function cleanAdminMediaEditText(string $value): string
{
    return trim(strip_tags($value));
}

function formatAdminMediaEditDate(?string $value): string
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

function formatAdminMediaEditFileSize(?int $bytes): string
{
    if (!$bytes || $bytes <= 0) {
        return 'Unknown';
    }

    $units = [
        'B',
        'KB',
        'MB',
        'GB',
    ];

    $size = (float) $bytes;
    $unitIndex = 0;

    while ($size >= 1024 && $unitIndex < count($units) - 1) {
        $size /= 1024;
        $unitIndex++;
    }

    return round($size, 2) . ' ' . $units[$unitIndex];
}

function isValidAdminMediaEditCsrfToken(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$mediaId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mediaId = isset($_POST['media_id']) ? (int) $_POST['media_id'] : 0;
}

if ($mediaId <= 0) {
    header('Location: /admin/media/', true, 303);
    exit();
}

$mediaStatement = $pdo->prepare("
    SELECT
        blog_media.id,
        blog_media.uploaded_by_user_id,
        blog_media.file_path,
        blog_media.file_name,
        blog_media.original_file_name,
        blog_media.mime_type,
        blog_media.file_extension,
        blog_media.file_size_bytes,
        blog_media.width,
        blog_media.height,
        blog_media.alt_text,
        blog_media.caption,
        blog_media.credit,
        blog_media.status,
        blog_media.created_at,
        blog_media.updated_at,
        blog_media.deleted_at,
        users.display_name AS uploaded_by_name
    FROM blog_media
    LEFT JOIN users
        ON blog_media.uploaded_by_user_id = users.id
    WHERE blog_media.id = :id
        AND blog_media.deleted_at IS NULL
    LIMIT 1
");

$mediaStatement->execute([
    ':id' => $mediaId,
]);

$media = $mediaStatement->fetch(PDO::FETCH_ASSOC);

if (!$media) {
    header('Location: /admin/media/?missing=1', true, 303);
    exit();
}

$validStatuses = [
    'active',
    'unused',
    'deleted',
];

$errors = [];

$altText = $media['alt_text'] ?? '';
$caption = $media['caption'] ?? '';
$credit = $media['credit'] ?? '';
$status = $media['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';

    $altText = cleanAdminMediaEditText($_POST['alt_text'] ?? '');
    $caption = trim($_POST['caption'] ?? '');
    $credit = cleanAdminMediaEditText($_POST['credit'] ?? '');
    $status = cleanAdminMediaEditText($_POST['status'] ?? 'active');

    if (!isValidAdminMediaEditCsrfToken($csrfToken)) {
        $errors[] = 'Your session expired. Please refresh the page and try again.';
    }

    if (!in_array($status, $validStatuses, true)) {
        $errors[] = 'Choose a valid media status.';
    }

    if ($altText !== '' && strlen($altText) > 255) {
        $errors[] = 'Alt text must be 255 characters or fewer.';
    }

    if ($credit !== '' && strlen($credit) > 255) {
        $errors[] = 'Credit must be 255 characters or fewer.';
    }

    if (!$errors) {
        try {
            $updateMediaStatement = $pdo->prepare("
                UPDATE blog_media
                SET
                    alt_text = :alt_text,
                    caption = :caption,
                    credit = :credit,
                    status = :status
                WHERE id = :id
                LIMIT 1
            ");

            $updateMediaStatement->execute([
                ':alt_text' => $altText !== '' ? $altText : null,
                ':caption' => trim($caption) !== '' ? trim($caption) : null,
                ':credit' => $credit !== '' ? $credit : null,
                ':status' => $status,
                ':id' => $mediaId,
            ]);

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header('Location: /admin/media/edit.php?id=' . $mediaId . '&updated=1', true, 303);
            exit();
        } catch (Throwable $exception) {
            $errors[] = 'The media item could not be updated. Please check the form and try again.';
        }
    }
}

$csrfToken = $_SESSION['csrf_token'];
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

                            <h1>Edit media.</h1>

                            <p class="kn-lead">
                                Update image metadata, alt text, caption, credit, and media status.
                            </p>

                            <div class="kn-button-group">
                                <a href="/admin/media/" class="kn-button kn-button-secondary">Media Library</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary">Manage Posts</a>
                                <a href="/admin/" class="kn-button kn-button-ghost">Admin Dashboard</a>
                            </div>
                        </div>

                        <?php if (isset($_GET['updated']) && $_GET['updated'] === '1'): ?>
                            <article class="kn-card kn-stack">
                                <h2>Media Updated</h2>

                                <p>
                                    The media item was saved successfully.
                                </p>
                            </article>
                        <?php endif; ?>

                        <?php if ($errors): ?>
                            <article class="kn-card kn-stack">
                                <h2>Media Not Updated</h2>

                                <ul class="kn-feature-list">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo escapeAdminMediaEditHtml($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        <?php endif; ?>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Preview</h2>
                            </div>

                            <?php if (strpos((string) $media['mime_type'], 'image/') === 0): ?>
                                <img
                                    src="<?php echo escapeAdminMediaEditHtml($media['file_path']); ?>"
                                    alt="<?php echo escapeAdminMediaEditHtml($altText ?: $media['original_file_name']); ?>"
                                >
                            <?php endif; ?>

                            <div class="kn-button-group">
                                <a
                                    href="<?php echo escapeAdminMediaEditHtml($media['file_path']); ?>"
                                    class="kn-button kn-button-secondary"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    Open File
                                </a>
                            </div>
                        </article>

                        <form class="kn-form kn-stack" method="post" action="/admin/media/edit.php?id=<?php echo escapeAdminMediaEditHtml((string) $mediaId); ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeAdminMediaEditHtml($csrfToken); ?>">
                            <input type="hidden" name="media_id" value="<?php echo escapeAdminMediaEditHtml((string) $mediaId); ?>">

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2>Media Details</h2>
                                </div>

                                <div class="kn-form-field">
                                    <label for="alt_text">Alt Text</label>
                                    <input
                                        type="text"
                                        id="alt_text"
                                        name="alt_text"
                                        maxlength="255"
                                        value="<?php echo escapeAdminMediaEditHtml($altText); ?>"
                                        placeholder="Describe the image for accessibility"
                                    >
                                </div>

                                <div class="kn-form-field">
                                    <label for="caption">Caption</label>
                                    <textarea
                                        id="caption"
                                        name="caption"
                                        rows="3"
                                        placeholder="Optional caption"
                                    ><?php echo escapeAdminMediaEditHtml($caption); ?></textarea>
                                </div>

                                <div class="kn-form-field">
                                    <label for="credit">Credit</label>
                                    <input
                                        type="text"
                                        id="credit"
                                        name="credit"
                                        maxlength="255"
                                        value="<?php echo escapeAdminMediaEditHtml($credit); ?>"
                                        placeholder="Optional image credit"
                                    >
                                </div>

                                <div class="kn-form-field">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="unused" <?php echo $status === 'unused' ? 'selected' : ''; ?>>Unused</option>
                                        <option value="deleted" <?php echo $status === 'deleted' ? 'selected' : ''; ?>>Deleted</option>
                                    </select>

                                    <p class="kn-small-text kn-text-muted">
                                        Deleted marks the media item as deleted in the library but does not remove the physical file.
                                    </p>
                                </div>
                            </article>

                            <div class="kn-button-group">
                                <button class="kn-button kn-button-primary" type="submit">Save Changes</button>
                                <a href="/admin/media/" class="kn-button kn-button-ghost">Cancel</a>
                            </div>
                        </form>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>File Details</h2>

                            <dl>
                                <dt>Original Name</dt>
                                <dd><?php echo escapeAdminMediaEditHtml($media['original_file_name']); ?></dd>

                                <dt>Stored Name</dt>
                                <dd><?php echo escapeAdminMediaEditHtml($media['file_name']); ?></dd>

                                <dt>Path</dt>
                                <dd><?php echo escapeAdminMediaEditHtml($media['file_path']); ?></dd>

                                <dt>MIME Type</dt>
                                <dd><?php echo escapeAdminMediaEditHtml($media['mime_type']); ?></dd>

                                <dt>File Size</dt>
                                <dd><?php echo escapeAdminMediaEditHtml(formatAdminMediaEditFileSize((int) $media['file_size_bytes'])); ?></dd>

                                <dt>Dimensions</dt>
                                <dd>
                                    <?php if ($media['width'] && $media['height']): ?>
                                        <?php echo escapeAdminMediaEditHtml((string) $media['width']); ?> × <?php echo escapeAdminMediaEditHtml((string) $media['height']); ?>
                                    <?php else: ?>
                                        Unknown
                                    <?php endif; ?>
                                </dd>

                                <dt>Uploaded By</dt>
                                <dd><?php echo escapeAdminMediaEditHtml($media['uploaded_by_name'] ?? 'Unknown'); ?></dd>

                                <dt>Uploaded</dt>
                                <dd><?php echo escapeAdminMediaEditHtml(formatAdminMediaEditDate($media['created_at'])); ?></dd>

                                <dt>Updated</dt>
                                <dd><?php echo escapeAdminMediaEditHtml(formatAdminMediaEditDate($media['updated_at'])); ?></dd>
                            </dl>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminMediaEditHtml($currentUser['display_name']); ?>.
                            </p>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/media/" class="kn-button kn-button-primary kn-full-width">Media Library</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary kn-full-width">Manage Posts</a>
                                <a href="/admin/" class="kn-button kn-button-secondary kn-full-width">Dashboard</a>
                                <a href="/admin/logout.php" class="kn-button kn-button-ghost kn-full-width">Log Out</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Usage Note</h2>

                            <p>
                                This page edits media metadata only. Upload new images from the blog post create/edit editor.
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
</body>
</html>