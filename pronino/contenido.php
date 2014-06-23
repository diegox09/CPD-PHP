<?php
	session_start();	
	if(!array_key_exists('id_pn', $_SESSION)) {
		header('Location: index.php');
	}	
?>	
<!DOCTYPE HTML>
<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Proniño</title>  
  	<link rel="shortcut icon" href="img/application_view_gallery.png" type="image/ico" />
  	<link rel="stylesheet" type="text/css" href="css/ui/jquery.ui.all.css" /> 
    <link rel="stylesheet" type="text/css" href="css/tablesorter.min.css" /> 
  	<link rel="stylesheet" type="text/css" href="css/contenido.css" />
  	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script> 
  	<script type="text/javascript" src="js/ui/jquery.ui.core.min.js"></script>
  	<script type="text/javascript" src="js/ui/jquery.ui.datepicker.min.js"></script>
    <script type="text/javascript" src="js/tablesorter.min.js"></script> 
    <script type="text/javascript" src="js/jquery.textareaCounter.plugin.js"></script>  
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
        <div style="width:15%">
            <img src="img/logo.png" height="70" />
        </div>
        <div style="width:70%">
        &nbsp;
        </div>
        <div style="width:15%">
            <img src="img/telefonica.png" height="70" />
        </div>
    </div> 
          
	<div id="info">
        <div id="busqueda_beneficiario">
            <form id="form_buscar" action="#" method="get">
                <input type="hidden" id="opc_buscar" name="opc" value="" />
                <input type="hidden" id="year_buscar" name="year" value="" /> 
                <div style="width:455px"> 
                    <input type="text" id="input_buscar" class="input_buscar" name="buscar" value="" label="Digite el numero de documento o nombre del beneficiario"/>
                    <input type="submit" id="buscar" class="boton_gris" value="Buscar" title="Buscar Beneficiario"/>
                    &nbsp;
                    <a href="#" id="beneficiario_nuevo" class="generico" title="Beneficiario Nuevo" style="display:none">&nbsp;&nbsp;&nbsp;</a>
                </div>
                <div style="width:60px">
                	<div style="width:55px;height:16px">&nbsp;</div>
                    &nbsp;&raquo;
                </div>
                <div style="width:160px">
                    <label>Municipio</label>
                    <select id="id_municipio_buscar" class="select_c" name="id_municipio">
                    </select>   
                </div>
                <div>&nbsp;&nbsp;</div>
                <div style="width:315px">
                    <label>Colegio</label>
                    <select id="id_colegio_buscar" class="select_c" name="id_colegio">
                    </select>   
                </div>
            </form>
            <div style="width:1002px" class="clear">
            	<table class="tablesorter" id="busqueda"></table> 
            </div> 
        </div>
        
        <div id="generico" class="formulario" style="display:none">
            <div class="header_info">
                INFORMACION BASICA&nbsp;<span id="span_generico"></span>                    
                <label>
                    &nbsp;&raquo;&nbsp;
                    <span id="usuario_actualizo_generico"></span>                            
                    &nbsp;&raquo;&nbsp;
                    <span id="fecha_actualizacion_generico"></span> 
                    &nbsp;
                    <a href="#" id="actualizar_generico" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </label> 
            </div>
            <div>
                <form id="form_generico" action="#" method="get">
                	<input type="hidden" id="id_beneficiario_generico" name="id_pronino" value="" /> 
                    <input type="hidden" id="id_generico" name="id_beneficiario" value="" /> 
                    <input type="hidden" id="tipo_generico" name="tipo" value="" />                   	
                    <input type="hidden" id="opc_generico" name="opc" value="" />
                    <div style="width:100%">
                    	<div style="width:190px">
                            <label>Documento Beneficiario</label>
                            <input type="text" name="documento_beneficiario" id="documento_beneficiario_generico" class="input_l" value=""/>   
                        </div>  
                        <div style="width:130px"> 
                            <label>Tipo Documento</label><br>
                            <select id="td_generico" class="select_l" name="td">
                                <option value="0"> - Seleccionar - </option>
                                <option value="1"> Cedula de Ciudadania </option>                            
                                <option value="2"> Nuip </option>
                                <option value="3"> Registro Civil </option>
                                <option value="4"> Tarjeta de Identidad </option>                            
                            </select> 
                        </div>                                
                        <div style="width:193px">
                            <label>Nombres</label>
                            <input type="text" name="nombres" id="nombres_generico" class="input_l" value="" />           
                        </div>  
                        <div style="width:193px">
                            <label>Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos_generico" class="input_l" value="" />   
                        </div> 
                        <div style="width:140px">
                            <label>Fecha Nacimiento</label>
                            <input type="text" name="fecha_nacimiento" id="fecha_nacimiento_generico" class="input_c" value="" />   
                        </div>
                        <div style="width:84px">
                            <label>Edad</label>
                            <input type="text" name="edad" id="edad_generico" class="input_c" value="" readonly />  
                        </div>                  
                        <div class="clear" style="width:130px"> 
                            <label>Genero</label><br>
                            <select id="genero_generico" class="select_c" name="genero" >
                                <option value="0" selected="selected"> - Seleccionar - </option>
                                <option value="1" > Femenino </option>
                                <option value="2" > Masculino </option>                            
                            </select> 
                        </div>
                        <div style="width:130px">
                            <label>Municipio</label>
                            <select id="id_municipio_generico" class="select_c" name="id_municipio">
                            </select>   
                        </div> 
                        <div style="width:180px">
                            <label>Barrio</label>
                            <select id="id_barrio_generico" class="select_c" name="id_barrio">
                            </select>   
                        </div> 
                        <div style="width:210px">
                            <label>Direccion</label>
                            <input type="text" name="direccion" id="direccion_generico" class="input_l" value="" />   
                        </div> 
                        <div style="width:190px">
                            <label>Telefono</label>
                            <input type="text" name="telefono" id="telefono_generico" class="input_l" value="" />    
                        </div>
                    </div>                                           
                    <div id="botones_generico">
                    	<input type="button" id="nuevo_generico" class="boton_verde" value="Nuevo" title="" style="display:none"/>	
                        <input type="button" id="eliminar_generico" class="boton_naranja" value="Eliminar" title="Eliminar" style="display:none"/>	
                        &nbsp;&there4;&nbsp;
                        <input type="submit" id="guardar_generico" class="boton_gris" value="Buscar" title="Buscar - Guardar"/>
                        <input type="button" id="cancelar_generico" class="boton_naranja" value="Cancelar" title="Cancelar"/>
                    </div>
                </form>
            </div>
            <table id="tabla_generico" class="tablesorter"></table>
            <div class="espacio"></div> 
        </div>           
        
        <div id="info_beneficiario" class="formulario" style="display:none">
            <div class="header_info">                
                INFORMACION BASICA DEL BENEFICIARIO
                <label>
                    &nbsp;&raquo;&nbsp;
                    <span id="usuario_actualizo"></span>                            
                    &nbsp;&raquo;&nbsp;
                    <span id="fecha_actualizacion"></span>
                </label>
                &nbsp;
                <a href="#" id="actualizar" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </div>
            
            <form id="form_beneficiario" action="#" method="get"> 
                <input type="hidden" id="id_beneficiario" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>
                <input type="hidden" id="opc_beneficiario" name="opc" value="" />
                <div style="width:100%">
                	<div style="width:190px">
                        <label>Documento Beneficiario</label>
                        <input type="text" name="documento_beneficiario" id="documento_beneficiario" class="input_l" value=""/>   
                    </div>  
                	<div style="width:130px"> 
                        <label>Tipo Documento</label><br>
                        <select id="td" class="select_l" name="td">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Cedula de Ciudadania </option>                            
                            <option value="2"> Nuip </option>
                            <option value="3"> Registro Civil </option>
                            <option value="4"> Tarjeta de Identidad </option>                            
                        </select> 
                    </div>                                   
                    <div style="width:193px">
                        <label>Nombres</label>
                        <input type="text" name="nombres" id="nombres" class="input_l" value="" />           
                    </div>  
                    <div style="width:193px">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="input_l" value="" />   
                    </div> 
                    <div style="width:140px">
                        <label>Fecha Nacimiento</label>
                        <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="input_c" value="" />   
                    </div>
                    <div style="width:84px">
                        <label>Edad</label>
                        <input type="text" name="edad" id="edad" class="input_c" value="" readonly />  
                    </div>                  
                    <div class="clear" style="width:110px"> 
                        <label>Genero</label><br>
                        <select id="genero" class="select_c" name="genero" >
                            <option value="0" selected="selected"> - Seleccionar - </option>
                            <option value="1" > Femenino </option>
                            <option value="2" > Masculino </option>                            
                        </select> 
                    </div>
                    <div style="width:130px">
                        <label>Municipio</label>
                        <select id="id_municipio" class="select_c" name="id_municipio">                            
                        </select>   
                    </div> 
                    <div style="width:170px">
                        <label>Barrio</label>
                        <select id="id_barrio" class="select_c" name="id_barrio">
                        </select>   
                    </div> 
                    <div style="width:210px">
                        <label>Direccion</label>
                        <input type="text" name="direccion" id="direccion" class="input_l" value="" />   
                    </div> 
                    <div style="width:190px">
                        <label>Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="input_l" value="" />    
                    </div>
                    <div style="width:35px">
                    	<div style="width:30px;height:12px">&nbsp;</div>
                        &nbsp;
                		<a href="#" id="beneficiario" class="generico" title="Actualizar Acudiente">&nbsp;&nbsp;&nbsp;</a>
                    </div>
                    <div style="width:90px;text-align:right">
                    	<div style="width:80px;height:2px">&nbsp;</div>
                    	<input type="submit" id="guardar_beneficiario" class="boton_gris" value="Guardar" title="Guardar Beneficiario"/>
                        &nbsp;
                    </div>
              	</div>
         	</form>   
            
            <form id="form_pronino" action="#" method="get"> 
                <input type="hidden" id="id_beneficiario_pronino" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>
                <input type="hidden" id="id_acudiente" name="id_acudiente" value="" /> 
                <input type="hidden" id="opc_pronino" name="opc" value="" />  
                <div class="header_info">
                    INFORMACION BASICA DEL BENEFICIARIO EN EL PROGRAMA PRONIÑO
                    <label>
                        &nbsp;&raquo;&nbsp;
                        <span id="usuario_actualizo_pronino"></span>                            
                        &nbsp;&raquo;&nbsp;
                        <span id="fecha_actualizacion_pronino"></span>
                	</label>        
                </div>
                <div style="width:100%">                  
                    <div class="clear" style="width:150px">
                        <label>Item</label>
                        <input type="text" name="item" id="item" class="input_c" value="" />   
                    </div> 
                    <div style="width:160px">
                        <label class="new">Grupo Étnico</label>
                        <select id="grupo_etnico" class="select_c" name="grupo_etnico">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Mestizo </option>
                            <option value="2"> Afro descendiente </option>
                            <option value="3"> Indígena </option>
                            <option value="4"> Blanco </option>
                            <option value="5"> No lo sé </option>
                            <option value="6"> Otros </option>
                        </select>   
                    </div>
                    <div style="width:150px">
                        <label>Sisben</label>
                        <select id="sisben" class="select_c" name="sisben">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> I </option>
                            <option value="2"> II </option>
                            <option value="3"> III </option>
                        </select>            
                    </div> 
                    <div style="width:160px">
                        <label>ARS</label>
                        <select id="id_ars" class="select_c" name="id_ars">
                        </select>   
                    </div>                    
                    <div style="width:150px;display:none">
                        <label>Talla Uniforme</label>
                        <select id="talla_uniforme" class="select_c" name="talla_uniforme">
                            <option value="0"> - Seleccionar - </option>
                            <option value="6"> 6 </option>
                            <option value="8"> 8 </option>
                            <option value="10"> 10 </option>
                            <option value="12"> 12 </option>
                            <option value="13"> 13 </option>
                            <option value="14"> 14 </option>
                            <option value="16"> 16 </option>
                            <option value="18"> 18 </option>
                            <option value="28"> 28 </option>
                            <option value="32"> 32 </option>
                            <option value="35"> 35 </option>
                            <option value="36"> 36 </option>
                            <option value="38"> S (38-40) </option>
                            <option value="40"> M (40-42) </option>
                            <option value="42"> L (42-44) </option>
                        </select>            
                    </div>         
                    <div style="width:150px;display:none">
                        <label>Talla Zapato</label>
                        <select id="talla_zapato" class="select_c" name="talla_zapato">
                            <option value="0"> - Seleccionar - </option>
                            <option value="26"> 26 </option>
                            <option value="27"> 27 </option>
                            <option value="28"> 28 </option>
                            <option value="29"> 29 </option>
                            <option value="30"> 30 </option>
                            <option value="31"> 31 </option>
                            <option value="32"> 32 </option>
                            <option value="33"> 33 </option>
                            <option value="34"> 34 </option>
                            <option value="35"> 35 </option>
                            <option value="36"> 36 </option>
                            <option value="37"> 37 </option>
                            <option value="38"> 38 </option>
                            <option value="39"> 39 </option>
                            <option value="40"> 40 </option>
                            <option value="41"> 41 </option>
                            <option value="42"> 42 </option>
                            <option value="43"> 43 </option>
                        </select>    
                    </div>                
                    <div id="usuario1" style="width:160px;display:none">
                        <label>Profesional</label>
                        <select id="id_usuario1" class="select_c" name="id_usuario1">
                        </select>   
                    </div>
                    <div id="usuario2" style="width:160px;display:none">
                        <label>Coordinador</label>
                        <select id="id_usuario2" class="select_c" name="id_usuario2">
                        </select>   
                    </div>
                    <div class="clear" style="width:150px">
                        <label class="new">Tipologia Familiar</label>
                        <select id="tipologia_familiar" class="select_l" name="tipologia_familiar">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Nuclear </option>                            
                            <option value="2"> Monoparental Paterna </option>
                            <option value="3"> Monoparental Materna </option>
                            <option value="4"> Extensa </option>
                            <option value="5"> Otra </option>
                        </select> 
                    </div>  
                    <div style="width:150px">
                        <label>Fecha de Ingreso</label>
                        <input type="text" name="fecha_ingreso" class="input_c" id="fecha_ingreso" value="" />   
                    </div>
                    <div style="width:160px;display:none" id="estado">
                        <label>Estado</label>
                        <select id="id_estado"  class="select_c" name="estado">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Activo </option>
                            <option value="2"> Inactivo </option>
                        </select>   
                    </div>                    
                    <div style="width:150px;visibility:hidden" class="retirado">
                        <label>Fecha de Retiro</label>
                        <input type="text" name="fecha_retiro" id="fecha_retiro" class="input_c" value="" />   
                    </div>                    
                    <div style="width:160px;visibility:hidden" class="retirado">                            
                        <label>Egresado</label>
                        <select id="razon_egresado" class="select_c" name="razon_egresado">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Por edad legal o admision al empleo </option>
                             <option value="6"> Porque finalizo primaria </option>
                            <option value="2"> Porque finalizo secundaria </option>
                            <option value="3"> Mejoro su situacion y no necesita ayuda del programa </option>
                            <option value="5"> Derivacion a Otras Redes </option> 
                            <option value="4"> Cumplio mayoria de edad </option>                                                      
                        </select>   
                    </div>
                    <div style="width:160px;visibility:hidden" class="retirado">                            
                        <label>Baja</label>
                        <select id="razon_baja" class="select_c" name="razon_baja">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Se mudo </option>
                            <option value="13"> Cambió de Escuela </option>
                            <option value="2"> Casamiento/convivencia </option>
                            <option value="14"> Embarazo </option>
                            <option value="3"> Fallecimiento </option>
                            <option value="4"> Se retiro la ONG de la escuela </option>
                            <option value="5"> Abandono programa </option>
                            <option value="6"> Incumplimiento acuerdos del programa </option>
                            <option value="7"> Problemas de salud </option>
                            <!--
                            <option value="8"> Derivacion a otras redes </option>
                            -->
                            <option value="9"> Baja de ONG del programa </option>
                            <option value="10"> Desinterés al estudio </option>
                            <!--
                            <option value="11"> Estudia a distancia </option>
                            -->
                            <option value="15"> Deserción Escolar</option>
                            <option value="16"> No Completo Ciclo de Intervención </option>
                            <option value="17"> Traspaso Competencias Siglo XXI </option>
                            <option value="12"> Otro </option>
                        </select>   
                    </div> 
                    
                    <div style="width:160px;display:none">                            
                        <label>Razon Retiro</label>
                        <select id="razon_retiro" class="select_c" name="razon_retiro">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Desertor </option>
                            <option value="2"> Expulsado </option>
                            <option value="3"> Retirado </option>
                        </select>   
                    </div>
                      
                    <div class="clear" style="width:160px">
                        <label>Documento Acudiente</label>
                        <input type="text" name="documento_acudiente" id="documento_acudiente" class="input_l" value="" readonly />   
                    </div> 
                    <div style="width:35px">
                    	<div style="width:30px;height:12px">&nbsp;</div>
                        &nbsp;
                		<a href="#" id="acudiente" class="generico" title="Actualizar Acudiente">&nbsp;&nbsp;&nbsp;</a>
                    </div>   	       
                    <div style="width:310px">
                        <label>Nombre del Acudiente</label>
                        <input type="text" name="nombre_acudiente" id="nombre_acudiente" class="input_l" value="" readonly />   
                    </div>
                    <div style="width:160px">
                        <label class="new">Parentesco</label>
                        <select id="parentesco_acudiente" class="select_l" name="parentesco_acudiente">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Padre/Madre </option>                            
                            <option value="2"> Tio/a </option>
                            <option value="3"> Hermano/a </option>
                            <option value="4"> Abuelo/a </option>
                            <option value="5"> Padrastro/Madrastra </option>
                            <option value="6"> Otro </option>
                        </select> 
                    </div>     
                    <div style="width:90px;text-align:right">
                    	<div style="width:80px;height:2px">&nbsp;</div>
                    	<input type="submit" id="guardar_pronino" class="boton_gris" value="Guardar" title="Guardar Informacion"/>
                        &nbsp;
                    </div> 
                </div>    
            </form>
            
            <div id="diagnostico" style="display:none">
            	<div class="header_info">
                    DIAGNOSTICO INICIAL
                    <label>
                        &nbsp;&raquo;&nbsp;
                        <span id="usuario_actualizo_diagnostico"></span>                            
                        &nbsp;&raquo;&nbsp;
                        <span id="fecha_actualizacion_diagnostico"></span> 
                        &nbsp;
                        <a href="#" id="actualizar_diagnostico" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    </label>    
                </div>
            	<div>
                	<form id="form_diagnostico" action="#" method="get">
                    	<input type="hidden" id="id_beneficiario_diagnostico" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>
                        <input type="hidden" id="opc_diagnostico" name="opc" value="" />
                        <div style="width:100%">
                        	<div style="width:350px">
                            	<label>Nombre Beneficiario</label>
                            	<input type="text" name="nombre_beneficiario" id="nombre_beneficiario_diagnostico" class="input_l" value="" readonly />
                            </div> 
                        	<div style="width:210px"> 
                                <label>Caso Remitido Por</label><br>
                                <select id="remitido" class="select_l" name="remitido">
                                    <option value="0"> - Seleccionar - </option>
                                    <option value="1"> ICBF </option>                            
                                    <option value="2"> Red Unidos </option>
                                    <option value="3"> Institución Educativa </option>
                                    <option value="4"> Lideres Comunitarios </option> 
                                    <option value="5"> Busqueda Activa </option> 
                                    <option value="6"> Otros </option>                            
                                </select>                               
                            </div>  
                            <div style="width:210px"> 
                                <label>Profesional</label><br>
                                <select id="profesional_diagnostico" class="select_l" name="profesional">
                                </select>                               
                            </div>                                                                                     
                            <div style="width:991px" class="clear">
                                <div class="header_diagnostico">
                                	<label>SITUACION LABORAL</label><br>
                                    (Describa sitio, hora, persona que lo emplea, si recibe remuneracion)
                                </div>
                                <textarea name="situacion_laboral" id="situacion_laboral" value="" ></textarea>        
                            </div>
                            <div style="width:991px" class="clear">
                                <div class="header_diagnostico">
                                	<label>DESCRIPCION DE LOS ESCENARIOS DE PARTICIPACIÓN DEL BENEFICIARIO</label><br>
                                    (A nivel familiar, social, escolar, comportamental y académico)
                                </div>    
                                <textarea name="descripcion_escenarios" id="descripcion_escenarios" value="" ></textarea>        
                            </div>
                            <div style="width:991px" class="clear">
                                <div class="header_diagnostico">
                                	<label>OBSERVACIONES, RECOMENDACIONES Y/O SUGERENCIAS</label>
                                </div>
                                <textarea name="observaciones_diagnostico" id="observaciones_diagnostico" value="" ></textarea>        
                            </div>
                            
                            <div id="botones_diagnostico">
                            	<input type="button" id="eliminar_diagnostico" class="boton_naranja" value="Eliminar" title="Eliminar Diagnostico Inicial" style="display:none"/>
                                &nbsp;&there4;&nbsp;
                                <input type="submit" id="guardar_diagnostico" class="boton_gris" value="Guardar" title="Guardar Diagnostico Inicial"/>
                                <input type="button" id="cancelar_diagnostico" class="boton_naranja" value="Cancelar" title="Cancelar Diagnostico Inicial"/>
                                &nbsp;&there4;&nbsp;
                                <input type="button" id="imprimir_diagnostico" class="boton_azul" value="Imprimir" title="Imprimir Diagnostico Inicial"/>
                                &nbsp;	
                            </div>
                    	</div>        
                    </form>
                </div>
            </div>
            
            <div id="seguimiento" style="display:none">
            	<div class="header_info">
                    SEGUIMIENTO VISITAS DOMICILIARIAS Y ATENCIÓN PSICOSOCIAL                    
                    <label>
                        &nbsp;&raquo;&nbsp;
                        <span id="usuario_actualizo_seguimiento"></span>                            
                        &nbsp;&raquo;&nbsp;
                        <span id="fecha_actualizacion_seguimiento"></span> 
                        &nbsp;
                        <a href="#" id="actualizar_seguimiento" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                	</label> 
                </div>
            	<div>
                	<form id="form_seguimiento" action="#" method="get">
                    	<input type="hidden" id="id_seguimiento" name="id_seguimiento" value="" />
                    	<input type="hidden" id="id_beneficiario_seguimiento" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>
                        <input type="hidden" id="opc_seguimiento" name="opc" value="" />
                        <div style="width:100%"> 
                            <div style="width:350px">
                            	<label>Nombre Beneficiario</label>
                            	<input type="text" name="nombre_beneficiario" id="nombre_beneficiario_seguimiento" class="input_l" value="" readonly />
                            </div>
                            <div style="width:190px"> 
                                <label>Fecha Visita Domiciliaria</label><br>
                                <input type="text" name="fecha_seguimiento" id="fecha_seguimiento" class="input_c" value="" label="Digite la fecha de la visita"/>                               
                            </div>  
                            <div style="width:210px"> 
                                <label>Profesional</label><br>
                                <select id="profesional_seguimiento" class="select_l" name="profesional" label="Seleccione un profesional">
                                </select>                               
                            </div> 
                            <div style="width:991px" class="clear">
                                <div class="header_diagnostico">
                                	<label>MOTIVO</label>
                                </div>
                                <textarea name="motivo_seguimiento" id="motivo_seguimiento" value="" label="Digite el motivo de la visita"></textarea>        
                            </div>
                            <div style="width:991px" class="clear">
                                <div class="header_diagnostico">
                                	<label>DESCRIPCION</label>
                                </div>
                                <textarea name="descripcion_seguimiento" id="descripcion_seguimiento" value="" label="Digite la descripcion de la visita"></textarea>        
                            </div>                                           
                            <div id="botones_seguimiento">
                            	<input type="button" id="eliminar_seguimiento" class="boton_naranja" value="Eliminar" title="Eliminar Seguimiento Visitas Domiciliarias" style="display:none"/>	
                                &nbsp;&there4;&nbsp;
                                <input type="submit" id="guardar_seguimiento" class="boton_gris" value="Guardar" title="Guardar Visita Domiciliaria"/>
                                <input type="button" id="cancelar_seguimiento" class="boton_naranja" value="Cancelar" title="Cancelar Seguimiento Visitas Domiciliarias"/>
                                &nbsp;&there4;&nbsp;
                                <input type="button" id="imprimir_seguimiento" class="boton_azul" value="Imprimir" title="Imprimir Seguimiento Visitas Domiciliarias"/>
                                &nbsp;
                            </div>
                    	</div> 
                    </form>
            	</div>
                <table id="tabla_seguimientos" class="tablesorter"></table>
                <div class="espacio"></div> 
            </div>
            
            <div id="psicosocial" style="display:none">
            	<div class="header_info">
                    ATENCION PSICOSOCIAL                   
                    <label>
                        &nbsp;&raquo;&nbsp;
                        <span id="usuario_actualizo_psicosocial"></span>                            
                        &nbsp;&raquo;&nbsp;
                        <span id="fecha_actualizacion_psicosocial"></span> 
                        &nbsp;
                        <a href="#" id="actualizar_psicosocial" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                	</label> 
                </div>
            	<div>
                	<form id="form_psicosocial" action="#" method="get">
                    	<input type="hidden" id="id_psicosocial" name="id_psicosocial" value="" />
                    	<input type="hidden" id="id_beneficiario_psicosocial" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>
                        <input type="hidden" id="opc_psicosocial" name="opc" value="" />
                        <div style="width:100%"> 
                            <div style="width:350px">
                            	<label>Nombre Beneficiario</label>
                            	<input type="text" name="nombre_beneficiario" id="nombre_beneficiario_psicosocial" class="input_l" value="" readonly />
                            </div>
                            <div style="width:190px"> 
                                <label>Fecha Remision</label><br>
                                <input type="text" name="fecha_remision" id="fecha_remision" class="input_c" value="" label="Digite la fecha de remision" />                               
                            </div> 
                            <div style="width:210px"> 
                                <label>Remitido Por</label><br>
                                <select id="remitido_psicosocial" class="select_l" name="remitido" label="Seleccione un profesional">
                                </select>                               
                            </div> 
                            <div style="width:991px" class="clear">
                            	<div class="header_diagnostico">
                                    <label>1.	ASPECTO EN DONDE PRESENTA DIFICULTAD:</label>
                                </div>                                
                                <div style="width:236px">                            
                                    <input type="checkbox" id="aspecto_academico" name="aspecto_academico" title="Aspecto Académico" value="1"/>
                                    <label>Aspecto Académico</label> 
                                </div>
                                <div style="width:236px">                            
                                    <input type="checkbox" id="aspecto_comportamiento" name="aspecto_comportamiento" title="Aspecto de Comportamiento" value="1"/>
                                    <label>Aspecto de Comportamiento</label>    
                                </div> 
                                <div style="width:236px">                            
                                    <input type="checkbox" id="aspecto_comunicativo" name="aspecto_comunicativo" title="Aspecto Comunicativo" value="1"/>  
                                    <label>Aspecto Comunicativo</label>
                                </div>
                                <div style="width:236px">                            
                                    <input type="checkbox" id="aspecto_familiar" name="aspecto_familiar" title="Aspecto Familiar" value="1"/>    
                                    <label>Aspecto Familiar</label>
                                </div>  
                            </div>
                            <div style="width:991px" class="clear">  
                            	<div class="header_diagnostico">
                                	<label>2.	MOTIVO DE REMISION:</label>
                                </div>               	
                                <div class="header_psicosocial">
                                	<label> ASPECTO ACADEMICO: </label>
                                    (Describa brevemente el área y la dificultad que presenta)
                                </div>
                                <textarea name="motivo_aspecto_academico" id="motivo_aspecto_academico" value=""></textarea>
                                <div class="header_psicosocial">
                                	<label> ASPECTO DE COMPORTAMIENTO: </label>
                                    (Describa brevemente la dificultad que presenta el NNA si es en las relaciones con compañeros, docentes, coordinador o personal administrativo, o si es dificultad a nivel emocional timidez, agresividad, aislamiento entre otras)
                                </div>
                                <textarea name="motivo_aspecto_comportamiento" id="motivo_aspecto_comportamiento" value=""></textarea>
                                <div class="header_psicosocial">
                                	<label> ASPECTO COMUNICATIVO: </label>
                                    (Describa la dificultad en el área del lenguaje)
                                </div>
                                <textarea name="motivo_aspecto_comunicativo" id="motivo_aspecto_comunicativo" value=""></textarea>
                                <div class="header_psicosocial">
                                	<label> ASPECTO FAMILIAR: </label>
                                    (Describa brevemente la dificultad en las relaciones del NNA con el padre, madre, hermanos, otros)
                                </div>
                                <textarea name="motivo_aspecto_familiar" id="motivo_aspecto_familiar" value=""></textarea>
                            </div>                                
                            <div style="width:991px" class="clear">
                                <div class="header_diagnostico">
                                	<label>ACCIONES REALIZADAS CON EL NNA ANTES DE REMITIRLO A ATENCION PSICOSOCIAL:</label>
                                </div>
                                <textarea name="acciones_realizadas" id="acciones_realizadas" value=""></textarea>
                            </div> 
                            <div style="width:991px" class="clear">
                                <div class="header_diagnostico">
                                	<label>REMISIONES POR PARTE DEL PROGRAMA PRONIÑO:</label>
                                </div>
                                <div style="width:316px">                            
                                    <input type="checkbox" id="remitido_uai" name="remitido_uai" title="Remitido a la UAI" value="1"/>
                                    <label>Remitido a la UAI</label> 
                                </div>
                                <div style="width:316px">                            
                                    <input type="checkbox" id="remitido_psicologia" name="remitido_psicologia" title="Remitido a Atencion Psicológica" value="1"/>
                                    <label>Remitido a Atencion Psicológica</label>    
                                </div> 
                                <div style="width:316px">                            
                                    <input type="checkbox" id="remitido_terapia_ocupacional" name="remitido_terapia_ocupacional" title="Remitido a Terapia Ocupacional" value="1"/>    
                                    <label>Remitido a Terapia Ocupacional</label>
                                </div>
                                <div style="width:316px" class="clear">                            
                                    <input type="checkbox" id="remitido_refuerzo_escolar" name="remitido_refuerzo_escolar" title="Remitido a Refuerzo Escolar" value="1"/>  
                                    <label>Remitido a Refuerzo Escolar</label>
                                </div>
                                <div style="width:472px">
                                	<label>Remitido a Otros Especialistas y/o Instituciones</label><br>
                                	<input type="text" name="remitido_otras_instituciones" id="remitido_otras_instituciones" class="input_c" value=""/>
                                </div>
                            </div>                                                                 
                            <div id="botones_psicosocial" class="clear">
                            	<input type="button" id="eliminar_psicosocial" class="boton_naranja" value="Eliminar" title="Eliminar Seguimiento Visitas Domiciliarias" style="display:none"/>
                                &nbsp;&there4;&nbsp;	
                                <input type="submit" id="guardar_psicosocial" class="boton_gris" value="Guardar" title="Guardar Visita Domiciliaria"/>
                                <input type="button" id="cancelar_psicosocial" class="boton_naranja" value="Cancelar" title="Cancelar Seguimiento Visitas Domiciliarias"/>
                                &nbsp;&there4;&nbsp;
                                <input type="button" id="imprimir_psicosocial" class="boton_azul" value="Imprimir" title="Imprimir Seguimiento Visitas Domiciliarias"/>
                                &nbsp;
                            </div>
                    	</div> 
                    </form>
            	</div>
                <table id="tabla_psicosocial" class="tablesorter"></table>
                <div class="espacio"></div> 
            </div>
                        
            <div id="actividades" style="display:none">
                <div id="menu_actividades" class="actividad_seleccionada" style="background:#FA8072">
                	<span id="seleccion_multiple">
                    	&nbsp;
                    	Multiple
                    	<input type="checkbox" id="multiple" value=""/>                          
                    </span>    
                    &nbsp;
                    <a href="#" id="actividad_escuela" label="#3CB371" title="Act. Escuela">Act. en Escuela</a>
                    <a href="#" id="actividad_casa" label="#6495ED" title="Act. Casa">Act. en la Casa</a>
                    <a href="#" id="actividad_pronino" label="#EEE8AA" title="Act. Proniño">Act. Proniño</a>
                    <a href="#" id="actividad_trabajando" label="#FA8072" title="Trabajando">Trabajando</a>
                    <a href="#" id="actividad_jugando" label="#D8BFD8" title="Jugando">Jugando</a>
                    <a href="#" id="actividad_otras" label="#FFDEAD" title="Otras Act.">Otras Act.</a>
                    <a href="#" id="actividad_quitar" label="#FFFFFF" title="">Ninguna</a>
                </div>
                <div>
                    <form id="form_mes" action="#" method="get">
                        <input type="hidden" id="id_beneficiario_mes" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>                      
                        <input type="hidden" id="opc_mes" name="opc" value="" />
                        <input type="hidden" id="seleccionado" value="" />
                        <input type="hidden" id="actividad_seleccionada" value="#FA8072" label="Trabajando" /> 
                        <input type="hidden" id="year_mes" name="year" value="" label="Por favor seleccione un año"/>
                        <input type="hidden" id="actividades_mes" name="actividades_mes" value="" /> 
                        <table class="tablesorter">                        
                            <thead>
                                <tr>
                                    <th colspan="9">
                                    	<span id="nombre_nna"></span>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;
                                    	<span id="tipo_periodo"></span>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;
                                        <span class="desc_periodo"></span>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;
                                        <span class="desc_year"></span>
                                        
                                        &nbsp;&nbsp;(&nbsp;
                                        <span id="usuario_actualizo_mes"></span>                            
                                        &nbsp;&raquo;&nbsp;
                                        <span id="fecha_actualizacion_mes"></span>
                                        &nbsp;)
                                        &nbsp;
                        				<a href="#" id="actualizar_mes" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="12%">
                                        <select id="id_mes" class="select_l" name="id_mes" > 
                                            <option value="1" > Enero </option> 
                                            <option value="2" > Febrero </option>  
                                            <option value="3" > Marzo </option>
                                            <option value="4" > Abril </option> 
                                            <option value="5" > Mayo </option> 
                                            <option value="6" > Junio </option> 
                                            <option value="7" > Julio </option> 
                                            <option value="8" > Agosto </option> 
                                            <option value="9" > Septiembre </option> 
                                            <option value="10" > Octubre </option> 
                                            <option value="11" > Noviembre </option>            
                                            <option value="12" > Diciembre </option>            
                                        </select>
                                    </th>
                                    <th width="4%">Hora</th>
                                    <th width="12%" title="Día Útil">Lunes</th>
                                    <th width="12%" title="Día Útil">Martes</th>
                                    <th width="12%" title="Día Útil">Miercoles</th>
                                    <th width="12%" title="Día Útil">Jueves</th>
                                    <th width="12%" title="Día Útil">Viernes</th>
                                    <th width="12%" class="fin_semana" title="Fin de Semana">Sabado</th>
                                    <th width="12%" class="fin_semana" title="Fin de Semana">Domingo</th>
                                </tr>                               
                            </thead>
                            <tbody id="desc_actividades">
                                <tr>
                                    <th rowspan="5" class="horario">Madrugada</th>
                                    <th class="center">12am</th>
                                    <td id="1_0"></td>
                                    <td id="2_0"></td>
                                    <td id="3_0"></td>
                                    <td id="4_0"></td>
                                    <td id="5_0"></td>
                                    <td id="6_0" class="fin_semana"></td>
                                    <td id="7_0" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>1am</th>
                                    <td id="1_1"></td>
                                    <td id="2_1"></td>
                                    <td id="3_1"></td>
                                    <td id="4_1"></td>
                                    <td id="5_1"></td>
                                    <td id="6_1" class="fin_semana"></td>
                                    <td id="7_1" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>2am</th>
                                    <td id="1_2"></td>
                                    <td id="2_2"></td>
                                    <td id="3_2"></td>
                                    <td id="4_2"></td>
                                    <td id="5_2"></td>
                                    <td id="6_2" class="fin_semana"></td>
                                    <td id="7_2" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>3am</th>
                                    <td id="1_3"></td>
                                    <td id="2_3"></td>
                                    <td id="3_3"></td>
                                    <td id="4_3"></td>
                                    <td id="5_3"></td>
                                    <td id="6_3" class="fin_semana"></td>
                                    <td id="7_3" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>4am</th>
                                    <td id="1_4"></td>
                                    <td id="2_4"></td>
                                    <td id="3_4"></td>
                                    <td id="4_4"></td>
                                    <td id="5_4"></td>
                                    <td id="6_4" class="fin_semana"></td>
                                    <td id="7_4" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th rowspan="7" class="horario">Mañana</th>
                                    <th>5am</th>
                                    <td id="1_5"></td>
                                    <td id="2_5"></td>
                                    <td id="3_5"></td>
                                    <td id="4_5"></td>
                                    <td id="5_5"></td>
                                    <td id="6_5" class="fin_semana"></td>
                                    <td id="7_5" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>6am</th>
                                    <td id="1_6"></td>
                                    <td id="2_6"></td>
                                    <td id="3_6"></td>
                                    <td id="4_6"></td>
                                    <td id="5_6"></td>
                                    <td id="6_6" class="fin_semana"></td>
                                    <td id="7_6" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>7am</th>
                                    <td id="1_7"></td>
                                    <td id="2_7"></td>
                                    <td id="3_7"></td>
                                    <td id="4_7"></td>
                                    <td id="5_7"></td>
                                    <td id="6_7" class="fin_semana"></td>
                                    <td id="7_7" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>8am</th>
                                    <td id="1_8"></td>
                                    <td id="2_8"></td>
                                    <td id="3_8"></td>
                                    <td id="4_8"></td>
                                    <td id="5_8"></td>
                                    <td id="6_8" class="fin_semana"></td>
                                    <td id="7_8" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>9am</th>
                                    <td id="1_9"></td>
                                    <td id="2_9"></td>
                                    <td id="3_9"></td>
                                    <td id="4_9"></td>
                                    <td id="5_9"></td>
                                    <td id="6_9" class="fin_semana"></td>
                                    <td id="7_9" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>10am</th>
                                    <td id="1_10"></td>
                                    <td id="2_10"></td>
                                    <td id="3_10"></td>
                                    <td id="4_10"></td>
                                    <td id="5_10"></td>
                                    <td id="6_10" class="fin_semana"></td>
                                    <td id="7_10" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>11am</th>
                                    <td id="1_11"></td>
                                    <td id="2_11"></td>
                                    <td id="3_11"></td>
                                    <td id="4_11"></td>
                                    <td id="5_11"></td>
                                    <td id="6_11" class="fin_semana"></td>
                                    <td id="7_11" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th rowspan="6" class="horario">Tarde</th>
                                    <th>12pm</th>
                                    <td id="1_12"></td>
                                    <td id="2_12"></td>
                                    <td id="3_12"></td>
                                    <td id="4_12"></td>
                                    <td id="5_12"></td>
                                    <td id="6_12" class="fin_semana"></td>
                                    <td id="7_12" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>1pm</th>
                                    <td id="1_13"></td>
                                    <td id="2_13"></td>
                                    <td id="3_13"></td>
                                    <td id="4_13"></td>
                                    <td id="5_13"></td>
                                    <td id="6_13" class="fin_semana"></td>
                                    <td id="7_13" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>2pm</th>
                                    <td id="1_14"></td>
                                    <td id="2_14"></td>
                                    <td id="3_14"></td>
                                    <td id="4_14"></td>
                                    <td id="5_14"></td>
                                    <td id="6_14" class="fin_semana"></td>
                                    <td id="7_14" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>3pm</th>
                                    <td id="1_15"></td>
                                    <td id="2_15"></td>
                                    <td id="3_15"></td>
                                    <td id="4_15"></td>
                                    <td id="5_15"></td>
                                    <td id="6_15" class="fin_semana"></td>
                                    <td id="7_15" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>4pm</th>
                                    <td id="1_16"></td>
                                    <td id="2_16"></td>
                                    <td id="3_16"></td>
                                    <td id="4_16"></td>
                                    <td id="5_16"></td>
                                    <td id="6_16" class="fin_semana"></td>
                                    <td id="7_16" class="fin_semana"></td>
                                </tr>
                                 <tr>
                                    <th>5pm</th>
                                    <td id="1_17"></td>
                                    <td id="2_17"></td>
                                    <td id="3_17"></td>
                                    <td id="4_17"></td>
                                    <td id="5_17"></td>
                                    <td id="6_17" class="fin_semana"></td>
                                    <td id="7_17" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th rowspan="6" class="horario">Noche</th>
                                    <th>6pm</th>
                                    <td id="1_18"></td>
                                    <td id="2_18"></td>
                                    <td id="3_18"></td>
                                    <td id="4_18"></td>
                                    <td id="5_18"></td>
                                    <td id="6_18" class="fin_semana"></td>
                                    <td id="7_18" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>7pm</th>
                                    <td id="1_19"></td>
                                    <td id="2_19"></td>
                                    <td id="3_19"></td>
                                    <td id="4_19"></td>
                                    <td id="5_19"></td>
                                    <td id="6_19" class="fin_semana"></td>
                                    <td id="7_19" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>8pm</th>
                                    <td id="1_20"></td>
                                    <td id="2_20"></td>
                                    <td id="3_20"></td>
                                    <td id="4_20"></td>
                                    <td id="5_20"></td>
                                    <td id="6_20" class="fin_semana"></td>
                                    <td id="7_20" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>9pm</th>
                                    <td id="1_21"></td>
                                    <td id="2_21"></td>
                                    <td id="3_21"></td>
                                    <td id="4_21"></td>
                                    <td id="5_21"></td>
                                    <td id="6_21" class="fin_semana"></td>
                                    <td id="7_21" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>10pm</th>
                                    <td id="1_22"></td>
                                    <td id="2_22"></td>
                                    <td id="3_22"></td>
                                    <td id="4_22"></td>
                                    <td id="5_22"></td>
                                    <td id="6_22" class="fin_semana"></td>
                                    <td id="7_22" class="fin_semana"></td>
                                </tr>
                                <tr>
                                    <th>11pm</th>
                                    <td id="1_23"></td>
                                    <td id="2_23"></td>
                                    <td id="3_23"></td>
                                    <td id="4_23"></td>
                                    <td id="5_23"></td>
                                    <td id="6_23" class="fin_semana"></td>
                                    <td id="7_23" class="fin_semana"></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table class="tablesorter">
                            <thead> 
                                <tr>
                                    <td colspan="7"></td>
                                </tr>                                  
                                <tr>
                                    <th width="28%" class="fin_semana"><span class="desc_periodo"></span>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;<span class="desc_year"></span></th>
                                    <th width="12%">Act. Escuela</th>
                                    <th width="12%">Act. Casa</th>
                                    <th width="12%">Act. Proniño</th>
                                    <th width="12%">Trabajando</th>
                                    <th width="12%">Jugando</th>
                                    <th width="12%">Otras Act.</th>
                                </tr>
                                <tr>
                                    <th>Numero de Horas a la Semana</th>
                                    <th id="p_actividad_1"></th>
                                    <th id="p_actividad_2"></th>
                                    <th id="p_actividad_3"></th>
                                    <th id="p_actividad_4"></th>
                                    <th id="p_actividad_5"></th>
                                    <th id="p_actividad_6"></th>
                                </tr>
                                <tr>
                                    <th colspan="7">Promedio Horas Semanales durante el Semestre ( <span id="meses_actualizados"></span> )</th>
                                </tr>
                                <tr>
                                    <th>Periodo Lectivo</th>
                                    <th id="pl_actividad_0"></th>
                                    <th id="pl_actividad_1"></th>
                                    <th id="pl_actividad_2"></th>
                                    <th id="pl_actividad_3"></th>
                                    <th id="pl_actividad_4"></th>
                                    <th id="pl_actividad_5"></th>
                                </tr>
                                <tr>
                                    <th>Periodo de Vacaciones</th>
                                    <th id="pv_actividad_0"></th>
                                    <th id="pv_actividad_1"></th>
                                    <th id="pv_actividad_2"></th>
                                    <th id="pv_actividad_3"></th>
                                    <th id="pv_actividad_4"></th>
                                    <th id="pv_actividad_5"></th>
                                </tr>
                            </thead>
                        </table>
                        
                        <table class="tablesorter">
                            <thead>
                                <tr>
                                    <th colspan="6">Meses en los que ha trabajado el niño</th>
                                </tr>
                                <tr>
                                    <th width="17%" id="desc_mes_0" class="periodo_v"></th>
                                    <th width="17%" id="desc_mes_1"></th>
                                    <th width="16.5%" id="desc_mes_2"></th>
                                    <th width="16.5%" id="desc_mes_3"></th>
                                    <th width="17%" id="desc_mes_4"></th>
                                    <th width="17%" id="desc_mes_5" class="periodo_v"></th>
                               </tr>
                               <tr>
                                    <th id="mes_0" class="periodo_v"></th>
                                    <th id="mes_1"></th>
                                    <th id="mes_2"></th>
                                    <th id="mes_3"></th>
                                    <th id="mes_4"></th>
                                    <th id="mes_5" class="periodo_v"></th>
                                </tr> 
                            </thead>      
                        </table>
                        
                        <table class="tablesorter">
                            <thead>
                                <tr>
                                    <th colspan="4">Períodos del dia en los que el niño realiza el trabajado</th>
                                </tr>
                                <tr>
                                    <th width="25%">Madrugada (12pm - 5am)</th>
                                    <th width="25%">Mañana (5am - 12am)</th>
                                    <th width="25%">Tarde (12am - 18pm)</th>
                                    <th width="25%">Noche (18pm - 12pm)</th>
                                </tr>
                                <tr>
                                    <th id="hora_0"></th>
                                    <th id="hora_1"></th>
                                    <th id="hora_2"></th>
                                    <th id="hora_3"></th>
                                </tr>
                            </thead>      
                        </table>
                       
                        <table class="tablesorter">
                            <thead>
                                <tr>
                                    <th colspan="5">Dias en los que el niño trabaja</th>
                                </tr>
                                <tr>
                                    <th width="32%">Días útiles</th>
                                    <th width="2%"></th>
                                    <th width="32%" class="fin_semana">Fines de semana</th>
                                    <th width="2%" class="fin_semana"></th>
                                    <th width="32%">Ambos</th>
                                </tr>
                                <tr>
                                    <th id="dia_0"></th>
                                    <th></th>
                                    <th id="dia_1"></th>
                                    <th></th>
                                    <th id="dia_2"></th>
                                </tr>
                            </thead>      
                        </table>
                        <div class="mini_espacio"></div> 
                        <div id="botones_actividades">
                            <input type="submit" id="guardar_mes" class="boton_gris" value="Guardar" title="Guardar Actividades"/>
                            <input type="button" id="cancelar_mes" class="boton_naranja" value="Cancelar" title="Cancelar"/>
                            &nbsp;	
                        </div>
                    </form>
                </div>                
            </div>

            <div id="resumen" style="display:none">
            	<div class="header_info">
                    RESUMEN ATENCIÓN PSICOSOCIAL                    
                    <label>
                        &nbsp;&raquo;&nbsp;
                        <span id="usuario_actualizo_resumen"></span>                            
                        &nbsp;&raquo;&nbsp;
                        <span id="fecha_actualizacion_resumen"></span> 
                        &nbsp;
                        <a href="#" id="actualizar_resumen" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                	</label> 
                </div>
	            <div>
	            	<form id="form_resumen" action="#" method="get">
	            		<input type="hidden" id="id_resumen" name="id_resumen" value="" />
	                	<input type="hidden" id="id_beneficiario_resumen" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>
	                    <input type="hidden" id="opc_resumen" name="opc" value="" />
	                    <div style="width:100%">
	                    	<div style="width:350px">
	                        	<label>Nombre Beneficiario</label>
	                        	<input type="text" name="nombre_beneficiario" id="nombre_beneficiario_resumen" class="input_l" value="" readonly />
	                        </div> 
	                        <div style="width:190px"> 
                                <label>Fecha</label><br>
                                <input type="text" name="fecha_resumen" id="fecha_resumen" class="input_c" value="" label="Digite la fecha del resumen" />                               
                            </div>
                            <div style="width:210px"> 
                                <label>Tipo</label><br>
                                <select id="tipo_resumen" class="select_l" name="tipo_resumen" label="Seleccione una Opcion">
                                	<option value="0"> - Seleccionar - </option>
		                            <option value="1"> Resumen de Intervencion </option>
		                            <option value="2"> Diagnostico y Plan de Intervencion </option>
		                            <option value="3"> Seguimiento Psicosocial </option>	
                                </select>                               
                            </div>                                                                                     
	                        <div style="width:991px" class="clear">
	                            <div class="header_diagnostico">
	                            	<label>SITUACION NNA</label><br>
	                            	RESUMEN DE INTERVENCIÓN: Situación Familiar(Tipología Familiar, Condiciones Socio económicas, Problemáticas Principales), Escolarización, Situación frente al T.I.<br>
	                            	PLAN DE INTERVENCIÓN: Considerar los recursos familiares y personales del NNA, los intereses y motivaciones del NNA. Puede estar orientado al NNA o a la familia
	                            </div>
	                            <textarea name="descripcion_resumen" id="descripcion_resumen" class="textarea_b" value="" ></textarea>        
	                        </div>
	                        	                        
	                        <div id="botones_resumen">
	                        	<input type="button" id="eliminar_resumen" class="boton_naranja" value="Eliminar" title="Eliminar Resumen" style="display:none"/>
	                            &nbsp;&there4;&nbsp;
	                            <input type="submit" id="guardar_resumen" class="boton_gris" value="Guardar" title="Guardar Resumen"/>
	                            <input type="button" id="cancelar_resumen" class="boton_naranja" value="Cancelar" title="Cancelar Resumen"/>
	                            &nbsp;&there4;&nbsp;
	                            <input type="button" id="imprimir_resumen" class="boton_azul" value="Imprimir" title="Imprimir Resumen"/>
	                            &nbsp;	
	                        </div>
	                	</div>        
	                </form>
	            </div>
	            <table id="tabla_resumen" class="tablesorter"></table>
                <div class="espacio"></div>
	       	</div>       
            
            <form id="form_year" action="#" method="get">
                <input type="hidden" id="id_beneficiario_year" name="id_beneficiario" value="" label="Seleccione un beneficiario"/>    
                <input type="hidden" id="opc_year" name="opc" value="" />        
                <div class="header_info">
                    INFORMACION DEL BENEFICIARIO EN EL PROGRAMA PRONIÑO DURANTE EL AÑO
                    <label>
                    	&nbsp;&raquo;&nbsp;
                        <span id="usuario_actualizo_year"></span>                            
                        &nbsp;&raquo;&nbsp;
                        <span id="fecha_actualizacion_year"></span>
                        &nbsp;
                        <select id="year" name="year">                              
                    	</select>
                    </label>
                </div>
                <div>
                    <!--                  
                    <div style="width:234px">
                        <label>Sitio de Trabajo</label>
                        <select id="sitio_trabajo" class="select_l" name="sitio_trabajo">
                        </select>  
                    </div>  
                    -->
                    <div style="width:230px">
                        <label class="new">Actualmente Trabaja</label></br>
                        <select id="actualmente_trabaja" class="select_l" name="actualmente_trabaja">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1">Si</option>
                            <option value="2">No</option>
                        </select>           
                    </div>
                    <div style="width:235px">
                        <label class="mov">Actividad Laboral</label>
                        <select id="actividad_laboral" class="select_l" name="actividad_laboral">
                            <option value="0"> - Seleccionar - </option>
                            <optgroup label="Urbano">
                                <option value="51">Albañil/Construcción Civil</option>
                                <option value="52">Camales/matadero</option>
                                <option value="53">Comercio formal</option>
                                <option value="54">Hilandería/ confección/Artesanía</option>
                                <option value="55">Industria de fuegos artificiales</option>
                                <option value="56">Mendicidad</option>
                                <option value="57">Recolección de materiales para reciclajes</option>
                                <option value="58">Segregación de basura, basurero</option>
                                <option value="59">Servicios</option>
                            </optgroup>
                            <optgroup label="Urbano y Rural">
                                <option value="61">Carga de mercancía, flete</option>
                                <option value="62">Caza y pesca</option>
                                <option value="63">Comercio ambulante, ferias libres, mercado, otros</option>
                                <option value="64">Conflicto armado</option>
                                <option value="65">Distribución de panfletos, malabares, servicios a automovilistas en la vía pública, otros</option>
                                <option value="66">Explotación sexual comercial, inclusive actuación y producción de materiales o espectáculos</option>
                                <option value="67">Mecánica/ eléctrica/ manutención industrial, de automóviles, de equipamientos y utensilios</option>
                                <option value="68">Negocio familiar</option>
                                <option value="69">Producción cerámica/ladrillo</option>
                                <option value="70">Producción o comercio de drogas</option>
                                <option value="71">Silvicultura</option>
                                <option value="72">Trabajo doméstico en su proprio hogar</option>
                                <option value="73">Trabajo doméstico para terceros</option>
                                <option value="74">Turismo/Hoteles/restaurantes</option>
                                <option value="75">Otro</option>
                            </optgroup>
                            <optgroup label="Rural">
                                <option value="81">Guardia o servicio militar</option>
                                <option value="82">Manejo de animales</option>
                                <option value="83">Minería</option>
                                <option value="84">Pincha de coco, castaña u otros</option>
                                <option value="85">Plantación o cosecha</option>
                            </optgroup>
                        </select>   
                    </div>  
                    <div style="width:235px">
                        <label>Actividad Especifica</label>
                        <input type="text" name="actividad_especifica" id="actividad_especifica" class="input_l" value="" />   
                    </div>
                    <div style="width:235px">
                        <label class="new">Problema Salud x el Trabajo</label>
                        <select id="problema_salud" class="select_l" name="problema_salud">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1">Auditivos</option>
                            <option value="2">Cardiológicos</option>
                            <option value="3">Dermatológicos</option>
                            <option value="4">Fonoaudiológicos</option>
                            <option value="5">Neurológicos</option>
                            <option value="6">Oftalmológicos</option>
                            <option value="7">Odontológicos</option>
                            <option value="8">Respiratorios</option>
                            <option value="9">Traumatológicos</option>
                            <option value="10">Psicológia</option>
                            <option value="11">Sexual y Reproductiva</option>
                            <option value="12">Otro</option>
                        </select>  
                    </div>

                    <div class="clear" style="width:230px">
                        <label class="new">Ingresos Aprox. al Mes</label> 
                        <input type="text" name="ingresos_mes" id="ingresos_mes" class="input_c" value="" />
                    </div> 
                    <div style="width:235px">
                        <label class="new">En que Gasta los Ingresos</label>
                        <select id="gasta_ingresos" class="select_c" name="gasta_ingresos">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Gastos del Hogar (alimentación, vivienda) </option>
                            <option value="2"> Gastos Personales (alimentación, vestuario) </option>
                            <option value="3"> Estudios (escuela, materiales escolares, transporte para la escuela, otros cursos) </option> 
                            <option value="4"> Salud </option>
                            <option value="5"> Ahorro </option>
                            <option value="6"> Drogas </option>
                            <option value="7"> Otras Razones </option>
                        </select>  
                    </div>
                    <div style="width:235px">
                        <label class="new">Los Ingresos Percibidos son</label>
                        <select id="ingresos_percibidos" class="select_c" name="ingresos_percibidos">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Sustitutivos </option>
                            <option value="2"> Complementarios </option>
                            <option value="3"> Para Auto Sustento </option> 
                        </select>  
                    </div>
                    <div style="width:235px">
                        <label class="new">Por que Trabaja</label>
                        <select id="porque_trabaja" class="select_c" name="porque_trabaja">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Para ayudar a costear sus estudios </option>
                            <option value="2"> Para ayudar en los gastos de la casa </option>
                            <option value="3"> Para tener su propio Dinero </option> 
                            <option value="4"> Otro </option> 
                        </select>  
                    </div>  

                    <div class="clear" style="width:418px">
                        <label>Observaciones</label>
                        <textarea name="observaciones" id="observaciones_year" value="" ></textarea>
                    </div>         
                    <div style="width:265px">
                        <label class="mov">Grupo</label>
                        <select id="escuela_formacion1" class="select_l" name="escuela_formacion1">
                        </select>  
                    </div>                    
                    <!--
                    <div style="width:205px">
                        <label>Escuela de Formacion 2</label>
                        <select id="escuela_formacion2" class="select_l" name="escuela_formacion2">
                        </select>  
                    </div>
                    -->
                    <div style="width:265px">
                        <label class="new">Situacion Especial</label>
                        <select id="situacion_especial" class="select_c" name="situacion_especial">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Condicion de Discapacidad </option>
                            <option value="2"> Educación flexible </option>
                            <option value="3"> Niña o adolescente en condición de embarazo o Maternidad</option> 
                        </select>  
                    </div>                   
                    <div style="width:160px">
                        <label>Entrega Kit Escolar</label> 
                        <input type="text" name="kit_escolar" id="kit_escolar" class="input_c" value="" />
                    </div>                     
                    <!-- 
                    <div style="width:15px">&nbsp;</div>                    
                    <div style="width:160px">
                        <label>Entrega Uniforme</label> 
                        <input type="text" name="uniforme" id="uniforme" class="input_c" value="" />   
                    </div> 
                    <div style="width:15px">&nbsp;</div>  
                    <div style="width:160px">
                        <label>Entrega Zapatos</label> 
                        <input type="text" name="zapatos" id="zapatos" class="input_c" value="" />
                    </div>
                    -->
                    <div style="width:15px">&nbsp;</div>
                    <div style="width:160px">
                        <label>Visita Domiciliaria</label> 
                        <input type="text" name="visita_domiciliaria" id="visita_domiciliaria" class="input_c" value="" />
                    </div>
                    <div style="width:15px">&nbsp;</div>
                    <div style="width:160px">
                        <label class="new">Folio Unidos</label> 
                        <input type="text" name="folio_unidos" id="folio_unidos" class="input_c" value="" />
                    </div>                       
                    <!--
                    <div style="width:15px">&nbsp;</div>  
                    <div style="width:160px">
                        <label>Visita Academica</label> 
                        <input type="text" name="visita_academica" id="visita_academica" class="input_c" value="" />
                    </div>
                    <div style="width:15px">&nbsp;</div> 
                    <div style="width:160px">
                        <label>Visita Psicosocial</label> 
                        <input type="text" name="visita_psicosocial" id="visita_psicosocial" class="input_c" value="" />
                    </div>
                    <div style="width:160px">
                        <label>Interv. Psicologica</label> 
                        <input type="text" name="intervencion_psicologica" id="intervencion_psicologica" class="input_c" value="" />
                    </div> 
                    <div style="width:15px">&nbsp;</div>  
                    <div style="width:160px">
                        <label>Valoracion Medica</label> 
                        <input type="text" name="valoracion_medica" id="valoracion_medica" class="input_c" value="" />
                    </div> 
                    <div style="width:15px">&nbsp;</div>  
                    <div style="width:160px">
                        <label>Val. Odontologica</label> 
                        <input type="text" name="valoracion_odontologica" id="valoracion_odontologica" class="input_c" value="" />
                    </div>
                    -->
                    <div style="width:160px">                            
                        <input type="checkbox" id="desplazados" name="desplazados" title="Desplazados" value="1"/>
                        <label>Desplazados</label> 
                    </div>
                    <div style="width:15px">&nbsp;</div>                    
                    <div style="width:160px">                            
                        <input type="checkbox" id="familias_accion" name="familias_accion" title="Familias en Accion" value="1"/>  
                        <label>Flias. en Accion</label>
                    </div> 
                    <div style="width:15px">&nbsp;</div>                   
                    <div style="width:160px">                            
                        <input type="checkbox" id="juntos" name="juntos" title="Red Unidos" value="1"/>
                        <label>Red Unidos</label>    
                    </div>
                    <!--
                    <div style="width:150px">                            
                        <input type="checkbox" id="comedor_infantil" name="comedor_infantil" title="Comedor Infantil" value="1"/>    
                        <label>Comedor Infantil</label>
                    </div>                    
                    <div style="width:15px">&nbsp;</div>
                    <div style="width:160px">
                        <label>Kit Nutricional</label> 
                        <input type="text" name="kit_nutricional" id="kit_nutricional" class="input_c" value="" />
                    </div> 
                    <div style="width:15px">&nbsp;</div>
                    <div style="width:160px">
                        <label class="new">Visita Seguimiento</label> 
                        <input type="text" name="visita_seguimiento" id="visita_seguimiento" class="input_c" value="" />
                    </div>
                    -->    
                </div>
                
                <div class="subheader_info">
                    INFORMACION DE LA INSTITUCION
                </div>
                <div>
                    <div style="width:200px">
                        <label class="new">NNA Escolarizado</label>
                        <select id="escolarizado" class="select_l" name="escolarizado">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Si </option>
                            <option value="2"> No </option>                            
                        </select>   
                    </div>
                	<div style="width:200px">
                        <label>Municipio</label>
                        <select id="id_municipio_colegio" class="select_l" name="id_municipio">                            
                        </select>   
                    </div>
                    <div style="width:270px">
                        <label>Colegio</label>
                        <select id="id_colegio" class="select_l" name="id_colegio">
                        </select>  
                    </div>
                    <div style="width:270px">
                        <label>Sede</label>
                        <select id="id_sede" class="select_l" name="id_sede">
                        </select>   
                    </div> 
                    <div class="clear" style="width:140px">
                        <label>Grado</label>
                        <select id="grado" class="select_c" name="grado">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                            <option value="3"> 3 </option>
                            <option value="4"> 4 </option>
                            <option value="5"> 5 </option>
                            <option value="6"> 6 </option>
                            <option value="7"> 7 </option>
                            <option value="8"> 8 </option>
                            <option value="9"> 9 </option>
                            <option value="10"> 10 </option>
                            <option value="11"> 11 </option>
                        </select>  
                    </div>
                    <div style="width:140px">
                        <label>Seccion</label>
                        <select id="seccion" class="select_c" name="seccion">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                            <option value="3"> 3 </option>
                            <option value="4"> 4 </option>
                            <option value="5"> 5 </option>
                            <option value="6"> 6 </option>
                            <option value="7"> 7 </option>
                            <option value="8"> 8 </option>
                            <option value="9"> 9 </option>
                            <option value="10"> 10 </option>
                            <option value="11"> A </option>
                            <option value="12"> B </option>
                            <option value="13"> C </option>
                            <option value="14"> D </option>
                            <option value="15"> E </option>
                            <option value="16"> F </option>
                            <option value="17"> G </option>
                            <option value="18"> H </option>
                            <option value="19"> I </option>
                            <option value="20"> J </option>
                        </select>  
                    </div>
                    <div style="width:140px">
                        <label>Jornada</label>
                        <select id="jornada" class="select_c" name="jornada">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Mañana </option>
                            <option value="2"> Tarde </option>
                            <option value="4"> Noche </option>
                            <option value="3"> Sabados y/o Domingos </option>                            
                        </select>   
                    </div>
                    <div style="width:140px">
                        <label class="new">Ciclo</label>
                        <select id="ciclo" class="select_c" name="ciclo">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Ciclo I </option>
                            <option value="2"> Ciclo II </option>
                            <option value="3"> Ciclo III </option>
                            <option value="4"> Ciclo IV </option>
                            <option value="5"> Ciclo V </option>
                        </select>
                        
                    </div>
                    <div style="width:372px;display:none">
                        <label>Coordinador Colegio</label>
                        <input type="text" name="coordinador" id="coordinador" class="input_l" value="" readonly />   
                    </div>                     
                    <div style="width:372px;text-align:right">
                        <div style="width:362px;height:2px">&nbsp;</div>
                    	<input type="button" id="eliminar_year" class="boton_naranja" value="Eliminar" title="Eliminar Informacion del Año Actual" style="display:none"/>
                        &nbsp;&there4;&nbsp;
                        <input type="submit" id="guardar_year" class="boton_gris" value="Guardar" title="Guardar Informacion del Año Actual"/>
                        <input type="button" id="cancelar_year" class="boton_naranja" value="Cancelar" title="Cancelar"/>
                    </div> 
                    
                    <div id="botones_l">
                        &nbsp;
                        <input type="button" id="ver_diagnostico" class="boton_azul" value="Diagnostico" title="Diagnostico Inicial"/>
                        <input type="button" id="ver_seguimiento" class="boton_azul" value="Seguimientos" title="Seguimiento Visitas Domiciliarias"/>
                        <input type="button" id="ver_psicosocial" class="boton_azul" value="Psicosocial" title="Atencion Psicosocial"/> 
                        &nbsp;&there4;&nbsp;
                        <input type="button" id="ver_mes" class="boton_azul" value="Actividades" title="Horario Actividades Beneficiario" style="display:none"/>
                        <input type="button" id="ver_resumen" class="boton_naranja" value="Resumen" title="Resumen"/> 
                    </div>  
                                 
                    <div id="botones_r">
                        &nbsp;&there4;&nbsp;
                        <input type="button" id="lista_beneficiario" class="boton_azul" value="Listado" title="Lista Beneficiarios"/>
                        &nbsp;
                     </div> 
                </div>
            </form>                
            
            <div class="clear" id="notas" style="display:none"> 
                <div class="header_info">
                    NOTAS
                </div>               	
                <form id="form_nota" action="#" method="get">
                    <input type="hidden" id="id_beneficiario_nota" name="id_beneficiario" value="" label="Seleccione un beneficiario"/> 
                    <input type="hidden" id="year_nota" name="year" value="" label="Seleccione un año"/> 
                    <input type="hidden" id="opc_nota" name="opc" value="" />                 	
                    <table class="tablesorter" id="tabla_notas">                        
                        <thead>
                            <tr>
                                <th width="10%">Periodo</th>
                                <th width="12%">Materia</th>
                                <th width="10%">Tipo Nota</th>
                                <!--
                                <th width="8%">Nota</th>
                                -->
                                <th width="40%">Observaciones</th>
                                <th width="28%">Fecha Actualizacion</th>
                            </tr>
                       	</thead>
                        <tbody id="desc_notas">
                        </tbody>
                       	<tfoot>     
                            <tr>
                                <th>
                                    <select id="periodo" class="select_l" name="periodo" label="Seleccione un periodo">
                                        <option value="0"> - Seleccionar - </option>
                                        <option value="1"> 1 </option>
                                        <option value="2"> 2 </option>
                                        <option value="3"> 3 </option>
                                        <option value="4"> 4 </option>                                            
                                    </select> 
                                </th>
                                <th>
                                    <select id="materia" class="select_l" name="materia" label="Seleccione una materia"> 
                                        <option value="0"> - Seleccionar - </option>
                                        <option value="1"> ESPAÑOL </option>
                                        <option value="2"> MATEMATICAS </option>                                  
                                    </select>
                                </th>
                                <th>
                                    <select id="tipo_nota" class="select_l" name="tipo_nota" label="Seleccione un tipo de nota">
                                        <option value="0"> - Seleccionar - </option>
                                        <option value="1"> Deficiente </option>
                                        <option value="2"> Regular </option> 
                                        <option value="3"> Bueno </option>
                                        <option value="4"> Excelente </option>                                 
                                    </select>
                                </th>
                                <th style="display:none">
                                    <input type="text" name="nota" id="nota_periodo" class="input_c" value="" label="Digite la nota"/>
                                </th>
                                <th>
                                    <input type="text" name="observaciones" id="observaciones_nota" class="input_l" value="" />
                                </th>
                                <th style="text-align:right">
                                	<input type="button" id="eliminar_nota" class="boton_naranja" value="Eliminar" title="Eliminar"/>	
                                	&nbsp;&there4;&nbsp;
                                    <input type="submit" id="guardar_nota" class="boton_gris" value="Guardar" title="Guardar Nota"/>	
                                    <input type="button" id="cancelar_nota" class="boton_naranja" value="Cancelar" title="Cancelar"/>	                                    
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </form> 
            </div> 
                            
            <div class="clear"></div>
        </div>             
    </div> 
       
    <div class="espacio"></div>    
    
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a> 
            &nbsp;|&nbsp;        	
        	<a href="../">SGC</a> 
            &nbsp;|&nbsp;            
        	<a href="administracion.php">Administracion</a>
            &nbsp;|&nbsp;
            <a href="doc/ayuda.pdf" target="_blank" id="ayuda" title="Ayuda">&nbsp;&nbsp;&nbsp;</a>
     	</div>       
    </div> 
    
    <div id="error"></div>
</body>
</html>
