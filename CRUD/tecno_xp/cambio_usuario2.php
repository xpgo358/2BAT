<?php

include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$ape1 = $_POST['ape1'] ?? '';
$ape2 = $_POST['ape2'] ?? '';
$grupo = $_POST['grupo'] ?? '';

if (empty($id_usuario)) {
    echo "<script>window.location='cambio_usuario.html'</script>";
    exit();
}

$stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, ape1 = ?, ape2 = ?, grupo = ? WHERE id_usuario = ?");
$stmt->bind_param("sssss", $nombre, $ape1, $ape2, $grupo, $id_usuario);
$resultado = $stmt->execute();

if ($resultado) {
    echo "
    <script>
    alert('USUARIO ACTUALIZADO CORRECTAMENTE');
    window.location='cambio_usuario.html';
    </script>";
} else {
    echo "
    <script>
    alert('ERROR AL ACTUALIZAR');
    window.location='cambio_usuario.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
