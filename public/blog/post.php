<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/10/2026
    Updated: 06/10/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';
require_once $projectRoot . '/config/nickolaspatino_db.php';

function escapeBlogPostHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function cleanBlogPostInput(string $value): string
{
    return trim(strip_tags($value));
}

function formatBlogPostDate(?string $value): string
{
    if (!$value) {
        return 'Not set';
    }

    $timestamp = strtotime($value);

    if (!$timestamp) {
        return 'Not set';
    }

    return date('M j, Y', $timestamp);
}

function makeBlogPostUrl(string $slug): string
{
    return '/blog/post.php?slug=' . rawurlencode($slug);
}

$slug = cleanBlogPostInput($_GET['slug'] ?? '');

if ($slug === '') {
    header('Location: /blog/', true, 303);
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
        blog_categories.slug AS category_slug,
        users.display_name AS author_name,
        blog_media.file_path AS featured_media_path,
        blog_media.alt_text AS featured_media_alt,
        blog_media.caption AS featured_media_caption,
        blog_media.credit AS featured_media_credit
    FROM blog_posts
    INNER JOIN users
        ON blog_posts.author_user_id = users.id
    LEFT JOIN blog_categories
        ON blog_posts.category_id = blog_categories.id
    LEFT JOIN blog_media
        ON blog_posts.featured_media_id = blog_media.id
    WHERE blog_posts.slug = :slug
        AND blog_posts.status = 'published'
        AND blog_posts.deleted_at IS NULL
        AND (
            blog_posts.published_at IS NULL
            OR blog_posts.published_at <= CURRENT_TIMESTAMP
        )
    LIMIT 1
");

$postStatement->execute([
    ':slug' => $slug,
]);

$post = $postStatement->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    $redirectStatement = $pdo->prepare("
        SELECT
            new_path,
            http_status
        FROM blog_redirects
        WHERE old_path = :old_path
        LIMIT 1
    ");

    $redirectStatement->execute([
        ':old_path' => '/blog/' . $slug,
    ]);

    $redirect = $redirectStatement->fetch(PDO::FETCH_ASSOC);

    if ($redirect) {
        $redirectPath = parse_url($redirect['new_path'], PHP_URL_PATH);
        $redirectSlug = '';

        if (is_string($redirectPath)) {
            $redirectSlug = basename($redirectPath);
        }

        if ($redirectSlug !== '') {
            $httpStatus = (int) $redirect['http_status'];

            if (!in_array($httpStatus, [301, 302, 307, 308], true)) {
                $httpStatus = 301;
            }

            header('Location: ' . makeBlogPostUrl($redirectSlug), true, $httpStatus);
            exit();
        }
    }

    header('Location: /blog/?missing=1', true, 303);
    exit();
}

$tagStatement = $pdo->prepare("
    SELECT
        blog_tags.name,
        blog_tags.slug,
        blog_tags.description
    FROM blog_post_tags
    INNER JOIN blog_tags
        ON blog_post_tags.tag_id = blog_tags.id
    WHERE blog_post_tags.post_id = :post_id
    ORDER BY blog_tags.name ASC
");

$tagStatement->execute([
    ':post_id' => (int) $post['id'],
]);

$tags = $tagStatement->fetchAll(PDO::FETCH_ASSOC);

$relatedPostsStatement = $pdo->prepare("
    SELECT DISTINCT
        related_posts.id,
        related_posts.title,
        related_posts.slug,
        related_posts.excerpt,
        related_posts.published_at,
        related_posts.created_at,
        blog_categories.name AS category_name
    FROM blog_posts AS related_posts
    LEFT JOIN blog_categories
        ON related_posts.category_id = blog_categories.id
    LEFT JOIN blog_post_tags AS current_post_tags
        ON current_post_tags.post_id = :current_post_id
    LEFT JOIN blog_post_tags AS related_post_tags
        ON related_post_tags.post_id = related_posts.id
        AND related_post_tags.tag_id = current_post_tags.tag_id
    WHERE related_posts.id != :current_post_id
        AND related_posts.status = 'published'
        AND related_posts.deleted_at IS NULL
        AND (
            related_posts.published_at IS NULL
            OR related_posts.published_at <= CURRENT_TIMESTAMP
        )
        AND (
            related_posts.category_id = :category_id
            OR related_post_tags.tag_id IS NOT NULL
        )
    ORDER BY
        related_posts.published_at DESC,
        related_posts.created_at DESC
    LIMIT 3
");

$relatedPostsStatement->execute([
    ':current_post_id' => (int) $post['id'],
    ':category_id' => $post['category_id'] ? (int) $post['category_id'] : 0,
]);

$relatedPosts = $relatedPostsStatement->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Nickolas Patino | " . ($post['seo_title'] ?: $post['title']);
$pageDescription = $post['seo_description'] ?: ($post['excerpt'] ?: 'Blog post by Nickolas Patino.');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $projectRoot . '/src/head.php'; ?>

    <?php if (!$post['allow_indexing']): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <?php if ($post['canonical_url']): ?>
        <link rel="canonical" href="<?php echo escapeBlogPostHtml($post['canonical_url']); ?>">
    <?php else: ?>
        <link rel="canonical" href="<?php echo escapeBlogPostHtml('/blog/post.php?slug=' . rawurlencode($post['slug'])); ?>">
    <?php endif; ?>
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
                                <?php if ($post['category_name']): ?>
                                    <a href="/blog/?category=<?php echo escapeBlogPostHtml(rawurlencode($post['category_slug'])); ?>">
                                        <?php echo escapeBlogPostHtml($post['category_name']); ?>
                                    </a>
                                    •
                                <?php endif; ?>

                                <?php echo escapeBlogPostHtml(formatBlogPostDate($post['published_at'] ?: $post['created_at'])); ?>
                            </p>

                            <h1><?php echo escapeBlogPostHtml($post['title']); ?></h1>

                            <?php if ($post['excerpt']): ?>
                                <p class="kn-lead">
                                    <?php echo escapeBlogPostHtml($post['excerpt']); ?>
                                </p>
                            <?php endif; ?>

                            <p class="kn-small-text kn-text-muted">
                                By <?php echo escapeBlogPostHtml($post['author_name']); ?>
                            </p>
                        </div>

                        <?php if ($post['featured_media_path']): ?>
                            <figure class="kn-card kn-stack">
                                <img
                                    src="<?php echo escapeBlogPostHtml($post['featured_media_path']); ?>"
                                    alt="<?php echo escapeBlogPostHtml($post['featured_media_alt'] ?: $post['title']); ?>"
                                >

                                <?php if ($post['featured_media_caption'] || $post['featured_media_credit']): ?>
                                    <figcaption class="kn-small-text kn-text-muted">
                                        <?php if ($post['featured_media_caption']): ?>
                                            <?php echo escapeBlogPostHtml($post['featured_media_caption']); ?>
                                        <?php endif; ?>

                                        <?php if ($post['featured_media_credit']): ?>
                                            <?php if ($post['featured_media_caption']): ?>
                                                —
                                            <?php endif; ?>

                                            <?php echo escapeBlogPostHtml($post['featured_media_credit']); ?>
                                        <?php endif; ?>
                                    </figcaption>
                                <?php endif; ?>
                            </figure>
                        <?php endif; ?>

                        <article class="kn-stack">
                            <?php echo $post['content_html']; ?>
                        </article>

                        <?php if ($tags): ?>
                            <article class="kn-card kn-stack">
                                <h2>Tags</h2>

                                <div class="kn-button-group">
                                    <?php foreach ($tags as $tag): ?>
                                        <a href="/blog/?tag=<?php echo escapeBlogPostHtml(rawurlencode($tag['slug'])); ?>" class="kn-button kn-button-secondary">
                                            <?php echo escapeBlogPostHtml($tag['name']); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </article>
                        <?php endif; ?>

                        <div class="kn-button-group">
                            <a href="/blog/" class="kn-button kn-button-primary">Back to Blog</a>

                            <?php if ($post['category_slug']): ?>
                                <a href="/blog/?category=<?php echo escapeBlogPostHtml(rawurlencode($post['category_slug'])); ?>" class="kn-button kn-button-secondary">
                                    More in <?php echo escapeBlogPostHtml($post['category_name']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Post Details</h2>

                            <dl>
                                <dt>Published</dt>
                                <dd><?php echo escapeBlogPostHtml(formatBlogPostDate($post['published_at'] ?: $post['created_at'])); ?></dd>

                                <dt>Updated</dt>
                                <dd><?php echo escapeBlogPostHtml(formatBlogPostDate($post['updated_at'])); ?></dd>

                                <dt>Author</dt>
                                <dd><?php echo escapeBlogPostHtml($post['author_name']); ?></dd>

                                <dt>Category</dt>
                                <dd>
                                    <?php if ($post['category_name']): ?>
                                        <a href="/blog/?category=<?php echo escapeBlogPostHtml(rawurlencode($post['category_slug'])); ?>">
                                            <?php echo escapeBlogPostHtml($post['category_name']); ?>
                                        </a>
                                    <?php else: ?>
                                        Uncategorized
                                    <?php endif; ?>
                                </dd>
                            </dl>
                        </article>

                        <?php if ($relatedPosts): ?>
                            <article class="kn-card kn-stack">
                                <h2>Related Posts</h2>

                                <div class="kn-stack kn-stack-tight">
                                    <?php foreach ($relatedPosts as $relatedPost): ?>
                                        <article class="kn-card kn-stack kn-stack-tight">
                                            <p class="kn-small-text kn-text-primary">
                                                <?php if ($relatedPost['category_name']): ?>
                                                    <?php echo escapeBlogPostHtml($relatedPost['category_name']); ?> •
                                                <?php endif; ?>

                                                <?php echo escapeBlogPostHtml(formatBlogPostDate($relatedPost['published_at'] ?: $relatedPost['created_at'])); ?>
                                            </p>

                                            <h3>
                                                <a href="<?php echo escapeBlogPostHtml(makeBlogPostUrl($relatedPost['slug'])); ?>">
                                                    <?php echo escapeBlogPostHtml($relatedPost['title']); ?>
                                                </a>
                                            </h3>

                                            <?php if ($relatedPost['excerpt']): ?>
                                                <p>
                                                    <?php echo escapeBlogPostHtml($relatedPost['excerpt']); ?>
                                                </p>
                                            <?php endif; ?>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </article>
                        <?php endif; ?>

                        <article class="kn-card kn-stack">
                            <h2>Explore</h2>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/blog/" class="kn-button kn-button-primary kn-full-width">All Posts</a>
                                <a href="/projects/" class="kn-button kn-button-secondary kn-full-width">Projects</a>
                                <a href="/services.php" class="kn-button kn-button-secondary kn-full-width">Services</a>
                                <a href="/contact.php#contact-form" class="kn-button kn-button-ghost kn-full-width">Contact</a>
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