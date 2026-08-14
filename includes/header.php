<?php
/**
 * Shared Header + Sidebar Navigation (mobile-responsive)
 * ---------------------------------------------------------
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

<!-- Mobile-only top bar with hamburger toggle -->
<div class="mobile-topbar">
    <button id="sidebarToggle" class="hamburger-btn" aria-label="Open menu">
        <i class="fa-solid fa-bars"></i>
    </button>
    <span class="mobile-logo"><i class="fa-solid fa-book-open"></i> Library System</span>
</div>

<!-- Overlay shown behind the sidebar when open on mobile -->
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<div class="layout">

    <aside class="sidebar" id="sidebar">
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
                <a href="auth/logout.php" class="logout-btn">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        width="18"
        height="18"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
    </svg>

    <span>Logout</span>
</a>

<style>
.logout-btn {
    position: fixed;
    top: 20px;
    right: 24px;
    z-index: 9999;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 10px 16px;

    background: #dc2626;
    color: #ffffff;

    border: none;
    border-radius: 8px;

    font-family: Arial, sans-serif;
    font-size: 14px;
    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.logout-btn:hover {
    background: #b91c1c;
    transform: translateY(-1px);
}

.logout-btn:active {
    transform: translateY(0);
}

@media (max-width: 480px) {
    .logout-btn {
        top: 14px;
        right: 14px;
        padding: 9px 12px;
    }

    .logout-btn span {
        display: none;
    }
}
</style>
            </ul>
        </nav>
    </aside>

    <div class="main-column">
        <main class="site-content">
