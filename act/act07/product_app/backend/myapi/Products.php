<?php 
    namespace TECWEB\MYAPI;
    include_once __DIR__.'/DataBase.php';
    class Products extends DataBase{
        private $data;
        public function __construct($db,$user='root',$pass='W0lverine'){
            $this->data = array();
            parent::__construct($db,$user,$pass);   
        }

        public function list () {
            if ( $result = $this -> conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
                // SE OBTIENEN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                if(!is_null($rows)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this -> data[$num][$key] = $value;
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this -> conexion));
            }
            $this -> conexion->close();
        }

        public function getData() {
            return json_encode($this -> data, JSON_PRETTY_PRINT);
        }
    }
?>