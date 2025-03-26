<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej 4</title>
</head>
<body>
    <?php 
    require_once __DIR__.'/Taba.php';

    $tab1 = new Tabla(2,3,'border: 1px solid');
    $tab1->cargar(0,0,'A');
    $tab1->cargar(0,1,'B');
    $tab1->cargar(0,2,'C');
    $tab1->cargar(1,0,'D');
    $tab1->cargar(1,1,'F');
    $tab1->cargar(1,2,'G');

    $tab1->graficar();
    ?>
</body>
</html>