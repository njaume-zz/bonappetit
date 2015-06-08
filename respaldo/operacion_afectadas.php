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
?>

<div align="center" class="titulo">
    <strong>Operaci&oacute;n afectada</strong>: se refiere a la empresa para la que presta servicio el integrante de la UTE particular.
</div>
<br>
<?php


new Scaffold("noeditable","operacion_afectadas",30);
include_once('html_inf.php');
?>