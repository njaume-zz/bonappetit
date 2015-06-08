<?php
require("aut_verifica.inc.php");
$nivel_acceso=3;
if ($nivel_acceso <= $_SESSION['usuario_nivel']){
header ("Location: empresas.php");
exit;
}

$tip = '';

include_once('html_sup.php');
include("scaffold.php");
?>


<div align="center" class="titulo">
    <strong>Evaluaci&oacute;n final</strong>: corresponde al detalle de las tareas realizadas por el empleado y su desempe&ntilde;o en la empresa luego de finalizar sus labores como empleado de la misma.
</div>
<br>
<?php

$submit = $_POST['descripcion']; //Toma el valor de descripción que viene por formulario 
//(solo para saber si se ha llenado el formulario correspondiente).

//leo el motivo de desvinculación y actualizo el estado (activo_id Si=1 No=2) 
//en la tabla choferes 



//###########  Si se llenó el formulario y se puso "guardar":

if (!empty($submit)) {  
    
    //Tomo la fecha en la que se da de baja el empleado según formulario
    $fecha_baja_empleado = date_transform_usa($_POST['fecha_baja_empleado']);
    
    //Tomo la fecha actual (o sea, la fecha de hoy)
    $fecha_actual = date('Y-m-d');
    
    //En la variable $fecha1, creo un objeto DataTime con la fecha de baja del empleado
    $fecha1 = new DateTime($fecha_baja_empleado);    
    
    //En la variable $fecha2, creo un objeto DataTime con la fecha de hoy
    $fecha2 = new DateTime($fecha_actual);
   
    //Calcula la diferencia entre las dos fechas 
    $intervalo = $fecha1->diff($fecha2); 
    
    //A la variable $dias_restantes le asigno la diferencia entre las dos fechas, 
    // Un valor negativo indicará que hay un error, ya que la fecha de baja del empleado
    // fecha1 no puede ser superior a la fecha2.
    $dias_restantes = $intervalo->format('%R%a'); 
    
    //echo $dias_restantes;
    
    //Si la diferencia entre fecha1 y fecha 2 da un valor negativo
    if($dias_restantes<0) {
        
        //Ejecuto una función javascript que muestre una alerta y saque de la página
        //en caso de que se cumpla la condicion.
       
        echo '<script language="JavaScript" type="text/javascript">
                <!--
                function validafecha() 
                {
                   alert
                      ("La fecha de baja no puede ser superior a la fecha de calendario actual.")
                      
                      //history.go(-1); 
                      return false;
                      
                   
                }
                //document.writeln(validafecha())
                // -->

                
              </script>';
    }else{ 
   
    
    $chofer_id = $_POST['chofer_id'];
    echo 'chofer: '.$chofer_id.'<br>';
    $sql = "UPDATE chofers SET activo_id=2 WHERE id = $chofer_id";
    mysql_query($sql);
}
}
new Scaffold("noeditable","evaluacion_finals",30);





include_once('html_inf.php');
?>