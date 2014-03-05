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

JHTML::_('behavior.tooltip');
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
$status 		= array(5,10,6,7,8,11);

foreach ($proyectos as $key => $value) {
	$entity = new JTrama;
	$entity->getEditUrl($value);
}

$pathJumi = $base.'components/com_jumi/files/perfil_usuario/';
$document->addStyleSheet($pathJumi.'css/style.css');
$datosgenerales = UserData::datosGr($userid);

if(is_null($datosgenerales)){
	$app->redirect('index.php', ''.JText::_("JSIN_DATOS_USUARIO").'','notice');
}

$id_datos_generales = $datosgenerales->id;
$promedio = UserData::scoreUser($userMiddleId->idJoomla);
?>

    <body>
        <h1><?php echo JText::_('MI_ESCRITORIO');?></h1>
      <script type="text/javascript" src="libraries/trama/js/raty/jquery.raty.js"></script>
        
      <div id="contenido">  
			<section class="ac-container" style="max-width: 100%;">
				<div> <!--Proyectos-->
					<input id="ac-2a" name="accordion-2" type="radio" checked="checked" /> <!--Funcionalidad de escritorio en acordeon -->
					
					<label for="ac-2a"><?php echo JText::_('LABEL_PROYECTOS');?></label>
					
					<article class="ac-medium">
						
						<div class="escritorio" id="esc-proyectos" frame="box" rules="all" style="text-align: center">
							<div class="clase-tr">
								<div class="clase-th"><?php echo JText::_('LABEL_NAME');?></div>
								<div class="clase-th"><?php echo JText::_('LABEL_CREACION');?></div>
								<div class="clase-th"><?php echo JText::_('LABEL_STATUS');?></div>
								<div class="clase-th"><?php echo JText::_('COM_COMMUNITY_SINGULAR_GROUP');?></div>
								<div class="clase-th">
									<span class="comentarios"><?php echo JText::_('JCOMENTARIOS');?></span>
									
								</div>
								<div class="clase-th">
									<span class="editTabla"><?php echo JText::_('LBL_EDIT');?></span>
								</div>
								<div class="clase-th">
									<span class="editTabla"><?php echo JText::_('LBL_EDO_RESULT');?></span>
								</div>
							</div>
							
							<?php 
								foreach ($proyectos as $key => $value ) {
									if ($value->type == 'PROJECT' && $value->status!=4) {
										$fecha = $value->timeCreated/1000;
										$groupId = JTrama::searchGroup($value->id);
										$statusName = JTrama::getStatusName($value->status);

										echo '<div class="clase-tr">';
											
											echo '<div class="clase-td"><a href="'.$value->viewUrl.'" >'.$value->name.'</a></div>';
											echo '<div class="clase-td">'.date('d-M-Y',$fecha).'</div>';
											echo '<div class="clase-td">'.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</div>';
											echo '<div class="clase-td">';
											if (isset($groupId->id)) {
												echo '<span class="boton-texto">
														<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
													</span>
													<span class="boton-icono">
														<a href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														<img width="30" src="components/com_jumi/files/escritorio/img/grupo.jpg" />
														</a>
													</span>
												  </div>';
											}
											echo '<div class="clase-td">';
												if ( !empty($value->logs) ) {
													echo '<span class="boton-texto">
															<a class="button" data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">'.JText::_('JVIEW').'</a>
														 </span>
														<span class="boton-icono">
															<a data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">
        													<img width="30" src="components/com_jumi/files/escritorio/img/comentarios.jpg" />
															</a>
        												</span>';
												}
											echo '</div>';
											echo '<div class="clase-td">';
							 					if($value->status == 0 || $value->status == 2) {
													echo '<span class="boton-texto">
											      			<a class="button" href="'.$value->editUrl.'">'.JText::_('JGO').'</a> 
											      		</span>
														<span class="boton-icono">
															<a href="'.$value->editUrl.'">
															<img width="30" src="components/com_jumi/files/escritorio/img/editar.jpg" />
															</a>
														</span>';
												}
											echo '</div>';
											echo '<div class="clase-td">';
												if(in_array($value->status, $status)){
													echo '<span class="boton-texto">
															<a class="button" href="index.php?option=com_jumi&view=application&fileid=32&proyId='.$value->id.'">'.JText::_('PROJECT_STATEMENT_RESULT').'</a>
														</span>
														<span class="boton-icono">
															<a href="index.php?option=com_jumi&view=application&fileid=32&proyId='.$value->id.'">
															<img width="30" src="components/com_jumi/files/escritorio/img/resultados.jpg" />
															</a>
														</span>';
												}
											echo '</div>';
											echo '	<div style="clear:both"></div>';
										echo "</div>";
									}
							?>							
							<div class="divcontent" id="divContent<?php echo $count; ?>">
							<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										$statusName = JTrama::getStatusName($value->status);
										
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.date('d-M-Y', $fechacreacion).'</div>'.
											 '<div><strong>'. JText::_('LABEL_STATUS').'</strong>: '.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</div>'.
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
						</div>
					</article>
				</div>
				
				<div> <!--Productos-->
					<input id="ac-3a" name="accordion-2" type="radio" />
					<label for="ac-3a"><?php echo JText::_('LABEL_PRODUCTOS');?></label>
					<article class="ac-large">
						<div class="escritorio" id="esc-proyectos" frame="box" rules="all" style="text-align: center;">
							<div class="clase-tr">
								<div class="clase-th"><?php echo JText::_('LABEL_NAME');?></div>
								<div class="clase-th"><?php echo JText::_('LABEL_CREACION');?></div>
								<div class="clase-th"><?php echo JText::_('LABEL_STATUS');?></div>
								<div class="clase-th"><?php echo JText::_('COM_COMMUNITY_SINGULAR_GROUP');?></div>
								<div class="clase-th">
									<span class="comentarios"><?php echo JText::_('JCOMENTARIOS');?></span>
								</div>
								<div class="clase-th">
									<span class="editTabla"><?php echo JText::_('LBL_EDIT'); ?></span>
								</div>
								<div class="clase-th">
									<span class="editTabla"><?php echo JText::_('LBL_EDO_RESULT');?></span
								</div>
							</div>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type == 'PRODUCT' && $value->status != 4) {
										$fecha = $value->timeCreated/1000;
										$groupId = JTrama::searchGroup($value->id);
										$statusName = JTrama::getStatusName($value->status);
										
										echo "<div class='clase-tr'>";
										
											echo '<div class="clase-td"><a href="'.$value->viewUrl.'" >'.$value->name.'</a></div>';
											echo '<div class="clase-td">'.date('d-M-Y',$fecha).'</div>';
											echo '<div class="clase-td">'.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</div>';
											echo '<div class="clase-td">
													<span class="boton-texto">
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
														ir
													</a>
													</span>
													<span class="boton-icono">
															<a href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.$groupId->id.'">
															<img width="30" src="components/com_jumi/files/escritorio/img/grupo.jpg" />
															</a>
													</span>
												  </div>';
											echo "<div class='clase-td'>";
												if ( !empty($value->logs) ) {
													echo '<span class="boton-texto">
															<a class="button" data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">'.JText::_('JVIEW').'</a>
        												</span>
													<span class="boton-icono">
															<a href="#" data-rokbox-element="#divContent'.$count.'">
																<img width="30" src="components/com_jumi/files/escritorio/img/comentarios.jpg" />
															</a>
													</span>';
												}
											echo '</div>';
											echo "<div class='clase-td'>";
												if($value->status == 0 || $value->status == 2) {
													echo '<span class="boton-texto">
															<a class="button" href="'.$value->editUrl.'">'.JText::_('JGO').'</a>
														</span>
													<span class="boton-icono">
															<a href="'.$value->editUrl.'">
																<img width="30" src="components/com_jumi/files/escritorio/img/editar.jpg" />
															</a>
													</span>';
												}
											echo "</div>";
											echo '<div class="clase-td">';
												if(in_array($value->status, $status)){
													echo '<span class="boton-texto">
																<a class="button" href="index.php?option=com_jumi&view=application&fileid=32&proyId='.$value->id.'">'.JText::_('PROJECT_STATEMENT_RESULT').'</a>
															<span class="boton-icono">
															<a href="index.php?option=com_jumi&view=application&fileid=32&proyId='.$value->id.'">
																<img width="30" src="components/com_jumi/files/escritorio/img/editar.jpg" />
															</a>
															</span>';
												}
											echo '</div>';
										echo '	<div style="clear:both"></div>';
										echo "</div>";
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.date('d-M-Y', $fechacreacion).'</div>'.
											 '<div><strong>'. JText::_('LABEL_STATUS').'</strong>: '.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</div>'.
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
						</div>
					</article>
				</div>
				
				<div><!--Repertorio-->
					<input id="ac-4a" name="accordion-2" type="radio" />
					<label for="ac-4a"><?php echo JText::_('LABEL_REPERTORIO');?></label>
					<article class="ac-small">
						<div class="escritorio" id="esc-repertorio" frame="box" rules="all" style="text-align: center;">
							<div class="clase-tr">
								<div class="clase-th"><?php echo JText::_('LABEL_NAME');?></div>
								<div class="clase-th">
									<span class="editTabla"><?php echo JText::_('LBL_EDIT'); ?></span>
								</div>
							</div>
							<?php 
								foreach ($proyectos as $key => $value) {
									if ($value->type == 'REPERTORY') {
										echo '<div class="clase-tr">';
										echo '	<div class="clase-td"><a href="'.$value->viewUrl.'">'.$value->name.'</a></div>';
										echo '	<div class="clase-td"><a class="button" href="'.$value->editUrl.'">'.JText::_('JGO').'</a></div>';	
										echo '	<div style="clear:both"></div>';
										echo "</div>";
									}
								}
		       				?>
		       			</div> 				
					</article>
                </div>
                
                <div><!--Suspendidos-->
                    <input id="ac-5a" name="accordion-2" type="radio" />
					<label for="ac-5a"><?php echo JText::_('LABEL_SUSPENDIDOS');?></label>
					<article class="ac-large">
						<div class="escritorio" id="esc-suspendidos"frame="box" rules="all" style="text-align: center;">
							<div class="clase-tr">
								<div class="clase-th"><?php echo JText::_('LABEL_NAME');?></div>
								<div class="clase-th"><?php echo JText::_('LABEL_CREACION');?></div>
								<div class="clase-th"><?php echo JText::_('COM_COMMUNITY_SINGULAR_GROUP');?></div>
								<div class="clase-th">
									<span class="comentarios"><?php echo JText::_('JCOMENTARIOS');?></span>
								</div>
							</div>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type != 'REPERTORY' && $value->status == 4) {
										$groupId = JTrama::searchGroup($value->id);
										$fecha = $value->timeCreated/1000;
										$statusName = JTrama::getStatusName($value->status);
										
										echo "<div class='clase-tr'>";
										echo '	<div class="clase-td"><a href="'.$value->viewUrl.'" >'.$value->name.'</a></div>';
										echo '	<div class="clase-td">'.date('d-M-Y',$fecha).'</div>';
										echo '<div class="clase-td">
												<span class="boton-texto">
													<a class="button" href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.@$groupId->id.'">
														ir
													</a>
												</span>
													<span class="boton-icono">
															<a href="index.php?option=com_community&view=groups&task=viewgroup&groupid='.@$groupId->id.'">
															<img width="30" src="components/com_jumi/files/escritorio/img/grupo.jpg" />
															</a>
													</span>
												  </div>';
										echo '	<div class="clase-td">';
													if ( !empty($value->logs) ) {
														echo '<span class="boton-texto">
																<a class="button" data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">'.JText::_('JVIEW').'</a>
															</span><span class="boton-icono">
																<a href="#" data-rokbox-element="#divContent'.$count.'">
																	<img width="30" src="components/com_jumi/files/escritorio/img/comentarios.jpg" />
																</a>
															</span>';
													}
										echo '	</div>';
										echo '	<div style="clear:both"></div>';
										echo '</div>';
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>'.JText::_('JCOMENTARIOS').'</strong>: '.date('d-M-Y', $fechacreacion).'</div>'.
											 '<div><strong>'. JText::_('LABEL_STATUS').'</strong>: '.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</div>'.
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
						</div>
					</article>
				</div>
				
			</section>
        <div style="clear: both"></div>
       </div>
       
      