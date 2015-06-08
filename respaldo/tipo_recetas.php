<?php
require("aut_verifica.inc.php");
$nivel_acceso=4;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = '';

include_once('html_sup.php');
include("scaffold.php");


new Scaffold(
        "editable",
        "tipo_recetas",
        30,
        array(),
        array(),   
        array(),   
        array(),   
        array('D','E','B','N')          
        );
include_once('html_inf.php');
?>