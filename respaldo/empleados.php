<?php
require("aut_verifica.inc.php");
$nivel_acceso=2;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = '';

include_once('html_sup.php');
include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    nombre=document.getElementById('nombre').value;
    apellido=document.getElementById('apellido').value;
    dni=document.getElementById('dni').value;
    
    descripcion = apellido+', '+nombre+' - '+dni;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>
<?php

new Scaffold("noeditable",
        "empleados",
        30,
        array('descripcion','dni','tipo_empleado_id'),
        array(),                                        // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array(),                                     // Campos a ocultar del maestro en el detalle
        array('D','E','B','N')
        
        );
include_once('html_inf.php');
?>