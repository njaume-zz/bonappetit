<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = 'ATENCI&Oacute;N: Vencimiento de carnet de Fulano de Tal dentro de 8 d&iacute;as';

include_once('html_sup.php');
include("scaffold.php");


new Scaffold("editable","parametros_vehiculos",30);
include_once('html_inf.php');
?>