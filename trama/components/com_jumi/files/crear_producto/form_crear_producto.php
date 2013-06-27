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

	<label for=""><?php echo JText::_('SECCION'); ?>:</label> <input type="text"
		class="validate[required,custom[onlyLetterNumber]]" name="section0"> <br />
	<label for=""><?php echo JText::_('PRECIO_UNIDAD'); ?>:</label> <input type="number"
		class="validate[required,custom[onlyNumberSp]]" name="unitSale0"
		step="any"> <br> <label for=""><?php echo JText::_('INVENTARIOPP'); ?>:</label> <input
		type="number" class="validate[required,custom[onlyNumberSp]]"
		name="capacity0"> <br /> <br /> <input type="button" value="<?php echo JText::_('QUITAR_CAMPOS');  ?>"
		onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
	<br />
</div>
<!--FIN DIV DE AGREGAR CAMPOS-->
<h3><?php echo JText::_('CREAR').JText::_('PRODUCTO');  ?></h3>
<form action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/project/create" id="form2" enctype="multipart/form-data" method="POST">
	<input type="hidden" name="status" id="status" value="0" >
	<input type="hidden" name="type" id="type" value="1" >
	<label for="nomProy"><?php echo JText::_('NOMBREPR').JText::_('PRODUCTO');  ?>*:</label> 
	<input type="text" name="name" id="nomProy" class="validate[required,custom[onlyLetterNumber]]" maxlength="100"> 
	<br />
	<!-- aqui va el codigo para que categoria y subcategoria -->
	
	<label for="banner"><?php echo JText::_('BANNER').JText::_('PRODUCTO');  ?>*:</label>
	<input type="file" id="banner" class="validate[required]" name="banner"> 
	<br />
	
	<label for="avatar"><?php echo JText::_('AVATAR').JText::_('PRODUCTO');  ?>*:</label> 
	<input type="file" id="avatar" class="validate[required]" name="avatar"> 
	<br />
	
	<br /> 
	<?php echo JText::_('VIDEOSP');  ?>
	<br /> 
	<label for="linkYt1"><?php echo JText::_('ENLACE_YT');  ?>1*:</label> 
	<input type="text" id="linkYt1" class="validate[required,custom[yt]]" name="youtubeLink1"> 
	<br />
	
	<label for="linkYt2"><?php echo JText::_('ENLACE_YT');  ?>2:</label> 
	<input type="text" id="linkYt2" class="validate[custom[yt]]" name="youtubeLink2">
	<br />
	
	<label for="linkYt3"><?php echo JText::_('ENLACE_YT');  ?>3:</label> 
	<input type="text" id="linkYt3" class="validate[custom[yt]]" name="youtubeLink3"> 
	<br />
	
	<label for="linkYt4"><?php echo JText::_('ENLACE_YT');  ?>4:</label> 
	<input type="text" id="linkYt4" class="validate[custom[yt]]" name="youtubeLink4"> 
	<br />
	
	<label for="linkYt5"><?php echo JText::_('ENLACE_YT');  ?>5:</label> 
	<input type="text" id="linkYt5" class="validate[custom[yt]]" name="youtubeLink5"> 
	<br />
	
	<br /> <?php echo JText::_('AUDIOSP');  ?>
	<br /> 
	
	<label for="linkSc1"><?php echo JText::_('ENLACE_SC');  ?> 1:</label> 
	<input type="text" id="linkSc1" class="validate[custom[sc]]" name="soundCloudLink1"> 
	<br />
	
	<label for="linkSc"><?php echo JText::_('ENLACE_SC');  ?> 2:</label> 
	<input type="text" id="linkSc2" class="validate[custom[sc]]" name="soundCloudLink2"> 
	<br />
	
	<label for="linkSc3"><?php echo JText::_('ENLACE_SC');  ?> 3:</label> 
	<input type="text" id="linkSc3" class="validate[custom[sc]]" name="soundCloudLink3"> 
	<br />
	
	<label for="linkSc4"><?php echo JText::_('ENLACE_SC');  ?> 4:</label> 
	<input type="text" id="linkSc4" class="validate[custom[sc]]" name="soundCloudLink4"> 
	<br />
	
	<label for="linkSc5"><?php echo JText::_('ENLACE_SC');  ?> 5:</label> 
	<input type="text" id="linkSc5" class="validate[custom[sc]]" name="soundCloudLink5"> 
	<br />
	
	<label for="fotos"><?php echo JText::_('FOTOS');  ?>*:</label> 
	<input class="multi validate[required]" id="fotos" accept="gif|jpg|x-png" type="file" maxlength="10" name="photo"> 
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
	
	<br /> <?php echo JText::_('PRECIOS_SALIDA').JText::_('PRODUCTO');  ?>*: 
	<br />
	<br /> 
	
	<label for="seccion"><?php echo JText::_('SECCION'); ?>*:</label>
	<input type="text" id="seccion" class="validate[required,custom[onlyLetterNumber]]" name="section"> 
	<br />
	
	<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input type="number" id="unidad" class="validate[required,custom[onlyNumberSp]]" name="unitSale" step="any"> 
	<br> 
	
	<label for="inventario"><?php echo JText::_('INVENTARIOPP');  ?>*:</label>
	<input type="number" id="inventario" class="validate[required,custom[onlyNumberSp]]" name="capacity"> 
	<br />
	<br />
	 
	<span id="writeroot"></span> 
	<input type="button" onclick="moreFields()" value="<?php echo JText::_('AGREGAR_CAMPOS');  ?>" /> <br /> 
	<br /> 
	
	<label for="premiereStartDate"><?php echo JText::_('FECHA_LANZAMIENTO');  ?></label> 
	<input type="date"  class="validate[required,custom[date]]" name="premiereStartDate"> 
	<br> 
	
	<label for="premiereEndDate"><?php echo JText::_('FECHA_CIERRE');  ?></label> 
	<input type="date"  class="validate[required,custom[date]]" name="premiereEndDate">
	<br /> 
	<br/> 
	
	<input type="submit" value="<?php echo JText::_('ENVIAR');  ?>">
</form>
