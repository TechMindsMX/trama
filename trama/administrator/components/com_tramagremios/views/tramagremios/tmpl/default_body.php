<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
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
