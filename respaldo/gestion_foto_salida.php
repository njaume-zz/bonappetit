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

$id_ingreso = DevuelveValor($empleado_id, 'id', 'registro_ingresos', 'empleado_id');        

$consulta       = "DELETE FROM `registro_ingresos` 
                   WHERE id = $id_ingreso
                    ";

$borra_ingreso = mysql_query($consulta);

// Calcula horas trabajadas
function Tiempo($start,$end, $out_in_array=false){
        $intervalo = date_diff(date_create($start), date_create($end));
        $out = $intervalo->format("Y:%Y,Me:%M,D:%d,H:%H,m:%i,S:%s");
        if(!$out_in_array)
            return $out;
        $a_out = array();
        array_walk(explode(',',$out),
        function($val,$key) use(&$a_out){
            $v=explode(':',$val);
            $a_out[$v[0]] = $v[1];
        });
        return $a_out;
}

$hora_entrada = DevuelveValor($id_ingreso, 'hora_entrada', 'registro_asistencias', 'id');
$horas = Tiempo($timestamp,$hora_entrada,true);
$horas_trabajadas = $horas[H].':'.$horas[m];

$url_foto_salida = 'fotos/'.$filename;
$consulta_a      = "UPDATE registro_asistencias SET 
                    horas_trabajadas = '$horas_trabajadas',
                    hora_salida = '$timestamp',
                    url_foto_salida = '$url_foto_salida'
                    WHERE id = $id_ingreso
                    ";

$inserta_assitencia = mysql_query($consulta_a);

print("<script>window.location.replace('registro_egreso.php');</script>");  

?>