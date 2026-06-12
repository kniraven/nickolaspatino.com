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

$pageTitle = "Nickolas Patino | Blog";
$pageDescription = "Blog posts about web development, automation, internal tools, small business technology, gaming projects, and career development.";

function escapeBlogIndexHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function cleanBlogIndexInput(string $value): string
{
    return trim(strip_tags($value));
}

function formatBlogIndexDate(?string $value): string
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

function makeBlogIndexPostUrl(string $slug): string
{
    return '/blog/post.php?slug=' . rawurlencode($slug);
}

$searchQuery = cleanBlogIndexInput($_GET['q'] ?? '');
$categorySlug = cleanBlogIndexInput($_GET['category'] ?? '');
$tagSlug = cleanBlogIndexInput($_GET['tag'] ?? '');

$activeCategory = null;
$activeTag = null;

if ($categorySlug !== '') {
    $activeCategoryStatement = $pdo->prepare("
        SELECT
            id,
            name,
            slug,
            description
        FROM blog_categories
        WHERE slug = :slug
            AND is_active = 1
        LIMIT 1
    ");

    $activeCategoryStatement->execute([
        ':slug' => $categorySlug,
    ]);

    $activeCategory = $activeCategoryStatement->fetch(PDO::FETCH_ASSOC);

    if (!$activeCategory) {
        $categorySlug = '';
    }
}

if ($tagSlug !== '') {
    $activeTagStatement = $pdo->prepare("
        SELECT
            id,
            name,
            slug,
            description
        FROM blog_tags
        WHERE slug = :slug
        LIMIT 1
    ");

    $activeTagStatement->execute([
        ':slug' => $tagSlug,
    ]);

    $activeTag = $activeTagStatement->fetch(PDO::FETCH_ASSOC);

    if (!$activeTag) {
        $tagSlug = '';
    }
}

$categoriesStatement = $pdo->query("
    SELECT
        blog_categories.id,
        blog_categories.name,
        blog_categories.slug,
        blog_categories.description,
        COUNT(blog_posts.id) AS post_count
    FROM blog_categories
    LEFT JOIN blog_posts
        ON blog_posts.category_id = blog_categories.id
        AND blog_posts.status = 'published'
        AND blog_posts.deleted_at IS NULL
        AND (
            blog_posts.published_at IS NULL
            OR blog_posts.published_at <= CURRENT_TIMESTAMP
        )
    WHERE blog_categories.is_active = 1
    GROUP BY
        blog_categories.id,
        blog_categories.name,
        blog_categories.slug,
        blog_categories.description,
        blog_categories.sort_order
    ORDER BY blog_categories.sort_order ASC, blog_categories.name ASC
");

$categories = $categoriesStatement->fetchAll(PDO::FETCH_ASSOC);

$tagsStatement = $pdo->query("
    SELECT
        blog_tags.id,
        blog_tags.name,
        blog_tags.slug,
        blog_tags.description,
        COUNT(blog_posts.id) AS post_count
    FROM blog_tags
    INNER JOIN blog_post_tags
        ON blog_post_tags.tag_id = blog_tags.id
    INNER JOIN blog_posts
        ON blog_post_tags.post_id = blog_posts.id
        AND blog_posts.status = 'published'
        AND blog_posts.deleted_at IS NULL
        AND (
            blog_posts.published_at IS NULL
            OR blog_posts.published_at <= CURRENT_TIMESTAMP
        )
    GROUP BY
        blog_tags.id,
        blog_tags.name,
        blog_tags.slug,
        blog_tags.description
    HAVING post_count > 0
    ORDER BY blog_tags.name ASC
");

$tags = $tagsStatement->fetchAll(PDO::FETCH_ASSOC);

$whereClauses = [
    "blog_posts.status = 'published'",
    "blog_posts.deleted_at IS NULL",
    "(
        blog_posts.published_at IS NULL
        OR blog_posts.published_at <= CURRENT_TIMESTAMP
    )",
];

$queryParams = [];

if ($activeCategory) {
    $whereClauses[] = 'blog_posts.category_id = :category_id';
    $queryParams[':category_id'] = (int) $activeCategory['id'];
}

if ($activeTag) {
    $whereClauses[] = "
        EXISTS (
            SELECT 1
            FROM blog_post_tags
            INNER JOIN blog_tags
                ON blog_post_tags.tag_id = blog_tags.id
            WHERE blog_post_tags.post_id = blog_posts.id
                AND blog_tags.slug = :tag_slug
        )
    ";

    $queryParams[':tag_slug'] = $activeTag['slug'];
}

if ($searchQuery !== '') {
    $whereClauses[] = "(
        blog_posts.title LIKE :search
        OR blog_posts.excerpt LIKE :search
        OR blog_posts.content_text LIKE :search
    )";

    $queryParams[':search'] = '%' . $searchQuery . '%';
}

$whereSql = implode(' AND ', $whereClauses);

$postsStatement = $pdo->prepare("
    SELECT
        blog_posts.id,
        blog_posts.title,
        blog_posts.slug,
        blog_posts.excerpt,
        blog_posts.content_text,
        blog_posts.is_featured,
        blog_posts.published_at,
        blog_posts.created_at,
        blog_posts.updated_at,
        blog_categories.name AS category_name,
        blog_categories.slug AS category_slug,
        users.display_name AS author_name,
        blog_media.file_path AS featured_media_path,
        blog_media.alt_text AS featured_media_alt
    FROM blog_posts
    INNER JOIN users
        ON blog_posts.author_user_id = users.id
    LEFT JOIN blog_categories
        ON blog_posts.category_id = blog_categories.id
    LEFT JOIN blog_media
        ON blog_posts.featured_media_id = blog_media.id
    WHERE {$whereSql}
    ORDER BY
        COALESCE(blog_posts.published_at, blog_posts.created_at) DESC,
        blog_posts.created_at DESC,
        blog_posts.is_featured DESC
    LIMIT 25
");

$postsStatement->execute($queryParams);

$posts = $postsStatement->fetchAll(PDO::FETCH_ASSOC);

$blogHeading = 'Blog.';

if ($activeCategory) {
    $blogHeading = $activeCategory['name'] . '.';
    $pageTitle = "Nickolas Patino | " . $activeCategory['name'];
    $pageDescription = $activeCategory['description'] ?: $pageDescription;
}

if ($activeTag) {
    $blogHeading = 'Posts tagged ' . $activeTag['name'] . '.';
    $pageTitle = "Nickolas Patino | " . $activeTag['name'];
    $pageDescription = $activeTag['description'] ?: $pageDescription;
}

if ($searchQuery !== '') {
    $blogHeading = 'Search results.';
    $pageTitle = "Nickolas Patino | Blog Search";
}
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
                                Blog
                            </p>

                            <h1><?php echo escapeBlogIndexHtml($blogHeading); ?></h1>

                            <p class="kn-lead">
                                Notes on web development, automation, internal tools, small business technology, portfolio projects, and gaming-adjacent builds.
                            </p>
                        </div>

                        <details class="kn-card kn-stack kn-stack-tight" <?php echo ($activeCategory || $activeTag || $searchQuery !== '') ? 'open' : ''; ?>>
                            <summary class="kn-small-text kn-text-primary">
                                Filter Posts
                                <?php if ($activeCategory): ?>
                                    • Category: <?php echo escapeBlogIndexHtml($activeCategory['name']); ?>
                                <?php elseif ($activeTag): ?>
                                    • Tag: <?php echo escapeBlogIndexHtml($activeTag['name']); ?>
                                <?php elseif ($searchQuery !== ''): ?>
                                    • Search: <?php echo escapeBlogIndexHtml($searchQuery); ?>
                                <?php endif; ?>
                            </summary>

                            <form class="kn-form" method="get" action="/blog/">
                                <div class="kn-form-row">
                                    <div class="kn-form-field">
                                        <label for="q">Search</label>
                                        <input
                                            type="search"
                                            id="q"
                                            name="q"
                                            maxlength="190"
                                            value="<?php echo escapeBlogIndexHtml($searchQuery); ?>"
                                            placeholder="Search posts"
                                        >
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="category">Category</label>
                                        <select id="category" name="category">
                                            <option value="">All categories</option>

                                            <?php foreach ($categories as $category): ?>
                                                <?php if ((int) $category['post_count'] > 0): ?>
                                                    <option
                                                        value="<?php echo escapeBlogIndexHtml($category['slug']); ?>"
                                                        <?php echo $categorySlug === $category['slug'] ? 'selected' : ''; ?>
                                                    >
                                                        <?php echo escapeBlogIndexHtml($category['name']); ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="tag">Tag</label>
                                        <select id="tag" name="tag">
                                            <option value="">All tags</option>

                                            <?php foreach ($tags as $tag): ?>
                                                <option
                                                    value="<?php echo escapeBlogIndexHtml($tag['slug']); ?>"
                                                    <?php echo $tagSlug === $tag['slug'] ? 'selected' : ''; ?>
                                                >
                                                    <?php echo escapeBlogIndexHtml($tag['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="kn-button-group">
                                    <button class="kn-button kn-button-primary" type="submit">Apply</button>
                                    <a href="/blog/" class="kn-button kn-button-ghost">Clear</a>
                                </div>
                            </form>
                        </details>

                        <section class="kn-stack">
                            <?php if ($posts): ?>
                                <?php foreach ($posts as $post): ?>
                                    <article class="kn-card kn-stack">
                                        <?php if ($post['featured_media_path']): ?>
                                            <a href="<?php echo escapeBlogIndexHtml(makeBlogIndexPostUrl($post['slug'])); ?>">
                                                <img
                                                    src="<?php echo escapeBlogIndexHtml($post['featured_media_path']); ?>"
                                                    alt="<?php echo escapeBlogIndexHtml($post['featured_media_alt'] ?: $post['title']); ?>"
                                                >
                                            </a>
                                        <?php endif; ?>

                                        <div class="kn-stack kn-stack-tight">
                                            <p class="kn-small-text kn-text-primary">
                                                <?php if ($post['is_featured']): ?>
                                                    Featured •
                                                <?php endif; ?>

                                                <?php if ($post['category_name']): ?>
                                                    <?php echo escapeBlogIndexHtml($post['category_name']); ?> •
                                                <?php endif; ?>

                                                <?php echo escapeBlogIndexHtml(formatBlogIndexDate($post['published_at'] ?: $post['created_at'])); ?>
                                            </p>

                                            <h2>
                                                <a href="<?php echo escapeBlogIndexHtml(makeBlogIndexPostUrl($post['slug'])); ?>">
                                                    <?php echo escapeBlogIndexHtml($post['title']); ?>
                                                </a>
                                            </h2>

                                            <?php if ($post['excerpt']): ?>
                                                <p>
                                                    <?php echo escapeBlogIndexHtml($post['excerpt']); ?>
                                                </p>
                                            <?php elseif ($post['content_text']): ?>
                                                <p>
                                                    <?php echo escapeBlogIndexHtml(substr($post['content_text'], 0, 220)); ?>...
                                                </p>
                                            <?php endif; ?>

                                            <div class="kn-button-group">
                                                <a href="<?php echo escapeBlogIndexHtml(makeBlogIndexPostUrl($post['slug'])); ?>" class="kn-button kn-button-primary">Read Post</a>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <article class="kn-card kn-stack">
                                    <h2>No posts found.</h2>

                                    <p>
                                        No published posts match the current filters.
                                    </p>

                                    <div class="kn-button-group">
                                        <a href="/blog/" class="kn-button kn-button-primary">View All Posts</a>
                                    </div>
                                </article>
                            <?php endif; ?>
                        </section>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Categories</h2>

                            <?php if ($categories): ?>
                                <div class="kn-stack kn-stack-tight">
                                    <?php foreach ($categories as $category): ?>
                                        <?php if ((int) $category['post_count'] > 0): ?>
                                            <a href="/blog/?category=<?php echo escapeBlogIndexHtml(rawurlencode($category['slug'])); ?>" class="kn-button kn-button-secondary kn-full-width">
                                                <?php echo escapeBlogIndexHtml($category['name']); ?>
                                                (<?php echo escapeBlogIndexHtml((string) $category['post_count']); ?>)
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>No categories yet.</p>
                            <?php endif; ?>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Tags</h2>

                            <?php if ($tags): ?>
                                <div class="kn-stack kn-stack-tight">
                                    <?php foreach ($tags as $tag): ?>
                                        <a href="/blog/?tag=<?php echo escapeBlogIndexHtml(rawurlencode($tag['slug'])); ?>" class="kn-button kn-button-secondary kn-full-width">
                                            <?php echo escapeBlogIndexHtml($tag['name']); ?>
                                            (<?php echo escapeBlogIndexHtml((string) $tag['post_count']); ?>)
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>No tags yet.</p>
                            <?php endif; ?>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>About This Blog</h2>

                            <p>
                                Practical notes, project writeups, and development logs from my work in web development, automation, and custom tools.
                            </p>

                            <div class="kn-button-group">
                                <a href="/projects/" class="kn-button kn-button-secondary">View Projects</a>
                                <a href="/contact.php#contact-form" class="kn-button kn-button-ghost">Contact Me</a>
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