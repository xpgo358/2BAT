<?php 
include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'];

if (empty($id_usuario)) {
    echo "<script>window.location='cambio_alu.html'</script>";
    exit();
}

// Consulta segura
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("s", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('LA CLAVE NO EXISTE'); window.location='cambio_alu.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<html>
<head>
<meta charset="utf-8">
<title>Modificar Usuario</title>

<script>
function cancelar() {
    window.location="cambio_alu.html";
}
</script>
</head>

<body>

<div style="text-align:center; margin-top:40px;">
<h2 style="color:blue;">DATOS A MODIFICAR</h2>
</div>

<form action='cambio_alu2.php' method='post'>

<div style="text-align:center; margin-top:20px;">

<b>ID usuario:</b>
<input type='text' name='id_usuario' value="<?php echo $datos->id_usuario?>" readonly><br><br>

<b>NOMBRE:</b>
<input type='text' name='nombre' value="<?php echo $datos->nombre?>"><br><br>

<b>Apellido 1:</b>
<input type='text' name='ape1' value="<?php echo $datos->ape1?>"><br><br>

<b>Apellido 2:</b>
<input type='text' name='ape2' value="<?php echo $datos->ape2?>"><br><br>

<b>Grupo:</b>
<input type='text' name='grupo' value="<?php echo $datos->grupo?>"><br><br>

</div>

<p align="center">
<input type='submit' name='cambiar' value="CAMBIAR">
<input type='button' value="CANCELAR" onclick='cancelar();'>
</p>

</form>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>