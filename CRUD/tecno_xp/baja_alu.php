<?php 
include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'];

if (empty($id_usuario)) {
    echo "<script>window.location='baja_alu.html'</script>";
    exit();
}

// Consulta segura
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("s", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('EL USUARIO NO EXISTE'); window.location='baja_alu.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<html>
<head>
<meta charset="utf-8">
<script>
function cancelar() {
    window.location="baja_alu.html";
}
</script>
</head>

<body>

<div align="center">
    <p><strong style="font-size:20px; color:#ed09b4;">
    ¿DESEAS ELIMINAR EL SIGUIENTE USUARIO?
    </strong></p>
</div>

<form action='baja_alu2.php' method='post'>	 
<div align="center"><strong><br>

ID usuario:
<input type='text' name='id_usuario' value="<?php echo $datos->id_usuario?>" readonly><br>

Nombre:
<input type='text' name='nombre' value="<?php echo $datos->nombre?>" readonly><br>

Apellido 1:
<input type='text' name='ape1' value="<?php echo $datos->ape1?>" readonly><br>

Apellido 2:
<input type='text' name='ape2' value="<?php echo $datos->ape2?>" readonly><br>

Grupo:
<input type='text' name='grupo' value="<?php echo $datos->grupo?>" readonly><br>

</strong></div>

<p align="center">
<input type='submit' name='eliminar' value="SI">
<input type='button' value="NO" onclick='cancelar();'>
</p>

</form>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>