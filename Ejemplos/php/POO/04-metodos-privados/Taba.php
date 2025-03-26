<?php 
class Tabla {
    private $matriz = array();
    private $numfilas;
    private $numcol;
    private $estilo;

    public function __construct($rows,$cols,$style){
        $this->numfilas= $rows;
        $this->numcol = $cols;
        $this->estilo = $style;
    }

    public function cargar($row,$col,$val){
        $this->matriz[$row][$col] = $val;
    }

    private function inicio_tabla(){
        echo '<table style=">'.$this->estilo.'">';
    }

    private function inicio_fila(){
        echo '<tr>';
    }

    private function mostrar_dato($row,$col){
        echo '<td style=">'.$this->estilo.'">';
        echo $this->matriz[$row][$col];
        echo '</td>';
    }

    private function fin_fila(){
        echo '</tr>';
    }

    private function fin_tabla(){
        echo '</table>';
    }

    public function graficar(){
        $this->inicio_tabla();
        for($i = 0; $i<$this->numfilas;$i++){
            $this->inicio_fila();
            for($j = 0; $j<$this->numcol;$j++){
                $this->mostrar_dato($i,$j);
            }
            $this->fin_fila();
        }
        $this->fin_tabla();
    }
}
?>