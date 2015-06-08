<?php
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';
$maestro_id = $_POST['n_maestro_id'];



$sql_detalles = "SELECT rm.precio, pd.cantidad 
                 FROM pedido_detalles AS pd
                 INNER JOIN receta_maestros AS rm ON pd.receta_maestro_id = rm.id
                 WHERE pd.pedido_maestro_id = '$maestro_id'";
$consulta_sql = mysql_query($sql_detalles);

$total = 0;
while($r = mysql_fetch_array($consulta_sql)){
    $cantidad = $r['cantidad'];
    $precio_u = $r['precio'];
    $total = $total + ($cantidad*$precio_u);

}

//Actualizo el total de pedido_maestro
$sql_pm = "UPDATE pedido_maestros SET total = $total WHERE id = $maestro_id";

$consulta_pm = mysql_query($sql_pm);



$consulta = "SELECT rm.tipo_receta_id, pm.mesa_nro, pm.empleado_id, rm.descripcion, pd.cantidad, pd.observaciones
             FROM receta_maestros AS rm
             INNER JOIN pedido_detalles AS pd ON pd.receta_maestro_id = rm.id
             INNER JOIN pedido_maestros AS pm ON pd.pedido_maestro_id = pm.id
             WHERE pm.id = $maestro_id
             AND pd.estado_id = 1
             AND rm.tipo_receta_id NOT LIKE 4";
$r_consulta = mysql_query($consulta);



$nro_mesa = DevuelveValor($maestro_id, 'mesa_nro', 'pedido_maestros', 'id');

$consulta_e = "UPDATE pedido_detalles SET estado_id='3' WHERE pedido_maestro_id = $maestro_id AND estado_id NOT LIKE '2'";

$r_consulta_e = mysql_query($consulta_e);


?>
<html>
    <body onload="window.print();"  onUnload="self.opener.location='pedidos_grilla.php';">
_____________________________<br>
<font size="22px;">
<strong>Mesa: <?php echo $nro_mesa;?></strong>

<br>

</font>

<?php
while($r = mysql_fetch_array($r_consulta)){
    $descripcion    = $r['descripcion'];
    $cantidad       = $r['cantidad'];
    $observaciones  = $r['observaciones'];
    $tipo_receta_id = $r['tipo_receta_id'];
    $empleado_id    = $r['empleado_id'];
    $tipo_receta    = DevuelveValor($tipo_receta_id,'descripcion','tipo_recetas','id');
    $empleado       = DevuelveValor($empleado_id,'apellido','empleados','id');
?>
<strong><?php echo $tipo_receta;?></strong><br>
<strong><?php echo $cantidad;?></strong> - <?php echo $descripcion;?><br>
<?php echo $observaciones;?><br><br>
<?php
}
?>
<strong>Mozo: <?php echo $empleado;?></strong><br>
<strong>Fecha y hora: <?php echo date('d-m-Y H:i');?></strong><br>
_____________________________

    </body>
</html>