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
include("scaffold.php");
?>
<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<script type="text/javascript">
function creardescripcion() {

    nombre=document.getElementById('nombre').value;
    apellido=document.getElementById('apellido').value;
    dni=document.getElementById('dni').value;
    
    descripcion = apellido+', '+nombre+' - '+dni;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>

<?php


  

$totalfilas=0;
$band1 = 0; $band2 = 0; $band3 = 0; $band4 = 0; $band5 = 0;
$band6 = 0; $band7 = 0; $band8 = 0; $band9 = 0; $band10 = 0; 
$band11 = 0; $band12 = 0; $band13 = 0; $band14 = 0; $band15 = 0; 
$band16 = 0; $band17 = 0; $band18 = 0; $band19 = 0; $band20 = 0; 
$totalcolumnas[1]=0;  $totalcolumnas[2]=0;  $totalcolumnas[3]=0;  $totalcolumnas[20]=0;
$totalcolumnas[4]=0;  $totalcolumnas[5]=0;  $totalcolumnas[6]=0;  $totalcolumnas[7]=0; 
$totalcolumnas[8]=0;  $totalcolumnas[9]=0;  $totalcolumnas[10]=0; $totalcolumnas[11]=0;
$totalcolumnas[12]=0; $totalcolumnas[13]=0; $totalcolumnas[14]=0; $totalcolumnas[15]=0;
$totalcolumnas[16]=0; $totalcolumnas[17]=0; $totalcolumnas[18]=0; $totalcolumnas[19]=0;

$resultado = mysql_query("SELECT mesa_nro FROM pedido_maestros WHERE finalizado = 0 ORDER BY mesa_nro ASC");  
while ($fila = mysql_fetch_array($resultado, MYSQL_NUM)) {
if (($fila[0]<=10) and ($band1 != 1)) {$totalfilas++; $band1=1;}
 else if (($fila[0] >10) and ($fila[0] <=20) and ($band2 != 1)) {$totalfilas++; $band2=1;}
 else if (($fila[0] >20) and ($fila[0] <=30) and ($band3 != 1)) {$totalfilas++; $band3=1;}
 else if (($fila[0] >30) and ($fila[0] <=40) and ($band4 != 1)) {$totalfilas++; $band4=1;}
 else if (($fila[0] >40) and ($fila[0] <=50) and ($band5 != 1)) {$totalfilas++; $band5=1;}
 else if (($fila[0] >50) and ($fila[0] <=60) and ($band6 != 1)) {$totalfilas++; $band6=1;}
 else if (($fila[0] >60) and ($fila[0] <=70) and ($band7 != 1)) {$totalfilas++; $band7=1;}
 else if (($fila[0] >70) and ($fila[0] <=80) and ($band8 != 1)) {$totalfilas++; $band8=1;}
 else if (($fila[0] >80) and ($fila[0] <=90) and ($band9 != 1)) {$totalfilas++; $band9=1;}
 else if (($fila[0] >90) and ($fila[0] <=100) and ($band10 != 1)) {$totalfilas++; $band10=1;}
 else if (($fila[0] >100) and ($fila[0] <=110) and ($band11 != 1)) {$totalfilas++; $band11=1;}
 else if (($fila[0] >110) and ($fila[0] <=120) and ($band12 != 1)) {$totalfilas++; $band12=1;}
 else if (($fila[0] >120) and ($fila[0] <=130) and ($band13 != 1)) {$totalfilas++; $band13=1;}
 else if (($fila[0] >130) and ($fila[0] <=140) and ($band14 != 1)) {$totalfilas++; $band14=1;}
 else if (($fila[0] >140) and ($fila[0] <=150) and ($band15 != 1)) {$totalfilas++; $band15=1;}
 else if (($fila[0] >150) and ($fila[0] <=160) and ($band16 != 1)) {$totalfilas++; $band16=1;}
 else if (($fila[0] >160) and ($fila[0] <=170) and ($band17 != 1)) {$totalfilas++; $band17=1;}
 else if (($fila[0] >170) and ($fila[0] <=180) and ($band18 != 1)) {$totalfilas++; $band18=1;}
 else if (($fila[0] >180) and ($fila[0] <=190) and ($band19 != 1)) {$totalfilas++; $band19=1;}
 else if (($fila[0] >190) and ($fila[0] <=200) and ($band20 != 1)) {$totalfilas++; $band20=1;}
  
if (($fila[0]<=10)) {$totalcolumnas[1]++;}
 else if (($fila[0] >10) and ($fila[0] <=20)) {$totalcolumnas[2]++;}
 else if (($fila[0] >20) and ($fila[0] <=30)) {$totalcolumnas[3]++;}
 else if (($fila[0] >30) and ($fila[0] <=40)) {$totalcolumnas[4]++;}
 else if (($fila[0] >40) and ($fila[0] <=50)) {$totalcolumnas[5]++;}
 else if (($fila[0] >50) and ($fila[0] <=60)) {$totalcolumnas[6]++;}
 else if (($fila[0] >60) and ($fila[0] <=70)) {$totalcolumnas[7]++;}
 else if (($fila[0] >70) and ($fila[0] <=80)) {$totalcolumnas[8]++;}
 else if (($fila[0] >80) and ($fila[0] <=90)) {$totalcolumnas[9]++;}
 else if (($fila[0] >90) and ($fila[0] <=100)) {$totalcolumnas[10]++;}
 else if (($fila[0] >100) and ($fila[0] <=110)) {$totalcolumnas[11]++;}
 else if (($fila[0] >110) and ($fila[0] <=120)) {$totalcolumnas[12]++;}
 else if (($fila[0] >120) and ($fila[0] <=130)) {$totalcolumnas[13]++;}
 else if (($fila[0] >130) and ($fila[0] <=140)) {$totalcolumnas[14]++;}
 else if (($fila[0] >140) and ($fila[0] <=150)) {$totalcolumnas[15]++;}
 else if (($fila[0] >150) and ($fila[0] <=160)) {$totalcolumnas[16]++;}
 else if (($fila[0] >160) and ($fila[0] <=170)) {$totalcolumnas[17]++;}
 else if (($fila[0] >170) and ($fila[0] <=180)) {$totalcolumnas[18]++;}
 else if (($fila[0] >180) and ($fila[0] <=190)) {$totalcolumnas[19]++;}
 else if (($fila[0] >190) and ($fila[0] <=200)) {$totalcolumnas[20]++;}

}   
  
$cont=0;
$resultado = mysql_query("SELECT mesa_nro FROM pedido_maestros WHERE finalizado = 0 ORDER BY mesa_nro ASC");  
while ($fila = mysql_fetch_array($resultado, MYSQL_NUM)) {
    $valor[$cont]=$fila[0];
    $cont++;
}

?>
<div align="center" class="contiene-grilla">
<?php

$x=0;
$y=0;
$cont=0;
$w= $y+35;

for($i=0; $i<=$totalfilas; $i++)
  { for($j=0; $j<$totalcolumnas[$i]; $j++)
       { ?> 
         <div style="position:absolute; background:#92a167; top:<?php echo $y; ?>px; left:<?php echo $x; ?>px; color:#ffffff; width:60px; height:55px;">
	 <div align="center" style="position:relative; top:17px; font-size:xx-large;">
             
<ul class="menu-pedido">
  
  <li>
    <a href="#">
        <?php 
            if ($valor[$cont]<=9) echo '00'.$valor[$cont];
            else if (($valor[$cont] >9) and ($valor[$cont]<=99)) echo '0'.$valor[$cont];
                 else echo $valor[$cont]; 
        ?>
    </a>
    <ul>
            
      <li><a href="pedido_maestros.php?nuevo=1&mesa_id=<?php echo $cont; ?>"> Cargar Pedido </a></li>
      <li><a href="cerrar_pedido.php?mesa_id=<?php echo $cont; ?>"> Entrega Pedido </a></li>
      <li><a href=""> Cuenta </a></li>

    </ul>
  </li>
</ul>
             
 </div>
</DIV>
    <?php
	 $cont ++;
         $x=$x+70;
       }
       $y=$y+65;
       $w=$y+25;    
      $x=0; 
      
}
?>
</div>
    
    
    
    
    
    
</div>

    
<?php
include_once('html_inf.php');
?>