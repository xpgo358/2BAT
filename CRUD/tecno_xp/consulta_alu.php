<html>
<head>
<meta charset="utf-8"/>
<title>Listado usuarios</title>
</head>
<body>

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("SELECT * FROM usuarios");
?>

<br><br>
<center><h2><b>LISTADO DE USUARIOS</b></h2>

<table width="900" border="0" align="center">
<tr align="center">
    <td bgcolor="#CCCCCC">ID USUARIO</td>
    <td bgcolor="#CCCCCC">NOMBRE</td>
    <td bgcolor="#CCCCCC">APELLIDO 1</td>
    <td bgcolor="#CCCCCC">APELLIDO 2</td>
    <td bgcolor="#CCCCCC">GRUPO</td>
</tr>

<?php
$contador = 0;

while ($fila = $consulta->fetch_assoc()) {
    $contador++;
?>

<tr>
    <td><p style="color:#666;"><?= $fila['id_usuario'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['nombre'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['ape1'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['ape2'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['grupo'] ?></p></td>
</tr>

<?php } ?>

</table>

<p align="center">
Registros encontrados: <?= $contador ?> <br><br><br><br>

<input type="button" onclick="window.location='index.html'" value="REGRESAR">
</p>

</body>
</html>