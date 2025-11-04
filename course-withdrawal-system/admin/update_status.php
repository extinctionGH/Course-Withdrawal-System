<?php
require '../includes/auth.php';
require '../config/db_connect.php';

if (strtolower($_SESSION['role']) !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['id'], $_POST['status'])) {
    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("UPDATE withdrawal_request SET Status = :status WHERE RequestID = :id");
    $stmt->execute([
        ':status' => $_POST['status'],
        ':id' => $_POST['id']
    ]);
}

header("Location: review_requests.php");
exit();
?>
