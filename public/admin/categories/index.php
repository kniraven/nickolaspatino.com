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

$pageTitle = "Nickolas Patino | Manage Categories";
$pageDescription = "Manage blog categories for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminCategoryHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function cleanAdminCategoryText(string $value): string
{
    return trim(strip_tags($value));
}

function makeAdminCategorySlug(string $value): string
{
    $slug = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug) ?? '';
    $slug = trim($slug, '-');

    if ($slug === '') {
        $slug = 'category-' . date('YmdHis');
    }

    return substr($slug, 0, 140);
}

function makeUniqueAdminCategorySlug(PDO $pdo, string $baseSlug, int $categoryId = 0): string
{
    $baseSlug = substr($baseSlug, 0, 130);
    $slug = $baseSlug;
    $counter = 2;

    while (true) {
        $slugStatement = $pdo->prepare("
            SELECT COUNT(*)
            FROM blog_categories
            WHERE slug = :slug
                AND id != :id
        ");

        $slugStatement->execute([
            ':slug' => $slug,
            ':id' => $categoryId,
        ]);

        if ((int) $slugStatement->fetchColumn() === 0) {
            return $slug;
        }

        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }
}

function formatAdminCategoryDate(?string $value): string
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

function isValidAdminCategoryCsrfToken(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];

$editCategoryId = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : 0;
$isEditing = $editCategoryId > 0;

$name = '';
$slug = '';
$description = '';
$sortOrder = 0;
$isActive = true;

if ($isEditing) {
    $editCategoryStatement = $pdo->prepare("
        SELECT
            id,
            name,
            slug,
            description,
            sort_order,
            is_active,
            created_at,
            updated_at
        FROM blog_categories
        WHERE id = :id
        LIMIT 1
    ");

    $editCategoryStatement->execute([
        ':id' => $editCategoryId,
    ]);

    $editCategory = $editCategoryStatement->fetch(PDO::FETCH_ASSOC);

    if (!$editCategory) {
        header('Location: /admin/categories/?missing=1', true, 303);
        exit();
    }

    $name = $editCategory['name'];
    $slug = $editCategory['slug'];
    $description = $editCategory['description'] ?? '';
    $sortOrder = (int) $editCategory['sort_order'];
    $isActive = (bool) $editCategory['is_active'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $action = cleanAdminCategoryText($_POST['action'] ?? 'create');
    $postedCategoryId = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;

    $name = cleanAdminCategoryText($_POST['name'] ?? '');
    $slug = cleanAdminCategoryText($_POST['slug'] ?? '');
    $description = cleanAdminCategoryText($_POST['description'] ?? '');
    $sortOrder = isset($_POST['sort_order']) ? (int) $_POST['sort_order'] : 0;
    $isActive = isset($_POST['is_active']) && $_POST['is_active'] === '1';

    $isEditing = $action === 'update';
    $editCategoryId = $isEditing ? $postedCategoryId : 0;

    if (!isValidAdminCategoryCsrfToken($csrfToken)) {
        $errors[] = 'Your session expired. Please refresh the page and try again.';
    }

    if (!in_array($action, ['create', 'update'], true)) {
        $errors[] = 'Choose a valid category action.';
    }

    if ($isEditing && $editCategoryId <= 0) {
        $errors[] = 'Choose a valid category to update.';
    }

    if ($name === '') {
        $errors[] = 'Category name is required.';
    }

    if (strlen($name) > 120) {
        $errors[] = 'Category name must be 120 characters or fewer.';
    }

    if ($slug !== '' && strlen($slug) > 140) {
        $errors[] = 'Slug must be 140 characters or fewer.';
    }

    if ($sortOrder < 0) {
        $errors[] = 'Sort order cannot be negative.';
    }

    if (!$errors && $isEditing) {
        $existingCategoryStatement = $pdo->prepare("
            SELECT COUNT(*)
            FROM blog_categories
            WHERE id = :id
        ");

        $existingCategoryStatement->execute([
            ':id' => $editCategoryId,
        ]);

        if ((int) $existingCategoryStatement->fetchColumn() === 0) {
            $errors[] = 'The category you are trying to update no longer exists.';
        }
    }

    if (!$errors) {
        $duplicateNameStatement = $pdo->prepare("
            SELECT COUNT(*)
            FROM blog_categories
            WHERE name = :name
                AND id != :id
        ");

        $duplicateNameStatement->execute([
            ':name' => $name,
            ':id' => $editCategoryId,
        ]);

        if ((int) $duplicateNameStatement->fetchColumn() > 0) {
            $errors[] = 'A category with that name already exists.';
        }
    }

    if (!$errors) {
        $baseSlug = makeAdminCategorySlug($slug !== '' ? $slug : $name);
        $uniqueSlug = makeUniqueAdminCategorySlug($pdo, $baseSlug, $editCategoryId);
        $descriptionValue = $description !== '' ? $description : null;

        try {
            if ($isEditing) {
                $updateCategoryStatement = $pdo->prepare("
                    UPDATE blog_categories
                    SET
                        name = :name,
                        slug = :slug,
                        description = :description,
                        sort_order = :sort_order,
                        is_active = :is_active
                    WHERE id = :id
                    LIMIT 1
                ");

                $updateCategoryStatement->execute([
                    ':name' => $name,
                    ':slug' => $uniqueSlug,
                    ':description' => $descriptionValue,
                    ':sort_order' => $sortOrder,
                    ':is_active' => $isActive ? 1 : 0,
                    ':id' => $editCategoryId,
                ]);

                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: /admin/categories/?updated=1&edit_id=' . $editCategoryId, true, 303);
                exit();
            }

            $insertCategoryStatement = $pdo->prepare("
                INSERT INTO blog_categories (
                    name,
                    slug,
                    description,
                    sort_order,
                    is_active
                ) VALUES (
                    :name,
                    :slug,
                    :description,
                    :sort_order,
                    :is_active
                )
            ");

            $insertCategoryStatement->execute([
                ':name' => $name,
                ':slug' => $uniqueSlug,
                ':description' => $descriptionValue,
                ':sort_order' => $sortOrder,
                ':is_active' => $isActive ? 1 : 0,
            ]);

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header('Location: /admin/categories/?created=1', true, 303);
            exit();
        } catch (Throwable $exception) {
            $errors[] = 'The category could not be saved. Please check the form and try again.';
        }
    }
}

$categoryCountStatement = $pdo->query("
    SELECT
        SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) AS active_count,
        SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) AS inactive_count,
        COUNT(*) AS total_count
    FROM blog_categories
");

$categoryCounts = $categoryCountStatement->fetch(PDO::FETCH_ASSOC);

$categoriesStatement = $pdo->query("
    SELECT
        blog_categories.id,
        blog_categories.name,
        blog_categories.slug,
        blog_categories.description,
        blog_categories.sort_order,
        blog_categories.is_active,
        blog_categories.created_at,
        blog_categories.updated_at,
        COUNT(blog_posts.id) AS post_count
    FROM blog_categories
    LEFT JOIN blog_posts
        ON blog_posts.category_id = blog_categories.id
        AND blog_posts.deleted_at IS NULL
    GROUP BY
        blog_categories.id,
        blog_categories.name,
        blog_categories.slug,
        blog_categories.description,
        blog_categories.sort_order,
        blog_categories.is_active,
        blog_categories.created_at,
        blog_categories.updated_at
    ORDER BY blog_categories.sort_order ASC, blog_categories.name ASC
");

$categories = $categoriesStatement->fetchAll(PDO::FETCH_ASSOC);

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

                            <h1>Categories.</h1>

                            <p class="kn-lead">
                                Create, edit, sort, activate, and deactivate blog categories.
                            </p>

                            <div class="kn-button-group">
                                <a href="/admin/posts/" class="kn-button kn-button-secondary">Manage Posts</a>
                                <a href="/admin/" class="kn-button kn-button-ghost">Admin Dashboard</a>
                            </div>
                        </div>

                        <?php if (isset($_GET['created']) && $_GET['created'] === '1'): ?>
                            <article class="kn-card kn-stack">
                                <h2>Category Created</h2>

                                <p>
                                    The category was created successfully.
                                </p>
                            </article>
                        <?php endif; ?>

                        <?php if (isset($_GET['updated']) && $_GET['updated'] === '1'): ?>
                            <article class="kn-card kn-stack">
                                <h2>Category Updated</h2>

                                <p>
                                    The category was saved successfully.
                                </p>
                            </article>
                        <?php endif; ?>

                        <?php if ($errors): ?>
                            <article class="kn-card kn-stack">
                                <h2>Category Not Saved</h2>

                                <ul class="kn-feature-list">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo escapeAdminCategoryHtml($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        <?php endif; ?>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminCategoryHtml((string) ($categoryCounts['total_count'] ?? 0)); ?></h2>
                                <p>Total Categories</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminCategoryHtml((string) ($categoryCounts['active_count'] ?? 0)); ?></h2>
                                <p>Active</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminCategoryHtml((string) ($categoryCounts['inactive_count'] ?? 0)); ?></h2>
                                <p>Inactive</p>
                            </article>
                        </div>

                        <form class="kn-form kn-stack" method="post" action="/admin/categories/">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeAdminCategoryHtml($csrfToken); ?>">
                            <input type="hidden" name="action" value="<?php echo $isEditing ? 'update' : 'create'; ?>">
                            <input type="hidden" name="category_id" value="<?php echo escapeAdminCategoryHtml((string) $editCategoryId); ?>">

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2><?php echo $isEditing ? 'Edit Category' : 'Create Category'; ?></h2>

                                    <p>
                                        Categories are used to group blog posts by topic.
                                    </p>
                                </div>

                                <div class="kn-form-row">
                                    <div class="kn-form-field">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            maxlength="120"
                                            required
                                            value="<?php echo escapeAdminCategoryHtml($name); ?>"
                                        >
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="slug">Slug</label>
                                        <input
                                            type="text"
                                            id="slug"
                                            name="slug"
                                            maxlength="140"
                                            value="<?php echo escapeAdminCategoryHtml($slug); ?>"
                                            placeholder="Leave blank to generate from name"
                                        >
                                    </div>
                                </div>

                                <div class="kn-form-field">
                                    <label for="description">Description</label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="3"
                                        placeholder="Optional category description"
                                    ><?php echo escapeAdminCategoryHtml($description); ?></textarea>
                                </div>

                                <div class="kn-form-row">
                                    <div class="kn-form-field">
                                        <label for="sort_order">Sort Order</label>
                                        <input
                                            type="number"
                                            id="sort_order"
                                            name="sort_order"
                                            min="0"
                                            step="1"
                                            value="<?php echo escapeAdminCategoryHtml((string) $sortOrder); ?>"
                                        >
                                    </div>

                                    <div class="kn-form-field">
                                        <label>
                                            <input
                                                type="checkbox"
                                                name="is_active"
                                                value="1"
                                                <?php echo $isActive ? 'checked' : ''; ?>
                                            >
                                            Active
                                        </label>
                                    </div>
                                </div>

                                <div class="kn-button-group">
                                    <button class="kn-button kn-button-primary" type="submit">
                                        <?php echo $isEditing ? 'Save Category' : 'Create Category'; ?>
                                    </button>

                                    <?php if ($isEditing): ?>
                                        <a href="/admin/categories/" class="kn-button kn-button-ghost">Cancel Edit</a>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </form>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Category List</h2>

                                <p>
                                    Categories are ordered by sort order, then name.
                                </p>
                            </div>

                            <?php if ($categories): ?>
                                <div class="kn-stack">
                                    <?php foreach ($categories as $category): ?>
                                        <article class="kn-card kn-stack">
                                            <div>
                                                <p class="kn-small-text kn-text-primary">
                                                    <?php echo $category['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    • <?php echo escapeAdminCategoryHtml((string) $category['post_count']); ?> posts
                                                </p>

                                                <h3><?php echo escapeAdminCategoryHtml($category['name']); ?></h3>

                                                <p class="kn-small-text kn-text-muted">
                                                    Slug: <?php echo escapeAdminCategoryHtml($category['slug']); ?>
                                                </p>
                                            </div>

                                            <?php if ($category['description']): ?>
                                                <p>
                                                    <?php echo escapeAdminCategoryHtml($category['description']); ?>
                                                </p>
                                            <?php endif; ?>

                                            <dl>
                                                <dt>Sort Order</dt>
                                                <dd><?php echo escapeAdminCategoryHtml((string) $category['sort_order']); ?></dd>

                                                <dt>Created</dt>
                                                <dd><?php echo escapeAdminCategoryHtml(formatAdminCategoryDate($category['created_at'])); ?></dd>

                                                <dt>Updated</dt>
                                                <dd><?php echo escapeAdminCategoryHtml(formatAdminCategoryDate($category['updated_at'])); ?></dd>
                                            </dl>

                                            <div class="kn-button-group">
                                                <a href="/admin/categories/?edit_id=<?php echo escapeAdminCategoryHtml((string) $category['id']); ?>" class="kn-button kn-button-primary">Edit</a>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="kn-card kn-stack">
                                    <h3>No categories found.</h3>

                                    <p>
                                        Create the first category to organize blog posts.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminCategoryHtml($currentUser['display_name']); ?>.
                            </p>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/categories/" class="kn-button kn-button-primary kn-full-width">Categories</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary kn-full-width">Manage Posts</a>
                                <a href="/admin/tags/" class="kn-button kn-button-secondary kn-full-width">Tags</a>
                                <a href="/admin/" class="kn-button kn-button-secondary kn-full-width">Dashboard</a>
                                <a href="/admin/logout.php" class="kn-button kn-button-ghost kn-full-width">Log Out</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Category Notes</h2>

                            <ul class="kn-feature-list">
                                <li>Use categories for broad topics.</li>
                                <li>Use tags for more specific keywords.</li>
                                <li>Inactive categories stay in the database but are hidden from active selection lists.</li>
                                <li>Sort order controls category display priority.</li>
                            </ul>
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