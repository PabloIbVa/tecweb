<?php
// Conectar a la base de datos
$link_page = isset($_POST['link']) ? $_POST['link'] : null;
$link = mysqli_connect("localhost", "root", "W0lverine", "marketzone");

// Verificar conexión
if (!$link) {
    die("Error: No se pudo conectar a la base de datos. " . mysqli_connect_error());
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Obtener datos del formulario
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $nombre = mysqli_real_escape_string($link, $_POST['name']);
    $marca = mysqli_real_escape_string($link, $_POST['marca']);
    $modelo = mysqli_real_escape_string($link, $_POST['model']);
    $precio = mysqli_real_escape_string($link, $_POST['price']);
    $detalle = mysqli_real_escape_string($link, $_POST['detail']);
    $cantidad = mysqli_real_escape_string($link, $_POST['cant']);
    $imagen = mysqli_real_escape_string($link, $_POST['img']);

    // Consulta para actualizar
    $sql = "UPDATE productos 
          SET nombre='$nombre', 
          marca='$marca', 
          modelo='$modelo', 
          precio=$precio, 
          detalles='$detalle', 
          unidades=$cantidad, 
          imagenes='$imagen' 
          WHERE id=$id;";

    if (mysqli_query($link, $sql)) {
        // Redirigir después de actualizar
        if ($link_page == 1) {
            header("Location: http://localhost/tecweb/practicas/p09/get_productos_vigentes_v2.php");
        } 
        else {
            header("Location: " . $link_page);
        }
        exit();
    } else {
        echo "<script>alert('Error al actualizar: " . mysqli_error($link) . "');</script>";
    }
}

// Cerrar conexión
mysqli_close($link);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        ol,
        ul {
            list-style-type: none;
        }
    </style>
    <title>Formulario</title>
</head>

<body>
    <h1>Modificacion de Producto</h1>
    <br>
    <form id="miFormulario" action="" method="post">

        <h2>Detalles de Producto a Insertar</h2>

        <fieldset>
            <legend>Actualizacion de datos:</legend>

            <ul>
                <input type="hidden" name="link" value="<?= !empty($_POST['link']) ? $_POST['link'] : $_GET['link'] ?>">
                <li><label for="form-id">ID:</label> <input type="text" name="id" id="form-id" value="<?= !empty($_POST['ids']) ? $_POST['ids'] : $_GET['ids'] ?>" readonly></li>
                <li><label for="form-name">Nombre:</label> <input type="text" name="name" id="form-name" value="<?= !empty($_POST['nombre']) ? $_POST['nombre'] : $_GET['nombre'] ?>"></li>
                <li><label for="form-marca">Marca:</label> <input type="text" name="marca" id="form-marca" value="<?= !empty($_POST['marca']) ? $_POST['marca'] : $_GET['marca'] ?>"></li>
                <li><label for="form-model">Modelo:</label> <input type="text" name="model" id="form-model" value="<?= !empty($_POST['modelo']) ? $_POST['modelo'] : $_GET['modelo'] ?>"></li>
                <li><label for="form-price">Precio:</label> <input type="text" name="price" id="form-price" value="<?= !empty($_POST['precio']) ? $_POST['precio'] : $_GET['precio'] ?>"></li>
                <li><label for="form-detail">Detalles</label><br><textarea name="detail" rows="4" cols="60" id="form-detail" placeholder="Escribe características del producto"><?= !empty($_POST['detalles']) ? $_POST['detalles'] : $_GET['detalles'] ?></textarea></li>
                <li><label for="form-cant">Unidades:</label> <input type="number" name="cant" min="0" id="form-cant" value="<?= !empty($_POST['cantidad']) ? $_POST['cantidad'] : $_GET['cantidad'] ?>"></li>
                <li><label for="form-img">Imagen:</label> <input type="text" name="img" id="form-img" value="<?= !empty($_POST['imagen']) ? $_POST['imagen'] : $_GET['imagen'] ?>"></li>
            </ul>
        </fieldset>

        <p>
            <input type="submit" name="submit" value="Subir producto">
            <input type="reset">
        </p>

    </form>
</body>

</html>