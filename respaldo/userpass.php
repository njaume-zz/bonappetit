<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
$ventananueva = LimpiarXSS($_POST['ventananueva']);
?>
<head>
  <title>EQUISETO - SISTEMA DE ADMINISTRACION PARA RESTAURANTE</title>
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



</head>
<body>

<br>
<div align="center">

<table width="95%" height="50" align="center" cellpadding="5" cellspacing="0" border="0">

<tr><td>

<?php

if ($ventananueva!='si') {
?>

<table align="center" width="100%" bgcolor="#ffffff">
<tr>
<td align="left" width="125">
<img src="images/logo.png">
</td>
<td width="525" align="right">
<div align="center"><strong><h3>SISTEMA DE ADMINISTRACI&Oacute;N</h3></strong></div>
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

</td></tr>



<?php
}

?>



<tr>
<td align="center" bgcolor="#dddddd">
    <h2><?php echo $_GET['mensaje'];?></h2>
<br>
<br>

<form name="registro" method="post" action="confirmar_login.php">        
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
  <tr>
    <td bgcolor="#CCCCCC"></td>
    <td colspan="4" bgcolor="#CCCCCC"></td>
    <td bgcolor="#CCCCCC"></td>
  </tr>
  <tr>
    <td rowspan="5" bgcolor="#FFFFFF"></td>
    <td bgcolor="#CCCCCC"></td>
    <td colspan="2" bgcolor="#FFFFFF"></td>
    <td bgcolor="#CCCCCC"></td>
    <td rowspan="5" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td rowspan="3" bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF"><font face="Arial">Usuario:</font></td>
    <td bgcolor="#FFFFFF"> <input name="user" type="text" id="user6" size="6"></td>
    <td rowspan="3" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><font face="Arial">Clave:</font></td>
    <td bgcolor="#FFFFFF"><input name="pass" type="password" id="pass" size="6"></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
    </td>
    <td valign="top" bgcolor="#FFFFFF"> <p align="right">
      <input type="submit" name="Submit" value="Acceder">
    </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#CCCCCC"></td>
    <td colspan="2" valign="top" bgcolor="#FFFFFF"></td>
    <td valign="top" bgcolor="#CCCCCC"></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#CCCCCC"></td>
    <td colspan="4" valign="top" bgcolor="#CCCCCC"></td>
    <td valign="top" bgcolor="#CCCCCC"></td>
  </tr>
</table>
</form>


</td></tr></table>
</div>


<!--[if lt IE 8]>
<script src="http://ie7-js.googlecode.com/svn/trunk/lib/IE8.js" type="text/javascript"></script>
<![endif]-->


<script type="text/javascript" charset="utf-8">
  jQuery(document).ready(function($){
    $("a[rel^='prettyPhoto']").prettyPhoto();
  });
</script>


</body>
</html>