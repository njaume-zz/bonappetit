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
  
    
<script type="text/javascript">
    
function creardescripcion() {

   // Parse the entries
   start = '<?php echo $fecha_actual;?>';
   
   end = document.getElementById('fecha_alta_empleado').value;
   dia = end.substr(0,2);
   mes = end.substr(3,2);
   anho = end.substr(6,4);
   end = anho+"-"+mes+"-"+dia;

   var startDate = Date.parse(start);
   var endDate = Date.parse(end);
 
   // Check the date range, 86400000 is the number of milliseconds in one day
   var difference = (startDate - endDate) / (86400000 * 7);
   if (difference < 0) {
       alert("La fecha de alta no puede ser superior a la fecha actual");
       return false;
   }else{
       
    return true;
    dni=document.getElementById('dni').value;
    nombre=document.getElementById('nombre').value;
    apellido=document.getElementById('apellido').value;

    descripcion = apellido+', '+nombre+' '+dni;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
    }
}
</script> 

<?php


new Scaffold("noeditable","chofers",30,array('descripcion','legajo','celular','empresa_id'),'',array('salud_id','evaluacion_final_id'));
include_once('html_inf.php');
?>