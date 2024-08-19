<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $user_id = $_SESSION['user_id'];
    $attachment = '';

  
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['attachment']['tmp_name'];
        $fileName = $_FILES['attachment']['name'];
        $fileSize = $_FILES['attachment']['size'];
        $fileType = $_FILES['attachment']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $attachment = $dest_path;
        }
    }

    
    $sql = "INSERT INTO task (user_id, title, description, due_date, priority, completed, attachment) VALUES ('$user_id', '$title', '$description', '$due_date', '$priority', 0, '$attachment')";

    if (mysqli_query($conn, $sql)) {
        header("Location: tasks.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM task WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $tareas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($conn);

    echo json_encode($tareas);
}
?>