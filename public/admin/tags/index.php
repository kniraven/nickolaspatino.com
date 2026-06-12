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

$pageTitle = "Nickolas Patino | Manage Tags";
$pageDescription = "Manage blog tags for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminTagHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function cleanAdminTagText(string $value): string
{
    return trim(strip_tags($value));
}

function makeAdminTagSlug(string $value): string
{
    $slug = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug) ?? '';
    $slug = trim($slug, '-');

    if ($slug === '') {
        $slug = 'tag-' . date('YmdHis');
    }

    return substr($slug, 0, 140);
}

function makeUniqueAdminTagSlug(PDO $pdo, string $baseSlug, int $tagId = 0): string
{
    $baseSlug = substr($baseSlug, 0, 130);
    $slug = $baseSlug;
    $counter = 2;

    while (true) {
        $slugStatement = $pdo->prepare("
            SELECT COUNT(*)
            FROM blog_tags
            WHERE slug = :slug
                AND id != :id
        ");

        $slugStatement->execute([
            ':slug' => $slug,
            ':id' => $tagId,
        ]);

        if ((int) $slugStatement->fetchColumn() === 0) {
            return $slug;
        }

        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }
}

function formatAdminTagDate(?string $value): string
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

function isValidAdminTagCsrfToken(?string $token): bool
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

$editTagId = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : 0;
$isEditing = $editTagId > 0;

$name = '';
$slug = '';
$description = '';

if ($isEditing) {
    $editTagStatement = $pdo->prepare("
        SELECT
            id,
            name,
            slug,
            description,
            created_at,
            updated_at
        FROM blog_tags
        WHERE id = :id
        LIMIT 1
    ");

    $editTagStatement->execute([
        ':id' => $editTagId,
    ]);

    $editTag = $editTagStatement->fetch(PDO::FETCH_ASSOC);

    if (!$editTag) {
        header('Location: /admin/tags/?missing=1', true, 303);
        exit();
    }

    $name = $editTag['name'];
    $slug = $editTag['slug'];
    $description = $editTag['description'] ?? '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $action = cleanAdminTagText($_POST['action'] ?? 'create');
    $postedTagId = isset($_POST['tag_id']) ? (int) $_POST['tag_id'] : 0;

    $name = cleanAdminTagText($_POST['name'] ?? '');
    $slug = cleanAdminTagText($_POST['slug'] ?? '');
    $description = cleanAdminTagText($_POST['description'] ?? '');

    $isEditing = $action === 'update';
    $editTagId = $isEditing ? $postedTagId : 0;

    if (!isValidAdminTagCsrfToken($csrfToken)) {
        $errors[] = 'Your session expired. Please refresh the page and try again.';
    }

    if (!in_array($action, ['create', 'update'], true)) {
        $errors[] = 'Choose a valid tag action.';
    }

    if ($isEditing && $editTagId <= 0) {
        $errors[] = 'Choose a valid tag to update.';
    }

    if ($name === '') {
        $errors[] = 'Tag name is required.';
    }

    if (strlen($name) > 120) {
        $errors[] = 'Tag name must be 120 characters or fewer.';
    }

    if ($slug !== '' && strlen($slug) > 140) {
        $errors[] = 'Slug must be 140 characters or fewer.';
    }

    if (!$errors && $isEditing) {
        $existingTagStatement = $pdo->prepare("
            SELECT COUNT(*)
            FROM blog_tags
            WHERE id = :id
        ");

        $existingTagStatement->execute([
            ':id' => $editTagId,
        ]);

        if ((int) $existingTagStatement->fetchColumn() === 0) {
            $errors[] = 'The tag you are trying to update no longer exists.';
        }
    }

    if (!$errors) {
        $duplicateNameStatement = $pdo->prepare("
            SELECT COUNT(*)
            FROM blog_tags
            WHERE name = :name
                AND id != :id
        ");

        $duplicateNameStatement->execute([
            ':name' => $name,
            ':id' => $editTagId,
        ]);

        if ((int) $duplicateNameStatement->fetchColumn() > 0) {
            $errors[] = 'A tag with that name already exists.';
        }
    }

    if (!$errors) {
        $baseSlug = makeAdminTagSlug($slug !== '' ? $slug : $name);
        $uniqueSlug = makeUniqueAdminTagSlug($pdo, $baseSlug, $editTagId);
        $descriptionValue = $description !== '' ? $description : null;

        try {
            if ($isEditing) {
                $updateTagStatement = $pdo->prepare("
                    UPDATE blog_tags
                    SET
                        name = :name,
                        slug = :slug,
                        description = :description
                    WHERE id = :id
                    LIMIT 1
                ");

                $updateTagStatement->execute([
                    ':name' => $name,
                    ':slug' => $uniqueSlug,
                    ':description' => $descriptionValue,
                    ':id' => $editTagId,
                ]);

                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: /admin/tags/?updated=1&edit_id=' . $editTagId, true, 303);
                exit();
            }

            $insertTagStatement = $pdo->prepare("
                INSERT INTO blog_tags (
                    name,
                    slug,
                    description
                ) VALUES (
                    :name,
                    :slug,
                    :description
                )
            ");

            $insertTagStatement->execute([
                ':name' => $name,
                ':slug' => $uniqueSlug,
                ':description' => $descriptionValue,
            ]);

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            header('Location: /admin/tags/?created=1', true, 303);
            exit();
        } catch (Throwable $exception) {
            $errors[] = 'The tag could not be saved. Please check the form and try again.';
        }
    }
}

$tagCountStatement = $pdo->query("
    SELECT
        COUNT(*) AS total_count,
        SUM(CASE WHEN post_count > 0 THEN 1 ELSE 0 END) AS used_count,
        SUM(CASE WHEN post_count = 0 THEN 1 ELSE 0 END) AS unused_count
    FROM (
        SELECT
            blog_tags.id,
            COUNT(blog_posts.id) AS post_count
        FROM blog_tags
        LEFT JOIN blog_post_tags
            ON blog_post_tags.tag_id = blog_tags.id
        LEFT JOIN blog_posts
            ON blog_post_tags.post_id = blog_posts.id
            AND blog_posts.deleted_at IS NULL
        GROUP BY blog_tags.id
    ) AS counted_tags
");

$tagCounts = $tagCountStatement->fetch(PDO::FETCH_ASSOC);

$tagsStatement = $pdo->query("
    SELECT
        blog_tags.id,
        blog_tags.name,
        blog_tags.slug,
        blog_tags.description,
        blog_tags.created_at,
        blog_tags.updated_at,
        COUNT(blog_posts.id) AS post_count
    FROM blog_tags
    LEFT JOIN blog_post_tags
        ON blog_post_tags.tag_id = blog_tags.id
    LEFT JOIN blog_posts
        ON blog_post_tags.post_id = blog_posts.id
        AND blog_posts.deleted_at IS NULL
    GROUP BY
        blog_tags.id,
        blog_tags.name,
        blog_tags.slug,
        blog_tags.description,
        blog_tags.created_at,
        blog_tags.updated_at
    ORDER BY blog_tags.name ASC
");

$tags = $tagsStatement->fetchAll(PDO::FETCH_ASSOC);

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

                            <h1>Tags.</h1>

                            <p class="kn-lead">
                                Create and edit blog tags for more specific post organization.
                            </p>

                            <div class="kn-button-group">
                                <a href="/admin/posts/" class="kn-button kn-button-secondary">Manage Posts</a>
                                <a href="/admin/categories/" class="kn-button kn-button-secondary">Categories</a>
                                <a href="/admin/" class="kn-button kn-button-ghost">Admin Dashboard</a>
                            </div>
                        </div>

                        <?php if (isset($_GET['created']) && $_GET['created'] === '1'): ?>
                            <article class="kn-card kn-stack">
                                <h2>Tag Created</h2>

                                <p>
                                    The tag was created successfully.
                                </p>
                            </article>
                        <?php endif; ?>

                        <?php if (isset($_GET['updated']) && $_GET['updated'] === '1'): ?>
                            <article class="kn-card kn-stack">
                                <h2>Tag Updated</h2>

                                <p>
                                    The tag was saved successfully.
                                </p>
                            </article>
                        <?php endif; ?>

                        <?php if ($errors): ?>
                            <article class="kn-card kn-stack">
                                <h2>Tag Not Saved</h2>

                                <ul class="kn-feature-list">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo escapeAdminTagHtml($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        <?php endif; ?>

                        <div class="kn-grid">
                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminTagHtml((string) ($tagCounts['total_count'] ?? 0)); ?></h2>
                                <p>Total Tags</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminTagHtml((string) ($tagCounts['used_count'] ?? 0)); ?></h2>
                                <p>Used</p>
                            </article>

                            <article class="kn-card kn-stack">
                                <h2><?php echo escapeAdminTagHtml((string) ($tagCounts['unused_count'] ?? 0)); ?></h2>
                                <p>Unused</p>
                            </article>
                        </div>

                        <form class="kn-form kn-stack" method="post" action="/admin/tags/">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeAdminTagHtml($csrfToken); ?>">
                            <input type="hidden" name="action" value="<?php echo $isEditing ? 'update' : 'create'; ?>">
                            <input type="hidden" name="tag_id" value="<?php echo escapeAdminTagHtml((string) $editTagId); ?>">

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2><?php echo $isEditing ? 'Edit Tag' : 'Create Tag'; ?></h2>

                                    <p>
                                        Tags are used for specific keywords, technologies, tools, and topics.
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
                                            value="<?php echo escapeAdminTagHtml($name); ?>"
                                        >
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="slug">Slug</label>
                                        <input
                                            type="text"
                                            id="slug"
                                            name="slug"
                                            maxlength="140"
                                            value="<?php echo escapeAdminTagHtml($slug); ?>"
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
                                        placeholder="Optional tag description"
                                    ><?php echo escapeAdminTagHtml($description); ?></textarea>
                                </div>

                                <div class="kn-button-group">
                                    <button class="kn-button kn-button-primary" type="submit">
                                        <?php echo $isEditing ? 'Save Tag' : 'Create Tag'; ?>
                                    </button>

                                    <?php if ($isEditing): ?>
                                        <a href="/admin/tags/" class="kn-button kn-button-ghost">Cancel Edit</a>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </form>

                        <article class="kn-card kn-stack">
                            <div class="kn-text-block">
                                <h2>Tag List</h2>

                                <p>
                                    Tags are ordered alphabetically.
                                </p>
                            </div>

                            <?php if ($tags): ?>
                                <div class="kn-stack">
                                    <?php foreach ($tags as $tag): ?>
                                        <article class="kn-card kn-stack">
                                            <div>
                                                <p class="kn-small-text kn-text-primary">
                                                    <?php echo escapeAdminTagHtml((string) $tag['post_count']); ?> posts
                                                </p>

                                                <h3><?php echo escapeAdminTagHtml($tag['name']); ?></h3>

                                                <p class="kn-small-text kn-text-muted">
                                                    Slug: <?php echo escapeAdminTagHtml($tag['slug']); ?>
                                                </p>
                                            </div>

                                            <?php if ($tag['description']): ?>
                                                <p>
                                                    <?php echo escapeAdminTagHtml($tag['description']); ?>
                                                </p>
                                            <?php endif; ?>

                                            <dl>
                                                <dt>Created</dt>
                                                <dd><?php echo escapeAdminTagHtml(formatAdminTagDate($tag['created_at'])); ?></dd>

                                                <dt>Updated</dt>
                                                <dd><?php echo escapeAdminTagHtml(formatAdminTagDate($tag['updated_at'])); ?></dd>
                                            </dl>

                                            <div class="kn-button-group">
                                                <a href="/admin/tags/?edit_id=<?php echo escapeAdminTagHtml((string) $tag['id']); ?>" class="kn-button kn-button-primary">Edit</a>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="kn-card kn-stack">
                                    <h3>No tags found.</h3>

                                    <p>
                                        Create the first tag to add keyword-level organization.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminTagHtml($currentUser['display_name']); ?>.
                            </p>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/tags/" class="kn-button kn-button-primary kn-full-width">Tags</a>
                                <a href="/admin/categories/" class="kn-button kn-button-secondary kn-full-width">Categories</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary kn-full-width">Manage Posts</a>
                                <a href="/admin/" class="kn-button kn-button-secondary kn-full-width">Dashboard</a>
                                <a href="/admin/logout.php" class="kn-button kn-button-ghost kn-full-width">Log Out</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Tag Notes</h2>

                            <ul class="kn-feature-list">
                                <li>Use tags for specific tools, skills, technologies, or themes.</li>
                                <li>Use categories for broader post groups.</li>
                                <li>Tags can be attached to posts after the post editor supports tag selection.</li>
                                <li>Unused tags can stay available for future posts.</li>
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