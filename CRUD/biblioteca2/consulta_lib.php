<html>
<head>
<meta charset="utf-8"/>
<title>Listado libros</title>
</head>
<body>

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("SELECT * FROM libros");
?>

<br><br>
<center><h2><b>LISTADO DE LIBROS</b></h2>

<table width="900" border="0" align="center">
<tr align="center">
    <td bgcolor="#CCCCCC"><b>ISBN</b></td>
    <td bgcolor="#CCCCCC"><b>TITULO</b></td>
    <td bgcolor="#CCCCCC"><b>AUTOR</b></td>
    <td bgcolor="#CCCCCC"><b>FOTO</b></td>
</tr>

<?php
$contador = 0;

while ($fila = $consulta->fetch_assoc()) {
    $contador++;

    $isbn = $fila['ISBN'];
    $titulo = $fila['Titulo'];
    $autor = $fila['Autor'];

    $foto = "imagen/" . $fila['Foto']; // asegúrate que exista este campo
?>

<tr align="center">
    <td><?= $isbn ?></td>
    <td><?= $titulo ?></td>
    <td><?= $autor ?></td>
    <td>
        <?php if (!empty($fila['Foto'])) { ?>
            <img src="<?= $foto ?>" width="80" height="auto">
        <?php } else { ?>
            Sin imagen
        <?php } ?>
    </td>
</tr>

<?php } ?>

</table>

<p align="center">
Registros encontrados: <?= $contador ?> <br><br><br><br>

<input type="button" onclick="window.location='index.html'" value="REGRESAR">
</p>

</body>
</html>