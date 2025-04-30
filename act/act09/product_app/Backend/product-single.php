<?php
header('Content-Type: application/json');

require_once __DIR__.'/../vendor/autoload.php';
use Myapi\Read\Read as Products; // Hacemos que la clase Products esté disponible

try {
    $id = $_POST['id'] ?? null;
    $prod = new Products('marketzone');
    $prod->single($id);
    echo $prod->getData() ?: '{}';
} catch(Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>