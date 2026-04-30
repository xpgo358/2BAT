<html>
<head>
<meta charset="utf-8"/>
<title>Listado de Tarifas</title>
<link rel="stylesheet" href="styles.css">

</head>

<body class="list-page">

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("SELECT * FROM tarifas ORDER BY Nombre ASC");
?>

<br><br>
<div class="container">

    <h1>🔍 LISTADO DE TARIFAS</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio/Persona (€)</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;

            while ($fila = $consulta->fetch_assoc()) {
                $contador++;
                $estado = $fila['Activa'] ? '<span class="badge-active">ACTIVA</span>' : '<span class="badge-inactive">INACTIVA</span>';
            ?>
                <tr>
                    <td><strong><?= htmlspecialchars($fila['IDTarifa']) ?></strong></td>
                    <td><?= htmlspecialchars($fila['Nombre']) ?></td>
                    <td><?= number_format($fila['PrecioPorPersona'], 2, ',', '.') ?></td>
                    <td><?= $estado ?></td>
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
