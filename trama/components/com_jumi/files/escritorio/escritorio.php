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
jimport("trama.jsocial");
require_once 'components/com_jumi/files/perfil_usuario/usuario_class.php';
$input = JFactory::getApplication()->input;
$userid = $input->get("userid",0,"int");

$objuserdata = new UserData;
$userid = ($userid==0)? $usuario->id: $userid ;

$document = JFactory::getDocument();
$base = JUri::base();
$proyectos = JTrama::getProjectsByUser($userid);
foreach ($proyectos as $key => $value) {
	$entity = new JTrama;
	
	$entity->getEditUrl($value);
}


$pathJumi = $base.'components/com_jumi/files/perfil_usuario/';
$document->addStyleSheet($pathJumi.'css/style.css');

$datosgenerales = $objuserdata::datosGr($userid);

if(is_null($datosgenerales)){
	$app->redirect('index.php', 'No hay datos de usuario','notice');
}

$id_datos_generales = $datosgenerales->id;

$promedio = $objuserdata->scoreUser($userid);

?>

    <body>
        
      <script type="text/javascript" src="components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js"></script>
        
      <div id="contenido">  
			<section class="ac-container2">
				
				<div>
					<input id="ac-2a" name="accordion-2" type="radio" />
					<label for="ac-2a">Proyectos</label>
					<article class="ac-medium">
						<p> 
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type == 'PROJECT' && $value->status!=4) {
										
										$fecha = $value->timeCreated/1000;
										echo "<ul>";
										echo '<li><a href="'.$value->viewUrl.'" >'.$value->name.'</a></li>';
											if ($usuario->id == $value->userId) {
												if($value->status == 0 || $value->status == 2) {
													echo '<span><a class="button editar" href="'.$value->editUrl.'">'.JText::_('EDIT').'</a></span>';
												}
												echo 'Status <span class="statusproyecto">'.JTrama::getStatusName($value->status).'</span> ';
											}
											if ( !empty($value->logs) ) {
												echo '<a data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Comentarios</a>';
											}
										echo ' Creado <span class="fechacreacion">'.date('d/M/Y',$fecha).'</span>';
										echo "</ul>";
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>Modificado</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
											 '<div><strong>Status</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>Comentario</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>	
							
							
						</p>
					</article>
				</div>
				<div>
					<input id="ac-3a" name="accordion-2" type="radio" />
					<label for="ac-3a">Productos</label>
					<article class="ac-large">
						<p>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type == 'PRODUCT' && $value->status != 4) {
										
										$fecha = $value->timeCreated/1000;
										echo "<ul>";
										echo '<li><a href="'.$value->viewUrl.'" >'.$value->name.'</a></li>';
											if ($usuario->id == $value->userId) {
												if($value->status == 0 || $value->status == 2) {
													echo '<span><a class="button editar" href="'.$value->editUrl.'">'.JText::_('EDIT').'</a></span>';
												}
												echo 'Status <span class="statusproyecto">'.JTrama::getStatusName($value->status).'</span> ';
											}
											if ( !empty($value->logs) ) {
												echo '<a data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Comentarios</a>';
											}
										echo ' Creado <span class="fechacreacion">'.date('d/M/Y',$fecha).'</span>';
										echo "</ul>";
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>Modificado</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
											 '<div><strong>Status</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>Comentario</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>	
							
								
						</p>
					</article>
				</div>
				<div>
					<input id="ac-4a" name="accordion-2" type="radio" />
					<label for="ac-4a">Repertorio</label>
					<article class="ac-small">						
							<?php 
								foreach ($proyectos as $key => $value) {
									
									if ($value->type == 'REPERTORY') {
										echo '<p><a href="'.$value->viewUrl.'" target="_blank">'.$value->name.'</a></p>';
										if ( $usuario->id == $value->userId ) {
											echo '<span><a class="button editar" href="'.$value->editUrl.'">'.JText::_('EDIT').'</a></span>';	
										}
										echo '<p>'.$value->description.'</p>';
									}
								}
		       				?>		       				
					</article>
                    </div>
                    <div>
                    <input id="ac-5a" name="accordion-2" type="radio" />
					<label for="ac-5a">Suspendidos</label>
					<article class="ac-large">
						<p>
							<?php 
								foreach ($proyectos as $key => $value ) {							
									if ($value->type != 'REPERTORY' && $value->status == 4) {
										
										$fecha = $value->timeCreated/1000;
										echo "<ul>";
										echo '<li><a href="'.$value->viewUrl.'" >'.$value->name.'</a></li>';
											if ($usuario->id == $value->userId) {
												if($value->status == 0 || $value->status == 2) {
													echo '<span><a class="button editar" href="'.$value->editUrl.'">'.JText::_('EDIT').'</a></span>';
												}
												echo 'Status <span class="statusproyecto">'.JTrama::getStatusName($value->status).'</span> ';
											}
											if ( !empty($value->logs) ) {
												echo '<a data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">Comentarios</a>';
											}
										echo ' Creado <span class="fechacreacion">'.date('d/M/Y',$fecha).'</span>';
										echo "</ul>";
									}
							?>
							<div class="divcontent" id="divContent<?php echo $count; ?>">
									<?php
									foreach ($value->logs as $indice => $valor) {
										$fechacreacion = $valor->timestamp/1000;
										echo '<div style="margin-bottom: 10px;">'.
											 '<li>'.
											 '<div><strong>Modificado</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
											 '<div><strong>Status</strong>: '.JTrama::getStatusName($valor->status).'</div>'.
											 '<div align="justify"><strong>Comentario</strong>: '.$valor->comment.'</div>'.
											 '</li>'.
											 '</div>';
										}
									?>
								</div>
							<?php
									$count = $count + 1;
								}
							?>							
						</p>
					</article>
				</div>
				
			</section>
        <div style="clear: both"></div>
       </div>
       
      