<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Reservas - TecnoXP</title>

<link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="container">
    <h1>📅 LISTADO DE RESERVAS</h1>

    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Dispositivo</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('conexion.php');
            $conexion = conectar();

            $consulta = $conexion->query("SELECT * FROM reservas");
            $contador = 0;

            while ($fila = $consulta->fetch_assoc()) {
                $contador++;
            ?>
            <tr>
                <td><?= $fila['cod_usuario']; ?></td>
                <td><?= $fila['cod_dispositivo']; ?></td>
                <td><?= date('d/m/Y', strtotime($fila['fecha_inicio'])); ?></td>
                <td><?= date('d/m/Y', strtotime($fila['fecha_fin'])); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="count">
        Reservas encontradas: <strong><?= $contador; ?></strong>
    </div>

    <div class="button-group">
        <button onclick="window.location='index.html'">🏠 Volver al Inicio</button>
    </div>
</div>

<?php
$conexion->close();
?>

</body>
</html>
