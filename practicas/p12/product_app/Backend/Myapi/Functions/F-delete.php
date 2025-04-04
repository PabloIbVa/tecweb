<?php
namespace Backend\Myapi\Functions;
use Backend\Myapi\DataBase;
class Delete extends DataBase{
    public function __construct($db,$user='root',$pass='W0lverine'){
        $this->data = array();
        parent::__construct($db,$user,$pass);   
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
}
?>