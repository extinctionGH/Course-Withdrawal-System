<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Withdrawal System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
    <h1>Course Withdrawal System</h1>
    <div class="user-info">
        <span>Logged in as: <?= htmlspecialchars($_SESSION['fullName']) ?></span>
        <a href="../auth/logout.php">Logout</a>
    </div>
</header>
<div class="sidebar">
    <?php if (strtolower($_SESSION['role']) === 'admin'): ?>
        <a href="../admin/dashboard.php" class="active">Dashboard</a>
        <a href="../admin/review_requests.php">Review Requests</a>
        <a href="../admin/manage_courses.php">Manage Courses</a>
        <a href="../admin/manage_students.php">Manage Students</a>
    <?php else: ?>
        <a href="../student/dashboard.php" class="active">Dashboard</a>
        <a href="../student/request_form.php">Submit Request</a>
        <a href="../student/view_requests.php">View Requests</a>
    <?php endif; ?>
</div>
<div class="main-content">
