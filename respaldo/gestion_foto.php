<?php
include("lib/connect_mysql.php");

$id          = $_POST['id'];//20120214052450.jpg
$empleado_id = $_POST['empleado_id'];

//$des         = $_POST['des'];

$sub = (substr($id,-18));
$id_foto = str_replace(".jpg", "", $sub);//20120214052450
$consul = "update fotos set id_foto=id_foto, nombre='$nombre', des='$des' where id_foto='$id_foto'";
$modifica = mysql_query($consul,$c);
print("<script>window.location.replace('index.php');</script>");  

?>