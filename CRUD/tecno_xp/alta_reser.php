<?php

include('conexion.php');
$conexion = conectar();

$cod_usuario = $_POST['cod_usuario'] ?? '';
$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';
$estado = $_POST['estado'] ?? '';

if (empty($cod_usuario) || empty($cod_dispositivo) || empty($fecha_inicio) || empty($fecha_fin) || empty($estado)) {
    echo "
    <script>
    alert('FALTAN DATOS OBLIGATORIOS');
    window.location='alta_reser.html';
    </script>";
    exit();
}

$stmt = $conexion->prepare("INSERT INTO reservas (cod_usuario, cod_dispositivo, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $cod_usuario, $cod_dispositivo, $fecha_inicio, $fecha_fin, $estado);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_reser.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('RESERVA GUARDADA CORRECTAMENTE');
    window.location='alta_reser.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
