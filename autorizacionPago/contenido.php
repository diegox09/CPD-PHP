<?php
	session_start();	
	if(!array_key_exists('id_ap', $_SESSION)) {
		header('Location: index.php');
	}		
?>	
<!DOCTYPE HTML>
<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Autorización de Pago</title>  
  	<link rel="shortcut icon" href="img/application_view_gallery.png" type="image/ico" />
  	<link rel="stylesheet" type="text/css" href="css/ui/jquery.ui.all.css" /> 
    <link rel="stylesheet" type="text/css" href="css/apprise.min.css" />
    <link rel="stylesheet" type="text/css" href="css/tablesorter.min.css" /> 
    <link rel="stylesheet" type="text/css" href="css/accordion.css" /> 
  	<link rel="stylesheet" type="text/css" href="css/contenido.css" />
  	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script> 
  	<script type="text/javascript" src="js/ui/jquery.ui.core.min.js"></script>
  	<script type="text/javascript" src="js/ui/jquery.ui.datepicker.min.js"></script> 
    <script type="text/javascript" src="js/apprise-1.5.min.js"></script>   
    <script type="text/javascript" src="js/tablesorter.min.js"></script> 
    <script type="text/javascript" src="js/accordion.js"></script> 
    <script type="text/javascript" src="js/numberformat.min.js"></script> 
  	<script type="text/javascript" src="js/contenido.js"></script>    
</head>
<body>	
	<div id="cargando">
    	<span>Cargando <img src="img/ajax-loader.gif" />
    </span></div>
    
    <div id="overlay" style="display:none"></div>    
      
	<div id="header">    	
    	<span id="nombre_user" ></span> 
    	<a id="salir" href="#" title="Salir de la aplicación">Salir</a>
  	</div> 
    
    <div id="corprodinco">
        <div style="width:20%">
            <img src="img/logo.png" height="70" />
        </div>
        <div style="width:80%">
            Corporación de Profesionales<br>
            para el Desarrollo Integral Comunitario<br> 
        </div>
    </div> 
          
	<div id="info">
    	<div id="overlay" style="display:none"></div>         
        <div class="minimo">
            <div class="menu">
                </br>
                <a href="#" id="cambiar_municipio"><img src="img/page_white_world.png" title="Cambiar Municipio" /></a>               
                <span id="municipio_user"></span>
                <input type="hidden" id="id_departamento_user" value="" />
                <input type="hidden" id="id_municipio_user" value="" />
                <div style="height:15px"></div>
                
                <div id="menu">
                </div>           
            </div>
            <div class="info">  
                <form id="form_buscar" action="#" method="get">  	
                	<input type="hidden" id="opc_buscar" name="opc" value="" />
                    <div class="div_buscar">
                    	<select id="programa_buscar" class="select_b" name="id_programa" label="PROGRAMA"></select>
                        <input type="text" id="buscar" class="input_b" name="buscar" value="" label="BUSCAR" required />
                        <a id="buscar_todo" class="boton_g" href="#" title="Buscar">Buscar</a>
                        <span id="error_buscar"></span>                    
                    </div>    
                </form>            
            </div>
        </div>   
        <div class="minimo"><!--Inicio minimo-->              
                <div class="info"><!--Inicio info--> 	
                    <div class="bordes"><!--Inicio bordes-->
                        <div class="header_form">
                            <span id="opcion_menu"></span>
                        </div> 
                        <input type="hidden" id="atras_departamento" value="" /> 
                        <input type="hidden" id="atras_municipio" value="" />  
                        <input type="hidden" id="atras_programa" value="" />
                        <input type="hidden" id="atras_barrio" value="" /> 
                        <input type="hidden" id="atras_persona" value="" /> 
                        
                        <div id="calidad"><!--Inicio Calidad-->                        	
                        	<div id="overlay_cambiar" style="display:none"></div>   
                            <form id="form_ap" action="#" method="get" style="display:none"><!--Incio form_ap-->
                            	<input type="hidden" id="id_ap" name="id_ap" value="" /> 
                                <input type="hidden" id="opc_ap" name="opc" value="" /> 
                                <div class="contenido_calidad">                                 	
                                    <div class="viii">
                                        <div>PROGRAMA:</div>
                                    </div>
                                    <div class="xv">
                                        <select id="programa_ap" class="select" name="id_programa" label="PROGRAMA" required ></select>                	
                                    </div>  
                                    <div class="iii">
                                        &nbsp;<a href="#" id="adicionar_programa_ap"><img src="img/add.png" title="Adicionar Programa" /></a>                            	
                                    </div>	                          
                                    <div class="xii">
                                        <div>SOLICITADO POR:</div>
                                    </div>
                                    <div class="xv">
                                        <select id="responsable_ap" class="select" name="id_responsable" label="SOLICITADO POR" required ></select>                 					</div>  
                                    <div class="iii">
                                        <a href="#" id="adicionar_responsable_ap"><img src="img/add.png" title="Adicionar Responsable" /></a>                            	
                                    </div>	
                                    <div class="vii">
                                        <div>CIUDAD:</div>
                                    </div>
                                    <div class="xv">
                                        <select id="municipio_ap" class="select" name="id_municipio" label="CIUDAD" required ></select>
                                    </div>  
                                    <div class="iii">
                                        <a href="#" id="adicionar_municipio_ap"><img src="img/add.png" title="Adicionar Municipio" /></a>                            	
                                    </div>
                                </div>
                                <div class="contenido_calidad"> 
                                    <div class="viii">
                                        <div>PROGRAMA:</div>
                                    </div>
                                    <div class="xviii">
                                        <input type="hidden" id="id_programa_ap" name="id_programa_ap" label="PROGRAMA" value="" />                                   		<input type="text" id="nombre_programa_ap" class="input_l" value="" disabled />
                                    </div>                    
                                    <div class="xii">
                                        <div>SOLICITADO POR:</div>
                                    </div>
                                    <div class="xviii">
                                        <input type="hidden" id="id_responsable_ap" name="id_responsable_ap" label="SOLICITADO POR" value="" />                        				<input type="text" id="nombre_responsable_ap" class="input_l" value="" disabled />
                                    </div> 
                                    <div class="vii">
                                        <div>CIUDAD:</div>
                                    </div>
                                    <div class="xvii">
                                        <input type="hidden" id="id_municipio_ap" name="id_municipio_ap" label="CIUDAD" value="" />                             		<input type="text" id="nombre_municipio_ap" class="input_l" value="" disabled />
                                    </div>
                                </div>                                                
                                <div class="contenido_calidad">
                                	<div class="xii">
                                        <div>CONSECUTIVO N°:</div>
                                    </div>
                                    <div class="iii">
                                    	&nbsp;
                                    	<input type="hidden" id="consecutivo_nuevo_ap" name="consecutivo" value="" />
                                    	<div id="consecutivo_ap"></div>                                        
                                    </div>
                                    <div class="iv">
                                    	&nbsp;
                                        <a href="#" id="cambiar_consecutivo_ap"><img src="img/note_edit.png" title="Cambiar Consecutivo" /></a>
                                    </div>
                                	<div class="vi">
                                        <div>FECHA:</div>
                                    </div>
                                    <div class="viii">
                                        <input type="text" id="fecha_ap" class="input_c" name="fecha" value="" maxlength="10" label="FECHA" required />    
                                    </div>
                                    <div class="ix">
                                        <div>A FAVOR DE:</div>
                                    </div>
                                    <div class="xix">
                                    	<input type="hidden" id="id_cliente_ap" name="id_cliente" label="A FAVOR DE" value="" />                                        <input type="text" id="nombre_cliente_ap" class="input_l" value="" disabled />    
                                    </div>
                                     <div class="iii">
                                        <a href="#" id="editar_cliente_ap"><img src="img/vcard_edit.png" title="Editar Cliente" /></a>
                                    </div>
                                    <div class="ii">
                                        <a href="#" id="cambiar_cliente_ap"><img src="img/delete.png" title="Cambiar Cliente" /></a>
                                    </div>                                   
                                    <div class="vi">
                                        <div>NIT/CC:</div>
                                    </div>
                                    <div class="ix">
                                        <input type="text" id="identificacion_cliente_ap" class="input_l" value="" disabled />                                    
                                    </div>
                                </div>       
                                <div class="contenido_calidad">
                                    <div class="viii">
                                        <div>CONCEPTO:</div>
                                    </div>
                                    <div class="lxxii">
                                    	<textarea id="concepto_ap" class="textarea_l" name="concepto" label="CONCEPTO" required></textarea>   	                
                                    </div>                                        
                                </div>
                                <div class="contenido_calidad" style="display:none">
                                	<div class="viii">
                                        <div>BANCO:</div>
                                    </div>
                                    <div class="xii">
                                        <input type="text" id="banco_ap" name="banco" class="input_c" value="" />
                                    </div>
                                    <div class="x">
                                        <div>TIPO CUENTA:</div>
                                    </div>
                                    <div class="xi">
                                        <select id="tipo_cuenta_ap" class="select" name="tipo_cuenta">
                                        	<option value="0" selected="selected"> - Seleccionar - </option>
                                            <option value="1" > Ahorros </option>
                                            <option value="2" > Corriente </option>
                                        </select>
                                    </div> 
                                    <div class="viii">
                                        <div>CUENTA N°:</div>
                                    </div>
                                    <div class="xii">
                                        <input type="text" id="numero_cuenta_ap" name="numero_cuenta" class="input_c" value="" />
                                    </div>
                                    <div class="vii">
                                        <div>ESTADO:</div>
                                    </div>
                                    <div class="xi">
                                        <select id="estado_ap" class="select" name="estado">
                                        	<option value="0" selected="selected"> - Seleccionar - </option>
                                            <option value="1" > Autorizado </option>
                                            <option value="2" > Pagado </option>
                                        </select>
                                    </div>                                                                        
                                </div> 
                                
                                <div class="contenido_calidad">
                                </div>
                                                                                                
                                <div class="contenido_calidad">
                                	<div class="iv">
                                    	&nbsp;<img id="informacion_ap" src="img/information.png" title="" />
                                    </div>
                                	<div class="iv">
                                    	&nbsp;<a id="ver_ap" href="#" target="_blank"><img src="img/page_white_acrobat.png" title="Ver Autorizacion" /></a>
                                    </div> 
                                    <div class="viii">
                                        <strong> NINGUNO </strong><input type="radio" id="tipo_pago_ap_n" name="tipo_pago" value="0" checked >
                                    </div>
                                    <div class="vii">
                                        <strong> CHEQUE </strong><input type="radio" id="tipo_pago_ap_c" name="tipo_pago" value="1">
                                    </div>
                                    <div class="xii">
                                          <strong> TRANSFERENCIA </strong><input type="radio" id="tipo_pago_ap_t" name="tipo_pago" value="2">
                                    </div>                                                                     
                                    <div class="xxv">
                                    	<div id="error_ap"></div>
                                    </div>                                
                                    <div class="iii">
                                    	&nbsp;<a id="desbloquear_ap" href="#"><img src="img/lock.png" title="Desbloquear Autorizacion" /></a>
                                    </div>
                                    <div class="ix">
                                        <div class="botones"> 
                                             <a id="cancelar_ap" class="boton_c" href="#" title="Cancelar">Cancelar</a>
                                        </div>    
                                    </div>     
                                    <div class="ix"> 
                                        <div class="botones">
                                            <a id="guardar_ap" class="boton_g" href="#" title="Guardar Autorizacion de Pago">Guardar</a>
                                        </div>    
                                    </div> 
                                </div>
                           	</form><!--Fin form_ap-->  
                                                                                       
                            <form id="form_item_ap" action="#" method="get" style="display:none"><!--Incio form_item_ap-->
                            	<input type="hidden" id="id_ap_item_ap" name="id_ap" value="" /> 
                                <input type="hidden" id="id_item_ap" name="item_ap" value="" /> 
                                <input type="hidden" id="opc_item_ap" name="opc" value="" /> 
                                <div class="contenido_negrita">
                                    CONTABILIZACION	
                                </div> 
                                <table cellspacing="1" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th width="15%">CHEQUE / TRANSFERENCIA</th>
                                            <th width="15%">COMPROBANTE DE EGRESO</th>
                                            <th width="43%">DESCRIPCION</th>
                                            <th width="10%">CENTRO COSTOS</th>
                                            <th width="15%">VALOR</th>
                                            <th width="2%"></th>
                                        </tr>
                                        <tr> 
                                            <th>
                                                <input type="text" id="numero_pago_ap" class="input_c" name="numero_pago" value="" maxlength="15" label="NUMERO DE PAGO" />
                                            </th>
                                            <th>
                                                <input type="text" id="comprobante_egreso_ap" class="input_c" name="comprobante_egreso" value="" maxlength="15" label="COMPROBANTE DE EGRESO" />
                                            </th>
                                            <th>
                                                <input type="text" id="descripcion_pago_ap" class="input_l" name="descripcion_pago" value="" maxlength="100" label="DESCRIPCION" required />
                                            </th>
                                            <th>
                                                <input type="text" id="centro_costo_ap" class="input_c" name="centro_costo" value="" maxlength="10" label="CENTRO DE COSTO" required />
                                            </th>
                                            <th>
                                                <input type="text" id="valor_pago_ap" class="input_d" name="valor_pago" value="" maxlength="15" label="VALOR" required />
                                            </th>
                                            <th>
                                                <a href="#" id="guardar_item_ap"><img src="img/disk.png" title="Guardar Registro" /></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_item_ap">                                      
                                    </tbody>
                                    <tfoot>
                                    	<tr>
                                            <th colspan="3"><div id="error_item_ap"></div></th>
                                            <th class="derecha">Subtotal</th>                                            
                                            <th class="derecha">
                                            	<input type="hidden" id="number_format_ap" value="" maxlength="15"/>
                                            	<span id="subtotal_ap"></span>
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                        	<th colspan="2" class="derecha">
                                            	Iva descontable 
                                            	<input type="checkbox" id="sumar_iva" name="sumar_iva" title="" value="1"/>
                                            </th>
                                            <th class="derecha">IVA</th>
                                            <th>
                                                <input type="text" id="iva_ap" class="input_d" name="iva" value="" maxlength="15" label="IVA" />
                                            </th>
                                            <th class="derecha">
                                                <input type="text" id="valor_iva_ap" class="input_d" name="valor_iva" value="" maxlength="15" label="IVA" />
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="derecha">Ret. IVA</th>
                                            <th>
                                                <input type="text" id="retencion_iva_ap" class="input_d" name="retencion_iva" value="" maxlength="5" label="Ret. IVA" />
                                            </th>
                                            <th class="derecha">
                                                <input type="text" id="valor_retencion_iva_ap" class="input_d" name="valor_retencion_iva" value="" maxlength="15" label="Ret. IVA" />
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="derecha">Retención en la Fuente</th>
                                            <th>
                                                <input type="text" id="retencion_fuente_ap" class="input_d" name="retencion_fuente" value="" maxlength="5" label="Retención en la Fuente" />
                                            </th>
                                            <th>
                                                <input type="text" id="valor_retencion_fuente_ap" class="input_d" name="valor_retencion_fuente" value="" maxlength="15" label="Retención en la Fuente" />
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="derecha">Ret. ICA</th>
                                            <th>
                                                <input type="text" id="retencion_ica_ap" class="input_d" name="retencion_ica" value="" maxlength="7" label="Ret. ICA" />
                                            </th>
                                            <th class="derecha">
                                                 <input type="text" id="valor_retencion_ica_ap" class="input_d" name="valor_retencion_ica" value="" maxlength="15" label="Ret. ICA" />
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                        	<th colspan="3"></th>
                                            <th class="derecha">Total</th>
                                            <th class="derecha"><span id="total_ap"></span></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>      
                                </table>
                            </form><!--Fin form_item_ap--> 
                            
                            <form id="form_programa" action="#" method="get" style="display:none"><!--Incio form_programa-->			                    		<input type="hidden" id="opc_programa" name="opc" value="" />   
                                <input type="hidden" id="id_programa" name="id_programa" value="" /> 
                                <div class="form_generico"> 
                                    <div class="header_generico">
                                        <a href="#" id="nuevo_programa" title="Programa Nuevo">PROGRAMA</a>
                                    </div>                                  
                                    <div>
                                        <div class="label">PROGRAMA:</div> 
                                        <div class="info_generica">
                                            <input type="text" id="nombre_programa" class="input_l" name="nombre" value="" maxlength="40" label="PROGRAMA" required />
                                        </div>
                                        <div class="clear"></div>
                                        <div class="label">DESCRIPCION:</div> 
                                        <div class="info_generica">
                                            <input type="text" id="descripcion_programa" class="input_l" name="descripcion" value="" maxlength="30" label="DESCRIPCION" />
                                        </div> 
                                        <div class="clear"></div>
                                        <div class="label">MUNICIPIO:</div>                                
                                        <div class="info_generica">
                                            <select id="municipio_programa" class="select" name="id_municipio" label="MUNICIPIO" ></select>
                                        </div> 
                                        <div class="add">
                                            <a href="#" id="adicionar_municipio_prog"><img src="img/add.png" title="Adicionar Municipio" /></a>
                                        </div> 
                                        <div class="clear"></div>
                                        <div class="botones">                                    	
                                            <a id="cancelar_programa" class="boton_c" href="#" title="Cancelar">Cancelar</a>
                                            <a id="eliminar_programa" class="boton_e" href="#" title="Eliminar Programa">Eliminar</a>                                                                     
                                            <a id="guardar_programa" class="boton_g" href="#" title="Guardar Programa">Guardar</a>                                                                              
                                        </div>
                                        <div class="mensaje">
                                            <div id="error_programa">
                                            </div>                                	
                                        </div> 
                                    </div>            
                                </div>        
                            </form><!--Fin form_programa-->  
                            
                            <form id="form_departamento" action="#" method="get" style="display:none"><!--Incio form_departamento-->		
                                <input type="hidden" id="opc_departamento" name="opc" value="" />   
                                <input type="hidden" id="id_departamento" name="id_departamento" value="" /> 	
                                <div class="form_generico"> 
                                    <div class="header_generico">
                                        <a href="#" id="nuevo_departamento" title="Departamento Nuevo">DEPARTAMENTO</a>
                                    </div> 
                                    <div>
                                        <div class="label">DEPARTAMENTO:</div>
                                        <div class="info_generica">
                                            <input type="text" id="nombre_departamento" class="input_l" name="nombre" value="" maxlength="20" label="DEPARTAMENTO" required />
                                        </div> 
                                        <div class="clear"></div> 
                                        <div class="botones">
                                            <a id="cancelar_departamento" class="boton_c" href="#" title="Cancelar">Cancelar</a>
                                            <a id="eliminar_departamento" class="boton_e" href="#" title="Eliminar Departamento">Eliminar</a>
                                            <a id="guardar_departamento" class="boton_g" href="#" title="Guardar Departamento">Guardar</a>    
                                        </div>
                                        <div class="mensaje">
                                            <div id="error_departamento">
                                            </div>                                	
                                        </div>  
                                    </div>            
                                </div>        
                            </form><!--Fin form_departamento-->  
                            
                            <form id="form_municipio" action="#" method="get" style="display:none"><!--Incio form_municipio-->			                    		
                            	<input type="hidden" id="opc_municipio" name="opc" value="" />   
                                <input type="hidden" id="id_municipio" name="id_municipio" value="" /> 
                                <div class="form_generico"> 
                                    <div class="header_generico">
                                        <a href="#" id="nuevo_municipio" title="Municipio Nuevo">MUNICIPIO</a>
                                    </div> 
                                    <div> 
                                        <div class="label">MUNICIPIO:</div> 
                                        <div class="info_generica">
                                            <input type="text" id="nombre_municipio" class="input_l" name="nombre" value="" maxlength="20" label="MUNICIPIO" required />
                                        </div>
                                        <div class="clear"></div>                                    
                                        <div class="label">DEPARTAMENTO:</div>
                                        <div class="info_generica">
                                            <select id="departamento_municipio" class="select" name="id_departamento" label="DEPARTAMENTO" ></select>                     
                                        </div>
                                        <div class="add">
                                            <a href="#" id="adicionar_departamento_municipio"><img src="img/add.png" title="Adicionar Departamento" /></a>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="botones">
                                            <a id="cancelar_municipio" class="boton_c" href="#" title="Cancelar">Cancelar</a>                            
                                            <a id="eliminar_municipio" class="boton_e" href="#" title="Eliminar Municipio">Eliminar</a>
                                            <a id="guardar_municipio" class="boton_g" href="#" title="Guardar Municipio">Guardar</a>    
                                        </div>
                                        <div class="mensaje">
                                            <div id="error_municipio">
                                            </div>                                	
                                        </div>  
                                    </div>            
                                </div>        
                            </form><!--Fin form_municipio-->    
                            
                            <form id="form_barrio" action="#" method="get" style="display:none"><!--Incio form_barrio-->
                                <input type="hidden" id="opc_barrio" name="opc" value="" />   
                                <input type="hidden" id="id_barrio" name="id_barrio" value="" />
                                <div class="form_generico">
                                    <div class="header_generico">
                                        <a href="#" id="nuevo_barrio" title="Barrio Nuevo">BARRIO</a>
                                    </div>
                                    <div>
                                        <div class="label">BARRIO:</div>
                                        <div class="info_generica">  
                                            <input type="text" id="nombre_barrio" class="input_l" name="nombre" value="" maxlength="20" label="BARRIO" required />
                                        </div>                          
                                        <div class="clear"></div> 
                                        <div class="label">MUNICIPIO:</div>
                                        <div class="info_generica">       	
                                            <select id="municipio_barrio" class="select" name="id_municipio" label="MUNICIPIO"></select>
                                        </div>
                                        <div class="add">
                                            <a href="#" id="adicionar_municipio_barrio"><img src="img/add.png" title="Adicionar Municipio" /></a>
                                        </div>
                                        <div class="clear"></div>      
                                        <div class="botones">           
                                            <a id="cancelar_barrio" class="boton_c" href="#" title="Cancelar">Cancelar</a>                         	
                                            <a id="eliminar_barrio" class="boton_e" href="#" title="Eliminar Barrio">Eliminar</a>
                                            <a id="guardar_barrio" class="boton_g" href="#" title="Guardar Barrio">Guardar</a>                             
                                        </div> 
                                        <div class="mensaje">
                                            <div id="error_barrio">
                                            </div>                                	
                                        </div> 
                                    </div>            
                                </div>      
                            </form><!--Fin form_barrio-->
                            
                            <form id="form_persona" action="#" method="get" style="display:none"><!--Incio form_persona-->
                                <input type="hidden" id="opc_persona" name="opc" value="" />   
                                <input type="hidden" id="id_persona" name="id_persona" value="" />
                                <div class="form_doble">
                                    <div class="header_generico">
                                        <a href="#" id="nuevo_persona" title="Persona Nueva">INFORMACION PERSONAL</a>
                                    </div>
                                    <div class="div">
                                        <div class="info_doble">      
                                            <div class="label">NOMBRE:</div>
                                            <div class="info_generica">    
                                                <input type="text" id="nombre_persona" class="input_l" name="nombre" value="" maxlength="50" label="NOMBRE" required />
                                            </div>                
                                        </div>                                    
                                         <div class="add">
                                        </div>
                                        <div class="info_doble">      
                                            <div class="label">IDENTIFICACION:</div>
                                            <div class="info_generica">    
                                                <input type="text" id="identificacion_persona" class="input_l" name="identificacion" value="" maxlength="19" label="IDENTIFICACION" required />
                                            </div>                
                                        </div>
                                        <div class="add"></div>                                    
                                        <div class="info_doble">      
                                            <div class="label">TELEFONO:</div>
                                            <div class="info_generica">    
                                                <input type="text" id="telefono_persona" class="input_l" name="telefono" value="" maxlength="10" label="TELEFONO" />
                                            </div>                
                                        </div>
                                        <div class="add"></div>
                                        <div class="info_doble">      
                                            <div class="label">CELULAR:</div>
                                            <div class="info_generica">    
                                                <input type="text" id="celular_persona" class="input_l" name="celular" value="" maxlength="10" label="CELULAR" />
                                            </div>                
                                        </div>                 
                                        <div class="add"></div>                                    
                                        <div class="info_doble">      
                                            <div class="label">DIRECCION:</div>
                                            <div class="info_generica">    
                                                <input type="text" id="direccion_persona" class="input_l" name="direccion" value="" maxlength="50" label="DIRECCION" />
                                            </div>                
                                        </div>         
                                        <div class="add"></div> 
                                        <div class="info_doble"> 
                                            <div class="label">BARRIO:</div>
                                            <div class="info_generica">       	
                                                <select id="barrio_persona" class="select" name="id_barrio" label="BARRIO"></select>
                                            </div>
                                        </div>    
                                        <div class="add">
                                            <a href="#" id="adicionar_barrio_persona"><img src="img/add.png" title="Adicionar Municipio" /></a>
                                        </div>                                         
                                        <div class="info_doble">      
                                            <div class="label">EMAIL:</div>
                                            <div class="info_generica">    
                                                <input type="text" id="email_persona" class="input_l" name="email" value="" maxlength="50" label="EMAIL" />
                                            </div>                
                                        </div>
                                        <div class="clear"></div>
                                        <div class="botones">
                                             <a id="cancelar_persona" class="boton_c" href="#" title="Atras">Atras</a>
                                             <a id="eliminar_persona" class="boton_e" href="#" title="Eliminar Persona">Eliminar</a>
                                             <a id="guardar_persona" class="boton_g" href="#" title="Guardar Persona">Guardar</a>               
                                        </div>
                                    </div>  
                                    <div class="mensaje">
                                        <div id="error_persona">
                                        </div>                                	
                                    </div>    
                                </div>      
                            </form><!--Fin form_persona-->
                            
                            <form id="form_usuario" action="#" method="get" style="display:none"><!--Incio form_usuario-->
                                <input type="hidden" id="opc_usuario" name="opc" value="" />   
                                <input type="hidden" id="id_usuario" name="id_usuario" value="" label="SELECCIONE UN USUARIO" required />
                                <div class="form_doble">
                                    <div class="header_generico">
                                        <a href="#" id="nuevo_usuario" title="Usuario Nuevo">USUARIO</a>
                                    </div>
                                    <div class="div">
                                        <div class="info_doble">      
                                            <div class="label">NOMBRE:</div>
                                            <div class="info_generica">                                        	 
                                                <input type="text" id="nombre_usuario" class="input_l" name="nombre" value="" maxlength="50" label="NOMBRE" />
                                            </div>                
                                        </div>                                    
                                        <div class="add">
                                            <a href="#" id="modificar_persona_usuario"><img src="img/vcard_edit.png" title="Modificar Persona" /></a>                                       
                                        </div>                                    
                                        <div class="info_doble">      
                                            <div class="label">USUARIO:</div>
                                            <div class="info_generica">    
                                                <input type="text" id="usuario" class="input_l" name="user" value="" maxlength="15" label="USUARIO" required />
                                            </div>                
                                        </div>
                                        <div class="add"></div>
                                        <div class="info_doble">  
                                            <div class="label">PERFIL:</div>
                                            <div class="info_generica">       	
                                                <select id="perfil_usuario" class="select" name="id_perfil" label="PERFIL" required ></select>
                                            </div>
                                        </div>  
                                        <div class="clear"></div>
                                         <div class="info_doble"> 
                                            <div class="label">MUNICIPIO:</div>
                                            <div class="info_generica">
                                                <select id="municipio_usuario" class="select" name="id_municipio" label="MUNICIPIO" ></select>                     
                                            </div>  
                                        </div>  
                                        <div class="add">
                                                <a href="#" id="adicionar_municipio_usuario"><img src="img/add.png" title="Adicionar Municipio" /></a>
                                        </div>
                                        <div class="info_doble">                                            
                                            <div class="label">PROGRAMA X USUARIO:</div>
                                            <div class="info_generica">
                                                <select id="programa_registrado_usuario" class="select" name="id_programa_registrado" label="PROG. REGISTRADO" ></select>                     
                                            </div>
                                        </div>    
                                        <div class="add">
                                        	<a href="#" id="eliminar_programa_usuario"><img src="img/table_row_delete.png" title="Eliminar Programa" /></a>
                                        </div>
                                        <div class="info_doble"> 
                                            <div class="label">PROGRAMAS:</div>
                                            <div class="info_generica">
                                                <select id="programa_usuario" class="select" name="id_programa" label="PROGRAMA" ></select>                     
                                            </div>  
                                        </div>  
                                        <div class="add">
                                                <a href="#" id="adicionar_programa_usuario"><img src="img/table_row_insert.png" title="Adicionar Programa" /></a>
                                        </div>                               
                                        <div class="clear"></div>
                                        <div class="botones">
                                             <a id="cancelar_usuario" class="boton_c" href="#" title="Cancelar">Cancelar</a>
                                             <a id="eliminar_usuario" class="boton_e" href="#" title="Eliminar Usuario">Eliminar</a>
                                             <a id="guardar_usuario" class="boton_g" href="#" title="Guardar Usuario">Guardar</a>               
                                        </div>
                                    </div>  
                                    <div class="mensaje">
                                        <div id="error_usuario">
                                        </div>                                	
                                    </div>    
                                </div>      
                            </form><!--Fin form_usuario-->
                            
                             <form id="form_passwd" action="#" method="get" style="display:none"><!--Incio form_passwd-->	
                             	<input type="hidden" id="opc_passwd" name="opc" value="" />  
                                <div class="form_generico"> 
                                    <div class="header_generico">
                                        CAMBIAR CONTRASE�&#145;A
                                    </div> 
                                    <div>
                                    	<div class="label">EMAIL USUARIO:</div>
                                        <div class="info_generica">
                                            <input type="text" id="email_user" class="input_l" name="email" value="" maxlength="50" label="EMAIL" required />
                                        </div> 
                                        <div class="clear"></div> 
                                        <div class="label">PASSWORD ACTUAL:</div>
                                        <div class="info_generica">
                                            <input type="password" id="passwd_actual" class="input_l" name="passwd_actual" value="" maxlength="15" label="CONTRASE�&#145;A ACTUAL" required />
                                        </div>  
                                        <div class="clear"></div>
                                        <div class="label">PASSWORD NUEVO:</div>
                                        <div class="info_generica">
                                            <input type="password" id="passwd_nuevo" class="input_l" name="passwd_nuevo" value="" maxlength="15" label="CONTRASE�&#145;A NUEVA" required />
                                        </div> 
                                        <div class="clear"></div>
                                        <div class="botones">
                                            <a id="cancelar_passwd" class="boton_c" href="#" title="Cancelar">Cancelar</a>                                           
                                            <a id="guardar_passwd" class="boton_g" href="#" title="Cambiar Contraseña">Cambiar</a>    
                                        </div>
                                        <div class="mensaje">
                                            <div id="error_passwd">
                                            </div>                                	
                                        </div>  
                                    </div>            
                                </div>        
                            </form><!--Fin form_passwd--> 
                            
                            <form id="form_responsable" action="#" method="get" style="display:none"><!--Incio form_responsable-->
                                <input type="hidden" id="opc_responsable" name="opc" value="" />   
                                <input type="hidden" id="id_responsable" name="id_responsable" value="" label="SELECCIONE UN FUNCIONARIO"/>
                                <div class="form_generico">
                                    <div class="header_generico">
                                        <a href="#" id="nuevo_responsable" title="Responsable Nuevo">FUNCIONARIO</a>
                                    </div>
                                    <div class="div"> 
                                        <div class="add"></div>                                       
                                        <div class="label">NOMBRE:</div>
                                        <div class="info_generica"> 
                                            <input type="text" id="nombre_responsable" class="input_l" name="nombre" value="" maxlength="50" label="NOMBRE" required />
                                        </div>     
                                        <div class="add">
                                            <a href="#" id="modificar_persona_responsable"><img src="img/vcard_edit.png" title="Modificar Persona" /></a>                                      
                                        </div> 
                                        <div class="clear"></div>                                  
                                        <div class="label">PROGRAMA X FUNC.:</div>
                                        <div class="info_generica">
                                            <select id="programa_registrado_responsable" class="select" name="id_programa_registrado" label="PROG. REGISTRADO" required ></select>                     
                                        </div>                                          
                                        <div class="clear"></div>                                  
                                        <div class="label">PROGRAMAS:</div>
                                        <div class="info_generica">
                                            <select id="programa_responsable" class="select" name="id_programa" label="PROGRAMA" required ></select>                     
                                        </div>  
                                         <div class="add">
                                            <a href="#" id="adicionar_programa_responsable"><img src="img/add.png" title="Adicionar Programa" /></a>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="botones">                                        
                                            <a id="cancelar_responsable" class="boton_c" href="#" title="Cancelar">Cancelar</a>                                        
                                            <a id="eliminar_responsable" class="boton_e" href="#" title="Eliminar Funcionario">Eliminar</a>
                                            <a id="guardar_responsable" class="boton_g" href="#" title="Guardar Funcionario">Guardar</a>
                                        </div>
                                    </div>  
                                    <div class="mensaje">
                                        <div id="error_responsable">
                                        </div>                                	
                                    </div>    
                                </div>       
                            </form><!--Fin form_responsable-->
                            
                            <form id="form_cambiar" action="#" method="get" style="display:none"><!--Incio form_cambiar-->			                    		
                            	<div class="form_generico"> 
                                    <div class="header_generico">
                                        <a href="#">CAMBIAR MUNICIPIO</a>
                                    </div>                                  
                                    <div>
                                        <div class="label">DEPARTAMENTO:</div>
                                        <div class="info_generica">
                                            <select id="departamento_cambiar" class="select" name="id_departamento" label="DEPARTAMENTO" ></select>                     
                                        </div>
                                        <div class="clear"></div>
                                        <div class="label">MUNICIPIO:</div>                                
                                        <div class="info_generica">
                                            <select id="municipio_cambiar" class="select" name="id_municipio" label="MUNICIPIO" ></select>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="botones">                                    	
                                            <a id="cancelar_cambiar" class="boton_c" href="#" title="Cancelar">Cancelar</a>                                    </div>
                                        <div class="mensaje">                                        
                                        </div> 
                                    </div>            
                                </div>        
                            </form><!--Fin form_cambiar-->
                                                    
                            <div id="lista_ap" style="display:none">
                            	<table id="tabla_ap" cellspacing="1" class="tablesorter" >
                                </table>
                            </div>
                            
                            <div id="lista_pqrs" style="display:none">
                            	<table id="tabla_pqrs" cellspacing="1" class="tablesorter" >
                                	<thead>
                                        <tr>
                                            <th width="3%"></th>
                                            <th width="12%">No.</th>
                                            <th width="20%">Programa</th>
                                            <th width="20%">Solicitante</th>
                                            <th width="20%">Direccionado a</th>
                                            <th width="25%">Descripcion</th>
                                        </tr>
                                    </thead>    
                                    <tbody>
                                	</tbody>        
                                </table>
                            </div>
                            
                            <div id="mostrar">          
                                <table id="tabla" cellspacing="1" class="tablesorter" ></table>
                            </div> 
                        </div><!--Fin Calidad-->   
                        
                        <div class="clear"></div>             
                    </div><!--Fin bordes--> 
                    <div class="clear" style="height:40px">&nbsp;</div>
                    <div id="footer">                	
                        <a href="http://www.corprodinco.org" target="_blank">&copy; 2011 - Corprodinco</a>
                        &nbsp;|&nbsp;
                        <a href="../">Inicio</a>
                    </div> 
                </div><!--Fin info-->
        </div><!--Fin minimo-->               
    </div> 
       
    <div class="espacio"></div>    
    
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a> 
            &nbsp;|&nbsp;        	
        	<a href="../">SGC</a> 
            &nbsp;|&nbsp;            
        	<a href="administracion.php">Administracion</a>
     	</div>       
    </div> 
    
    <div id="error"></div>
</body>
</html>
