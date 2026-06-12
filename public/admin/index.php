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

$pageTitle = "Nickolas Patino | Admin Dashboard";
$pageDescription = "Admin dashboard for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminDashboardHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function getDashboardCount(PDO $pdo, string $sql): int
{
    $statement = $pdo->query($sql);

    return (int) $statement->fetchColumn();
}

function formatDashboardDate(?string $value): string
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

$counts = [
    'total_posts' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_posts
        WHERE deleted_at IS NULL
    "),
    'published_posts' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_posts
        WHERE status = 'published'
            AND deleted_at IS NULL
    "),
    'draft_posts' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_posts
        WHERE status = 'draft'
            AND deleted_at IS NULL
    "),
    'scheduled_posts' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_posts
        WHERE status = 'scheduled'
            AND deleted_at IS NULL
    "),
    'archived_posts' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_posts
        WHERE status = 'archived'
            AND deleted_at IS NULL
    "),
    'media_items' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_media
        WHERE deleted_at IS NULL
    "),
    'categories' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_categories
        WHERE is_active = 1
    "),
    'tags' => getDashboardCount($pdo, "
        SELECT COUNT(*)
        FROM blog_tags
    "),
];

$recentPostsStatement = $pdo->query("
    SELECT
        blog_posts.id,
        blog_posts.title,
        blog_posts.slug,
        blog_posts.status,
        blog_posts.published_at,
        blog_posts.updated_at,
        blog_categories.name AS category_name
    FROM blog_posts
    LEFT JOIN blog_categories
        ON blog_posts.category_id = blog_categories.id
    WHERE blog_posts.deleted_at IS NULL
    ORDER BY blog_posts.updated_at DESC
    LIMIT 3
");

$recentPosts = $recentPostsStatement->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="kn-stack">
                        <div class="kn-page-hero-content">
                            <p class="kn-small-text kn-text-primary">
                                Admin Dashboard
                            </p>

                            <h1>Admin.</h1>
                        </div>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Quick Actions</h2>
                            </div>

                            <div class="kn-button-group">
                                <a href="/admin/posts/create.php" class="kn-button kn-button-primary">Create Post</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary">Manage Posts</a>
                                <a href="/admin/media/" class="kn-button kn-button-secondary">Media</a>
                                <a href="/blog/" class="kn-button kn-button-ghost" target="_blank" rel="noopener">View Blog</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Blog Snapshot</h2>
                            </div>

                            <div class="kn-grid">
                                <article class="kn-card kn-stack kn-stack-tight">
                                    <h3><?php echo escapeAdminDashboardHtml((string) $counts['total_posts']); ?></h3>
                                    <p>Total</p>
                                </article>

                                <article class="kn-card kn-stack kn-stack-tight">
                                    <h3><?php echo escapeAdminDashboardHtml((string) $counts['published_posts']); ?></h3>
                                    <p>Published</p>
                                </article>

                                <article class="kn-card kn-stack kn-stack-tight">
                                    <h3><?php echo escapeAdminDashboardHtml((string) $counts['draft_posts']); ?></h3>
                                    <p>Drafts</p>
                                </article>

                                <article class="kn-card kn-stack kn-stack-tight">
                                    <h3><?php echo escapeAdminDashboardHtml((string) $counts['scheduled_posts']); ?></h3>
                                    <p>Scheduled</p>
                                </article>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Recent Posts</h2>
                            </div>

                            <?php if ($recentPosts): ?>
                                <div class="kn-stack kn-stack-tight">
                                    <?php foreach ($recentPosts as $post): ?>
                                        <article class="kn-card kn-stack kn-stack-tight">
                                            <div>
                                                <h3><?php echo escapeAdminDashboardHtml($post['title']); ?></h3>

                                                <p class="kn-small-text kn-text-muted">
                                                    <?php echo escapeAdminDashboardHtml(ucfirst($post['status'])); ?>

                                                    <?php if ($post['category_name']): ?>
                                                        • <?php echo escapeAdminDashboardHtml($post['category_name']); ?>
                                                    <?php endif; ?>

                                                    • Updated <?php echo escapeAdminDashboardHtml(formatDashboardDate($post['updated_at'])); ?>
                                                </p>
                                            </div>

                                            <div class="kn-button-group">
                                                <a href="/admin/posts/edit.php?id=<?php echo escapeAdminDashboardHtml((string) $post['id']); ?>" class="kn-button kn-button-primary">Edit</a>

                                                <?php if ($post['status'] === 'published'): ?>
                                                    <a href="/blog/<?php echo escapeAdminDashboardHtml($post['slug']); ?>" class="kn-button kn-button-secondary" target="_blank" rel="noopener">View</a>
                                                <?php endif; ?>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="kn-text-block">
                                    <p>
                                        No posts yet. Create the first post to start building the blog.
                                    </p>
                                </div>

                                <div class="kn-button-group">
                                    <a href="/admin/posts/create.php" class="kn-button kn-button-primary">Create First Post</a>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Signed In</h2>

                            <p>
                                <strong><?php echo escapeAdminDashboardHtml($currentUser['display_name']); ?></strong><br>
                                <?php echo escapeAdminDashboardHtml($currentUser['user_role']); ?> • <?php echo escapeAdminDashboardHtml($currentUser['account_status']); ?>
                            </p>

                            <?php if ($currentUser['last_login_at']): ?>
                                <p class="kn-small-text kn-text-muted">
                                    Last login: <?php echo escapeAdminDashboardHtml(formatDashboardDate($currentUser['last_login_at'])); ?>
                                </p>
                            <?php endif; ?>

                            <div class="kn-button-group">
                                <a href="/admin/logout.php" class="kn-button kn-button-secondary">Log Out</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Tools</h2>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/posts/" class="kn-button kn-button-primary kn-full-width">Posts</a>
                                <a href="/admin/media/" class="kn-button kn-button-secondary kn-full-width">Media Library</a>
                                <a href="/admin/categories/" class="kn-button kn-button-secondary kn-full-width">Categories</a>
                                <a href="/admin/tags/" class="kn-button kn-button-secondary kn-full-width">Tags</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Totals</h2>

                            <dl>
                                <dt>Media</dt>
                                <dd><?php echo escapeAdminDashboardHtml((string) $counts['media_items']); ?></dd>

                                <dt>Categories</dt>
                                <dd><?php echo escapeAdminDashboardHtml((string) $counts['categories']); ?></dd>

                                <dt>Tags</dt>
                                <dd><?php echo escapeAdminDashboardHtml((string) $counts['tags']); ?></dd>

                                <dt>Archived</dt>
                                <dd><?php echo escapeAdminDashboardHtml((string) $counts['archived_posts']); ?></dd>
                            </dl>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Preview</h2>

                            <div class="kn-button-group">
                                <a href="/blog/" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Blog</a>
                                <a href="/" class="kn-button kn-button-ghost" target="_blank" rel="noopener">Website</a>
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