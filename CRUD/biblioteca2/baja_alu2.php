<?php
include('conexion.php');
$conexion = conectar();

$nia = $_POST['NIA'];

// Validación
if (empty($nia)) {
    echo "<script>alert('NIA VACÍO'); window.location='baja_alu.html';</script>";
    exit();
}

// Comprobar si existe
$check = $conexion->prepare("SELECT NIA FROM alumnos WHERE NIA = ?");
$check->bind_param("s", $nia);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('EL ALUMNO NO EXISTE'); window.location='baja_alu.html';</script>";
    exit();
}

// Eliminar (consulta segura)
$stmt = $conexion->prepare("DELETE FROM alumnos WHERE NIA = ?");
$stmt->bind_param("s", $nia);

if (!$stmt->execute()) {
    echo "ERROR AL ELIMINAR";
    exit();
}

echo "
<script>
alert('REGISTRO ELIMINADO');
window.location='baja_alu.html';
</script>
";

$stmt->close();
$conexion->close();
?>