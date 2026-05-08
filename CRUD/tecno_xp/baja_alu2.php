<?php

include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'] ?? '';

if (empty($id_usuario)) {
    echo "<script>window.location='baja_alu.html'</script>";
    exit();
}

$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("s", $id_usuario);
$resultado = $stmt->execute();

if ($resultado) {
    echo "
    <script>
    alert('USUARIO ELIMINADO CORRECTAMENTE');
    window.location='baja_alu.html';
    </script>";
} else {
    echo "
    <script>
    alert('ERROR AL ELIMINAR');
    window.location='baja_alu.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
