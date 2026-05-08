<?php
include('conexion.php');
$conexion = conectar();

$nia = $_POST['NIA'];
$nombre = $_POST['Nombre'];
$ape1 = $_POST['Ape1'];
$ape2 = $_POST['Ape2'];
$curso = $_POST['Curso'];

// Validación básica
if (empty($nia) || empty($nombre)) {
    echo "<script>alert('DATOS INCOMPLETOS'); window.location='cambio_alu.html';</script>";
    exit();
}

// UPDATE seguro
$stmt = $conexion->prepare("
    UPDATE alumnos 
    SET Nombre=?, Ape1=?, Ape2=?, Curso=? 
    WHERE NIA=?
");

$stmt->bind_param("sssss", $nombre, $ape1, $ape2, $curso, $nia);

if (!$stmt->execute()) {
    echo "ERROR AL CAMBIAR LOS DATOS";
    exit();
}

echo "
<script>
alert('LOS DATOS HAN SIDO MODIFICADOS');
window.location='cambio_alu.html';
</script>
";

$stmt->close();
$conexion->close();
?>