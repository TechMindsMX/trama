<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
JHtml::_('behavior.tooltip');
$proyeto 	= $this->items;
$document 	= JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');

?>
<style>
	input[type="button"]{
		padding: 5px 10px;
		font-size: 115%;
	}
</style>
	<script language="JavaScript">
		jQuery(document).ready(function(){
			jQuery('.submit').click(function(){
				string = this.value.split(" ");
				
				switch(string[3]){
					case 'Revisando':
						jQuery('.statuschange').val(1);
						jQuery('#callback').val("<?php echo $proyeto->callback.'&status=1&name='.$proyeto->id ?>");
						$statusName = JTrama::getStatusName(1);
						msg = "<?php echo JText::_('COM_TRAMAPROYECTOS_ESTASEGURO').$statusName->fullName.' '.JText::_('COM_TRAMAPROYECTOS_LABEL_IRREVERSIBLE'); ?> ";
						break;
					case 'Observaciones':
						jQuery('.statuschange').val(2);
						jQuery('#callback').val("<?php echo $proyeto->callback.'&status=2&name='.$proyeto->id ?>");
						$statusName = JTrama::getStatusName(2);
						msg = "<?php echo JText::_('COM_TRAMAPROYECTOS_ESTASEGURO').$statusName->fullName.' '.JText::_('COM_TRAMAPROYECTOS_LABEL_IRREVERSIBLE'); ?> ";
						break;
					case 'Corregido':
						jQuery('.statuschange').val(3);
						jQuery('#callback').val("<?php echo $proyeto->callback.'&status=3&name='.$proyeto->id ?>");
						$statusName = JTrama::getStatusName(3)
						msg = "<?php echo JText::_('COM_TRAMAPROYECTOS_ESTASEGURO').$statusName->fullName.' '.JText::_('COM_TRAMAPROYECTOS_LABEL_IRREVERSIBLE'); ?> ";
						break;
					case 'Rechazado':
						jQuery('.statuschange').val(4);
						jQuery('#callback').val("<?php echo $proyeto->callback.'&status=4&name='.$proyeto->id ?>");
						$statusName = JTrama::getStatusName(4)
						msg = "<?php echo JText::_('COM_TRAMAPROYECTOS_ESTASEGURO').$statusName->fullName.' '.JText::_('COM_TRAMAPROYECTOS_LABEL_IRREVERSIBLE'); ?> ";
						break;
					case 'Autorizado':
						jQuery('.statuschange').val(5);
						jQuery('#callback').val("<?php echo $proyeto->callback.'&status=5&name='.$proyeto->id ?>");
						$statusName = JTrama::getStatusName(5)
						msg = "<?php echo JText::_('COM_TRAMAPROYECTOS_ESTASEGURO').$statusName->fullName.' '.JText::_('COM_TRAMAPROYECTOS_LABEL_IRREVERSIBLE'); ?> ";
						break;
				}
				
				if(confirm(msg)){
					jQuery("#formstatus").submit();
				}
			})
		});
	</script>
	<form id="formstatus" action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/project/changeStatus" method="post" >
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
	</table>
</form>