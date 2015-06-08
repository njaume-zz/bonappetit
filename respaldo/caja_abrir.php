<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}
include_once('html_sup.php');

include_once 'lib/funciones.php';

$nuevo   = LimpiarXSS($_GET['nuevo']);
//$mesa_id = LimpiarXSS($_GET['mesa_id']);

$tip = 'RECUERDE LIMPIAR TODOS LOS PEDIDOS ANTES DE ABRIR LA CAJA';

if ($_POST['submit']=='Aceptar') {
    $fyh = date('Y-m-d h:i:s');
    $fyh_es = date('d-m-Y');
    $saldo_apertura = LimpiarXSS($_POST['saldo_apertura']);
    
    
    $empresa_id= DevuelveValor($usuario_id, 'empresa_id' , 'usuarios' , 'id');
              
    $sql_caja = "INSERT INTO `caja_apertura_cierres`( 
                `id`, 
                `descripcion`, 
                `hora_apertura`, 
                `hora_cierre`, 
                `saldo_apertura`, 
                `saldo_cierre`, 
                `cantidad_horas`, 
                `total_ingreso`, 
                `total_egreso`, 
                `estado`, 
                `empresa_id`, 
                `usuario_id`
                ) VALUES (
                NULL,
                'CAJA DEL DIA $fyh_es',
                '$fyh',
                '$fyh',
                $saldo_apertura,
                0,
                0,
                0,
                0,
                1,
                $empresa_id,
                $usuario_id )";
   
   $run_sql = mysql_query($sql_caja);
  
   $sql_estado_caja = "UPDATE `caja_estados` SET 
                        `descripcion`='ACTIVA'
                        WHERE id = 1
                        ";
   
   $run_ec = mysql_query($sql_estado_caja);
}


include("scaffold.php");

if ($_POST['submit']!='Aceptar'){
?>
<hr size="3"><br><br>
<h2>Abrir caja</h2>(No olvide limpiar los pedidos)<br><br>
<form action="caja_abrir.php" method="POST" name="caja_abrir">
    Monto en caja: <input type="text" name="saldo_apertura" size="20" class=":required">
    <br><br>
    <input type="submit" name="submit" value="Aceptar">
    <br><br>
</form>
<hr size="3">
<br><br>
<?php
}else{echo "<h2>Total ingresado en caja: $".$saldo_apertura."</h2><br><br><br>";}
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