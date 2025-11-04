<?php
require '../includes/auth.php';
require '../config/db_connect.php';
include '../includes/header.php';

$db = new Database();
$conn = $db->connect();

$currentDateTime = date('Y-m-d H:i:s');

$query = "
    SELECT wr.RequestID, u.FullName, c.CourseName, wr.RequestDate, wr.Reason, wr.Status
    FROM withdrawal_request wr
    JOIN user u ON wr.UserID = u.UserID
    JOIN course c ON wr.CourseID = c.CourseID
    WHERE wr.RequestDate <= :currentDateTime
    ORDER BY wr.RequestDate DESC
";

$stmt = $conn->prepare($query);
$stmt->execute([':currentDateTime' => $currentDateTime]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="card">
    <h2>All Withdrawal Requests</h2>
    <?php if ($requests): ?>
        <table>
            <tr><th>Student</th><th>Course</th><th>Reason</th><th>Date</th><th>Status</th></tr>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['FullName']) ?></td>
                    <td><?= htmlspecialchars($r['CourseName']) ?></td>
                    <td><?= htmlspecialchars($r['Reason']) ?></td>
                    <td><?= htmlspecialchars($r['RequestDate']) ?></td>
                    <td><?= htmlspecialchars($r['Status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No requests yet.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
