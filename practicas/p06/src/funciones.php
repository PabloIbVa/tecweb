<?php
    function multiplos5y7($num)
    {
        if ($num%5==0 && $num%7==0)
        {
            echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
        }
        else
        {
            echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
        }
    }
    function par_im_par($col1,$col2,$col3){
        if ($col1%2==0 && $col2%2!=0 && $col3%2==0) {
            return true;
        }
        else{
            return false;
        }
    }
    function matriz_3(){
        $matriz = array();
        $num = 0;
        $iter = 0;
        $i = 0;
        do{
            $col1 = rand(1, 100);
            $col2 = rand(1, 100);
            $col3 = rand(1, 100);
            $matriz[$i][0] = $col1;
            $matriz[$i][1] = $col2;
            $matriz[$i][2] = $col3;
            $i++;   
            $num = $num + 3;
            $iter++;
        }while(par_im_par($col1,$col2,$col3)==false);
        return[
            'matriz' => $matriz,
            'iter' => $iter,
            'num' => $num
        ];
    }
    function numeroA($num){
        $numA = rand(1, 100);
        while($numA%$num!=0){
            $numA = rand(1, 100);
        }
        echo '<h3>El primer número entero obtenido aleatoriamente, pero que además sea múltiplo de '.$num.' es: '.$numA.'</h3>';
    }   
    function numeroA2($num){
        do{
            $numA = rand(1, 100);
        }while($numA%$num!=0);
        echo '<h3>El primer número entero obtenido aleatoriamente, pero que además sea múltiplo de '.$num.' es: '.$numA.'</h3>';
    }
?>