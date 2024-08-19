<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM userp WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        
        if ($user) {
     
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
             
              header("Location: tasks.html");
            } else {
                echo "Correo o contraseña incorrectos";
            }
        } else {
            echo "Correo o contraseña incorrectos";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }
}
?>