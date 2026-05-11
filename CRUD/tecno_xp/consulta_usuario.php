<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Usuarios - TecnoXP</title>

<link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="container">
    <h1>👨‍💻 LISTADO DE USUARIOS</h1>

    <table>
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Apellido 1</th>
                <th>Apellido 2</th>
                <th>Grupo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('conexion.php');
            $conexion = conectar();

            $consulta = $conexion->query("SELECT * FROM usuarios");
            $contador = 0;

            while ($fila = $consulta->fetch_assoc()) {
                $contador++;
            ?>
            <tr>
                <td><?= $fila['id_usuario']; ?></td>
                <td><?= $fila['nombre']; ?></td>
                <td><?= $fila['ape1']; ?></td>
                <td><?= $fila['ape2'] ?? 'N/A'; ?></td>
                <td><?= $fila['grupo']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="count">
        Usuarios encontrados: <strong><?= $contador; ?></strong>
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
