<?php
header('Content-Type: application/json');

use TECWEB\MYAPI\Products as Products;
include_once __DIR__.'/myapi/Products.php';

try {
    $id = $_POST['id'] ?? null;
    $prod = new Products('marketzone');
    $prod->single($id);
    echo $prod->getData() ?: '{}';
} catch(Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>