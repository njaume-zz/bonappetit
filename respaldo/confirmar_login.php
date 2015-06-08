<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}
 //librerias a utilizar
 include_once("lib/connect_mysql.php");
 include_once("lib/funciones.php");
 //.....................

$usuario_nivel=$_SESSION['usuario_nivel'];
if ($usuario_nivel<=2) {header ("Location: empresas.php");}
else header ("Location: empresas.php");
?>