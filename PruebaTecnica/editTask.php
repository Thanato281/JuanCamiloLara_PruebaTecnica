<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $sql = "SELECT * FROM task WHERE id='$task_id'";
    $result = mysqli_query($conn, $sql);
    $task = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $task_id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);

    $sql = "UPDATE task SET title='$title', description='$description', due_date='$due_date', priority='$priority' WHERE id='$task_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: tasks.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Tarea</title>
    <link rel="stylesheet" href="/css/stylesTasks.css">
</head>
<body>
    <h1>Modificar Tarea</h1>
    <form action="editTask.php" method="post">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" value="<?php echo $task['title']; ?>" required>
        <label for="description">Descripción:</label>
        <textarea id="description" name="description" required><?php echo $task['description']; ?></textarea>
        <label for="due_date">Fecha de vencimiento:</label>
        <input type="date" id="due_date" name="due_date" value="<?php echo $task['due_date']; ?>" required>
        <label for="priority">Prioridad:</label>
        <select id="priority" name="priority">
            <option value="alta" <?php if ($task['priority'] == 'alta') echo 'selected'; ?>>Alta</option>
            <option value="media" <?php if ($task['priority'] == 'media') echo 'selected'; ?>>Media</option>
            <option value="baja" <?php if ($task['priority'] == 'baja') echo 'selected'; ?>>Baja</option>
        </select>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>