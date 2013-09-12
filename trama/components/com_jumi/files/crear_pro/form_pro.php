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

require_once 'components/com_jumi/files/crear_pro/classIncludes/libreriasPP.php';
require_once 'components/com_jumi/files/crear_pro/classIncludes/validacionFiscal.php';

validacionFiscal($usuario);

$categoria = JTrama::getAllCatsPadre();
$subCategorias = JTrama::getAllSubCats();
JHtml::_('behavior.modal');

$token = JTrama::token();

$input = JFactory::getApplication()->input;
$proyid = $input->get("proyid",0,"int");

$datosObj = JTrama::getDatos($proyid);
?>
<script>
	jQuery(document).ready(function(){	
		jQuery("#form2").find(".toggle-editor").css("display","none");	
		jQuery("#form2").validationEngine();
		
		<?php
		?>
		
		jQuery("#guardar, #revision").click(function (){

//			if(confirm('<?php echo JText::_('CONFIRMAR_ENVIAR');  ?>')){
				var form = jQuery("#form2")[0];
				var total = form.length;
	
				jQuery('#token').val('<?php echo $token;?>');

				if( this.id == 'revision' ) {
					
					if( jQuery('#status').val() == 0 ) {
						jQuery('#status').val(9);
					} else if( jQuery('#status').val() == 2 ){
						jQuery('#status').val(3);
					}
				} else if(this.id == 'guardar') {
					if( jQuery('#status').val() != <?php echo $status_pro; ?> ) {
						
						jQuery('#status').val(<?php echo $status_pro; ?>);
					}
				}
				
				jQuery("#form2").submit();
//			}
		});
	});
        
</script>

<!--DIV DE AGREGAR CAMPOS-->
<div id="readroot" style="display: none">
	<label for=""><?php echo JText::_('SECCION'); ?>*:</label> 
	<input 
		type="text" 
		class="validate[required,custom[onlyLetterNumber]]"
		name="section0">
	<br />
	
	<label for=""><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input 
		type="text" 
		class="validate[required,custom[onlyNumberSp]]" 
		name="unitSale0" step="any"> 
	<br>
	
	<label for=""><?php echo JText::_('INVENTARIOPP'); ?>:</label> 
	<input 
		type="text" 
		class="validate[required,custom[onlyNumberSp]]" 
		value=""
		name="capacity0"> 
	<br /> 
	
	<input 
		type="button" 
		value="<?php echo JText::_('QUITAR_CAMPOS'); ?>" 
		onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
	<br /><br />
</div>
<!--FIN DIV DE AGREGAR CAMPOS-->

<div style="margin-left:15px;"><h1><?php echo $titulo; ?></h1></div>

<form id="form2" action="<?php echo $action; ?>" enctype="multipart/form-data" method="POST">
	<div class="datos_proy">
		
		
		<input 
			type="hidden"
			name="projectPhotosIds"
			id="projectPhotosIds"
			value= ""/>
		
		<input 
			type="hidden"
			value="<?php echo $usuario->id; ?>"
			name="userId" />
			
		<input
			type="hidden"
			value=""
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
			$selectedCat = ($value->id == $categoriaSelected) ? 'selected' : ''; 
					
			echo '<option value="'.$value->id.'" '.$selectedCat.' >'.$value->name.'</option>';
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
				$selectedSubCat = ($value->id == $subcategoriaSelected) ? 'selected' : '';
				$opcionesSubCat .= '<option class="'.$value->father.'" value="'.$value->id.'" '.$selectedSubCat.' >'.$value->name.'</option>';
			}		
			echo $opcionesSubCat;
			?>
		</select>
		<br />
		<br />
		<label for="banner"><?php echo JText::_('BANNER').$textPro; ?>*:</label>
		<input type="file"  id="banner" onchange='loadImage(this);' accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="banner">
		<div style="max-width:430px; font-size:12px;"><?php echo JText::_('NOTE_BANNER'); ?></div>
		<br />
		
		<label for="avatar"><?php echo JText::_('AVATAR').$textPro; ?>*:</label> 
		<input type="file" id="avatar" onchange='loadImage2(this);' accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="avatar">
		<div style="max-width:430px; font-size:12px;"><?php echo JText::_('NOTE_AVATER'); ?></div>
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
				$urlVideo = isset($ligasVideos[$i]) ? $ligasVideos[$i]->url : '';
				$obligatorio = ($i == 0) ? 'validate[required,custom[yt]]' : 'validate[custom[yt]]';
				$asterisco = ($i == 0) ? '*' : '';
				
				echo $labelVideos = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_YT').' '.($i+1).$asterisco.':</label>';
				echo $inputVideos = '<input type="text" id="linkYt'.($i+1).'" class="'.$obligatorio.'" value = "'.$urlVideo.'"	name="videoLink'.($i+1).'" /><br />';
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
			$urlSound = isset($ligasAudios[$i]) ? $ligasAudios[$i]->url : '';
			
			echo $labelSound = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_SC').' '.($i+1).':</label>';
			echo $inputSound = '<input type="text" id="linkSc1'.($i+1).'" class="validate[custom[sc]]" value = "'.$urlSound.'"	name="soundCloudLink'.($i+1).'" /><br />';
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
			if ( isset($objDatos) ) {
				echo '<div class="MultiFile-label" id="imagenes" style="display:block; float:left;">';
				
				foreach ($objDatos->projectPhotos as $key => $value) {
					echo '<input 
							type = "checkbox"
							id = "photosids"
							name = "photoids_'.$value->id.'"  
							class="projectPhotosIds" 
							value="'.$value->id.'" 
							checked="checked" />
							<img alt="'.$objDatos->name.'" src="'.MIDDLE.PHOTO.'/'.$value->name.'" width="100" /><br /><br />';
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
					$contenidoDescription = isset($objDatos) ? $objDatos->description : '';
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
					$contenidoCast = isset($objDatos) ? $objDatos->cast : '';
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
				value="<?php echo isset($objDatos) ? $objDatos->inclosure : ''; ?>" 
				name="inclosure"
				maxlength="100" /> 
			<br>
		
			<br />
			<div id="panel" >
				<label for="direccion"><?php echo JText::_('DIRECCION_RECINTO'); ?>*: </label> 
				<input name="showground" class="validate[required]" value="<?php echo isset($objDatos) ? $objDatos->showground : ''; ?>" id="searchTextField" type="text" size="50">
			</div>
			<div id="map-canvas" style="height: 400px; max-width: 420px"></div>
			<br />
			
			<label for="tags"><?php echo JText::_('KEYWORDS'); ?><br /><span style="font-size: 12px;">(separarlas por comas)</span></label>
			<textarea id="tagsArea" name="tags" cols="60" rows="5"></textarea>
		</fieldset>
	</div>
	
	
	<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
	<input type="button" class="button" id="guardar" value="<?php echo JText::_('GUARDAR'); ?>">
	<input type="button" class="button" id="revision" value="<?php echo JText::_('ENVIAR_REVISION'); ?>" />
	
</form>
<?php 
var_dump($datosObj);
?>