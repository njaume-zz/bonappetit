<?php
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';
$maestro_id = $_POST['n_maestro_id'];


$con_fin = "UPDATE pedido_maestros SET finalizado='2' WHERE id=$maestro_id";
$run_cf  = mysql_query($con_fin);


$consulta = "SELECT rm.tipo_receta_id, pm.mesa_nro, pm.empleado_id, rm.descripcion, pd.cantidad, pd.precio_unitario, pd.observaciones
             FROM receta_maestros AS rm
             INNER JOIN pedido_detalles AS pd ON pd.receta_maestro_id = rm.id
             INNER JOIN pedido_maestros AS pm ON pd.pedido_maestro_id = pm.id
             WHERE pm.id = $maestro_id";
$r_consulta = mysql_query($consulta);

$nro_mesa   = DevuelveValor($maestro_id, 'mesa_nro', 'pedido_maestros', 'id');
$cliente_id = DevuelveValor($maestro_id, 'cliente_id', 'pedido_maestros', 'id');
$fyh        = DevuelveValor($maestro_id, 'fecha_y_hora', 'pedido_maestros', 'id');
$total_pm   = DevuelveValor($maestro_id, 'total', 'pedido_maestros', 'id');
$tipo_iva   = DevuelveValor($cliente_id, 'condicion_iva_id', 'clientes', 'id');


//Guardo todo en factura maestro y factura detalle para dejar constancia de la venta
$con_fac_mes = "
                INSERT INTO `factura_maestros` (
                `id` ,
                `descripcion` ,
                `fecha_y_hora` ,
                `cliente_id` ,
                `total` ,
                `subtotal` ,
                `tipo_iva_id` ,
                `empresa_id`,
                `usuario_id`
                )
                VALUES (
                NULL ,
                'VENTA DE COMIDA EN SALON - $fyh',
                '$fyh',
                '$cliente_id',
                '$total_pm',
                '0',
                '2',
                '1',
                '1'
                )
";
//echo $con_fac_mes;
$r_fac_mes = mysql_query($con_fac_mes);

$query_id = mysql_query("SELECT @@identity AS id");
 if ($row_id = mysql_fetch_row($query_id)) 
 {
   $pm_id = trim($row_id[0]);
 }




?>
<html>
    <body onload="window.print();">
<img src="images/logo.png"><br>
<font size="22px;">
<strong>Mesa: <?php echo $nro_mesa;?></strong>
<br>

</font>

<?php 
while($r = mysql_fetch_array($r_consulta)){
    $descripcion    = $r['descripcion'];
    $cantidad       = $r['cantidad'];
    $precio_u       = $r['precio_unitario'];
    $observaciones  = $r['observaciones'];
    $tipo_receta_id = $r['tipo_receta_id'];
    $empleado_id    = $r['empleado_id'];
    $tipo_receta    = DevuelveValor($tipo_receta_id,'descripcion','tipo_recetas','id');
    $empleado       = DevuelveValor($empleado_id,'apellido','empleados','id');
    
    //Inserto los detalles en la factura_detalles.
    $sql_fd = "INSERT INTO `factura_detalles`(
                            `id`,
                            `descripcion`,
                            `factura_maestro_id`,
                            `cantidad`,
                            `precio_unitario`,
                            `empresa_id`,
                            `usuario_id`
                            ) VALUES (
                            NULL,
                            '$descripcion',
                            $pm_id,
                            $cantidad,
                            $precio_u,
                            1,
                            1
                            )";
    //echo $sql_fd;
    mysql_query($sql_fd);
    
    
    $total          = $total + ($cantidad * $precio_u);
?>
<strong><?php echo $cantidad;?></strong> - <?php echo $descripcion;?> - <strong><?php echo $precio_u;?></strong>
<br>
<?php
}





?>
<h2>Total: $<?php echo $total;?></h2>
<strong>Mozo: <?php echo $empleado;?></strong><br>
<strong>Fecha y hora: <?php echo date('d-m-Y H:i');?></strong><br>
_____________________________________<br>
Documento no v&aacute;lido como factura.<br>
Solicite su factura en la caja.
    </body>
</html>