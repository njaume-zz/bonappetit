<?php
$tip = '';

include_once('html_sup.php');

?>
<div align="center" class="iframedoc">
<div align="center" class="titulo">
    <strong>ALERTA</strong>: Esta planilla NO EDITABLE  permite una vista panor&aacute;mica de los vencimientos de documentaci&oacute;n de veh&iacute;culos.
</div>
<br>
<?php

//inicializo variables:
$parametros_id = array();
$parametros_plazo_vigencia = array();
$parametros_dias_alerta = array();
$fecha_actual = date('Y-m-d');


//leo los nombres de los parámetros que serán los encabezados de las columnas.
$consulta = "SELECT * FROM parametros_vehiculos";
$resultado = mysql_query($consulta);

    echo '<table align="center">';
    echo '<tr>';
    echo '<th>Dominio</th>';
    echo '<th>Descripci&oacute;n</th>';
    

    
while ($fila = mysql_fetch_array($resultado, MYSQL_BOTH)) {
    echo '<th>'.$fila['descripcion'].'</th>';
    $parametros_id[]             = $fila['id'];   
    $parametros_plazo_vigencia[] = $fila['plazo_vigencia'];
    $parametros_dias_alerta[]    = $fila['dias_alerta']; 
    
}
    echo '</tr>'; //fin del encabezado
    //print_r($parametros_id); //Esto es para ver como se forma el array
    $total_parametros = count($parametros_id);
    
//
//
//Para cada vehiculo:

$consulta2  = "SELECT * FROM vehiculos";
$resultado2 = mysql_query($consulta2);


while ($fila2 = mysql_fetch_array($resultado2, MYSQL_BOTH)) {
echo '<tr>';    
    echo '<td>'.$fila2['dominio'].'</td>';  
    echo '<td>'.$fila2['descripcion'].'</td>';
    $vehiculo_id = $fila2['id'];


        //For que sirve para llenar cada celda (tenga dato de vencimiento o no)
        for ($i = 0; $i <= $total_parametros-1; $i++){
            $parametros_vehiculo_id = $parametros_id[$i];
            $consulta_doc = "SELECT ultima_renovacion, proximo_vencimiento_normal, proximo_vencimiento_excepcion, fecha_turno_reservado 
                             FROM documentacion_vehiculos 
                             WHERE parametros_vehiculo_id = '$parametros_vehiculo_id'
                             AND vehiculo_id = '$vehiculo_id'";
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
                  if (($dias_restantes <= 20) AND ($dias_restantes >= 10)) {
                      $color = '#fbec88';
                  }
                  if ($dias_restantes <= 10)  {
                      $color = '#FF0000';
                  }
                  
                  //imprimo las celdas y los tooltips
                  echo '<td align="center" bgcolor="'.$color.'">';
                  echo '<a href="#" class="tt">';
                  echo $dias_restantes;
                  echo '<span class="tooltip"><span class="top"></span><span class="middle">';
                  echo 'Ultima renovacion: <br>'.$ultima_renovacion.'<br>';
                  echo 'Fecha de vencimiento: <br>'.$proximo_vencimiento_normal.'<br>';
                  echo 'Turno reservado: <br>'.$fecha_turno_reservado.'<br>';
                  echo '</span><span class="bottom"></span></span></a>';
                  echo '</td>';
                  
            }else{
                echo '<td align="center"> - </td>';
            }
            

            
                $ultima_renovacion              = '';
                $proximo_vencimiento_normal     = '';
                $proximo_vencimiento_excepcion  = '';
                $fecha_turno_reservado          = '';
                $color = '';
        
        }

 
    

    
    
echo '</tr>'; //fin 
}





    echo '</tr>'; //fin del encabezado







//fin de la tabla
    echo '</table>';

?>
</div>
<?php
include_once('html_inf.php');
?>