<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	
	$usuario = JFactory::getUser();
	
	$base = JUri::base();
	$pathJumi = Juri::base().'components/com_jumi/files/ver_proyecto/';
	$proyecto = $_GET['proyid'];
	
	//$document->addScript($pathJumi.'js/jquery.nivo.slider.js');
	$document->addStyleSheet($pathJumi.'css/themes/bar/bar.css');
	$document->addStyleSheet($pathJumi.'css/nivo-slider.css');
	$document->addStyleSheet($pathJumi.'css/style.css');
?>

<script type="text/javascript" src="components/com_jumi/files/ver_proyecto/js/jquery.nivo.slider.js"></script>
<?php
	$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$proyecto;
	$homepage = file_get_contents($url);
	$json = json_decode($homepage);
	
	$urlSubcategoria = MIDDLE.PUERTO.'/trama-middleware/rest/category/subcategories/all';
	$jsonSubcategoria = file_get_contents($urlSubcategoria);
	$jsonObjSubcategoria = json_decode($jsonSubcategoria);
	
	foreach($jsonObjSubcategoria as $key=>$value) {
		if($value->id == $json->subcategory) {
			$nombreSubcategoria = $value->name;
		}
	}
	
	$db = JFactory::getDbo();
	
	$query = $db->getQuery(true);
	
	$query
	->select(array('a.nomNombre','a.nomApellidoPaterno'))
	->from('perfil_persona AS a')
	->join('INNER', 'perfil_persona_contacto AS b ON (a.id = b.perfil_persona_idpersona)')
	->where('a.users_id = '.$json->userId.' && b.perfil_tipoContacto_idtipoContacto = 1');
	
	$db->setQuery($query);
	$results = $db->loadObjectList();

$tipo = prefijoTipo($json);

function prefijoTipo($data) {
	switch ($data->type) {
		case 'PROJECT':
			$prefix ='PROY_';
			break;
		default:
			$prefix ='PROD_';
			break;
	}
	return $prefix;
}

function buttons($data, $user) {
	if ( $user->id == strval($data->userId) ) {
		$link = 'index.php?option=com_jumi&view=appliction&fileid=9';
		$proyid = '&proyid='.$data->id;
		$html = '<a href="'.$link.$proyid.'">'.JText::_('Edit').'</a>';

		return $html;
	}
}

function videos($obj, $param) {
	$html = '';
	switch ($param) {
	case 1:
		$array = $obj->projectYoutubes;
		foreach ($array as $key => $value ) {
			switch ($value->url) {
				case strstr($value->url, 'youtube'):
					$tipoVideo = 'you';
					break;
				case strstr($value->url, 'vimeo'):
					$tipoVideo = 'vimeo';
					break;
			}
			echo "TIPO ".$tipoVideo;
		
			$idVideo[] = end(explode("=", $value->url));
		}
		$html .= '<iframe class="video-player" width="853" height="480" ';
		$html .= 'src="//www.youtube.com/embed/'.$idVideo[0].'?rel=0" frameborder="0" allowfullscreen></iframe>';
	break;
	default:
		$arrayVideos = $obj->projectYoutubes;
		foreach ($arrayVideos as $key => $value ) {
			$idVideo = end(explode("=", $value->url));
			$html .= '<div class="item-video">';
			$html .= '<input class="liga" type="button"';
			$html .= 'value="//www.youtube.com/embed/'.$idVideo.'?rel=0"';
			$html .= 'style="background: url(\'http://img.youtube.com/vi/'.$idVideo.'/0.jpg\')';
			$html .= ' no-repeat; background-size: 100%;">';
			$html .= '</div>';
		}
	break;
	}
	return $html;
}

function imagenes($data) {
	$html = '';
	$array = $data->projectPhotos;
	foreach ( $array as $key => $value ) {
		$imagen = "/".$value->name;
		$html .= '<img width="100" height="100" src="'.MIDDLE.PHOTO.$imagen.'" alt="" />';	
	}
	return $html;
}

function audios($data) {

	$html = '';
	$array = $data->projectSoundclouds;
	foreach ( $array as $key => $value ) {
		$val = "/".$value->url;
	}
	return $html;
}

function avatar($data) {
	$avatar = $data->projectAvatar->name;
	$html = '<img class="avatar" src="'.MIDDLE.AVATAR.'/'.$avatar.'" />';
	
	return $html;
}

function finanzas ($data) {
	$html = '<div id="finanzas_general">'.
			'<p><span>'.JText::_('BUDGET').'</span>'.$data->budget.'</p>'.
			'<p><span>'.JText::_('BREAKEVEN').'</span>'.$data->breakeven.'</p>'.
			'<p><span>'.JText::_('REVE_POTENTIAL').'</span>'.$data->revenuePotential.'</p>'.
			'</div>';

	return $html;
}

function tablaFinanzas($data) {
	$html = '<table id="tabla_finanzas">'.
			'<tr><th>'.
			JText::_('SECCION').'</th><th>'.
			JText::_('PRECIO').'</th><th>'.
			JText::_('CANTIDAD').'</th></tr>';
	$opentag = '<td>';
	$closetag = '</td>';
	foreach ($data->projectUnitSales as $key => $value) {
		$html .= '<tr class="row">';
		$html .= $opentag.$value->section.$closetag;
		$html .= $opentag.$value->unitSale.$closetag;
		$html .= $opentag.$value->capacity.$closetag;
		$html .= '</tr>';
	}
	$html .= '</table>';
	
	return $html;
}

function descripcion ($data) {
	$html = '';
	
	$html = '<p id="descripcion" class="texto">'.
			$data->description.
			'</p>';
	
	return $html;
}

function irGrupo($data) {
	$html = '<a class="button" >'.JText::_('IR_GRUPO').'</a>';
	
	return $html;
}

function informacionTmpl($data) {
 	require_once 'solicitud_participar.php';
	$html = '<div id="izquierdaDesc" class="gantry-width-33 gantry-width-block">'.
			'<div class="gantry-width-spacer">'.
			avatar($data).
			'<div class="gantry-width-spacer flotado">'.
	  		participar().
			'</div>'.
			'<div class="gantry-width-spacer flotado">'.
			irGrupo($data).
			'</div>'.
			'</div>'.
			'</div>'.
			'<div id="derechaDesc" class="gantry-width-66 gantry-width-block">'.
			'<div class="gantry-width-spacer">'.
			$data->description.
			'</div>'.
			'</div>'.
			'</div>';
	
	return $html;
}

function fechas($data, $tipo) {
	$html = '<div id="fechas)">';
	if (isset($data->fundStartDate)) {
			$html .= '<p><span>'.JText::_('FUND_START').'</span>'.$data->fundStartDate.'</p>';
	}
	if (isset($data->fundStartDate)) {
			$html .= '<p><span>'.JText::_('FUND_END').'</span>'.$data->fundEndDate.'</p>';
	}
	$html .= '<p><span>'.JText::_($tipo.'PRODUCTION_START').'</span>'.$data->productionStartDate.'</p>'.
			'<p><span>'.JText::_($tipo.'PREMIERE_START').'</span>'.$data->premiereStartDate.'</p>'.
			'<p><span>'.JText::_($tipo.'PREMIERE_END').'</span>'.$data->premiereEndDate.'</p>'.
			'</div>';

	return $html;
}

?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".ver_proyecto").hide();
		jQuery("#banner").show();

		jQuery(".menu-item").click(function(){
			var clase = jQuery(this).attr("id");
			jQuery(".ver_proyecto").hide();
			jQuery(".menu-item").removeClass("active");
			jQuery("#content #"+clase).show("slow");
			jQuery(this).addClass("active");
		});

		jQuery(".cerrar").click(function(){
			jQuery(".ver_proyecto").hide();
			jQuery("#banner").show("slow");
			jQuery(".menu-item").removeClass("active");
		});	

		jQuery(".liga").click(function(){
			var liga = jQuery(this).val();
			jQuery(".video-player").attr("src",liga);
		});
		
	});
	</script>
	<div id="wrapper">
		<div id="content">
			<?php if($usuario->id == $json->userId) {
				echo buttons($json, $usuario); 	
			} ?>
			<div id="banner" class="ver_proyecto">
				<div class="content-banner">
					<img src="<?php echo MIDDLE.BANNER.'/'.$json->projectBanner->name ?>" />
					<div class="info-banner">
						<h2><?php echo $json->name;?></h2>
						<h4><?php echo $results[0]->nomNombre." ".$results[0]->nomApellidoPaterno;?></h4>
						<p><?php echo $nombreSubcategoria;?></p>
					</div>
				</div>
			</div>
			<div id="video" class="ver_proyecto">
				<div id="content_player">
					<div id="video-player">
						<div id="menu-player">
							<?php echo videos($json, 0); ?>
						</div>
						<div id="reproductor">
							<?php echo videos($json, 1); ?>
						</div>
					</div>
				</div>
			<a class="cerrar">cerrar</a>
			</div>
			<div id="gallery" class="ver_proyecto">
			<div id="wrapper">
				<div class="slider-wrapper theme-bar">
            		<div id="slider" class="nivoSlider">
            			<?php echo imagenes($json); ?>
            		</div>
        		</div>
        	</div>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="audios" class="ver_proyecto">
				<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F63404056"></iframe>
				<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F63404056"></iframe>
				<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F63404056"></iframe>
				<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F63404056"></iframe>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="finanzas" class="ver_proyecto">
				<h3>Finanzas</h3>
				<?php echo finanzas($json); ?>
				<?php echo tablaFinanzas($json); ?>
				<?php echo fechas($json, $tipo); ?>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="info" class="ver_proyecto">
				<h3>Informacion</h3>
				<div class="detalleDescripcion">
					<?php echo informacionTmpl($json); ?>
				</div>
				<a class="cerrar">cerrar</a>
			</div>
		</div>
		<div id="menu">
			<div>
				<div class="menu-item video" id="video"></div>
				<div class="menu-item gallery" id="gallery"></div>
				<div class="menu-item audios" id="audios"></div>
				<div class="menu-item finanzas" id="finanzas"></div>
				<div class="menu-item info" id="info"></div>			
			</div>
		</div>
	</div>
	<script type="text/javascript">
	    $(window).load(function() {
        $('#slider').nivoSlider();
	    });
    </script>

<?php 
 var_dump($json);
 ?>
