<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = 'En "D&iacute;as a vencer" poner el valor 0. El sistema actualizar&aacute; autom&aacute;ticamente';

include_once('html_sup.php');
include("scaffold.php");

$sql = "SELECT * FROM documentacion_vehiculos";
$consulta = mysql_query($sql,$link);

while ($fila = mysql_fetch_array($consulta, MYSQL_BOTH))
{
$id = $fila['id'];

$vehiculo_id      = $fila['vehiculo_id'];
$vehiculo_des     = DevuelveValor($vehiculo_id, 'descripcion', 'vehiculos', 'id');

$parametro_id   = $fila['parametros_vehiculo_id'];
$parametro_des  = DevuelveValor($parametro_id, 'descripcion', 'parametros_vehiculos', 'id');

$descripcion = "$vehiculo_des".' - '."$parametro_des";
echo $descripcion;
$sql2 = "UPDATE documentacion_vehiculos SET descripcion='$descripcion',calculado='SI' WHERE id=$id";
mysql_query($sql2,$link);
    

}

include_once('html_inf.php');
?>