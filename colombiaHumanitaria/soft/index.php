<?php
	session_start();	
	if(!array_key_exists('id_hu', $_SESSION)) {
		header('Location: ../');
	}		
?>	
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Colombia Humanitaria</title>  
  	<link rel="shortcut icon" href="img/application_view_gallery.png" type="image/ico" />
  	<link rel="stylesheet" type="text/css" href="css/ui/jquery.ui.all.css" />  
  	<link rel="stylesheet" type="text/css" href="css/index.css" />
  	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script> 
  	<script type="text/javascript" src="js/ui/jquery.ui.core.min.js"></script>
  	<script type="text/javascript" src="js/ui/jquery.ui.datepicker.min.js"></script>
  	<script type="text/javascript" src="js/index.js"></script>
</head>
<body>
	<div id="overlay" style="display:none"></div>
	<div id="cargando"><span>Cargando <img src="img/ajax-loader.gif" /></span></div>
    <div id="error"></div>
      
	<div id="header">    	
    	<a href="#" id="nombre_user" title=""></a>
        <input type="hidden" id="perfil" name="perfil" value="" />  
    	<a id="salir" href="#" title="Salir de la aplicación">Salir</a> 
        <img src="img/corprodinco.jpg" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       
   		<img src="img/logo_colombia_humanitaria.jpg" />       
  	</div>  
          
	<div id="contenido">
    	<div id="resultados" style="display:none">
            <table id="tabla">                  
            </table>
        </div>
        
    	<div class="info">
            <div class="formulario">
            	<div class="header_info">
                    <a href="#" id="resultado" title="Ocultar - Mostrar : Resultados">BUSCAR</a>
                </div>
                <form id="form_buscar" action="#" method="get">  
                    <input type="text" id="input_buscar" class="input_buscar" name="buscar" value="" title="Buscar Damnificado" label="Digite el numero de documento o nombre del damnificado"/> 
                    <input type="submit" id="buscar" class="boton_azul" value="Buscar" title="Buscar Damnificado"/>
                    &nbsp;&nbsp;&nbsp;
                    <strong><label for="arrendador" title="Buscar Arrendador" >Arr.</label></strong>
                    <input type="checkbox" id="arrendador" name="arrendador" title="Buscar Arrendador" value="1"/>
                </form>
                <div class="clear"></div>
            </div>
            <div class="formulario">
                <div class="header_info">
                    <a href="#" id="limpiar" title="Limpiar Formularios">INFORMACION DEL DAMNIFICADO</a>&nbsp;&nbsp;
                    <select id="fase" class="select_c" name="fase" >
                        <option value="1" > Fase 1 </option>
                        <option value="2" > Fase 2 </option>
                        <option value="3" > Fase 3 </option>
                    </select>&nbsp;&nbsp;
                    <a href="#" id="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_damnificado" action="#" method="get"> 
                    <input type="hidden" id="id_damnificado" name="id_damnificado" value="" label="Por favor seleccione un damnificado" />
                    <input type="hidden" id="opc_damnificado" name="opc" value="" />
                    <input type="hidden" id="fase_damnificado" name="fase" value="" />
                    <div class="clear"> 
                        <label for="td">Tipo Documento</label><br>
                        <select id="td" name="td">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1" selected="selected"> Cedula de Ciudadania </option>
                            <option value="2" > Tarjeta de Identidad </option>
                        </select> 
                    </div>        
                    <div>
                        <label for="documento_damnificado">No. Doc. del Damnificado</label>
                        <input type="text" name="documento" id="documento_damnificado" value="" label="Por favor digite el numero de documento" />   
                    </div>       
                    <div class="clear">
                        <label for="primer_nombre">Primer Nombre</label>
                        <input type="text" name="primer_nombre" id="primer_nombre" value="" label="Por favor digite el primer nombre del damnificado" />           
                    </div>  
                    <div>
                        <label for="segundo_nombre">Segundo Nombre</label>
                        <input type="text" name="segundo_nombre" id="segundo_nombre" value="" />   
                    </div> 
                    <div class="clear">
                        <label for="primer_apellido">Primer Apellido</label>
                        <input type="text" name="primer_apellido" id="primer_apellido" value="" />
                    </div> 
                    <div>
                        <label for="segundo_apellido">Segundo Apellido</label>
                        <input type="text" name="segundo_apellido" id="segundo_apellido" value="" />   
                    </div> 
                    <div class="clear"> 
                        <label for="genero">Genero</label><br>
                        <select id="genero" name="genero" >
                            <option value="0" selected="selected"> - Seleccionar - </option>
                            <option value="1" > Masculino </option>
                            <option value="2" > Femenino </option>
                        </select> 
                    </div>
                    <div>
                        <label for="telefono_damnificado">Telefono</label>
                        <input type="text" name="telefono" id="telefono_damnificado" value="" />   
                    </div>        
                    <div class="clear">
                        <label for="direccion_damnificado">Direccion de la Vivienda Actual</label>
                        <input type="text" name="direccion" id="direccion_damnificado" value="" />           
                    </div>         
                    <div>
                        <label for="barrio">Albergue o Barrio</label>
                        <input type="text" name="barrio" id="barrio" value="" />   
                    </div> 
                    <div class="clear">
                    	<div class="label_l">
                        	<label for="observaciones_damnificado">
                            	<strong>Observaciones,</strong>
                                Fecha:<span id="fecha_observaciones_damnificado"></span>
                                : <span id="usuario_observaciones_damnificado"></span>
                            </label>
                        </div>
                        <textarea name="observaciones" id="observaciones_damnificado" value="" ></textarea>
                    </div>        
                    <div class="clear">
                        <input type="submit" id="guardar_damnificado" class="boton_gris" value="Guardar" title="Guardar Damnificado" style="display:none"/>                        
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="entregas_nuevo" class="boton_gris" value="Entregas" title="Adicionar Entregas" style="display:none"/>	
                    </div>
                    <div>  
                    	<input type="button" id="damnificado_nuevo" class="boton_gris" value="Nuevo" title="Damnificado Nuevo" style="display:none"/>
                        <input type="button" id="arriendo_nuevo" class="boton_gris" value="Arriendo" title="Adicionar Arriendo" style="display:none"/>	 
                        &nbsp;&nbsp;&nbsp;                       
                        <input type="button" id="reparacion_nueva" class="boton_gris" value="Reparacion" title="Adicionar Reparacion" style="display:none"/>
                    </div>                                
                </form>
                <div class="clear"></div>
            </div> 
        </div>    
        
        <div class="info">
            <div class="formulario" id="arriendo_damnificado">
                <div class="header_info">
                    <a href="#" id="arriendo" title="Ocultar - Mostrar">INFORMACION DEL ARRIENDO</a>
                </div>
                <div id="div_arriendo">
                    <form id="form_arrendador" action="#" method="get" style="display:none"> 
                        <input type="hidden" id="id_damnificado_arrendador" name="id_damnificado" value="" /> 
                         <input type="hidden" id="fase_arrendador" name="fase" value="" /> 
                                            
                        <input type="hidden" id="id_arrendador" name="id_arrendador" value="" /> 
                        <input type="hidden" id="opc_arrendador" name="opc" value="" />                          
                        <div class="clear">
                            <label for="documento_arrendador">No. Doc. del Arrendador</label>
                            <input type="text" name="documento" id="documento_arrendador" value="" />   
                        </div>    	       
                        <div>
                            <label for="nombre_arrendador">Nombre del Arrendador</label>
                            <input type="text" name="nombre" id="nombre_arrendador" value="" />   
                        </div>
                        <div class="clear">
                            <label for="direccion_arrendador">Direccion del Arrendador</label>
                            <input type="text" name="direccion" id="direccion_arrendador" value="" />   
                        </div>  
                        <div>
                            <label for="telefono_arrendador">Telefono del Arrendador</label>
                            <input type="text" name="telefono" id="telefono_arrendador" value="" />   
                        </div>                     
                        <div class="clear">          
                            <input type="submit" id="guardar_arrendador" class="boton_gris" value="Guardar" title="Guardar Arrendador" style="display:none"/> 
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" id="eliminar_arrendador" class="boton_naranja" value="Quitar" title="Quitar Arrendador" style="display:none"/>	
                        </div> 
                        <div>
                        	<span id="usuario_arrendador"></span><br>
                        	<span id="fecha_arrendador"></span>                            
                        </div>            	            
                    </form>
                    
                    <form id="form_cambiar_arrendador" action="#" method="get" style="display:none"> 
                        <input type="hidden" id="opc_cambiar_arrendador" name="opc" value="" />              	                       
                        <div class="clear">
                            <label for="documento_cambiar_arrendador">No. Doc. del Arrendador</label>
                            <input type="text" name="documento" id="documento_cambiar_arrendador" value="" label="Por favor digite el numero de documento del arrendador" />   
                        </div> 
                        <div>  
                        	<br> 
                            <input type="submit" id="cambiar_arrendador" class="boton_gris" value="Buscar" title="Buscar Arrendador"/>  
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" id="arrendador_nuevo" class="boton_gris" value="Nuevo" title="Arrendador Nuevo" />
                        </div>	            
                    </form>                        
                    
                    <form id="form_arriendo" action="#" method="get">                     
                        <input type="hidden" id="id_damnificado_arriendo" name="id_damnificado" value="" />
                        <input type="hidden" id="fase_arriendo" name="fase" value="" /> 
                        
                        <input type="hidden" id="id_arrendador_arriendo" name="id_arrendador" value="" />
                        <input type="hidden" id="opc_arriendo" name="opc" value="" />                    
                        <div class="clear">
                            <div class="label_l">
                                <label for="observaciones_arriendo">
                                    <strong>Observaciones,</strong>
                                    Fecha:<span id="fecha_observaciones_arriendo"></span>
                                    : <span id="usuario_observaciones_arriendo"></span>
                                </label>
                            </div>
                            <textarea name="observaciones" id="observaciones_arriendo" value="" ></textarea>
                        </div>
                        <div class="clear">
                            <label for="comprobante">Numero de Comprobante</label>
                            <input type="text" name="comprobante" id="comprobante" class="input_c" value=""	/>
                        </div>
                        <div>
                            <label for="fecha_arriendo" >Entrega de Arriendo</label>
                            <input type="text" id="fecha_arriendo" name="fecha_arriendo" class="input_c" value="" />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="bloquear_arriendo" name="bloquear" value="1" style="display:none" />
                        </div> 
						<div class="clear">
                            <label for="cheque">Numero de Cheque</label>
                            <input type="text" name="cheque" id="cheque" class="input_c" value=""	/>
                        </div>                   
                        <div class="clear">          
                            <input type="submit" id="guardar_arriendo" class="boton_gris" value="Guardar" title="Guardar Arriendo"  style="display:none"/> 
                            &nbsp;&nbsp;&nbsp;									
                            <input type="button" id="eliminar_arriendo" class="boton_naranja" value="Eliminar" title="Eliminar Arriendo" style="display:none"/>	
                        </div>
                        <div>                       
                            <input type="button" id="contrato" class="boton_gris" value="Contrato" title="Contrato" style="display:none"/>
							&nbsp;&nbsp;&nbsp;									
                            <input type="button" id="egreso" class="boton_gris" value="Egreso" title="Egreso" style="display:none"/>	
                        </div>                 	            
                    </form>                                        
                	<div class="clear"></div>
               </div> 
            </div>  
            
            <div class="formulario" id="damnificado_reparacion">
                <div class="header_info">
                    <a href="#" id="reparacion" title="Ocultar - Mostrar">INFORMACION DE LA REPARACION DE VIVIENDA</a>
                </div>                        
                <form id="form_reparacion" action="#" method="get"> 
                	<input type="hidden" id="id_damnificado_reparacion" name="id_damnificado" value="" />                    
                	<input type="hidden" id="fase_reparacion" name="fase" value="" />
                    <input type="hidden" id="opc_reparacion" name="opc" value="" />
                    <div class="clear">
                    	<div class="label_l">
                       		<label for="observaciones_reparacion">
                            	<strong>Observaciones,</strong>
                                Fecha:<span id="fecha_observaciones_reparacion"></span>
                                : <span id="usuario_observaciones_reparacion"></span>
                           	</label>
                        </div>
                        <textarea name="observaciones" id="observaciones_reparacion" value="" ></textarea>
                    </div>
                    <div class="clear">
                        <label for="comprobante_reparacion">Numero de Comprobante</label>
                        <input type="text" name="comprobante" id="comprobante_reparacion" class="input_c" value=""	/>
                    </div>
                    <div>
                        <label for="fecha_reparacion" >Fecha Reparacion Vivienda</label>
                        <input type="text" id="fecha_reparacion" name="fecha_reparacion" class="input_c" value="" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="bloquear_reparacion" name="bloquear" value="1" style="display:none" />
                    </div>
                    <div class="clear">          
                        <input type="submit" id="guardar_reparacion" class="boton_gris" value="Guardar" title="Guardar Reparacion"  style="display:none"/> 
                        &nbsp;&nbsp;&nbsp;									
                        <input type="button" id="eliminar_reparacion" class="boton_naranja" value="Eliminar" title="Eliminar Reparacion" style="display:none"/>	
                    </div> 
             	</form> 
                <div class="clear"></div>
            </div>       
            
            <div class="formulario" id="damnificado_reparacion">
                <div class="header_info">
                    <a href="#" id="mercados" title="Ocultar - Mostrar">INFORMACION DE LAS ENTREGAS</a>
                </div>                        
                <form id="form_entregas" action="#" method="get"> 
                	<input type="hidden" id="id_damnificado_entregas" name="id_damnificado" value="" />                    
                	<input type="hidden" id="fase_entregas" name="fase" value="" />
                    <input type="hidden" id="opc_entregas" name="opc" value="" />
                    <div class="clear">
                    	<div class="label_l">
                       		<label for="observaciones_entregas">
                            	<strong>Observaciones,</strong>
                                Fecha:<span id="fecha_observaciones_entregas"></span>
                                : <span id="usuario_observaciones_entregas"></span>
                           	</label>
                        </div>
                        <textarea name="observaciones" id="observaciones_entregas" value="" ></textarea>
                    </div>
                    <div class="clear">
                        <label for="ficho" >Ficho</label><br>
                        <input type="text" id="ficho" name="ficho" class="input_c" value=""/>
                    </div>
                    <div>
                        <label for="fecha_kit_aseo" >Entrega Kit de Aseo</label>
                        <input type="text" id="fecha_kit_aseo" name="fecha_kit_aseo" class="input_c" value="" />            
                    </div>
                    <div class="clear">
                        <label for="fecha_mercado1" >1ra. Entrega de Mercado</label>
                        <input type="text" id="fecha_mercado1" name="fecha_mercado1" class="input_c" value="" />            
                    </div> 
                    <div>
                        <label for="fecha_mercado2" >2ta. Entrega de Mercado</label>
                        <input type="text" id="fecha_mercado2" name="fecha_mercado2" class="input_c" value="" /> 
                    </div>          
                    <div class="clear">
                        <label for="fecha_mercado3" >3ra. Entrega de Mercado</label>
                        <input type="text" id="fecha_mercado3" name="fecha_mercado3" class="input_c" value="" />             
                    </div> 
                    <div>
                        <label for="fecha_mercado2" >4ta. Entrega de Mercado</label>
                        <input type="text" id="fecha_mercado4" name="fecha_mercado4" class="input_c" value="" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="bloquear_entregas" name="bloquear" value="1" style="display:none" />
                    </div>
                    <div class="clear">                        
                        <input type="submit" id="guardar_entregas" class="boton_gris" value="Guardar" title="Guardar Entregas" />
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="eliminar_entregas" class="boton_naranja" value="Eliminar" title="Quitar Entregas" style="display:none"/>	
                    </div>
                    <div>
                    	<input type="button" id="entregar_todo" class="boton_azul" value="Entregar" title="Entregar Todo" style="display:none"/>
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" id="hoja_ayuda" class="boton_gris" value="Hoja Ayuda" title="Hoja de Ayuda" style="display:none"/>  
                    </div>      
                </form>
                <div class="clear"></div>
            </div> 
       	</div>     
  	</div>
    
    <div id="espacio"></div>    
    
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2011 - Corprodinco</a>
        	&nbsp;|&nbsp;
        	<a href="http://diegox09.co.cc" target="_blank">Diegox09</a>
            &nbsp;|&nbsp;
        	<a href="#" id="resumen">Informes</a>
     	</div>       
    </div> 
</body>
</html>
