<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        if(isset($_GET['numero']))
        {
            require_once __DIR__ . '/src/funciones.php';
            multiplos5y7($_GET['numero']);
        }
    ?>
    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
    secuencia compuesta por: par,impar,par</p>
    <?php
        require_once __DIR__ . '/src/funciones.php';
        $resul = matriz_3();
        $matriz = $resul['matriz'];
        $iter = $resul['iter'];
        $num = $resul['num'];
        echo '<h3>Matriz generada:</h3>';
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Columna 1</th>';
        echo '<th>Columna 2</th>';
        echo '<th>Columna 3</th>';
        echo '</tr>';   
        for($i=0;$i<$iter;$i++)
        {
            echo '<tr>';
            echo '<td>'.$matriz[$i][0].'</td>';
            echo '<td>'.$matriz[$i][1].'</td>';
            echo '<td>'.$matriz[$i][2].'</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<h3>Se creao un total de '.$num.' numeros  y de '.$iter.' Interacciones</h3>';

    ?>
    <h2>Ejercicio 3</h2>
    <p>
        Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
        pero que además sea múltiplo de un número dado.
    </p>
    <?php
        if(isset($_GET['numero2']))
        {
            require_once __DIR__ . '/src/funciones.php';
            numeroA($_GET['numero2']);
        }
    ?>
    <p>
        Crear una variante de este script utilizando el ciclo do-while.
    </p>
    <?php
        if(isset($_GET['numero3']))
        {
            require_once __DIR__ . '/src/funciones.php';
            numeroA2($_GET['numero3']);
        }
    ?>
    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p04/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>
</body>
</html>