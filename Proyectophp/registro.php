<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        /* Estilos CSS para la página de registro */

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

select {
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

.error {
    color: #ff0000; /* Rojo */
    margin-bottom: 10px;
}

    </style>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="registro.php" method="POST">
        <label>Nombre: <input type="text" name="nombre"></label>
        <label>Contraseña: <input type="password" name="contrasenia"></label>
        <label>Rol: 
            <select name="rol">
                <option value="admin">Admin</option>
                <option value="invitado">Invitado</option>
            </select>
        </label>
        <input type="submit" value="Registrarse">
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contrasenia = $_POST['contrasenia'];
    $rol = $_POST['rol'];

    if (empty($nombre) || empty($contrasenia)) {
        echo '<p class="error">Nombre y contraseña son campos obligatorios.</p>';
    } else {
        if (strlen($nombre) < 3) {
            echo '<p class="error">El nombre debe tener al menos 3 caracteres.</p>';
        } elseif (strlen($contrasenia) < 6) {
            echo '<p class="error">La contraseña debe tener al menos 6 caracteres.</p>';
        } else {
            try {
                $usuario = 'root';
                $con = new PDO('mysql:dbname=moviles_db;host=localhost;charset=utf8', $usuario);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $con->prepare("INSERT INTO usuarios (usuario, contraseña, rol) VALUES (:usuario, :contrasenia, :rol)");
                $stmt->bindValue(':usuario', $nombre);
                $stmt->bindValue(':contrasenia', $contrasenia);
                $stmt->bindValue(':rol', $rol);
                $stmt->execute();

                echo '<p>Registro exitoso</p>';

                // Agregamos el botón para ir al login
                echo '<a href="login.php"><button>Iniciar Sesión</button></a>';
            } catch (PDOException $e) {
                echo '<p class="error">Error al insertar en la base de datos: ' . $e->getMessage() . '</p>';
            }
        }
    }
}
?>



  
</body>
</html>

