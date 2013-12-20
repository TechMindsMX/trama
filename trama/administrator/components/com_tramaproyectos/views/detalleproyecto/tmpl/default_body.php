<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
jimport('trama.class');

$token 		= JTrama::token();
$adminId 	= JFactory::getUser();
$proyeto 	= $this->items;
$urls 		= new JTrama;
$urls1 		= $urls->getEditUrl($proyeto);
$boton 		= '';

switch ( $proyeto->status ) {
	case 1:
		$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND2').'" />';
		$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND4').'" />';
		$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND5').'" />';
		break;
	case 2:
		$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND3').'" />';
		break;
	case 3:
		if( count($proyeto->logs) < 2 ){
			$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND2').'" />';
		}
		$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND4').'" />';
		$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND5').'" />';
		break;
	case 9:
		$boton .= '<input type="button" class="submit" value="'.JText::_('COM_TRAMAPROYECTOS_SEND1').'" />';
		break;
		
	default:
		
		break;
}

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
<input type="hidden" name="callback" id="callback" size="200"/>
<input type="hidden" name="task" value="" />
<input type="hidden" name="token" value="<?php echo $token;?>" />
<tr class="row">
	<td width="100%" valign="top">
		<div style="padding-right: 20px;">
			<div style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px;">
				<?php echo $proyeto->name; ?>
			</div>
			<div style="margin-bottom:10px; color:#FF0000;">
				<?php echo JTrama::tipoProyProd($proyeto).' - '.JTrama::getStatusName($proyeto->status)->fullName; ?>			
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
				<input type="hidden" name="status" class="statuschange" />
								
				<div>
					<?php echo JText::_('COM_TRAMAPROYECTOS_COMMENTS'); ?><br />
					<textarea name="comment" rows="15" cols="100"></textarea>
				</div>
				
				<div style="margin-top:10px;">
					<input type="button" value="<?php echo JText::_('COM_TRAMAPROYECTOS_CANCEL'); ?>" onclick="javascript:window.history.back()">
					<?php echo $boton; ?>
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
							 '<div><strong>'.JText::_("COM_TRAMAPROYECTOS_STATUS").'</strong>: '.JTrama::getStatusName($value->status)->fullName.'</div>'.
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