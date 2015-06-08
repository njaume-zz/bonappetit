<?php
require("aut_verifica.inc.php");
$nivel_acceso=5;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

include_once 'lib/funciones.php';
$tip = 'ROJO: Falta imprimir en cocina <br> 
        AMARILLO: Impreso en cocina, falta entregar <br> 
        ANARANJADO: Falta cobrar <br>
        VERDE: Finalizado';

?>

<?php
include_once('html_sup.php');
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



//Tomo los datos de cantidad, monto e iva de cada registro y calculo los totales correspondientes.
$sql = "SELECT * 
            FROM  `pedido_detalles` 
            WHERE  `pedido_maestro_id` = $n_maestro_id";
$consulta = mysql_query($sql,$link);



//Tomo el importe total según el maestro_id
//$importe_total_maestro = DevuelveValor($n_maestro_id, 'total', 'pedido_maestros', 'id');

$importe_total = 0;

while($fila = mysql_fetch_array($consulta, MYSQL_BOTH)){
    $id                 = $fila['id'];
    $cantidad           = $fila['cantidad'];
    $importe            = $fila['precio_unitario'];
    $receta_maestro_id  = $fila['receta_maestro_id'];
    if ($importe == 0) {$importe = DevuelveValor($receta_maestro_id, 'precio', 'receta_maestros', 'id');}
    $cons = "UPDATE pedido_detalles SET `precio_unitario`='$importe' WHERE `id` = $id";
    $r_consulta = mysql_query($cons);    
    $precio = $cantidad*$importe;
    $importe_total = $importe_total + $precio;
    //echo $consulta.'<br>';
}


//Actualizo el total de pedido_maestro
$sql_pm = "UPDATE pedido_maestros SET total = $importe_total WHERE id = $n_maestro_id";
$consulta_pm = mysql_query($sql_pm);


//echo "<br><h1><strong>Total registrado en maestro: </strong>$ ".round($importe_total_maestro,2)."<h1>";
echo "<br><br><h1><strong>Total registrado en detalle: $".round($importe_total,2)."</strong><h1><br>";
/*
if (round($importe_total,2) != round($importe_total_maestro,2)) {
    echo "<br><br>El total registrado en maestro no coincide con lo detallado. Verifique haber ingresado todas las fracciones.";
}else{
    echo "<br><br>Totales coincidentes.";
}


*/
















?>
<br>

<table align="center" border="0">
    <tr>
        <td>
            <form action="imprimir_en_cocina.php" method="post" name="imprime_cocina" id="imprime_cocina" target="_blank">
                <input type="hidden" id="n_maestro_id" name="n_maestro_id" value="<?php echo $n_maestro_id;?>">
                <input type="submit" name="submit" class="boton_cocina" value="">
            </form>
        </td>
        <td>
            <form action="imprimir_en_mostrador.php" method="post" name="imprime" target="_blank">
                <input type="hidden" id="n_maestro_id" name="n_maestro_id" value="<?php echo $n_maestro_id;?>">
                <input type="submit" name="submit" class="boton_admin" value="">
            </form> 
        </td>
        <td>
            <form action="registrar_pago.php" method="post" name="pagar" target="_blank">
                <input type="hidden" id="n_maestro_id" name="n_maestro_id" value="<?php echo $n_maestro_id;?>">
                <input type="submit" name="submit" class="boton_pagar" value="">
            </form> 
        </td>        
    </tr>
</table>


<?php
include_once('html_inf.php');
?>