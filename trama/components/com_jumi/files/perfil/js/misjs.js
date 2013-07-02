/*funcion para mostrat formulario extendido de persona moral*/
function toggle_noFisica(elemento) {

  if(elemento.value=="1") {
  //    document.getElementById("noFisica").style.display = "none";
    jQuery('#noFisica').hide('slow');  
   } else {
   	jQuery('#noFisica').show('slow');  
   //  document.getElementById("noFisica").style.display = "block"; 
   }

}
/*funciones para copiar informacion de campos*/
function copiarFiscal() {
    document.getElementById('doFi_nomCalle').value = document.getElementById('dire_nomCalle').value;
    document.getElementById('doFi_noExterior').value = document.getElementById('dire_noExterior').value;
    document.getElementById('doFi_noInterior').value = document.getElementById('dire_noInterior').value;
    document.getElementById('doFi_iniCodigoPostal').value = document.getElementById('dire_iniCodigoPostal').value;
    document.getElementById('doFi_nomEstado').value = document.getElementById('dire_nomEstado').value;
	document.getElementById('doFi_nomPais').value = document.getElementById('dire_nomPais').value;
	document.getElementById('doFi_nomColonias').value = document.getElementById('dire_nomColonias').value;
	document.getElementById('doFi_nomDelegacion').value = document.getElementById('dire_nomDelegacion').value;
}

function copiarRepresentante() {
    document.getElementById('repr_nomNombre').value = document.getElementById('daGr_nomNombre').value;
    document.getElementById('repr_nomApellidoPaterno').value = document.getElementById('daGr_nomApellidoPaterno').value;
    document.getElementById('repr_nomApellidoMaterno').value = document.getElementById('daGr_nomApellidoMaterno').value;
    document.getElementById('maRe_coeEmail').value = document.getElementById('maGr_coeEmail').value;
    document.getElementById('teRe_nomTipoTelefono').value = document.getElementById('teGr_nomTipoTelefono').value;	
    document.getElementById('teRe_telTelefono').value = document.getElementById('teGr_telTelefono').value;	
    document.getElementById('teRe_extension').value = document.getElementById('teGr_extension').value;
}

function copiarDomRep() {
    document.getElementById('doRe_nomCalle').value = document.getElementById('dire_nomCalle').value;
    document.getElementById('doRe_noExterior').value = document.getElementById('dire_noExterior').value;
    document.getElementById('doRe_noInterior').value = document.getElementById('dire_noInterior').value;
    document.getElementById('doRe_iniCodigoPostal').value = document.getElementById('dire_iniCodigoPostal').value;
    document.getElementById('doRe_nomEstado').value = document.getElementById('dire_nomEstado').value;
	document.getElementById('doRe_nomPais').value = document.getElementById('dire_nomPais').value;
	document.getElementById('doRe_nomColonias').value = document.getElementById('dire_nomColonias').value;
	document.getElementById('doRe_nomDelegacion').value = document.getElementById('dire_nomDelegacion').value;
}

function copiarContacto() {
    document.getElementById('daCo_nomNombre').value = document.getElementById('daGr_nomNombre').value;
    document.getElementById('daCo_nomApellidoPaterno').value = document.getElementById('daGr_nomApellidoPaterno').value;
    document.getElementById('daCo_nomApellidoMaterno').value = document.getElementById('daGr_nomApellidoMaterno').value;
    document.getElementById('maCo_coeEmail').value = document.getElementById('maGr_coeEmail').value;
    document.getElementById('teCo_nomTipoTelefono').value = document.getElementById('teGr_nomTipoTelefono').value;	
    document.getElementById('teCo_telTelefono').value = document.getElementById('teGr_telTelefono').value;	
    document.getElementById('teCo_extension').value = document.getElementById('teGr_extension').value;
}

function copiarDomCon() {
    document.getElementById('doCo_nomCalle').value = document.getElementById('dire_nomCalle').value;
    document.getElementById('doCo_noExterior').value = document.getElementById('dire_noExterior').value;
    document.getElementById('doCo_noInterior').value = document.getElementById('dire_noInterior').value;
    document.getElementById('doCo_iniCodigoPostal').value = document.getElementById('dire_iniCodigoPostal').value;
    document.getElementById('doCo_nomEstado').value = document.getElementById('dire_nomEstado').value;	
	document.getElementById('doCo_nomPais').value = document.getElementById('dire_nomPais').value;
	document.getElementById('doCo_nomColonias').value = document.getElementById('dire_nomColonias').value;
	document.getElementById('doCo_nomDelegacion').value = document.getElementById('dire_nomDelegacion').value;
}
/*funciones para agregar campos*/
/*funcion para agregar proyectos adicionales*/
var counterProy = 0;

function moreFieldsProy(campo,add) {
	if(add){
		var restantes = 3 - ((jQuery("[id^=prPa_nomNombreProyecto]").length) -1);
		if(restantes == 0) { counterProy = 2};
		if(restantes == 1) { counterProy = 1};
		if(restantes == 2) { counterProy = 0};
		if(counterProy<=1){
			var newFields = document.getElementById("readrootProy").cloneNode(true);
			newFields.id = '';
			newFields.style.display = 'block';
			var newField = newFields.childNodes;
			for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name;
				if (theName){
					newField[i].id = theName + counterProy;
					newField[i].name = theName + counterProy;
				}
			}
			var insertHere = document.getElementById("writerootProy");
			insertHere.parentNode.insertBefore(newFields,insertHere);
			counterProy++;
			
			window.onload = moreFieldsProy;
		}
	}else{
		var id = jQuery(campo).prev().attr('id');
		var counter = id.substr(id.length -1);
		counterProy = counter;				
		campo.parentNode.parentNode.removeChild(campo.parentNode);			
	}
}
/*funcion para agregar correos generales adicionales*/
var counterCorreoGr = 0;

function moreFieldsCorreoGr(campo,add) {
	if(add){
		var restantes = 3 - ((jQuery("[id^=maGr_coeEmail]").length) -1);
		if(restantes == 0) { counterCorreoGr = 2};
		if(restantes == 1) { counterCorreoGr = 1};
		if(restantes == 2) { counterCorreoGr = 0};
		if(counterCorreoGr<=1 ){
			var newFields = document.getElementById("readrootCorreoGr").cloneNode(true);
			newFields.id = '';
			newFields.style.display = 'block';
			var newField = newFields.childNodes;
			for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name;
				if (theName){
					newField[i].id = theName + counterCorreoGr;
					newField[i].name = theName + counterCorreoGr;
				}
			}
			var insertHere = document.getElementById("writerootCorreoGr");
			insertHere.parentNode.insertBefore(newFields,insertHere);
			counterCorreoGr++;
			
			window.onload = moreFieldsCorreoGr;
		}
	}else{
		var id = jQuery(campo).prev().attr('id');
		var counter = id.substr(id.length -1);
		counterCorreoGr = counter;				
		campo.parentNode.parentNode.removeChild(campo.parentNode);				
	}
}
/*funcion para agregar correos de representante adicionales*/
var counterCorreoRe = 0;

function moreFieldsCorreoRe(campo,add) {
	if(add){
		var restantes = 3 - ((jQuery("[id^=maRe_coeEmail]").length) -1);
		if(restantes == 0) { counterCorreoRe = 2};
		if(restantes == 1) { counterCorreoRe = 1};
		if(restantes == 2) { counterCorreoRe = 0};
		if(counterCorreoRe<=1){
			var newFields = document.getElementById("readrootCorreoRe").cloneNode(true);
			newFields.id = '';
			newFields.style.display = 'block';
			var newField = newFields.childNodes;
			for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name;
				if (theName){
					newField[i].id = theName + counterCorreoRe;
					newField[i].name = theName + counterCorreoRe;
				}
			}
			var insertHere = document.getElementById("writerootCorreoRe");
			insertHere.parentNode.insertBefore(newFields,insertHere);
			counterCorreoRe++;
			
			window.onload = moreFieldsCorreoRe;
		}
	}else{
		var id = jQuery(campo).prev().attr('id');
		var counter = id.substr(id.length -1);
		counterCorreoRe = counter;				
		campo.parentNode.parentNode.removeChild(campo.parentNode);				
	}
}
/*funcion para agregar correos de contacto adicionales*/
var counterCorreoCo = 0;

function moreFieldsCorreoCo(campo,add) {
	if(add){
		var restantes = 3 - ((jQuery("[id^=maCo_coeEmail]").length) -1);
		if(restantes == 0) { counterCorreoCo = 2};
		if(restantes == 1) { counterCorreoCo = 1};
		if(restantes == 2) { counterCorreoCo = 0};
		if(counterCorreoCo<=1){
			var newFields = document.getElementById("readrootCorreoCo").cloneNode(true);
			newFields.id = '';
			newFields.style.display = 'block';
			var newField = newFields.childNodes;
			for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name;
				if (theName){
					newField[i].id = theName + counterCorreoCo;
					newField[i].name = theName + counterCorreoCo;
				}
			}
			var insertHere = document.getElementById("writerootCorreoCo");
			insertHere.parentNode.insertBefore(newFields,insertHere);
			counterCorreoCo++;
			
			window.onload = moreFieldsCorreoCo;
		}
	}else{
		var id = jQuery(campo).prev().attr('id');
		var counter = id.substr(id.length -1);
		counterCorreoCo = counter;				
		campo.parentNode.parentNode.removeChild(campo.parentNode);			
	}
}
/*funcion para agregar telefonos generales adicionales*/
var counterTelGr = 0;

function moreFieldsTelGr(campo,add) {
	if(add){
		var restantes = 3 - ((jQuery("[id^=teGr_telTelefono]").length) -1);
		if(restantes == 0) { counterTelGr = 2};
		if(restantes == 1) { counterTelGr = 1};
		if(restantes == 2) { counterTelGr = 0};
		if(counterTelGr<=1){
			var newFields = document.getElementById("readrootTelGr").cloneNode(true);
			newFields.id = '';
			newFields.style.display = 'block';
			var newField = newFields.childNodes;
			for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name;
				if (theName){
					newField[i].id = theName + counterTelGr;
					newField[i].name = theName + counterTelGr;
				}
			}
			var insertHere = document.getElementById("writerootTelGr");
			insertHere.parentNode.insertBefore(newFields,insertHere);
			counterTelGr++;
			
			window.onload = moreFieldsTelGr;
		}
	}else{
		
		
		
		var id = jQuery(campo).prev().prev().attr('id');
		var counter = id.substr(id.length -1);
		counterTelGr = counter;				
		campo.parentNode.parentNode.removeChild(campo.parentNode);
	}
}

/*funcion para agregar telefonos de representante adicionales*/
var counterTelRe = 0;

function moreFieldsTelRe(campo,add) {
	if(add){
		var restantes = 3 - ((jQuery("[id^=teRe_telTelefono]").length) -1);
		if(restantes == 0) { counterTelRe = 2};
		if(restantes == 1) { counterTelRe = 1};
		if(restantes == 2) { counterTelRe = 0};
		if(counterTelRe<=1){
			var newFields = document.getElementById("readrootTelRe").cloneNode(true);
			newFields.id = '';
			newFields.style.display = 'block';
			var newField = newFields.childNodes;
			for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name;
				if (theName){
					newField[i].id = theName + counterTelRe;
					newField[i].name = theName + counterTelRe;
				}
			}
			var insertHere = document.getElementById("writerootTelRe");
			insertHere.parentNode.insertBefore(newFields,insertHere);
			counterTelRe++;
			
			window.onload = moreFieldsTelRe;
		}
	}else{
		var id = jQuery(campo).prev().prev().attr('id');
		var counter = id.substr(id.length -1);
		counterTelRe = counter;				
		campo.parentNode.parentNode.removeChild(campo.parentNode);			
	}
}
/*funcion para agregar telefonos de contacto adicionales*/
var counterTelCo = 0;

function moreFieldsTelCo(campo,add) {
	if(add){
		var restantes = 3 - ((jQuery("[id^=teCo_telTelefono]").length) -1);
		if(restantes == 0) { counterTelCo = 2};
		if(restantes == 1) { counterTelCo = 1};
		if(restantes == 2) { counterTelCo = 0};
		if(counterTelCo<=1){
			var newFields = document.getElementById("readrootTelCo").cloneNode(true);
			newFields.id = '';
			newFields.style.display = 'block';
			var newField = newFields.childNodes;
			for (var i=0;i<newField.length;i++) {
				var theName = newField[i].name;
				if (theName){
					newField[i].id = theName + counterTelCo;
					newField[i].name = theName + counterTelCo;
				}
			}
			var insertHere = document.getElementById("writerootTelCo");
			insertHere.parentNode.insertBefore(newFields,insertHere);
			counterTelCo++;
			
			window.onload = moreFieldsTelCo;
		}
	}else{
		var id = jQuery(campo).prev().prev().attr('id');
		var counter = id.substr(id.length -1);
		counterTelCo = counter;				
		campo.parentNode.parentNode.removeChild(campo.parentNode);				
	}
}

/*funciones  que valida el tipo de telefono si hay telefono*/
function validar(){
	
	if(document.formID.teGr_telTelefono.value==''){
		$("#teGr_nomTipoTelefono").removeClass("validate[required]");
	}else{
		
		
		$("#teGr_nomTipoTelefono").addClass("validate[required]");
		}
		
	if(document.formID.teGr_telTelefono00.value==''){
		$("#teGr_perfil_tipoTelefono_idtipoTelefono00").removeClass("validate[required]");
	}else{
		
		
		$("#teGr_perfil_tipoTelefono_idtipoTelefono00").addClass("validate[required]");
		}
		
	if(document.formID.teGr_telTelefono01.value==''){
		$("#teGr_perfil_tipoTelefono_idtipoTelefono01").removeClass("validate[required]");
	}else{
		
		
		$("#teGr_perfil_tipoTelefono_idtipoTelefono01").addClass("validate[required]");
		}
		
		
	if(document.formID.teRe_telTelefono.value==''){
		$("#teRe_nomTipoTelefono").removeClass("validate[required]");
	}else{
		
		
		$("#teRe_nomTipoTelefono").addClass("validate[required]");
		}
		
	if(document.formID.teRe_telTelefono00.value==''){
		$("#teRe_perfil_tipoTelefono_idtipoTelefono00").removeClass("validate[required]");
	}else{
		
		
		$("#teRe_perfil_tipoTelefono_idtipoTelefono00").addClass("validate[required]");
		}
		
	if(document.formID.teRe_telTelefono01.value==''){
		$("#teRe_perfil_tipoTelefono_idtipoTelefono01").removeClass("validate[required]");
	}else{
		
		
		$("#teRe_perfil_tipoTelefono_idtipoTelefono01").addClass("validate[required]");
		}
		
		
		
	if(document.formID.teCo_telTelefono.value==''){
		$("#teCo_nomTipoTelefono").removeClass("validate[required]");
	}else{
		
		
		$("#teCo_nomTipoTelefono").addClass("validate[required]");
		}
		
	if(document.formID.teCo_telTelefono00.value==''){
		$("#teCo_perfil_tipoTelefono_idtipoTelefono00").removeClass("validate[required]");
	}else{
		
		
		$("#teCo_perfil_tipoTelefono_idtipoTelefono00").addClass("validate[required]");
		}
		
	if(document.formID.teCo_telTelefono01.value==''){
		$("#teCo_perfil_tipoTelefono_idtipoTelefono01").removeClass("validate[required]");
	}else{
		
		
		$("#teCo_perfil_tipoTelefono_idtipoTelefono01").addClass("validate[required]");
		}
	
	

	
}
/*funciones para habilitar extension si es oficina*/
function enable() {
	if(document.formID.teGr_nomTipoTelefono.value=='3'){
$("input[name='teGr_extension']").prop('disabled',false);
        }else{
            $("input[name='teGr_extension']").prop('disabled',true);
        }
if(document.formID.teGr_perfil_tipoTelefono_idtipoTelefono00.value=='3'){
$("input[name='teGr_extension00']").prop('disabled',false);
        }else{
            $("input[name='teGr_extension00']").prop('disabled',true);
        }
if(document.formID.teGr_perfil_tipoTelefono_idtipoTelefono01.value=='3'){
$("input[name='teGr_extension01']").prop('disabled',false);
        }else{
            $("input[name='teGr_extension01']").prop('disabled',true);
        }
}
function enable2() {
if(document.formID.teRe_nomTipoTelefono.value=='3'){
$("input[name='teRe_extension']").prop('disabled',false);
        }else{
            $("input[name='teRe_extension']").prop('disabled',true);
        }
if(document.formID.teRe_perfil_tipoTelefono_idtipoTelefono00.value=='3'){
$("input[name='teRe_extension00']").prop('disabled',false);
        }else{
            $("input[name='teRe_extension00']").prop('disabled',true);
        }
if(document.formID.teRe_perfil_tipoTelefono_idtipoTelefono01.value=='3'){
$("input[name='teRe_extension01']").prop('disabled',false);
        }else{
            $("input[name='teRe_extension01']").prop('disabled',true);
        }
}
function enable3() {
if(document.formID.teCo_nomTipoTelefono.value=='3'){
$("input[name='teCo_extension']").prop('disabled',false);
        }else{
            $("input[name='teCo_extension']").prop('disabled',true);
        }
if(document.formID.teCo_perfil_tipoTelefono_idtipoTelefono00.value=='3'){
$("input[name='teCo_extension00']").prop('disabled',false);
        }else{
            $("input[name='teCo_extension00']").prop('disabled',true);
        }
if(document.formID.teCo_perfil_tipoTelefono_idtipoTelefono01.value=='3'){
$("input[name='teCo_extension01']").prop('disabled',false);
        }else{
            $("input[name='teCo_extension01']").prop('disabled',true);
        }
}