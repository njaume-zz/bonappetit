<div id="menu">
<?php $caja_estado = DevuelveValor(1, 'descripcion', 'caja_estados', 'id');?>
    
<ul>     
<li class="nivel1"><a href="#" class="nivel1">PEDIDOS</a>
<!--[if lte IE 6]><a href="#" class="nivel1ie">PEDIDOS<table class="falsa"><tr><td><![endif]-->
	<ul class="nivel2">
            <hr size="2">
            <li><a href="pedido_maestros_nuevo.php" accesskey="P"><u>P</u>edido nuevo</a></li>
            <li><a href="pedido_maestros.php" accesskey="L"><u>L</u>istado</a></li>
            <hr size="2">
            <li><a href="#" onclick="var answer = confirm('Atencion, se borraran todos los pedidos del sistema');if (answer == true){window.location.href='limpieza_pedidos.php'; }">Limpiar pedidos</a></li>           

	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>

<ul>
<li class="nivel1"><a href="#" class="nivel1">ADMINISTRACION</a>
<!--[if lte IE 6]><a href="#" class="nivel1ie">ADMINISTRACION<table class="falsa"><tr><td><![endif]-->
	<ul class="nivel2">
            <hr size="2">
            <?php if ($caja_estado == 'INACTIVA'){?>
            <li><a href="caja_abrir.php">Abrir caja</a></li>  
            <?php }else{ ?>
            <li><a href="caja_cerrar.php">Cerrar caja</a></li> 
            <?php } ?>
            <hr size="2">
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="empleados.php">Empleados</a></li>  
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>
    
    
<ul>
<li class="nivel1"><a href="#" class="nivel1">RRHH</a>
<!--[if lte IE 6]><a href="#" class="nivel1ie">RRHH<table class="falsa"><tr><td><![endif]-->
	<ul class="nivel2">
            <li><a href="empleados.php">Empleados</a></li> 
            <hr size="2">
            <li><a href="proveedors.php">Proveedores</a></li>  
            <hr size="2">
            <li><a href="registro_ingreso.php">Registro de entrada</a></li> 
            <li><a href="registro_egreso.php">Registro de salida</a></li>
            <li><a href="registro_ingresos.php">Empleados en local</a></li> 
            <li><a href="registro_asistencias.php">Registro de asistencia</a></li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>  
    
    
<ul>
<li class="nivel1"><a  class="nivel1" href="#">CARTA</a>
<!--[if lte IE 6]><a href="#" class="nivel1ie">CARTA<table class="falsa"><tr><td><![endif]-->
	<ul class="nivel2">
            <hr size="2">
            <li><a href="productos.php">Productos</a></li> 
            <li><a href="recetas.php">Recetas</a></li> 
            <li><a href="tipo_recetas.php">Tipo de recetas</a></li>
            


	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>

       
<ul>   
<li class="nivel1"><a class="nivel1" href="#">REPORTES</a>
<!--[if lte IE 6]><a href="#" class="nivel1ie">REPORTES<table class="falsa"><tr><td><![endif]-->
	<ul class="nivel2">
            <hr size="2">
            <li><a href="ventas_del_dia_paso_1.php">Ventas del d&iacute;a</a></li>
            <li><a href="horas_trabajadas_por_empleado_paso_1.php">Horas trabajadas</a></li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>    
    
    
<ul>   
<li class="nivel1"><a class="nivel1" href="#">CONFIGURACION</a>
<!--[if lte IE 6]><a href="#" class="nivel1ie">CONFIGURACION<table class="falsa"><tr><td><![endif]-->
	<ul class="nivel2">
            <hr size="2">
            <li><a href="">Rubros</a></li>
            <li><a href="">Tipo de empleado</a></li>
            <li><a href="">Tipo de gastos</a></li>
            <li><a href="">Tipo de pagos</a></li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>    
    

</div>