<?php
include('conexion.php');
$conexion = conectar();

$cod_alumno = $_POST['cod_alumno'];
$cod_libro  = $_POST['cod_libro'];

// Validación
if (empty($cod_alumno) || empty($cod_libro)) {
    echo "<script>alert('DATOS INCOMPLETOS'); window.location='baja_reser.html';</script>";
    exit();
}

// Comprobar si existe
$check = $conexion->prepare("SELECT * FROM reserva WHERE cod_alumno = ? AND cod_libro = ?");
$check->bind_param("ss", $cod_alumno, $cod_libro);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('LA RESERVA NO EXISTE'); window.location='baja_reser.html';</script>";
    exit();
}

// Eliminar reserva concreta
$stmt = $conexion->prepare("DELETE FROM reserva WHERE cod_alumno = ? AND cod_libro = ?");
$stmt->bind_param("ss", $cod_alumno, $cod_libro);

if (!$stmt->execute()) {
    echo "ERROR AL ELIMINAR";
    exit();
}

echo "
<script>
alert('RESERVA ELIMINADA');
window.location='baja_reser.html';
</script>
";

$stmt->close();
$conexion->close();
?>