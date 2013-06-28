<?php 
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$urlproyectco = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/2';
$jsonproyecto = file_get_contents($urlproyectco);
$jsonObjproyecto = json_decode($jsonproyecto);

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
$action = 'action="'.MIDDLE.PUERTO.'/trama-middleware/rest/project/create"';
$hiddenIdProyecto = '';
$banner = '';
$avatar = '';
$opcionesSubCat = '';
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
	$hiddenIdProyecto = '<input type="hidden" name="idProject" value="'.$jsonObjproyecto->id.'"  />';
	$avatar = '<img src="'.MIDDLE.AVATAR.'/'.$jsonObjproyecto->projectAvatar->name.'" width="100" />';
	$banner = '<img src="'.MIDDLE.BANNER.'/'.$jsonObjproyecto->projectBanner->name.'" width="100" />';
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
			var sec = 0;
			var unit = 0;
			var cap = 0;
			
			for (i=0; i < total; i++) {
			    seccion = form[i].name.substring(0,7);
			    capayuni = form[i].name.substring(0,8);
			    if(seccion == 'section') {
			        section[sec] = form[i].value;
			        sec++;
			    }else if(capayuni == 'unitSale'){
			        unitSale[unit] = form[i].value;
			        unit++
			    }else if(capayuni == 'capacity'){
			        capacity[cap] = form[i].value;
			        cap++;
			    }
			}
			
			jQuery("#seccion").removeClass("validate[required,custom[onlyLetterNumber]]");
			jQuery("#unidad").removeClass("validate[required,custom[onlyNumberSp]]");
			jQuery("#inventario").removeClass("validate[required,custom[onlyNumberSp]]");
			
			console.log(section.join(","));
			console.log(unitSale.join(","));
			console.log(capacity.join(","));
			
			jQuery("#seccion").val(section.join(","));
			jQuery("#unidad").val(unitSale.join(","));
			jQuery("#inventario").val(capacity.join(","));
			
			jQuery("#form2").submit();
		});

	});
	
	function checkHELLO(field, rules, i, options){
		if (field.val() != "HELLO") {
			return options.allrules.validate2fields.alertText;
		}
	}
</script>

<!--DIV DE AGREGAR CAMPOS-->
<div id="readroot" style="display: none">
	<label for=""><?php echo JText::_('SECCION'); ?>*:</label> 
	<input type="text" class="validate[required,custom[onlyLetterNumber]]" name="section0">
	<br />
	
	<label for=""><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input type="number" class="validate[required,custom[onlyNumberSp]]" name="unitSale0" step="any"> 
	<br>
	
	<label for=""><? echo jText::_('INVENTARIOPP'); ?>:</label> 
	<input type="number" class="validate[required,custom[onlyNumberSp]]" name="capacity0"> 
	<br /> 
	
	<input type="button" value="Quitar campos" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
	<br /><br />
</div>

<!--FIN DIV DE AGREGAR CAMPOS-->

<h3>Crear un proyecto</h3>

<form id="form2" <?php echo $action; ?> enctype="multipart/form-data" method="POST">
	<?php echo $hiddenIdProyecto; ?>
	<input type="hidden"
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->userId : $usuario->id; ?>"
		   name="userId" />
		   
	<input type="hidden" 
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->status : '0'; ?>"
		   name="status" />
		   
	<input type="hidden"
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->type : '0'; ?>"
		   name="type" />
	
	<label for="nomProy"><?php echo JText::_('NOMBRE').JText::_('PROYECTO'); ?>*:</label>
	<input type="text" name="name" id="nomProy"
		   class="validate[required,custom[onlyLetterNumber]]" 
		   maxlength="100"
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->name : ''; ?>" /> 
	<br />
	
	<label for="categoria">Categoria: </label>
	<select id="selectCategoria" name="categoria">
		
	<?php		
	foreach ( $categoria as $key => $value ) {		
		echo '<option value="'.$value->id.'">'.$value->name.'</option>';
		$opcionesPadre[] = $value->id;
	}
	?>
	</select>
	<br />
	
	<label for="subcategory">Subcategoria: </label>
	<select id="subcategoria" name="subcategory">
		<option value="all">Todas</option>
		<?php
		foreach ( $subCategorias as $key => $value ) {
			$opcionesSubCat .= '<option class="'.$value->father.'" value="'.$value->id.'">'.$value->name.'</option>';
		}		
		echo $opcionesSubCat;
		?>
	</select>
	<br />
	<br />
	
	<label for="banner">Imagen(Banner) del proyecto*:</label>
	<input type="file" id="banner" class="validate[required]" name="banner">
	<br />
	
	<label for="avatar">Imagen(Avatar) del proyecto*:</label> 
	<input type="file" id="avatar" class="validate[required]" name="avatar">
	
	<br />
	<br />
	 
	Videos promocionales (solo links de youtube):
	<br />
	 
	<label for="linkYt1">Enlace Youtube 1*:</label> 
	<input type="text" id="linkYt1" class="validate[required,custom[yt]]" name="youtubeLink1"> 
	<br />
	
	<label for="linkYt2">Enlace Youtube 2:</label> 
	<input type="text" id="linkYt2" class="validate[custom[yt]]" name="youtubeLink2">
	<br />
	
	<label for="linkYt3">Enlace Youtube 3:</label> 
	<input type="text" id="linkYt3" class="validate[custom[yt]]" name="youtubeLink3"> 
	<br />
	
	<label for="linkYt4">Enlace Youtube 4:</label> 
	<input type="text" id="linkYt4" class="validate[custom[yt]]" name="youtubeLink4"> 
	<br />
	
	<label for="linkYt5">Enlace Youtube 5:</label> 
	<input type="text" id="linkYt5" class="validate[custom[yt]]" name="youtubeLink5"> 
	<br />
	
	<br /> Audios promocionales (solo links de soundcloud): 
	<br /> 
	
	<label for="linkSc1">Enlace Soundcloud 1:</label>
	<input type="text" id="linkSc1" class="validate[custom[sc]]" name="soundCloudLink1"> 
	<br />
	
	<label for="linkSc">Enlace Soundcloud 2:</label> 
	<input type="text" id="linkSc2" class="validate[custom[sc]]" name="soundCloudLink2"> 
	<br />
	
	<label for="linkSc3">Enlace Soundcloud 3:</label> 
	<input type="text" id="linkSc3" class="validate[custom[sc]]" name="soundCloudLink3"> 
	<br />
	
	<label for="linkSc4">Enlace Soundcloud 4:</label> 
	<input type="text" id="linkSc4" class="validate[custom[sc]]" name="soundCloudLink4"> 
	<br />
	
	<label for="linkSc5">Enlace Soundcloud 5:</label> 
	<input type="text" id="linkSc5" class="validate[custom[sc]]" name="soundCloudLink5"> 
	<br />
	
	<label for="fotos">Fotos m&aacute;ximo 10 m&iacute;nimo una*:</label> 
	<input class="multi validate[required]" id="fotos" accept="gif|jpg|x-png" type="file" maxlength="10" name="photo"> 
	<br /> 
	
	<label for="descProy">Descripci&oacute;n del proyecto*:</label> <br />
	<textarea name="description" id="descProy" class="validate[required]" cols="60" rows="5"><?php 
		echo isset($jsonObjproyecto) ? $jsonObjproyecto->description : ''; 
	?></textarea>
	<br /> 
	
	<label for="elenco">Elenco:</label> <br />
	<textarea name="cast" id="elenco" cols="60" rows="5"><?php 
		echo isset($jsonObjproyecto) ? $jsonObjproyecto->cast : ''; 
	?></textarea>
	<br />
	
	<label for="direccion">Nombre del recinto*: </label> 
	<input type="text" 
		   class="validate[required]" 
		   id="nameRecinto"
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->inclosure : ''; ?>" 
		   name="inclosure"
		   maxlength="100" /> 
	<br>
	
	<label for="direccion">Direcci&oacute;n del recinto*: </label> 
	<input type="text" 
		   class="validate[required]"
		   id="direccion"
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->showground : ''; ?>"
		   name="showground"
		   maxlength="100" /> 
	<br> 
	
	<label for="plantilla">Cargar la plantilla de Excel con el Business Case*:</label> 
	<input type="file" class="validate[required]" id="plantilla" name="businessCase"> 
	<br />
	
	<label for="presupuesto">Presupuesto del proyecto*:</label> 
	<input type="number" 
		   class="validate[required]"
		   id="presupuesto"
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->budget : ''; ?>"
		   name="budget" /> 
	<br /> 
	
	<br /> Precios de salida del proyecto*: 
	<br />
	<br /> 
	
	<label for="seccion"><?php echo JText::_('SECCION'); ?>*:</label>
	<input type="text" id="seccion" class="validate[required,custom[onlyLetterNumber]]" name="section"> 
	<br />
	
	<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input type="text" id="unidad" class="validate[required,custom[onlyNumberSp]]" name="unitSale"> 
	<br> 
	
	<label for="inventario"><?php echo JText::_('INVENTARIOPP'); ?>*:</label>
	<input type="text" id="inventario" class="validate[required,custom[onlyNumberSp]]" name="capacity"> 
	<br />
	<br />
	 
	<span id="writeroot"></span> 
	<input type="button" onclick="moreFields()" value="Agregar campos" /> <br /> 
	<br /> 
	
	<label for="potenicales">Ingresos potenciales del proyecto*:</label> 
	<input type="number" 
		   id="potenciales"
		   class="validate[required,custom[onlyNumberSp]]"
		   value="<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->revenuePotential : ''; ?>"
		   name="revenuePotential"
		   step="any" /> 
	<br>
	
	<label for="equilibrio">Punto de equilibrio*:</label>
	<input type = "number" 
		   id = "equilibrio"
		   class = "validate[required,custom[onlyNumberSp]]"
		   value = "<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->breakeven : ''; ?>"
		   name = "breakeven"
		   step="any" /> 
	<br>
	
	<label for="productionStartDate">Fecha inicio producci&oacute;n*:</label> 
	<input type = "text" 
	       id = "productionStartDate" 
	       class = "validate[required, custom[date], custom[funciondate]]"
	       value = "<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->productionStartDate : ''; ?>" 
	       name="productionStartDate" /> 
	<br>
	
	<label for="premiereStartDate">Fecha fin de Producci&oacute;n / Lanzamiento*:</label> 
	<input type = "text" 
	       id = "premiereStartDate" 
	       class = "validate[required, custom[date], custom[fininicio]]"
	       value = "<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->premiereStartDate : ''; ?>" 
	       name = "premiereStartDate" />
	       
	<br> 
	
	<label for="premiereEndDate">Fecha de cierre*:</label> 
	<input type = "text" 
		   id = "premiereEndDate" 
		   class = "validate[required], custom[date], custom[cierre]"
		   value = "<?php echo isset($jsonObjproyecto) ? $jsonObjproyecto->premiereEndDate : ''; ?>" 
		   name = "premiereEndDate">
	<br /> 
	<br/> 
	
	<input type="button" id="enviar" value="Enviar">
</form>
