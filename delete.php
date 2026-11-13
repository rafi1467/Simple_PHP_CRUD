<?php
/**
 * DELETE: Remove a student record by ID
 */
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $sql = "DELETE FROM students WHERE id = $id";
    mysqli_query($conn, $sql);
}

header('Location: index.php?msg=deleted');
exit;
