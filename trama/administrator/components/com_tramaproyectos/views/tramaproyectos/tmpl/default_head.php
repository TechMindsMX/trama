<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
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
        	<div style="margin-top: 10px;">
        		<select id="filtroStatus" name="filtro_status">
	    			<option value="all">Seleccione un filtro</option>
	    			<option value="0">Desarollo</option>
	    			<option value="1">En Revision</option>
	    			<option value="2">Observaciones</option> 
	    			<option value="3">Corregido</option>
	    			<option value="4">Rechazado</option>
	    			<option value="5">Autorizado</option>
	    			<option value="6">Produccion</option>
	    			<option value="7">Presentacion</option>
	    			<option value="8">Finalizado</option>
	    			<option value="9">Listo para revision</option>
	    		</select>
        	</div>
        </th>
</tr>