<?php
require_once __DIR__.'/../vendor/autoload.php'; // Autoload de Composer
use Backend\Myapi\Functions\Read as Products; // Hacemos que la clase Products esté disponible

$prod = new Products('marketzone');
$prod->list();
echo $prod->getData();
?>