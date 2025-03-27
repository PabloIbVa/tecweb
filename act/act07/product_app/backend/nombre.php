<?php
use TECWEB\MYAPI\Products as Products; // hacemos que la clase Products esté disponible
include_once __DIR__.'/myapi/Products.php'; //incluimos el archivo Products.php

$name = $_GET['name'] ?? ''; //obtenemos el nombre del producto
$prod = new Products('marketzone');//creamos una instancia de Products
$prod->singleByName($name); //buscamos el producto por nombre
$data = json_decode($prod->getData(), true); //obtenemos los datos del producto

echo json_encode([ //devolvemos los datos del producto
    'existe' => !empty($data) //verificamos si el producto existe
]);
?>