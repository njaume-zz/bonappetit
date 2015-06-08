<?php
require("aut_verifica.inc.php");
$nivel_acceso=5;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: userpass.php");
exit;
}

$tip = '';

include_once('html_sup.php');
include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    razon_social=document.getElementById('razon_social').value;
    cuit=document.getElementById('cuit').value;

    descripcion = razon_social+', '+cuit;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>

<br><br><br>
<hr size="4">
<br><br><br>
<h1>USTED NO TIENE PERMISO PARA INGRESAR A ESTA SECCI&Oacute;N</h1>
<br><br><br>
<hr size="4">
<br><br><br>
<?php

/*
new Scaffold("noeditable",
        "empresas",
        30,
        array('descripcion'));
 * 
 */
include_once('html_inf.php');
?>