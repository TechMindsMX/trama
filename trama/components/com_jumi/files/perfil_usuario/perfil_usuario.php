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
jimport("trama.usuario_class");
require_once 'components/com_jumi/files/ver_proyecto/solicitud_participar.php';
JHTML::_('behavior.tooltip');


$botonContactar		= JText::_('SOLICITA_CONTACTO');
$input 				= JFactory::getApplication()->input;
$document 			= JFactory::getDocument();
$base 				= JUri::base();
$userid 			= $input->get("userid", 0, "int");
$userid 			= ($userid == 0) ? $usuario->id: $userid ;
$idMiddleware		= UserData::getUserMiddlewareId($userid);
$pathJumi 			= $base.'components/com_jumi/files/perfil_usuario/';
$proyectos	 		= JTrama::getProjectsByUser($idMiddleware->idMiddleware);
$promedio 			= UserData::scoreUser($idMiddleware->idJoomla);
$datosgenerales 	= UserData::datosGr($idMiddleware->idJoomla);
$id_datos_generales = $datosgenerales->id;

foreach ($proyectos as $key => $value) {
	$entity = new JTrama;
	$entity->getEditUrl($value);
}

$document->addStyleSheet($pathJumi.'css/style.css');
?>
  <script type="text/javascript" src="libraries/trama/js/raty/jquery.raty.js"></script>
  <div id="contenido">
	<div class="rt-inner mitad">
		<section class="ac-container">
			<div class="business-card">
			<div id="foto"><img src="<?php echo $datosgenerales->Foto; ?>"  /></div>
			<div id="datos">
			<?php echo '<h2>'.$datosgenerales->nomNombre.' '.$datosgenerales->nomApellidoPaterno.'</h2>'.
		    		'<span id="job_title">'.$datosgenerales->nomJobTitle.'</span>'.			    	
		    		'<span id="company_name">'.$datosgenerales->nomCompania.'</span>';
		 	?>
		  	</div>
		  	
		  	<div id="raty">
	  			<div id="calif"></div>
				<div id="texto"><?php echo number_format($promedio->score ,1); ?></div>
				
			</div>
			<?php 
	  		echo '<div id="contactar">'.
	  			participar($datosgenerales->users_id, $botonContactar).
	  			'</div>';
		  	?>
			<div id="agrega_amigo" class="button"><?php echo JTramaSocial::addFriendJS($userid, $usuario); ?></div>
			<div style="clear: both;"></div>
			</div>
			
			<div>
				<div style="clear: both"></div>
				<input id="ac-2" name="accordion-1" type="radio" />
				<label for="ac-2"><?php echo JText::_('PERFIL_EXTENDIDO'); ?></label>
				<article class="ac-medium">
					<?php
					 UserData::generacampos(0, 'perfilx_catalogoperfil', 'idcatalogoPerfil', 'idcatalogoPerfilPadre', 'nomNombreCategoria', 'respuestaPerfil', $userid); 
					 ?>
				</article>
			</div>
			<div>
				<input id="ac-3" name="accordion-1" type="radio" />
				<label for="ac-3"><?php echo JText::_('LBL_FUNCIOGRAMA'); ?></label>
				<article class="ac-large">
						<?php UserData::generacampos(0, 'perfilx_catalogofuncion', 'idcatalogoFuncion', 'idcatalogoFuncionPadre', 'nomNombreCategoria', 'respuestaFuncion', $userid); ?>

				</article>
			</div>
			<div>
				<input id="ac-4" name="accordion-1" type="radio" />
				<label for="ac-4"><?php echo JText::_('PRODUCCION_FORM'); ?></label>
				<article class="ac-large">
						<?php UserData::generacampos(0, 'perfilx_catalogoproduccion', 'idcatalogoProduccion', 'idcatalogoProduccionPadre', 'nomNombreCategoria', 'respuestaProduccion', $userid); ?>
					
				</article>
			</div>
		</section>
   </div>
   
		<div class="mitad rt-inner">
		<section class="ac-container ac-container-color2">
			
			<div>
				<input id="ac-2a" name="accordion-2" type="radio" checked />
				<label for="ac-2a"><?php echo JText::_('PRO_DESCRIPTION'); ?></label>
				<article class="ac-medium">
						<div class="space-text">
						<?php 
	      					echo $datosgenerales->dscDescripcionPersonal;		       
	       				?>	
	       				</div>
				</article>
			</div>
			<div>
				<input id="ac-3a" name="accordion-2" type="radio" />
				<label for="ac-3a"><?php echo JText::_('LBL_CV'); ?></label>
				<article class="ac-large">
						<div class="space-text">
						<?php 
	      					echo $datosgenerales->dscCurriculum;		       
	       				?>	
	       				</div>
				</article>
			</div>
			<div>
				<input id="ac-4a" name="accordion-2" type="radio" />
				<label for="ac-4a"><?php echo JText::_('LBL_REPERTORY'); ?></label>
				<article class="ac-large">
						<div class="space-text">
						<?php 
							foreach ($proyectos as $key => $value) {
								
								if ($value->type == 'REPERTORY') {
									echo '<h4><a style="margin-left:10px;" href="'.$value->viewUrl.'" target="_blank">'.$value->name.'</a></h4>';
									if ( $usuario->id == $value->userId ) {
										echo '<span><a class="button editar" href="'.$value->editUrl.'">'.JText::_('LBL_EDIT').'</a></span>';	
									}
									echo '<p>'.$value->description.'</p>';
								}
							}
	       				?>	
	       				</div>
				</article>
                </div>
                <div>
                <input id="ac-5a" name="accordion-2" type="radio" />
				<label for="ac-5a"><?php echo JText::_('PROY_ACTUALES'); ?></label>
				<article class="ac-large">
						<div class="space-text">
						<?php 
							foreach ($proyectos as $key => $value ) {							
								if ($value->type != 'REPERTORY') {
									$fecha = $value->timeCreated/1000;
									echo "<ul>";
									echo '<li><a href="'.$value->viewUrl.'" >'.$value->name.'</a></li>';
										if ($usuario->id == $value->userId) {
											if($value->status == 0 || $value->status == 2) {
												echo '<span><a class="button editar" href="'.$value->editUrl.'">'.JText::_('LBL_EDIT').'</a></span>';
											}
											$statusName = JTrama::getStatusName($value->status);
											echo 'Status <span class="statusproyecto">'.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</span> ';
											if ( !empty($value->logs) ) {
												echo '<a data-rokbox href="#" data-rokbox-element="#divContent'.$count.'">'.JText::_('JCOMENTARIOS').'</a>';
											}
										}
									echo ' '.JText::_('CREATED').' <span class="fechacreacion">'.date('d/M/Y',$fecha).'</span>';
									echo "</ul>";
								}
						?>
						
						<div class="divcontent" id="divContent<?php echo $count; ?>">
								<?php
								foreach ($value->logs as $indice => $valor) {
									$fechacreacion = $valor->timestamp/1000;
									$statusName = JTrama::getStatusName($valor->status);
									
									echo '<div style="margin-bottom: 10px;">'.
										 '<li>'.
										 '<div><strong>'.JText::_('LABEL_MODIFIED').'</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
										 '<div><strong>'.JText::_('LABEL_STATUS').'</strong>: '.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</div>'.
										 '<div align="justify"><strong>'.JText::_('JCOMENTARIO').'</strong>: '.$valor->comment.'</div>'.
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
		</div>
		<div style="clear: both"></div>
   </div>
   
   <script type="text/javascript">
	var ruta = "libraries/trama/js/raty/img/"

	jQuery(document).ready(function () {
		jQuery('#calif').raty({
			click: function (score) {
				var request = $.ajax({
	     			url:"libraries/trama/js/ajax.php",
	 				data: {
	  					"score": score,
	  					"calificador": <?php echo $usuario->id; ?>,
	  					"calificado": <?php echo $userid; ?>,
	  					"fun": 1
	 				},
	 				type: 'post'
				});
	
				request.done(function(result){
		 			obj = eval('(' + result + ')');
		 			promedio = parseFloat(obj.score);
		 
		 			jQuery('#calif').raty({
		  				readOnly: true,
		  				path  : ruta,
		  				score  : obj.score,
		  				target  : '#texto',
		  				targetText : promedio.toFixed(1)
		 			});
				});
		
				request.fail(function (jqXHR, textStatus) {
		 			alert('<?php echo JText::_("RATING_ERROR"); ?>');
		    	});
		   },
		   score  : <?php echo $datosgenerales->score; ?>,
		   path  : ruta
		});
	});
	</script>
    