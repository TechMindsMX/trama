<?php 
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$path = JConfig::$mw_path;
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
<h3>Crear un proyecto</h3>
<form action="<?php echo $path; ?>:7171/trama-middleware/rest/project/create" id="form2" enctype="multipart/form-data" method="POST">
	<label for="nomProy">Nombre del proyecto*:</label> 
	<input type="text" name="name" id="nomProy" class="validate[required,custom[onlyLetterNumber]]" maxlength="100"> 
	<br />
	 <br>
		<label for="categoria">Categor&iacute;a*:</label>
  			<select id="categoria" class="validate[required]">
              <option value=""></option>
              <option value="Teatro">Teatro</option>
              <option value="Danza">Danza</option>
              <option value="Musica">Música</option>
              <option value="Conciertos">Conciertos</option>
              <option value="Espectaculos">Espect&aacute;culos</option>
              <option value="Opera">&Oacute;pera</option>          
       		</select><br />
        <label for="subcategoria">Subcategor&iacute;a*:</label>
        	<select id="subcategoria" class="validate[required]">
              <option value=""></option>          
              <option value="Monologo" class="Teatro">Monólogo</option>
              <option value="Musical" class="Teatro">Musical</option>
              <option value="Cabaret" class="Teatro">Cabaret</option>
              <option value="Infantil" class="Teatro">Infantil</option>
              <option value="Comedia" class="Teatro">Comedia</option>
              <option value="Tragicomedia" class="Teatro">Tragicomedia</option>
              <option value="Contemporaneo" class="Teatro">Contempor&aacute;neo</option>
              <option value="Improvisacion" class="Teatro">Improvisaci&oacute;n</option>
              <option value="Drama" class="Teatro">Drama</option>
              <option value="Melodrama" class="Teatro">Melodrama</option>
              <option value="Farsa" class="Teatro">Farsa</option>
             
              
              <option value="Folklor" class="Danza">Folklor</option>
              <option value="Contemporaneo" class="Danza">Contempor&aacute;neo</option>
              <option value="Clasico" class="Danza">Cl&aacute;sico</option>
              <option value="Valet" class="Danza">Valet</option>
              <option value="Otros" class="Danza">Otros</option>
              
              
              <option value="Recitales" class="Musica">Recitales</option>
              <option value="Clasica" class="Musica">Cl&aacute;sica</option>
              <option value="Contemporanea" class="Musica">Contempor&aacute;nea</option>
              <option value="Otros" class="Musica">Otros</option>
              
              
              <option value="Popular" class="Conciertos">Popular</option>
              <option value="Rock" class="Conciertos">Rock</option>
              <option value="Pop" class="Conciertos">Pop</option>
              <option value="Jazz" class="Conciertos">Jazz</option>
              <option value="Otros" class="Conciertos">Otros</option>
              
              
              <option value="Coreograficos" class="Espectaculos">Coreogr&aacute;ficos</option>
              <option value="Populares" class="Espectaculos">Populares</option>
              <option value="Performance" class="Espectaculos">Performance</option>
              <option value="Escenicos" class="Espectaculos">Esc&eacute;nicos</option>
              <option value="Infantiles" class="Espectaculos">Infantiles</option>
              <option value="Otros" class="Espectaculos">Otros</option>
              
              <option value="Zarzuela" class="Opera">Zarzuela</option>
              <option value="Clasica" class="Opera">Cl&aacute;sica</option>
              <option value="Contemporanea" class="Opera">Contempor&aacute;nea</option>
              <option value="Opereta" class="Opera">Opereta</option>
        	</select>
            <br />
	<label for="banner">Imagen(Banner) del proyecto*:</label> <input
		type="file" id="banner" class="validate[required]" name="banner"> <br />
	<label for="avatar">Imagen(Avatar) del proyecto*:</label> <input
		type="file" id="avatar" class="validate[required]" name="avatar"> <br />
	<br /> Videos promocionales (solo links de youtube):<br /> <label
		for="linkYt1">Enlace Youtube 1:</label> <input type="text"
		id="linkYt1" class="validate[custom[yt]]" name="youtubeLink1"> <br />
	<label for="linkYt2">Enlace Youtube 2:</label> <input type="text"
		id="linkYt2" class="validate[custom[yt]]" name="youtubeLink2"> <br />
	<label for="linkYt3">Enlace Youtube 3:</label> <input type="text"
		id="linkYt3" class="validate[custom[yt]]" name="youtubeLink3"> <br />
	<label for="linkYt4">Enlace Youtube 4:</label> <input type="text"
		id="linkYt4" class="validate[custom[yt]]" name="youtubeLink4"> <br />
	<label for="linkYt5">Enlace Youtube 5:</label> <input type="text"
		id="linkYt5" class="validate[custom[yt]]" name="youtubeLink5"> <br />
	<br /> Audios promocionales (solo links de soundcloud): <br /> <label
		for="linkSc1">Enlace Soundcloud 1:</label> <input type="text"
		id="linkSc1" class="validate[custom[sc]]" name="soundCloudLink1"> <br />
	<label for="linkSc">Enlace Soundcloud 2:</label> <input type="text"
		id="linkSc2" class="validate[custom[sc]]" name="soundCloudLink2"> <br />
	<label for="linkSc3">Enlace Soundcloud 3:</label> <input type="text"
		id="linkSc3" class="validate[custom[sc]]" name="soundCloudLink3"> <br />
	<label for="linkSc4">Enlace Soundcloud 4:</label> <input type="text"
		id="linkSc4" class="validate[custom[sc]]" name="soundCloudLink4"> <br />
	<label for="linkSc5">Enlace Soundcloud 5:</label> <input type="text"
		id="linkSc5" class="validate[custom[sc]]" name="soundCloudLink5"> <br />
	<label for="fotos">Fotos m&aacute;ximo 10 m&iacute;nimo una*:</label> <input
		class="multi validate[required]" id="fotos" accept="gif|jpg|x-png"
		type="file" maxlength="10" name="photo"> <br /> <label for="descProy">Descripci&oacute;n
		del proyecto*:</label> <br />
	<textarea name="description" id="descProy" class="validate[required]" cols="60" rows="5"></textarea>
	<br /> 
	<label for="elenco">Elenco:</label> <br />
	<textarea name="cast" id="elenco" cols="60" rows="5"></textarea>
	<br /> <label for="direccion">Direcci&oacute;n del recinto*: </label> <input
		type="text" class="validate[required]" id="direccion"
		name="showground" maxlength="100"> <br> <label for="plantilla">Cargar
		la plantilla de Excel con el Business Case*:</label> <input
		type="file" class="validate[required]" id="plantilla"
		name="businessCase"> <br /> <label for="presupuesto">Presupuesto del
		proyecto*:</label> <input type="number" class="validate[required]"
		id="presupuesto" name="budget"> <br /> <br /> Precios de salida del
	proyecto*: <br /> <br /> <label for="seccion">Secci&oacute;n*:</label>
	<input type="text" id="seccion"
		class="validate[required,custom[onlyLetterNumber]]" name="section"> <br />
	<label for="unidad">Precio unidad*:</label> <input type="number"
		id="unidad" class="validate[required,custom[onlyNumberSp]]"
		name="unitSale" step="any"> <br> <label for="inventario">Inventario(Cantidad)*:</label>
	<input type="number" id="inventario"
		class="validate[required,custom[onlyNumberSp]]" name="capacity"> <br />
	<br /> <span id="writeroot"></span> <input type="button"
		onclick="moreFields()" value="Agregar campos" /> <br /> <br /> <label
		for="potenicales">Ingresos potenciales del proyecto*:</label> <input
		type="number" id="potenciales"
		class="validate[required,custom[onlyNumberSp]]"
		name="revenuePotential" step="any"> <br> <label for="equilibrio">Punto
		de equilibrio*:</label> <input type="number" id="equilibrio"
		class="validate[required,custom[onlyNumberSp]]" name="breakeven"
		step="any"> <br> <label for="productionStartDate">Fecha inicio
		producci&oacute;n*:</label> <input type="date"
		id="productionStartDate" class="validate[required]"
		name="productionStartDate"> <br> <label for="productionEndDate">Fecha
		fin de producci&oacute;n*:</label> <input type="date"
		id="productionEndDate" class="validate[required]"
		name="productionEndDate"> <br> <label for="premiereStartDate">Fecha
		inicio presentaci&oacute;n*:</label> <input type="date"
		id="premiereStartDate" class="validate[required]"
		name="premiereStartDate"> <br> <label for="premiereEndDate">Fecha fin
		de presentaci&oacute;n*:</label> <input type="date"
		id="premiereEndDate" class="validate[required]" name="premiereEndDate">
	<br> <br> <input type="submit" value="Enviar">
</form>
