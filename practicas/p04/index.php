<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <p>
        $a = “ManejadorSQL”;
        $b = 'MySQL';
        $c = &$a;
    </p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;
        
        //a) Contenido de variables
        echo "<p>mostramos contenido de variables</p>";
        echo "$a, <br>";
        echo "$b, <br>";
        echo "$c, <br> <br>";

        //b) Asignaciones
        $a = "Php server";
        $b = &$a;

        //c) Volvemos a mostrar contenido de variables
        echo "<p>mostramos contenido de variables</p>";
        echo "$a, <br>";
        echo "$b, <br>";
        echo "$c, <br> <br>";

        //d) Describe en y muestra en la página obtenida qué ocurrió en el segundo bloque de asignaciones
        echo "<p> Respuesta: </p>";
        echo "En el segundo bloque se escribe php server dado a que b y c son apuntadores de a y todos estos apuntan a un solo valor (php server)";
        unset($a, $b, $c);
    ?>
    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
       verificar la evolución del tipo de estas variables (imprime todos los componentes de los
       arreglo):
    </p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $a = "PHP5";
        echo "Primer valor:  $a <br>";
        $z[] = &$a;
        echo "Segundo valor: ";
        print_r($z);
        unset($z);
        echo "<br>";
        $b = "5a version de PHP";
        echo "Tercer valor: $b <br>";
        @$c = $b*10;
        echo "Cuarto valor: $c <br>";
        $a .= $b;
        echo "Quinto valor: $a <br>";
        @$b *= $c;
        echo "Sexto valor: $b <br>";
        $z[0] = "MySQL";
        echo "Séptimo valor: , ";
        print_r($z);
    ?>
    <h2>Ejercicio 4</h2>
    <p>
        Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de
        la matriz $GLOBALS o del modificador global de PHP.
    </p>
    <?php
        //AQUI VA MI CÓDIGO PHP 
        var_dump($GLOBALS['a']);
        echo "<br>";
        
        var_dump($GLOBALS['b']);
        echo "<br>";
        
        var_dump($GLOBALS['c']);
        echo "<br>";
        
        print_r($GLOBALS['z']);
        echo "<br>";

        unset($a, $b, $c, $z);
    ?>
    <h2>Ejercicio 5</h2>
    <p>
       Dar el valor de las variables $a, $b, $c al final del siguiente script:
    </p>
    <?php
        //AQUI VA MI CÓDIGO PHP 
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;
        //Damos el valor de las variables
        echo "Valor de a: $a <br>";
        echo "Valor de b: $b <br>";
        echo "Valor de c: $c <br>";
        unset($a, $b, $c);
    ?>
    <h2>Ejercicio 6</h2>
    <p>
        Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas
        usando la función var_dump(datos).
        Después investiga una función de PHP que permita transformar el valor booleano de $c y $e
        en uno que se pueda mostrar con un echo:
    </p>
    <?php
        //AQUI VA MI CÓDIGO PHP 
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);
        echo '<p>Mostramos datos:</p>';
        var_dump($a);
        echo "<br>";
        var_dump($b);
        echo "<br>";
        var_dump($c);
        echo "<br>";
        var_dump($d);
        echo "<br>";
        var_dump($e);
        echo "<br>";
        var_dump($f);
        echo "<br>";

        echo '<p>Mostramos datos c) y e) con echo:</p>';
        echo "valor de c: " . var_export($c, true) . "<br>";
        echo "valor de e: " . var_export($e, true) . "<br>";
    ?>
    <h2>Ejercicio 7</h2>
    <p>
        Usando la variable predefinida $_SERVER, determina lo siguiente:
            a. La versión de Apache y PHP,
            b. El nombre del sistema operativo (servidor),
            c. El idioma del navegador (cliente).
    </p>
    <?php
        //AQUI VA MI CÓDIGO PHP 
        echo '<p>Mostramos datos:</p>';
        echo "Versión de Apache: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
        echo "Versión de PHP: " . phpversion() . "<br>";
        echo "Sistema operativo: " . php_uname('s') . "<br>";
        echo "Idioma del navegador: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br>";
    ?>
</body>
</html>