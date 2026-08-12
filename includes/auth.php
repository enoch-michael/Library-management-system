<?php
session_start();

// Check if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Only allow admin accounts
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    session_unset();
    session_destroy();

    header("Location: ../auth/login.php");
    exit;
}
