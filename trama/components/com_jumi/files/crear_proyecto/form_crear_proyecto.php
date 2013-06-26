<?php 
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$usuario = JFactory::getUser();
$base = JUri::base();
$document = JFactory::getDocument();
$pathJumi = Juri::base().'/components/com_jumi/files/crear_proyecto/';

$document->addStyleSheet($pathJumi.'css/validationEngine.jquery.css');
$document->addStyleSheet($pathJumi.'css/form2.css');
$document->addScript('http://code.jquery.com/jquery-1.9.1.js');
$document->addScript($pathJumi.'js/mas.js');
$document->addScript($pathJumi.'js/jquery.validationEngine-es.js');
$document->addScript($pathJumi.'js/jquery.validationEngine.js');
$document->addScript($pathJumi.'js/jquery.chained.js');
$document->addScript($pathJumi.'js/jquery.MultiFile.js');

//action=" echo MIDDLE.PUERTO; /trama-middleware/rest/project/create"
?>

<script type="text/javascript" charset="utf-8">
	
  $(function() {
    $("#subcategoria").chained("#categoria");    
});
</script>
<script>
	jQuery(document).ready(function(){
		jQuery("#form2").validationEngine();
		
		

		jQuery("#enviar").click(function (){
			var form = jQuery("#form2")[0];
			var total = form.length;
			var section = '';
			var unitSale = '';
			var capacity = '';
			
			for (i=0; i < total; i++) {
			    seccion = form[i].name.substring(0,7);
			    capayuni = form[i].name.substring(0,8);
			    
			    if(seccion == 'section') {
			       section += form[i].value+','; 
			    }else if(capayuni == 'unitSale'){
			        unitSale += form[i].value+',';
			    }else if(capayuni == 'capacity'){
			        capacity += form[i].value+',';
			    }
			}
			jQuery("#seccion").removeClass("validate[required,custom[onlyLetterNumber]]");
			jQuery("#unidad").removeClass("validate[required,custom[onlyNumberSp]]");
			jQuery("#inventario").removeClass("validate[required,custom[onlyNumberSp]]");
			
			jQuery("#seccion").val(section);
			jQuery("#unidad").val(unitSale);
			jQuery("#inventario").val(capacity);
			
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

	<label for="">Secci&oacute;n:</label> 
	<input type="text" class="validate[required,custom[onlyLetterNumber]]" name="section0">
	<br />
	
	<label for="">Precio unidad:</label> 
	<input type="number" class="validate[required,custom[onlyNumberSp]]" name="unitSale0" step="any"> 
	<br>
	
	<label for="">Inventario(Cantidad):</label> 
	<input type="number" class="validate[required,custom[onlyNumberSp]]" name="capacity0"> 
	<br /> 
	<br /> 
	
	<input type="button" value="Quitar campos" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
	<br />
</div>

<!--FIN DIV DE AGREGAR CAMPOS-->

<h3>Crear un proyecto</h3>

<form id="form2" action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/project/create" enctype="multipart/form-data" method="POST">
	<input type="hidden" name="userId" value="<?php echo $usuario->id; ?>" />
	<input type="hidden" value="0" name="type" />
	
	<label for="nomProy">Nombre del proyecto*:</label> 
	<input type="text" name="name" id="nomProy" class="validate[required,custom[onlyLetterNumber]]" maxlength="100"> 
	<br />
	<!-- aqui va el codigo para que categoria y subcategoria -->
	
	<label for="banner">Imagen(Banner) del proyecto*:</label>
	<input type="file" id="banner" class="validate[required]" name="banner"> 
	<br />
	
	<label for="avatar">Imagen(Avatar) del proyecto*:</label> 
	<input type="file" id="avatar" class="validate[required]" name="avatar"> 
	<br />
	<br />
	 
	Videos promocionales (solo links de youtube):
	<br />
	 
	<label for="linkYt1">Enlace Youtube 1:</label> 
	<input type="text" id="linkYt1" class="validate[custom[yt]]" name="youtubeLink1"> 
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
	
	<label for="seccion">Secci&oacute;n*:</label>
	<input type="text" id="seccion" class="validate[required,custom[onlyLetterNumber]]" name="section"> 
	<br />
	
	<label for="unidad">Precio unidad*:</label> 
	<input type="number" id="unidad" class="validate[required,custom[onlyNumberSp]]" name="unitSale" step="any"> 
	<br> 
	
	<label for="inventario">Inventario(Cantidad)*:</label>
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
	<input type="date" id="productionStartDate" class="validate[required]" name="productionStartDate"> 
	<br>
	
	<label for="productionEndDate">Fecha fin de producci&oacute;n*:</label> 
	<input type="date" id="productionEndDate" class="validate[required]" name="productionEndDate"> 
	<br> 
	
	<label for="premiereStartDate">Fecha inicio presentaci&oacute;n*:</label> 
	<input type="date" id="premiereStartDate" class="validate[required]" name="premiereStartDate"> 
	<br> 
	
	<label for="premiereEndDate">Fecha fin de presentaci&oacute;n*:</label> 
	<input type="date" id="premiereEndDate" class="validate[required]" name="premiereEndDate">
	<br /> 
	<br/> 
	
	<input type="button" id="enviar" value="Enviar">
</form>
