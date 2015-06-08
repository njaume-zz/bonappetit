<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

//Leo todos los pedidos maestro. Por cada pedido maestro, leo los detalles asociados. 
//Por cada detalle creo un factura detalles y por cada maestro creo un factura maestros
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';



$sql_pm = "TRUNCATE TABLE  `pedido_detalles`";
$result = mysql_query($sql_pm) or trigger_error(mysql_error());


$sql_pm = "DELETE FROM `pedido_maestros` WHERE 1";
$result = mysql_query($sql_pm) or trigger_error(mysql_error());

header("Location:pedido_maestros.php");
?>
