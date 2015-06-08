<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}


$mes_local = date('m');
$anio_local = date('Y');

include_once('html_sup.php');
include("scaffold.php");
?>

<script type="text/javascript">
function creardescripcion() {

    var mes_local = "<?php echo $mes_local;?>";
    var anio_local = "<?php echo $anio_local;?>";

    //razon_social=document.getElementById('razon_social').value;
    //cuit=document.getElementById('cuit').value;

    //descripcion = razon_social+', '+cuit;

    document.getElementById('mes').value=mes_local;
    document.getElementById('anio').value=anio_local;
    document.forms.crear.submit();
}
</script>

<?php
new Scaffold("editable","registro_de_gastos_por_total_detalles",30);


//Leo los datos almacenados en los detalles y calculo los totales.
$maestro_id     = $_POST['maestro_id'];


//Tomo los datos de cantidad, monto e iva de cada registro y calculo los totales correspondientes.
$sql = "SELECT * 
            FROM  `registro_de_gastos_por_total_detalles` 
            WHERE  `registro_de_gastos_por_total_maestro_id` =$maestro_id";
$consulta = mysql_query($sql,$link);

//Tomo el importe total según el maestro_id
$importe_total_maestro = DevuelveValor($maestro_id, 'importe', 'registro_de_gastos_por_total_maestros', 'id');


while($fila = mysql_fetch_array($consulta, MYSQL_BOTH)){
    $tipo_de_imputacion = $fila['tipo_de_imputacion_id'];
    $importe            = $fila['importe'];
    
    if ($tipo_de_imputacion == 1) {
        $importe_total = $importe_total + $importe;
    }elseif ($tipo_de_imputacion == 2) {
        $fraccion = $importe_total_maestro * $importe / 100;
        $importe_total = $importe_total + $fraccion;
    }
    
    
    
    
}

echo "<br><br><strong>Total registrado en maestro: </strong>".round($importe_total_maestro,2);
echo "<br><br><strong>Total registrado en detalle: </strong>".round($importe_total,2);

if (round($importe_total,2) != round($importe_total_maestro,2)) {
    echo "<br><br>El total registrado en maestro no coincide con lo detallado. Verifique haber ingresado todas las fracciones.";
}else{
    echo "<br><br>Totales coincidentes.";
}


?>




<?php
include_once('html_inf.php');
?>