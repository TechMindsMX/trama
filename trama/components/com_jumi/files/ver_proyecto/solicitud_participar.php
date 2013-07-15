<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");
?>

<?php
function participar($json) {
	JHTML::_('behavior.modal');
	$usuario = JFactory::getUser();
	$producer = JFactory::getUser($json -> userId);
	
	$accion = MIDDLE.'';
	
	$script = '';
	
	$html = $script.'<p>' . '<a class="button" href="#" data-rokbox="" data-rokbox-element="div.modalcontact">' .
			 JText::_('SOLICITA_PARTICIPAR') . '</a>' .
			 '</p>' . 
			 '<div class="esconder">' . 
			 '<div class="modalcontact">' . 
			 '<div class="inside" style="width: 300px;">' . 
			 '<form id="solicitud" action="/sourcetree/trama/test.php" method="post">' . 
			 '<label for="nombre">'.JText::_('USUARIO').'</label>'.
			 '<input id="nombre" type="text" value="' . $usuario -> name . '" readonly />' . 
			 '<label for="mensaje">'.JText::_('MENSAJE').'</label>' . 
			 '<textarea id="mensaje" name="mensaje"></textarea>' . 
			 '<input type="hidden" name="proyId" value="' . $producer -> id . '" />' . 
			 '<input type="hidden" name="remitente" value="' . $usuario -> id . '" />' . 
			 '<input type="submit" value="Enviar" id="enviar"/>' . 
			 '</form>' . 
			 '</div>' . 
			 '</div>' . 
			 '</div>';
		return $html;
}
?>
