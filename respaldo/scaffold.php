<?php
#Version mejorada para maestro detalle el 21 de febrero de 2012

class Scaffold {


// configuracion
  /*  	var $db_host = 'localhost';
	var $db_user = 'root';
	var $db_password = 'shinw1sa';
	var $db_name = 'equiseto';
 
 */
	var $db_host = 'localhost';
	var $db_user = 'root';
	var $db_password = '';
	var $db_name = 'equiseto';        

         
	/**
	Los siguientes arrays contienen los campos de las fk que estan relacionados con tablas que no llevan el mismo nombre.
	*/

	var $singular = array ('producto_elaborado');	// las fk
	var $plural = array ('receta_maestros'); //las tabas correspondientes a las fk anteriores

	/**
	* colores de filas alternados
	*/
	var $row_odd = '#fff';
	var $row_even = '#E9FEFF';
// fin configuracion

	var $table = '';								// Variable interna para la tabla

	function Scaffold(
                            $mostrar, 
                            $table, 
                            $max_records = 100, 
                            $fields = array(), 
                            $ocultos=array(), 
                            $relacion=array(), 
                            $oc_maestro=array(), 
                            $view_column=array(), 
                            $htmlsafe = true, 
                            $width = NULL)
                {
            
		$this->mostrar = $mostrar; //si la descripcion es editable o no
		$this->table = $table;	// Seteo la tabla
		$this->max_records = intval($max_records);	// Seteo el limite de registros por tabla
		$this->fields = $fields; // Campos a mostrar. Opcional. Si no se detalla, se muestran todos.
		$this->ocultos = $ocultos; // Campos a ocultar. Opcional
                $this->relacion = $relacion;  //Array que contiene los campos que están relacionados desde otras tablas
		//$this->table_asoc = $table_asoc; //Tabla asociada a la table. Opcional.
                $this->oc_maestro = $oc_maestro; 
		$this->htmlsafe = $htmlsafe;	// html seguro
		$this->width = intval($width);	//
                $this->view_column = $view_column;  //D = detalles, E=Editar, B=Borrar   view_column('','E','B') muestra Editar y Borrar pero no muestra Detalle.
		

		//Defino el tipo de comprobante y creo variables propias de la clase
		$this->maestro_id = $_POST['maestro_id'];
                $this->usuario_id = $_SESSION['usuario_id'];
                if (empty($this->usuario_id)) {
                    $this->usuario_id = $_POST['usuario_id'];
                }
                
                $this->usuario_nivel = $_SESSION['usuario_nivel'];
                
                $this->control_admin = '1';
		
                //Provisorio hasta habilitar el control de usuarios
                //$this->usuario_id = 1;
                //$this->empresa_id = 1;
                        
                       
                ###### SOLO  ###################################################################
		$this->empresa_id = DevuelveValor($this->usuario_id, 'empresa_id', 'usuarios', 'id');
                ########################################################################################

                
                
                if ($this->usuario_nivel == 1) {
                    $this->empresa_id = "'%'";
                }
                
                if ($_POST['empresa_id'] == $this->control_admin) {
                    $this->empresa_id = "'%'";
                }                
                

                
                
                
                
                
		$cadena = $this->table;
		$largo_nombre = strlen($cadena);
		$cola = 9;
		$total_cadena = $largo_nombre - $cola;
		$this->tipo_comprobante = substr($cadena, 0, $total_cadena);


		// Variable de pagina
		(!empty($_GET['page']) && is_numeric($_GET['page'])) ? $this->page = intval($_GET['page']) : $this->page = 1;


		$connection = mysql_connect($this->db_host,
							$this->db_user,
							$this->db_password);
		mysql_select_db($this->db_name, $connection) or die('Error al conectar a la base de datos.');

		$action = (!empty($_POST['variablecontrolposnavegacion'])) ? $_POST['variablecontrolposnavegacion'] : 'list' ;
		switch($action){
			default:
				$this->list_table();
			break;

			case 'list':
				$this->list_table();
			break;

			case 'new':
				$this->new_row();
			break;

			case 'create':
				$this->create();
			break;

			case 'edit':
				$this->edit_row();
			break;
                        
                        case 'view':
				$this->view_row();
			break;

			case 'update':
				$this->update();
			break;

			case 'delete':
				$this->delete_row();
			break;

			case 'search':
				$this->search();
			break;


		}
	}
        
        
        
        /**
	* Transforma la fecua
	*
	* string $fecha_lat		// Fecha en formato latino
	* 
	*
	*/
	function date_transform_usa($fecha_lat){
            //Parseo el $value para ver si es una fecha.
            $value = str_replace("'",'',$fecha_lat);


            
            $guion1 = substr($value, 2,-7);
            $guion2 = substr($value, 5,-4);
            $largo  = strlen($value);

            $verificador = $guion1.$largo.$guion2;

            if (($verificador == '-10-')) {
                
                $dia = substr($value, 0, 2);
                $mes = substr($value, 3, 2);
                $ano = substr($value, 6, 4);
                $value = "'".$ano . '-' . $mes . '-' . $dia."'";

            }
            $value = str_replace("'",'',$value);

            return $value;                        
        }
        
        /**
	* Transforma la fecua
	*
	* string $fecha_lat		// Fecha en formato latino
	* 
	*
	*/
	function date_transform_lat($fecha_usa){
            //Parseo el $value para ver si es una fecha.
            $value = str_replace("'",'',$fecha_usa);
            $guion1 = substr($value, 4,-5);
            $guion2 = substr($value, 7,-2);
            $largo  = strlen($value);

            $verificador = $guion1.$largo.$guion2;

            if (($verificador == '-10-')) {
                
                $dia = substr($value, 8, 2);
                $mes = substr($value, 5, 2);
                $ano = substr($value, 0, 4);
                $value = "'".$dia . '-' . $mes . '-' . $ano."'";

            }
            $value = str_replace("'",'',$value);
            return $value;                        
        }        
         

	/**
	* Lista de registros
	*
	* string $msg 		// Mensaje opcional
	* strgin $where		// WHERE opcional como parametro para SQL
	*
	*/
	function list_table($msg = NULL, $where = null){
             
            if ($this->max_records != 0) {
		$start = (($this->page-1)*$this->max_records);				// Parametros por pagina
		$end = $this->max_records;	// Fin parametros por pagina
		$page = '';
                
                if ($where == null){
                    $where = ' WHERE empresa_id LIKE '.$this->empresa_id.' ';
                }else{
                   $where = $where.' AND empresa_id LIKE '.$this->empresa_id.' '; 
                }


                
                if((!empty($this->maestro_id)) AND ($where == null)) {
                    $where = " WHERE ".$this->tipo_comprobante."_maestro_id = ".$this->maestro_id.' AND empresa_id LIKE '.$this->empresa_id.' ';
                }elseif ((!empty($this->maestro_id)) AND ($where != null)) {
                    $where = $where.' AND '.$this->tipo_comprobante."_maestro_id = ".$this->maestro_id;
                }                
                  
            
        
                
                       
                $Query = 'SELECT COUNT(*) FROM '.$this->table.''.$where;
		$totalQuery = mysql_query ($Query) or die(mysql_error());
		$totalA = mysql_fetch_array($totalQuery);
		$total = $totalA[0];
		if (!empty($this->fields)) {
		// Muestra los campos seleccionados solamente
			$query = 'SELECT id';
			foreach($this->fields as $val){
				$query .= ', '.$val;
			}
			$query .= ' FROM '.$this->table;
		}else{
			$query = 'SELECT * FROM '.$this->table;
		}

		if(!empty($where)){ $query .= $where;}
                
                //SOLO para Gestruck
                if(($this->table == 'documentacion_chofers') OR ($this->table == 'documentacion_vehiculos')) {
                    $query = $query.' ORDER BY dias_a_vencer LIMIT '.$start.', '.$end;
                }else{  //Si no es gestruck, se puede dejar solo lo q está en el else
                    $query = $query.' ORDER BY id DESC LIMIT '.$start.', '.$end;
                }
		$select = mysql_query($query) or die(mysql_error());
		$i = 0;


		(!empty($this->width)) ? $width = ' width="'.$this->width.'"' : $width = NULL;

		$this->build_search_bar();

                ##### Muestra el encabezado del documento maestro ####
                
		if(!empty($this->maestro_id)) {
                    $input_maestro = '<input type="hidden" name="maestro_id" value="'.$this->maestro_id.'">';
                    $mensaje_maestro = 'para '.$this->build_friendly_names(strtoupper(substr($this->table,0,-1)));
                    
                    
                    
                    $sql_maestro = "SELECT * FROM ".$this->tipo_comprobante."_maestros WHERE id=".$this->maestro_id;
                    
                    $fields = mysql_query($sql_maestro);
                    $rows   = mysql_query($sql_maestro);
                    $row = mysql_fetch_row($rows);
                    
                    $page_m .= '<table bgcolor="#ffffff" cellpadding="2" cellspacing="0" border="0"'.$width.'">';
                    $page_m .= '<tr>';
                    
                    $counthidden = 0;
		    $totalhidden = count($this->oc_maestro);
                    
                    //echo 'total ocultos maestro: '.$totalhidden;
                    
                    while($j < mysql_num_fields($fields)){
			$field = mysql_fetch_field($fields);
                        
                        
                        // En el siguiente if, hay campos que deberían enviarse en un array desde afuera. 
			if(($field->name != 'id') AND ($field->name != 'usuario_id')){
 
				$page_m .= '<tr>';
				// reviso las claves foraneas..
				if(($counthidden <= $totalhidden-1) AND ($this->oc_maestro[$counthidden] == $field->name)){
					$variable = $this->oc_maestro[$counthidden];
					$page_m .= '';
					$counthidden = $counthidden + 1;
				}else{
					$page_m .= '<td align="right"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$j].' </td>';
				}

			}
			$j++;
			$page_m .= '</tr>';
		}
		$page_m .= '<tr><td>&nbsp;</td><td></td></tr>'
		      . '</table>';
                

		echo $page_m;
                    
                    
                    
                } //esta linea verifica si se envia el id de maestro desde el formulario anterior. en caso positivo, genera un campo oculto del formulario

                ###### fin encabezado documento maestro

                
		$total.= ' Registro/s encontrado/s. Secci&oacute;n: <strong>'.$this->build_friendly_names(strtoupper(substr($this->table,0,-1))).'</strong>. | '
			. '<form name="newrecord" id="newrecord" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline">'.$input_maestro.'
                            <input type="hidden" name="variablecontrolposnavegacion" value="new">';
                
                
                if(($this->view_column[3]=='N') OR ($this->usuario_nivel == 1)){
                $total .=  '<a href="javascript:document.newrecord.submit()">Registro nuevo '.$mensaje_maestro.'</a>';
                }            

                $total .= '</form>
                           <br />
                           <br />';
                echo $total;
                
                
                //Filtro de resultados
                
                $filtro .= '
                <script>
                var searchOnTable = function() {
                var table = $(\'#lista\');
                var value = this.value;
                table.find(\'tr\').each(function(index, row) {
                        var allCells = $(row).find(\'td\');
                        if(allCells.length > 0) {
                                var found = false;
                                allCells.each(function(index, td) {
                                        var regExp = new RegExp(value, \'i\');
                                        if(regExp.test($(td).text())) {
                                                found = true;
                                                return false;
                                        }
                                });
                                if (found == true) $(row).show();
                                else $(row).hide();
                                }
                        });
                };

                $(function(){
                        $(\'#filter\').keyup(searchOnTable);
                });
                </script>
                
                ';
                $filtro .= '<br><br>Filtro: <input type="text" id="filter" placeholder="Filtrar"><br><br>';
                echo $filtro;
                //  fin Filtro de resultados
                
                
		if(!empty($msg)) { echo $msg; }
		$this->paginate($total, $this->page);
		$page .= '<table id="lista" cellpadding="2" cellspacing="0" border="0"'.$width.'>';
                
                
		$page .= '<tr>';
		while($i < mysql_num_fields($select)){
			$column = mysql_fetch_field($select, $i);
			if($column->name != 'id' && $column->name != 'updated_at' && $column->name != 'created_at'){
				$page .= '<th nowrap>'.str_replace(' ','<br>',$this->build_friendly_names($column->name)).'</th>';

			}
			$i++;
		}
		$page .= '</tr>';

		$count = 0;
		while($array = mysql_fetch_array($select)){
			$page .= (!($count % 2) == 0) ? '<tr style="background:'.$this->row_even.';">' : '<tr style="background:'.$this->row_odd.';">';
			
                        
                        foreach($array as $column => $value){
                            
                                //EXCLUSIVO EQUISETO
                                
                                if(($column == 'parametros_vehiculo_id') OR ($column == 'parametros_chofer_id')) $maestro_id = $value; 
                                
                                //FIN EXCLUSIVO EQUISETO
                                
				if(!is_int($column) && $column != 'id' && $column != 'updated_at' && $column != 'created_at'){
					
                                    //Esto es exclusivo del sistema Gestruck
                                    if ($column=='parametros_vehiculo_id'){
                                        $dias_alerta = DevuelveValor($parametro_id, 'dias_alerta','parametros_vehiculos','id');
                                        
                                    }elseif($column=='parametros_chofers_id'){
                                        $dias_alerta = DevuelveValor($parametro_id, 'dias_alerta','parametros_chofers','id');
                                        }
                                       
                                    
                                    
                                if($column == 'dias_a_vencer'){
                                    
                                    if (($value <= $dias_alerta) AND ($value >= 0)) {
                                        $bgcolor = '#fbec88';
                                    }
                                    elseif ($value <= 0)  {
                                        $bgcolor = '#FF0000';
                                    }
                                    else $bgcolor="";
                                }else $bgcolor="";
                                    //Acá termina la parte exclusiva de Gestruck

                                        
                                        $page .= '<td bgcolor="'.$bgcolor.'">';  
                                        
					if($column == 'foto') {
						$page .= '<img width="30" height="30" src="'.$value.'">';

					}else{
					if($this->htmlsafe) {
						if(substr($column, -3) == '_id'){

						$page .= $this->build_foreign_key_title($column,$value);
						}
						else{ 
                                                    $value = $this->date_transform_lat ($value);
                                                    $page .= htmlentities($value);
                                                }
					}else{
						if(substr($column, -3) == '_id'){
						$page .= $this->build_foreign_key_title($column,$value);}
						else{
                                                $value = $this->date_transform_lat ($value);
						$page .= $value;
                                                }
					}
					}
					$page .= '</td>';
				}
			}
			$count ++;
                        
                        //Lo siguiente añade un botón en la fila para ver los datos relacionados con la misma, 
                        //siempre y cuando esos datos hayan sido mandados por el array desde el llamado al scaffold
                        if (!empty($this->relacion)) {
                            $relacion = $this->relacion;
                            $table = $this->table;
                            $id_name = substr($table,0,-1).'_id';
                            $cantidad_elementos = count($relacion);
                            
                            for ($i=0;$i<$cantidad_elementos;$i++)
                            {
                                $relacion_id = $relacion[$i];
                                $relacion_table = substr($relacion_id, 0,-3);
                                $page .= '
                                <td>
                                <form name="view_'.$array[0].'" id="view_'.$array[0].'" action="'.$relacion_table.'s.php" 
                                    method="post" style="display:inline" target="ventanaForm" 
                                    onsubmit="window.open(\'\', \'ventanaForm\', \'width=1024,height=600,top=100,left=100,scrollbars=yes\')">
                                    <input type="hidden" name="variablecontrolposnavegacion" value="view">
                                    <input type="hidden" name="ventananueva" value="si">
                                    <input type="hidden" name="id_name" value="'.$id_name.'">
                                    <input type="hidden" name="id_value" value="'.$array[0].'">
                                    <input type="hidden" name="ver_relacion" value="SI">
                                    <input type="hidden" name="tabla_relacion" value="'.$relacion_table.'s">
                                    <input type="submit" name="View" value="'.$this->build_friendly_names($relacion_table).'" class="boton_relacion" style="cursor:pointer;" />
                                 </form>
                                 </td>                            
                                ';
                                
                            }
                            
                        }
                        
                        
                        //Lo siguiente sirve para agregar un botón para dar de baja pedido. Solo para EQUISETO
                        if ($this->table == 'pedido_detalles') {
                            $table = $this->table;
                            $entregado = DevuelveValor($array[0], 'estado_id', 'pedido_detalles', 'id');
                            if ($entregado == '1') {$clase_e = 'detalle_vacio'; $valor_entregado = 'FALTA IMPRIMIR';}
                            elseif ($entregado == '2') {$clase_e = 'boton_relacion'; $valor_entregado = 'ENTREGADO';}
                            elseif ($entregado == '3') {$clase_e = 'detalle_inconsistente'; $valor_entregado = 'EN PREPARACION';}
                                $page .= '
                                <td>
                                <form name="entregado" id="entregado" action="entregado.php" 
                                    method="post" style="display:inline">
                                    <input type="hidden" name="id_name" value="'.$id_name.'">
                                    <input type="hidden" name="id_value" value="'.$array[0].'">
                                    <input type="submit" name="entregado" value="'.$valor_entregado.'" class="'.$clase_e.'" style="cursor:pointer;"  onClick="if (confirm(\' Se va a marcar este producto como entregado. Est&aacute; seguro?\')){document.submit();}else{return false;}"/>
                                 </form>
                                 </td>                            
                                ';                          
                        }                        
                        
                        //FIN SOLO PARA EQUISETO
                        
                      
                        
                        
                        
                        
                        
                      
                        if(($this->view_column[0]=='D') OR ($this->usuario_nivel == 1)){
			$page .= '
                            <td>
                            <form name="view_'.$array[0].'" id="view_'.$array[0].'" action="'.$_SERVER['PHP_SELF'].'" 
                                method="post" style="display:inline" target="ventanaForm" 
                                onsubmit="window.open(\'\', \'ventanaForm\', \'width=1024,height=600,top=100,left=100,scrollbars=yes\')">
                                <input type="hidden" name="variablecontrolposnavegacion" value="view">
                                <input type="hidden" name="ventananueva" value="si">
                                <input type="hidden" name="id" value="'.$array[0].'">
                                <input type="submit" name="View" value="Detalles" class="boton_relacion" style="cursor:pointer;" />
                             </form>
                             </td>';
                        }
                        
                        
                        if(($this->view_column[1]=='E') OR ($this->usuario_nivel == 1)){
                        $page .= '
                            
                            <td>
                            <form name="edit_'.$array[0].'" id="edit_'.$array[0].'" action="'.$_SERVER['PHP_SELF'].'" 
                                method="post" style="display:inline"><input type="hidden" name="variablecontrolposnavegacion" value="edit">
                                '.$input_maestro.'
                                <input type="hidden" name="id" value="'.$array[0].'">
                                    <a href="javascript:document.edit_'.$array[0].'.submit()">Editar</a>
                            </form>
                            </td>
                        ';
                        }
                        
                        if(($this->view_column[2]=='B') OR ($this->usuario_nivel == 1)){
                        $page .= '
		            <td>
			    <form name="delete_'.$array[0].'" id="delete_'.$array[0].'" action="'.$_SERVER['PHP_SELF'].'" 
                                method="post" style="display:inline">
                                <input type="hidden" name="variablecontrolposnavegacion" value="delete">
                                <input type="hidden" name="maestro_id" value="'.$this->maestro_id.'">
                                <input type="hidden" name="id" value="'.$array[0].'">
                                <a href="javascript:" onClick="if (confirm(\'Est&aacute; seguro?\')){document.delete_'.$array[0].'.submit();}else{return false;}">
                                    Borrar
                                </a>
                             </form>
                             </td>';
                        
                        }
                        



			if(substr($this->table, -9) == '_maestros') {
			//Me fijo si la tabla detalle correspondiente al maestro tiene datos. Si es vacia pongo un estilo para el botón y si tiene datos pongo otro.
                        $consulta_detalles  = 'SELECT * FROM `'.$this->tipo_comprobante.'_detalles` WHERE `'.$this->tipo_comprobante.'_maestro_id` = '.$array[0];
                        $resultado_detalles = mysql_query($consulta_detalles);
                        $total_detalles     = mysql_num_rows($resultado_detalles);
                        //echo "<br>".$consulta_detalles;
                        //echo "<br>total registros: ".$total_detalles;
                        
                        //Tomo el valor de importe de _maestro para ese registro.
                        $importe_maestro = DevuelveValor($array[0], 'total', $this->tipo_comprobante.'_maestros', 'id');
                        
                        //finalizado
                        $finalizado = DevuelveValor($array[0], 'finalizado', $this->tipo_comprobante.'_maestros', 'id');
                        

                        
                        //Tomo los importes individuales de cada detalle y los sumo.
                        $consulta_detalles_importe  = 'SELECT SUM(cantidad*precio_unitario) as total FROM `'.$this->tipo_comprobante.'_detalles` WHERE `'.$this->tipo_comprobante.'_maestro_id` = '.$array[0];
                      
                        $resultado_detalles_importe = mysql_query($consulta_detalles_importe);
                        $fila_importes = mysql_fetch_array($resultado_detalles_importe, MYSQL_ASSOC);
                        $total_detalles_importe = $fila_importes["total"];
                        
                        
                        if ($total_detalles == 0) {
                            $boton_detalle = 'detalle_vacio';
                        }elseif($finalizado == 1){
                            $boton_detalle = 'detalle_finalizado';
                        }elseif($finalizado == 2){
                            $boton_detalle = 'detalle_pagar';                        
                        }elseif($importe_maestro != $total_detalles_importe){
                            $boton_detalle = 'detalle_inconsistente';
                        }else{
                            $boton_detalle = 'detalle_no_vacio';
                        }
                        
                        
                        
                        $page .= '<td><form name="searchbar" id="searchbar" action="'.$this->tipo_comprobante.'_detalles.php" method="post" style="display:inline"><input type="hidden" name="variablecontrolposnavegacion" value="search"><input type="hidden" name="field" value="'.$this->tipo_comprobante.'_maestro_id"><input type="hidden" name="compare" value="="><input type="hidden" name="searchterm" value="'.$array[0].'"><input type="hidden" id="maestro_id" name="maestro_id" value="'.$array[0].'"><input type="submit" name="Search" value="Detalle" class="'.$boton_detalle.'"/></form></td>';} //ESTE BOTON TIENE QUE HACER UN SEARCH LIMITANDO LOS RESULTADOS AL ID MAESTRO.
			$page .= '</tr>';
		}

		$page .= "</table>";
		echo $page;
		$this->paginate($total);


		}
        }


	/**
	* Este metodo crea el formulario para un nuevo registro
	*
	*/
	function new_row(){
		$page = '';
		$selectFields = mysql_query('SELECT * FROM '.$this->table);
		$i = 0;
		echo '<h2>Formulario de carga de datos: <strong>'.$this->build_friendly_names(strtoupper(substr($this->table,0,-1))).'</strong></h2><br>';
		$page .= '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="crear" id="crear" enctype="multipart/form-data" onsubmit="return creardescripcion()">'
				. '<input type="hidden" name="variablecontrolposnavegacion" value="create">'
				. '<table cellpadding="2" cellspacing="0" border="0" width="700">';
		$counthidden = 0;
		$totalhidden = count($this->ocultos);
		while($i < mysql_num_fields($selectFields)){
			$column = mysql_fetch_field($selectFields);
			if($column->name != 'id'){
				
				$page .= '<tr>';
				// revisa las claves foraneas..
				
				
				
				if(($column->name == 'receta_maestro_id') AND ($column->name != 'usuario_id') AND ($column->name != 'empresa_id')){
					$page .= $this->build_foreign_key_dropdowns_auto($column->name);
				}
				
			}
			$i++;
		}

                
       
                
		$page .= '<tr><td>&nbsp;</td><td>
                       
			  <input type="submit" value="Agregar registro"/></td></tr>'
		 		. '</table>'
		 		. '</form>'
		 		. '<a href="'.$_SERVER['PHP_SELF'].'">Volver al listado</a>';



		echo $page;
	}



	/**
	* Este metodo inserta un nuevo registro
	* Asume que en la base de datos no hay un campo llamado 'variablecontrolposnavegacion'
	*
	*
	*/
	function create(){
		$select = mysql_query('SELECT * FROM '.$this->table);
		$insert = "INSERT INTO ".$this->table." VALUES('',";
                
		$i = mysql_num_fields($select);
                //echo 'total: '.$i.'<br>';
		$i--;
		foreach($_POST as $key => $value){
    
			if($key != 'variablecontrolposnavegacion')
                        {
                            ($key == 'updated_at' || $key == 'created_at')? $value = 'NOW()' : (get_magic_quotes_gpc) ? $value =  "'".mysql_real_escape_string(stripslashes($value))."'" : $value = "'".mysql_real_escape_string($value)."'";
                            $i--;
                            
                            if($i > 0){
                                    //echo $i.'<br>';

                                    $value = $this->date_transform_usa($value);
                                    //echo $value;
                                
                                    $insert .= "'".strtoupper($value)."', ";
                            }elseif ($key != 'maestro_id') {$insert .= strtoupper($value).')';}
			}
		}
		//$insert .= strtoupper($value).')';
		//echo $insert;
		mysql_query($insert) or die(mysql_error());
		$last_idq = mysql_query('SELECT LAST_INSERT_ID()')or die(mysql_error());
		$last_id = mysql_fetch_array($last_idq);
		//echo $last_id[0];


		if(!empty($this->maestro_id)) {$where = " WHERE ".$this->tipo_comprobante."_maestro_id = ".$this->maestro_id;}

		$this->list_table('<div style="color:#090;"><p>Registro guardado..</p></div>',$where);
	}

	/**
	* Este metodo construye el formulario para editar registros
	* 
	*/
	function edit_row(){
		$page = '';
		$fields = mysql_query('SELECT * FROM '.$this->table) or die(mysql_error());
		$select = mysql_query('SELECT * FROM '.$this->table.' WHERE id = '.intval($_POST['id']));
		$row = mysql_fetch_row($select);
		$i = 0;
		echo '<h2>Formulario de carga de datos: <strong>'.$this->build_friendly_names(strtoupper(substr($this->table,0,-1))).'</strong></h2><br>';
		$page .= '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="crear" enctype="multipart/form-data" onsubmit="return creardescripcion()">'
				. '<input type="hidden" name="variablecontrolposnavegacion" value="update">'
		 		. '<table cellpadding="2" cellspacing="0" border="0" width="700">';
		while($i < mysql_num_fields($fields)){
			$field = mysql_fetch_field($fields);
			if($field->name != 'id'){
//				if (strpos($field->name, "fecha") !== false) { $clase = ':date_au :required';	}
//				else { $clase = ':required'; }
                                $clase = ':required'; 
				$page .= '<tr>';
				// reviso las claves foraneas..

				
				$posterior = substr($field->name, -11);
				$tabla     = $this->table;
				$cadena    = $field->name;
                                $comment   = DevuelveComentario($cadena, $tabla);
				$largo_pre = strlen($cadena) - strlen($posterior);
				$pre       = substr($cadena,0,$largo_pre);
				// echo $pre.' | ';
				
				if(($posterior == '_maestro_id') AND ($this->tipo_comprobante == $pre)){
					$page .= '<input type="hidden" name="'.$field->name.'" id="'.$field->name.'" value="'.$this->maestro_id.'"/>';					
				}elseif((substr($field->name, -3) == '_id') AND ($field->name != 'usuario_id') AND ($field->name != 'empresa_id')){
					$page .= $this->build_foreign_key_dropdowns($field->name, $row[$i]);  
                                }elseif(($this->usuario_nivel == 1) AND ($field->name == 'empresa_id')){
					$page .= $this->build_foreign_key_dropdowns($field->name);
				}elseif($field->blob == 1){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td> <textarea class="'.$clase.'" name="'.$field->name.'" id="'.$field->name.'" rows="5" cols="40">'.$row[$i].'</textarea></td>';
				}elseif($field->type == 'timestamp'){
					$page .= '<input type="hidden" name="'.$field->name.'" id="'.$field->name.'" value="'.date("Y-m-d H:i:s").'"/>';
					//$page .= '<td align="right"  width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'</td>';
				}elseif($field->type == 'date'){ $value_field = $this->date_transform_lat($row[$i]); 
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td><input type="text" class="calendario" name="'.$field->name.'" id="'.$field->name.'" value="'.$value_field.'" /></td>';
				}elseif($field->name == 'usuario_id'){
                                  /*borrar ->*/   $page .= '<input type="hidden" name="'.$field->name.'" id="'.$field->name.'" value="'.$this->usuario_id.'" />';
					//$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($column->name).':</strong></td><td></td>';
				}elseif($field->name == 'empresa_id'){
                                        $page .= '<input type="hidden" name="'.$field->name.'" id="'.$field->name.'" value="'.$this->empresa_id.'" />';
				}elseif($field->name == 'clave'){
					$page .= '<td align="right"  valign="top" width="200">(todo en mayusculas) <strong>'.$this->build_friendly_names($field->name).':</strong></td><td><input type="password" name="'.$field->name.'" id="'.$field->name.'" /></td>';
				}elseif($field->type == 'time'){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td><input type="text" name="'.$field->name.'" id="'.$field->name.'" class="timepickr" value="'.$row[$i].'" /></td>';
				}elseif($field->name == 'descripcion'){
					if($this->mostrar=='editable'){
					$page .= '<td align="right"  width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td><input class="'.$clase.'" class=":required" type="text" name="'.$field->name.'" id="'.$field->name.'" value="'.$row[$i].'" />';
					}else{
					$page .= '<input type="hidden" name="'.$field->name.'" id="'.$field->name.'" value="'.$row[$i].'" />';
					}
				}else{
					$page .= '<td align="right"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td> <input class="'.$clase.'" class=":required"  type="text" name="'.$field->name.'" id="'.$field->name.'" value="'.$row[$i].'" size="35" /></td>';
				}

			}else{
				$page .= '<td align="right"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'<input type="hidden" name="id" value="'.$row[$i].'"></td>';
			}
			$i++;
			$page .= '</tr>';
		}

              
                if(!empty($this->maestro_id)) {$input_maestro = '<input type="hidden" name="maestro_id" id="maestro_id" value="'.$this->maestro_id.'">';}
		$page .= '<tr><td>&nbsp;</td><td>
                          '.$input_maestro.'
			  <input type="submit" value="Guardar" /></td></tr>'
		 		. '</table>'
		 		. '</form><br><br>'
		 		. '<a href="'.$_SERVER['PHP_SELF'].'">Volver al listado</a>';                

		echo $page;
	}

	/**
	* This method updates the record
	*
	*/
	function update(){
		$select = mysql_query('SELECT * FROM '.$this->table.' WHERE id = '.intval($_POST['id']));
		$num = mysql_num_fields($select);
		$update = 'UPDATE '.$this->table.' SET ';
		$i = 1;
		$comma = '';
		while($i <= $num){
			$column = mysql_fetch_field($select);
			if($column->name != 'id' && $column->name != 'created_at' && $column->name != 'updated_at'){
					$update .= $comma.$column->name.' = ';
                                        
                                        $value = strtoupper($_POST["$column->name"]);
                                        //echo 'valor anterior: '.$value;
                                        $value = $this->date_transform_usa($value);
                                        //echo 'valor nuevo: '.$value.'   ';
					$update .= (get_magic_quotes_gpc) ? '\''.mysql_real_escape_string(stripslashes($value)).'\'' : '\''.mysql_real_escape_string($value).'\'';
					$comma =', ';
			}
			$i++;
		}
		$update .= '  WHERE id = '.intval($_POST['id']);
                //echo $update;
		mysql_query($update) or die(mysql_error());
		$this->list_table('<div style="color:#090;"><p>Registro modificado..</p></div>');
	}

	/**
	* Este metodo borra un registro
	*
	*/
	function delete_row(){
		mysql_query('DELETE FROM '.$this->table.' WHERE id = '.$_POST['id']);
                
                if (mysql_error() == true) echo "La operacion no se puede realizar. El registro esta asociado a otros datos. Verifique su accion<br><br>";

		if(!empty($this->maestro_id)) {$where = " WHERE ".$this->tipo_comprobante."_maestro_id = ".$this->maestro_id;}

		$this->list_table('<div style="color:#090;"><p>Registro borrado..</p></div>',$where);
	}
        
        

	/**
	* Muestra el registro en un formato ameno para imprimir
	*
	*/       

        
	function view_row(){
                if ($_POST['ver_relacion'] == 'SI') { 
                    $this->table = $_POST['tabla_relacion'];
                    $relacion_value = $_POST['id_value'];
                    $relacion_name  = $_POST['id_name'];
                    $id = DevuelveValor($relacion_value, 'id', $this->table, $relacion_name);
                    echo '
                        <form name="newrecord" id="newrecord" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline">
                        '.$input_maestro.'
                        <input type="hidden" name="variablecontrolposnavegacion" value="new">
                        <input type="hidden" name="table" value="'.$this->table.'">
                        <input type="hidden" name="ventananueva" value="si">
                        <a href="javascript:document.newrecord.submit()">
                        Registro nuevo
                        </a>
                        </form>
                        <br /><br />
                        ';
                    }
                   
                
                else {
                    $id = $_POST['id'];
                }
                
                $page = '';
		$fields = mysql_query('SELECT * FROM '.$this->table) or die(mysql_error());
		$select = mysql_query('SELECT * FROM '.$this->table.' WHERE id = '.intval($id));
		$row = mysql_fetch_row($select);
		$i = 0;
                  
              
		echo '<h2>Detalle de registro: <strong>'.$this->build_friendly_names(strtoupper(substr($this->table,0,-1))).'</strong></h2><br>';
		$page .= '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="crear" enctype="multipart/form-data">'
				. '<input type="hidden" name="variablecontrolposnavegacion" value="update">'
		 		. '<table cellpadding="2" cellspacing="0" border="0" width="700" bgcolor="#ffffff">';
		while($i < mysql_num_fields($fields)){
			$field = mysql_fetch_field($fields);
			if($field->name != 'id'){
                                                        
//				if (strpos($field->name, "fecha") !== false) { $clase = ':date_au :required';	}
//				else { $clase = ':required'; }
                                $clase = ':required'; 
				$page .= '<tr>';
				// reviso las claves foraneas..
				if(substr($field->name, -3) == '_id'){
                                        $campo = substr($field->name,0,-3);
                                        $tabla = $campo.'s';
                                        $valor_campo = DevuelveValor($row[$i], 'descripcion', $tabla, 'id');
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$valor_campo.'</td>';

				}elseif($field->blob == 1){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'</td>';
				}elseif($field->type == 'timestamp'){
					$page .= '<input type="hidden" name="'.$column->name.'" id="'.$column->name.'" value="'.date("Y-m-d H:i:s").'"/>';
					//$page .= '<td align="right"  width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'</td>';
				}elseif($field->type == 'date'){ $value_field = $this->date_transform_lat($row[$i]); 
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$value_field.'</td>';
				}elseif($field->type == 'time'){
					$page .= '<td align="right"  valign="top" width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'</td>';
				}elseif($field->name == 'descripcion'){
					if($this->mostrar=='editable'){
					$page .= '<td align="right"  width="200"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'</td>';
					}else{
					$page .= '<input type="hidden" name="'.$field->name.'" id="'.$field->name.'" value="'.$row[$i].'" />';
					}
				}else{
					$page .= '<td align="right"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].' </td>';
				}

			}else{
				$page .= '<td align="right"><strong>'.$this->build_friendly_names($field->name).':</strong></td><td>'.$row[$i].'<input type="hidden" name="id" value="'.$row[$i].'"></td>';
			}
			$i++;
			$page .= '</tr>';
		}
		$page .= '<tr><td>&nbsp;</td><td></td></tr>'
				 . '</table>'
				 . '</form>'
                                 . '<input type="button" name="imprimir" value="Imprimir" onclick="window.print();">';
                

		echo $page;
	}
        
        
        
        
        

	/**
	* Construye una busqueda para ser pasada a list_table
	*
	*/
	function search(){
		if(!empty($_POST['searchterm'])){
			// Seguridad
			$searchterm = (get_magic_quotes_gpc) ? '\''.mysql_real_escape_string(stripslashes($_POST['searchterm'])).'\'' : '\''.mysql_real_escape_string($_POST['searchterm']).'\'';

			$field = (get_magic_quotes_gpc) ? '\''.mysql_real_escape_string(stripslashes($_POST['field'])).'\'' : '\''.mysql_real_escape_string($_POST['field']).'\'';
			switch ($_POST['compare']){
				default:
					$compare = '1';
					$compare = NULL;
					$searchterm = NULL;
					break;
				case '=':
					$compare = ' = ';
					break;
				case '>':
					$compare = ' > ';
					break;
				case '<':
					$compare = ' < ';
					break;
				case 'LIKE':
					$compare = ' LIKE ';
					$searchterm = (get_magic_quotes_gpc) ? "'%".mysql_real_escape_string(stripslashes($_POST["searchterm"]))."%'" : "'%".mysql_real_escape_string($_POST["searchterm"])."%'";
					break;

			}
			$where = ' WHERE '.$_POST['field'].$compare.$searchterm;
		}else{
			$where = NULL;
		}
                
		$this->list_table('<div style="color:#090">Resultados de la b&uacute;squeda..</div>',$where);

	}


	/**
	* Genera selects est�ticos. Este se usa en el "editar fila"
	* **IMPORTANTE:**
	* Los nombres de las tablas deben terminar en s, las fk deben terminar en
	* _id y las tablas de las fk deben tener un campo 'descripcion'
	* Si ademas tienen un campo 'detalle', este es usado como title del
	* option
	*
	* string $field				// campo fk
	* string $value				// valor
	*/
	function build_foreign_key_dropdowns($field, $value = null) {
		// revisa las relaciones
		$match = FALSE;
		$dd = '';
		for($i=0; $i<count($this->singular); $i++){
			$match = preg_match('/^'.$this->singular[$i].'$/', substr($field, 0, -3));
			if($match){break;}
		}
		if($match){
			$foreignTable = str_replace($this->singular, $this->plural, substr($field, 0, -3));
		}else{
			// corta _id y pluraliza el nombre
			$foreignTable = substr($field, 0, -3);
			(substr($foreignTable, -1) != 'y') ? $foreignTable .= 's' : $foreignTable = substr($foreignTable, 0, -1).'ies';
		}
                
                $where_fk = ' WHERE empresa_id LIKE '.$this->empresa_id.' OR empresa_id = '.$this->control_admin;

                $sql_fk = 'SELECT * FROM '.$foreignTable.$where_fk;
                
                //echo $sql_fk;
                
		$select = mysql_query($sql_fk) or die(mysql_error());
                
		//$select = mysql_query('SELECT * FROM '.$foreignTable.' WHERE empresa_id = '.$this->empresa_id.' OR empresa_id = 14') or die(mysql_error());
		$foreign = mysql_fetch_assoc($select);
		$dd .= '<td align="right" ><strong>'.$this->build_friendly_names(substr($field, 0, -3)).'</strong></td><td>'
		. '<select name="'.$field.'">';
		do{
			$dd .= "<option title=\"".$foreign['detalle']."\"   value='".$foreign['id']."'";
			if ($foreign['id'] == $value){ $dd .= ' selected';}
			if (!empty($foreign['descripcion'])){
				$dd .= '>'.$foreign['descripcion'].'</option>';
			}else{
				$dd .= '>'.$foreign['id'].'</option>';
			}
		}while($foreign = mysql_fetch_assoc($select));
		$dd .= '</td>';
		return $dd;
	}



	/**
	* Genera los SELECT dinamicos. Dependen de la cantidad de datos de la
	* tabla
	* **IMPORTANTE:**
	* Los nombres de las tablas deben terminar en s, las fk deben terminar en
	* _id y las tablas de las fk deben tener un campo 'descripcion'
	* Si ademas tienen un campo 'detalle', este es usado como title del
	* option
	*
	* string $field				// campo fk
	* string $value				// valor
	*/
	function build_foreign_key_dropdowns_auto($field, $value = null) {
		// revisa las relaciones
		$match = FALSE;
		$dd = '';
		for($i=0; $i<count($this->singular); $i++){
			$match = preg_match('/^'.$this->singular[$i].'$/', substr($field, 0, -3));
			if($match){break;}
		}
		if($match){
			$foreignTable = str_replace($this->singular, $this->plural, substr($field, 0, -3));
		}else{
			// corta _id y pluraliza el nombre
			$foreignTable = substr($field, 0, -3);
			(substr($foreignTable, -1) != 'y') ? $foreignTable .= 's' : $foreignTable = substr($foreignTable, 0, -1).'ies';
		}
                               
                $sql_fk = 'SELECT * FROM '.$foreignTable;
                                
		$select = mysql_query($sql_fk) or die(mysql_error());
                
		$foreign = mysql_fetch_assoc($select);
		$totalrows = mysql_num_rows($select);
		
		$dd .= '<script type="text/javascript">
		$(function()
		{
			// Updated script
			var categories = $.map($("#s'.$field.' option"),function(e, i)
			{
			return e;
			});

			$("#my'.$field.'").autocomplete(categories,
			{
			matchContains : true,
			formatItem : function(item) { return item.text; }
			});
			// Added to fill hidden field with option value
			$("#my'.$field.'").result(function(event, item, formatted)
			{
			$("#'.$field.'").val(item.value);
			}
		)});
		</script>';
		$dd .= '<td align="right" ><strong>'.$this->build_friendly_names(substr($field, 0, -3)).'</strong></td><td>
		<input type="text" id="'.$field.'" name="'.$field.'" size="1" readonly="true"></input><input type="text" id="my'.$field.'" class=":required" size="31" title="Cantidad de registros: '.$totalrows.'"></input>'.'<select id="s'.$field.'" style="display: none">';

		do{
			$dd .= "<option title=\"".$foreign['detalle']."\"   value='".$foreign['id']."'";
			if ($foreign['id'] == $value){ $dd .= ' selected';}
			if (!empty($foreign['descripcion'])){
				$dd .= '>'.$foreign['descripcion'].'</option>';
			}else{
				$dd .= '>'.$foreign['id'].'</option>';
			}
		}while($foreign = mysql_fetch_assoc($select));
		$dd .= '</td>';
		return $dd;
		
	}




	/**
	* **IMPORTANTE:**
	* Los nombres de las tablas deben terminar en s, las fk deben terminar en
	* _id y las tablas de las fk deben tener un campo 'descripcion'
	*
	* string $field				// campo fk
	* string $value				// valor
	*/
	function build_foreign_key_title($field, $value) {
		// revisa las relaciones
		$match = FALSE;
		$dd = '';
		for($i=0; $i<count($this->singular); $i++){
			$match = preg_match('/^'.$this->singular[$i].'$/', substr($field, 0, -3));
			if($match){break;}
		}
		if($match){
			$foreignTable = str_replace($this->singular, $this->plural, substr($field, 0, -3));
		}else{
			// corta _id y pluraliza el nombre
			$foreignTable = substr($field, 0, -3);
			(substr($foreignTable, -1) != 'y') ? $foreignTable .= 's' : $foreignTable = substr($foreignTable, 0, -1).'ies';
		}
		$select = mysql_query("SELECT id, descripcion FROM $foreignTable WHERE id=$value") or die(mysql_error());
		$foreign = mysql_fetch_assoc($select);
		if (!empty($foreign['descripcion'])){
				//ESTO LO PODRÍA HACER CON LIGHTBOX JQUERY
                    $dd .='  
                        <form name="searchbar'.$foreign['id'].'" id="searchbar'.$foreign['id'].'" action="'.$foreignTable.'.php" method="post"  target="ventanaForm" onsubmit="window.open(\'\', \'ventanaForm\', \'width=1024,height=400,top=100,left=100,scrollbars=yes\')">
                        <input type="hidden" name="variablecontrolposnavegacion" value="search">
                        <input type="hidden" name="field" value="descripcion">
                        <input type="hidden" name="compare" value="=">
                        <input type="hidden" name="searchterm" value="'.$foreign['descripcion'].'">
                        <input type="submit" name="Search" value="(+)" class="boton_relacion" /> '.$foreign['descripcion'].'  
                        <input type="hidden" name="ventananueva" value="si"></form>';
		}else{
				$dd .= $foreign['id'];
		}
		while($foreign = mysql_fetch_assoc($select));
		return $dd;
	}

// <a href="#" onclick="document.searchbar'.$foreign['id'].'.submit();return false">'.$foreign['descripcion'].' - '.$foreign['id'].'</a>


	/**
	* Paginacion
	*
	* int $total 	// Numero total de filas de la tabla
	*
	*/
	function paginate($total = 1) {
		// paginacion
		if($total>$this->max_records){
		// Construye los links del recordset
		$num_pages = ceil($total / $this->max_records);
		$nav = '';

		// Link a la pagina previa si es necesario
		if($this->page > 1)
		$nav .= '<a href="'.$_SERVER['PHP_SELF'].'?page=' . ($this->page-1) . '">&lt;&lt; Anterior</a> |';

		for($i = 1; $i < $num_pages+1; $i++)
		{
		if($this->page == $i)
		{
		  //
		  $nav .= ' <strong>'.$i.'</strong> |';
		}
		else
		{
		  // Link a la pagina
		  $nav .= ' <a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> |';
		}
		}

		// Link a la pagina siguiente si es necesario
		if($this->page < $num_pages)
		$nav .= ' <a href="'.$_SERVER['PHP_SELF'].'?page=' . ($this->page+1) . '">Siguiente &gt;&gt;</a>';

		// Dibuja un pipe entre los numeros de pagina
		$nav = preg_replace('@|$@', "", $nav);
		echo $nav;
		}
	}

	/**
	* Barra de busqueda
	*
	*/
	function build_search_bar() {
		// Campos del menu
		$fielddropdown = '<select name="field">';
		$fieldselect = mysql_query('SHOW FIELDS FROM '.$this->table);
                $fielddropdown .= '<option value="descripcion">DESCRIPCION (por defecto)</option>';
                while($fields = mysql_fetch_assoc($fieldselect)){
			$fielddropdown .= '<option value="'.$fields['Field'].'">'.$this->build_friendly_names($fields['Field']).'</option>';
		}
		$fielddropdown .= '</select>';
		$searchterm = (!empty($_POST['searchterm'])) ? $_POST['searchterm'] : '' ;
		$search = '';
		$search .=  '<form name="searchbar" id="searchbar" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:inline;"><input type="hidden" name="variablecontrolposnavegacion" value="search">'
				. $fielddropdown
				. '<select name="compare">'
				. '<option value="LIKE">Contiene</option>'
                                . '<option value="=">Es igual a</option>'
				. '<option value="<">Es menor que</option>'
				. '<option value=">">Es mayor que</option>'
				. '</select>'
				. '<input type="text" name="searchterm" value ="'.$searchterm.'">'
				. '<input type="submit" name="Search" value="Buscar" />'
				. '</form><br /><br />';

		echo $search;

	}


	/**
	* Transforma los nombres de los campos en amistosos
	* Esto lo hace reemplazando el guion bajo por espacio y poniendo la primer
	* letra de cada palabra en mayusculas
	* string $field 	// pass the field name
	*
	*/
	function build_friendly_names($field) {
		return ucwords(str_replace('_', ' ', $field));
	}


	/**
	* Transforma una imagen en un dato blob para subirlo a la db
	*
	*/

	function image_transform_blob ($image) {

  		$mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
  		$name = $_FILES["$image"]["name"];
  		$type = $_FILES["$image"]["type"];
  		$tmp_name = $_FILES["$image"]["tmp_name"];
  		$size = $_FILES["$image"]["size"];

  		//Verifico si la imagen es valida
  		if(!in_array($type, $mimetypes))
    		die("El archivo no es una imagen v�lida");

		//Tomo la foto
		$fp = fopen($tmp_name, "rb");
  		$tfoto = fread($fp, filesize($tmp_name));
  		$tfoto = addslashes($tfoto);
  		fclose($fp);

		  // Borra archivos temporales si es que existen
		@unlink($tmp_name);

		return($tfoto);
	}


}
