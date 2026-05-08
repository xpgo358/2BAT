<?php
include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'];

// Validación
if (empty($id_usuario)) {
    echo "<script>alert('ID USUARIO VACIO'); window.location='baja_alu.html';</script>";
    exit();
}

// Comprobar si existe
$check = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = ?");
$check->bind_param("s", $id_usuario);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('EL USUARIO NO EXISTE'); window.location='baja_alu.html';</script>";
    exit();
}

$checkRes = $conexion->prepare("SELECT * FROM reservas WHERE cod_usuario = ?");
$checkRes->bind_param("s", $id_usuario);
$checkRes->execute();
$res = $checkRes->get_result();

if ($res->num_rows > 0) {
    echo "<script>alert('NO SE PUEDE ELIMINAR: USUARIO CON RESERVAS'); window.location='baja_alu.html';</script>";
    exit();
}

// Eliminar (consulta segura)
$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("s", $id_usuario);

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