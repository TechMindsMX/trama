<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	
	$usuario = JFactory::getUser();
	
	jimport('trama.class');
	
	$base = JUri::base();
	$pathJumi = Juri::base().'components/com_jumi/files/ver_proyecto/';
	$proyecto = $_GET['proyid'];
	
	//$document->addScript($pathJumi.'js/jquery.nivo.slider.js');
	$document->addStyleSheet($pathJumi.'css/themes/bar/bar.css');
	$document->addStyleSheet($pathJumi.'css/nivo-slider.css');
	$document->addStyleSheet($pathJumi.'css/style.css');
	//$document->addScript('components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js');
?> 

<script type="text/javascript" src="components/com_jumi/files/ver_proyecto/js/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js"></script>
<?php
	$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$proyecto;
	$json = json_decode(file_get_contents($url));


$json->etiquetaTipo = tipoProyProd($json);
	

function tipoProyProd($data) {
	$tipo = $data->type;
	switch ($tipo) {
		case 'PRODUCT':
			$tipoEtiqueta = JText::_('PRODUCT');
			break;
		
		default:
			$tipoEtiqueta = JText::_('PROJECT');
			break;
	}
	return $tipoEtiqueta;
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

function rating($data) {
		
	if($data->rating == 'NaN') {
		$rating = 0;
	} else {
		$rating = $data->rating;
	}
	
	$html = '<div id="rating" style="float:left; margin-top:15px;"></div>'.
			'<div id="texto"style="float: left; font-size: 70px; position: relative; text-align: center; width: 30%; top: 30px;">'.
			number_format($rating, 1).
			'</div>';
	
	return $html;
}

function encabezado($data) {
	$html = '<h2>'.$data->name.'</h2>'.
		'<h4>'.JTrama::getSubCatName($data->subcategory).'</h4>'.
		'<span class="tipo_proy_prod"> - '.JTrama::getStatusName($data->status).'</span>'.
		'<span class="tipo_proy_prod">'.$data->etiquetaTipo.'</span>'.
		'<p>'.JTrama::getProducerName($data->userId).'</p>';
	
	return $html;
}

function informacionTmpl($data, $params) {
 	require_once 'solicitud_participar.php';
	switch ($params) {
		case 'finanzas':
			$izquierda = avatar($data).
				'<div class="gantry-width-spacer flotado">'.
		  		participar($data).
				'</div>'.
				'<div class="gantry-width-spacer flotado">'.
				irGrupo($data).
				'</div>';
			$derecha = finanzas($data).
						tablaFinanzas($data).
						fechas($data);
			break;
		
		default:
			$izquierda = avatar($data).
				'<div class="gantry-width-spacer flotado">'.
		  		participar($data).
				'</div>'.
				'<div class="gantry-width-spacer flotado">'.
				irGrupo($data).
				'</div>'.
				'<div class="granty-width-spacer flotando">'.
				rating($data).
				'</div>';
			$derecha = $data->description.
				'<br /><h3>Elenco</h3><p>'.$data->cast.'</p>';
			
			break;
	}


	$html = '<div id="izquierdaDesc" class="gantry-width-33 gantry-width-block">'.
			'<div class="gantry-width-spacer">'.
			$izquierda.
			'</div>'.
			'</div>'.
			'<div id="derechaDesc" class="gantry-width-66 gantry-width-block">'.
			'<div class="gantry-width-spacer">'.
			encabezado($data).
			'</div>'.
			'<div id="contenido-detalle">'.
			$derecha.
			'</div>'.
			'</div>';
	
	return $html;
}

function fechas($data) {
	$html = '<div id="fechas)">';
	if ($data->type == 'PROJECT') {
			$html .= '<p><span>'.JText::_($data->type.'_FUND_START').'</span>'.$data->fundStartDate.'</p>'.
					'<p><span>'.JText::_($data->type.'_FUND_END').'</span>'.$data->fundEndDate.'</p>'.
					'<p><span>'.JText::_($data->type.'_PRODUCTION_START').'</span>'.$data->productionStartDate.'</p>';
	}
	$html .= '<p><span>'.JText::_($data->type.'_PREMIERE_START').'</span>'.$data->premiereStartDate.'</p>'.
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
				<div class="info-banner">
					<div class="rt-inner">
						<?php echo encabezado($json); ?>
					</div>
				</div>
				<div class="content-banner">
					<img src="<?php echo MIDDLE.BANNER.'/'.$json->projectBanner->name ?>" />
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
				<?php echo informacionTmpl($json, "finanzas"); ?>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="info" class="ver_proyecto">
				<h3>Informacion</h3>
				<div class="detalleDescripcion">
					<?php echo informacionTmpl($json, null); ?>
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
	 var count = 0;
	 
	 if(isNaN(<?php echo $json->rating; ?>)){
	 	var rating = 0;
	 } else {
	 	var rating = parseFloat(<?php echo $json->rating; ?>);
	 }
	 
		$(document).ready(function() {
			var ruta = "components/com_jumi/files/crear_proyecto/js/raty/img/"
			$('#rating').raty({
				click: function(score, evt) {
					var request = $.ajax({
						url:"http://192.168.0.122:7070/trama-middleware/rest/project/rate",
						data: {
							"score": score,
							"projectId": "<?php echo $_GET['proyid']; ?>",
							"userId": <?php echo $usuario->id; ?>
						},
						type: 'post'
					});
					
					request.done(function(result){
						var obj = eval('(' + result + ')');
												
						if (obj.resultType == 'SUCCESS') {
							jQuery('#rating').raty({
								readOnly: true,
								path 	: ruta,
								score 	: score,
								target		: '#texto',
								targetText	: obj.rate
							});
						} else if(obj.resultType == 'FAIL') {
							jQuery('#rating').raty({
								readOnly: true,
								path 	: ruta,
								score 	: obj.rate,
								target		: '#texto',
								targetText	: obj.rate
							});
						}
					});
					
					request.fail(function (jqXHR, textStatus) {
						console.log('Surguieron problemas al almacenar tu calificación');
					});
				},
				score		: rating,
				path		: ruta,
				//target		: '#texto',
				//targetText	: 'Puntuar'
			});
		});
		
	    $(window).load(function() {
        	$('#slider').nivoSlider();
		});
    </script>

<?php 
// var_dump($json);
 ?>
