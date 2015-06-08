<?php
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';
$maestro_id = $_POST['n_maestro_id'];


$con_fin = "UPDATE pedido_maestros SET finalizado='1' WHERE id=$maestro_id";
$run_cf  = mysql_query($con_fin);
Header("Location: pedido_maestros.php")

?>