<?php
use TECWEB\MYAPI\Products as Products;
include_once __DIR__.'/myapi/Products.php';

$id = $_GET['id'] ?? null;
$prod = new Products('marketzone');
$prod->delete($id);
echo json_encode($prod->getData());
?>