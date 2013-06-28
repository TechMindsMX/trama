<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	$base = JUri::base();
	$pathJumi = Juri::base().'components/com_jumi/files/ver_proyecto/';
	//$document->addScript($pathJumi.'js/jquery.nivo.slider.js');
	$document->addStyleSheet($pathJumi.'css/themes/bar/bar.css');
	$document->addStyleSheet($pathJumi.'css/nivo-slider.css');
	$document->addStyleSheet($pathJumi.'css/style.css');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $json->name; ?></title>

<script type="text/javascript" src="http://192.168.0.107/trama/trama/trama/components/com_jumi/files/ver_proyecto/js/jquery.nivo.slider.js"></script>

<?php
	$url = "http://192.168.0.105:7171/trama-middleware/rest/project/get/1";
	$homepage = file_get_contents($url);
	$json = json_decode($homepage);
	var_dump($json);
	
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
	
	var_dump($results);
	var_dump($jsonObjSubcategoria);
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
</head>
<body>
	<div id="wrapper">
		<div id="content">
			<div id="banner" class="ver_proyecto">
				<div class="content-banner">
					<img src="components/com_jumi/files/ver_proyecto/images/banner.jpg" />
					<div class="info-banner">
						<h2><?php echo $json->name;?></h1>
						<h4><?php echo $results[0]->nomNombre." ".$results[0]->nomApellidoPaterno;?></h4>
						<p><?php echo $nombreSubcategoria;?></p>
					</div>
				</div>
			</div>
			<div id="video" class="ver_proyecto">
				<div id="content_player">
					<div id="video-player">
						<div id="menu-player">
							<div class="item-video"><input class="liga" type="button" value="//www.youtube.com/embed/UWb5Qc-fBvk?rel=0" style="background: url('http://img.youtube.com/vi/UWb5Qc-fBvk/0.jpg') no-repeat; background-size: 100%;"></div>
							<div class="item-video"><input class="liga" type="button" value="//www.youtube.com/embed/M7CdTAiaLes?rel=0" style="background: url('http://img.youtube.com/vi/M7CdTAiaLes/0.jpg') no-repeat; background-size: 100%;"></div>
							<div class="item-video"><input class="liga" type="button" value="//www.youtube.com/embed/3TlJWoM69ww?rel=0" style="background: url('http://img.youtube.com/vi/3TlJWoM69ww/0.jpg') no-repeat; background-size: 100%;"></div>
							<div class="item-video"><input class="liga" type="button" value="//www.youtube.com/embed/xkZjeACMbDI?rel=0" style="background: url('http://img.youtube.com/vi/xkZjeACMbDI/0.jpg') no-repeat; background-size: 100%;"></div>
							<div class="item-video"><input class="liga" type="button" value="http://player.vimeo.com/video/28457662" style="background: url('http://ts.vimeo.com.s3.amazonaws.com/235/662/23566238_100.jpg') no-repeat; background-size: 100%;"></div>
						</div>
						<div id="reproductor">
							<iframe class="video-player" width="853" height="480" src="//www.youtube.com/embed/UWb5Qc-fBvk?rel=0" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			<a class="cerrar">cerrar</a>
			</div>
			<div id="gallery" class="ver_proyecto">
			<div id="wrapper">
				<div class="slider-wrapper theme-bar">
            		<div id="slider" class="nivoSlider">
               	 		<img width="100" height="100" src="images/slide/toystory.jpg" alt="" />
                		<img width="100" height="100" src="images/slide/walle.jpg" alt="" data-transition="slideInLeft" />
                		<img width="100" height="100" src="images/slide/nemo.jpg" alt="" title="#htmlcaption" />
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
				<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F63404056"></iframe>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="finanzas" class="ver_proyecto">
				<div>
					Finanazas
				</div>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="info" class="ver_proyecto">
				Informacion
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
</body>
</html>
