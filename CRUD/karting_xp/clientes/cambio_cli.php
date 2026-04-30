<?php

include('conexion.php');
$conexion = conectar();

$dni = $_POST['DNI'];

// Validación
if (empty($dni)) {
    echo "
    <script>
    alert('DNI VACÍO');
    window.location='cambio_cli.html';
    </script>";
    exit();
}

// Comprobar si existe
$consulta = $conexion->prepare("SELECT * FROM clientes WHERE DNI = ?");
$consulta->bind_param("s", $dni);
$consulta->execute();
$result = $consulta->get_result();

if ($result->num_rows == 0) {
    echo "
    <script>
    alert('CLIENTE NO ENCONTRADO');
    window.location='cambio_cli.html';
    </script>";
    exit();
}

$fila = $result->fetch_assoc();

    <link rel="stylesheet" href="styles.css">

    .button-secondary:hover {
        background: rgba(255, 140, 0, 0.3);
    <body class="form-page">

</style>

</head>

<body>

<div class="container">

    <h1>✏️ ACTUALIZAR DATOS CLIENTE</h1>

    <form action="cambio_cli2.php" method="post">

        <div class="form-group">
            <label for="DNI">DNI (No se puede cambiar)</label>
            <input type="text" name="DNI" id="DNI" value="<?php echo htmlspecialchars($fila['DNI']); ?>" disabled>
        </div>

        <input type="hidden" name="DNI" value="<?php echo htmlspecialchars($fila['DNI']); ?>">

        <div class="form-group">
            <label for="NumLicencia">Número de Licencia</label>
            <input type="text" name="NumLicencia" id="NumLicencia" value="<?php echo htmlspecialchars($fila['NumLicencia']); ?>">
        </div>

        <div class="form-group">
            <label for="Nombre">Nombre</label>
            <input type="text" name="Nombre" id="Nombre" value="<?php echo htmlspecialchars($fila['Nombre']); ?>">
        </div>

        <div class="form-group">
            <label for="Ape1">Primer Apellido</label>
            <input type="text" name="Ape1" id="Ape1" value="<?php echo htmlspecialchars($fila['Ape1']); ?>">
        </div>

        <div class="form-group">
            <label for="Ape2">Segundo Apellido</label>
            <input type="text" name="Ape2" id="Ape2" value="<?php echo htmlspecialchars($fila['Ape2']); ?>">
        </div>

        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" name="Email" id="Email" value="<?php echo htmlspecialchars($fila['Email']); ?>">
        </div>

        <div class="form-group">
            <label for="Telefono">Teléfono</label>
            <input type="tel" name="Telefono" id="Telefono" value="<?php echo htmlspecialchars($fila['Telefono']); ?>">
        </div>

        <div class="form-group">
            <label for="Direccion">Dirección</label>
            <input type="text" name="Direccion" id="Direccion" value="<?php echo htmlspecialchars($fila['Direccion']); ?>">
        </div>

        <div class="form-group">
            <label for="FechaRenovacion">Fecha de Renovación</label>
            <input type="date" name="FechaRenovacion" id="FechaRenovacion" value="<?php echo htmlspecialchars($fila['FechaRenovacion']); ?>">
        </div>

        <button type="submit">ACTUALIZAR</button>
        <button type="button" class="button-secondary" onclick="window.location='index.html'">VOLVER</button>

    </form>

</div>

</body>

</html>

<?php
$consulta->close();
$conexion->close();
?>
