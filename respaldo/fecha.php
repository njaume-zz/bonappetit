<?php
// fecha original en formato americano
$fecha = "2008-12-10";
$dia = substr($fecha, 0, 2);
$mes   = substr($fecha, 3, 2);
$ano = substr($fecha, -4);
// fechal final realizada el cambio de formato a las fechas europeas
$fecha = $dia . '-' . $mes . '-' . $ano;
echo $fecha
?>