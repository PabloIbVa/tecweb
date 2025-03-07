<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'W0lverine',
        'marketzone'
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conectada!');
    }
?>