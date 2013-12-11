<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
jimport('trama.class');

$token = JTrama::token();
$adminId = JFactory::getUser();
$proyeto = $this->items;
$urls = new JTrama;
$urls1 = $urls->getEditUrl($proyeto);

if( !isset($proyeto->projectBusinessCase->name) ) {
	$bussinesCase = '';
} else {
	$bussinesCase = '<div style="margin-bottom:10px">
		<a href="'.JURI::root().BCASE.'/'.$proyeto->projectBusinessCase->name.'.xlsx" target="blank">
			'.JText::_("COM_TRAMAPROYECTOS_BCASE").'
		</a>
	</div>';
}

?>
<input type="hidden" name="callback" value="<?php echo $proyeto->callback ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="token" value="<?php echo $token;?>" />
<tr class="row">
	<td width="100%" valign="top">
		<div style="padding-right: 20px;">
			<div style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px;">
				<?php echo $proyeto->name; ?>
			</div>
			<div style="margin-bottom:10px; color:#FF0000;">
				<?php echo JTrama::tipoProyProd($proyeto).' - '.$urls::getStatusName($proyeto->status); ?>			
			</div>
			<?php echo $bussinesCase; ?>			
			<div>
				<p><?php echo JText::_('COM_TRAMAPROYECTOS_PROY_DESC'); ?></p>
				<p align="justify"><?php echo $proyeto->description; ?></p>
			</div>
			
			<div style="margin-bottom: 10px;">
				<a href="../<?php echo $urls1->viewUrl; ?>" target="blank"><?php echo JText::_('COM_TRAMAPROYECTOS_MORE'); ?></a>
			</div>
			
			<div>
				<h4 align="center"><?php echo JText::_('COM_TRAMAPROYECTOS_CHANGE_STATUS'); ?></h4>
				<input type="hidden" name="userId" value="<?php echo $adminId->id; ?>" />
				<input type="hidden" name="projectId" value="<?php echo $proyeto->id; ?>" />
				<div>
					<input type="radio" name="status" value="1" <?php echo $proyeto->status == 1?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(1); ?>
				</div>
				
				<div>
					<input type="radio" name="status" value="2" <?php echo $proyeto->status == 2?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(2); ?>
				</div>
				
				<div>
					<input type="radio" name="status" value="5" <?php echo $proyeto->status == 5?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(5); ?>
				</div>
				
				<div style="margin-bottom: 10px;">
					<input type="radio" name="status" value="4" <?php echo $proyeto->status == 4?'checked="checked"':''; ?> />
					<?php echo JTrama::getStatusName(4); ?>
				</div>		
				
				<div>
					<?php echo JText::_('COM_TRAMAPROYECTOS_COMMENTS'); ?><br />
					<textarea name="comment" rows="15" cols="100"></textarea>
				</div>
				
				<div style="margin-top:10px;">
					<input type="button" value="<?php echo JText::_('COM_TRAMAPROYECTOS_CANCEL'); ?>" onclick="javascript:window.history.back()">
					<input type="submit" value="<?php echo JText::_('COM_TRAMAPROYECTOS_SEND'); ?>" />
				</div>
			</div>
			
			<?php
			if( !empty($proyeto->logs) ) {
			?>
			<div>
				<h4 align="center"><?php echo JText::_('COM_TRAMAPROYECTOS_CHANGES'); ?></h4>
				<ul>
					<?php
					foreach ($proyeto->logs as $key => $value) {
						$fechacreacion = $value->timestamp/1000;
						echo '<div style="margin-bottom: 10px;">'.
							 '<li>'.
							 '<div><strong>'.JText::_("COM_TRAMAPROYECTOS_MODIFIED").'</strong>: '.date('d-M-Y', $fechacreacion).'</div>'.
							 '<div><strong>'.JText::_("COM_TRAMAPROYECTOS_STATUS").'</strong>: '.JTrama::getStatusName($value->status).'</div>'.
							 '<div align="justify"><strong>'.JText::_("COM_TRAMAPROYECTOS_COMMENT").'</strong>: '.$value->comment.'</div>'.
							 '</li>'.
							 '</div>';
					}
					?>
				</ul>
			</div>
			<?php
			}
			?>
		</div>
	</td>
</tr>