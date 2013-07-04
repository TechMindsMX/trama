<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$usuario = JFactory::getUser();
?>
<script>
	jQuery(document).ready(function(){		
		jQuery("#form2").validationEngine();
		
		jQuery("#enviar").click(function (){
			var form = jQuery("#form2")[0];
			var total = form.length;
			
			var user = <?php echo $usuario->id; ?>;;
	
			}
			
			jQuery("#form2").submit();
		});
</script>

<?php 
function participar() {
	$usuario = JFactory::getUser();
	$html = '<p>'.
			'<a class="button" href="#" data-rokbox="" data-rokbox-element="div.modalcontact">'.JText::_('SOLICITA_PARTICIPAR').'</a>'.
			'</p>'.
			'<div class="esconder" style="position: absolute; left: -1000px;">'.
			'<div class="modalcontact">'.
			'<div class="inside" style="width: 300px;">'.
			'<form id="" action="" method="post">'.
			'<input id="nombre" type="text" name="remitente" value="'. $usuario->name .'" disabled />'.
			'<label for="mensaje">Mensaje</label>'.
			'<textarea name="mensaje"></textarea>'.
			'<input type="hidden" name="receptor" /><input type="submit" value="Enviar" />'.
			'</form>'.
			'</div>'.
			'</div>'.
			'</div>';
	// <a href="#" data-rokbox="" data-rokbox-element="div.popup_contact"></a>
	return $html;
}
?>
