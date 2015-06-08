<?php
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';
$id          = $_POST['id_foto'];//20120214052450.jpg
$empleado_id = $_POST['empleado_id'];
$nombre_em   = DevuelveValor($empleado_id, 'descripcion', 'empleados', 'id');
$timestamp   = date('Y-m-d H:i:s');
$fecha       = date('Y-m-d');

$filename = (substr($id,-18));
$id_foto = str_replace(".jpg", "", $filename);//20120214052450

$consul = "
           UPDATE fotos 
           SET 
           descripcion = '$nombre_em',
           empleado_id = $empleado_id,
           fecha_y_hora ='$timestamp' 
           WHERE id = '$id_foto'";

$modifica = mysql_query($consul);

$descripcion = $id_foto.' - '.$nombre_em;
$consulta       = "INSERT INTO registro_ingresos VALUES (
                    '$id_foto',
                    '$descripcion',
                    '$empleado_id',
                    '$timestamp',
                    '1'
                     )";

$inserta_ingreso = mysql_query($consulta);

$url_foto_entrada = 'fotos/'.$filename;
$consulta_a      = "INSERT INTO registro_asistencias VALUES (
                    '$id_foto',
                    '$descripcion',
                    '$fecha',    
                    '$empleado_id',
                    '0',
                    '$timestamp',
                    '2013-05-15',
                    '$url_foto_entrada',
                    '',
                    '1'
                     )";

$inserta_assitencia = mysql_query($consulta_a);

print("<script>window.location.replace('registro_ingreso.php');</script>");  

?>