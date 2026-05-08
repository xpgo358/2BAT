<?php 
include('conexion.php');
$conexion = conectar();

$nia = $_POST['NIA'];

if (empty($nia)) {
    echo "<script>window.location='cambio_alu.html'</script>";
    exit();
}

// Consulta segura
$stmt = $conexion->prepare("SELECT * FROM alumnos WHERE NIA = ?");
$stmt->bind_param("s", $nia);
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
<title>Modificar Alumno</title>

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

<b>NIA:</b>
<input type='text' name='NIA' value="<?php echo $datos->NIA?>" readonly><br><br>

<b>NOMBRE:</b>
<input type='text' name='Nombre' value="<?php echo $datos->Nombre?>"><br><br>

<b>Ape1:</b>
<input type='text' name='Ape1' value="<?php echo $datos->Ape1?>"><br><br>

<b>Ape2:</b>
<input type='text' name='Ape2' value="<?php echo $datos->Ape2?>"><br><br>

<b>Curso:</b>
<input type='text' name='Curso' value="<?php echo $datos->Curso?>"><br><br>

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