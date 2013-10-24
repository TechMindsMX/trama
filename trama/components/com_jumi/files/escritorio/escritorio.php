<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$count = 0;
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport("trama.class");
jimport("trama.usuario_class");
jimport("trama.jsocial");

$input 			= JFactory::getApplication()->input;
$userid 		= $input->get("userid",0,"int");
$userid 		= ($userid==0)? $usuario->id: $userid ;
$userMiddleId	= UserData::getUserMiddlewareId($userid);
$document 		= JFactory::getDocument();
$base 			= JUri::base();
$proyectos 		= JTrama::getProjectsByUser($userMiddleId->idMiddleware);

foreach ($proyectos as $key => $value) {
	$entity = new JTrama;
	$entity->getEditUrl($value);
}

$pathJumi = $base.'components/com_jumi/files/perfil_usuario/';
$document->addStyleSheet($pathJumi.'css/style.css');
$datosgenerales = UserData::datosGr($userid);

if(is_null($datosgenerales)){
	$app->redirect('index.php', 'No hay datos de usuario','notice');
}

$id_datos_generales = $datosgenerales->id;
$promedio = UserData::scoreUser($userMiddleId->idJoomla);
?>
<style>
.comentariosMedia{
			display:none;
		}
.editMedia {
	display:none;
}
		 
@media all and (max-width: 720px){
	.comentarios{
		display:none;
	}
	.comentariosMedia{
		display:inline;
	}
	.editTabla{
		display:none;
	}
	.editMedia{
		display:inline;
	}
}
</style>
    <body>
        <h1><?php echo JText::_('MI_ESCRITORIO');?></h1>
      <script type="text/javascript" src="components/com_jumi/files/crear_pro/js/raty/jquery.raty.js"></script>
        
      <div id="contenido">  
			<section class="ac-container" style="max-width: 100%;">
				<div>
					<input id="ac-2a" name="accordion-2" type="radio" />
			<label for="ac-2a"><?php echo JText::_('LABEL_PROYECTOS');?></label>
					<article class="ac-medium">
						<table class="escritorio table table-striped" width="100%" frame="box" rules="all" style="text-align: center">
							<tr>
								<th><?php echo JText::_('LABEL_NAME');?></th>
								<th><?php echo JText::_('LABEL_CREACION');?></th>
								<th><?php echo JText::_('LABEL_STATUS');?></th>
								<th width="15%"><?php echo JText::_('COM_COMMUNITY_SINGULAR_GROUP');?></th>
								<th width="15%">
									<span class="comentarios"><?php echo JText::_('JCOMENTARIOS');?></span>
									<span class="comentariosMedia">
										<img width="20" src="components/com_jumi/files/escritorio/img/comentarios.png" />
									</span>
								</th>
								<th width="15%">
									<span class="editTabla"><?php echo JText::_('EDIT');?></span>
									<span class="editMedia">
								  		<img width="20" src="components/com_jumi/files/escritorio/img/editar.png" />
	  							    </span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value ) {
									if ($value->type == 'PROJECT' && $value->status!=4) {
										$fecha = $value->timeCreated/1000;
										$groupId = JTrama::searchGroup($value->id);
										echo '<tr>';
											
											echo '<td><a href="'.$value->viewUrl.'" >'.$value->name.'</a></td>';
											echo '<td>'.date('d-M-Y',$fecha).'</td>';
											echo '<td>'.JTrama::getStatusName($value->status).'</td>';
											echo '<td>
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
												  </td>';
											echo '<td>';
												if ( !empty($value->logs) ) {
													echo '<a class="button" data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Ver</a>';
												}
											echo '</td>';
											echo '<td>';
							 					if($value->status == 0 || $value->status == 2) {
													echo '<a class="button" href="'.$value->editUrl.'">Ir</a>';
												}
											echo '</td>';
											
										echo "</tr>";
									}
							?>							
							<div class="divcontent" id="divContent<?php echo $count; ?>">
							<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.date('d-M-Y', $fechacreacion).'</div>'.
											 '<div><strong>'. JText::_('LABEL_STATUS').'</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>
						</table>
					</article>
				</div>
				
				<div>
					<input id="ac-3a" name="accordion-2" type="radio" />
					<label for="ac-3a"><?php echo JText::_('LABEL_PRODUCTOS');?></label>
					<article class="ac-large">
						<table class="escritorio table table-striped" width="100%" frame="box" rules="all" style="text-align: center;">
							<tr>
								<th><?php echo JText::_('LABEL_NAME');?></th>
								<th><?php echo JText::_('LABEL_CREACION');?></th>
								<th><?php echo JText::_('LABEL_STATUS');?></th>
								<th width="15%"><?php echo JText::_('COM_COMMUNITY_SINGULAR_GROUP');?></th>
								<th width="15%">
									<span class="comentarios"><?php echo JText::_('JCOMENTARIOS');?></span>
									<span class="comentariosMedia">
										<img width="20" src="components/com_jumi/files/escritorio/img/comentarios.png" />
									</span>
								</th>
								<th width="15%">
									<span class="editTabla"><?php echo JText::_('EDIT'); ?></span>
									<span class="editMedia">
								  		<img width="20" src="components/com_jumi/files/escritorio/img/editar.png" />
	  							    </span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type == 'PRODUCT' && $value->status != 4) {
										$fecha = $value->timeCreated/1000;
										$groupId = JTrama::searchGroup($value->id);
										echo "<tr>";
										
											echo '<td><a href="'.$value->viewUrl.'" >'.$value->name.'</a></td>';
											echo '<td>'.date('d-M-Y',$fecha).'</td>';
											echo '<td>'.JTrama::getStatusName($value->status).'</td>';
											echo '<td>
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
												  </td>';
											echo "<td>";
												if ( !empty($value->logs) ) {
													echo '<a class="button" data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Ver</a>';
												}
											echo '</td>';
											echo "<td>";
												if($value->status == 0 || $value->status == 2) {
													echo '<a class="button" href="'.$value->editUrl.'">Ir</a>';
												}
											echo "</td>";

										echo "</tr>";
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.date('d-M-Y', $fechacreacion).'</div>'.
											 '<div><strong>'. JText::_('LABEL_STATUS').'</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>	
						</table>
					</article>
				</div>
				
				<div>
					<input id="ac-4a" name="accordion-2" type="radio" />
					<label for="ac-4a"><?php echo JText::_('LABEL_REPERTORIO');?></label>
					<article class="ac-small">
						<table class="escritorio table table-striped" width="100%" frame="box" rules="all" style="text-align: center;">
							<tr>
								<th><?php echo JText::_('LABEL_NAME');?></th>
								<th>
									<span class="editTabla"><?php echo JText::_('EDIT'); ?></span>
									<span class="editMedia">
								  		<img width="20" src="components/com_jumi/files/escritorio/img/editar.png" />
	  							    </span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value) {
									if ($value->type == 'REPERTORY') {
										echo '<tr>';
										echo '	<td><a href="'.$value->viewUrl.'">'.$value->name.'</a></td>';
										echo '	<td><a class="button" href="'.$value->editUrl.'">Ir</a></td>';	
										echo "</tr>";
									}
								}
		       				?>
		       			</table> 				
					</article>
                </div>
                    
               	<div>
                    <input id="ac-5a" name="accordion-2" type="radio" />
					<label for="ac-5a"><?php echo JText::_('LABEL_SUSPENDIDOS');?></label>
					<article class="ac-large">
						<table class="escritorio table table-striped" width="100%" frame="box" rules="all" style="text-align: center;">
							<tr>
								<th><?php echo JText::_('LABEL_NAME');?></th>
								<th><?php echo JText::_('LABEL_CREACION');?></th>
								<th width="15%"><?php echo JText::_('COM_COMMUNITY_SINGULAR_GROUP');?></th>
								<th width="15%">
									<span class="comentarios"><?php echo JText::_('JCOMENTARIOS');?></span>
									<span class="comentariosMedia">
										<img width="20" src="components/com_jumi/files/escritorio/img/comentarios.png" />
									</span>
								</th>
							</tr>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type != 'REPERTORY' && $value->status == 4) {
										$groupId = JTrama::searchGroup($value->id);
										$fecha = $value->timeCreated/1000;
										echo "<tr>";
										echo '	<td><a href="'.$value->viewUrl.'" >'.$value->name.'</a></td>';
										echo '	<td>'.date('d-M-Y',$fecha).'</td>';
										echo '<td>
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
												  </td>';
										echo '	<td>';
													if ( !empty($value->logs) ) {
														echo '<a data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Ver</a>';
													}
										echo '	</td>';
										echo '</tr>';
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.date('d-M-Y', $fechacreacion).'</div>'.
											 '<div><strong>'. JText::_('LABEL_STATUS').'</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>							
						</table>
					</article>
				</div>
				
			</section>
        <div style="clear: both"></div>
       </div>
       
      