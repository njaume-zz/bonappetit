<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
$ventananueva = LimpiarXSS($_POST['ventananueva']);
$nivel = $_SESSION['usuario_nivel'];
$usuario_id = $_SESSION['usuario_id'];
$usuario = $_SESSION['usuario_login'];
?>
<head>
  <title>EQUISETO</title>
  <meta name="author" content="Walter R. Elias">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--   <link type="text/css" rel="stylesheet" href="estilos.css"> -->
	<link rel="stylesheet" href="menu.css">
	<link rel="stylesheet" href="viejos/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.autocomplete.js">
	</script>

        <link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
        <script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>        
        
       
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>
	<script src="js/vanadium.js" type="text/javascript"></script>

	<link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<script src="js/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
	
	jQuery(document).ready(function($) {
	$('a[rel*=facebox]').facebox({
		loadingImage : 'css/loading.gif',
		closeImage   : 'css/closelabel.png'
	})
	})
	</script>

	<script language="javascript">
	function eltooltip(algo)
	{
		var ejecuta = window.event;
		var x = ejecuta.x;
		var y = ejecuta.srcElement.offsetTop+ejecuta.srcElement.offsetHeight+10;
		var pos = tabla.style;
		tabla.innerHTML = '<table style="background-color:INFOBACKGROUND;font:8pt Arial;padding:3px 3px 3px 3px;border:1px solid INFOTEXT"><tr><td align=left>'+ algo +'</td></tr></table>';
		pos.posTop = y
		pos.posLeft = x;
		pos.visibility = '';
	}
	</script>

<link href="css/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/cal.js"></script>

<script type="text/javascript">
jQuery(document).ready(function () {
	$('input.calendario').simpleDatepicker();
});
</script>
	<link rel="Stylesheet" media="screen" href="css/ui.core.css" />
	<link rel="Stylesheet" media="screen" href="css/ui.timepickr.css" />
	<script type="text/javascript" src="js/jquery.ui.all.js"></script>
	<script type="text/javascript" src="js/jquery.timepickr.js"></script>
	<script type="text/javascript">

	$(document).ready(function() {
	$(".timepickr").each(function(){
		$(this).timepickr();
                
	})
	});
        
        

</script>

<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="webcam.js"></script>

</head>
<body onload="javascript:foco();">

<br>
<div align="center">

<table width="95%" height="50" align="center" cellpadding="5" cellspacing="0" border="0">

<tr><td>

<?php

if ($ventananueva!='si') {
?>

<table align="center" width="100%" bgcolor="#FFFFFF">
<tr>
<td align="left" width="125">
    <a href="pedidos_grilla.php"><img src="images/logo.png" border="0"></a>
</td>
<td width="525" align="right">
<div align="center"><strong><h3>SISTEMA DE ADMINISTRACI&Oacute;N</h3></strong>
    <br>
<h2>Usuario: <?php echo $usuario;?></h2></div>
    <br>
    <div align="center">
     <a href="aut_logout.php">Salir</a>        
    </div>
</td>
<td width="300" align="left">
<p style="text-decoration: blink;">
<img src="images/tips.jpg" align="right">
<?php
include_once('tips.php');
?>
</p>
</td>
</tr>
</table>



</td></tr>

<tr>
<td bgcolor="Black">
<?php
include_once('menu.php');
?>
</td></tr>



<?php
}

?>



<tr>
<td align="center" bgcolor="#dddddd">
<br>