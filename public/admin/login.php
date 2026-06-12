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

$pageTitle = "Nickolas Patino | Admin Login";
$pageDescription = "Admin login for NickolasPatino.com.";

function escapeAdminLoginHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function cleanAdminLoginInput(string $value): string
{
    return trim(strip_tags($value));
}

function isValidAdminCsrfToken(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

$allowedRoles = [
    'owner',
    'admin',
    'editor',
    'author',
];

if (
    !empty($_SESSION['admin_user_id']) &&
    !empty($_SESSION['admin_user_role']) &&
    in_array($_SESSION['admin_user_role'], $allowedRoles, true)
) {
    header('Location: /admin/');
    exit();
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = cleanAdminLoginInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!isValidAdminCsrfToken($csrfToken)) {
        $errors[] = 'Your session expired. Please refresh the page and try again.';
    }

    if ($email === '') {
        $errors[] = 'Email is required.';
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (!$errors) {
        $userStatement = $pdo->prepare("
            SELECT
                id,
                display_name,
                email,
                password_hash,
                user_role,
                account_status
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $userStatement->execute([
            ':email' => $email,
        ]);

        $user = $userStatement->fetch(PDO::FETCH_ASSOC);

        if (
            !$user ||
            $user['account_status'] !== 'active' ||
            !in_array($user['user_role'], $allowedRoles, true) ||
            !password_verify($password, $user['password_hash'])
        ) {
            $errors[] = 'Invalid login. Check your email and password, then try again.';
        } else {
            session_regenerate_id(true);

            $_SESSION['admin_user_id'] = (int) $user['id'];
            $_SESSION['admin_user_role'] = $user['user_role'];
            $_SESSION['admin_display_name'] = $user['display_name'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            $updateLoginStatement = $pdo->prepare("
                UPDATE users
                SET last_login_at = CURRENT_TIMESTAMP
                WHERE id = :id
                LIMIT 1
            ");

            $updateLoginStatement->execute([
                ':id' => $user['id'],
            ]);

            header('Location: /admin/');
            exit();
        }
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
                    <article class="kn-card kn-stack">
                        <div class="kn-text-block">
                            <p class="kn-small-text kn-text-primary">
                                Admin Access
                            </p>

                            <h1>Admin login.</h1>

                            <p class="kn-lead">
                                Sign in to manage blog posts, media, categories, tags, and site content.
                            </p>
                        </div>

                        <?php if (isset($_GET['logged_out']) && $_GET['logged_out'] === '1'): ?>
                            <div class="kn-card kn-stack">
                                <h2>Logged Out</h2>

                                <p>
                                    You have been logged out successfully.
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if ($errors): ?>
                            <div class="kn-card kn-stack">
                                <h2>Login Failed</h2>

                                <ul class="kn-feature-list">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo escapeAdminLoginHtml($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form class="kn-form kn-stack" method="post" action="/admin/login.php">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeAdminLoginHtml($csrfToken); ?>">

                            <div class="kn-form-field">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    maxlength="190"
                                    autocomplete="username"
                                    required
                                    value="<?php echo escapeAdminLoginHtml($email); ?>"
                                >
                            </div>

                            <div class="kn-form-field">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    maxlength="255"
                                    autocomplete="current-password"
                                    required
                                >
                            </div>

                            <div class="kn-button-group">
                                <button class="kn-button kn-button-primary" type="submit">Log In</button>
                                <a href="/" class="kn-button kn-button-ghost">Back to Website</a>
                            </div>
                        </form>
                    </article>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Admin Area</h2>

                            <p>
                                This area is for managing the NickolasPatino.com blog and related content.
                            </p>

                            <ul class="kn-feature-list">
                                <li>Create and edit blog posts</li>
                                <li>Manage draft, scheduled, and published content</li>
                                <li>Upload and organize blog images</li>
                                <li>Manage categories and tags</li>
                            </ul>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Security Notes</h2>

                            <ul class="kn-feature-list">
                                <li>Use a strong password.</li>
                                <li>Log out when finished.</li>
                                <li>Do not share admin access.</li>
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