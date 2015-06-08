<?php
/*require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}
*/
$tip = '';

include_once('html_sup.php');
$id_empleado = LimpiarXSS($_POST['id_empleado']);
$descripcion = DevuelveValor($id_empleado, 'descripcion', 'empleados', 'id');
$mes_actual  = LimpiarXSS($_POST['mes']);
$anio_actual = LimpiarXSS($_POST['anio']);

?>
<h2>Reporte por cantidad de horas trabajadas</h2>

<h3>Empleado: <?php echo $descripcion;?></h3><br><br>


<?php
//Recorro los registros correspondientes a ese mes, año y empleado y los listo.


echo "<table border=1 >"; 
echo "<tr>"; 
echo "<td><b>Fecha</b></td>"; 
echo "<td><b>Horas Trabajadas</b></td>"; 
echo "<td><b>Hora Entrada</b></td>"; 
echo "<td><b>Hora Salida</b></td>"; 
echo "<td><b>Url Foto Entrada</b></td>"; 
echo "<td><b>Url Foto Salida</b></td>"; 
echo "</tr>"; 
$sql_1 = "SELECT * 
            FROM `registro_asistencias` 
            WHERE empleado_id = $id_empleado 
            AND MONTH(fecha) = $mes_actual 
            AND YEAR(fecha) = $anio_actual
        ";
//echo $sql_1;
$horas_trabajadas = '00:00';

$result = mysql_query($sql_1) or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['fecha']) . "</td>";    
echo "<td valign='top'>" . nl2br( $row['horas_trabajadas']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['hora_entrada']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['hora_salida']) . "</td>";  
echo "<td valign='top'><img width=\"100\" src=\"" . $row['url_foto_entrada'] . "\"></td>";  
echo "<td valign='top'><img width=\"100\" src=\"" . $row['url_foto_salida'] . "\"></td>";   
echo "</tr>";

$hora_ingreso = $row['horas_trabajadas'];
$jornal = $horas_trabajadas;             
$hora_ingreso=split(":",$hora_ingreso);         
$jornal=split(":",$jornal);         
$horas=(int)$hora_ingreso[0]+(int)$jornal[0];         
$minutos=(int)$hora_ingreso[1]+(int)$jornal[1];         
$horas+=(int)($minutos/60);         
$minutos=$minutos%60;         
if($minutos<10)$minutos="0".$minutos ;         
$horas_trabajadas = $horas.":".$minutos;        

} 
echo "</table>"; 
echo "<h2>Horas trabajadas por el empleado en el mes ".$mes_actual.": ".$horas_trabajadas." horas</h2>";
include_once('html_inf.php');
?>