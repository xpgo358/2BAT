<html>
<head>
<meta charset="utf-8"/>
<title>Listado de Pistas</title>
<link rel="stylesheet" href="styles.css">

</head>

<body class="list-page">

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("SELECT * FROM pistas ORDER BY Nombre ASC");
?>

<br><br>
<div class="container">

    <h1>🔍 LISTADO DE PISTAS</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;

            while ($fila = $consulta->fetch_assoc()) {
                $contador++;
            ?>
                <tr>
                    <td><strong><?= htmlspecialchars($fila['IDPista']) ?></strong></td>
                    <td><?= htmlspecialchars($fila['Nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['Direccion']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="info">
        Registros encontrados: <strong><?= $contador ?></strong> <br><br>
    </div>

    <button class="button" onclick="window.location='index.html'">← REGRESAR AL MENÚ</button>

</div>

</body>

</html>

<?php
$consulta->close();
$conexion->close();
?>
