<?php
require '../includes/auth.php';
require '../config/db_connect.php';
include '../includes/header.php';

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("
    SELECT wr.RequestID, c.CourseName, wr.RequestDate, wr.Status
    FROM withdrawal_request wr
    JOIN course c ON wr.CourseID = c.CourseID
    WHERE wr.UserID = :userid
    ORDER BY wr.RequestDate DESC
");
$stmt->execute([':userid' => $_SESSION['userID']]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <h2>View My Requests</h2>
    <?php if ($requests): ?>
        <table>
            <tr><th>Course</th><th>Date</th><th>Status</th></tr>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['CourseName']) ?></td>
                    <td><?= htmlspecialchars($r['RequestDate']) ?></td>
                    <td><?= htmlspecialchars($r['Status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No requests found.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
