<?php	
	session_start();
	  		
	if (!array_key_exists('id_pqr', $_SESSION))
		header("Location: index.php");
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="author" content="Diego Fernando Rodriguez Rincon">
	<title>Recepción y Tratamiento de Quejas y Reclamos</title>    
	<link id="favicon" type="image/png" rel="shortcut icon" href="img/application_view_gallery.png" />
    
    <link type="text/css" rel="stylesheet" href="css/inbox.css" />
    <link rel="stylesheet" type="text/css" href="css/ui/jquery.ui.all.css" /> 
        
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/ui/jquery.ui.core.min.js"></script>
  	<script type="text/javascript" src="js/ui/jquery.ui.datepicker.min.js"></script>    
  	<script type="text/javascript" src="js/inbox.js"></script>  
</head>	
<body>
    <div id="cargando">
        <span>Cargando <img src="img/ajax-loader.gif" /></span>
    </div>
    
    <div id="overlay" style="display:none"></div>
      
	<div id="header">    	
    	<a href="#" id="nombre_user" title=""></a>        
    	<a id="salir" href="php/salir.php" title="Salir de la aplicación">Salir</a>
        <div style="width:10%">
        	&nbsp;
        </div>
        <div style="width:10%">
        	<img src="img/logo.png" height="70" />
        </div>
        <div style="width:70%">
        	<span id="corprodinco">Corprodinco</span><br> 
        	Recepción y Tratamiento de Quejas y Reclamos        
   		</div>
        <div style="width:10%">
        	&nbsp;
        </div>
        <div class="clear"></div>
  	</div>           
	
    <div id="info">
        
        <form id="form_buscar" action="#" method="get">
            <input type="hidden" id="opc_buscar" name="opc" value="" />  
            <input type="text" id="input_buscar" name="buscar" value="1" label=""/>                     
            <input type="submit" id="pqrs_buscar" class="boton_azul" value="Buscar" title="Buscar PQRS"/>
            <input type="button" id="pqrs_nuevo" class="boton_gris" value="Nuevo" title="PQRS Nuevo"/>
        </form>
        
        <div id="resultado_pqrs">                    
            <table>                        
                <thead>
                    <tr>
                    	<th width="3%"></th>
                        <th width="10%">N. Radicacion</th>
                        <th width="8%">Fecha</th>
                        <th width="16%">Programa</th>
                        <th width="24%">Nombre Solicitante</th>
                        <th width="9%">Tipo</th>
                        <th width="30%">Descripcion</th>
                    </tr>
                </thead>
                <tbody id="pqrs">
                	<tr class="editar_pqrs">
                    	<td><a href="#"><img class="ver_pqrs" src="img/page_white_acrobat.png" title="Ver PQRS" /></a></td>
                        <td>001</td>
                        <td>22/12/2011</td>
                        <td>Colombia Humanitaria</td>
                        <td>Diego Fernando Rodriguez Rincon</td>
                        <td>Peticion</td>
                        <td>xxxxxxxxxx</td>
                    </tr>
                </tbody>
            </table> 
        </div>
        
        <div id="info_pqrs" class="formulario" style="display:none">
            <div class="header_info">                
                <a href="#">RECEPCIÓN Y TRATAMIENTO DE QUEJAS Y RECLAMOS</a>&nbsp;&nbsp;
                <a href="#" id="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </div>
            <form id="form_pqrs" action="#" method="get"> 
                <input type="hidden" id="id_pqrs" name="id_beneficiario" value="" label="Por favor seleccione un PQRS"/>
                <input type="hidden" id="opc_pqrs" name="opc" value="" />
                <div style="width:75px"> 
                    <label for="id_ciudad">Ciudad:</label>
                </div>
                <div style="width:150px">    
                    <select name="id_ciudad" id="id_ciudad" class="select_c">
                        <option value="1"> Cúcuta </option>                            
                        <option value="2"> Bucaramanga </option>
                        <option value="3"> Barrancabermeja </option>                  
                    </select> 
                </div>
                <div style="width:120px">
                    <label for="radicacion">Nro. Radicacion:</label>
                </div>
                <div style="width:125px">    
                    <input type="text" name="radicacion" id="radicacion" class="input_c" value="" />   
                </div>            
                <div style="width:50px">
                    <label for="fecha_solicitud">Fecha:</label>
                </div>
                <div style="width:125px">    
                    <input type="text" name="fecha_solicitud" id="fecha_solicitud" class="input_c" value="" />           
                </div>     
                <div style="width:75px"> 
                    <label for="id_programa">Programa:</label>
                </div>
                <div style="width:200px">    
                    <select name="id_programa" id="id_programa" class="select_c">
                        <option value="0"> - Seleccionar - </option>
                        <option value="1"> CHF </option>                            
                        <option value="2"> Colombia Humanitaria </option>
                        <option value="3"> Juntos </option>                            
                        <option value="4"> Proniño </option>                                                        
                        <option value="5"> Unidos </option>                            
                    </select> 
                </div> 
                               
                <div class="clear" style="width:170px">
                    <label for="nombre">Nombre del Solicitante:</label>
                </div>
                <div style="width:225px">     
                    <input type="text" name="nombre" id="nombre" class="input_c" value="" />   
                </div> 
                <div style="width:225px">
                    <input type="text" name="apellido" id="apellido" class="input_c" value="" />  
                </div>
                <div style="width:5px">
                    &nbsp;
                </div>
                <div style="width:10px">
                	<a href="#"><img id="editar_cliente" src="img/vcard_edit.png" title="Editar Cliente" /></a>
                </div>
                <div style="width:16px">
                    &nbsp;
                </div>                   
                <div style="width:120px">
                    <label for="documento">No. Documento:</label>
                </div>
                <div style="width:130px">    
                    <input type="text" name="documento" id="documento" class="input_c" value=""/>   
                </div> 
                
                <div style="width:75px">
                    <label for="direccion">Direccion:</label>
                </div>
                <div style="width:240px">     
                    <input type="text" name="direccion" id="direccion" class="input_c" value=""/>   
                </div>
                <div style="width:200px">    
                    <select name="id_barrio" id="id_barrio" class="select_c">
                        <option value="0"> - Seleccionar - </option> 
                        <option value="1"> Centro </option>
                        <option value="2"> Cundinamarcar </option> 
                        <option value="3"> La Playa </option> 
                        <option value="4"> Pescadero </option>                
                    </select> 
                </div>
                <div style="width:70px">
                    <label for="telefono">Telefono:</label>
                </div>
                <div style="width:130px">    
                    <input type="text" name="telefono" id="telefono" class="input_c" value=""/>   
                </div>
                <div style="width:65px">
                    <label for="celular">Celular:</label>
                </div>
                <div style="width:130px">    
                    <input type="text" name="celular" id="celular" class="input_c" value=""/>   
                </div>
                
                <div class="clear" style="width:75px">
                	<label for="tipo">Tipo:</label>
                </div>
                <div style="width:445px">    
                    <label for="peticion" title="Manifestación de solicitud que formula una persona en relación e información o servicios suministrados">Peticion</label>
                    <input type="radio" name="tipo" id="peticion" class="radio" value="1">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="queja" title="Expresión de insatisfacción referida a la prestación de un servicio o a la deficiente o inoportuna atención de una solicitud">Queja</label>
                    <input type="radio" name="tipo" id="queja" class="radio" value="2" title="">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="reclamo" title="Expresión de insatisfacción en relación con la conducta o la acción de los servidores o de los particulares que llevan a cabo una función">Reclamo</label>
                    <input type="radio" name="tipo" id="reclamo" class="radio" value="3">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="sugerencia" title="Proposición o idea que ofrece un usuario para mejorar un proceso relacionado con la prestación del servicio o el desempeño ">Sugerencia</label>
                	<input type="radio" name="tipo" id="sugerencia" class="radio" value="4">
                </div>
                <div style="width:10px">
                    &nbsp;
                </div>
                <div style="width:10px">
                	<a href="#"><img id="ver_pqrs" src="img/page_white_acrobat.png" title="Ver PQRS" /></a>
                </div>
                                    
                <div class="clear" style="width:195px">
                    <label for="descripcion" title="DESCRIPCION BREVE Y CLARA DE LA SOLICITUD">Descripcion de la Solicitud:</label>
                </div> 
                <div style="width:760px">   
                    <textarea name="descripcion" id="descripcion" class="textarea_l" value="" ></textarea>
                </div> 
                
                <div class="clear" style="width:195px">
                    <label for="id_responsable">Direccionamiento Para:</label>
                </div>
                <div style="width:225px">     
                    <select name="id_responsable" id="id_responsable" class="select_c">
                        <option value="0"> - Seleccionar - </option> 
                        <option value="1"> Diego Rodriguez </option>  
                        <option value="2"> Maritza Hernandez </option>                
                    </select>  
                </div> 
                <div style="width:50px">
                    <label for="fecha_direccionamiento">Fecha:</label>
                </div>
                <div style="width:125px">    
                    <input type="text" name="fecha_direccionamiento" id="fecha_direccionamiento" class="input_c" value="" />   
                </div> 
                <div style="width:10px">
                    &nbsp;
                </div>
                <div style="width:10px">
                	<a href="#"><img id="reenviar_pqrs" src="img/email_go.png" title="Reenviar PQRS" /></a>
                </div>                
                
                <div class="clear" style="width:195px">
                    <label for="solucion" title="COMUNICACIÓN DE LA SOLUCION O TRATAMIENTO">Solucion o Tratamiento:</label>
                </div> 
                <div style="width:760px">   
                    <textarea name="solucion" id="solucion" class="textarea_l" value="" ></textarea>
                </div> 
                
                <div class="clear" style="width:195px">
                    <label for="id_funcionario">Funcionario Soluciono:</label>
                </div>
                <div style="width:225px">     
                    <select name="id_funcionario" id="id_funcionario" class="select_c">
                        <option value="0"> - Seleccionar - </option>
                        <option value="1"> Diego Rodriguez </option>  
                        <option value="2"> Maritza Hernandez </option>             
                    </select>  
                </div>
                <div style="width:50px">
                    <label for="fecha_solucion">Fecha:</label>
                </div>
                <div style="width:125px">    
                    <input type="text" name="fecha_solucion" id="fecha_solucion" class="input_c" value="" />   
                </div>
                <div style="width:10px">
                    &nbsp;
                </div>
                <div style="width:10px">
                	<a href="#"><img id="cerrar_pqrs" src="img/lock.png" title="Cerrar PQRS" /></a>
                </div>                                    
                <div style="width:120px">
                    &nbsp;
                </div>                     
                <div style="width:180px">                        
                    <input type="submit" id="guardar_pqrs" class="boton_gris" value="Guardar" title="Guardar PQRS"/>
                    <input type="button" id="cancelar_pqrs" class="boton_naranja" value="Cancelar" title="Cancelar"/>    
                </div> 
            </form>           
            <div class="clear"></div>
        </div>             
    </div>   
        
    <div id="footer">
        <div>
            <a href="http://www.corprodinco.org" target="_blank">&copy; 2011 - Corprodinco</a>
            &nbsp;|&nbsp;
            <a href="../">Inicio</a>
            &nbsp;|&nbsp;
            <a href="pdf/pqrs_pdf.php">Formato PDF</a>
        </div>       
    </div>
    
    <div id="error"></div>
</body>
</html>