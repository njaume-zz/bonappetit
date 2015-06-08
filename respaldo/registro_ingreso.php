<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

include_once 'html_sup.php';
?>
<div align="center"><h1>REGISTRO DE ENTRADA</h1></div>

<style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#cuadro_camara {
		background-color: #444;
		padding-left: 30px;
		padding-top:20px;
	}
	#titulo_camara {
	background-color: #666;
	color:#FFF;
	padding-left: 30px;
	font-size: 14px;
	text-align:center;
	}
	.botones_cam {
		background-color:#FFF;
		color:#333;
		font-family: "Comic Sans MS", cursive;
		font-size:14px;
		margin-top:10px;
		width:100px;
		height:40px;
	}
	.formulario {
		color: #FFF;
	}
	
	</style>


    <script language="JavaScript">
		webcam.set_api_url( 'sube_foto_entrada.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
		webcam.set_quality( 90 ); // calidad de la imagen
		webcam.set_shutter_sound( true ); // Sonido de flash
	</script>
		<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function do_upload() {
			// subir al servidor
			document.getElementById('upload_results').innerHTML = '<h1>Cargando al servidor...</h1>';
			webcam.upload();
		}
		
		function my_completion_handler(msg) {
			
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
				
				// Muestra la imagen en la pantalla
				document.getElementById('upload_results').innerHTML = 
					'<img src="' + image_url + '">'+
					'<form action="gestion_foto_ingreso.php" method="post">'+
					'<input type="hidden" name="id_foto" id="id_foto" value="' + image_url + '"  /><br>'+
					'<label>Empleado </label><select name="empleado_id">'+
                                        '<option selected value="">Elija un empleado</option>'+
                                        <?php
                                              $sql = "SELECT id, descripcion
                                                      FROM empleados
                                                      ORDER BY apellido";
                                              $query = mysql_query($sql);
                                              while($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
                                              echo "'<option value=\"$result_query[0]\">$result_query[1]</option>'+\n";//muestra resultado de la consulta
                                        ?>
                                        '</select>'+
				    '<input type="submit" name="button" id="button" value="Confirmar ingreso" /></form>'
					;
				// reset camera for another shot
				webcam.reset();
			}
			else alert("PHP Error: " + msg);
		}
	</script>
<div align="center" id="cuadro_camara">    

<table width="800" height="144" border="0" align="center"><tr><td width="100" valign=top>
		<form>
<!--		<input type=button value="Configurar" onClick="webcam.configure()" class="botones_cam">
		&nbsp;&nbsp;-->
		<input type=button value="Tomar foto" onClick="webcam.freeze()" class="botones_cam">
		&nbsp;&nbsp;
		<input type=button value="Aceptar foto" onClick="do_upload()" class="botones_cam">
		&nbsp;&nbsp;
		<input type=button value="Reiniciar" onClick="webcam.reset()" class="botones_cam">
	</form>
	
	</td>
    <td width="263" valign=top align="center">
	<script language="JavaScript">
	document.write( webcam.get_html(320, 240) );//dimensiones de la camara
	</script>
    </td>
    <td width=411 align="center">
	    <div id="upload_results" class="formulario" > </div>
  </td></tr></table><br /><br />
</div>



<br />
<br />
<script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();//Galeria jquery
    });
    </script>
    <style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#gallery {
		background-color: #444;
		width: 100%;
	}
	#gallery ul { list-style: none; }
	#gallery ul li { display: inline; }
	#gallery ul img {
		border: 5px solid #3e3e3e;
		border-width: 5px 5px 5px;
	}
	#gallery ul a:hover img {
		border: 5px solid #fff;
		border-width: 5px 5px 5px;
		color: #fff;
	}
	#gallery ul a:hover { color: #fff; }
	</style>
    
    <div id="gallery">
    <ul>
  <?php  
  

  $consulta="
      SELECT * 
      FROM fotos 
      ORDER BY id 
      DESC
      LIMIT 0,20
      ";
  
  $busca_fotos=mysql_query($consulta);
  while($ro=mysql_fetch_array($busca_fotos)){
   $url         = $ro['id'];
   $empleado_id = $ro['empleado_id']; 
   $des         = $ro['descripcion'];
   $fecha_y_hora = $ro['fecha_y_hora'];
     echo "<li>
	 
            <a href=\"fotos/".$url.".jpg\" title=\"$fecha_y_hora - $des\">

                <img src=\"fotos/".$url.".jpg\" width=\"160\" height=\"120\" alt=\"\" />

            </a>
        </li>";
  }
?>    
    </ul>
</div>
<?php
include_once 'html_inf.php';
?>