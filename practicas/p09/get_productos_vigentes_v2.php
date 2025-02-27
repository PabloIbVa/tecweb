<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <?php
        $data = array();
        
        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', 'W0lverine', 'marketzone'); 
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */

        /** comprobar la conexión */
        if ($link->connect_errno) 
        {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
        }

        /** Crear una tabla que no devuelve un conjunto de resultados */
        if ( $result = $link->query("SELECT * FROM productos WHERE eliminado = 0") ) 
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

        $link->close();
    ?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Producto</title>
        <link 
            rel="stylesheet" 
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
            crossorigin="anonymous">
        <script>
            function showDetails(event) {
                var row = event.target.closest("tr"); // Encuentra la fila más cercana dado a que no te e
                var data = row.querySelectorAll(".row-data");

                var id = data[0].innerText;
                var name = data[1].innerText;
                var marca = data[2].innerText;
                var model = data[3].innerText;
                var price = data[4].innerText;
                var cantidad = data[5].innerText;
                var detail = data[6].innerText;
                var img = data[7].querySelector("img").getAttribute('src'); // Obtiene la URL de la imagen

                alert("ID: " + id + 
                    "\nNombre: " + name + 
                    "\nMarca: "  + marca +
                    "\nModelo: " + model +
                    "\nPrecio: " + price +
                    "\nCantidad: " + cantidad +
                    "\nDetalles: " + detail +
                    "\nImagen: " + img);

                sendForm(id, name, marca, model, price, cantidad, detail, img);
            }
            function sendForm(id, name, marca, model, price, cantidad, detail, img) {
                var form = document.createElement("form");

                var idIn = document.createElement("input");
                idIn.type = 'text';
                idIn.name = 'ids';
                idIn.value = id;
                form.appendChild(idIn);

                var nombreIn = document.createElement("input");
                nombreIn.type = 'text';
                nombreIn.name = 'nombre';
                nombreIn.value = name;
                form.appendChild(nombreIn);

                var marcaIn = document.createElement("input");
                marcaIn.type = 'text';
                marcaIn.name = 'marca';
                marcaIn.value = marca;
                form.appendChild(marcaIn);

                var modeloIn = document.createElement("input");
                modeloIn.type = 'text';
                modeloIn.name = 'modelo';
                modeloIn.value = model;
                form.appendChild(modeloIn);

                var precioIn = document.createElement("input");
                precioIn.type = 'text';
                precioIn.name = 'precio';
                precioIn.value = price;
                form.appendChild(precioIn);

                var detallesIn = document.createElement("input");
                detallesIn.type = 'text';
                detallesIn.name = 'detalles';
                detallesIn.value = detail;
                form.appendChild(detallesIn);

                var cantidadIn = document.createElement("input");
                cantidadIn.type = 'text';
                cantidadIn.name = 'cantidad';
                cantidadIn.value = cantidad;
                form.appendChild(cantidadIn);

                var imagenIn = document.createElement("input");
                imagenIn.type = 'text';
                imagenIn.name = 'imagen';
                imagenIn.value = img;
                form.appendChild(imagenIn);

                console.log(form);

                form.method = 'POST';
                form.action = 'formulario_productos_v2.php';  

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    </head>
    <body>
        <h3>PRODUCTOS</h3>
        
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
                    <th scope="col">Datos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $reg) : ?>
                    <tr>
                        <th scope="row" class="row-data"><?= htmlspecialchars($reg['id']) ?></th>
                        <td class="row-data"><?= htmlspecialchars($reg['nombre']) ?></td>
                        <td class="row-data"><?= htmlspecialchars($reg['marca']) ?></td>
                        <td class="row-data"><?= htmlspecialchars($reg['modelo']) ?></td>
                        <td class="row-data"><?= htmlspecialchars($reg['precio']) ?></td>
                        <td class="row-data"><?= htmlspecialchars($reg['unidades']) ?></td>
                        <td class="row-data"><?= htmlspecialchars($reg['detalles']) ?></td>
                        <td class="row-data"><img src=<?= htmlspecialchars($reg['imagenes']) ?> ></td>
                        <td class="row-data"><input type="button" value="Mostrar Datos" onclick="showDetails(event)"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else : ?>
            <script>
                alert('No se encontraron productos disponibles.');
            </script>
        <?php endif; ?>
    </body>
</html>
