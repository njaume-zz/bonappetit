<?php
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';
$pedido_detalle_id = $_POST['id_value'];
//echo $pedido_detalle_id;

//Actualizo los siguientes datos en base de datos. EL precio y el tiempo de entrega en pedido_detalles, el stock en las recetas


$diayhora = date("Y-m-d H:i:s");

//Tomo el id de la receta asociada al pedido detalle
$receta_maestro_id = DevuelveValor($pedido_detalle_id,'receta_maestro_id','pedido_detalles','id');
$precio            = DevuelveValor($receta_maestro_id, 'precio', 'receta_maestros', 'id');

$pedido_maestro_id = DevuelveValor($pedido_detalle_id, 'pedido_maestro_id', 'pedido_detalles', 'id');

$consulta = "UPDATE pedido_detalles SET estado_id='2',precio_unitario='$precio',timestamp_entrega='$diayhora' WHERE id = $pedido_detalle_id";
$r_consulta = mysql_query($consulta);

$sql_detalles = "SELECT cantidad,precio_unitario FROM pedido_detalles WHERE pedido_maestro_id = '$pedido_maestro_id'";
$consulta_sql = mysql_query($sql_detalles);

$total = 0;
while($r = mysql_fetch_array($consulta_sql)){
    $cantidad = $r['cantidad'];
    $precio_u = $r['precio_unitario'];
    $total = $total + ($cantidad*$precio_u);

}

//Actualizo el total de pedido_maestro
$sql_pm = "UPDATE pedido_maestros SET total = $total WHERE id = $pedido_maestro_id";
$consulta_pm = mysql_query($sql_pm);

?>
<html>
    <body onload="document.forms.ciclo.submit();">
        <form action="pedido_detalles.php" method="post" name="ciclo">
        <input type="hidden" name="maestro_id" value="<?php echo $pedido_maestro_id;?>">
        
        </form>    
        
    </body>
</html>