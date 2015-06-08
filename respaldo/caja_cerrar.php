<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

include_once 'lib/funciones.php';
$nocoincide = 0;
$nuevo   = LimpiarXSS($_GET['nuevo']);
//$mesa_id = LimpiarXSS($_GET['mesa_id']);

$tip = '';

if ($_POST['submit']=='Aceptar') {
    
    $fyh = date('Y-m-d h:i:s');
    $fyh_es = date('d-m-Y');
    $saldo_cierre = LimpiarXSS($_POST['saldo_cierre']);
    
    $caja_id        = DevuelveValor('1', 'id', 'caja_apertura_cierres', 'estado');    
    $saldo_apertura = DevuelveValor($caja_id, 'saldo_apertura', 'caja_apertura_cierres', 'id');    
    echo 'nestor '.$saldo_apertura;
    //Controlo el total de pedidos.
    //Tomo los datos de cantidad, monto e iva de cada registro y calculo los totales correspondientes.
    $sql = "SELECT SUM(total) AS sumatotal
                FROM  `pedido_maestros` WHERE finalizado=1";
    $consulta = mysql_query($sql);

    while($fila = mysql_fetch_array($consulta, MYSQL_BOTH)){
        $total = $fila['sumatotal'];
    }
    
    $total = $total + $saldo_apertura;
    
    
    if ($total != $saldo_cierre){
        $nocoincide = 1;
    }else{
    
    $sql_caja = "UPDATE `caja_apertura_cierres` SET 
        `hora_cierre` = '$fyh',
        `saldo_cierre`= '$total',
        `estado`= '0'
        WHERE id = '$caja_id'
        ";
    //echo $sql_caja;
   $run_sql = mysql_query($sql_caja);
   
   $sql_estado_caja = "UPDATE `caja_estados` SET 
                        `descripcion`='INACTIVA'
                        WHERE id = 1
                        ";
   
   $run_ec = mysql_query($sql_estado_caja);
    }

}


include_once('html_sup.php');
include("scaffold.php");




if (($_POST['submit']!='Aceptar') OR ($nocoincide == 1)){
 if ($nocoincide == 1){   
    echo "<font color='#ff0000'>Valor ingresado manualmente: <strong>".$saldo_cierre;
    echo "</strong><br>Total pedidos: <strong>".$total; 
    echo '</strong></font><br><br><h2>La caja no cierra. Por favor revisar el valor ingresado: $'.$saldo_cierre.'</h2>';
 }  
?>
<hr size="3"><br><br>
<h2>Cerrar caja</h2><br><br>
<form action="caja_cerrar.php" method="POST" name="caja_cerrar">
    Monto en caja: <input type="text" name="saldo_cierre" size="20" class=":required">
    <br><br>
    <input type="submit" name="submit" value="Aceptar">
    <br><br>
</form>
<hr size="3">
<br><br>
<?php
}

new Scaffold(
        "noeditable",
        "pedido_maestros",
        30,
        array('empleado_id','mesa_nro','cantidad_de_comensales','total'),
        array('total','finalizado'),
        array(),
        array(),
        array('D','E','B','N')
        );

include_once('html_inf.php');
?> 