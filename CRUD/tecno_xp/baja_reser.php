<?php 
include('conexion.php');
$conexion = conectar();

$cod_alumno = $_POST['cod_alumno'];
$cod_libro  = $_POST['cod_libro'];

if (empty($cod_alumno) || empty($cod_libro)) {
    echo "<script>window.location='baja_reser.html'</script>";
    exit();
}

// Consulta segura
$stmt = $conexion->prepare("SELECT * FROM reserva WHERE cod_alumno = ? AND cod_libro = ?");
$stmt->bind_param("ss", $cod_alumno, $cod_libro);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('LA RESERVA NO EXISTE'); window.location='baja_reser.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<html>
<head>
<meta charset="utf-8">
<script>
function cancelar() {
    window.location="baja_reser.html";
}
</script>
</head>

<body>

<div align="center">
<p><strong style="font-size:20px; color:#ed09b4;">
¿DESEAS ELIMINAR LA SIGUIENTE RESERVA?
</strong></p>
</div>

<form action='baja_reser2.php' method='post'>	 

<div align="center"><strong><br>

NIA:
<input type='text' name='cod_alumno' value="<?php echo $datos->cod_alumno?>" readonly><br>

LIBRO:
<input type='text' name='cod_libro' value="<?php echo $datos->cod_libro?>" readonly><br>

FECHA:
<input type='text' name='fecha' value="<?php echo $datos->fecha?>" readonly><br>

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