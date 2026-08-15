<?php
/**
 * Authentication Helper Functions
 * -----------------------------------
 * Include this at the top of EVERY protected page, before any HTML:
 *
 *   require_once '../includes/auth.php';
 *   requireLogin();
 *
 * This restores isLoggedIn(), requireLogin(), requireRole(), and
 * currentUser() — required by header.php, register.php, and every
 * module's CRUD pages. It stays compatible with the newer email-based
 * login in auth/index.php + auth/login_handler.php, which sets these
 * same session keys: user_id, username, user_email, role.
 */

require_once __DIR__ . '/../config/paths.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header("Location: " . BASE_URL . "auth/index.php");
        exit;
    }
}

function requireRole(string $role): void {
    requireLogin();
    if (($_SESSION['role'] ?? '') !== $role) {
        http_response_code(403);
        die("Access denied — this page requires the '$role' role.");
    }
}

function currentUser(): ?array {
    if (!isLoggedIn()) {
        return null;
    }
    return [
        'id'       => $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? '',
        'email'    => $_SESSION['user_email'] ?? '',
        'role'     => $_SESSION['role'] ?? '',
    ];
}
?>
