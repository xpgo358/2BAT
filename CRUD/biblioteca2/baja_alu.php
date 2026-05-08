<?php 
include('conexion.php');
$conexion = conectar();

$nia = $_POST['NIA'];

if (empty($nia)) {
    echo "<script>window.location='baja_alu.html'</script>";
    exit();
}

// Consulta segura
$stmt = $conexion->prepare("SELECT * FROM alumnos WHERE NIA = ?");
$stmt->bind_param("s", $nia);
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
    ¿DESEAS ELIMINAR EL SIGUIENTE ALUMNO?
    </strong></p>
</div>

<form action='baja_alu2.php' method='post'>	 
<div align="center"><strong><br>

NIA:
<input type='text' name='NIA' value="<?php echo $datos->NIA?>" readonly><br>

Nombre:
<input type='text' name='Nombre' value="<?php echo $datos->Nombre?>" readonly><br>

Apellido 1:
<input type='text' name='Ape1' value="<?php echo $datos->Ape1?>" readonly><br>

Apellido 2:
<input type='text' name='Ape2' value="<?php echo $datos->Ape2?>" readonly><br>

Curso:
<input type='text' name='Curso' value="<?php echo $datos->Curso?>" readonly><br>

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