<?php
require_once '../config/db.php';
include '../includes/header.php';

$result = $conn->query("
    SELECT members.*,
           SUM(CASE WHEN issued_books.status = 'issued' THEN 1 ELSE 0 END) AS active_issues
    FROM members
    LEFT JOIN issued_books ON issued_books.member_id = members.member_id
    GROUP BY members.member_id
    ORDER BY members.full_name
");
?>

<h1>All Members</h1>

<p><a href="add.php" class="btn">+ Add New Member</a></p>

<div class="table-responsive">
<table>
    <tr>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Books Currently Issued</th>
        <th>Actions</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone'] ?: '—'); ?></td>
            <td><?php echo (int)$row['active_issues']; ?></td>
            <td class="actions">
                <a href="edit.php?id=<?php echo (int)$row['member_id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo (int)$row['member_id']; ?>"
                   class="delete-link"
                   onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">No members found.</td></tr>
    <?php endif; ?>
</table>
</div>

<?php
include '../includes/footer.php';
$conn->close();
?>
