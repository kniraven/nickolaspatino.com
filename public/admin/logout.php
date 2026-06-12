<?php
declare(strict_types=1);

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);

require_once $projectRoot . '/config/session.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $cookieParams = session_get_cookie_params();

    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $cookieParams['path'] ?? '/',
        'domain' => $cookieParams['domain'] ?? '',
        'secure' => (bool) ($cookieParams['secure'] ?? false),
        'httponly' => (bool) ($cookieParams['httponly'] ?? true),
        'samesite' => $cookieParams['samesite'] ?? 'Lax',
    ]);
}

session_destroy();

header('Location: /admin/login.php?logged_out=1', true, 303);
exit();