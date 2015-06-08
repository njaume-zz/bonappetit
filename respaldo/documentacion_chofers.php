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

$id      = $_POST['id'];

$chofer_id      = DevuelveValor($id, 'chofer_id', 'documentacion_chofers', 'id');
$chofer_des     = DevuelveValor($chofer_id, 'descripcion', 'chofers', 'id');

$parametro_id   = DevuelveValor($id, 'parametros_chofer_id', 'documentacion_chofers', 'id');
$parametro_des  = DevuelveValor($parametro_id, 'descripcion', 'parametros_chofers', 'id');


?>

<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    descripcion = "<?php echo $chofer_des;?>"+' - '+"<?php echo $parametro_des;?>";

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>    
    
    
<?php

new Scaffold("noeditable","documentacion_chofers",30,array('chofer_id','parametros_chofer_id','ultima_renovacion','proximo_vencimiento_normal','proximo_vencimiento_excepcion','fecha_turno_reservado','dias_a_vencer'),array('calculado'));
//tomo el id del chofer, el id del parámetro y la fecha de la última renovación para calcular el próximo vencimiento normal y los días hasta el vencimiento (que son los días del parámetro). Estos últimos deberían actualizarse con algún script automático todos los días (quizás en el cron). Puedo usar algún administrador de cron como Schedule Task de Gnome para llamar específicamente el script /usr/bin/php -f /home/sistemas/sistemas/gestruck/script_cron.php

$calculado = $_POST['calculado'];
if(empty($calculado)){

  //  Tomo las variables del formulario
  $chofer_id    = $_POST['chofer_id'];
  
  $parametro_id = $_POST['parametros_chofer_id'];

  if (empty($parametro_id)) $parametro_id = $_POST['sparametros_chofer_id'];
  $ultima_renovacion = $_POST['ultima_renovacion'];
  
  //tomo los días de vencimiento del parámetro
  $plazo_vigencia = DevuelveValor($parametro_id, 'plazo_vigencia', 'parametros_chofers', 'id');
  

  
    $ultima_renovacion = date_transform_usa($ultima_renovacion);
  
    $fecha_actual = date('Y-m-d');
    
    $fecha_nueva = suma_fechas($ultima_renovacion, $plazo_vigencia);
    
    //Calculo los días que faltan para el vencimiento:
    $fecha1 = new DateTime($fecha_nueva);
    $fecha2 = new DateTime($fecha_actual);
    $intervalo = $fecha2->diff($fecha1);
    $dias_a_vencer = $intervalo->format('%R%a');
    
    
    
    //Actualizo los datos en la base de datos.
    
    $sql = "UPDATE documentacion_chofers SET proximo_vencimiento_normal = '$fecha_nueva',dias_a_vencer=$dias_a_vencer,calculado='SI' WHERE chofer_id = $chofer_id AND parametros_chofer_id = $parametro_id";
    
    mysql_query($sql);
    
}
include_once('html_inf.php');
?>