<?php
require("aut_verifica.inc.php");
$nivel_acceso=5;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

include_once('html_sup.php');
include("scaffold.php");

?>
<div align="center" class="titulo">
    <br>
    Elija un rubro y presione "Detalle" para ver la documentaci&oacute;n asociada.
    <br>
    <br>
</div>
    
    
<form name="searchbar" id="searchbar" action="proveedors.php" method="post" style="display:inline">
    
        <input type="hidden" name="variablecontrolposnavegacion" value="search">
        <input type="hidden" name="field" value="rubro_proveedor_id">
        <input type="hidden" name="compare" value="=">
  

    
    
  <table width="500" cellspacing="0" border="0" cellpadding="0" align="center">
  <tbody>
    <tr>
	<td align="right">
	Rubro: 
	</td>
	<td align="left">
                <select name="searchterm"> 
                  <option selected value=''>Elija un rubro</option>  <!--pone valor por defecto-->
                  <?
			$sql = "SELECT id, descripcion
				FROM rubro_proveedors
				ORDER BY descripcion";
			$query = mysql_query($sql);
			while($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
			echo "<option value='$result_query[0]'>$result_query[3] - $result_query[2], $result_query[1]</option\n>";//muestra resultado de la consulta
		  ?>
                </select>

	</td>
    </tr>
    <tr>
      <td align="right" colspan="2"><input type="submit" name="Search" value="Detalle"></td>
    </tr>
  </tbody>
</table>

</form>

<br><br>

<?php



//new Scaffold("noeditable","comisions",30,array('descripcion','empleado_id','pedido_maestro_id','fecha','monto'));


include_once('html_inf.php');
?>