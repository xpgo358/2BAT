<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Dispositivos - TecnoXP</title>

<link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="container">
    <h1>💻 LISTADO DE DISPOSITIVOS</h1>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('conexion.php');
            $conexion = conectar();

            $consulta = $conexion->query("SELECT * FROM dispositivos");
            $contador = 0;

            while ($fila = $consulta->fetch_assoc()) {
                $contador++;
            ?>
            <tr>
                <td><?= $fila['cod_dispositivo']; ?></td>
                <td><?= $fila['nombre_dispositivo']; ?></td>
                <td><?= $fila['tipo']; ?></td>
                <td>
                    <span class="status <?= $fila['estado']; ?>">
                        <?= $fila['estado']; ?>
                    </span>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="count">
        Dispositivos encontrados: <strong><?= $contador; ?></strong>
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
