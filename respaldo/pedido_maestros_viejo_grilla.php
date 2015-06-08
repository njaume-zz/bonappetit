<?php
/*require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}
*/
include_once 'lib/funciones.php';

$nuevo   = LimpiarXSS($_GET['nuevo']);
$mesa_id = LimpiarXSS($_GET['mesa_id']);

$tip = 'PEDIDO PARA LA MESA '.$mesa_id;

include_once('html_sup.php');
include("scaffold.php");

?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->


<h2>Formulario de carga de datos: 
    <strong>
        PEDIDO MAESTRO
    </strong>
</h2>
<br>
<form action="guardar_pedido_maestros.php" method="POST" name="crear" id="crear" enctype="multipart/form-data" onsubmit="return creardescripcion()">
    <input type="hidden" name="variablecontrolposnavegacion" value="create">
<table cellpadding="2" cellspacing="0" border="0" width="700">



<tr>
        <script type="text/javascript">
        $(function()
        {
                // Updated script
                var categories = $.map($("#sempleado_id option"),function(e, i)
                {
                return e;
                });

                $("#myempleado_id").autocomplete(categories,
                {
                matchContains : true,
                formatItem : function(item) { return item.text; }
                });
                // Added to fill hidden field with option value
                $("#myempleado_id").result(function(event, item, formatted)
                {
                $("#empleado_id").val(item.value);
                }
        )});
        </script>
<td align="right" >
    <strong>Empleado</strong>
</td>
<td>

    <input type="text" id="empleado_id" name="empleado_id" size="1" readonly="true">
    <input type="text" id="myempleado_id" class=":required" size="31" title="Cantidad de registros: 7">
    <select id="sempleado_id" style="display: none">
        <?php
         $query2 = mysql_query("SELECT * FROM empleados WHERE tipo_empleado_id='1' ORDER BY descripcion");
         while($result_query2 = mysql_fetch_array($query2))
         echo "<option title=\"\" value='$result_query2[0]'>$result_query2[1]</option>";

        ?>
    </select>
    </td>
    <tr>
    <script type="text/javascript">
    $(function()
    {
            // Updated script
            var categories = $.map($("#scliente_id option"),function(e, i)
            {
            return e;
            });

            $("#mycliente_id").autocomplete(categories,
            {
            matchContains : true,
            formatItem : function(item) { return item.text; }
            });
            // Added to fill hidden field with option value
            $("#mycliente_id").result(function(event, item, formatted)
            {
            $("#cliente_id").val(item.value);
            }
    )});
    </script>
    <td align="right" >
        <strong>
            Cliente
        </strong>
    </td>
    <td>
    <input type="text" id="cliente_id" name="cliente_id" size="1" readonly="true">
    <input type="text" id="mycliente_id" class=":required" size="31" title="Cantidad de registros: 3">
    <select id="scliente_id" style="display: none">
        <?php
         $query2 = mysql_query("SELECT * FROM clientes ORDER BY descripcion");
         while($result_query2 = mysql_fetch_array($query2))
         echo "<option title=\"\" value='$result_query2[0]'>$result_query2[1]</option>";

        ?>
    </td>
    <tr>
    
    <script type="text/javascript">
    $(function()
    {
            // Updated script
            var categories = $.map($("#smesa_id option"),function(e, i)
            {
            return e;
            });

            $("#mymesa_id").autocomplete(categories,
            {
            matchContains : true,
            formatItem : function(item) { return item.text; }
            });
            // Added to fill hidden field with option value
            $("#mymesa_id").result(function(event, item, formatted)
            {
            $("#mesa_id").val(item.value);
            }
    )});
    </script>
    <td align="right" >
        <strong>
            Mesa
        </strong>
    </td>
    <td>
        <input type="hidden" id="mesa_id" name="mesa_id" value="<?php echo $mesa_id;?>">
        <font size="24px;"><?php echo $mesa_id;?></font>
    </td>
    <tr>
    <input type="hidden" name="fecha_y_hora" id="fecha_y_hora" value="<?php
           $dia  = date('Y-m-d H:i:s');
           echo $dia;
           ?>"/>
    <input type="hidden" name="descripcion" value="<?php echo $dia.' - '.$mesa_id;?>" />
    <input type="hidden" name="total" id="total" value="0" size="35" />
    <input type="hidden" name="finalizado" id="finalizado" value="0" size="35" />
    <input type="hidden" name="usuario_id" id="usuario_id" value="1" />
    <tr>
        <td>&nbsp;</td>
        <td>
            <input type="submit" value="Guardar pedido" />
        </td>
    </tr>
    </table>
</form>


<a href="/equiseto/pedido_maestros.php">Volver al listado</a></td></tr></table>



<?php

//new Scaffold("editable","pedido_maestros",30);
include_once('html_inf.php');
?>