<?php
header('Content-Type: application/json'); // Establecemos el tipo de contenido a JSON
require_once __DIR__.'/../vendor/autoload.php';
use Backend\Myapi\Functions\Delete as Products; // Hacemos que la clase Products esté disponible

$id = $_GET['id'] ?? null;
$prod = new Products('marketzone');
$prod->delete($id);
echo json_encode($prod->getData());
?>