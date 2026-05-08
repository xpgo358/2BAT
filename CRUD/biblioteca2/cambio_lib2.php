<?php
include('conexion.php');
$conexion = conectar();

$isbn = $_POST['ISBN'];
$titulo = $_POST['Titulo'];
$autor = $_POST['Autor'];

// Validación básica
if (empty($isbn) || empty($titulo)) {
    echo "<script>alert('DATOS INCOMPLETOS'); window.location='cambio_lib.html';</script>";
    exit();
}

// UPDATE seguro
$stmt = $conexion->prepare("
    UPDATE libros 
    SET Titulo = ?, Autor = ? 
    WHERE ISBN = ?
");

$stmt->bind_param("sss", $titulo, $autor, $isbn);

if (!$stmt->execute()) {
    echo "ERROR AL CAMBIAR LOS DATOS";
    exit();
}

echo "
<script>
alert('LOS DATOS HAN SIDO MODIFICADOS');
window.location='cambio_lib.html';
</script>
";

$stmt->close();
$conexion->close();
?>