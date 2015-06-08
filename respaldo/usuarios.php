<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}
$tip="En el campo Descripcion coloque el nombre y apellido del usuario";

include_once('html_sup.php');

include("scaffold.php");
new Scaffold("editable","usuarios",30,array('descripcion','usuario','nivel'));
include_once('html_inf.php');
?>
