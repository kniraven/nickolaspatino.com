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

$pageTitle = "Nickolas Patino | Manage Blog Posts";
$pageDescription = "Manage blog posts for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminPostsHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function formatAdminPostsDate(?string $value): string
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

$validStatuses = [
    'all',
    'draft',
    'published',
    'scheduled',
    'archived',
];

$statusFilter = $_GET['status'] ?? 'all';

if (!in_array($statusFilter, $validStatuses, true)) {
    $statusFilter = 'all';
}

$categoryFilter = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;
$searchQuery = trim($_GET['q'] ?? '');

$categoriesStatement = $pdo->query("
    SELECT
        id,
        name
    FROM blog_categories
    WHERE is_active = 1
    ORDER BY sort_order ASC, name ASC
");

$categories = $categoriesStatement->fetchAll(PDO::FETCH_ASSOC);

$postCountStatement = $pdo->query("
    SELECT
        status,
        COUNT(*) AS post_count
    FROM blog_posts
    WHERE deleted_at IS NULL
    GROUP BY status
");

$statusCounts = [
    'draft' => 0,
    'published' => 0,
    'scheduled' => 0,
    'archived' => 0,
];

foreach ($postCountStatement->fetchAll(PDO::FETCH_ASSOC) as $statusCount) {
    $statusCounts[$statusCount['status']] = (int) $statusCount['post_count'];
}

$totalPostCount = array_sum($statusCounts);

$whereClauses = [
    'blog_posts.deleted_at IS NULL',
];

$queryParams = [];

if ($statusFilter !== 'all') {
    $whereClauses[] = 'blog_posts.status = :status';
    $queryParams[':status'] = $statusFilter;
}

if ($categoryFilter > 0) {
    $whereClauses[] = 'blog_posts.category_id = :category_id';
    $queryParams[':category_id'] = $categoryFilter;
}

if ($searchQuery !== '') {
    $whereClauses[] = "(
        blog_posts.title LIKE :search
        OR blog_posts.slug LIKE :search
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
        blog_posts.status,
        blog_posts.is_featured,
        blog_posts.published_at,
        blog_posts.created_at,
        blog_posts.updated_at,
        blog_categories.name AS category_name,
        users.display_name AS author_name
    FROM blog_posts
    INNER JOIN users
        ON blog_posts.author_user_id = users.id
    LEFT JOIN blog_categories
        ON blog_posts.category_id = blog_categories.id
    WHERE {$whereSql}
    ORDER BY blog_posts.updated_at DESC
    LIMIT 100
");

$postsStatement->execute($queryParams);

$posts = $postsStatement->fetchAll(PDO::FETCH_ASSOC);
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

                            <h1>Manage posts.</h1>

                            <p class="kn-lead">
                                Review, search, filter, create, and edit blog posts for NickolasPatino.com.
                            </p>

                            <div class="kn-button-group">
                                <a href="/admin/posts/create.php" class="kn-button kn-button-primary">Create Post</a>
                                <a href="/admin/" class="kn-button kn-button-secondary">Admin Dashboard</a>
                            </div>
                        </div>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminPostsHtml((string) $totalPostCount); ?></h2>
                                <p>Total Posts</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminPostsHtml((string) $statusCounts['published']); ?></h2>
                                <p>Published</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminPostsHtml((string) $statusCounts['draft']); ?></h2>
                                <p>Drafts</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminPostsHtml((string) $statusCounts['scheduled']); ?></h2>
                                <p>Scheduled</p>
                            </article>
                        </div>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Post Filters</h2>

                                <p>
                                    Filter by status, category, or keyword.
                                </p>
                            </div>

                            <form class="kn-form" method="get" action="/admin/posts/">
                                <div class="kn-form-row">
                                    <div class="kn-form-field">
                                        <label for="status">Status</label>
                                        <select id="status" name="status">
                                            <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All statuses</option>
                                            <option value="draft" <?php echo $statusFilter === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                            <option value="published" <?php echo $statusFilter === 'published' ? 'selected' : ''; ?>>Published</option>
                                            <option value="scheduled" <?php echo $statusFilter === 'scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                            <option value="archived" <?php echo $statusFilter === 'archived' ? 'selected' : ''; ?>>Archived</option>
                                        </select>
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="category_id">Category</label>
                                        <select id="category_id" name="category_id">
                                            <option value="0">All categories</option>

                                            <?php foreach ($categories as $category): ?>
                                                <option
                                                    value="<?php echo escapeAdminPostsHtml((string) $category['id']); ?>"
                                                    <?php echo (int) $category['id'] === $categoryFilter ? 'selected' : ''; ?>
                                                >
                                                    <?php echo escapeAdminPostsHtml($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="kn-form-field">
                                    <label for="q">Search</label>
                                    <input
                                        type="search"
                                        id="q"
                                        name="q"
                                        maxlength="190"
                                        value="<?php echo escapeAdminPostsHtml($searchQuery); ?>"
                                        placeholder="Search title, slug, excerpt, or content"
                                    >
                                </div>

                                <div class="kn-button-group">
                                    <button class="kn-button kn-button-primary" type="submit">Apply Filters</button>
                                    <a href="/admin/posts/" class="kn-button kn-button-ghost">Clear Filters</a>
                                </div>
                            </form>
                        </article>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Posts</h2>

                                <p>
                                    Showing up to 100 posts ordered by most recently updated.
                                </p>
                            </div>

                            <?php if ($posts): ?>
                                <div class="kn-stack">
                                    <?php foreach ($posts as $post): ?>
                                        <article class="kn-card kn-stack">
                                            <div class="kn-stack kn-stack-tight">
                                                <div>
                                                    <p class="kn-small-text kn-text-primary">
                                                        <?php echo escapeAdminPostsHtml(ucfirst($post['status'])); ?>

                                                        <?php if ($post['is_featured']): ?>
                                                            • Featured
                                                        <?php endif; ?>
                                                    </p>

                                                    <h3><?php echo escapeAdminPostsHtml($post['title']); ?></h3>

                                                    <p class="kn-small-text kn-text-muted">
                                                        Slug: <?php echo escapeAdminPostsHtml($post['slug']); ?>
                                                    </p>
                                                </div>

                                                <?php if ($post['excerpt']): ?>
                                                    <p>
                                                        <?php echo escapeAdminPostsHtml($post['excerpt']); ?>
                                                    </p>
                                                <?php endif; ?>

                                                <dl>
                                                    <dt>Author</dt>
                                                    <dd><?php echo escapeAdminPostsHtml($post['author_name']); ?></dd>

                                                    <dt>Category</dt>
                                                    <dd><?php echo escapeAdminPostsHtml($post['category_name'] ?? 'Uncategorized'); ?></dd>

                                                    <dt>Published</dt>
                                                    <dd><?php echo escapeAdminPostsHtml(formatAdminPostsDate($post['published_at'])); ?></dd>

                                                    <dt>Updated</dt>
                                                    <dd><?php echo escapeAdminPostsHtml(formatAdminPostsDate($post['updated_at'])); ?></dd>
                                                </dl>
                                            </div>

                                            <div class="kn-button-group">
                                                <a href="/admin/posts/edit.php?id=<?php echo escapeAdminPostsHtml((string) $post['id']); ?>" class="kn-button kn-button-primary">Edit</a>
                                                <a href="/admin/posts/preview.php?id=<?php echo escapeAdminPostsHtml((string) $post['id']); ?>" class="kn-button kn-button-secondary" target="_blank" rel="noopener">Preview</a>

                                                <?php if ($post['status'] === 'published'): ?>
                                                    <a href="/blog/<?php echo escapeAdminPostsHtml($post['slug']); ?>" class="kn-button kn-button-ghost" target="_blank" rel="noopener">View Public</a>
                                                <?php endif; ?>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="kn-card kn-stack">
                                    <h3>No posts found.</h3>

                                    <p>
                                        No posts match the current filters.
                                    </p>

                                    <div class="kn-button-group">
                                        <a href="/admin/posts/create.php" class="kn-button kn-button-primary">Create Post</a>
                                        <a href="/admin/posts/" class="kn-button kn-button-ghost">Clear Filters</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Post Actions</h2>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/posts/create.php" class="kn-button kn-button-primary kn-full-width">Create Post</a>
                                <a href="/admin/media/" class="kn-button kn-button-secondary kn-full-width">Media Library</a>
                                <a href="/blog/" class="kn-button kn-button-ghost kn-full-width" target="_blank" rel="noopener">View Blog</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Status Filters</h2>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/posts/?status=all" class="kn-button kn-button-secondary kn-full-width">All Posts</a>
                                <a href="/admin/posts/?status=published" class="kn-button kn-button-secondary kn-full-width">Published</a>
                                <a href="/admin/posts/?status=draft" class="kn-button kn-button-secondary kn-full-width">Drafts</a>
                                <a href="/admin/posts/?status=scheduled" class="kn-button kn-button-secondary kn-full-width">Scheduled</a>
                                <a href="/admin/posts/?status=archived" class="kn-button kn-button-secondary kn-full-width">Archived</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminPostsHtml($currentUser['display_name']); ?>.
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