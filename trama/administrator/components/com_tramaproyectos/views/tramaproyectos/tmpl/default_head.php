<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
?>
<tr>
        <th width="5">
        	<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_HEADING_ID'); ?>
        </th>
                         
        <th>
            <?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_HEADING_GREETING'); ?>
        </th>
        <th>
        	<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_HEADING_NAMEPRODUCER');?>
        </th>
        <th>
        	<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_HEADING_TIPO');?>
        </th>
        <th>
        	<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_HEADING_STATUS'); ?>
        	<div style="margin: 10px;">
        		<select id="filtroStatus" name="filtro_status">
        			<option value="all"><?php echo JText::_('COM_TRAMAPROYECTOS_SELECT_FILTER'); ?></option>
	        		<?php
	        		foreach (JTrama::getStatus() as $key => $value) {
	        			$status = JTrama::getStatusName($value->id);
	        			echo '<option value="'.$value->id.'">'.$status->fullName.'</option>';
	    			}
	    			?>
	    		</select>
        	</div>
        </th>
        <th>
        	<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_HEADING_CALIFICADOR'); ?>
        </th>
        <th>
        	<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_HEADING_MODIFICADO'); ?>
        </th>
</tr>