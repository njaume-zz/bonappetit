<?php
require("aut_verifica.inc.php");
$nivel_acceso=1;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

include_once 'lib/funciones.php';


$tip = '
';

include_once('html_sup.php');
include("scaffold.php");

?>
<script type="text/javascript">
function creardescripcion() {

    document.getElementById('finalizado').value = 0;
    document.forms.crear.submit();
}
</script>




<?php

new Scaffold(
        "noeditable",
        "registro_ingresos",
        30,
        array('descripcion','empleado_id','fecha_y_hora'),
        array(),
        array(),
        array(),
        array('','','','')
        );

include_once('html_inf.php');
?> 