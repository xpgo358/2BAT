<html>
<head>
<meta charset="utf-8"/>
<title>Listado de Clientes</title>
<link rel="stylesheet" href="styles.css">

</head>

<body class="list-page">

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("SELECT * FROM clientes WHERE DNI != 'ANONIMO' ORDER BY Nombre ASC");
?>

<br><br>
<div class="container">

    <h1>🔍 LISTADO DE CLIENTES</h1>

    <table>
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nº Licencia</th>
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;

            while ($fila = $consulta->fetch_assoc()) {
                $contador++;
            ?>
                <tr>
                    <td><strong><?= htmlspecialchars($fila['DNI']) ?></strong></td>
                    <td><?= htmlspecialchars($fila['NumLicencia']) ?></td>
                    <td><?= htmlspecialchars($fila['Nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['Ape1']) ?></td>
                    <td><?= htmlspecialchars($fila['Ape2']) ?></td>
                    <td><?= htmlspecialchars($fila['Email']) ?></td>
                    <td><?= htmlspecialchars($fila['Telefono']) ?></td>
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
