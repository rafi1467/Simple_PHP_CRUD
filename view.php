<?php
/**
 * READ (Single): View a single student's details by ID
 */
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT * FROM students WHERE id = $id"; // parameter binding is not used here, but casting to int helps prevent SQL injection
$result = mysqli_query($conn, $sql);
$student = $result ? mysqli_fetch_assoc($result) : null;

if (!$student) {
    die('Studnet not found. <a href="index.php">Go back to list</a>');
}

include __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="page-header">
        <h1>Student Details (#<?php echo (int) $student['id']; ?>)</h1>
        <a href="index.php" class="btn btn-secondary">&larr; Back to List</a>
    </div>

    <div class="detail-row">
        <div class="detail-label">ID</div>
        <div class="detail-value"><?php echo (int) $student['id']; ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Full Name</div>
        <div class="detail-value"><?php echo htmlspecialchars($student['name']); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Email Address</div>
        <div class="detail-value"><?php echo htmlspecialchars($student['email']); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Phone Number</div>
        <div class="detail-value"><?php echo htmlspecialchars($student['phone']); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Department</div>
        <div class="detail-value"><span class="badge"><?php echo htmlspecialchars($student['department']); ?></span></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">CGPA</div>
        <div class="detail-value">$<?php echo number_format((float) $student['cgpa'], 2); ?></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Created At</div>
        <div class="detail-value"><?php echo htmlspecialchars($student['created_at']); ?></div>
    </div>

    <div style="margin-top: 20px;">
        <a href="edit.php?id=<?php echo (int) $student['id']; ?>" class="btn btn-warning">Edit Student</a>
        <a href="delete.php?id=<?php echo (int) $student['id']; ?>" class="btn btn-danger">Delete Student</a>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
