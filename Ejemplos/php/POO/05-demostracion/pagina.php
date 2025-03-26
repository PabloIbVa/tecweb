<?php
class pagina{
    private $cabecera;
    private $cuerpo;
    private $pie;
    
    public function __construct($texto1,$texto2){
        $this->cabecera = new Cabecera($texto1);
        $this->cuerpo = new Cuerpo;
    }

    public function insertar_cuerpo($texto){
        $this->cuerpo->insertar_parrafo($texto);
    }

    public function graficar(){
        $this->cabecera->graficar();
        $this->cuerpo->graficar();
        $this->pie->graficar();
    }
}

?>