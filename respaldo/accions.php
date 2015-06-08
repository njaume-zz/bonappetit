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

<?php
new Scaffold("editable","que_de_la_accions",30);
include_once('html_inf.php');
?>