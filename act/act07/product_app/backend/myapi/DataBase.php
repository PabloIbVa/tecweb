<?php
    namespace TECWEB\MYAPI;
    abstract class DataBase{
        protected $conexion;
        public function __construct($db,$user,$pass){
            $this->conexion = new \mysqli('localhost',$user,$pass,$db,3306);
        }
    }
?>