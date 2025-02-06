<?php
  header("Content-Type: application/xhtml+xml; charset=utf-8");
  echo "<?xml version='1.0' encoding='UTF-8'?>\n";                //se añade la cabecera XML con version 1.0 y codificación UTF-8
  echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='es'>\n"; //se añade el formato xml y el lenguaje español
  
  echo "<head>\n";
    echo "<title>Respuesta</title>\n";
  echo "</head>\n";
  echo "<body>\n";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {                   //si el método de envío es POST entonces se ejecuta el siguiente bloque
        $edad = $_POST["edad"];                                   //adquirimos los valores de edad y sexo
        $genero = $_POST["genero"];
        if ($genero == "femenino" && $edad >= 18 && $edad <= 35) {
        echo "<p>Bienvenida, usted está en el rango de edad permitido.</p>\n";
        } 
        else {
        echo "<p>Lo sentimos, no cumple con los requisitos.</p>\n";
        }
    }
  echo "</body>\n";
  echo "</html>\n";
?>