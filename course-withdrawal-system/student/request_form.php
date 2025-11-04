<?php
require '../includes/auth.php';
require '../config/db_connect.php';
include '../includes/header.php';

$db = new Database();
$conn = $db->connect();
$message = "";

$courses = $conn->query("SELECT * FROM course ORDER BY CourseName ASC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseID = $_POST['course_id'];
    $reason = trim($_POST['reason']);

    if (!empty($courseID) && !empty($reason)) {
        $stmt = $conn->prepare("
            INSERT INTO withdrawal_request (UserID, CourseID, Reason, RequestDate, Status)
            VALUES (:userID, :courseID, :reason, NOW(), 'Pending')
        ");
        $stmt->execute([
            ':userID' => $_SESSION['userID'],
            ':courseID' => $courseID,
            ':reason' => $reason
        ]);
        $message = "Withdrawal request submitted successfully.";
    } else {
        $message = "Please fill out all fields.";
    }
}
?>

<div class="card">
    <h2>Submit Course Withdrawal Request</h2>
    <?php if ($message): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>
    <form method="POST">
        <label>Course:</label>
        <select name="course_id" required>
            <option value="">-- Choose a Course --</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= htmlspecialchars($course['CourseID']) ?>">
                    <?= htmlspecialchars($course['CourseName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label>Reason:</label>
        <textarea name="reason" rows="5" cols="50" required></textarea>
        <br><br>
        <button type="submit">Submit</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
