<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE" && isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $sql = "DELETE FROM task WHERE id='$task_id'";

    if (mysqli_query($conn, $sql)) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
?>