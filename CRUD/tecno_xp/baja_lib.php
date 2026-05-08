<?php 
include('conexion.php');
$conexion = conectar();

$isbn = $_POST['ISBN'];

if (empty($isbn)) {
    echo "<script>window.location='baja_lib.html'</script>";
    exit();
}

// Consulta segura
$stmt = $conexion->prepare("SELECT * FROM libros WHERE ISBN = ?");
$stmt->bind_param("s", $isbn);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('EL LIBRO NO EXISTE'); window.location='baja_lib.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<html>
<head>
<meta charset="utf-8">
<script>
function cancelar() {
    window.location="baja_lib.html";
}
</script>
</head>

<body>

<div align="center">
<p><strong style="font-size:20px; color:#ed09b4;">
¿DESEAS ELIMINAR EL SIGUIENTE LIBRO?
</strong></p>
</div>

<form action='baja_lib2.php' method='post'>	 

<div align="center"><strong><br>

ISBN:
<input type='text' name='ISBN' value="<?php echo $datos->ISBN?>" readonly><br>

TÍTULO:
<input type='text' name='Titulo' value="<?php echo $datos->Titulo?>" readonly><br>

AUTOR:
<input type='text' name='Autor' value="<?php echo $datos->Autor?>" readonly><br>

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