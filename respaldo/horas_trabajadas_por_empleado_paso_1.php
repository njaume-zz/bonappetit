<?php
require("aut_verifica.inc.php");
$nivel_acceso=1;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = '';

include_once('html_sup.php');
$anio = date('Y');
?>
<h2>Reporte por cantidad de horas trabajadas</h2>
<h3>Elija un empleado</h3><br><br>
<form name="horastrabajadas" action="horas_trabajadas_por_empleado_paso_2.php"  method="post">
    
        <select name="id_empleado" id="id_empleado">
        <option selected>Seleccione un empleado:</option>
        <?php
        $sql = "SELECT id,descripcion
        	FROM empleados
        	ORDER BY descripcion";
        $query2 = mysql_query($sql);
        while($result_query2 = mysql_fetch_array($query2))
        echo "<option value='$result_query2[0]'>$result_query2[1]</option\n>";

        ?>
    </select>
<br><br>
Mes:
<input type="text" name="mes">
<br><br>
A&ntilde;o:
<input type="text" name="anio" value="<?php echo $anio?>">
<br><br>
<input type="submit" name="submit" value="Siguiente ->">
</form>
<?php
include_once('html_inf.php');
?>