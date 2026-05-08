<?php

include('conexion.php');
$conexion = conectar();

$isbn = $_POST['ISBN'];
$titulo = $_POST['Titulo'];
$autor = $_POST['Autor'];

// Validación básica
if (empty($isbn) || empty($titulo) || empty($autor)) {
    echo "
    <script>
    alert('FALTAN DATOS');
    window.location='alta_lib.html';
    </script>";
    exit();
}

// Consulta preparada (segura)
$stmt = $conexion->prepare("INSERT INTO libros (ISBN, Titulo, Autor) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $isbn, $titulo, $autor);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_lib.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('DATOS GUARDADOS CORRECTAMENTE');
    window.location='alta_lib.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>