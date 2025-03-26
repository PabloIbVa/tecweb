<?php 
    class Persona{
        private $nombre;

        public function inicializar($name){
            $his->nombre = $name;
        }

        public function mostrar(){
            echo '<p>'. $this->nombre.'</p>';
        }
    }
?>