<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}


$mes_local = date('m');
$anio_local = date('Y');

include_once('html_sup.php');
include("scaffold.php");
?>

<script type="text/javascript">
function creardescripcion() {

    //var mes_local = "<?php echo $mes_local;?>";
    //var anio_local = "<?php echo $anio_local;?>";

    //razon_social=document.getElementById('razon_social').value;
    //cuit=document.getElementById('cuit').value;

    //descripcion = razon_social+', '+cuit;

    //document.getElementById('mes').value=mes_local;
    //document.getElementById('anio').value=anio_local;
    //document.forms.crear.submit();
}
</script>

<?php
new Scaffold("editable","registro_de_gastos_por_comprobante_maestros",30,array('descripcion','fecha','vehiculo_id','gasto_id','importe'));
include_once('html_inf.php');
?>