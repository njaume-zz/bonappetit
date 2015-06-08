<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = 'En "D&iacute;as a vencer" poner el valor 0. El sistema actualizar&aacute; autom&aacute;ticamente';

include_once('html_sup.php');


//tomo el id del chofer, el id del parámetro y la fecha de la última renovación para calcular el próximo vencimiento normal y los días hasta el vencimiento (que son los días del parámetro). Estos últimos deberían actualizarse con algún script automático todos los días (quizás en el cron). Puedo usar algún administrador de cron como Schedule Task de Gnome para llamar específicamente el script /usr/bin/php -f /home/sistemas/sistemas/gestruck/script_cron.php

//selecciono todos los vehículos
$consulta  = "SELECT id,proximo_vencimiento_normal,dias_a_vencer FROM documentacion_chofers";
$resultado = mysql_query($consulta);


while ($fila = mysql_fetch_array($resultado, MYSQL_BOTH)) { 

//documento por docuemento, tomo el próximo vencimiento y según la fecha actual calculo el plazo a vencer y actualizo los días a vencer en la tabla
  
    $proximo_vencimiento_normal = $fila['proximo_vencimiento_normal'];
    $id = $fila['id'];
    
    $fecha_actual = date('Y-m-d');
  
    //Calculo los días que faltan para el vencimiento:
    $fecha1 = new DateTime($proximo_vencimiento_normal);
    $fecha2 = new DateTime($fecha_actual);
    $intervalo = $fecha2->diff($fecha1);
    $dias_a_vencer = $intervalo->format('%R%a');
   
    //Actualizo los datos en la base de datos.
    
    $sql = "UPDATE documentacion_chofers SET dias_a_vencer='$dias_a_vencer' WHERE id=$id";
    mysql_query($sql);
    
}
    

echo "<br><br><br><br><br><h2>La actualizaci&oacute;n se realiz&oacute; exitosamente.<h2><br><br><br><br><br><br><br>";


include_once('html_inf.php');
?>