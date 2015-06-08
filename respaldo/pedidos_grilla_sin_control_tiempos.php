<?php
/*require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}
*/
$tip = '<br><br> EN LA FECHA SUBIMOS EL SISTEMA DE REPORTES CORRESPONDIENTE A HORAS TRABAJADAS POR EMPLEADO. <br><br>Gracias. Walter, 11/07/2013';

include_once('html_sup.php');
include("scaffold.php");

function Tiempo($start,$end, $out_in_array=false){
        $intervalo = date_diff(date_create($start), date_create($end));
        $out = $intervalo->format("Y:%Y,Me:%M,D:%d,H:%H,m:%i,S:%s");
        if(!$out_in_array)
            return $out;
        $a_out = array();
        array_walk(explode(',',$out),
        function($val,$key) use(&$a_out){
            $v=explode(':',$val);
            $a_out[$v[0]] = $v[1];
        });
        return $a_out;
}

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
if ($fila[0]<=10) 
 {if ($band1 != 1) {$totalfilas++; $band1=1;}
  $totalcolumnas[$totalfilas]++;
 }
 else if (($fila[0] >10) and ($fila[0] <=20)) 
        {if ($band2 != 1) {$totalfilas++; $band2=1;}
         $totalcolumnas[$totalfilas]++;
        }
        else if (($fila[0] >20) and ($fila[0] <=30)) 
              {if ($band3 != 1) {$totalfilas++; $band3=1;}
               $totalcolumnas[$totalfilas]++;
              }
              else if (($fila[0] >30) and ($fila[0] <=40)) 
                     {if ($band4 != 1) {$totalfilas++; $band4=1;}
                      $totalcolumnas[$totalfilas]++;
                     }
                     else if (($fila[0] >40) and ($fila[0] <=50)) 
                            {if ($band5 != 1) {$totalfilas++; $band5=1;}
                             $totalcolumnas[$totalfilas]++;
                            }
                            else if (($fila[0] >50) and ($fila[0] <=60)) 
                                   {if ($band6 != 1) {$totalfilas++; $band6=1;}
                                    $totalcolumnas[$totalfilas]++;
                                   }
else if (($fila[0] >60) and ($fila[0] <=70)) 
        {if ($band7 != 1) {$totalfilas++; $band7=1;}
         $totalcolumnas[$totalfilas]++;
        }
        else if (($fila[0] >70) and ($fila[0] <=80)) 
              {if ($band8 != 1) {$totalfilas++; $band8=1;}
               $totalcolumnas[$totalfilas]++;
              }
              else if (($fila[0] >80) and ($fila[0] <=90)) 
                     {if ($band9 != 1) {$totalfilas++; $band9=1;}
                      $totalcolumnas[$totalfilas]++;
                     }
                     else if (($fila[0] >90) and ($fila[0] <=100)) 
                            {if ($band10 != 1) {$totalfilas++; $band10=1;}
                             $totalcolumnas[$totalfilas]++;
                            }
                            else if (($fila[0] >100) and ($fila[0] <=110)) 
                                   {if ($band11 != 1) {$totalfilas++; $band11=1;}
                                    $totalcolumnas[$totalfilas]++;
                                   }       
else if (($fila[0] >110) and ($fila[0] <=120)) 
        {if ($band12 != 1) {$totalfilas++; $band12=1;}
         $totalcolumnas[$totalfilas]++;
        }
        else if (($fila[0] >120) and ($fila[0] <=130)) 
              {if ($band13 != 1) {$totalfilas++; $band13=1;}
               $totalcolumnas[$totalfilas]++;
              }
              else if (($fila[0] >130) and ($fila[0] <=140)) 
                     {if ($band14 != 1) {$totalfilas++; $band14=1;}
                      $totalcolumnas[$totalfilas]++;
                     }
                     else if (($fila[0] >140) and ($fila[0] <=150)) 
                            {if ($band15 != 1) {$totalfilas++; $band15=1;}
                             $totalcolumnas[$totalfilas]++;
                            }
                            else if (($fila[0] >150) and ($fila[0] <=160)) 
                                   {if ($band16 != 1) {$totalfilas++; $band16=1;}
                                    $totalcolumnas[$totalfilas]++;
                                   }
else if (($fila[0] >160) and ($fila[0] <=170)) 
        {if ($band17 != 1) {$totalfilas++; $band17=1;}
         $totalcolumnas[$totalfilas]++;
        }
        else if (($fila[0] >170) and ($fila[0] <=180)) 
              {if ($band18 != 1) {$totalfilas++; $band18=1;}
               $totalcolumnas[$totalfilas]++;
              }
              else if (($fila[0] >180) and ($fila[0] <=190)) 
                     {if ($band19 != 1) {$totalfilas++; $band19=1;}
                      $totalcolumnas[$totalfilas]++;
                     }
                     else if (($fila[0] >190) and ($fila[0] <=200)) 
                            {if ($band20!= 1) {$totalfilas++; $band20=1;}
                             $totalcolumnas[$totalfilas]++;
                            }
                                   
} //cierro el } del while
                                   
  
$cont=0;
$resultado = mysql_query("SELECT mesa_nro, cantidad_de_comensales,fecha_y_hora FROM pedido_maestros WHERE finalizado = 0 ORDER BY mesa_nro ASC");  
while ($fila = mysql_fetch_array($resultado, MYSQL_NUM)) {
    $valor[$cont]=$fila[0];
    $comensales[$cont]=$fila[1];
   // echo $valor[$cont]." ".$comensales[$cont]."<br>";
    $fecha_y_hora[$cont] = $fila[2];
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
       { //$ancho=60+($comensales[$cont]*5);
        $fecha_actual = date('Y-m-d H:i');
        $fecha_pedido = $fecha_y_hora[$cont];
        $dif=Tiempo($fecha_actual,$fecha_pedido,true);
        
        if ($dif[m]<=5) $color_fondo = '#92a167';
        elseif (($dif[m]<=10) AND ($dif[m]>=5)) $color_fondo = '#FFF700';
        elseif (($dif[m]<=15) AND ($dif[m]>=10)) $color_fondo = '#FFD791';
        elseif (($dif[m]<=20) AND ($dif[m]>=15)) $color_fondo = '#FF461C';
        elseif (($dif[m]<=25) AND ($dif[m]>=20)) $color_fondo = '#C20003';
        else $color_fondo = '#cccccc';
        
       ?> 
         <div style="position:absolute; background:<?php echo $color_fondo;?>; top:<?php echo $y; ?>px; left:<?php echo $x; ?>px; color:#ffffff; width:70px; height:55px;">
	 <div align="center" style="position:relative; top:17px; font-size:xx-large;">
             
<ul class="menu-pedido">
  
  <li>
    <a href="#">
        <?php              
            if ($valor[$cont]<=9) echo '00'.$valor[$cont];
            else if (($valor[$cont] >9) and ($valor[$cont]<=99)) echo '0'.$valor[$cont];
                 else echo $valor[$cont]; 
             
        ?>
        <div class="alerta">
            <?php echo $dif[H].':'.$dif[m];?>
        </div>
    </a>
    <ul>
      
      <li>
        <?php $resul = mysql_query("SELECT id FROM pedido_maestros WHERE finalizado = '0' AND mesa_nro = $valor[$cont]");  
              while ($fila = mysql_fetch_array($resul, MYSQL_NUM)) {
                  $g=$fila[0];
              }
        ?>
            <form name="searchbar" id="searchbar" action="pedido_detalles.php" 
                  method="post" style="display:inline">
                <input type="hidden" name="variablecontrolposnavegacion" value="search">
                <input type="hidden" name="field" value="pedido_maestro_id">
                <input type="hidden" name="compare" value="=">
                <input type="hidden" name="searchterm" value="<?php echo $g; ?>">
                <input type="hidden" id="maestro_id" name="maestro_id" value="<?php echo $g; ?>">
                <input type="submit" name="Search" value="Detalle" class="boton_grilla"/>
            </form>
      </li>

    </ul>
  </li>
</ul>
             
 </div>
</DIV>
    <?php
	 $cont ++;
         $x=$x+75;
       }
       $y=$y+60;
       $w=$y+25;    
      $x=0; 
      
}
?>
</div>
    


    
<?php
include_once('html_inf.php');
?>