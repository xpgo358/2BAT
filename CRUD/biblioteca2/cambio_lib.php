<?php 
include('conexion.php');
$conexion = conectar();

$isbn = $_POST['ISBN'];

if (empty($isbn)) {
    echo "<script>window.location='cambio_lib.html'</script>";
    exit();
}

// Consulta segura
$stmt = $conexion->prepare("SELECT * FROM libros WHERE ISBN = ?");
$stmt->bind_param("s", $isbn);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('LA CLAVE NO EXISTE'); window.location='cambio_lib.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<html>
<head>
<meta charset="utf-8">
<title>Modificar Libro</title>

<script>
function cancelar() {
    window.location="cambio_lib.html";
}
</script>
</head>

<body>

<div style="text-align:center; margin-top:40px;">
<h2 style="color:blue;">DATOS A MODIFICAR</h2>
</div>

<form action='cambio_lib2.php' method='post'>

<div style="text-align:center; margin-top:20px;">

<b>ISBN:</b>
<input type='text' name='ISBN' value="<?php echo $datos->ISBN?>" readonly><br><br>

<b>TITULO:</b>
<input type='text' name='Titulo' value="<?php echo $datos->Titulo?>"><br><br>

<b>AUTOR:</b>
<input type='text' name='Autor' value="<?php echo $datos->Autor?>"><br><br>

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