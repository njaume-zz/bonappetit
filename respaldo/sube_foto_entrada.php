<?php
include_once 'lib/connect_mysql.php';
include_once 'lib/funciones.php';

$id_foto        = date('YmdHis');//extraemos la fecha del servidor
$timestamp      = date('Y-m-d H:i:s');
$consulta       = "INSERT INTO fotos VALUES (
                    '$id_foto',
                    '$id_foto',
                    '1',
                    '$timestamp',
                    '1'
                     )";

$inserta_foto = mysql_query($consulta);
$filename = "fotos/".$id_foto.'.jpg';//nombre del archivo
$result = file_put_contents( $filename, file_get_contents('php://input') );//renombramos la fotografia y la subimos
if (!$result) {
	print "No se pudo subir al servidor\n";
	exit();
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;//generamos la respuesta como la ruta completa
print "$url\n";//20120214060943.jpg

?>
