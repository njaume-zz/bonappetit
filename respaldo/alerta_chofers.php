<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = '';

include_once('html_sup.php');


function OrdenArray ($ordenar, $campo, $inverso = false) {  
    $posicion = array();  
    $nuevafila = array();  
    foreach ($ordenar as $clave => $fila) {  
            $posicion[$clave]  = $fila[$campo];  
            $nuevafila[$clave] = $fila;  
    }  
    if ($inverso) {  
        arsort($posicion);  
    }  
    else {  
        asort($posicion);  
    }  
    $devuelvematriz = array();  
    foreach ($posicion as $clave => $pos) {       
        $devuelvematriz[] = $nuevafila[$clave];  
    }  
    return $devuelvematriz;  
}  


$submit = $_POST['submit'];
if (!empty($submit)) {
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
}else{
   
//inicializo variables:
$parametros_id = array();
$parametros_plazo_vigencia = array();
$parametros_dias_alerta = array();
$fecha_actual = date('Y-m-d');
$nro_filas = 0;

//leo los nombres de los parámetros que serán los encabezados de las columnas.
$consulta = "SELECT * FROM parametros_chofers";
$resultado = mysql_query($consulta);

    //echo '<table align="center">';
    //echo '<tr>';
    //echo '<th>Legajo</th>';
    //echo '<th>Descripci&oacute;n</th>';
    $encabezado[0] = 'Legajo'; 
    $encabezado[1] = 'Descripci&oacute;n';
    $j=2; 
 
    
    
while ($fila = mysql_fetch_array($resultado, MYSQL_BOTH)) { //while que crea el encabezado de la tabla
    $descripcion = $fila['descripcion'];
    //echo '<th>'.$descripcion.'</th>';
    $encabezado[$j] = $descripcion;  //Agrego descripciones a la matriz (encabezados)
    $parametros_id[]             = $fila['id'];   
    $parametros_plazo_vigencia[] = $fila['plazo_vigencia'];
    $parametros_dias_alerta[]    = $fila['dias_alerta']; 
    $j = $j + 1;
}
    //echo '</tr>'; //fin del encabezado
    //print_r($parametros_id); //Esto es para ver como se forma el array
    $total_parametros = count($parametros_id);

    
    
$indice_i = 0;
//
//
//Para cada chofer:

$consulta2  = "SELECT * FROM chofers ORDER BY descripcion";
$resultado2 = mysql_query($consulta2);


while ($fila2 = mysql_fetch_array($resultado2, MYSQL_BOTH)) {  //while que crea la fila
//echo '<tr>';
    $valor_legajo = $fila2['legajo'];
    //echo '<td>'.$valor_legajo.'</td>';
    $valor_descripcion = $fila2['descripcion'];
    //echo '<td>'.$valor_descripcion.'</td>';
    $chofer_id = $fila2['id'];
    $matriz[$indice_i][0] = $valor_legajo;
    $matriz[$indice_i][1] = $valor_descripcion;    
    $indice_j = 2;
    
        //For que sirve para llenar cada celda (tenga dato de vencimiento o no)
        for ($i = 0; $i <= $total_parametros-1; $i++){
            $parametros_chofer_id = $parametros_id[$i];
            $dias_alerta = $parametros_dias_alerta[$i];
            
            $consulta_doc = "SELECT ultima_renovacion, proximo_vencimiento_normal, proximo_vencimiento_excepcion, fecha_turno_reservado 
                             FROM documentacion_chofers 
                             WHERE parametros_chofer_id = '$parametros_chofer_id'
                             AND chofer_id = '$chofer_id'";
            $resultado_doc = mysql_query($consulta_doc);
            while ($fila_doc = mysql_fetch_array($resultado_doc, MYSQL_BOTH)) {
                $ultima_renovacion              = $fila_doc['ultima_renovacion'];
                $proximo_vencimiento_normal     = $fila_doc['proximo_vencimiento_normal'];
                $proximo_vencimiento_excepcion  = $fila_doc['proximo_vencimiento_excepcion'];
                $fecha_turno_reservado          = $fila_doc['fecha_turno_reservado']; 
            }

            if (!empty($ultima_renovacion)) {
                //calculo los dias de vencimiento y dependiendo de los que quedan, cambio el color de fondo de la celda

                  $fecha1 = new DateTime($proximo_vencimiento_normal);
                  $fecha2 = new DateTime($fecha_actual);
                  $intervalo = $fecha2->diff($fecha1);
                  $dias_restantes = $intervalo->format('%R%a');
                  
                  //Aca el color lo tengo que elegir según los parámetros
                  
                  if (($dias_restantes <= $dias_alerta) AND ($dias_restantes >= 0)) {
                      $color = '#fbec88';
                  }
                  if ($dias_restantes <= 0)  {
                      $color = '#FF0000';
                  }
                  
                  //imprimo las celdas y los tooltips
                  $contenido_celda =  
                  '<td align="center" bgcolor="'.$color.'">
                  <a href="#" class="tt">
                  '.$dias_restantes.'
                  <span class="tooltip">
                  <span class="top">
                  </span>
                  <span class="middle">
                  Ultima renovacion: <br>'.$ultima_renovacion.'<br>
                  Fecha de vencimiento: <br>'.$proximo_vencimiento_normal.'<br>
                  Turno reservado: <br>'.$fecha_turno_reservado.'<br>
                  D&iacute;as de alerta: <br>'.$dias_alerta.'<br>
                  </span>
                  <span class="bottom">
                  </span>
                  </span>
                  </a>
                  </td>';
                  $matriz[$indice_i][$indice_j] = $contenido_celda;
                  
                  //echo $contenido_celda;
                  
            }else{
                  $contenido_celda = '<td align="center">-</td>';
                  $matriz[$indice_i][$indice_j] = $contenido_celda;
                  //echo $contenido_celda;
            } //Fin del else

                $ultima_renovacion              = '';
                $proximo_vencimiento_normal     = '';
                $proximo_vencimiento_excepcion  = '';
                $fecha_turno_reservado          = '';
                $color = '';
                $indice_j = $indice_j + 1;
        } //fin del for

    
//echo '</tr>'; 
$indice_i = $indice_i + 1; //Incremento el número de la fila

} //Fin del while que crea la fila

//    echo '</tr>'; //fin del encabezado

//fin de la tabla
//    echo '</table></div>';

//Convierto la matriz a formato especial para pasarla por POST
    $compactada = serialize($matriz);
    $compactada = urlencode($compactada);
    
    $com_encabezado = serialize($encabezado);
    $com_encabezado = urlencode($com_encabezado);
    
  
    
    
 $nro_columnas = $total_parametros + 2;   
 $total_filas = $indice_i;   
    
    
}


//leo los nombres de los parámetros que serán los encabezados de las columnas.
?>
<div align="center" class="titulo">
    <strong>ALERTA</strong>: Esta planilla NO EDITABLE  permite una vista panor&aacute;mica de los vencimientos de documentaci&oacute;n de choferes.
</div>
<div align="center" class="iframedoc">
<br>
<?php
    echo '<table align="center">';
    echo '<tr>'; //comienzo del encabezado

    for ($j=0; $j<=$nro_columnas-1; $j++) { //while que crea el encabezado de la tabla
        $descripcion = $encabezado[$j];
        echo '
        <th bgcolor="white">
        <form name="form" method="post" action="alerta_chofers.php">
            <input type="hidden" name="matriz" value="'.$compactada.'">
            <input type="hidden" name="encabezado" value="'.$com_encabezado.'">    
            <input type="hidden" name="total_parametros" value="'.$total_parametros.'">
            <input type="hidden" name="total_filas" value="'.$total_filas.'">
            <input type="hidden" name="cambiaorden" value="'.$j.'">
            <input type="hidden" name="cambiado" value="'.$cambiado.'">
            <input class="boton_relacion" type="submit" name="submit" value="'.str_replace(" ","\n",$descripcion).'">
        </form>';
        if ($cambiado == 0) {echo '<img src="images/abajo.gif" align="center">';}
        else {echo '<img src="images/arriba.gif" align="center">';}
        
        echo '
        </th>'; 
    }
        echo '</tr>'; 

//Completo las filas con datos:

    for ($i=0; $i<=$total_filas-1; $i++) {
        if($i%2) 
        $bgcolor="white";
            else 
        $bgcolor="";    
        echo '<tr bgcolor="'.$bgcolor.'">'; //comienzo de la fila
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
?>


<?php
include_once('html_inf.php');
?>