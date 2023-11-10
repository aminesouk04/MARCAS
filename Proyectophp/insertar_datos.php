<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Datos</title>
    <style>
        /* Estilos CSS para la página de insertar_datos.php */
        body {
            background-color: #f0f0f0;
            color: #333;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            width: 300px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        a {
            color: #333;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Insertar Datos de Móvil</h1>

    <form action="insertar_datos.php" method="post" enctype="multipart/form-data">
        <label for="marca">Marca:</label>
        <input type="text" name="marca" required>

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" required>


        <label for="sistema_operativo">Sistema Operativo:</label>
        <input type="text" name="sistema_operativo" required>

        <label for="precio">Precio:</label>
        <input type="text" name="precio" required>

        <label for="imagen1">Imagen 1:</label>
        <input type="file" name="imagen1" accept="image/*" required>

        <label for="imagen2">Imagen 2:</label>
        <input type="file" name="imagen2" accept="image/*" required>

        <input type="submit" name="enviar" value="Insertar Móvil">
    </form>
</body>

</html>

<?php
// Conexión a la base de datos
try {
    $usuario = 'root';
    $con = new PDO('mysql:dbname=moviles_db;host=localhost;charset=utf8', $usuario);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $sistema_operativo = $_POST['sistema_operativo'];
    $precio = $_POST['precio'];

    if (empty($marca) || empty($modelo) || empty($sistema_operativo) || empty($precio)) {
        echo "Todos los campos son obligatorios.";
    } else {
        if (is_uploaded_file($_FILES['imagen1']['tmp_name']) && is_uploaded_file($_FILES['imagen2']['tmp_name'])) {
            $nombreDirectorio = "Imagenes/";
            $nombreFichero1 = $_FILES['imagen1']['name'];
            $nombreFichero2 = $_FILES['imagen2']['name'];

            $completo1 = $nombreDirectorio . $nombreFichero1;
            $completo2 = $nombreDirectorio . $nombreFichero2;

            $tipo1 = $_FILES['imagen1']['type'];
            $tipo2 = $_FILES['imagen2']['type'];

            if (in_array($tipo1, ['image/png', 'image/jpeg']) && in_array($tipo2, ['image/png', 'image/jpeg'])) {
                if (is_dir($nombreDirectorio)) {
                    if (move_uploaded_file($_FILES['imagen1']['tmp_name'], $completo1) && move_uploaded_file($_FILES['imagen2']['tmp_name'], $completo2)) {
                        try {
                            $stmt = $con->prepare("INSERT INTO moviles (marca, modelo, sistema_operativo, precio, imagen1, imagen2) VALUES (:marca, :modelo, :sistema_operativo, :precio, :imagen1, :imagen2)");
                            $stmt->bindValue(':marca', $marca);
                            $stmt->bindValue(':modelo', $modelo);
                            $stmt->bindValue(':sistema_operativo', $sistema_operativo);
                            $stmt->bindValue(':precio', $precio);
                            $stmt->bindValue(':imagen1', $completo1);
                            $stmt->bindValue(':imagen2', $completo2);
                            $stmt->execute();

                            echo "Datos insertados correctamente.";

                        } catch (PDOException $e) {
                            echo "Error al insertar datos: " . $e->getMessage();
                        }
                    } else {
                        echo "Error al subir las imágenes.";
                    }
                } else {
                    echo "El directorio de imágenes no existe.";
                }
            } else {
                echo "Tipo de archivo no permitido. Solo se permiten imágenes PNG y JPEG.";
            }
        } else {
            echo "Debes subir ambas imágenes.";
        }
    }
}

?>

