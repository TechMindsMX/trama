<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
jimport('trama.class');

$token 		= JTrama::token();
$adminId 	= JFactory::getUser();
$proyecto 	= $this->items;
$urls 		= new JTrama;
$urls1 		= $urls->getEditUrl($proyecto);
$boton 		= '';
$logsHtml	= '';
$logCount 	= 0;

foreach ($proyecto->con as $conKey => $conValue) {
	if (empty($conValue)) {
		JFactory::getApplication()->enqueueMessage(JText::_($conKey), 'error');
	}
}

foreach ($proyecto->logs as $key => $value) {
	if($value->status == 2) {
		$logCount++;
		$fechacreacion = $value->timestamp/1000;
		$logsHtml .= '<div style="margin-bottom: 10px;">'.
			 '<li>'.
			 '<div><strong>'.JText::_("COM_TRAMAPROYECTOS_MODIFIED").'</strong>: '.date('d-M-Y h:m:s', $fechacreacion).'</div>'.
			 '<div><strong>'.JText::_("COM_TRAMAPROYECTOS_STATUS").'</strong>: '.JTrama::getStatusName($value->status)->fullName.'</div>'.
			 '<div align="justify"><strong>'.JText::_("COM_TRAMAPROYECTOS_COMMENT").'</strong>: '.$value->comment.'</div>'.
			 '</li>'.
			 '</div>';
	}
}

switch ( $proyecto->status ) {
	case 1:
		$boton .= '<input type="button" class="submit yellow" value="'.JText::_('COM_TRAMAPROYECTOS_SEND2').'" />';
		$boton .= '<input type="button" class="submit red" value="'.JText::_('COM_TRAMAPROYECTOS_SEND4').'" />';
		if ($proyecto->autorizable) {
			$boton .= '<input type="button" class="submit green" value="'.JText::_('COM_TRAMAPROYECTOS_SEND5').'" />';
		} else {
			$boton .= '<input type="button" class="" value="'.JText::_('COM_TRAMAPROYECTOS_SEND5').'" disabled />';
		}
		break;
	case 2:
		$boton .= '<input type="button" class="submit green" value="'.JText::_('COM_TRAMAPROYECTOS_SEND3').'" />';
		break;
	case 3:
		if( $logCount < 3 ) {
			$boton .= '<input type="button" class="submit yellow" value="'.JText::_('COM_TRAMAPROYECTOS_SEND2').'" />';
		}
		$boton .= '<input type="button" class="submit red" value="'.JText::_('COM_TRAMAPROYECTOS_SEND4').'" />';
		if ($proyecto->autorizable) {
			$boton .= '<input type="button" class="submit green" value="'.JText::_('COM_TRAMAPROYECTOS_SEND5').'" />';
		} else {
			$boton .= '<input type="button" class="" value="'.JText::_('COM_TRAMAPROYECTOS_SEND5').'" disabled />';
		}
		break;
	case 9:
		$boton .= '<input type="button" class="submit yellow" value="'.JText::_('COM_TRAMAPROYECTOS_SEND1').'" />';
		break;
}

if( !isset($proyecto->projectBusinessCase->name) ) {
	$bussinesCase = '';
} else {
	$bussinesCase = '<div style="margin-bottom:10px">
		<a href="'.JURI::root().BCASE.'/'.$proyecto->projectBusinessCase->name.'.xlsx" target="blank">
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
				<?php echo $proyecto->name; ?>
			</div>
			<div style="margin-bottom:10px; color:#FF0000;">
				<?php echo JTrama::tipoProyProd($proyecto).' - '.JTrama::getStatusName($proyecto->status)->fullName; ?>			
			</div>
			
			<?php echo '<h3>'.JText::_('TABLA_FINANZAS').'</h3>'.$proyecto->financialTable; ?>

			<?php echo $bussinesCase; ?>			
			<div>
				<p><?php echo JText::_('COM_TRAMAPROYECTOS_PROY_DESC'); ?></p>
				<p align="justify"><?php echo $proyecto->description; ?></p>
			</div>
			
			<div style="margin-bottom: 10px;">
				<a href="../<?php echo $urls1->viewUrl; ?>" target="blank"><?php echo JText::_('COM_TRAMAPROYECTOS_MORE'); ?></a>
			</div>
			
			<div>
				<h4 align="center"><?php echo JText::_('COM_TRAMAPROYECTOS_CHANGE_STATUS'); ?></h4>
				<input type="hidden" name="userId" value="<?php echo $adminId->id; ?>" />
				<input type="hidden" name="projectId" value="<?php echo $proyecto->id; ?>" />
				<input type="hidden" name="status" class="statuschange" />
								
				<div id="comentarios">
					<?php echo JText::_('COM_TRAMAPROYECTOS_COMMENTS'); ?><br />
					<textarea name="comment" rows="15" cols="100"></textarea>
				</div>
				
				<div style="margin-top:10px;">
					<input type="button" value="<?php echo JText::_('COM_TRAMAPROYECTOS_CANCEL'); ?>" onclick="javascript:window.history.back()">
					<?php echo $boton; ?>
				</div>
			</div>
			
			<?php
			if( !empty($proyecto->logs) ) {
			?>
			<div>
				<h4 align="center"><?php echo JText::_('COM_TRAMAPROYECTOS_CHANGES'); ?></h4>
				<ul>
					<?php
					echo $logsHtml;
					?>
				</ul>
			</div>
			<?php
			}
			?>
		</div>
	</td>
</tr>