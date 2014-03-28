
function datosxCP() {
	jQuery('input[name$="perfil_codigoPostal_idcodigoPostal"]').on("focusout keydown keyup",function (e) {
		var campoCP = jQuery(this).parent().parent();
		var code = e.keyCode || e.which; 
		var cp = jQuery(this).val();

		if(cp.length == 5 && code != 13){
			var select_colonias = jQuery(this).parent().next().children('select');
			jQuery('option', select_colonias).remove();
			
			var request = $.ajax({
				url:"libraries/trama/js/ajax.php",
				data: {
					"cp": this.value,
					"fun": '2'
				},
				type: 'post'
			});
		
			request.done(function(result){
				var obj 			= eval('('+result+')');
				var colonias 		= obj.dAsenta;
				var select_colonias = jQuery(campoCP).find('select[name$="colonias_idcolonias"]');
				var select_edos 	= jQuery(campoCP).find('select[name$="estado_idestado"]');
				var select_deleg 	= jQuery(campoCP).find('select[name$="delegacion_iddelegacion"]');
				
				jQuery('option', select_colonias).remove();
				jQuery('option', select_edos).remove();
				jQuery('option', select_deleg).remove();
									
				jQuery.each(colonias, function (key, value){
					select_colonias.append(new Option(value, value));
				});
				
				select_edos.append(new Option(obj.dEstado, obj.dEstado));
				select_deleg.append(new Option(obj.dMnpio, obj.dMnpio));
			});
		
			request.fail(function (jqXHR, textStatus) {
				console.log(jqXHR);
			});
		}
	});
}