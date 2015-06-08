<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}
$tip = '';

include_once('html_sup.php');

?>

<div align="center" class="titulo">
    <strong>ALERTA</strong>: Esta planilla NO EDITABLE  permite una vista panor&aacute;mica de los vencimientos de documentaci&oacute;n de choferes.
</div>
<div align="center" class="iframedoc">
<br>
<?php

function OrdenArray ($toOrderArray, $field, $inverse = false) {  
    $position = array();  
    $newRow = array();  
    foreach ($toOrderArray as $key => $row) {  
            $position[$key]  = $row[$field];  
            $newRow[$key] = $row;  
    }  
    if ($inverse) {  
        arsort($position);  
    }  
    else {  
        asort($position);  
    }  
    $returnArray = array();  
    foreach ($position as $key => $pos) {       
        $returnArray[] = $newRow[$key];  
    }  
    return $returnArray;  
}  


$com_encabezado = $_POST['encabezado'];
$a = stripslashes($com_encabezado); //saco las contrabarras agregadas con urlencode
$b = urldecode($a);
$encabezado = unserialize($b); //vuelvo a armar la matriz desarmada con serialize

$compactada = $_POST['matriz'];
$a = stripslashes($compactada); //saco las contrabarras agregadas con urlencode
$b = urldecode($a);
$matriz = unserialize($b); //vuelvo a armar la matriz desarmada con serialize


$total_parametros = $_POST['total_parametros'];
//Recorro la matriz y la muestro
$nro_columnas = $total_parametros + 2;

$total_filas = $_POST['total_filas'];

$cambiaorden = $_POST['cambiaorden'];

$cambiado = $_POST['cambiado'];

//Ordeno la matriz
if (!empty($cambiaorden)) {
    if ($cambiado == 1) {
        $invertir = true;
        $cambiado = 0;
    }else{$cambiado = 1;}
    $matriz = OrdenArray($matriz, "$cambiaorden", $invertir); 
}



//leo los nombres de los parámetros que serán los encabezados de las columnas.

    echo '<table align="center">';
    echo '<tr>'; //comienzo del encabezado

    for ($j=0; $j<=$nro_columnas; $j++) { //while que crea el encabezado de la tabla
        $descripcion = $encabezado[$j];
        echo '
        <th>
        <form name="form" method="post" action="vista_alerta_chofers.php">
            <input type="hidden" name="matriz" value="'.$compactada.'">
            <input type="hidden" name="encabezado" value="'.$com_encabezado.'">    
            <input type="hidden" name="total_parametros" value="'.$total_parametros.'">
            <input type="hidden" name="total_filas" value="'.$total_filas.'">
            <input type="hidden" name="cambiaorden" value="'.$j.'">
            <input type="hidden" name="cambiado" value="'.$cambiado.'">    
            <input type="submit" name="submit" value="'.$descripcion.'">
        </form>
        </th>'; 
    }
        echo '</tr>'; 

//Completo las filas con datos:

    for ($i=0; $i<=$total_filas-1; $i++) {
        echo '<tr>'; //comienzo de la fila
        for ($j=0; $j<=$nro_columnas; $j++) { //while que crea el encabezado de la tabla
            $descripcion = $matriz[$i][$j];
            if (($j==0) OR ($j==1)) {
                echo '<td>'.$descripcion.'</td>';
            }else{
                echo $descripcion;
            }
        }
        echo '</tr>';    
    }    


//fin de la tabla
    echo '</table></div>';


include_once('html_inf.php');
?>