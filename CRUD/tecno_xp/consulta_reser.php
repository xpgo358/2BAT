<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Reservas - TecnoXP</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 40px 20px;
}

.container {
    max-width: 1100px;
    margin: 0 auto;
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

h1 {
    text-align: center;
    color: #667eea;
    margin-bottom: 30px;
    font-size: 28px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

td {
    padding: 12px 15px;
    border-bottom: 1px solid #e0e0e0;
}

tbody tr:hover {
    background-color: #f8f9ff;
}

.status {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status.activa {
    background: #d4edda;
    color: #155724;
}

.status.completada {
    background: #d1ecf1;
    color: #0c5460;
}

.status.cancelada {
    background: #f8d7da;
    color: #721c24;
}

.button-group {
    text-align: center;
}

button {
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.count {
    text-align: center;
    color: #667eea;
    font-weight: 600;
    margin-bottom: 20px;
}
</style>
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
                <th>Estado</th>
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
