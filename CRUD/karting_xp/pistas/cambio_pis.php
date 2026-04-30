<?php

include('conexion.php');
$conexion = conectar();

$idpista = $_POST['IDPista'];

// Validación
if (empty($idpista)) {
    echo "
    <script>
    alert('ID DE PISTA VACÍO');
    window.location='cambio_pis.html';
    </script>";
    exit();
}

<link rel="stylesheet" href="styles.css">
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
<body class="form-page">
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(230, 57, 70, 0.4);
    }

    .button-secondary {
        background: rgba(230, 57, 70, 0.3);
        margin-top: 10px;
    }

    .button-secondary:hover {
        background: rgba(255, 140, 0, 0.3);
    }

</style>

</head>

<body>

<div class="container">

    <h1>✏️ ACTUALIZAR PISTA</h1>

    <form action="cambio_pis2.php" method="post">

        <div class="form-group">
            <label for="IDPista">ID Pista (No se puede cambiar)</label>
            <input type="text" name="IDPista" id="IDPista" value="<?php echo htmlspecialchars($fila['IDPista']); ?>" disabled>
        </div>

        <input type="hidden" name="IDPista" value="<?php echo htmlspecialchars($fila['IDPista']); ?>">

        <div class="form-group">
            <label for="Nombre">Nombre</label>
            <input type="text" name="Nombre" id="Nombre" value="<?php echo htmlspecialchars($fila['Nombre']); ?>">
        </div>

        <div class="form-group">
            <label for="Direccion">Dirección</label>
            <input type="text" name="Direccion" id="Direccion" value="<?php echo htmlspecialchars($fila['Direccion']); ?>">
        </div>

        <div class="form-group">
            <label for="Descripcion">Descripción</label>
            <textarea name="Descripcion" id="Descripcion"><?php echo htmlspecialchars($fila['Descripcion']); ?></textarea>
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
