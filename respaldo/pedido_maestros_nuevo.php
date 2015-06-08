<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
echo "Nivel de usuario ".$_SESSION['usuario_nivel'];
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

include_once 'lib/funciones.php';

$nuevo   = LimpiarXSS($_GET['nuevo']);
$seguir  = LimpiarXSS($_POST['seguir_detalle']);


//$mesa_id = LimpiarXSS($_GET['mesa_id']);

$tip = '';

include_once('html_sup.php');
include("scaffold.php");

?>
<script type="text/javascript">
    
function foco(){
 document.getElementById('myempleado_id').focus();
}

    
    
    
function creardescripcion() {

    document.getElementById('finalizado').value = 0;
    document.forms.crear.submit();
    
    
    
}
</script>




<?php

$scaffold = new Scaffold(
        "noeditable",
        "pedido_maestros",
        0,        
        array('empleado_id','mesa_nro','cantidad_de_comensales','total'),
        array('total','finalizado','empresa'),
        array(),
        array(),
        array('D','E','B','N')
        );

$scaffold ->new_row();

$submit = LimpiarXSS($_POST['fecha_y_hora']);

if (!empty($submit)) {

        $rs = mysql_query("SELECT @@identity AS id");
        if ($row = mysql_fetch_row($rs)) {
            $maestro_id = trim($row[0]);
        }
        
        echo '<form name="pedido_detalle" id="searchbar" action="pedido_detalles.php" method="post" style="display:inline">
            <input type="hidden" name="variablecontrolposnavegacion" value="search">
            <input type="hidden" name="field" value="pedido_maestro_id">
            <input type="hidden" name="compare" value="=">
            <input type="hidden" name="searchterm" value="'.$maestro_id.'">
            <input type="hidden" id="maestro_id" name="maestro_id" value="'.$maestro_id.'">
            <input type="submit" name="Search" value="Detalle"/>
            </form>
            <SCRIPT LANGUAGE="javascript">
            setTimeout("pedido_detalle.submit()",0);
            </SCRIPT>
'
        ;

}

include_once('html_inf.php');
?> 