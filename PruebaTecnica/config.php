<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_pruebaTecnica";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>