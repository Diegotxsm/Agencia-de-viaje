<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filtro($_POST['username']);
    $password = $_POST['password']; // En una aplicación real, usa password_hash() y password_verify()

    $sql = "SELECT * FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) { // En una aplicación real, usa password_verify()
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: admin_panel.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador - Agencia de Viajes</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: #f44336;
            text-align: center;
            margin-bottom: 1rem;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        .button-container input[type="submit"],
        .button-container .back-button {
            width: 48%;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }
        .button-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        .button-container .back-button {
            background-color: #f44336;
            color: white;
            border: none;
            display: inline-block;
        }
        .button-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .button-container .back-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login Administrador</h1>
        <?php
        if (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        }
        ?>
        <form class="login-form" action="login.php" method="post">
            <input type="text" id="username" name="username" placeholder="Usuario" required>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <div class="button-container">
                <input type="submit" value="Iniciar Sesión">
                <a href="../index.php" class="back-button">Volver</a>
            </div>
        </form>
    </div>
</body>
</html>