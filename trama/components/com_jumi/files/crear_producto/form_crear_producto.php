<?php 
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$limiteVideos = 5;
$limiteSound = 5;
$countImgs = 10;

$pathJumi = Juri::base().'components/com_jumi/files/crear_proyecto/';
$usuario = JFactory::getUser();
$document = JFactory::getDocument();
$base = JUri::base();

require_once 'getcategorias.php';

$categoria = categoriasforms::getCategoria('all');
$subCategorias = categoriasforms::getSubCat('all');
$opcionesSubCat = '';
$scriptselect = 'jQuery(function() {
	jQuery("#subcategoria").chained("#selectCategoria");
});';

$document->addStyleSheet($pathJumi.'css/validationEngine.jquery.css');
$document->addStyleSheet($pathJumi.'css/form2.css');
$document->addScript('http://code.jquery.com/jquery-1.9.1.js');
$document->addScript($pathJumi.'js/mas.js');
$document->addScript($pathJumi.'js/jquery.validationEngine-es.js');
$document->addScript($pathJumi.'js/jquery.validationEngine.js');
$document->addScript($pathJumi.'js/jquery.chained.js');
$document->addScript($pathJumi.'js/jquery.MultiFile.js');
$document->addScriptDeclaration($scriptselect);

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

	<label for=""><?php echo JText::_('SECCION'); ?>:</label>
	<input 
		type="text"
		class="validate[required,custom[onlyLetterNumber]]"
		name="section0" />
		<br />
		
	<label for=""><?php echo JText::_('PRECIO_UNIDAD'); ?>:</label>
	<input 
		type="text"
		class="validate[required,custom[onlyNumberSp]]" 
		name="unitSale0"/>
		<br />
		
		<label for=""><?php echo JText::_('INVENTARIOPP'); ?>:</label>
		<input
			type="text"
			class="validate[required,custom[onlyNumberSp]]"
			name="capacity0" /> 
		<br />
		<br />
		
		<input 
			type="button" 
			value="<?php echo JText::_('QUITAR_CAMPOS');  ?>"
			onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
		<br />
</div>
<!--FIN DIV DE AGREGAR CAMPOS-->

<h3><?php echo JText::_('CREAR').JText::_('PRODUCTO');  ?></h3>
<form action="" id="form2" enctype="multipart/form-data" method="POST">
	<input
		type="hidden"
		id="status"
		value="0"
		name="status" />
		
	<input 
		type="hidden"
		id="type"
		value="PRODUCT"
		name="type" />
		
	<input 
		type="hidden"
		value="<?php echo $usuario->id; ?>"
		name="userId" />
	
	<label for="nomProy"> <?php echo JText::_('NOMBREPR').JText::_('PRODUCTO');  ?>*: </label> 
	<input type="text" name="name" id="nomProy" class="validate[required,custom[onlyLetterNumber]]" maxlength="100"> 
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
	
	<label for="banner"><?php echo JText::_('BANNER').JText::_('PRODUCTO');  ?>*:</label>
	<input 
		type="file"
		id="banner"
		class="validate[required]"
		name="banner" /> 
	<br />
	
	<label for="avatar"><?php echo JText::_('AVATAR').JText::_('PRODUCTO');  ?>*:</label> 
	<input 
		type="file"
		id="avatar"
		class="validate[required]"
		name="avatar" /> 
	<br />
	<br /> 
	
	<!-- ligas videos -->
	<?php echo JText::_('VIDEOSP');  ?>
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
	<br />
	
	<!-- ligas sonido -->
	<?php echo JText::_('AUDIOSP');  ?>
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
	<br /> 
	
	<label for="descProy"><?php echo JText::_('DESCRIPCION').JText::_('PRODUCTO'); ?>*:</label> <br />
	<textarea name="description" id="descProy" class="validate[required]" cols="60" rows="5"></textarea>
	<br /> 
	
	<label for="elenco"><?php echo JText::_('ELENCO');  ?>:</label> <br />
	<textarea name="cast" id="elenco" cols="60" rows="5"></textarea>
	
	<br /> 
	<label for="inclosure"><?php echo JText::_('RECINTO');  ?>*: </label> 
	<input type="text" class="validate[required]" id="inclosure" name="inclosure" maxlength="100"> 
	<br> 
	
	<br /> 
	<label for="direccion"><?php echo JText::_('DIRECCION_RECINTO');  ?>*: </label> 
	<input type="text" class="validate[required]" id="direccion" name="showground" maxlength="100"> 
	<br> 
	
	<label for="plantilla"><?php echo JText::_('BUSINESS_CASE'); ?>*:</label> 
	<input type="file" class="<?php echo $validacion; ?>" id="plantilla" name="businessCase"> 
	<br />
	
	<label for="presupuesto"><?php echo JText::_('PRESUPUESTO').JText::_('PRODUCTO'); ?>*:</label> 
	<input
		type="number" 
		class="validate[required]"
		id="presupuesto"
		name="budget" /> 
	<br /> 
	
	<br /> <?php echo JText::_('PRECIOS_SALIDA').JText::_('PRODUCTO');  ?>*: 
	<br />
	<br /> 
	
	<label for="seccion"><?php echo JText::_('SECCION'); ?>*:</label>
	<input type="text" id="seccion" class="validate[required,custom[onlyLetterNumber]]" name="section"> 
	<br />
	
	<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input type="text" id="unidad" class="validate[required,custom[onlyNumberSp]]" name="unitSale" step="any"> 
	<br> 
	
	<label for="inventario"><?php echo JText::_('INVENTARIOPP');  ?>*:</label>
	<input type="text" id="inventario" class="validate[required,custom[onlyNumberSp]]" name="capacity"> 
	<br />
	<br />
	 
	<span id="writeroot"></span> 
	<input type="button" onclick="moreFields()" value="<?php echo JText::_('AGREGAR_CAMPOS');  ?>" /> <br /> 
	<br /> 
	
	<label for="potenicales"><?php echo JText::_('INGRESOS_POTENCIALES').JText::_('PRODUCTO'); ?>*:</label> 
	<input 
		type="number" 
		id="potenciales"
		class="validate[required,custom[onlyNumberSp]]"
		name="revenuePotential"
		step="any" /> 
	<br>
	
	<label for="equilibrio"><?php echo JText::_('PUNTO_EQUILIBRIO'); ?>*:</label>
	<input
		type = "number" 
		id = "equilibrio"
		class = "validate[required,custom[onlyNumberSp]]"
		name = "breakeven"
		step="any" /> 
	<br>
	<label for="premiereStartDate"><?php echo JText::_('FECHA_LANZAMIENTO');  ?></label> 
	<input type="text" id="premiereStartDate"  class="validate[required,custom[date],custom[funciondate]]" name="premiereStartDate"> 
	<br> 
	
	<label for="premiereEndDate"><?php echo JText::_('FECHA_CIERRE');  ?></label> 
	<input type="text"  class="validate[required,custom[date],custom[cierre]]" name="premiereEndDate">
	<br /> 
	<br />
	
	<label for="tags"><?php echo JText::_('KEYWORDS'); ?><br /><span style="font-size: 9px;">(separarlas por comas)</span></label>
	<textarea name="tags" cols="60" rows="5"></textarea>
	<br />
	<br />
	
	<input type="button" id="enviar" value="<?php echo JText::_('ENVIAR');  ?>">
</form>
