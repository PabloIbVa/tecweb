<?php
use TECWEB\MYAPI\Products as Products; // Importar la clase Products
include_once __DIR__.'/myapi/Products.php'; // Incluir el archivo Products.php

$producto = file_get_contents('php://input'); // Obtener el contenido del body
$prod = new Products('marketzone'); // Instanciar la clase Products
$prod->edit($producto); // Llamar al método edit
echo $prod->getData(); // Imprimir el resultado
?>