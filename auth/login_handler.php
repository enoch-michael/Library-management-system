<?php
session_start();
require_once __DIR__ . '/../config/db.php'; // provides $conn (mysqli)

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

if ($email === '' || $password === '') {
    $_SESSION['login_error'] = "Please enter both email and password.";
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT admin_id, full_name, email, password FROM admins WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

if ($admin && password_verify($password, $admin['password'])) {
    // Prevent session fixation
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['admin_name'] = $admin['full_name'];
    $_SESSION['admin_email'] = $admin['email'];

    
    if ($remember) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            session_id(),
            time() + (30 * 24 * 60 * 60),
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    header("Location: ../index.php");
    exit;
} else {
    $_SESSION['login_error'] = "Invalid email or password.";
    header("Location: login.php");
    exit;
}
