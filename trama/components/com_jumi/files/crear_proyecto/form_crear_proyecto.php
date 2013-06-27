<?php 
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$urlproyectco = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/1';
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

$opcionesSubCat = '';
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

//action=" echo MIDDLE.PUERTO; /trama-middleware/rest/project/create"
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
			    console.log('en seccion');
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

<form id="form2" action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/project/create" enctype="multipart/form-data" method="POST">
	<input type="hidden" name="userId" value="<?php echo $usuario->id; ?>" />
	<input type="hidden" name="status" value="0"  />
	<input type="hidden" name="type" value="0"  />
	
	<label for="nomProy"><?php echo JText::_('NOMBRE').JText::_('PROYECTO'); ?>*:</label> 
	<input type="text" name="name" id="nomProy" class="validate[required,custom[onlyLetterNumber]]" maxlength="100" value="<?php echo $jsonObjproyecto->name; ?>"> 
	<br />
	
	<label for="categoria">Categoria: </label>
	<select id="selectCategoria" name="categoria">
		
	<?php		
	foreach ( $categoria as $key => $value ) {
		var_dump($value->id);
		
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
	<textarea name="description" id="descProy" class="validate[required]" cols="60" rows="5"></textarea>
	<br /> 
	
	<label for="elenco">Elenco:</label> <br />
	<textarea name="cast" id="elenco" cols="60" rows="5"></textarea>
	<br />
	
	<label for="direccion">Nombre del recinto*: </label> 
	<input type="text" class="validate[required]" id="nameRecinto" name="inclosure" maxlength="100"> 
	<br>
	
	<label for="direccion">Direcci&oacute;n del recinto*: </label> 
	<input type="text" class="validate[required]" id="direccion" name="showground" maxlength="100"> 
	<br> 
	
	<label for="plantilla">Cargar la plantilla de Excel con el Business Case*:</label> 
	<input type="file" class="validate[required]" id="plantilla" name="businessCase"> 
	<br />
	
	<label for="presupuesto">Presupuesto del proyecto*:</label> 
	<input type="number" class="validate[required]"	id="presupuesto" name="budget"> 
	<br /> 
	
	<br /> Precios de salida del proyecto*: 
	<br />
	<br /> 
	
	<label for="seccion"><?php echo JText::_('SECCION'); ?>*:</label>
	<input type="text" id="seccion" class="validate[required,custom[onlyLetterNumber]]" name="section"> 
	<br />
	
	<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input type="number" id="unidad" class="validate[required,custom[onlyNumberSp]]" name="unitSale"> 
	<br> 
	
	<label for="inventario"><?php echo JText::_('INVENTARIOPP'); ?>*:</label>
	<input type="number" id="inventario" class="validate[required,custom[onlyNumberSp]]" name="capacity"> 
	<br />
	<br />
	 
	<span id="writeroot"></span> 
	<input type="button" onclick="moreFields()" value="Agregar campos" /> <br /> 
	<br /> 
	
	<label for="potenicales">Ingresos potenciales del proyecto*:</label> 
	<input type="number" id="potenciales" class="validate[required,custom[onlyNumberSp]]" name="revenuePotential" step="any"> 
	<br>
	
	<label for="equilibrio">Punto de equilibrio*:</label>
	<input type="number" id="equilibrio" class="validate[required,custom[onlyNumberSp]]" name="breakeven" step="any"> 
	<br>
	
	<label for="productionStartDate">Fecha inicio producci&oacute;n*:</label> 
	<input type="text" id="productionStartDate" class="validate[required, custom[date], custom[funciondate]]" name="productionStartDate"> 
	<br>
	
	<label for="premiereStartDate">Fecha fin de Producci&oacute;n / Lanzamiento*:</label> 
	<input type="text" id="premiereStartDate" class="validate[required, custom[date], custom[fininicio]]" name="premiereStartDate"> 
	<br> 
	
	<label for="premiereEndDate">Fecha de cierre*:</label> 
	<input type="text" id="premiereEndDate" class="validate[required], custom[date], custom[cierre]" name="premiereEndDate">
	<br /> 
	<br/> 
	
	<input type="button" id="enviar" value="Enviar">
</form>
