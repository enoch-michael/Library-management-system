<?php
/**
 * Shared Header + Sidebar Navigation
 * -------------------------------------
 * Include this at the top of every page, AFTER db.php and any PHP
 * logic, but BEFORE your HTML content.
 *
 * From project root:      include 'includes/header.php';
 * From a subfolder:       include '../includes/header.php';
 */

if (!defined('BASE_URL')) {
    define('BASE_URL', '/library-system/');
}

// Work out which nav item should be highlighted as "active"
$current_page = basename($_SERVER['PHP_SELF']);
$current_folder = basename(dirname($_SERVER['PHP_SELF']));

function nav_active($page, $folder = null) {
    global $current_page, $current_folder;
    if ($folder !== null) {
        return ($current_folder === $folder) ? 'active' : '';
    }
    return ($current_page === $page) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>

<div class="layout">

    <aside class="sidebar">
        <nav class="sidebar-nav">
            <ul>
                <li class="<?php echo nav_active('index.php'); ?>">
                    <a href="<?php echo BASE_URL; ?>index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
                </li>
                <li class="<?php echo nav_active(null, 'books'); ?>">
                    <a href="<?php echo BASE_URL; ?>books/view.php"><i class="fa-solid fa-book-open"></i> Books</a>
                </li>
                <li class="<?php echo nav_active(null, 'authors'); ?>">
                    <a href="<?php echo BASE_URL; ?>authors/view.php"><i class="fa-solid fa-user"></i> Authors</a>
                </li>
                <li class="<?php echo nav_active(null, 'members'); ?>">
                    <a href="<?php echo BASE_URL; ?>members/view.php"><i class="fa-solid fa-users"></i> Members</a>
                </li>
                <li class="<?php echo nav_active('issue.php'); ?>">
                    <a href="<?php echo BASE_URL; ?>issue_return/issue.php"><i class="fa-solid fa-arrow-up-from-bracket"></i> Issue Book</a>
                </li>
                <li class="<?php echo nav_active('return.php'); ?>">
                    <a href="<?php echo BASE_URL; ?>issue_return/return.php"><i class="fa-solid fa-arrow-down-to-bracket"></i> Return Book</a>
                </li>
                <li class="<?php echo nav_active('status.php'); ?>">
                    <a href="<?php echo BASE_URL; ?>issue_return/status.php"><i class="fa-regular fa-clock"></i> Issued/Overdue</a>
                </li>
                <li class="<?php echo nav_active('search.php'); ?>">
                    <a href="<?php echo BASE_URL; ?>search.php"><i class="fa-solid fa-magnifying-glass"></i> Search</a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="main-column">
        <main class="site-content">
