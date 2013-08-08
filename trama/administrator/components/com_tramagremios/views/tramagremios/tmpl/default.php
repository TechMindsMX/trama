<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tramagremios'); ?>" method="post" name="adminForm">
    <table class="adminlist">
        <thead>
			<tr>
		        <th width="5">
		        	<?php echo JText::_('COM_TRAMAGREMIOS_TRAMAGREMIOS_HEADING_ID'); ?>
		        </th>
		                         
		        <th>
		            <?php echo JText::_('COM_TRAMAGREMIOS_TRAMAGREMIOS_HEADING_GREETING'); ?>
		        </th>
		        <th>
		        	<?php echo JText::_('COM_TRAMAGREMIOS_TRAMAGREMIOS_HEADING_TIPO');?>
		        </th>
		        <th>
		        	<?php echo JText::_('COM_TRAMAGREMIOS_TRAMAGREMIOS_HEADING_STATUS'); ?>
		        </th>
			</tr>
		</thead>
        <tbody>
			<?php 
			
			$front = str_replace('administrator/', '', JURI::base());
			$link = $front.'index.php?option=com_jumi&view=application&fileid=17&Itemid=220&userid=';
			
			// var_dump($this);
			foreach($this->items as $i => $item):
			 ?>
				<tr class="row<?php echo $i % 2; ?>">
					<td>
						<?php echo $item->users_id; ?>
					</td>
					<td>
						<a target="_blank" href="<?php echo $link. $item->users_id; ?>"><?php echo $item->nomNombre.' '.$item->nomNombre; ?></a>
					</td>
					<td>
						<?php echo $item->nomNombreCategoria; ?>
					</td>
					<td>
						<?php echo JHtml::_('grid.boolean', $i, !$item->block, 'tramaremios.unblock', 'tramaremios.block'); ?>
					</td>
				</tr>
			<?php 
			endforeach; 
			?>
				<div>
					<input type="hidden" name="task" value="" />
					<?php echo JHtml::_('form.token'); ?>
				</div>

		</tbody>

	    <tfoot>
			<tr>
	        	<td colspan="4"><?php // echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>

    </table>
</form>