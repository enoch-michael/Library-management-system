<?php
require_once 'config/db.php';
include 'includes/header.php';
require_once __DIR__ . '/includes/auth.php';

$total_books   = $conn->query("SELECT COUNT(*) AS c FROM books")->fetch_assoc()['c'];
$total_authors = $conn->query("SELECT COUNT(*) AS c FROM authors")->fetch_assoc()['c'];
$total_members = $conn->query("SELECT COUNT(*) AS c FROM members")->fetch_assoc()['c'];
$total_issued  = $conn->query("SELECT COUNT(*) AS c FROM issued_books WHERE status = 'issued'")->fetch_assoc()['c'];
?>

<section class="hero">
    <div class="hero-icon"><i class="fa-solid fa-book-open"></i></div>
    <h1>Welcome to the Library Management System</h1>
    <p>Manage books, authors, members, and track issued records &mdash; all in one place.</p>
</section>

<section class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-blue"><i class="fa-solid fa-book-open"></i></div>
        <h2><?php echo $total_books; ?></h2>
        <p>Total Books</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-green"><i class="fa-solid fa-feather-pointed"></i></div>
        <h2><?php echo $total_authors; ?></h2>
        <p>Total Authors</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-purple"><i class="fa-solid fa-users"></i></div>
        <h2><?php echo $total_members; ?></h2>
        <p>Total Members</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-orange"><i class="fa-solid fa-bookmark"></i></div>
        <h2><?php echo $total_issued; ?></h2>
        <p>Books Currently Issued</p>
    </div>
</section>

<section class="quick-links">
    <h2>Quick Actions</h2>
    <div class="quick-links-grid">
        <a href="books/add.php" class="quick-link">
            <span class="quick-link-icon"><i class="fa-solid fa-circle-plus"></i></span> Add New Book
        </a>
        <a href="books/view.php" class="quick-link">
            <span class="quick-link-icon"><i class="fa-solid fa-book-open"></i></span> View All Books
        </a>
        <a href="issue_return/issue.php" class="quick-link">
            <span class="quick-link-icon"><i class="fa-solid fa-arrow-up-from-bracket"></i></span> Issue a Book
        </a>
        <a href="issue_return/return.php" class="quick-link">
            <span class="quick-link-icon"><i class="fa-solid fa-arrow-down-to-bracket"></i></span> Return a Book
        </a>
        <a href="search.php" class="quick-link">
            <span class="quick-link-icon"><i class="fa-solid fa-magnifying-glass"></i></span> Search Books
        </a>
    </div>
</section>

<?php
include 'includes/footer.php';
$conn->close();
?>
