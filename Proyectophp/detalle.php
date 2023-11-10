<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Móvil</title>
    <style>
        body {
            background-image: url('http://localhost/Proyectophp/Imagenes/FondoVideojuegos3.jpg'); 
            background-color: #08101b;
            background-attachment: fixed;
            background-position: center center; 
            background-repeat: no-repeat;
            color: white; 
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; 
            height: 100vh;
            margin: 0;
        }

        #detalle {
            width: 500px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-top: 100px;
        }

        #detalle h2 {
            font-size: 24px;
            margin: 0;
            padding: 10px;
            color: #FF5733;
            font-weight: bold;
        }

        #detalle p {
            font-size: 18px;
            margin: 0;
            padding: 10px;
            color: #347CFF;
            font-style: italic;
        }

        #detalle img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $usuario = 'root';
            $con = new PDO('mysql:dbname=moviles_db;host=localhost;charset=utf8', $usuario);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $con->prepare('SELECT * FROM moviles WHERE id=:id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            echo "<div id=\"detalle\">";

            while ($movil = $stmt->fetch()) {
                $marca = $movil['marca'];
                $modelo = $movil['modelo'];
                $sistema_operativo = $movil['sistema_operativo'];
                $precio = $movil['precio'];
                $imagen1 = $movil['imagen1'];
                $imagen2 = $movil['imagen2'];

                echo "<h2>$marca $modelo</h2>";
                echo "<img src='../$imagen1' alt='Imagen 1'>";
                echo "<p>Sistema Operativo: $sistema_operativo</p>";
                echo "<p>Precio: $precio</p>";
                echo "<img src='../$imagen2' alt='Imagen 2'>";
            }

            echo "</div>";

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage() . "<br>";
        }
    } else {
        echo "No se proporcionó un ID válido.";
    }
    ?>
</body>
</html>
