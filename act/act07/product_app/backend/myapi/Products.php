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
            if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                if(!is_null($rows)){
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = $value;
                        }
                    }
                }
            }
            $result->free();
            $this->conexion->close();
        }

        public function getData() {
            return json_encode($this->data);
        }

        public function search($parametro) {
            // 1. Sanitizar el input
            $search = $this->conexion->real_escape_string($parametro);
        
            // 2. Query corregida (agregar comillas al valor numérico)
            $sql = "SELECT * FROM productos 
                    WHERE (
                        id = '{$search}' 
                        OR nombre LIKE '%{$search}%' 
                        OR marca LIKE '%{$search}%' 
                        OR detalles LIKE '%{$search}%'
                    ) AND eliminado = '0'"; 
            // 3. Simplificar asignación de datos
            if ($result = $this->conexion->query($sql)) {
                $this->data = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
            } else {
                $this->data = array();
            }
            $this->conexion->close();
        }

        public function single($id) {
            $this->data = array(); 
            
            if ($id) {
                $sql = "SELECT * FROM productos WHERE id = '{$id}'";
                
                if ($result = $this->conexion->query($sql)) {
                    $row = $result->fetch_assoc();
                    if ($row) {
                        $this->data = $row;
                    }
                    $result->free();
                }
                $this->conexion->close();
            }
        }

        public function singleByName($name){
            if( $name ) {
        
                $sql = "SELECT * FROM productos WHERE nombre = '{$name}'";
        
                if ( $result = $this -> conexion->query($sql) ) {
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) {
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $this -> data[$num][$key] = $value;
                            }
                        }
                    } 
                    $result->free();
                }
                else {
                    die('Query Error: '.mysqli_error($this -> conexion));
                }
                $this -> conexion->close();
            }
        }

        public function add($object) {
            $this->data = ['status' => 'error', 'message' => 'Error desconocido'];
            
            if (empty($object)) {
                $this->data['message'] = "Datos vacíos";
                return;
            }
            
            $jsonOBJ = json_decode($object);
            if ($jsonOBJ === null) {
                $this->data['message'] = "JSON inválido";
                return;
            }
            
            // Sanitizar inputs
            $nombre = $this->conexion->real_escape_string($jsonOBJ->nombre);
            $marca = $this->conexion->real_escape_string($jsonOBJ->marca);
            $modelo = $this->conexion->real_escape_string($jsonOBJ->modelo);
            $detalles = $this->conexion->real_escape_string($jsonOBJ->detalles);
            $imagen = $this->conexion->real_escape_string($jsonOBJ->imagen);
            
            // Validar campos numéricos
            if (!is_numeric($jsonOBJ->precio) || !is_numeric($jsonOBJ->unidades)) {
                $this->data['message'] = "Valores numéricos inválidos";
                return;
            }
            
            $sqlCheck = "SELECT id FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
            if ($result = $this->conexion->query($sqlCheck)) {
                if ($result->num_rows > 0) {
                    $this->data['message'] = "El producto ya existe";
                    $result->free();
                    return;
                }
                
                $sqlInsert = "INSERT INTO productos VALUES (
                    null, 
                    '$nombre', 
                    '$marca', 
                    '$modelo', 
                    {$jsonOBJ->precio}, 
                    '$detalles', 
                    {$jsonOBJ->unidades}, 
                    '$imagen', 
                    0
                )";
                
                if ($this->conexion->query($sqlInsert)) {
                    $this->data['status'] = "success";
                    $this->data['message'] = "Producto agregado";
                    $this->data['id'] = $this->conexion->insert_id;
                } else {
                    $this->data['message'] = "Error al insertar: " . $this->conexion->error;
                }
            } else {
                $this->data['message'] = "Error en verificación: " . $this->conexion->error;
            }
            
            $this->conexion->close();
        }

        public function delete($id){
            $msj = array(
                'status'  => 'error',
                'message' => 'La consulta falló'
            );
            if( $id ) {
                $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
                if ( $this -> conexion->query($sql) ) {
                    $this -> data['status'] =  "success";
                    $this -> data['message'] =  "Producto eliminado";
                } else {
                    $this -> data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this -> conexion);
                }
                $this -> conexion->close();
            } 
        }

        public function edit($object){
            $producto = $object;
            $msj = array(
                'status'  => 'error',
                'message' => 'No se encontró el producto o ocurrió un error'
            );

            if (!empty($producto)) {
                $jsonOBJ = json_decode($producto);
                if (isset($jsonOBJ->id)) {
                    $id = $jsonOBJ->id;
                    $sql = "SELECT * FROM productos WHERE id = '{$id}' AND eliminado = 0";
                    $result = $this -> conexion->query($sql);
                    if ($result->num_rows > 0) {
                        $this -> conexion->set_charset("utf8");
                        $sql = "UPDATE productos SET
                                    nombre = '{$jsonOBJ->nombre}',
                                    marca = '{$jsonOBJ->marca}',
                                    modelo = '{$jsonOBJ->modelo}',
                                    precio = {$jsonOBJ->precio},
                                    detalles = '{$jsonOBJ->detalles}',
                                    unidades = {$jsonOBJ->unidades},
                                    imagenes = '{$jsonOBJ->imagen}'
                                WHERE id = '{$id}' AND eliminado = 0";
                        if ($this -> conexion->query($sql)) {
                            $this -> data['status'] = "success";
                            $this -> data['message'] = "Producto actualizado correctamente";
                        }
                        else {
                            $this -> data['message'] = "ERROR: No se pudo ejecutar $sql. " . mysqli_error($this -> conexion);
                        }
                    }
                    else {
                        $this -> data['message'] = "No se encontró el producto con el nombre especificado.";
                    }

                    $result->free();
                } 
                else {
                    $this -> data['message'] = "El ID del producto no fue proporcionado en el JSON.";
                }
                $this -> conexion->close();
            }
        }
    }
?>