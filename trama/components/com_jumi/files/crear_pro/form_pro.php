<link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<?php
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
jimport('trama.class');
jimport('trama.usuario_class');
require_once 'components/com_jumi/files/crear_pro/classIncludes/libreriasPP.php';
require_once 'components/com_jumi/files/crear_pro/classIncludes/validacionFiscal.php';
JHtml::_('behavior.modal');

validacionFiscal($usuario);

$userMiddleId 			= UserData::getUserMiddlewareId($usuario->id);
$categoria 				= JTrama::getAllCatsPadre();
$subCategorias 			= JTrama::getAllSubCats();
$token 					= JTrama::token();
$input 					= JFactory::getApplication()->input;
$proyid 				= $input->get("proyid",0,"int");
$datosObj 				= $proyid == 0 ? null: JTrama::getDatos($proyid);
$comentarios			= '';
$ligaEditProveedores	= '';
$ligaCostosVariable		= '';
$ligaFinantialData		= '';
$suma 					= 0;
$presupuesto			= 0;
$breakeven				= 0;
$breakevenCalc			= 0;
?>
<script>
	emptyKeys();
	jQuery(document).ready(function(){	
		jQuery("#form2").find(".toggle-editor").css("display","none");	
		jQuery("#form2").validationEngine();
		
		<?php
		if( !is_null($datosObj) ) {
			JTrama::isEditable($datosObj, $userMiddleId->idMiddleware);

			$count = 0;
			foreach ($datosObj->logs as $key => $value) {
				if ( $value->status == 2 ) {
					$count++;
				}
			}
			
			if($count == 2) {
				$botonRevision = '';
			}

			if( ($datosObj->status == 0 || $datosObj->status == 2) && ($datosObj->type == 'PROJECT')) {
				if($datosObj->status == 2) {
					$comentarios = '<span class="liga"><a data-rokbox href="#" data-rokbox-element="#divContent">'.JText::_('JCOMENTARIOS').'</a></span>';
				}
				
				if(empty($datosObj->providers)){
					$mensaje = JText::_('ALTA_PROVEEDPORES');
				} else {
					$mensaje = JText::_('EDITAR_PROVEEDPORES');
				}
				$ligaEditProveedores = '<span class="liga">
											<a href="index.php?option=com_jumi&view=appliction&fileid=25&proyid='.$datosObj->id.'">'.$mensaje.'</a>
								   		</span>';
				if(empty($datosObj->variablecost)){
					$mensaje = JText::_('ALTA_COSTOS_VARIABLES');
				} else {
					$mensaje = JText::_('EDITAR_COSTOS_VARIABLES');
				}
				$ligaCostosVariable = '<span class="liga">
									  	<a href="index.php?option=com_jumi&view=appliction&fileid=26&proyid='.$datosObj->id.'">'.$mensaje.'</a>'.
								   	  '</span>';
									  
					$mensajeFinanzas = JText::_('EDITAR_FINANZAS');

					$ligaFinantialData = '<span class="liga">
										  	<a href="index.php?option=com_jumi&view=appliction&fileid=28&proyid='.$datosObj->id.'">'.$mensajeFinanzas.'</a>'.
									   	  '</span>';
			}
			
			foreach ($subCategorias as $key => $value) {
				if($value->id == $datosObj->subcategory) {
					$categoriaJS = $value->father;
				}
			}
			$validacion 	= '';
			$checkedvideos 	= $datosObj->videoPublic;
			$checkedsound 	= $datosObj->audioPublic;
			$checkedimages 	= $datosObj->imagePublic;
			$checkedinfo	= $datosObj->infoPublic;
			
			echo 'emptyKeys();';
			echo 'jQuery("#camposHidden").append(\'<input type="hidden" value="'.$datosObj->id.'" name="id" />\');';
			echo 'jQuery("#status").val('.$datosObj->status.');';
			echo 'jQuery("#nomProy").val("'.$datosObj->name.'");';
			echo 'jQuery("#selectCategoria").val('.$categoriaJS.').trigger("click").trigger("change");';
			echo 'jQuery("#subcategoria").val('.$datosObj->subcategory.').trigger("click").trigger("change");';
			echo 'jQuery("#miniaturaBanner").html(\'<img src="'.BANNER.'/'.$datosObj->projectBanner->name.'" width="100" />\');';
			echo 'jQuery("#miniaturaAvatar").html(\'<img src="'.AVATAR.'/'.$datosObj->projectAvatar->name.'" width="100" />\');';
			echo 'jQuery("#url").val("'.$datosObj->url.'");';
			
			foreach ($datosObj->projectVideos as $key => $value) {
				echo 'jQuery("#linkYt"+'.($key+1).').val("'.$value->url.'");';				
			}
			
			foreach ($datosObj->projectSoundclouds as $key => $value) {
				echo 'jQuery("#linkSc1"+'.($key+1).').val("'.$value->url.'");';				
			}
			
			echo 'jQuery("#nameRecinto").val("'.$datosObj->inclosure.'");';
			echo 'jQuery("#searchTextField").val("'.$datosObj->showground.'");';
			
			foreach ($datosObj->providers as $key => $value) {
				$suma = $value->advanceQuantity+$value->settlementQuantity+$suma;
			}
			$presupuesto 	= $datosObj->budget;
			$breakeven 		= $datosObj->breakeven;
			$breakevenCalc 	= $datosObj->breakeven+5;
			
			echo 'var breakeven = '.$breakeven.';';
			echo 'var breakevencalc = '.$breakevenCalc.';';
			echo 'var suma = '.$suma.';';
			echo 'var presupuesto = '.$presupuesto.';';
		}
		?>
		
		jQuery("#guardar, #revision").click(function (){			
			var form = jQuery("#form2")[0];
			var total = form.length;
	
			if( this.id == 'revision' ) {
				if( (suma == presupuesto) && (breakeven == breakevencalc) ) {
					if(confirm('<?php echo JText::_('CONFIRMAR_ENVIAR');  ?>')){
						if( jQuery('#status').val() == 0 ) {
							jQuery('#status').val(9);
						} else if( jQuery('#status').val() == 2 ){
							jQuery('#status').val(3);
						}
					}else {
						return false;
					}
				}else{
					if( suma != presupuesto ){
						alert('<?php echo JText::_('ERROR_PRESUPUESTO'); ?>');
					}
					
					if( breakeven != breakevencalc ) {
						alert('<?php echo JText::_('ERROR_BREAKEVEN'); ?>');
					}
					return false;
				}
				
			} else if(this.id == 'guardar') {
				if( jQuery('#status').val() != <?php echo $status_pro; ?> ) {
					jQuery('#status').val(<?php echo $status_pro; ?>);
				}
			}
			jQuery("#form2").submit();
		});
	});
        
</script>

<div class="divcontent" id="divContent">
	<?php 
	if( isset($datosObj) ){
		foreach ($datosObj->logs as $key => $value) {
			$fechacreacion = $value->timestamp/1000;
			echo '<div style="margin-bottom: 10px;">'.
				 '<li>'.
				 '<div><strong>'.JText::_('COM_CONTENT_MODIFIED_DATE').'</strong>: '.date('d/M/Y', $fechacreacion).'</div>'.
				 '<div><strong>'.JText::_('JSTATUS').'</strong>: '.JTrama::getStatusName($value->status).'</div>'.
				 '<div align="justify"><strong>'.JText::_('COMMENTARIOS').'</strong>: '.$value->comment.'</div>'.
				 '</li>'.
				 '</div>';
		}
	}
	?>
</div>

<div style="margin-left:15px;"><h1><?php echo $titulo; ?></h1></div>

<form id="form2" action="<?php echo $action; ?>" enctype="multipart/form-data" method="POST">
	<div class="datos_proy">
		<span id="camposHidden">
			<input
				type="hidden"
				name="callback"
				id="callback"
				value= "<?php echo $callback; ?>"/>
				
			<input 
				type="hidden"
				name="projectPhotosIds"
				id="projectPhotosIds"
				value= ""/>
			
			<input 
				type="hidden"
				value="<?php echo $userMiddleId->idMiddleware; ?>"
				name="userId" />
				
			<input
				type="hidden"
				value="<?php echo $token; ?>"
				name="token"
				id="token" />
				   
			<input 
				type = "hidden" 
				value = "0"
				name = "status"
				id = "status" />
				   
			<input
				type="hidden"
				value="<?php echo $type; ?>"
				name="type"
				id="type" />
		</span>
		
		<label for="nomProy"><?php echo JText::_('NOMBRE').' '.$textPro; ?>*:</label>
		<input 
			type="text"
			id="nomProy"
			class="validate[required,custom[onlyLetterNumber]]" 
			maxlength="100"
			name="name" /> 
		<br />
		
		<label for="categoria"><?php echo JText::_('CATEGORIA'); ?>: </label>
		<select id="selectCategoria" name="categoria">
			<?php		
			foreach ( $categoria as $key => $value ) {
				echo '<option value="'.$value->id.'" >'.$value->name.'</option>';
				$opcionesPadre[] = $value->id;
			}
			?>
		</select>
		<br />
		
		<label for="subcategory"><?php echo JText::_('SUBCATEGORIA'); ?>: </label>
		<select id="subcategoria" name="subcategory">
			<option value="all">Todas</option>
			<?php
			foreach ( $subCategorias as $key => $value ) {
				$opcionesSubCat .= '<option class="'.$value->father.'" value="'.$value->id.'" >'.$value->name.'</option>';
			}		
			echo $opcionesSubCat;
			?>
		</select>
		<br />
		<br />
		
		
		<label for="banner"><?php echo JText::_('BANNER').$textPro; ?>*:</label>
		<input type="file"  id="banner" onchange='loadImage(this);' accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="banner">
		<div id="miniaturaBanner"></div>
		<div style="max-width:460px; font-size:12px;"><?php echo JText::_('NOTE_BANNER'); ?></div>
		<br />
		
		<label for="avatar"><?php echo JText::_('AVATAR').$textPro; ?>*:</label> 
		<input type="file" id="avatar" onchange='loadImage2(this);' accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="avatar">
		<div id="miniaturaAvatar"></div>
		<div style="max-width:460px; font-size:12px;"><?php echo JText::_('NOTE_AVATAR'); ?></div>
		<br />
	
		<label for="url"><?php echo JText::_('URL_PROY'); ?>: </label> 
		<input 
			type="text" 
			class="validate[custom[url]]"
			placeholder="<?php echo JText::_('URL_VAL'); ?>"
			name="url"
			maxlength="100"
			id="url" > 
	</div>
	
	<div class="datos_proy">
		<h2><?php echo JText::_('LABEL_VIDEOS'); ?></h2>
		<fieldset class="fieldset">
			<LEGEND class="legend">
				<label class="label_public" for="priv"><?php echo JText::_('DATA_PUBLIC'); ?></label>
				<div class="radios_public">
				<input 
					type="radio" 
					name="videoPublic" 
					value="1" 
					id="videoPublic" 
					<?php echo $checkedvideos? 'checked="checked"':'';?>>Si</input>
				<input 
					type="radio" 
					name="videoPublic" 
					value="0" 
					id="videoPublic"
					<?php echo $checkedvideos?'':'checked="checked"';?>>No</input>
				</div>
			</LEGEND>
			
			<div style="padding:15px 0px;">
				<?php echo JText::_('VIDEOSP'); ?>
			</div>
			 
			<?php
			for ( $i = 0; $i < $limiteVideos; $i++ ) {
				$obligatorio = ($i == 0) ? 'validate[required,custom[yt]]' : 'validate[custom[yt]]';
				$asterisco = ($i == 0) ? '*' : '';
				
				echo $labelVideos = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_YT').' '.($i+1).$asterisco.':</label>';
				echo $inputVideos = '<input type="text" id="linkYt'.($i+1).'" class="'.$obligatorio.'" value = "" name="videoLink'.($i+1).'" /><br />';
			}
			?>
		</fieldset>
	</div>
	
	<div class="datos_proy">
		<h2><?php echo JText::_('LABEL_AUDIOS'); ?></h2>
		<fieldset class="fieldset">
			<LEGEND class="legend">
			<label class="label_public" for="priv"><?php echo JText::_('DATA_PUBLIC'); ?></label>
			<div class="radios_public">
			<input 
				type="radio" 
				name="audioPublic" 
				value="1" 
				id="audioPublic" 
				checked="checked" 
				<?php echo $checkedsound? 'checked="checked"':'';?>>Si</input>
			
			<input 
				type="radio" 
				name="audioPublic" 
				value="0" 
				id="audioPublic"
				<?php echo $checkedsound?'':'checked="checked"';?>>No</input>
			</div>
		</LEGEND>
		
		<div style="padding:15px 0px;">
			<?php echo JText::_('AUDIOSP'); ?>
		</div>
		
		<?php
		for ( $i = 0; $i < $limiteSound; $i++ ) {
			echo $labelSound = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_SC').' '.($i+1).':</label>';
			echo $inputSound = '<input type="text" id="linkSc1'.($i+1).'" class="validate[custom[sc]]"	name="soundCloudLink'.($i+1).'" /><br />';
		}
		?>
		</fieldset>
	</div>
	
	<div class="datos_proy">
		<h2><?php echo JText::_('LABEL_IMAGES'); ?></h2>
		<fieldset class="fieldset">
			<LEGEND class="legend">
				<label class="label_public" for="priv"><?php echo JText::_('DATA_PUBLIC'); ?></label>
				<div class="radios_public">
				<input 
					type="radio" 
					name="imagePublic"
					value="1"
					id="imagePublic"
					<?php echo $checkedimages?'checked="checked"':'';?>>Si</input>
				<input 
					type="radio" 
					name="imagePublic"
					value="0"
					id="imagePublic"
					<?php echo $checkedimages?'':'checked="checked"';?>>No</input>
				</div>
			</LEGEND>
			<br />
			<div style="margin-bottom: 15px;"><?php echo JText::_('TRAMA_FOTOS_LIMITE'); ?><span id="maximoImg"><?php echo $countImgs; ?></span></div>
			
			<label for="fotos" id="labelImagenes"><?php echo JText::_('TRAMA_FOTOS'); ?>*:</label> 
			<input class="multi <?php echo $validacion; ?>" id="fotos" accept="gif|jpg|x-png" type="file" maxlength="10" name="photo" />
			
			<?php
			if ( !is_null($datosObj) ) {
				echo '<div class="MultiFile-label" id="imagenes" style="display:block; float:left;">';
				
				foreach ($datosObj->projectPhotos as $key => $value) {
					echo '<input 
							type = "checkbox"
							id = "photosids"
							name = "photoids_'.$value->id.'"  
							class="projectPhotosIds" 
							value="'.$value->id.'" 
							checked="checked" />
							<img alt="'.$datosObj->name.'" src="'.PHOTO.'/'.$value->name.'" width="100" /><br /><br />';
				}
				
				echo '</div>';
			}
			?> 
			<div style="max-width:430px; font-size:12px;"><?php echo JText::_('NOTE_IMAGES'); ?></div>  
		</fieldset>
	</div>
	
	<div id="datos_generales_proy">
		<h2><?php echo JText::_('LABEL_GENERALES'); ?></h2>
		<fieldset class="fieldset">
			<LEGEND class="legend">
				<label class="label_public" for="priv"><?php echo JText::_('DATA_PUBLIC'); ?></label>
				<div class="radios_public">
					<input 
						type="radio" 
						name="infoPublic" 
						value="1" 
						id="infoPublic" 
						<?php echo $checkedinfo?'checked="checked"':'';?>>Si</input>
					<input 
						type="radio" 
						name="infoPublic" 
						value="0" 
						id="infoPublic"
						<?php echo $checkedinfo?'':'checked="checked"';?>>No</input>
					</div>
			</LEGEND>
			<br />
			
			<label  for="descProy"><?php echo JText::_('DESCRIPCION').$textPro; ?>*:</label> 
			<br />	
			
			<div style= "max-width:755px;">
				<?php
					$editor =& JFactory::getEditor('tinymce');
					$contenidoDescription = !is_null($datosObj) ? $datosObj->description : '';
					echo $editor->display( 'description', 
								   $contenidoDescription,
								   '100%',
								    '250', 
								    '20', 
								    '20', 
								    false, 
								    null, 
								    null, 
								    null, 
								    array('mode' => 'simple'));
					?>
			</div>
			<br />
			<br />
			
			<label for="elenco"><?php echo JText::_('ELENCO'); ?>:</label> <br />
			<div style= "max-width:755px;">
				<?php
					$editor =& JFactory::getEditor('tinymce');
					$contenidoCast = !is_null($datosObj) ? $datosObj->cast : '';
					echo $editor->display( 'cast', 
								   $contenidoCast,
								   '100%',
								    '250', 
								    '20', 
								    '20', 
								    false, 
								    null, 
								    null, 
								    null, 
								    array('theme' => 'simple'));
					?>
				</div>
			
			<br />
			<br />
			<label for="direccion"><?php echo JText::_('RECINTO'); ?>*: </label> 
			<input 
				type="text" 
				class="validate[required]" 
				id="nameRecinto"
				value="" 
				name="inclosure"
				maxlength="100" /> 
			<br>
		
			<br />
			<div id="panel" >
				<label for="direccion"><?php echo JText::_('DIRECCION_RECINTO'); ?>*: </label> 
				<input name="showground" class="validate[required]" value="" id="searchTextField" type="text" size="50">
			</div>
			<div id="map-canvas" style="height: 400px; max-width: 420px"></div>
			<br />
			
			<label for="tags"><?php echo JText::_('KEYWORDS'); ?><br /><span style="font-size: 12px;">(separarlas por comas)</span></label>
			<textarea id="tagsArea" name="tags" cols="60" rows="5"><?php
				if( isset($datosObj) && !empty($datosObj->tags)) {
					foreach ($datosObj->tags as $key => $value) {
						$array[] = $value->tag;
					}
					$tags = implode($array, ', ');
					echo $tags;
					
				}else {
					echo '';
				}
				?></textarea>
		</fieldset>
	</div>
	
	<div class="barra-top" id="otras_ligas">
		<?php 
			echo $ligaEditProveedores;
			echo $ligaCostosVariable;
			echo $ligaFinantialData;
			echo $comentarios; 
		?>
	</div>
	<div class="boton_enviar">
	<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
	<input type="button" class="button" id="guardar" value="<?php echo JText::_('GUARDAR'); ?>">
	</div>
	<?php echo $botonRevision; ?>	
</form>