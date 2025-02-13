<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <?php
        $data = array();
        if(isset($_GET['tope']))
        {
            $tope = $_GET['tope'];
        }
        else
        {
            die('Parámetro "tope" no detectado...');
        }

        if (!empty($tope))
        {
            /** SE CREA EL OBJETO DE CONEXION */
            @$link = new mysqli('localhost', 'root', 'W0lverine', 'marketzone');
            /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */

            /** comprobar la conexión */
            if ($link->connect_errno) 
            {
                die('Falló la conexión: '.$link->connect_error.'<br/>');
                //exit();
            }

            /** Crear una tabla que no devuelve un conjunto de resultados */
            if ( $result = $link->query("SELECT * FROM productos WHERE unidades <= '{$tope}'") ) 
            {
                /** Se extraen las tuplas obtenidas de la consulta */
                $row = $result->fetch_all(MYSQLI_ASSOC);

                foreach($row as $num => $registro) {            // Se recorren tuplas
                    foreach($registro as $key => $value) {      // Se recorren campos
                        $data[$num][$key] = utf8_encode($value);
                    }
                }

                /** útil para liberar memoria asociada a un resultado con demasiada información */
                $result->free();
            }
        }

            $link->close();
    ?>

    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Producto</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
    <body>
    <h3>PRODUCTO</h3>
		
		<?php if (!empty($data)) : ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Detalles</th>
                    <th scope="col">Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $reg) : ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($reg['id']) ?></th>
                        <td><?= htmlspecialchars($reg['nombre']) ?></td>
                        <td><?= htmlspecialchars($reg['marca']) ?></td>
                        <td><?= htmlspecialchars($reg['modelo']) ?></td>
                        <td><?= htmlspecialchars($reg['precio']) ?></td>
                        <td><?= htmlspecialchars($reg['unidades']) ?></td>
                        <td><?= htmlspecialchars($reg['detalles']) ?></td>
                        <td><img src=<?= $reg['imagenes'] ?> ></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else : ?>
            <script>
                alert('No se encontraron productos con las unidades especificadas.');
            </script>
        <?php endif; ?>
	</body>
</html>