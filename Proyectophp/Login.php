<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        /* Estilos CSS para la página de inicio de sesión */

body {
    background-color: #f0f0f0; /* Gris claro */
    color: #333; /* Texto negro */
    font-family: Arial, sans-serif;
    text-align: center;
    padding: 20px;
}

h1 {
    color: #333; /* Texto negro */
}

form {
    width: 300px;
    margin: 20px auto;
    background-color: #fff; /* Blanco */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

label {
    display: block;
    margin: 10px 0;
    color: #333; /* Texto negro */
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc; /* Gris claro */
    background-color: #f9f9f9; /* Gris muy claro */
    margin-bottom: 15px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #333; /* Negro */
    color: #fff; /* Texto blanco */
    padding: 12px 20px;
    font-size: 18px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

input[type="submit"]:hover {
    background-color: #555; /* Gris oscuro */
}

a {
    color: #333; /* Texto negro */
}

a:hover {
    text-decoration: underline;
}

    
    </style>
</head>

<body>
    <h1>Iniciar Sesión</h1>
    <form action="" method="POST">
        <label>Usuario: <input type="text" name="usuario"></label><br>
        <label>Contraseña: <input type="password" name="contrasena"></label><br>
        <input type="hidden" name="entrar" value="1">
        <input type="submit" value="Iniciar Sesión">

        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>

    </form>
</body>

</html>
<?php
    if (isset($_POST['entrar'])) {
        $user = $_POST['usuario'];
        $paswd = $_POST['contrasena'];

        try {
            $usuario = 'root';
            $con = new PDO('mysql:dbname=moviles_db;host=localhost;charset=utf8', $usuario);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $con->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :user AND contraseña = :clave");
            $stmt->bindValue(':user', $user);
            $stmt->bindValue(':clave', $paswd);
            $stmt->execute();
            $resultado = $stmt->fetchColumn();

            if ($resultado == 0) {
                echo '<p class="error">Contraseña o usuario incorrecto</p>';
            } else {
                session_start();
                $_SESSION["usuario"] = $user;

                $stmt2 = $con->prepare("SELECT rol FROM usuarios WHERE usuario = :user AND contraseña = :clave");
                $stmt2->bindValue(':user', $user);
                $stmt2->bindValue(':clave', $paswd);
                $stmt2->execute();
                $rol = $stmt2->fetchColumn();

                $_SESSION["rol"] = $rol;

                header('Location: bienvenidos.php');
                exit;
            }
        } catch (PDOException $e) {
            echo '<p class="error">' . $e->getMessage() . '</p>';
        }
    }
    ?>



