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

//$homepage = '{"id":1,"name":"Slava snow show","showground":"Av. Chapultepec y Av. CuauhtÃ©moc, Del. CuauhtÃ©moc,  MÃ©xico,  DF  06700","inclosure":"Centro Cultural Telmex","breakeven":100000,"budget":200000,"revenuePotential":500000,"description":"Desde su primera apariciÃ³n en MÃ©xico en 2006, este show ha cautivado a propios y extraÃ±os, ya que con mÃ­mica y trucos bÃ¡sicos generan admiraciÃ³n en todo el pÃºblico. Los payasos consiguen que los asistentes disfruten de un mÃ¡gico mundo alejado de los problemas, en medio de la frÃ­a nieve. \r\nLa compaÃ±Ã­a fundada por el ruso Slava Polunin y que tiene entre sus filas a los mejores payasos del mundo se renueva para esta temporada y ofrecerÃ¡ el mejor espectÃ¡culo, siempre lleno de sorpresas para propios y extraÃ±os.\r\n\r\nEl Centro Cultural Telmex 2 recibirÃ¡ en esta ocasiÃ³n a los payasos que trasladan al pÃºblico de un estado de Ã¡nimo a otro, haciendo alusiÃ³n a los caprichos del clima. \r\n\r\nA decir de su fundador, Slavaâ€™s tiene tantas descripciones como hay miembros de la audiencia. â€œSnowshow es la belleza de un solo copo de nieve que cae suavemente y cae en su hombro. Snowshow es el sonido de una risa incontrolable en adultos no hay nada en particular. Snowshow es la alegrÃ­a de creer que todo es posible, Snowshow es la tristeza de un adiÃ³s de una plataforma de la estaciÃ³n de tren. Snowshow es la constataciÃ³n de que la vida es realmente maravillosaâ€.\r\nGanador del â€œOliver Awardâ€ como El Mejor show en Londres, el espectÃ¡culo de Slava ha causado furor mundialmente y una vez mÃ¡s lo harÃ¡ en MÃ©xico a partir del 22 de mayo en el Centro Cultural Telmex 2. ","cast":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eu ante aliquam, posuere massa at, pulvinar lectus. Cras condimentum ornare sapien, quis mattis odio tincidunt at. Cras faucibus ipsum in adipiscing tincidunt. Vivamus auctor, augue eu interdum blandit, massa nunc ultrices purus, vitae rhoncus nibh diam eget ligula. Suspendisse scelerisque nulla sodales euismod sodales. Fusce id augue nec nisi malesuada tempus. Duis imperdiet metus sed sapien mollis, nec commodo massa faucibus. In enim libero, rutrum a commodo eu, aliquam a felis. Aenean eget urna ac lorem porttitor luctus. Maecenas pharetra nibh ac nunc pulvinar, quis cursus elit egestas.","fundStartDate":null,"fundEndDate":null,"productionStartDate":"2013-07-04","premiereStartDate":"2013-08-04","premiereEndDate":"2013-09-06","timeCreated":1372973266545,"subcategory":15,"status":0,"type":"PROJECT","userId":379,"projectBanner":{"projectBannerId":1,"name":"1372973267118_0.png"},"projectAvatar":{"projectAvatarId":1,"name":"1372973267856_0.png"},"projectBusinessCase":{"projectBusinessCaseId":1,"name":"1372973268132"},"projectUnitSales":[{"id":1,"section":"1A","unitSale":500,"capacity":3,"projectId":1}],"projectYoutubes":[{"id":5,"url":"https://vimeo.com/13850491","projectId":1},{"id":4,"url":"https://vimeo.com/13850491","projectId":1},{"id":3,"url":"http://www.youtube.com/watch?v=sL_7d1UFZ6s","projectId":1},{"id":2,"url":"http://www.youtube.com/watch?v=d9bfiNBtxcA","projectId":1},{"id":1,"url":"http://www.youtube.com/watch?v=fpUY7e-k4Jo","projectId":1}],"projectSoundclouds":[{"id":5,"url":"","projectId":1},{"id":4,"url":"","projectId":1},{"id":3,"url":"","projectId":1},{"id":2,"url":"","projectId":1},{"id":1,"url":"","projectId":1}],"projectPhotos":[{"id":1,"name":"1372973269979_0.png","projectId":1},{"id":2,"name":"1372973275368_5.png","projectId":1},{"id":3,"name":"1372973273644_2.png","projectId":1},{"id":4,"name":"1372973275593_6.png","projectId":1},{"id":5,"name":"1372973275981_7.png","projectId":1},{"id":6,"name":"1372973272232_1.png","projectId":1},{"id":7,"name":"1372973275167_4.png","projectId":1},{"id":8,"name":"1372973275062_3.png","projectId":1}]}';
	$json = json_decode($homepage);

	$producer = JFactory::getUser($json->userId);

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	
	$query
	->select(array('a.nomNombre','a.nomApellidoPaterno'))
	->from('perfil_persona AS a')
	->join('INNER', 'perfil_persona_contacto AS b ON (a.id = b.perfil_persona_idpersona)')
	->where('a.users_id = '.$json->userId.' && b.perfil_tipoContacto_idtipoContacto = 1');
	
	$db->setQuery($query);
	$results = $db->loadObjectList();
	
function getProySubCatName($data) {
    $urlSubcategoria = MIDDLE.PUERTO.'/trama-middleware/rest/category/subcategories/all';
	$subcats = json_decode(file_get_contents($urlSubcategoria));
	foreach ($subcats as $key => $value) {
		if($value->id == $data->subcategory) {
			$nomCat= $value->name;
		}
	}
	return $nomCat;
}

function buttons($data, $user) {
	if ( $user->id == strval($data->userId) ) {
		$link = 'index.php?option=com_jumi&view=appliction&fileid=9';
		$proyid = '&proyid='.$data->id;
		$html = '<div id="buttons">'.
				'<div><a href="'.$link.$proyid.'">'.JText::_('EDIT').'</a></div>';
		return $html;
	}
}

function videos($obj, $param) {
	$html = '';

	$array = $obj->projectYoutubes;
	foreach ($array as $key => $value ) {
		if (strstr($value->url, 'youtube')) {
			$arrayLimpio[] = array('youtube' => end(explode("=", $value->url)));
		}
		if (strstr($value->url, 'youtu.be')) {
			$urlcorta = end(explode(".be/", $value->url));
			$urlcorta = explode("?", $urlcorta);
			$arrayLimpio[] = array('youtube' => $urlcorta[0]);
		}
		elseif (strstr($value->url, 'vimeo')) {
			$arrayLimpio[] = array('vimeo' => end(explode("://vimeo.com/", $value->url)));
		}
	}

	switch ($param) {
	case 1:
		$video1 = $arrayLimpio[0];
		if (key($video1) == 'youtube') {
			$html .= '<iframe class="video-player" width="100%" '.
					'src="//www.youtube.com/embed/'.$video1['youtube'].
					'?rel=0" frameborder="0" allowfullscreen></iframe>';
		}
		elseif (key($video1) == 'vimeo') {
			$html .= '<iframe class="video-player" width="100%" '.
				'src="http://player.vimeo.com/video/'.$video1['vimeo'].'?autoplay=0" '.
				'frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		}
	break;
	default:
		foreach ( $arrayLimpio as $llave => $valor ) {
			foreach ($valor as $key => $value) {
				if ($key == 'youtube') {
					$html .= '<div class="item-video"><input class="liga" type="button"'.
						'value="//www.youtube.com/embed/'.$value.'?rel=0&autoplay=1"'.
						'style="background: url(\'http://img.youtube.com/vi/'.$value.'/0.jpg\')'.
						' no-repeat; background-size: 100%;" /></div>';
				}
				elseif ($key == 'vimeo') {
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$value.php"));
					$thumbVimeo = $hash[0]['thumbnail_medium']; 
					
					$html .= '<div class="item-video"><input class="liga" type="button"'.
						'value="//player.vimeo.com/video/'.$value.'?autoplay=1"'.
						'style="background: url('.$thumbVimeo.')'.
						' no-repeat; background-size: 100%;" /></div>';
				}
			}
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

function encabezado($data, $results) {
	$html = '<h2>'.$data->name.'</h2>'.
		'<h4>'.getProySubCatName($data).'</h4>'.
		'<p>'.$results[0]->nomNombre.' '.$results[0]->nomApellidoPaterno.'</p>';
	
	return $html;
}

function informacionTmpl($data, $results) {
 	require_once 'solicitud_participar.php';
	$html = '<div id="izquierdaDesc" class="gantry-width-33 gantry-width-block">'.
			'<div class="gantry-width-spacer">'.
			avatar($data).
			'<div class="gantry-width-spacer flotado">'.
	  		participar($data).
			'</div>'.
			'<div class="gantry-width-spacer flotado">'.
			irGrupo($data).
			'</div>'.
			'</div>'.
			'</div>'.
			'<div id="derechaDesc" class="gantry-width-66 gantry-width-block">'.
			'<div class="gantry-width-spacer">'.
			encabezado($data, $results).
			$data->description.
			'<br /><h3>Elenco</h3><p>'.$data->cast.'</p>'.
			'</div>'.
			'</div>'.
			'</div>';
	
	return $html;
}

function fechas($data) {
	$html = '<div id="fechas)">';
	if (isset($data->fundStartDate)) {
			$html .= '<p><span>'.JText::_('FUND_START').'</span>'.$data->fundStartDate.'</p>';
	}
	if (isset($data->fundStartDate)) {
			$html .= '<p><span>'.JText::_('FUND_END').'</span>'.$data->fundEndDate.'</p>';
	}
	$html .= '<p><span>'.JText::_($data->type.'_PRODUCTION_START').'</span>'.$data->productionStartDate.'</p>'.
			'<p><span>'.JText::_($data->type.'_PREMIERE_START').'</span>'.$data->premiereStartDate.'</p>'.
			'<p><span>'.JText::_($data->type.'_PREMIERE_END').'</span>'.$data->premiereEndDate.'</p>'.
			'</div>';

	return $html;
}

?>
	<script type="text/javascript">
	function scrollwrapper(){
		jQuery(window).scrollTop(jQuery('div#wrapper').offset().top);
	}

	jQuery(document).ready(function(){
		scrollwrapper();
		jQuery(".ver_proyecto").hide();
		jQuery("#banner").show();

		jQuery(".menu-item").hover(
			function(){
				jQuery(this).addClass("over");
			},
			function(){
				jQuery(this).removeClass("over");
			}
		);
		jQuery(".menu-item").click(function(){
			jQuery(".menu-item").removeClass("active");
			var clase = jQuery(this).attr("id");
			jQuery(".ver_proyecto").hide('slow');
			jQuery("#"+clase).show("slow", function() {
				scrollwrapper();
			});
			jQuery(this).addClass("active");
		});

		jQuery(".cerrar").click(function(){
			jQuery(".menu-item").removeClass("active");
			jQuery(".ver_proyecto").hide();
			jQuery("#banner").show("slow", function() {
				scrollwrapper();
			});
		});	

		jQuery(".liga").click(function(){
			var liga = jQuery(this).val();
			jQuery(".video-player").attr("src",liga);
		});
		
	});
	</script>
	<div id="wrapper">
		<div id="content">
			<?php echo buttons($json, $usuario); ?>
		</div>
			<div id="banner" class="ver_proyecto">
				<div class="content-banner">
					<img src="<?php echo MIDDLE.BANNER.'/'.$json->projectBanner->name ?>" />
					<div class="info-banner">
						<?php echo encabezado($json, $results); ?>
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
				<?php echo encabezado($json, $results); ?>
				<?php echo finanzas($json); ?>
				<?php echo tablaFinanzas($json); ?>
				<?php echo fechas($json); ?>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="info" class="ver_proyecto">
				<h3>Informacion</h3>
				<div class="detalleDescripcion">
					<?php echo informacionTmpl($json, $results); ?>
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
			<div style="clear: both;"></div>
		</div>
	</div>
	<script type="text/javascript">
	    $(window).load(function() {
        $('#slider').nivoSlider();
	    });
    </script>

<?php 
// var_dump($json);
 ?>
