<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = '';

include_once('html_sup.php');
include("scaffold.php");
$fecha_actual = date('Y-m-d');

?>
<script>
// checkDateEntries - Checks to ensure that the values entered are dates and 
//       are of a valid range.

function creardescripcion() {
   // Parse the entries
   start = '<?php echo $fecha_actual;?>';
   
   end = document.getElementById('fecha_baja_empleado').value;
   dia = end.substr(0,2);
   mes = end.substr(3,2);
   anho = end.substr(6,4);
   end = anho+"-"+mes+"-"+dia;

   var startDate = Date.parse(start);
   var endDate = Date.parse(end);
 
   // Check the date range, 86400000 is the number of milliseconds in one day
   var difference = (startDate - endDate) / (86400000 * 7);
   if (difference < 0) {
       alert("La fecha de baja no puede ser superior a la fecha actual");
       return false;
   }
   return true;
}
</script>
 
<div align="center" class="titulo">
    <strong>Evaluaci&oacute;n final</strong>: corresponde al detalle de las tareas realizadas por el empleado y su desempe&ntilde;o en la empresa luego de finalizar sus labores como empleado de la misma.
</div>
<br>


<?php
$submit = $_POST['fecha_baja_empleado']; //Toma el valor de la fecha que viene por formulario 
//(solo para saber si se ha llenado el formulario correspondiente).

//leo el motivo de desvinculación y actualizo el estado (activo_id Si=1 No=2) 
//en la tabla choferes 



//###########  Si se llenó el formulario y se puso "guardar":

if (!empty($submit)) {  
    
    $chofer_id = $_POST['chofer_id'];
    echo '<h2>El chofer con id: '.$chofer_id.' ya no esta activo</h2><br>';
    $sql = "UPDATE chofers SET activo_id=2 WHERE id = $chofer_id";
    mysql_query($sql);
}




new Scaffold("noeditable","evaluacion_finals",30);

include_once('html_inf.php');
?>