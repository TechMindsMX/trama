<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");
?>
<script>
	jQuery("#solicitud").submit(function() {
		
		console.log(jQuery("#mensaje").val().length);
		// if (jQuery("#mensaje").val().length >= 3) {
			// jQuery("span").text("Validated...").show();
			// return true;
		// }
		// jQuery("span").text("Not valid!").show().fadeOut(4000);
		// return false;
	});
</script>

<?php
function participar($json) {
	JHTML::_('behavior.modal');
	$usuario = JFactory::getUser();
	$producer = JFactory::getUser($json -> userId);
	
	$script = '<script>'.
			'jQuery("#solicitud").submit(function() {'.
				
				'console.log(jQuery("#mensaje").val().length);'.
				// if (jQuery("#mensaje").val().length >= 3) {
					// jQuery("span").text("Validated...").show();
					// return true;
				// }
				// jQuery("span").text("Not valid!").show().fadeOut(4000);
				// return false;
			'});'.
			'</script>';

	$html = $script.'<p>' . '<a class="button" href="#" data-rokbox="" data-rokbox-element="div.modalcontact">' .
			 JText::_('SOLICITA_PARTICIPAR') . '</a>' .
			 '</p>' . 
			 '<div class="esconder" style="position: absolute; left: -1000px;">' . 
			 '<div class="modalcontact">' . 
			 '<div class="inside" style="width: 300px;">' . 
			 '<form id="solicitud" action="" method="post">' . 
			 '<label for="nombre">'.JText::_('USUARIO').'</label>'.
			 '<input id="nombre" type="text" name="remitente" value="' . $usuario -> name . '" disabled />' . 
			 '<label for="mensaje">'.JText::_('MENSAJE').'</label>' . 
			 '<textarea id="mensaje" name="mensaje"></textarea>' . 
			 '<input type="hidden" name="proyId" value="' . $producer -> id . '" />' . 
			 '<input type="submit" value="Enviar" />' . 
			 '</form>' . 
			 '</div>' . 
			 '</div>' . 
			 '</div>';
	// $html = '<a href="#esconder" class="modal" rel="{size: {x: 50%, y: 500}}" id="modalLink1">Click here to see this interesting page</a>'.
			 // '<div id="esconder" style="display: none;">' . 
			 // '<div class="modalcontact">' . 
			 // '<div class="inside" style="width: 300px;">' . 
			 // '<form id="solicitud" action="" method="post">' . 
			 // '<input id="nombre" type="text" name="remitente" value="' . $usuario -> name . '" disabled />' . 
			 // '<label for="mensaje">Mensaje</label>' . 
			 // '<textarea name="mensaje"></textarea>' . 
			 // '<input type="hidden" name="proyId" value="' . $producer -> id . '" />' . 
			 // '<input type="submit" value="Enviar" />' . 
			 // '</form>' . 
			 // '</div>' . 
			 // '</div>' . 
			 // '</div>';
		return $html;
}
?>
