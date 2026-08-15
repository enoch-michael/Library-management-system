<?php
require_once __DIR__ . '/../config/paths.php';
session_start();

require_once __DIR__ . '/../config/db.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Validate input
if ($email === '' || $password === '') {
    $_SESSION['login_error'] = "Please enter both email and password.";
    header("Location: index.php");
    exit;
}

// Find user by email
$stmt = $conn->prepare(
    "SELECT user_id, username, email, password_hash, role
     FROM users
     WHERE email = ?
     LIMIT 1"
);

if (!$stmt) {
    $_SESSION['login_error'] = "Something went wrong. Please try again.";
    header("Location: index.php");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

// Check credentials AND make sure the user is an admin
if (
    $user &&
    $user['role'] === 'admin' &&
    password_verify($password, $user['password_hash'])
) {

    // Prevent session fixation
    session_regenerate_id(true);

    // Store authenticated admin information
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    // Optional "Remember Me"
    if ($remember) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            session_id(),
            [
                'expires' => time() + (30 * 24 * 60 * 60),
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => 'Lax'
            ]
        );
    }

    // Login successful
    header("Location: " . BASE_URL . "index.php");
    exit;

} else {

    // Don't reveal whether the email or password was wrong
    $_SESSION['login_error'] = "Invalid email or password.";

    header("Location: index.php");
    exit;
}
