<?php
	session_start();	
	if(!array_key_exists('id_pn', $_SESSION)) {
		header('Location: index.php');
	}
?>	
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Proniño</title>  
  	<link rel="shortcut icon" href="img/application_view_gallery.png" type="image/ico" />
    <link rel="stylesheet" type="text/css" href="css/tablesorter.min.css" /> 
  	<link rel="stylesheet" type="text/css" href="css/administracion.css" />
  	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script> 
    <script type="text/javascript" src="js/tablesorter.min.js"></script>
  	<script type="text/javascript" src="js/administracion.js"></script>
</head>
<body>	
	<div id="cargando">
    	<span>Cargando <img src="img/ajax-loader.gif" /></span>
    </div>
    
	<div id="header">    	
    	<span id="nombre_user" ></span>
    	<a id="salir" href="php/salir.php" title="Salir de la aplicación">Salir</a>        
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
    
    <div id="consulta" style="display:none">Usuario no Autorizado</div>
             
	<div id="info"> 
    	<div id="menu" style="display:none">
        	<ul id="lista">
            	<li style="display:none"><a href="#" class="lista" label="actividad">Actividad Laboral</a></li>           	
                <li><a href="#" class="lista" label="ars">Ars</a></li>
                <li id="li_asignar" style="display:none"><a href="#" class="lista" label="asignar">Asignar Usuarios</a></li>
                <li><a href="#" class="lista" label="passwd">Cambiar Contraseña</a></li>
                
                <li>
                	<a href="#" class="lista" label="departamento">Departamento</a>
                    <ul>
                        <li>
                            <a href="#" class="lista" label="municipio">Municipio</a>
                            <ul>
                                <li><a href="#" class="lista" label="barrio">Barrio</a></li>
                                <li><a href="#" class="lista" label="colegio">Colegio</a>
                                    <ul>
                                        <li><a href="#" class="lista" label="sede">Sede Colegio</a></li>
                                    </ul>    
                                </li>
                                <li><a href="#" class="lista" label="listado">Listado PDF</a></li>
                            </ul>
                        </li>
                   	</ul>     
                </li> 
                
                <li><a href="#" class="lista" label="escuela">Escuela Formacion</a></li>
                <li id="li_exportar" style="display:none"><a href="#" class="lista" label="exportar">Exportar Excel</a></li>	
                <li id="li_importar" style="display:none"><a href="#" class="lista" label="importar">Importar Excel</a></li>
                <li style="display:none"><a href="#" class="lista" label="sitio">Sitio Trabajo</a></li>
                <li id="li_usuario" style="display:none"><a href="#" class="lista" label="usuario">Usuario</a></li>
            </ul>
        </div>
     
     	<div>
            <div class="formulario" id="div_importar" style="display:none">
                <div class="header_info">
                    IMPORTAR EXCEL                
                </div>
                <form id="form_importar" action="xls/importar.php" method="post" enctype="multipart/form-data">	
                    <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />
                    <div style="width:150px">
                        <label>Año:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <select id="year_importar" class="select_l" name="year">                     
                        </select>
                    </div>
                    <div style="width:150px" class="clear">
                        <label>Seleccionar Archivo:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <input class="input_l" id="file_importar" name="userfile" type="file" label="Seleccione un Archivo">
                    </div>  
                    <div class="clear" style="width:440px;text-align:right">                 	
                        <input type="button" id="importar" class="boton_naranja" value="Importar" title="Importar Base de Datos">
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            
            <div class="formulario" id="div_asignar" style="display:none">
                <div class="header_info">
                    ASIGNAR USUARIOS               
                </div>
                <form id="form_asignar" action="xls/asignar.php" method="post" enctype="multipart/form-data">	
                    <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />                    
                    <div style="width:150px" class="clear">
                        <label>Seleccionar Archivo:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <input class="input_l" id="file_asignar" name="userfile" type="file" label="Seleccione un Archivo">
                    </div>                                         
                    <div class="clear" style="width:440px;text-align:right">                   	
                        <input type="button" id="asignar" class="boton_azul" value="Asignar" title="Asignar Usuarios">
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            
            <div class="formulario" id="div_exportar" style="display:none">
                <div class="header_info">
                    EXPORTAR EXCEL                 
                </div>
                <form id="form_exportar" action="#" method="get" >
                    <div style="width:150px">
                        <label>Año:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <select id="year_exportar" class="select_l" name="year">                     
                        </select>
                    </div>   
                    <div style="width:150px">
                        <label>Departamento:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_departamento_exportar" class="select_l" name="id_departamento" label="Seleccione un Departamento">
                        </select>
                    </div>
                    <div style="width:150px">
                        <label>Periodo:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_periodo_exportar" class="select_l" name="id_periodo" label="Seleccione un Periodo">
                        	<option value="0"> - Seleccionar - </option>
                            <option value="1"> Enero - Junio </option>                            
                            <option value="7"> Julio - Diciembre </option>
                        </select>
                    </div>
                    <div style="width:150px">
                        <label>Actividad:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_actividad_exportar" class="select_l" name="id_actividad" label="Seleccione una Actividad">
                        	<option value="0"> - Seleccionar - </option>
                            <option value="1"> Actividades en la Escuela </option>                            
                            <option value="2"> Actividades en la Casa </option>
                            <option value="3"> Actividades Proniño </option>
                            <option value="4"> Trabajando </option> 
                            <option value="5"> Jugando </option>
                            <option value="6"> Otras Actividades </option>
                        </select>
                    </div>          
                    <div class="clear" style="width:440px;text-align:right">  
                        <input type="button" id="exportar" class="boton_azul" value="Base de Datos" title="Exportar Base de Datos"/>
                        &nbsp;&there4;&nbsp;
                        <input type="button" id="exportar_act" class="boton_naranja" value="Resumen" title="Exportar Resumen"/>
                        &nbsp;&there4;&nbsp;
                        <input type="button" id="exportar_ti" class="boton_gris" value="Resumen x Actividades" title="Exportar Consolidado X Actividades"/>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            
            <div class="formulario" id="div_listado" style="display:none">
                <div class="header_info">
                    LISTADO PDF                 
                </div>
                <form id="form_listado" action="#" method="get" >
                    <div style="width:150px">
                        <label>Año:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <select id="year_listado" class="select_l" name="year">                     
                        </select>
                    </div>   
                    <div style="width:150px">
                        <label>Nombre Municipio:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_municipio_listado" class="select_l" name="id_municipio" label="Seleccione un Municipio">
                        </select>
                    </div>
                    <div style="width:150px">
                        <label>Nombre Colegio:</label>
                    </div>
                    <div style="width:270px"> 
                        <select id="id_colegio_listado" class="select_l" name="id_colegio" label="Seleccione un Colegio">
                        </select>
                    </div>          
                    <div class="clear" style="width:440px;text-align:right"> 
                        <input type="button" id="listado_pdf" class="boton_azul" value="Listado" title="Listado PDF"/>
                    </div>
                </form>
                <div class="clear"></div>
            </div> 
            
            <div class="formulario" id="div_actividad" style="display:none">
                <div class="header_info">
                    ACTIVIDAD LABORAL
                    ( <span id="span_actividad" class="span"></span> )
                    <a href="#" id="actualizar_actividad" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_actividad" action="#" method="get">
                    <input type="hidden" id="id_actividad" name="id" value="" />
                    <input type="hidden" id="opc_actividad" name="opc" value="" />
                    <div style="width:150px">
                        <label>Actividad Laboral:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <input type="text" id="nombre_actividad" class="input_l" name="nombre" value="" label="Digite el nombre de la Actividad"/>              
                    </div>
                    <div class="clear" style="width:440px;text-align:right"> 
                    	 <input type="button" id="nueva_actividad" class="boton_verde" value="Nueva" title="Nueva Actividad Laboral" style="display:none"/>
                        <input type="button" id="eliminar_actividad" class="boton_naranja" value="Eliminar" title="Eliminar Actividad Laboral" style="display:none"/>
                    	&nbsp;&there4;&nbsp;               	
                        <input type="submit" id="guardar_actividad" class="boton_gris" value="Buscar" title="Buscar - Guardar Actividad Laboral"/>
                        <input type="button" id="cancelar_actividad" class="boton_naranja" value="Cancelar" title="Cancelar Actividad Laboral"/>
                    </div>
                </form>
                <table class="tablesorter" id="tabla_actividad"></table> 
            </div> 
            
            <div class="formulario" id="div_ars" style="display:none">
                <div class="header_info">
                    ARS 
                    ( <span id="span_ars" class="span"></span> )
                    <a href="#" id="actualizar_ars" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_ars" action="#" method="get">
                    <input type="hidden" id="id_ars" name="id" value="" />
                    <input type="hidden" id="opc_ars" name="opc" value="" />
                    <div style="width:150px">
                        <label>Nombre ARS:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <input type="text" id="nombre_ars" class="input_l" name="nombre" value="" label="Digite el nombre de la ARS"/>              
                    </div>
                    <div class="clear" style="width:440px;text-align:right">  
                    	<input type="button" id="nueva_ars" class="boton_verde" value="Nueva" title="Nueva ARS" style="display:none"/>
                        <input type="button" id="eliminar_ars" class="boton_naranja" value="Eliminar" title="Eliminar ARS" style="display:none"/>
                    	&nbsp;&there4;&nbsp;              	
                        <input type="submit" id="guardar_ars" class="boton_gris" value="Buscar" title="Buscar - Guardar ARS"/>
                        <input type="button" id="cancelar_ars" class="boton_naranja" value="Cancelar" title="Cancelar ARS"/>
                    </div>
                </form>
                <table class="tablesorter" id="tabla_ars"></table> 
            </div>  
            
            <div class="formulario" id="div_departamento" style="display:none">
                <div class="header_info">
                    DEPARTAMENTO  
                    ( <span id="span_departamento" class="span"></span> ) 
                    <a href="#" id="actualizar_departamento" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_departamento" action="#" method="get">
                    <input type="hidden" id="id_departamento" name="id" value="" />
                    <input type="hidden" id="opc_departamento" name="opc" value="" /> 
                    <div style="width:150px">
                        <label>Nombre Dpto:</label>
                    </div>
                    <div style="width:270px">     
                        <input type="text" id="nombre_departamento" class="input_l" name="nombre" value="" label="Digite el nombre del Departamento"/>    
                    </div>
                    <div class="clear" style="width:440px;text-align:right">  
                    	<input type="button" id="nuevo_departamento" class="boton_verde" value="Nuevo" title="Nuevo Departamento" style="display:none"/>
                        <input type="button" id="eliminar_departamento" class="boton_naranja" value="Eliminar" title="Eliminar Departamento" style="display:none"/>
                    	&nbsp;&there4;&nbsp;       
                        <input type="submit" id="guardar_departamento" class="boton_gris" value="Buscar" title="Buscar - Guardar Departamento"/>               
                        <input type="button" id="cancelar_departamento" class="boton_naranja" value="Cancelar" title="Cancelar Departamento" />
                    </div>
                </form>
                <table class="tablesorter" id="tabla_departamento"></table>
            </div>       
            
            <div class="formulario" id="div_municipio" style="display:none">
                <div class="header_info">
                    MUNICIPIO  
                    ( <span id="span_municipio" class="span"></span> ) 
                    <a href="#" id="actualizar_municipio" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_municipio" action="#" method="get">
                    <input type="hidden" id="id_municipio" name="id" value="" />
                    <input type="hidden" id="opc_municipio" name="opc" value="" /> 
                    <div style="width:150px">
                        <label>Departamento:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_departamento_municipio" class="select_l" name="id_departamento" label="Seleccione un Departamento">
                        </select>
                    </div>
                    <div style="width:150px" class="clear">
                        <label>Nombre Municipio:</label>
                    </div>
                    <div style="width:270px">     
                        <input type="text" id="nombre_municipio" class="input_l" name="nombre" value="" label="Digite el nombre del Municipio"/>    
                    </div>
                    <div class="clear" style="width:440px;text-align:right"> 
                    	<input type="button" id="nuevo_municipio" class="boton_verde" value="Nuevo" title="Nuevo Municipio" style="display:none"/>
                        <input type="button" id="eliminar_municipio" class="boton_naranja" value="Eliminar" title="Eliminar Municipio" style="display:none"/> 
                    	&nbsp;&there4;&nbsp;       
                        <input type="submit" id="guardar_municipio" class="boton_gris" value="Buscar" title="Buscar - Guardar Municipio"/>               
                        <input type="button" id="cancelar_municipio" class="boton_naranja" value="Cancelar" title="Cancelar Municipio" />
                    </div>
                </form>
                <table class="tablesorter" id="tabla_municipio"></table>
            </div> 
            
            <div class="formulario" id="div_barrio" style="display:none">
                <div class="header_info">
                    BARRIO
                    ( <span id="span_barrio" class="span"></span> ) 
                    <a href="#" id="actualizar_barrio" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_barrio" action="#" method="get">
                    <input type="hidden" id="id_barrio" name="id" value="" />
                    <input type="hidden" id="opc_barrio" name="opc" value="" />
                    <div style="width:150px">
                        <label>Nombre Municipio:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_municipio_barrio" class="select_l" name="id_municipio" label="Seleccione un Municipio">
                        </select>
                    </div>  
                    <div style="width:150px" class="clear">
                        <label>Nombre Barrio:</label>
                    </div>   
                    <div style="width:270px">                 	
                        <input type="text" id="nombre_barrio" class="input_l" name="nombre" value="" label="Digite el nombre del Barrio"/>    
                    </div>
                    <div class="clear" style="width:440px;text-align:right"> 
                    	 <input type="button" id="nuevo_barrio" class="boton_verde" value="Nuevo" title="Nuevo Barrio" style="display:none"/>
                        <input type="button" id="eliminar_barrio" class="boton_naranja" value="Eliminar" title="Eliminar Barrio" style="display:none"/>
                    	&nbsp;&there4;&nbsp;        
                        <input type="submit" id="guardar_barrio" class="boton_gris" value="Buscar" title="Buscar - Guardar Barrio"/>
                        <input type="button" id="cancelar_barrio" class="boton_naranja" value="Cancelar" title="Cancelar Barrio" />
                    </div>
                </form>
                <table class="tablesorter" id="tabla_barrio"></table>
            </div> 
            
            <div class="formulario" id="div_colegio" style="display:none">
                <div class="header_info">
                    COLEGIO
                    ( <span id="span_colegio" class="span"></span> ) 
                    <a href="#" id="actualizar_colegio" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_colegio" action="#" method="get">
                    <input type="hidden" id="id_colegio" name="id" value="" />
                    <input type="hidden" id="opc_colegio" name="opc" value="" />
                    <div style="width:150px">
                        <label>Nombre Municipio:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_municipio_colegio" class="select_l" name="id_municipio" label="Seleccione un Municipio">
                        </select>
                    </div>
                    <div style="width:150px" class="clear">
                        <label>Nombre Colegio:</label>
                    </div> 
                    <div style="width:270px">                	
                        <input type="text" id="nombre_colegio" class="input_l" name="nombre" value="" label="Digite el nombre del Colegio"/>    
                    </div>
                    <div class="clear" style="width:440px;text-align:right"> 
                    	<input type="button" id="nuevo_colegio" class="boton_verde" value="Nuevo" title="Nuevo Colegio" style="display:none"/>    
                        <input type="button" id="eliminar_colegio" class="boton_naranja" value="Eliminar" title="Eliminar Colegio" style="display:none"/>
                    	&nbsp;&there4;&nbsp;
                        <input type="submit" id="guardar_colegio" class="boton_gris" value="Buscar" title="Buscar - Guardar Colegio"/>
                        <input type="button" id="cancelar_colegio" class="boton_naranja" value="Cancelar" title="Cancelar Colegio" />
                    </div>
                </form>
                <table class="tablesorter" id="tabla_colegio"></table>
            </div> 
            
            <div class="formulario" id="div_sede" style="display:none">
                <div class="header_info">
                    SEDE COLEGIO
                    ( <span id="span_sede" class="span"></span> )
                    <a href="#" id="actualizar_sede" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_sede" action="#" method="get">
                    <input type="hidden" id="id_sede" name="id" value="" />
                    <input type="hidden" id="opc_sede" name="opc" value="" />
                    <div style="width:150px">
                        <label>Nombre Municipio:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="id_municipio_sede" class="select_l" name="id_municipio" label="Seleccione un Municipio">
                        </select>
                    </div>
                    <div style="width:150px">
                        <label>Nombre Colegio:</label>
                    </div>
                    <div style="width:270px"> 
                        <select id="id_colegio_sede" class="select_l" name="id_colegio" label="Seleccione un Colegio">
                        </select>
                    </div>
                    <div style="width:150px" class="clear">
                        <label>Nombre Sede:</label>
                    </div>     
                    <div style="width:270px"> 
                        <input type="text" id="nombre_sede" class="input_l" name="nombre" value="" label="Digite el nombre de la Sede del Colegio"/>    
                    </div>
                    <div style="width:150px" class="clear">
                        <label>Coordinador:</label>
                    </div>
                    <div style="width:270px"> 
                        <input type="text" id="coordinador" class="input_l" name="coordinador" value="" label="Digite el nombre del Coordinador de la Sede del Colegio"/>    
                    </div>
                    <div class="clear" style="width:440px;text-align:right"> 
                    	<input type="button" id="nueva_sede" class="boton_verde" value="Nueva" title="Nueva Sede" style="display:none"/>             
                        <input type="button" id="eliminar_sede" class="boton_naranja" value="Eliminar" title="Eliminar Sede" style="display:none"/>
                    	&nbsp;&there4;&nbsp;        
                        <input type="submit" id="guardar_sede" class="boton_gris" value="Buscar" title="Buscar - Guardar Sede"/>
                        <input type="button" id="cancelar_sede" class="boton_naranja" value="Cancelar" title="Cancelar Sede" />
                    </div>
                </form>
                <table class="tablesorter" id="tabla_sede"></table>
            </div>  
            
            <div class="formulario" id="div_escuela" style="display:none">
                <div class="header_info">
                    ESCUELA DE FORMACION  
                    ( <span id="span_escuela" class="span"></span> )
                    <a href="#" id="actualizar_escuela" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_escuela" action="#" method="get">
                    <input type="hidden" id="id_escuela" name="id" value="" />
                    <input type="hidden" id="opc_escuela" name="opc" value="" />
                    <div style="width:150px">
                        <label>Escuela Formacion:</label>
                    </div>
                    <div style="width:270px">                 	
                        <input type="text" id="nombre_escuela" class="input_l" name="nombre" value="" label="Digite el Nombre de la Escuela"/> 	
                    </div> 
                    <div class="clear" style="width:440px;text-align:right"> 
                    	<input type="button" id="nueva_escuela" class="boton_verde" value="Nueva" title="Nueva Escuela" style="display:none"/>
                        <input type="button" id="eliminar_escuela" class="boton_naranja" value="Eliminar" title="Eliminar Escuela" style="display:none"/>
                    	&nbsp;&there4;&nbsp;       
                        <input type="submit" id="guardar_escuela" class="boton_gris" value="Buscar" title="Buscar - Guardar Escuela"/>
                        <input type="button" id="cancelar_escuela" class="boton_naranja" value="Cancelar" title="Cancelar Escuela" />
                    </div>
                </form>
                <table class="tablesorter" id="tabla_escuela"></table>
            </div>
            
            <div class="formulario" id="div_sitio" style="display:none">
                <div class="header_info">
                    SITIO DE TRABAJO
                    ( <span id="span_sitio" class="span"></span> )
                    <a href="#" id="actualizar_sitio" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_sitio" action="#" method="get">
                    <input type="hidden" id="id_sitio" name="id" value="" />
                    <input type="hidden" id="opc_sitio" name="opc" value="" />
                    <div style="width:150px">
                        <label>Sitio de Trabajo:</label>
                    </div> 
                    <div style="width:270px">                 	
                        <input type="text" id="nombre_sitio" class="input_l" name="nombre" value="" label="Digite el nombre del Sitio de Trabajo"/>              
                    </div>
                    <div class="clear" style="width:440px;text-align:right">   
                    	<input type="button" id="nuevo_sitio" class="boton_verde" value="Nueva" title="Nueva Sitio de Trabajo" style="display:none"/>
                        <input type="button" id="eliminar_sitio" class="boton_naranja" value="Eliminar" title="Eliminar Sitio de Trabajo" style="display:none"/>
                    	&nbsp;&there4;&nbsp;              	
                        <input type="submit" id="guardar_sitio" class="boton_gris" value="Buscar" title="Buscar - Guardar Sitio de Trabajo"/>
                        <input type="button" id="cancelar_sitio" class="boton_naranja" value="Cancelar" title="Cancelar Sitio de Trabajo"/>
                    </div>
                </form>
                <table class="tablesorter" id="tabla_sitio"></table> 
            </div>
            
            <div class="formulario" id="div_usuario" style="display:none">
                <div class="header_info">
                    USUARIO
                    ( <span id="span_usuario" class="span"></span> ) 
                    <a href="#" id="actualizar_usuario" class="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_usuario" action="#" method="get">
                    <input type="hidden" id="id_usuario" name="id" value="" />
                    <input type="hidden" id="opc_usuario" name="opc" value="" />                                
                    <div style="width:150px" class="clear">
                        <label>Usuario:</label>
                    </div>
                    <div style="width:270px">                	
                        <input type="text" id="usuario" class="input_l" name="usuario" value="" label="Digite el Nombre de Usuario"/>    
                    </div>                
                    <div style="width:150px" class="clear">
                        <label>Tipo Usuario:</label>
                    </div>
                    <div style="width:270px">                 	
                        <select id="tipo_usuario" class="select_l" name="tipo_usuario">
                            <option value="0"> - Seleccionar - </option>
                            <option value="1"> Profesional </option>                            
                            <option value="2"> Coordinador </option>
                            <option value="3"> Administrador </option>
                        </select>
                    </div>           
                    <div style="width:150px">
                        <label>Nombre Completo:</label>
                    </div> 
                    <div style="width:270px">
                        <input type="text" id="nombre_usuario" class="input_l" name="nombre" value="" label="Digite el nombre del Funcionario"/>    
                    </div>                      
                    <div class="clear" style="width:440px;text-align:right"> 
                    	<input type="button" id="nuevo_usuario" class="boton_verde" value="Nuevo" title="Nuevo Usuario" style="display:none"/>
                        <input type="button" id="eliminar_usuario" class="boton_naranja" value="Eliminar" title="Eliminar Usuario" style="display:none"/> 
                    	&nbsp;&there4;&nbsp;       
                        <input type="submit" id="guardar_usuario" class="boton_gris" value="Buscar" title="Buscar - Guardar Usuario"/>
                        <input type="button" id="cancelar_usuario" class="boton_naranja" value="Cancelar" title="Cancelar Usuario" />
                    </div>
                </form>
                <table class="tablesorter" id="tabla_usuario"></table>
            </div> 
            
            <div class="formulario" id="div_passwd" style="display:none">
                <div class="header_info">
                    CAMBIAR CONTRASEÑA
                </div>
                <form id="form_passwd" action="#" method="get">
                    <input type="hidden" id="id_usuario_passwd" name="id" value="" />
                    <input type="hidden" id="opc_passwd" name="opc" value="" />
                    <div style="width:150px" class="clear">
                        <label>Contraseña Actual:</label>
                    </div>
                    <div style="width:270px">                 	
                        <input type="password" id="passwd" class="input_l" name="passwd" value="" label="Digite la Contraseña Actual"/>    
                    </div> 
                    <div style="width:150px" class="clear">
                        <label>Contraseña Nueva:</label>
                    </div>
                    <div style="width:270px">                 	
                        <input type="password" id="passwd_new" class="input_l" name="passwd_new" value="" label="Contraseña Nueva"/>    
                    </div>
                    <div style="width:150px" class="clear">
                        <label>Contraseña Nueva:</label>
                    </div>
                    <div style="width:270px">                 	
                        <input type="password" id="passwd_new2" class="input_l" name="passwd_new2" value="" label="Contraseña Nueva"/>    
                    </div>
                    <div style="width:150px" class="clear">
                        <label>Email:</label>
                    </div>
                    <div style="width:270px">                 	
                        <input type="text" id="email" class="input_l" name="email" value="" label="Email"/>    
                    </div>
                    <div class="clear" style="width:440px;text-align:right">        
                        <input type="submit" id="guardar_passwd" class="boton_gris" value="Cambiar" title="Cambiar Contraseña"/>
                        <input type="button" id="cancelar_passwd" class="boton_naranja" value="Cancelar" title="Cancelar Cambio Contraseña" />
                    </div>
                </form>
            </div>
    	</div>        
    </div>
                
    <div id="espacio"></div>    
    
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a> 
            &nbsp;|&nbsp;       	
        	<a href="../">SGC</a>
            &nbsp;|&nbsp;            
        	<a href="contenido.php">Inicio</a>
            &nbsp;|&nbsp;
            <a href="doc/ayuda.pdf" target="_blank" id="ayuda" title="Ayuda">&nbsp;&nbsp;&nbsp;</a>
     	</div>       
    </div>
    
    <div id="error"></div> 
</body>
</html>