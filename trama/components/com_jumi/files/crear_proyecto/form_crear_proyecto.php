<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
require_once 'libraries/trama/class.php';
require_once 'components/com_jumi/files/crear_proyecto/classIncludes/clase.php';
require_once 'components/com_jumi/files/crear_proyecto/classIncludes/libreriasPP.php';

$categoria = JTrama::getAllCatsPadre();
$subCategorias = JTrama::getAllSubCats();

//si proyid no esta vacio traigo los datos del proyecto del servicio del middleware
$objDatosProyecto = claseTraerDatos::getDatos('project', (!empty($_GET['proyid']))?$_GET['proyid']:null, $subCategorias);

//definicion de campos del formulario
$action = MIDDLE.PUERTO.'/trama-middleware/rest/project/create';
$hiddenphotosIds = '<input type="hidden" name="projectPhotosIds" id="projectPhotosIds" value= ""/>';
$validacion = 'validate[required]';
$countunitSales = 1;
$countImgs = 10;
$limiteVideos = 5;
$limiteSound = 5;
$hiddenIdProyecto = '';
$agregarCampos = '';
$categoriaSelected = '';
$subcategoriaSelected = '';
$banner = '';
$avatar = '';
$opcionesSubCat = '';
$ligasVideos = '';
$ligasAudios = '';
//termina los definicion de campos del formularios


if ( isset ($objDatosProyecto) ) {
	if($objDatosProyecto->status != 0 || $objDatosProyecto->status != 2) {
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php', 'Este proyecto ya no puede ser editado.' );
	}
	$hiddenIdProyecto = '<input type="hidden" value="'.$objDatosProyecto->id.'" name="id" />';
	$hiddenphotosIds = '<input type="hidden"  name="projectPhotosIds" id="projectPhotosIds" />';
	
	$avatar = '<img src="'.MIDDLE.AVATAR.'/'.$objDatosProyecto->projectAvatar->name.'" width="100" />';
	$banner = '<img src="'.MIDDLE.BANNER.'/'.$objDatosProyecto->projectBanner->name.'" width="100" />';
	
	$ligasVideos = $objDatosProyecto->projectYoutubes;
	$ligasAudios = $objDatosProyecto->projectSoundclouds;
	
	$fechaIniProd = explode('-',$objDatosProyecto->productionStartDate);
	$fechaFin = explode('-',$objDatosProyecto->premiereStartDate);
	$fechaCierre = explode('-',$objDatosProyecto->premiereEndDate);
	
	$countunitSales = count($objDatosProyecto->projectUnitSales);
	$datosRecintos = $objDatosProyecto->projectUnitSales;
		
	$validacion = '';
	$validacionImgs = '';
	
	$countImgs = $countImgs - count($objDatosProyecto->projectPhotos);

	$subcategoriaSelected = $objDatosProyecto->subcategory;
	
	foreach ($subCategorias as $key => $value) {
		if( $value->id == $objDatosProyecto->subcategory ) {
			$categoriaSelected = $value->father;
		}
	}
}
?>
<script>
	jQuery(document).ready(function(){		
		jQuery("#form2").validationEngine();
		
		jQuery("#enviar").click(function (){
			var form = jQuery("#form2")[0];
			var total = form.length;
			
			var section = new Array();
			var unitSale = new Array();
			var capacity = new Array();
			var projectPhothosIds = new Array();
			var sec = 0;
			var unit = 0;
			var cap = 0;
			var photos = 0;
			
			for (i=0; i < total; i++) {
			    seccion = form[i].name.substring(0,7);
			    capayuni = form[i].name.substring(0,8);
			    
			    if(seccion == 'section') {
			    	if(form[i].value != ''){
			        	section[sec] = form[i].value;
			        	sec++;
			        }
			    }else if(capayuni == 'unitSale'){
			        if(form[i].value != ''){
			        	unitSale[unit] = form[i].value;
			        	unit++
			        }
			    }else if(capayuni == 'capacity'){
			        if(form[i].value != ''){
			        	capacity[cap] = form[i].value;
			        	cap++;
			        }
			    }else if(capayuni == 'photoids') {
			         if ( form[i].checked ){
			             projectPhothosIds[photos] = form[i].value;
			              photos++
			         }
			    }
			}
			jQuery("#projectPhotosIds").val(projectPhothosIds.join(","));
			
			jQuery("#seccion").removeClass("validate[required,custom[onlyLetterNumber]]");
			jQuery("#unidad").removeClass("validate[required,custom[onlyNumberSp]]");
			jQuery("#inventario").removeClass("validate[required,custom[onlyNumberSp]]");
			
			jQuery("#seccion").val(section.join(","));
			jQuery("#unidad").val(unitSale.join(","));
			jQuery("#inventario").val(capacity.join(","));
						
			jQuery("#form2").submit();
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

<h3><?php echo JText::_('CREAR').JText::_('PROYECTO'); ?></h3>

<form id="form2" action="<?php echo $action; ?>" enctype="multipart/form-data" method="POST">
	<?php 
		echo $hiddenIdProyecto;
		echo $hiddenphotosIds; 
	?>
	<input 
		type="hidden"
		value="<?php echo $usuario->id; ?>"
		name="userId" />
		   
	<input 
		type = "hidden" 
		value = "<?php echo isset($objDatosProyecto) ? $objDatosProyecto->status : '0'; ?>"
		name = "status" />
		   
	<input
		type="hidden"
		value="PROJECT"
		name="type" />
	
	<label for="nomProy"><?php echo JText::_('NOMBRE').' '.JText::_('PROYECTO'); ?>*:</label>
	<input 
		type="text"
		id="nomProy"
		class="validate[required,custom[onlyLetterNumber]]" 
		maxlength="100"
		value="<?php echo isset($objDatosProyecto) ? $objDatosProyecto->name : ''; ?>" 
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
	
	<label for="banner"><?php echo JText::_('BANNER').JText::_('PROYECTO'); ?>*:</label>
	<input type="file" id="banner" accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="banner">
	<br />
	<?php echo $banner; ?>
	<br />
	
	<label for="avatar"><?php echo JText::_('AVATAR').JText::_('PROYECTO'); ?>*:</label> 
	<input type="file" id="avatar" accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="avatar">
	<br />
	<?php echo $avatar; ?>
	<br />
	<br />
	 
	<?php echo JText::_('VIDEOSP'); ?>
	<br />
	 
	<?php
	for ( $i = 0; $i < $limiteVideos; $i++ ) {
		$urlVideo = isset($ligasVideos[$i]) ? $ligasVideos[$i]->url : '';
		$obligatorio = ($i == 0) ? 'validate[required,custom[yt]]' : 'validate[custom[yt]]';
		$asterisco = ($i == 0) ? '*' : '';
		
		echo $labelVideos = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_YT').' '.($i+1).$asterisco.':</label>';
		echo $inputVideos = '<input type="text" id="linkYt'.($i+1).'" class="'.$obligatorio.'" value = "'.$urlVideo.'"	name="youtubeLink'.($i+1).'" /><br />';
	}
	?>
	
	<br /> <?php echo JText::_('AUDIOSP'); ?>
	<br /> 
	
	<?php
	for ( $i = 0; $i < $limiteSound; $i++ ) {
		$urlSound = isset($ligasAudios[$i]) ? $ligasAudios[$i]->url : '';
		
		echo $labelSound = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_SC').' '.($i+1).':</label>';
		echo $inputSound = '<input type="text" id="linkSc1'.($i+1).'" class="validate[custom[sc]]" value = "'.$urlSound.'"	name="soundCloudLink'.($i+1).'" /><br />';
	}
	?>
	
	<label for="fotos" id="labelImagenes"><?php echo JText::_('FOTOS'); ?><span id="maximoImg"><?php echo $countImgs; ?></span>*:</label> 
	<input class="multi <?php echo $validacion; ?>" id="fotos" accept="gif|jpg|x-png" type="file" maxlength="10" name="photo" />
	
	<?php
	if ( isset($objDatosProyecto) ) {
		echo '<div class="MultiFile-label" id="imagenes" style="display:block; float:left;">';
		
		foreach ($objDatosProyecto->projectPhotos as $key => $value) {
			echo '<input 
					type = "checkbox"
					id = "photosids"
					name = "photoids_'.$value->id.'"  
					class="projectPhotosIds" 
					value="'.$value->id.'" 
					checked="checked" />
					<img alt="'.$objDatosProyecto->name.'" src="'.MIDDLE.PHOTO.'/'.$value->name.'" width="100" /><br /><br />';
		}
		
		echo '</div>';
	}
	?> 
	<br /> 
	
	<label for="descProy"><?php echo JText::_('DESCRIPCION').JText::_('PROYECTO'); ?>*:</label> <br />
	<textarea name="description" id="descProy" class="validate[required]" cols="60" rows="5"><?php 
		echo isset($objDatosProyecto) ? $objDatosProyecto->description : ''; 
	?></textarea>
	<br /> 
	
	<label for="elenco"><?php echo JText::_('ELENCO'); ?>:</label> <br />
	<textarea name="cast" id="elenco" cols="60" rows="5"><?php 
		echo isset($objDatosProyecto) ? $objDatosProyecto->cast : ''; 
	?></textarea>
	<br />
	
	<label for="direccion"><?php echo JText::_('RECINTO'); ?>*: </label> 
	<input 
		type="text" 
		class="validate[required]" 
		id="nameRecinto"
		value="<?php echo isset($objDatosProyecto) ? $objDatosProyecto->inclosure : ''; ?>" 
		name="inclosure"
		maxlength="100" /> 
	<br>
	
	<label for="direccion"><?php echo JText::_('DIRECCION_RECINTO'); ?>*: </label> 
	<input 
		type="text" 
		class="validate[required]"
		id="direccion"
		value="<?php echo isset($objDatosProyecto) ? $objDatosProyecto->showground : ''; ?>"
		name="showground"
		maxlength="100" /> 
	<br> 
	
	<label for="plantilla"><?php echo JText::_('BUSINESS_CASE'); ?>*:</label> 
	<input type="file" class="<?php echo $validacion; ?>" id="plantilla" name="businessCase"> 
	<br />
	
	<label for="presupuesto"><?php echo JText::_('PRESUPUESTO').JText::_('PROYECTO'); ?>*:</label> 
	<input 10
		type="number" 
		class="validate[required]"
		id="presupuesto"
		value="<?php echo isset($objDatosProyecto) ? $objDatosProyecto->budget : ''; ?>"
		name="budget" /> 
	<br /> 
	
	<br /> <?php echo JText::_('PRECIOS_SALIDA').JText::_('PROYECTO')?>*: 
	<br />
	<br /> 
	
	<label for="seccion"><?php echo JText::_('SECCION'); ?>*:</label>
	<input 
		type="text" 
		id="seccion" 
		class="validate[required,custom[onlyLetterNumber]]"
		value="<?php echo isset($objDatosProyecto) ? $datosRecintos[0]->section : ''; ?>" 
		name="section"> 
	<br />
	
	<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input 
		type="text" 
		id="unidad" 
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($objDatosProyecto) ? $datosRecintos[0]->unitSale : ''; ?>" 
		name="unitSale"> 
	<br> 
	
	<label for="inventario"><?php echo JText::_('INVENTARIOPP'); ?>*:</label>
	<input 
		type="text"
		id="inventario" 
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($objDatosProyecto) ? $datosRecintos[0]->capacity : ''; ?>"  
		name="capacity"> 
	<br />
	<br />
	
	<?php
		for($i = 1; $i < $countunitSales; $i++) {
			$valorSection = isset($objDatosProyecto) ? $datosRecintos[$i]->section : '';
			$valorUnitSales = isset($objDatosProyecto) ? $datosRecintos[$i]->unitSale : '';
			$valorCapacity = isset($objDatosProyecto) ? $datosRecintos[$i]->capacity : '';
			
			$unitsales = '<label for="seccion_E'.$i.'">'.JText::_('SECCION').'*:</label>';
			$unitsales .= '<input'; 
			$unitsales .= '		type = "text"'; 
			$unitsales .= '		id = "seccion_E'.$i.'"'; 
			$unitsales .= '		class = "validate[required,custom[onlyLetterNumber]]"'; 
			$unitsales .= '		value = "'.$valorSection.'"';
			$unitsales .= '		name = "section_E'.$i.'"/>'; 
			$unitsales .= '	<br />';
				
			$unitsales .= '	<label for="unidad_E'.$i.'">'.JText::_('PRECIO_UNIDAD').'*:</label>'; 
			$unitsales .= '	<input ';
			$unitsales .= '		type="text" ';
			$unitsales .= '		id="unidad_E'.$i.'" ';
			$unitsales .= '		class="validate[required,custom[onlyNumberSp]]"';
			$unitsales .= '		value="'.$valorUnitSales.'"';
			$unitsales .= '		name = "unitSale_E'.$i.'" />'; 
			$unitsales .= '	<br> ';
				
			$unitsales .= '	<label for="inventario_E'.$i.'">'.JText::_('INVENTARIOPP').'*:</label>';
			$unitsales .= '	<input ';
			$unitsales .= '		type="text" id="inventario"';
			$unitsales .= '		id="inventario_E'.$i.'" ';
			$unitsales .= '		class="validate[required,custom[onlyNumberSp]]"';
			$unitsales .= '		value="'.$valorCapacity.'"';
			$unitsales .= '		name = "capacity_E'.$i.'" />'; 
			$unitsales .= '	<br />';
			$unitsales .= '	<br />';
			
			echo $unitsales;
		}
	?>
	 
	<span id="writeroot"></span> 
	<input type="button" onclick="moreFields()" value="<?php echo JText::_('AGREGAR_CAMPOS')?>" /> <br /> 
	<br /> 
	
	<label for="potenicales"><?php echo JText::_('INGRESOS_POTENCIALES').JText::_('PROYECTO'); ?>*:</label> 
	<input 
		type="number" 
		id="potenciales"
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($objDatosProyecto) ? $objDatosProyecto->revenuePotential : ''; ?>"
		name="revenuePotential"
		step="any" /> 
	<br>
	
	<label for="equilibrio"><?php echo JText::_('PUNTO_EQUILIBRIO'); ?>*:</label>
	<input
		type = "number" 
		id = "equilibrio"
		class = "validate[required,custom[onlyNumberSp]]"
		value = "<?php echo isset($objDatosProyecto) ? $objDatosProyecto->breakeven : ''; ?>"
		name = "breakeven"
		step="any" /> 
	<br>
	
	<label for="productionStartDate"><?php echo JText::_('FECHA_INICIO_PRODUCCION')?>*:</label> 
	<input
		type = "text" 
	    id = "productionStartDate" 
	    class = "validate[required, custom[date], custom[funciondate]]"
	    value = "<?php echo isset($objDatosProyecto) ? $fechaIniProd[2].'/'.$fechaIniProd[1].'/'.$fechaIniProd[0] : ''; ?>" 
	    name = "productionStartDate" /> 
	<br>
	
	<label for="premiereStartDate"><?php echo JText::_('FECHA_FIN_INICIO')?>*:</label> 
	<input 
		type = "text" 
	    id = "premiereStartDate" 
	    class = "validate[required, custom[date], custom[fininicio]]"
	    value = "<?php echo isset($objDatosProyecto) ? $fechaFin[2].'/'.$fechaFin[1].'/'.$fechaFin[0] : ''; ?>" 
	    name = "premiereStartDate" />
	       
	<br> 
	
	<label for="premiereEndDate"><?php echo JText::_('FECHA_CIERRE')?>*:</label> 
	<input 
		type = "text" 
		id = "premiereEndDate" 
		class = "validate[required, custom[date], custom[cierre]]"
		value = "<?php echo isset($objDatosProyecto) ? $fechaCierre[2].'/'.$fechaCierre[1].'/'.$fechaCierre[0] : ''; ?>" 
		name = "premiereEndDate">
	<br /> 
	<br />
	
	<label for="tags"><?php echo JText::_('KEYWORDS'); ?><br /><span style="font-size: 9px;">(separarlas por comas)</span></label>
	<textarea name="tags" cols="60" rows="5"><?php
		if( isset($objDatosProyecto) && !empty($objDatosProyecto->tags)) {
			foreach ($objDatosProyecto->tags as $key => $value) {
				$array[] = $value->tag;
			}
			$tags = implode($array, ', ');
			echo $tags;
			
		}else {
			echo '';
		}
	?></textarea>
	<br />
	<br /> 
	
	<input type="button" id="enviar" value="<?php echo JText::_('ENVIAR'); ?>">
</form>