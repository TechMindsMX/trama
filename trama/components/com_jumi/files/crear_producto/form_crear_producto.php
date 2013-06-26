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

?>

<script type="text/javascript" charset="utf-8">
	
  $(function() {
    $("#subcategoria").chained("#categoria");    
});
</script>
<script>
	jQuery(document).ready(function(){
		jQuery("#form2").validationEngine();
	});
	function checkHELLO(field, rules, i, options){
		if (field.val() != "HELLO") {
			return options.allrules.validate2fields.alertText;
		}
	}
</script>


  
  <script>
  jQuery(function() {
    jQuery( "#datepicker1" ).datepicker();
    jQuery( "#datepicker2" ).datepicker();
  });
  </script>
<!--DIV DE AGREGAR CAMPOS-->
<div id="readroot" style="display: none">

	<label for="">Secci&oacute;n:</label> <input type="text"
		class="validate[required,custom[onlyLetterNumber]]" name="section0"> <br />
	<label for="">Precio unidad:</label> <input type="number"
		class="validate[required,custom[onlyNumberSp]]" name="unitSale0"
		step="any"> <br> <label for="">Inventario(Cantidad):</label> <input
		type="number" class="validate[required,custom[onlyNumberSp]]"
		name="capacity0"> <br /> <br /> <input type="button"
		value="Quitar campos"
		onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
	<br />
</div>
<!--FIN DIV DE AGREGAR CAMPOS-->
<h3>Crear un producto</h3>
<form action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/project/create" id="form2" enctype="multipart/form-data" method="POST">
	<input type="hidden" name="status" id="status" value="0" >
	<label for="nomProy">Nombre del producto*:</label> 
	<input type="text" name="name" id="nomProy" class="validate[required,custom[onlyLetterNumber]]" maxlength="100"> 
	<br />
	<!-- aqui va el codigo para que categoria y subcategoria -->
	
	<label for="banner">Imagen(Banner) del producto*:</label>
	<input type="file" id="banner" class="validate[required]" name="banner"> 
	<br />
	
	<label for="avatar">Imagen(Avatar) del producto*:</label> 
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
	
	<label for="descProy">Descripci&oacute;n del producto*:</label> <br />
	<textarea name="description" id="descProy" class="validate[required]" cols="60" rows="5"></textarea>
	<br /> 
	
	<label for="elenco">Elenco:</label> <br />
	<textarea name="cast" id="elenco" cols="60" rows="5"></textarea>
	
	<br /> 
	<label for="inclosure">Nombre del recinto*: </label> 
	<input type="text" class="validate[required]" id="inclosure" name="inclosure" maxlength="100"> 
	<br> 
	
	<br /> 
	<label for="direccion">Direcci&oacute;n del recinto*: </label> 
	<input type="text" class="validate[required]" id="direccion" name="showground" maxlength="100"> 
	<br> 
	
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
	
	<label for="premiereStartDate">Fecha de lanzamiento*:</label> 
	<input type="date"  class="validate[required]" name="premiereStartDate"> 
	<br> 
	
	<label for="premiereEndDate">Fecha de cierre*:</label> 
	<input type="date"  class="validate[required]" name="premiereEndDate">
	<br /> 
	<br/> 
	
	<input type="submit" value="Enviar">
</form>
