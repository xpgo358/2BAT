<?php
include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'];
$nombre = $_POST['nombre'];
$ape1 = $_POST['ape1'];
$ape2 = $_POST['ape2'];
$grupo = $_POST['grupo'];

// Validación básica
if (empty($id_usuario) || empty($nombre)) {
    echo "<script>alert('DATOS INCOMPLETOS'); window.location='cambio_alu.html';</script>";
    exit();
}

// UPDATE seguro
$stmt = $conexion->prepare("
    UPDATE usuarios 
    SET nombre=?, ape1=?, ape2=?, grupo=? 
    WHERE id_usuario=?
");

$stmt->bind_param("sssss", $nombre, $ape1, $ape2, $grupo, $id_usuario);

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