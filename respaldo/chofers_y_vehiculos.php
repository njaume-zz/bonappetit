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
    Asocie el chofer correspondiente a un veh&iacute;culo.
</div>
<br>
<?php


new Scaffold("noeditable","chofer_y_vehiculos",30);
include_once('html_inf.php');
?>