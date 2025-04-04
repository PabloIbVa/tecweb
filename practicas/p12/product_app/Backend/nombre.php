<?php
header('Content-Type: application/json'); // Establecemos el tipo de contenido a JSON
require_once __DIR__.'/../vendor/autoload.php'; // Autoload de Composer
use Backend\Myapi\Functions\Read as Products; // Importar la clase Products

$name = $_GET['name'] ?? ''; //obtenemos el nombre del producto
$prod = new Products('marketzone');//creamos una instancia de Products
$prod->singleByName($name); //buscamos el producto por nombre
$data = json_decode($prod->getData(), true); //obtenemos los datos del producto

echo json_encode([ //devolvemos los datos del producto
    'existe' => !empty($data) //verificamos si el producto existe
]);
?>