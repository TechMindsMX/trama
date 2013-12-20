<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
jimport('trama.class');

$document 	= JFactory::getDocument();
$app 		= JFactory::getApplication();
$status		= $app->input->get('status', '', 'string');
$name		= $app->input->get('name', '', 'string');

if($status != '' && $name != ''){
	foreach($this->items as $key => $value){
		if($value->id == $name){
			$name = $value->name;
		}
	}
	$app->enqueueMessage('"'.$name.'"'.JText::_('COM_TRAMAPROYECTOS_LISTADO_MSG').JTrama::getStatusName($status)->fullName, 'message');
}
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
?>
<script>
	jQuery(document).ready(function () {
		jQuery('#filtroStatus').change( function() {
			var status = 'status_'+this.value;
			var limite = $('#tablaGral tr').length;
			
			if( this.value == 'all') {
				$('#tablaGral tr').fadeIn();
			} else {
				for(var i = 0; i < limite; i++) {
				    if( ($('#tablaGral tr')[i].id != status) && ($('#tablaGral tr')[i].id != '') ) {
				    	$('#tablaGral tr#'+$('#tablaGral tr')[i].id).fadeOut();
				    	$('#tablaGral tr#'+status).fadeIn();
				    }
				}
			}
		});
	});
</script>
<form action="<?php echo JRoute::_('index.php?option=com_tramaproyectos'); ?>" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>