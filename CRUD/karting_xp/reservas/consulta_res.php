<html>
<head>
<meta charset="utf-8"/>
<title>Listado de Reservas</title>
<link rel="stylesheet" href="styles.css">

</head>

<body class="list-page">

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("
    SELECT 
        r.IDReserva,
        c.Nombre as NombreCliente,
        c.Ape1 as ApellidoCliente,
        p.Nombre as NombrePista,
        t.Nombre as NombreTarifa,
        r.FechaReserva,
        r.HoraInicio,
        r.HoraFin,
        r.Personas,
        t.PrecioPorPersona,
        r.Descuento,
        r.Estado
    FROM reservas r
    JOIN clientes c ON r.NumLicencia = c.NumLicencia
    JOIN pistas p ON r.IDPista = p.IDPista
    JOIN tarifas t ON r.IDTarifa = t.IDTarifa
    ORDER BY r.FechaReserva DESC, r.HoraInicio ASC
");
?>

<br><br>
<div class="container">

    <h1>🔍 LISTADO DE RESERVAS</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Pista</th>
                <th>Tarifa</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Personas</th>
                <th>Precio Total (€)</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;

            while ($fila = $consulta->fetch_assoc()) {
                $contador++;
                
                // Calcular precio total
                $preciototal = $fila['PrecioPorPersona'] * $fila['Personas'] * (1 - $fila['Descuento'] / 100);
                
                // Badge de estado
                $estadobadge = '';
                switch ($fila['Estado']) {
                    case 'Reservada':
                        $estadobadge = '<span class="badge badge-reservada">Reservada</span>';
                        break;
                    case 'Confirmada':
                        $estadobadge = '<span class="badge badge-confirmada">Confirmada</span>';
                        break;
                    case 'En curso':
                        $estadobadge = '<span class="badge badge-encurso">En curso</span>';
                        break;
                    case 'Completada':
                        $estadobadge = '<span class="badge badge-completada">Completada</span>';
                        break;
                    case 'Cancelada':
                        $estadobadge = '<span class="badge badge-cancelada">Cancelada</span>';
                        break;
                }
            ?>
                <tr>
                    <td><strong><?= htmlspecialchars($fila['IDReserva']) ?></strong></td>
                    <td><?= htmlspecialchars($fila['NombreCliente'] . ' ' . $fila['ApellidoCliente']) ?></td>
                    <td><?= htmlspecialchars($fila['NombrePista']) ?></td>
                    <td><?= htmlspecialchars($fila['NombreTarifa']) ?></td>
                    <td><?= htmlspecialchars($fila['FechaReserva']) ?></td>
                    <td><?= htmlspecialchars($fila['HoraInicio'] . ' - ' . $fila['HoraFin']) ?></td>
                    <td><?= htmlspecialchars($fila['Personas']) ?></td>
                    <td><?= number_format($preciototal, 2, ',', '.') ?></td>
                    <td><?= $estadobadge ?></td>
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
