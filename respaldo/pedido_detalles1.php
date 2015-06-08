<?php
//require("aut_verifica.inc.php");
$nivel_acceso=5;

include_once 'lib/funciones.php';
?>

<?php

include("scaffold.php");
$n_maestro_id = $_POST['maestro_id'];

?>
<script type="text/javascript">

function foco(){
 document.getElementById('myreceta_maestro_id').focus();
}



function creardescripcion() {

    nro_mesa = document.getElementById('nro_mesa').value;
    cant_comensales=document.getElementById('cant_comensales').value;

    
    descripcion = 'Mesa '+nro_mesa+' para '+cant_comensales;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}



</script>

<script type="text/javascript">
function my_func () {
  location.reload(true);
}
</script>

<?php


new Scaffold(
        "noeditable",                                                    // si se puede editar o no la descripcion
        "pedido_detalles",                                               // Tabla a mostrar
        200,                                                              // Cantidad de registros a mostrar por página   
        array('receta_maestro_id','cantidad'),                           // Campos a mostrar en el listado
        array('precio_unitario'),                                        // Campos a ocultar en el formulario
        array(),                                                         // Campos relacionados
        array('descripcion','empleado_id','cliente_id','total','finalizado','empresa_id'),                                     // Campos a ocultar del maestro en el detalle
        array('','E','B','N')
);
















?>
<br>


<?php
include_once('html_inf.php');
?>