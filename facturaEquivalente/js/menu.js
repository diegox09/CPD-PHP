$(document).ready(function(){$("#submenu").empty();$("#guardar_factura").formly();$("#buscar_nombre").formly();$("#buscar_factura").formly();$("#administrar_p").formly();$("#administrar_r").formly();$("#administrar_i").formly();$("#administrar_u").formly();$("#administrar_up").formly();$("#administrar_c").formly();$("#cambiar_password").formly();$.getJSON("x09/menu.php",function(a){if(a.login){var b="";for(var c=0;c<a.menu.length;c++){b=a.menu[c].submenu;$("#submenu").append('<li><a class="submenu" href="#">'+b+'<span class="arrow"></span></a><ul id="'+b+'"></ul></li>');for(var d=0;d<a.menu[c].items.length;d++){items=a.menu[c].items[d];iniciales=a.menu[c].iniciales[d];$("#"+b).append('<li><a class="item" href="#" id="'+iniciales+'">'+items+"</a></li>")}}$(".menu").fixedMenu();if(a.user!=""){document.title=a.perfil+": "+a.user;$("#id_user").attr("value",a.idUser)}$("#submenu").show()}else $("#xsoft").load("login.html");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")});$("#guardar_factura").submit(function(a){a.preventDefault();if($("#id_user").attr("value")!=""&&$("#id_programa").attr("value")!=""){$("#cargando").show();$("#guardar").attr("disabled","disabled");var b=$("#info_factura").serialize();$.getJSON("x09/factura.php",b,function(a){if(a.consulta){$.fn.cargar(a);if($("#imprimir_factura").is(":checked")){$("#cargando").hide();window.print()}}else alert("Error al Actualizar la Informacion");$("#guardar").removeAttr("disabled");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#guardar").removeAttr("disabled");$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})}});$("#buscar_factura").submit(function(a){a.preventDefault();$("#cargando").show();$("#buscar_b").attr("disabled","disabled");$("#opc_buscar").attr("value","@buscador");var b=$(this).serialize();$.getJSON("x09/buscar_factura.php",b,function(a){$("#tabla").empty();if(a.consulta){$("#tabla").append('<thead><tr id="cabecera"><th width="5%">Tipo</th><th width="20%">Programa</th><th width="5%">Numero</th><th width="10%">Fecha</th><th width="50%">Nombre</th></tr></thead>');if(a.administrador)$("#cabecera").append('<th width="5%"></th><th width="5%"></th>');$("#tabla").append('<tbody id="body_tabla"></tbody>');var b,c=$("#id_user").attr("value");for(var d=0;d<a.idFactura.length;d++){if(a.administrador)b="cargar_factura";else{if(a.idUser[d]==c)b="cargar_factura";else b="center"}$("#body_tabla").append('<tr id="'+a.idFactura[d]+'"><td>'+a.inicFactura[d]+'</td><td class="nombre_prog">'+a.nombrePrograma[d]+'</td><td class="'+b+'">'+a.numeroFactura[d]+"</td><td>"+a.fecha[d]+'</td><td class="nombre_cli">'+a.nombreCliente[d]+"</td></tr>");if(a.administrador){$("#"+a.idFactura[d]).append('<td class="modificar_f"><img src="icons/page_edit.png" alt="" title="Modificar" /></td>');$("#"+a.idFactura[d]).append('<td class="eliminar_f"><img src="icons/page_delete.png" alt="" title="Eliminar" /></td>')}if(a.estadoFactura[d]=="2")$("#"+a.idFactura[d]+" > .cargar_factura,  #"+a.idFactura[d]+" > .center").css("background-color","#ff0000")}$("#tabla").tablesorter({widgets:["zebra"]})}else alert("No se encontro ningun Resultado");$("#buscar_b").removeAttr("disabled");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#buscar_b").removeAttr("disabled");$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})});$("#buscar_nombre").submit(function(a){a.preventDefault()});$("#administrar_p").submit(function(a){a.preventDefault();if(($("#admin_id_programa").attr("value")!=""||$("#opc_p").attr("value")=="insert")&&$("#nombre_programa").attr("value")!="")$.fn.admin_programa();else alert("Seleccione una opcion: (Modificar - Nuevo) y digite la informacion solicitada")});$("#administrar_r").submit(function(a){a.preventDefault();if(($("#admin_id_porcentaje").attr("value")!=""||$("#opc_r").attr("value")=="insert")&&$("#concepto").attr("value")!=""&&$("#admin_tarifa_iva").attr("value")!=""&&$("#admin_tarifa_reteiva").attr("value")!=""&&$("#admin_tarifa_retefuente").attr("value")!="")$.fn.admin_porcentaje();else alert("Seleccione una opcion: (Modificar - Nuevo) y digite la informacion solicitada")});$("#administrar_i").submit(function(a){a.preventDefault();if(($("#admin_id_reteica").attr("value")!=""||$("#opc_i").attr("value")=="insert")&&$("#actividad").attr("value")!=""&&$("#tarifa_ica").attr("value")!="")$.fn.admin_reteica();else alert("Seleccione una opcion: (Modificar - Nuevo) y digite la informacion solicitada")});$("#administrar_u").submit(function(a){a.preventDefault();if(($("#admin_id_usuario").attr("value")!=""||$("#opc_u").attr("value")=="insert")&&$("#admin_usuario").attr("value")!="")$.fn.admin_usuario();else alert("Seleccione una opcion: (Modificar - Nuevo) y digite la informacion solicitada")});$("#administrar_c").submit(function(a){a.preventDefault();if(($("#admin_id_persona").attr("value")!=""||$("#opc_t").attr("value")=="insert")&&$("#admin_nit_persona").attr("value")!="")$.fn.admin_cliente();else alert("Seleccione una opcion: (Modificar - Nuevo) y digite la informacion solicitada")});$("#cambiar_password").submit(function(a){a.preventDefault();$(".formlyAlert").remove();$("#opc_c").attr("value","pas");if($("#passwd_act").attr("value")!=""&&$("#passwd_new").attr("value")!=""&&$("#passwd_repeat").attr("value")!=""){if($("#passwd_new").attr("value")==$("#passwd_repeat").attr("value")){$("#cargando").show();$("#guardar_c").attr("disabled","disabled");var b=$(this).serialize();$.getJSON("x09/usuario.php",b,function(a){if(a.consulta){$("#passwd_act").attr("value","");$("#passwd_new").attr("value","");$("#passwd_repeat").attr("value","");$("#administracion").hide("slow");alert("Contraseña Cambiada Correctamente")}else{$("#cambiar_password").find(".formlyAlerts").append('<div class="formlyInvalid formlyAlert" id="error_c">La contraseña actual es Incorrecta.</div>');$("#error_c").fadeIn()}$("#guardar_c").removeAttr("disabled");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#guardar_c").removeAttr("disabled");$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})}else alert("La contraseña nueva debe ser igual en los dos campos")}});$("#numero_factura").change(function(a){$("#cargando").show();var b=$(this).attr("value");var c=$("#id_programa").attr("value");$.getJSON("x09/buscar_factura.php",{numero_factura:b,id_programa:c},function(a){if(a.login){if(a.consulta)$.fn.cargar(a);else{alert("El Numero de Factura no Existe");$.fn.limpiar()}}else $("#xsoft").load("login.html");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})});$("#nit_persona").change(function(a){var b=$(this).attr("value");if(b!=""){$("#cargando").show();$.getJSON("x09/cliente.php",{opc:"buscar",nit_persona:b},function(a){if(a.login){$("#id_persona").attr("value",a.idCliente[0]);$("#persona_natural").attr("value",a.nombreCliente[0]);$("#actividad_economica").attr("value",a.actividadEconomica[0]);$("#direccion_persona").attr("value",a.direccionCliente[0])}else $("#xsoft").load("login.html");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})}else{$("#id_persona").attr("value","");$("#persona_natural").attr("value","");$("#actividad_economica").attr("value","");$("#direccion_persona").attr("value","")}});$("#persona_natural").change(function(a){$.fn.actualizar_cliente()});$("#direccion_persona").change(function(a){$.fn.actualizar_cliente()});$("#actividad_economica").change(function(a){$.fn.actualizar_cliente()});$("#porcentajes").change(function(a){$("#cargando").show();var b=$(this).attr("value");$.getJSON("x09/porcentaje.php",{id_porcentaje:b,opc:""},function(a){if(a.login){if(a.consulta){$("#tarifa_iva").attr("value",a.tarifaIva[0]+"%");$("#tarifa_reteiva").attr("value",a.retencionIva[0]+"%");$("#retefuente").attr("value",a.retencionFuente[0]+"%")}else{$("#tarifa_iva").attr("value","");$("#tarifa_reteiva").attr("value","");$("#retefuente").attr("value","")}}else $("#xsoft").load("login.html");$.fn.subtotal();$("#cargando").delay(400).slideUp(1)}).error(function(){$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})});$("#id_reteica").change(function(a){$("#cargando").show();var b=$(this).attr("value");$.getJSON("x09/reteica.php",{id_reteica:b,opc:""},function(a){if(a.login){if(a.consulta)$("#reteica").attr("value",a.tarifa[0]);else $("#reteica").attr("value","")}else $("#xsoft").load("login.html");$.fn.subtotal();$("#cargando").delay(400).slideUp(1)}).error(function(){$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})});$("#programas_u").change(function(a){$("#cargando").show();var b=$(this).attr("value");var c=$("#admin_id_usuario").attr("value");$.getJSON("x09/programa.php",{id_programa:b,tipo_factura:"",opc:"insert",id_user:c},function(a){if(a.login){$.fn.listaProgramas_u();if(!a.consulta)alert("Error al Actualizar la Informacion")}else $("#xsoft").load("login.html");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})});$("#buscar_nombre_cliente").keyup(function(a){var b=$(this).attr("value");if(b.length>2){$("#cargando").show();$.getJSON("x09/cliente.php",{nit_persona:"",opc:"buscar_n",persona_natural:b},function(a){if(a.login){$("#mostrar_n").empty();if(a.consulta){for(var b=0;b<a.idCliente.length;b++){$("#mostrar_n").append('<ul><li class="lista"><a href="#" class="cargar_cliente" id="'+a.idCliente[b]+'" title="'+a.nitCliente[b]+'" alt="'+a.direccionCliente[b]+'" label="'+a.actividadEconomica[b]+'">'+a.nombreCliente[b]+"</a></li></ul>")}}else{$("#mostrar_n").html('<ul><li class="lista">No se encontro ningun Resultado</li></ul>')}}else $("#xsoft").load("login.html");$("#cargando").delay(400).slideUp(1)}).error(function(){$("#cargando").delay(400).slideUp(1);alert("Error: Compruebe la conexion de red de su equipo")})}else $("#mostrar_n").empty()});$(".input_r").keyup(function(a){var b=$(this).attr("id").split("_");var c=parseInt(b[1]);switch(a.keyCode){case 13:if(c<=9)$("#referencia_"+(c+1)).focus();break;case 38:if(c>1)$("#referencia_"+(c-1)).focus();break;case 40:if(c<=9)$("#referencia_"+(c+1)).focus();break}});$(".input_d").keyup(function(a){var b=$(this).attr("id").split("_");var c=parseInt(b[1]);switch(a.keyCode){case 13:if(c<=9)$("#descripcion_"+(c+1)).focus();break;case 38:if(c>1)$("#descripcion_"+(c-1)).focus();break;case 40:if(c<=9)$("#descripcion_"+(c+1)).focus();break}});$(".input_c").keyup(function(a){var b=$(this).attr("id").split("_");var c=parseInt(b[1]);switch(a.keyCode){case 13:if(c<=9)$("#cantidad_"+(c+1)).focus();break;case 38:if(c>1)$("#cantidad_"+(c-1)).focus();break;case 40:if(c<=9)$("#cantidad_"+(c+1)).focus();break;default:$.fn.subtotal();break}});$(".input_v").keyup(function(a){var b=$(this).attr("id").split("_");var c=parseInt(b[1]);switch(a.keyCode){case 13:if(c<=9)$("#valor_"+(c+1)).focus();break;case 38:if(c>1)$("#valor_"+(c-1)).focus();break;case 40:if(c<=9)$("#valor_"+(c+1)).focus();break;default:$.fn.subtotal();break}});$(".input_s").keyup(function(a){$.fn.subtotal()});$(document).keydown(function(a){if(a.keyCode==27)$(".active").removeClass("active")})})