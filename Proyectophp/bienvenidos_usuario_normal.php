<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bienvenido, <?php echo $_SESSION['usuario']; ?></title>
    <style>
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #666666;
        }

        th {
            background-color: #333333;
            color: #ffffff;
        }

        .ver-mas {
            background-color: #3498db;
            color: #ffffff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .ver-mas:hover {
            background-color: #2980b9;
        }

        #cerrar-sesion {
            margin: 20px;
            padding: 10px 15px;
            background-color: #ffffff;
            color: #333333;
            border: none;
            cursor: pointer;
        }

        #cerrar-sesion:hover {
            background-color: #cccccc;
        }
        img{
        width: 200px;}
    </style>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Sistema Operativo</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Imagen2</th>
            <th>Acciones</th>
        </tr>
        <?php
        include_once 'conexion.php';
        $BD = new ConectarBD();
        $conn = $BD->getConexion();

        $stmt = $conn->prepare('SELECT * FROM moviles');
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($movil = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $movil['id'] . "</td>";
            echo "<td>" . $movil['marca'] . "</td>";
            echo "<td>" . $movil['modelo'] . "</td>";
            echo "<td>" . $movil['sistema_operativo'] . "</td>";
            echo "<td>" . $movil['precio'] . "</td>";
            echo "<td><img src='" . $movil['imagen1'] . "' alt='Imagen 1'></td>";
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($movil['imagen2']) . "' width='500' height='500'></td>";
            echo "<td><a href='modelosmoviles/" . $movil['id'] . "' class='ver-mas'>Ver Más</a></td>";
            echo "</tr>";
        }

        $BD->cerrarConexion();
        ?>
    </table>

    <form action="cerrar_sesion.php" method="POST">
        <input type="submit" id="cerrar-sesion" value="Cerrar Sesión">
    </form>
   

</body>
</html>


