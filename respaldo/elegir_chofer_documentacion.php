<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

include_once('html_sup.php');
include("scaffold.php");

?>
<div align="center" class="titulo">
    <br>
    Elija un chofer y presione "Detalle" para ver la documentaci&oacute;n asociada.
    <br>
    <br>
</div>
    
    
<form name="searchbar" id="searchbar" action="documentacion_chofers.php" method="post" style="display:inline">
    
        <input type="hidden" name="variablecontrolposnavegacion" value="search">
        <input type="hidden" name="field" value="chofer_id">
        <input type="hidden" name="compare" value="=">
  

    
    
  <table width="500" cellspacing="0" border="0" cellpadding="0" align="center">
  <tbody>
    <tr>
	<td align="right">
	Chofer: 
	</td>
	<td align="left">
                <select name="searchterm"> 
                  <option selected value=''>Elija un chofer</option>  <!--pone valor por defecto-->
                  <?
			$sql = "SELECT id, nombre, apellido, legajo
				FROM chofers
				ORDER BY apellido";
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
