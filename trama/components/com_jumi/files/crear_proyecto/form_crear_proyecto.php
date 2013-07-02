<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$limiteVideos = 5;
$limiteSound = 5;

if(!empty($_GET['proyid'])) {
	$urlproyectco = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$_GET['proyid'];
	$jsonproyecto = file_get_contents($urlproyectco);
	$jsonObjproyecto = json_decode($jsonproyecto);
}


							function getCategoria() {
								$urlCategoria = MIDDLE.PUERTO.'/trama-middleware/rest/category/categories';
								$jsonCategoria = file_get_contents($urlCategoria);
								$jsonObjCategoria = json_decode($jsonCategoria);
								        
							    return $jsonObjCategoria;
							}
							
							function getSubCat() { 	
								$urlSubcategoria = MIDDLE.PUERTO.'/trama-middleware/rest/category/subcategories/all';
								$jsonSubcategoria = file_get_contents($urlSubcategoria);
								$jsonObjSubcategoria = json_decode($jsonSubcategoria);
								
								return $jsonObjSubcategoria;
								
							}
							
$usuario = JFactory::getUser();
$document = JFactory::getDocument();
$base = JUri::base();
$pathJumi = Juri::base().'components/com_jumi/files/crear_proyecto/';


//definicion de campos del formulario
$action = MIDDLE.PUERTO.'/trama-middleware/rest/project/create';
//$action = 'http://localhost/lutek/test.php';
$hiddenIdProyecto = '';
$hiddenphotosIds = '';
$banner = '';
$avatar = '';
$opcionesSubCat = '';
$ligasVideos = '';
$ligasAudios = '';
$countunitSales = 1;
$agregarCampos = '';
$validacion = 'validate[required]';
$validacionImgs = 'validate[required]';
$countImgs = 10;
$categoriaSelected = '';
$subcategoriaSelected = '';
//termina los definicion de campos del formularios

$categoria = getCategoria();
$subCategorias = getSubCat();
$scriptselect = 'jQuery(function() {
	jQuery("#subcategoria").chained("#selectCategoria");	
});';

$document->addStyleSheet($pathJumi.'css/validationEngine.jquery.css');
$document->addStyleSheet($pathJumi.'css/form2.css');
$document->addScript('http://code.jquery.com/jquery-1.9.1.js');
$document->addScript($pathJumi.'js/mas.js');
$document->addScript($pathJumi.'js/jquery.mask.js');
$document->addScript($pathJumi.'js/jquery.validationEngine-es.js');
$document->addScript($pathJumi.'js/jquery.validationEngine.js');
$document->addScript($pathJumi.'js/jquery.chained.js');
$document->addScript($pathJumi.'js/jquery.MultiFile.js');
$document->addScript('http://dev7studios.com/demo/jquery-currency/jquery.currency.js');
$document->addScriptDeclaration($scriptselect);

if ( isset ( $jsonObjproyecto ) ) {
		
	$hiddenIdProyecto = '<input type="hidden" value="'.$jsonObjproyecto->id.'" name="id" />';
	$hiddenphotosIds = '<input type="hidden"  name="projectPhotosIds" id="projectPhotosIds" />';
	
	$avatar = '<img src="'.MIDDLE.AVATAR.'/'.$jsonObjproyecto->projectAvatar->name.'" width="100" />';
	$banner = '<img src="'.MIDDLE.BANNER.'/'.$jsonObjproyecto->projectBanner->name.'" width="100" />';
	
	$ligasVideos = $jsonObjproyecto->projectYoutubes;
	$ligasAudios = $jsonObjproyecto->projectSoundclouds;
	
	$fechaIniProd = explode('-',$jsonObjproyecto->productionStartDate);
	$fechaFin = explode('-',$jsonObjproyecto->premiereStartDate);
	$fechaCierre = explode('-',$jsonObjproyecto->premiereEndDate);
	
	$countunitSales = count($jsonObjproyecto->projectUnitSales);
	$datosRecintos = $jsonObjproyecto->projectUnitSales;
		
	$validacion = '';
	$validacionImgs = '';
	
	$countImgs = $countImgs - count($jsonObjproyecto->projectPhotos);
	
	$subcat = getSubCat();
	$subcategoriaSelected = $jsonObjproyecto->subcategory;
	
	foreach ($subcat as $key => $value) {
		if( $value->id == $jsonObjproyecto->subcategory ) {
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
			    photosIds = form[i].name.substring(0,9);
			console.log(photosIds);
			
			    if(seccion == 'section') {
			        section[sec] = form[i].value;
			        sec++;
			    }else if(capayuni == 'unitSale'){
			        unitSale[unit] = form[i].value;
			        unit++
			    }else if(capayuni == 'capacity'){
			        capacity[cap] = form[i].value;
			        cap++;
			    }else if(photosIds == 'photosids') {
			         projectPhothosIds[photos] = form[i].value;
			         photos++
			    }
			}
			jQuery("#projectPhotosIds").val(projectPhothosIds.join(","));
			
			jQuery("#seccion").removeClass("validate[required,custom[onlyLetterNumber]]");
			jQuery("#unidad").removeClass("validate[required,custom[onlyNumberSp]]");
			jQuery("#inventario").removeClass("validate[required,custom[onlyNumberSp]]");
			
			jQuery("#seccion").val(section.join(","));
			jQuery("#unidad").val(unitSale.join(","));
			jQuery("#inventario").val(capacity.join(","));
			
			jQuery("#projectPhotosIds").val(projectPhothosIds.join(","));
			
			jQuery("#form2").submit();
		});
		
		jQuery('.projectPhotosIds').change(function () {
			if ( jQuery(this).prop('checked') ) {
				maxImgs = parseInt(jQuery('#fotos').attr('maxlength')) - 1;
				
				jQuery('#fotos').attr('maxlength',maxImgs)
			} else {
				maxImgs = parseInt(jQuery('#fotos').attr('maxlength')) + 1;
				
				jQuery('#fotos').attr('maxlength',maxImgs)
			} 
		});
		
	});
	
	function checkHELLO(field, rules, i, options){
		if (field.val() != "HELLO") {
			return options.allrules.validate2fields.alertText;
		}
	}
</script>

<!--DIV DE AGREGAR CAMPOS-->
<?php
$divrecintos = '<div id="readroot" style="display: none">
	<label for="">'.JText::_('SECCION').'*:</label> 
	<input 
		type="text" 
		class="validate[required,custom[onlyLetterNumber]]"
		name="section0">
	<br />
	
	<label for="">'.JText::_('PRECIO_UNIDAD').'*:</label> 
	<input 
		type="number" 
		class="validate[required,custom[onlyNumberSp]]" 
		name="unitSale0" step="any"> 
	<br>
	
	<label for="">'.JText::_('INVENTARIOPP').':</label> 
	<input 
		type="number" 
		class="validate[required,custom[onlyNumberSp]]" 
		value=""
		name="capacity0"> 
	<br /> 
	
	<input 
		type="button" 
		value="'.JText::_('QUITAR_CAMPOS').'" 
		onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
	<br /><br />
</div>';

echo $divrecintos;
?>

<!--FIN DIV DE AGREGAR CAMPOS-->

<h3><?php echo JText::_('CREAR').JText::_('PROYECTO'); ?></h3>

<form id="form2" action="<?php echo $action; ?>" enctype="multipart/form-data" method="POST">
	<?php 
		echo $hiddenIdProyecto;
		echo $hiddenphotosIds; 
	?>
	<input 
		type="hidden"
		value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->userId : $usuario->id; ?>"
		name="userId" />
		   
	<input 
		type = "hidden" 
		value = "<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->status : '0'; ?>"
		name = "status" />
		   
	<input
		type="hidden"
		value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->type : 'PROJECT'; ?>"
		name="type" />
	
	<label for="nomProy"><?php echo JText::_('NOMBRE').' '.JText::_('PROYECTO'); ?>*:</label>
	<input 
		type="text" name="name" id="nomProy"
		class="validate[required,custom[onlyLetterNumber]]" 
		maxlength="100"
		value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->name : ''; ?>" /> 
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
	
	<label for="fotos" id="labelImagenes"><?php echo JText::_('FOTOS'); ?>*:</label> 
	<input class="multi <?php echo $validacionImgs; ?>" id="fotos" accept="gif|jpg|x-png" type="file" maxlength="<?php echo $countImgs; ?>" name="photo" />
	
	<?php
	if ( isset($jsonObjproyecto) ) {
		echo '<div id="imagenes" style="display:block; float:left;">';
		
		foreach ($jsonObjproyecto->projectPhotos as $key => $value) {
			echo '<input 
					type = "checkbox"
					id = "photosids"
					name = "photosids"  
					class="projectPhotosIds" 
					value="'.$value->id.'" 
					checked="checked" />';
		 	echo '<img src="'.MIDDLE.PHOTO.'/'.$value->name.'" width="100" /><br />';
		}
		
		echo '</div>';
	}
	?> 
	<br /> 
	
	<label for="descProy"><?php echo JText::_('DESCRIPCION').JText::_('PROYECTO'); ?>*:</label> <br />
	<textarea name="description" id="descProy" class="validate[required]" cols="60" rows="5"><?php 
		echo isset($jsonObjproyecto) ? $jsonObjproyecto->description : ''; 
	?></textarea>
	<br /> 
	
	<label for="elenco"><?php echo JText::_('ELENCO'); ?>:</label> <br />
	<textarea name="cast" id="elenco" cols="60" rows="5"><?php 
		echo isset($jsonObjproyecto) ? $jsonObjproyecto->cast : ''; 
	?></textarea>
	<br />
	
	<label for="direccion"><?php echo JText::_('RECINTO'); ?>*: </label> 
	<input 
		type="text" 
		class="validate[required]" 
		id="nameRecinto"
		value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->inclosure : ''; ?>" 
		name="inclosure"
		maxlength="100" /> 
	<br>
	
	<label for="direccion"><?php echo JText::_('DIRECCION_RECINTO'); ?>*: </label> 
	<input 
		type="text" 
		class="validate[required]"
		id="direccion"
		value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->showground : ''; ?>"
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
		value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->budget : ''; ?>"
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
		value="<?php echo isset($jsonObjproyecto) ? $datosRecintos[0]->section : ''; ?>" 
		name="section"> 
	<br />
	
	<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input 
		type="text" 
		id="unidad" 
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($jsonObjproyecto) ? $datosRecintos[0]->unitSale : ''; ?>" 
		name="unitSale"> 
	<br> 
	
	<label for="inventario"><?php echo JText::_('INVENTARIOPP'); ?>*:</label>
	<input 
		type="text" id="inventario" 
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($jsonObjproyecto) ? $datosRecintos[0]->capacity : ''; ?>"  
		name="capacity"> 
	<br />
	<br />
	
	<?php
		for($i = 1; $i < $countunitSales; $i++) {
			$valorSection = isset($jsonObjproyecto) ? $datosRecintos[$i]->section : '';
			$valorUnitSales = isset($jsonObjproyecto) ? $datosRecintos[$i]->unitSale : '';
			$valorCapacity = isset($jsonObjproyecto) ? $datosRecintos[$i]->capacity : '';
			
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
		value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->revenuePotential : ''; ?>"
		name="revenuePotential"
		step="any" /> 
	<br>
	
	<label for="equilibrio"><?php echo JText::_('PUNTO_EQUILIBRIO'); ?>*:</label>
	<input
		type = "number" 
		id = "equilibrio"
		class = "validate[required,custom[onlyNumberSp]]"
		value = "<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->breakeven : ''; ?>"
		name = "breakeven"
		step="any" /> 
	<br>
	
	<label for="productionStartDate"><?php echo JText::_('FECHA_INICIO_PRODUCCION')?>*:</label> 
	<input
		type = "text" 
	    id = "productionStartDate" 
	    class = "validate[required, custom[date], custom[funciondate]]"
	    value = "<?php echo isset($jsonObjproyecto) ? $fechaIniProd[2].'/'.$fechaIniProd[1].'/'.$fechaIniProd[0] : ''; ?>" 
	    name = "productionStartDate" /> 
	<br>
	
	<label for="premiereStartDate"><?php echo JText::_('FECHA_FIN_INICIO')?>*:</label> 
	<input 
		type = "text" 
	    id = "premiereStartDate" 
	    class = "validate[required, custom[date], custom[fininicio]]"
	    value = "<?php echo isset($jsonObjproyecto) ? $fechaFin[2].'/'.$fechaFin[1].'/'.$fechaFin[0] : ''; ?>" 
	    name = "premiereStartDate" />
	       
	<br> 
	
	<label for="premiereEndDate"><?php echo JText::_('FECHA_CIERRE')?>*:</label> 
	<input 
		type = "text" 
		id = "premiereEndDate" 
		class = "validate[required], custom[date], custom[cierre]"
		value = "<?php echo isset($jsonObjproyecto) ? $fechaCierre[2].'/'.$fechaCierre[1].'/'.$fechaCierre[0] : ''; ?>" 
		name = "premiereEndDate">
	<br /> 
	<br/> 
	
	<input type="button" id="enviar" value="<?php echo JText::_('ENVIAR'); ?>">
</form>
