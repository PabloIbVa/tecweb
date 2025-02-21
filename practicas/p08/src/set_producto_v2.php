<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Validación de Producto</title>
    <style type="text/css">
        body {
            margin: 20px;
            font-family: Verdana, Helvetica, sans-serif;
            font-size: 90%;
        }
        .success {
            background-color: #C4DF9B;
            color: #005825;
        }
        .error {
            background-color: #FFCCCC;
            color: #B00000;
        }
        h1 {
            border-bottom: 1px solid #005825;
        }
    </style>
</head>
<body class="<?php echo isset($error) ? 'error' : 'success'; ?>">
    <?php 
    $error_messages = [];
    
    if (empty($_POST['name'])) $error_messages[] = "El nombre es obligatorio.";
    if (empty($_POST['marca'])) $error_messages[] = "La marca es obligatoria.";
    if (empty($_POST['model'])) $error_messages[] = "El modelo es obligatorio.";
    if (!isset($_POST['price']) || !is_numeric($_POST['price'])) $error_messages[] = "El precio debe ser un número válido.";
    if (!isset($_POST['cant']) || !is_numeric($_POST['cant'])) $error_messages[] = "Las unidades deben ser un número válido.";
    if (empty($_POST['detail'])) $error_messages[] = "Los detalles son obligatorios.";
    if (empty($_POST['img'])) $error_messages[] = "La imagen es obligatoria.";

    if (empty($error_messages)) {
        // Datos correctos, procedemos con la inserción
        $nombre   = htmlspecialchars($_POST['name']);
        $marca    = htmlspecialchars($_POST['marca']);
        $modelo   = htmlspecialchars($_POST['model']);
        $detalles = htmlspecialchars($_POST['detail']);
        $imagenes = htmlspecialchars($_POST['img']);
        $precio   = floatval($_POST['price']);
        $unidades = intval($_POST['cant']);

        @$link = new mysqli('localhost', 'root', 'W0lverine', 'marketzone');
        if ($link->connect_errno) {
            die('<h1>Error de conexión: </h1>' . $link->connect_error);
        }

        $sql = "INSERT INTO productos VALUES (null, '$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagenes', 0)";
        if ($link->query($sql)) {
            echo "<h1>Producto añadido correctamente.</h1>";
            echo "<h2>Insertación realizada:</h2>
                <ul>
                    <li><strong>Nombre:</strong> <em>$nombre</em></li>
                    <li><strong>Marca:</strong> <em>$marca</em></li>
                    <li><strong>Modelo:</strong> <em>$modelo</em></li>
                    <li><strong>Precio:</strong> <em>$precio</em></li>
                    <li><strong>Unidades:</strong> <em>$unidades</em></li>
                </ul>
                <p><strong>Detalles:</strong> <em>$detalles</em></p>
                <h2><strong>Imagen producto</strong></h2>
                <img src=".$imagenes.">";
        } else {
            echo "<h1>Error al insertar el producto: " . $link->error . "</h1>";
        }
        $link->close();
    } else {
        // Mostrar errores
        echo "<h1>Error en el envío del formulario:</h1><ul>";
        foreach ($error_messages as $message) {
            echo "<li>$message</li>";
        }
        echo "</ul>";
    }
    ?>
    <p>
        <a href="http://validator.w3.org/check?uri=referer"><img
            src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
    </p>
</body>
</html>
