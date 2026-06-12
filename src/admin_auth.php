<?php
declare(strict_types=1);

/**
 * Admin authentication helpers.
 *
 * This file does not replace config/session.php.
 *
 * Intended admin page order:
 * 1. Set $pageLocked = "admin";
 * 2. require config/session.php;
 * 3. require config/nickolaspatino_db.php;
 * 4. require src/admin_auth.php;
 * 5. call nickolas_require_admin_user($pdo);
 */

if (!function_exists('nickolas_clear_admin_session')) {
    function nickolas_clear_admin_session(): void
    {
        unset(
            $_SESSION['admin_user_id'],
            $_SESSION['admin_user_role'],
            $_SESSION['admin_display_name'],
            $_SESSION['admin_email']
        );

        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id(true);
        }
    }
}

if (!function_exists('nickolas_redirect_to_admin_login')) {
    function nickolas_redirect_to_admin_login(): never
    {
        header('Location: /admin/login.php', true, 303);
        exit();
    }
}

if (!function_exists('nickolas_require_admin_user')) {
    function nickolas_require_admin_user(PDO $pdo, array $allowedRoles = []): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!$allowedRoles) {
            $allowedRoles = [
                'owner',
                'admin',
                'editor',
                'author',
            ];
        }

        $adminUserId = $_SESSION['admin_user_id'] ?? null;
        $adminUserRole = $_SESSION['admin_user_role'] ?? null;

        if (!$adminUserId || !in_array($adminUserRole, $allowedRoles, true)) {
            nickolas_clear_admin_session();
            nickolas_redirect_to_admin_login();
        }

        $currentUserStatement = $pdo->prepare("
            SELECT
                id,
                display_name,
                email,
                user_role,
                account_status,
                last_login_at,
                created_at,
                updated_at
            FROM users
            WHERE id = :id
            LIMIT 1
        ");

        $currentUserStatement->execute([
            ':id' => (int) $adminUserId,
        ]);

        $currentUser = $currentUserStatement->fetch(PDO::FETCH_ASSOC);

        if (
            !$currentUser ||
            $currentUser['account_status'] !== 'active' ||
            !in_array($currentUser['user_role'], $allowedRoles, true)
        ) {
            nickolas_clear_admin_session();
            nickolas_redirect_to_admin_login();
        }

        $_SESSION['admin_user_id'] = (int) $currentUser['id'];
        $_SESSION['admin_user_role'] = $currentUser['user_role'];
        $_SESSION['admin_display_name'] = $currentUser['display_name'];
        $_SESSION['admin_email'] = $currentUser['email'];

        return $currentUser;
    }
}

if (!function_exists('nickolas_admin_has_role')) {
    function nickolas_admin_has_role(array $currentUser, string|array $roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return in_array($currentUser['user_role'] ?? '', $roles, true);
    }
}

if (!function_exists('nickolas_require_admin_role')) {
    function nickolas_require_admin_role(array $currentUser, string|array $roles, string $redirectTo = '/admin/'): void
    {
        if (!nickolas_admin_has_role($currentUser, $roles)) {
            header('Location: ' . $redirectTo, true, 303);
            exit();
        }
    }
}