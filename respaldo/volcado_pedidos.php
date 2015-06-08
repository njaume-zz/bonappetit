<?php
//Leo todos los pedidos maestro. Por cada pedido maestro, leo los detalles asociados. 
//Por cada detalle creo un factura detalles y por cada maestro creo un factura maestros
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';

$sql_pm = "SELECT * FROM `pedido_maestros` WHERE 1";
$result = mysql_query($sql_pm) or trigger_error(mysql_error());

echo $sql_pm."<br>".$result;


while($row = mysql_fetch_array($result)){
    
     $id            = $row['id'];
     $descripcion   = $row['descripcion'];
     $fyh           = $row['fecha_y_hora'];
     $cliente_id    = $row['cliente_id'];
     $total         = $row['total'];
     

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
                `usuario_id`
                )
                VALUES (
                NULL ,
                'VENTA DE COMIDA EN SALON - $fyh',
                '$fyh',
                '$cliente_id',
                '$total',
                '0',
                '2',
                '1'
                )
";
echo $con_fac_mes."<br>";


mysql_query($con_fac_mes);

$query_id = mysql_query("SELECT @@identity AS id");
 if ($row_id = mysql_fetch_row($query_id)) 
 {
   $pm_id = trim($row_id[0]);
 }
     
     $sql_pd    = "SELECT * FROM `pedido_detalles` WHERE pedido_maestro_id = $id";
     $result_pd = mysql_query($sql_pd) or trigger_error(mysql_error()); 
     
     while($r = mysql_fetch_array($result_pd)){
         
        $descripcion    = $r['descripcion'];
        $cantidad       = $r['cantidad'];
        $precio_u       = $r['precio_unitario'];
        $tipo_receta_id = $r['receta_maestro_id'];
        $tipo_receta    = DevuelveValor($tipo_receta_id,'descripcion','receta_maestros','id');

        //Inserto los detalles en la factura_detalles.
        $sql_fd = "INSERT INTO `factura_detalles`(
                                `id`,
                                `descripcion`,
                                `factura_maestro_id`,
                                `cantidad`,
                                `precio_unitario`,
                                `usuario_id`
                                ) VALUES (
                                NULL,
                                '$tipo_receta',
                                $pm_id,
                                $cantidad,
                                $precio_u,
                                1
                                )";
        echo $sql_fd."<br>";
        mysql_query($sql_fd);
    
         //guardo en la base de datos
     } echo "<br><br>";    
}
?>