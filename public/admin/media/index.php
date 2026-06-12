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

$pageTitle = "Nickolas Patino | Media Library";
$pageDescription = "Manage blog media for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminMediaHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function formatAdminMediaDate(?string $value): string
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

function formatAdminMediaFileSize(?int $bytes): string
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

$validStatuses = [
    'all',
    'active',
    'unused',
    'deleted',
];

$statusFilter = $_GET['status'] ?? 'all';

if (!in_array($statusFilter, $validStatuses, true)) {
    $statusFilter = 'all';
}

$searchQuery = trim($_GET['q'] ?? '');

$mediaCountStatement = $pdo->query("
    SELECT
        status,
        COUNT(*) AS media_count
    FROM blog_media
    WHERE deleted_at IS NULL
    GROUP BY status
");

$statusCounts = [
    'active' => 0,
    'unused' => 0,
    'deleted' => 0,
];

foreach ($mediaCountStatement->fetchAll(PDO::FETCH_ASSOC) as $statusCount) {
    $statusCounts[$statusCount['status']] = (int) $statusCount['media_count'];
}

$totalMediaCount = array_sum($statusCounts);

$whereClauses = [
    'blog_media.deleted_at IS NULL',
];

$queryParams = [];

if ($statusFilter !== 'all') {
    $whereClauses[] = 'blog_media.status = :status';
    $queryParams[':status'] = $statusFilter;
}

if ($searchQuery !== '') {
    $whereClauses[] = "(
        blog_media.file_name LIKE :search
        OR blog_media.original_file_name LIKE :search
        OR blog_media.alt_text LIKE :search
        OR blog_media.caption LIKE :search
        OR blog_media.credit LIKE :search
    )";

    $queryParams[':search'] = '%' . $searchQuery . '%';
}

$whereSql = implode(' AND ', $whereClauses);

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
        users.display_name AS uploaded_by_name
    FROM blog_media
    LEFT JOIN users
        ON blog_media.uploaded_by_user_id = users.id
    WHERE {$whereSql}
    ORDER BY blog_media.created_at DESC
    LIMIT 100
");

$mediaStatement->execute($queryParams);

$mediaItems = $mediaStatement->fetchAll(PDO::FETCH_ASSOC);
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

                            <h1>Media library.</h1>

                            <p class="kn-lead">
                                Manage uploaded blog images and media metadata.
                            </p>

                            <div class="kn-button-group">
                                <a href="/admin/posts/" class="kn-button kn-button-primary">Manage Posts</a>
                                <a href="/admin/posts/create.php" class="kn-button kn-button-secondary">Create Post</a>
                                <a href="/admin/" class="kn-button kn-button-ghost">Admin Dashboard</a>
                            </div>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminMediaHtml((string) $totalMediaCount); ?></h2>
                                <p>Total Media</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminMediaHtml((string) $statusCounts['active']); ?></h2>
                                <p>Active</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminMediaHtml((string) $statusCounts['unused']); ?></h2>
                                <p>Unused</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminMediaHtml((string) $statusCounts['deleted']); ?></h2>
                                <p>Deleted</p>
                            </article>
                        </div>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Media Filters</h2>

                                <p>
                                    Filter media by status or keyword.
                                </p>
                            </div>

                            <form class="kn-form" method="get" action="/admin/media/">
                                <div class="kn-form-row">
                                    <div class="kn-form-field">
                                        <label for="status">Status</label>
                                        <select id="status" name="status">
                                            <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All statuses</option>
                                            <option value="active" <?php echo $statusFilter === 'active' ? 'selected' : ''; ?>>Active</option>
                                            <option value="unused" <?php echo $statusFilter === 'unused' ? 'selected' : ''; ?>>Unused</option>
                                            <option value="deleted" <?php echo $statusFilter === 'deleted' ? 'selected' : ''; ?>>Deleted</option>
                                        </select>
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="q">Search</label>
                                        <input
                                            type="search"
                                            id="q"
                                            name="q"
                                            maxlength="190"
                                            value="<?php echo escapeAdminMediaHtml($searchQuery); ?>"
                                            placeholder="Search filename, alt text, caption, or credit"
                                        >
                                    </div>
                                </div>

                                <div class="kn-button-group">
                                    <button class="kn-button kn-button-primary" type="submit">Apply Filters</button>
                                    <a href="/admin/media/" class="kn-button kn-button-ghost">Clear Filters</a>
                                </div>
                            </form>
                        </article>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Media Items</h2>

                                <p>
                                    Showing up to 100 media items ordered by most recently uploaded.
                                </p>
                            </div>

                            <?php if ($mediaItems): ?>
                                <div class="kn-grid">
                                    <?php foreach ($mediaItems as $media): ?>
                                        <article class="kn-card kn-stack">
                                            <?php if (strpos((string) $media['mime_type'], 'image/') === 0): ?>
                                                <img
                                                    src="<?php echo escapeAdminMediaHtml($media['file_path']); ?>"
                                                    alt="<?php echo escapeAdminMediaHtml($media['alt_text'] ?: $media['original_file_name']); ?>"
                                                >
                                            <?php endif; ?>

                                            <div class="kn-stack kn-stack-tight">
                                                <div>
                                                    <p class="kn-small-text kn-text-primary">
                                                        <?php echo escapeAdminMediaHtml(ucfirst($media['status'])); ?>
                                                    </p>

                                                    <h3><?php echo escapeAdminMediaHtml($media['original_file_name']); ?></h3>

                                                    <p class="kn-small-text kn-text-muted">
                                                        <?php echo escapeAdminMediaHtml($media['mime_type']); ?>
                                                        • <?php echo escapeAdminMediaHtml(formatAdminMediaFileSize((int) $media['file_size_bytes'])); ?>
                                                    </p>
                                                </div>

                                                <?php if ($media['alt_text']): ?>
                                                    <p>
                                                        <strong>Alt:</strong> <?php echo escapeAdminMediaHtml($media['alt_text']); ?>
                                                    </p>
                                                <?php endif; ?>

                                                <?php if ($media['caption']): ?>
                                                    <p>
                                                        <?php echo escapeAdminMediaHtml($media['caption']); ?>
                                                    </p>
                                                <?php endif; ?>

                                                <dl>
                                                    <dt>Stored File</dt>
                                                    <dd><?php echo escapeAdminMediaHtml($media['file_name']); ?></dd>

                                                    <dt>Dimensions</dt>
                                                    <dd>
                                                        <?php if ($media['width'] && $media['height']): ?>
                                                            <?php echo escapeAdminMediaHtml((string) $media['width']); ?> × <?php echo escapeAdminMediaHtml((string) $media['height']); ?>
                                                        <?php else: ?>
                                                            Unknown
                                                        <?php endif; ?>
                                                    </dd>

                                                    <dt>Uploaded By</dt>
                                                    <dd><?php echo escapeAdminMediaHtml($media['uploaded_by_name'] ?? 'Unknown'); ?></dd>

                                                    <dt>Uploaded</dt>
                                                    <dd><?php echo escapeAdminMediaHtml(formatAdminMediaDate($media['created_at'])); ?></dd>
                                                </dl>
                                            </div>

                                            <div class="kn-button-group">
                                                <a href="/admin/media/edit.php?id=<?php echo escapeAdminMediaHtml((string) $media['id']); ?>" class="kn-button kn-button-primary">Edit</a>
                                                <a href="<?php echo escapeAdminMediaHtml($media['file_path']); ?>" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Open</a>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="kn-card kn-stack">
                                    <h3>No media found.</h3>

                                    <p>
                                        No media items match the current filters.
                                    </p>

                                    <div class="kn-button-group">
                                        <a href="/admin/posts/create.php" class="kn-button kn-button-primary">Create Post</a>
                                        <a href="/admin/media/" class="kn-button kn-button-ghost">Clear Filters</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Media Actions</h2>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/posts/" class="kn-button kn-button-primary kn-full-width">Manage Posts</a>
                                <a href="/admin/posts/create.php" class="kn-button kn-button-secondary kn-full-width">Create Post</a>
                                <a href="/admin/" class="kn-button kn-button-secondary kn-full-width">Dashboard</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Status Filters</h2>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/media/?status=all" class="kn-button kn-button-secondary kn-full-width">All Media</a>
                                <a href="/admin/media/?status=active" class="kn-button kn-button-secondary kn-full-width">Active</a>
                                <a href="/admin/media/?status=unused" class="kn-button kn-button-secondary kn-full-width">Unused</a>
                                <a href="/admin/media/?status=deleted" class="kn-button kn-button-secondary kn-full-width">Deleted</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminMediaHtml($currentUser['display_name']); ?>.
                            </p>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/" class="kn-button kn-button-secondary kn-full-width">Dashboard</a>
                                <a href="/admin/logout.php" class="kn-button kn-button-ghost kn-full-width">Log Out</a>
                            </div>
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