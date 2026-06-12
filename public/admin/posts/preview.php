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

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminPreviewPostHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function formatAdminPreviewPostDate(?string $value): string
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

$postId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($postId <= 0) {
    header('Location: /admin/posts/', true, 303);
    exit();
}

$postStatement = $pdo->prepare("
    SELECT
        blog_posts.id,
        blog_posts.author_user_id,
        blog_posts.category_id,
        blog_posts.featured_media_id,
        blog_posts.title,
        blog_posts.slug,
        blog_posts.excerpt,
        blog_posts.content_html,
        blog_posts.content_text,
        blog_posts.status,
        blog_posts.is_featured,
        blog_posts.allow_indexing,
        blog_posts.seo_title,
        blog_posts.seo_description,
        blog_posts.canonical_url,
        blog_posts.published_at,
        blog_posts.created_at,
        blog_posts.updated_at,
        blog_categories.name AS category_name,
        users.display_name AS author_name,
        blog_media.file_path AS featured_media_path,
        blog_media.alt_text AS featured_media_alt,
        blog_media.caption AS featured_media_caption
    FROM blog_posts
    INNER JOIN users
        ON blog_posts.author_user_id = users.id
    LEFT JOIN blog_categories
        ON blog_posts.category_id = blog_categories.id
    LEFT JOIN blog_media
        ON blog_posts.featured_media_id = blog_media.id
    WHERE blog_posts.id = :id
        AND blog_posts.deleted_at IS NULL
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

$tagStatement = $pdo->prepare("
    SELECT
        blog_tags.name,
        blog_tags.slug
    FROM blog_post_tags
    INNER JOIN blog_tags
        ON blog_post_tags.tag_id = blog_tags.id
    WHERE blog_post_tags.post_id = :post_id
    ORDER BY blog_tags.name ASC
");

$tagStatement->execute([
    ':post_id' => $postId,
]);

$tags = $tagStatement->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Preview | " . $post['title'];
$pageDescription = $post['seo_description'] ?: ($post['excerpt'] ?: "Preview a blog post for NickolasPatino.com.");
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
                    <article class="kn-card kn-stack">
                        <div class="kn-page-hero-content">
                            <p class="kn-small-text kn-text-primary">
                                Admin Preview
                            </p>

                            <h1><?php echo escapeAdminPreviewPostHtml($post['title']); ?></h1>

                            <?php if ($post['excerpt']): ?>
                                <p class="kn-lead">
                                    <?php echo escapeAdminPreviewPostHtml($post['excerpt']); ?>
                                </p>
                            <?php endif; ?>

                            <div class="kn-button-group">
                                <a href="/admin/posts/edit.php?id=<?php echo escapeAdminPreviewPostHtml((string) $post['id']); ?>" class="kn-button kn-button-primary">Edit Post</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary">Manage Posts</a>

                                <?php if ($post['status'] === 'published'): ?>
                                    <a href="/blog/<?php echo escapeAdminPreviewPostHtml($post['slug']); ?>" class="kn-button kn-button-ghost" target="_blank" rel="noopener">View Public</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($post['featured_media_path']): ?>
                            <figure class="kn-card kn-stack">
                                <img
                                    src="<?php echo escapeAdminPreviewPostHtml($post['featured_media_path']); ?>"
                                    alt="<?php echo escapeAdminPreviewPostHtml($post['featured_media_alt'] ?: $post['title']); ?>"
                                >

                                <?php if ($post['featured_media_caption']): ?>
                                    <figcaption class="kn-small-text kn-text-muted">
                                        <?php echo escapeAdminPreviewPostHtml($post['featured_media_caption']); ?>
                                    </figcaption>
                                <?php endif; ?>
                            </figure>
                        <?php endif; ?>

                        <article class="kn-stack">
                            <?php echo $post['content_html']; ?>
                        </article>
                    </article>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Preview Status</h2>

                            <p>
                                This is an admin-only preview. Draft, scheduled, and archived posts are not necessarily public.
                            </p>

                            <dl>
                                <dt>Status</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml(ucfirst($post['status'])); ?></dd>

                                <dt>Slug</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml($post['slug']); ?></dd>

                                <dt>Author</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml($post['author_name']); ?></dd>

                                <dt>Category</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml($post['category_name'] ?? 'Uncategorized'); ?></dd>

                                <dt>Published</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml(formatAdminPreviewPostDate($post['published_at'])); ?></dd>

                                <dt>Updated</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml(formatAdminPreviewPostDate($post['updated_at'])); ?></dd>
                            </dl>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Search Metadata</h2>

                            <dl>
                                <dt>SEO Title</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml($post['seo_title'] ?: 'Not set'); ?></dd>

                                <dt>SEO Description</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml($post['seo_description'] ?: 'Not set'); ?></dd>

                                <dt>Canonical URL</dt>
                                <dd><?php echo escapeAdminPreviewPostHtml($post['canonical_url'] ?: 'Not set'); ?></dd>

                                <dt>Indexing</dt>
                                <dd><?php echo $post['allow_indexing'] ? 'Allowed' : 'Blocked'; ?></dd>
                            </dl>
                        </article>

                        <?php if ($tags): ?>
                            <article class="kn-card kn-stack">
                                <h2>Tags</h2>

                                <ul class="kn-feature-list">
                                    <?php foreach ($tags as $tag): ?>
                                        <li><?php echo escapeAdminPreviewPostHtml($tag['name']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        <?php endif; ?>

                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminPreviewPostHtml($currentUser['display_name']); ?>.
                            </p>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/posts/edit.php?id=<?php echo escapeAdminPreviewPostHtml((string) $post['id']); ?>" class="kn-button kn-button-primary kn-full-width">Edit Post</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary kn-full-width">Manage Posts</a>
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