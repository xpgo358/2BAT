<?php

include('conexion.php');
$conexion = conectar();

$cod_usuario = $_POST['cod_usuario'] ?? '';
$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';

if (empty($cod_usuario) || empty($cod_dispositivo) || empty($fecha_inicio) || empty($fecha_fin)) {
    echo "
    <script>
    alert('FALTAN DATOS OBLIGATORIOS');
    window.location='alta_reserva.html';
    </script>";
    exit();
}

$stmt = $conexion->prepare("SELECT estado FROM dispositivos WHERE cod_dispositivo = ?");
$stmt->bind_param("s", $cod_dispositivo);
$stmt->execute();
$resultadoDispositivo = $stmt->get_result();
$dispositivo = $resultadoDispositivo->fetch_object();
$stmt->close();

if (!$dispositivo) {
    echo "
    <script>
    alert('DISPOSITIVO NO ENCONTRADO');
    window.location='alta_reserva.html';
    </script>";
    $conexion->close();
    exit();
}

if ($dispositivo->estado !== 'disponible') {
    echo "
    <script>
    alert('EL DISPOSITIVO NO ESTÁ DISPONIBLE PARA RESERVAR');
    window.location='alta_reserva.html';
    </script>";
    $conexion->close();
    exit();
}

$stmt = $conexion->prepare(
    "SELECT 1
     FROM reservas
     WHERE cod_dispositivo = ?
       AND NOT (fecha_fin < ? OR fecha_inicio > ?)
     LIMIT 1"
);
$stmt->bind_param("sss", $cod_dispositivo, $fecha_inicio, $fecha_fin);
$stmt->execute();
$resultadoReserva = $stmt->get_result();

if ($resultadoReserva->num_rows > 0) {
    echo "
    <script>
    alert('YA EXISTE UNA RESERVA PARA ESE DISPOSITIVO EN ESAS FECHAS');
    window.location='alta_reserva.html';
    </script>";
    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();

$stmt = $conexion->prepare("INSERT INTO reservas (cod_usuario, cod_dispositivo, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $cod_usuario, $cod_dispositivo, $fecha_inicio, $fecha_fin);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_reserva.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('RESERVA GUARDADA CORRECTAMENTE');
    window.location='alta_reserva.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
