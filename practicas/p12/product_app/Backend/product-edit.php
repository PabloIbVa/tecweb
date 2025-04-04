<?php
header('Content-Type: application/json'); // Establecemos el tipo de contenido a JSON
require_once __DIR__.'/../vendor/autoload.php'; // Autoload de Composer
use Myapi\Update\Update as Products; // Hacemos que la clase Products esté disponible

$producto = file_get_contents('php://input'); // Obtener el contenido del body
$prod = new Products('marketzone'); // Instanciar la clase Products
$prod->edit($producto); // Llamar al método edit
echo $prod->getData(); // Imprimir el resultado
?>