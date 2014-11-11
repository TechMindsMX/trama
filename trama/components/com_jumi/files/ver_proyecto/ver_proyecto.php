<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$usuario =& JFactory::getUser();

$app = JFactory::getApplication();
if ($usuario->guest == 1) {
    $return = JURI::getInstance()->toString();
    $url    = 'index.php?option=com_users&view=login';
    $url   .= '&return='.base64_encode($return);
    $app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
$jinput = $app->input;

jimport('trama.class');
jimport('trama.jsocial');
jimport('trama.jfactoryext');
jimport('trama.usuario_class');
jimport('trama.error_class');
JHTML::_('behavior.tooltip');


$usuario->idMiddleware = ( $usuario->id != 0 ) ? UserData::getUserMiddlewareId($usuario->id)->idMiddleware : null;
// chequeamos si el usuario es Special
$isSpecial = '';
$grupos = new JFactoryExtended;
foreach ($usuario->getAuthorisedViewLevels() as $key => $value) {
    $isSpecial = ($value == $grupos->getSpecialViewlevel()) ? 1 : 0;
}

$pathJumi 	= Juri::base().'components/com_jumi/files/ver_proyecto/';
$proyecto 	= $jinput->get('proyid', '', 'INT');
$errorCode	= $jinput->get("error",0,"int");
$from		= $jinput->get("from",0,"int");

errorClass::manejoError($errorCode, $from, $proyecto);


if($errorCode==0 && $from!=0){
    $app->enqueueMessage(JText::_('SAVED_SUCCESSFUL').'', 'message');
}

$document->addStyleSheet($pathJumi.'css/themes/bar/bar.css');
$document->addStyleSheet($pathJumi.'css/nivo-slider.css');
$document->addStyleSheet($pathJumi.'css/style.css');

$middlewareId = UserData::getUserMiddlewareId($usuario->id);
$token = JTrama::token();

?>

<script type="text/javascript" src="components/com_jumi/files/ver_proyecto/js/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="libraries/trama/js/raty/jquery.raty.js"></script>
<script type="text/javascript" src="libraries/trama/js/jquery.number.min.js"></script>

<?php
$json 				= JTrama::getDatos($proyecto);
$json->etiquetaTipo = tipoProyProd($json);
$json->acceso 		= JTramaSocial::checkUserGroup($proyecto, $usuario->id);
$json->userIdJoomla = UserData::getUserJoomlaId($json->userId);

checkShared($json, $usuario);

if($json->name) {
    $mydoc =& JFactory::getDocument();
    $mydoc->setTitle($json->name);
}

function tipoProyProd($data) {
    $tipo = $data->type;
    switch ($tipo) {
        case 'PRODUCT':
            $tipoEtiqueta = JText::_('PRODUCT');
            $data->editUrl = '29';
            break;
        case 'REPERTORY':
            $tipoEtiqueta = JText::_('REPERTORIO');
            $data->editUrl = '30';
            break;
        default:
            $tipoEtiqueta = JText::_('PROJECT');
            $data->editUrl = '27';
            break;
    }
    return $tipoEtiqueta;
}

function buttons($data, $user) {
    $share = checkShared($data, $user);

    if ( $user->id == strval(UserData::getUserJoomlaId($data->userId)) ) {
        $link = 'index.php?option=com_jumi&view=appliction&fileid='.$data->editUrl;
        $proyid = '&proyid='.$data->id;
        $html = '<div id="buttons">';
        if (($data->type != 'REPERTORY' && $data->status == 0) || ($data->type != 'REPERTORY' && $data->status == 2)) {
            $html.=	'<div class="arrecho" ><span class="editButton"><a href="'.$link.$proyid.'">'.JText::_('LBL_EDIT').'</a></span></div>';
        }
        $html.=	'<div class="arrecho" >'.$share.'</div>';

        if ($data->type != 'REPERTORY' || in_array($data->status, array(8, 11))) {
            $html.= '<div class="arrecho hide-phone" >'.JTramaSocial::inviteToGroup($data->id).'</div></div>';
        }
        $html .= '</div>';
    } else {
        $html = '<div id="buttons"><div class="arrecho">'.$share.'</div></div>';
    }
    return $html;
}

function checkShared($data, $user) {
    include_once(getcwd().'/configuration.php');

    $configuracion 	= new JConfig;
    $userId			= $user->id;
    $projectId		= $data->id;

    $bd = new mysqli($configuracion->host, $configuracion->user ,$configuracion->password, $configuracion->db);
    $queryShared = 'SELECT * FROM c3rn2_community_activities WHERE actor = '.$userId.' && proyId = '.$projectId;
    $resultShared = $bd->query($queryShared);

    if ($resultShared->num_rows == 0) {
        $label = JText::_('SHARE_PROJECT');
    } else {
        $label = JText::_('ALREDY_SHARE_PROJECT_LBL');
    }
    $share = '<span style="cursor: pointer;" class="shareButton">'.$label.'</span>';

    return $share;
}

function videos($obj, $param) {
    $html = '';

    $array = $obj->projectVideos;
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
                    '?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>';
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
        $imagen = "/".$value->url;
        $html .= '<img width="100" height="100" src="'.PHOTO.$imagen.'" alt="" />';
    }

    return $html;
}

function validaURLs($arreglo){
    // create a client object with your app credentials
    $client = new Services_Soundcloud(SOUNDCLOUD_CLIENT_ID, SOUNDCLOUD_CLIENT_SECRET);
    $client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));

    foreach ($arreglo as $key => $value) {
        if (!empty($value->url)) {
            $track_url = $value->url;

            try {
                $client->get('resolve', array('url' => $track_url));
                $value->error = false;
                $noerror[] = $value;
            }
            catch(Services_Soundcloud_Invalid_Http_Response_Code_Exception $e){
                $value->error = true;
                $errores[] = $value;
            }
            // render the html for the player widget
        }
    }
    $final = array_merge($errores,$noerror);


    return $final;
}
/**
 * @param $data
 * @return string
 */
function audios($data) {
    $hostname = parse_url(JURI::base(), PHP_URL_HOST);
    $localDomain = ( $hostname == 'localhost' || is_numeric(strpos($hostname, '192')) );

    $html = '';
    $array = $data;

    if (!empty($array) && $localDomain === false ) {

        require_once 'Services/Soundcloud.php';

        // create a client object with your app credentials
        $client = new Services_Soundcloud(SOUNDCLOUD_CLIENT_ID, SOUNDCLOUD_CLIENT_SECRET);
        $client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));

        $final = validaURls($array);

        foreach ($final as $key => $value) {
            if (!empty($value->url) && !$value->error) {
                // get a tracks embed data
                $track_url = $value->url;

                $embed_info = json_decode($client->get('resolve', array('url' => $track_url)));
                $html .= '<iframe width="100%" height="100" scrolling="no" frameborder="no" src="'.
                    'https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F'.$embed_info->id.'"></iframe>';
                // render the html for the player widget
            }elseif($value->error && !empty($value->url)){
                $html .= '<div class="errorSc error_'.$key.'">Error en la liga '.$value->url.'</div>';
            }
        }
    } else {
        $html = ($localDomain === false) ? JText::_('NO_HAY_AUDIOS') : JText::_('SOLO_EN_DOMINIO');
    }

    return $html;
}

function avatar($data) {
    $avatar = $data->avatar;
    $html = '<img class="avatar" src="'.AVATAR.'/'.$avatar.'" />';

    return $html;
}

function finanzas ($data) {
    $html = '';

    $html = '<ul id="finanzas_general">'.
        '<li><span>'.JText::_('BUDGET').'</span> $<span class="number">'.$data->budget.'</span></li>'.
        '<li><span>'.JText::_('BREAKEVEN').'</span> $<span class="number">'.$data->breakeven.'</span></li>'.
        '<li><span>'.JText::_('REVE_POTENTIAL').'</span> $<span class="number">'.$data->revenuePotential.'</span></li>'.
        '</ul>';
    return $html;
}

function tablaFinanzas($data) {
    $html = '<table class="table table-striped">'.
        '<tr><th>'.
        JText::_('LBL_SECCION').'</th><th>'.
        JText::_('PRECIO').'</th><th>'.
        JText::_('CANTIDAD').'</th></tr>';
    $opentag = '<td>';
    $closetag = '</td>';
    if (isset($data->projectUnitSales)) {
        foreach ($data->projectUnitSales as $key => $value) {
            $html .= '<tr>';
            $html .= $opentag.$value->section.$closetag;
            $html .= $opentag.'$<span class="number">'.$value->unitSale.'</span>'.$closetag;
            $html .= $opentag.$value->unit.$closetag;
            $html .= '</tr>';
        }
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
    if ($data->type != 'REPERTORY' || in_array($data->status, array(8, 11))) {
        $data->proyGroupUrl = JTramaSocial::getProyGroupUrl($data->id);
        $html = '<a href="'.$data->proyGroupUrl.'" alt="'.$data->name.'" class="button" >'.JText::_('IR_GRUPO').'</a>';

        return $html;
    }
}

function rating($data) {

    if($data->rating == 'NaN') {
        $rating = 0;
    } else {
        $rating = $data->rating;
    }

    $html = '<div id="rating"></div>'.
        '<div id="texto">'.
        number_format($rating, 1).
        '</div>';

    return $html;
}

function encabezado($data) {
    $fechacreacion	= $data->timeCreated/1000;
    $statusName 	= JTrama::getStatusName($data->status);
    $statusPrint	= $data->type === 'REPERTORY' ? '' :' - '.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName);

    $html = '<div class="encabezado">'.
        '<h1>'.$data->name.'</h2>'.
        '<h2 class="mayusc">'.JTrama::getSubCatName($data->subcategory).'</h3>'.
        '<p id="productor">'.JTrama::getProducerProfile($data->userIdJoomla).'</p>'.
        '<p class="fechacreacion"> Creado '.date('d-M-Y', $fechacreacion).'</p>'.
        '<h3 class="tipo_proy_prod mayusc">'.$data->etiquetaTipo.$statusPrint.'</h3>'.
        '</div>';

    return $html;
}

function informacionTmpl($data, $params) {
    $mapa= '<div id="map-wrapper"><div id="map-canvas" style="height: 100%; width:100%; margin-top:25px;"></div></div>
  	 <p style="max-width:300px;">'.$data->showground.'</p>';
    $botonContactar = JText::_('SOLICITA_PARTICIPAR');
    require_once 'solicitud_participar.php';

    if($data->type != 'REPERTORY'){
        $botonparticipar = '<div class="gantry-width-spacer flotado">'.
            participar($data->userIdJoomla,$botonContactar).
            '</div>';
    }else{
        $botonparticipar = '';
    }

    switch ($params) {
        case 'finanzas':
            $izquierda = avatar($data).
                '<div class="gantry-width-spacer flotado">'.
                participar($data->userIdJoomla,$botonContactar).
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

                $botonparticipar.

                '<div class="gantry-width-spacer flotado">'.
                irGrupo($data).
                '</div>'.

                '<div class="granty-width-spacer flotando">'.
                rating($data).

                '</div>'.
                '<div class="granty-width-spacer flotado">'.
                $mapa.
                '</div>';
            $derecha = '<h3 class="line-space">'.JText::_('PRO_DESCRIPTION').'</h3><p>'.$data->description.'</p><h3 class="line-space">'.JText::_('PRO_CAST').'</h3><p>'.$data->cast.'</p>';

            break;
    }


    $html = '<div id="izquierdaDesc" class="ancho-col gantry-width-block">'.
        '<div class="img_avatar">'.
        $izquierda.
        '</div>'.
        '</div>'.
        '<div id="derechaDesc" class="ancho-col gantry-width-block">'.
        '<div>'.
        encabezado($data).
        '</div>'.
        '<div id="contenido-detalle">'.
        '<div id="inside-detalle">'.
        $derecha.
        '</div>'.
        '</div>'.

        '</div>';

    return $html;
}

function fechas($data) {
    $html = '<ul id="fechas">';
    if ($data->type == 'PROJECT') {
        $html .= '<li><span>'.JText::_($data->type.'_FUND_START').'</span>'.$data->fundStartDate.'</li>'.
            '<li><span>'.JText::_($data->type.'_FUND_END').'</span>'.$data->fundEndDate.'</li>'.
            '<li><span>'.JText::_($data->type.'_PRODUCTION_START').'</span>'.$data->productionStartDate.'</li>';
    }
    $html .= '<li><span>'.JText::_($data->type.'_PREMIERE_START').'</span>'.$data->premiereStartDate.'</li>'.
        '<li><span>'.JText::_($data->type.'_PREMIERE_END').'</span>'.$data->premiereEndDate.'</li>'.
        '</ul>';

    return $html;
}

function userName($data) {
    $db =& JFactory::getDBO();
    $query = $db->getQuery(true);

    $query
        ->select('nomNombre,nomApellidoPaterno')
        ->from('perfil_persona')
        ->where('users_id = '.$data.' && perfil_tipoContacto_idtipoContacto = 1');

    $db->setQuery( $query );

    $resultado = $db->loadObject();
    if (!is_null($resultado)) {
        $result = $resultado->nomNombre.' '.$resultado->nomApellidoPaterno;
    }
    $result = JFactory::getUser($data)->name;

    return $result;
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
        jQuery("#rt-mainbody").addClass("margen-proyecto");
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
                initialize();
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
            <img src="<?php echo BANNER.'/'.$json->banner; ?>" />
        </div>
    </div>
    <div id="video" class="ver_proyecto">
        <div id="content_player">
            <?php
            if( ($isSpecial == 1) || ($json->acceso != null) || ($json->videoPublic == 1) || (UserData::getUserJoomlaId($json->userId) == $usuario->id) ){
                ?>
                <div id="video-player">
                    <div id="menu-player">
                        <?php echo videos($json, 0); ?>
                    </div>
                    <div id="reproductor">
                        <?php echo videos($json, 1); ?>
                    </div>
                </div>
            <?php
            }elseif( ($json->acceso == null) || ($json->videoPublic == 0) ) {
                echo JText::_('CONTENIDO_PRIVADO');
            }
            ?>
        </div>
        <a class="cerrar"><?php echo JText::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?></a>
    </div>
    <div id="gallery" class="ver_proyecto">
        <div id="wrapper">
            <?php
            if( ($isSpecial == 1) || ($json->acceso != null) || ($json->imagePublic == 1) || (UserData::getUserJoomlaId($json->userId) == $usuario->id) ){
                ?>
                <div class="slider-wrapper theme-bar">
                    <div id="slider" class="nivoSlider">
                        <?php echo imagenes($json); ?>
                    </div>
                </div>
            <?php
            }elseif( ($json->acceso == null) || ($json->imagePublic == 0) ) {
                echo JText::_('CONTENIDO_PRIVADO');
            }
            ?>
        </div>
        <a class="cerrar"><?php echo JText::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?></a>
    </div>
    <div id="audios" class="ver_proyecto">
        <?php
        if( ($isSpecial == 1) || ($json->acceso != null) || ($json->audioPublic == 1) || (UserData::getUserJoomlaId($json->userId) == $usuario->id) ){
            echo audios($json->projectSoundclouds);
        }elseif( ($json->acceso == null) || ($json->audioPublic == 0) ) {
            echo JText::_('CONTENIDO_PRIVADO');
        }
        ?>
        <a class="cerrar"><?php echo JText::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?></a>
    </div>
    <div id="finanzas" class="ver_proyecto">
        <?php
        if( ($isSpecial == 1) || ($json->acceso != null) || ($json->numberPublic == 1) || (UserData::getUserJoomlaId($json->userId) == $usuario->id) ){
            echo '<h1 class="mayusc">'.JText::_('LABEL_FINANZAS').'</h1>';
            echo informacionTmpl($json, "finanzas");
        }elseif( ($json->acceso == null) || ($json->numberPublic == 0) ) {
            echo JText::_('CONTENIDO_PRIVADO');
        }
        ?>
        <a class="cerrar"><?php echo JText::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?></a>
    </div>

    <div id="info" class="ver_proyecto">
        <?php
        if( ($isSpecial == 1) || ($json->acceso != null) || ($json->infoPublic == 1) || (UserData::getUserJoomlaId($json->userId) == $usuario->id) ){
        ?>
        <h1 class="mayusc"><?php echo JText::_('LABEL_INFO'); ?></h1>

        <div class="detalleDescripcion">
            <?php
            echo informacionTmpl($json, null);
            }elseif( ($json->acceso == null) || ($json->infoPublic == 0) ) {
                echo JText::_('CONTENIDO_PRIVADO');
            } ?>


            <link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

            <script>

                var geocoder;
                var map;
                function initialize() {

                    var useragent = navigator.userAgent;
                    var mapdiv = document.getElementById("map-canvas");

                    if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
                        mapdiv.style.width = '100%';
                        mapdiv.style.height = '100%';
                        variables = {zoom: 14, center: latlng, disableDefaultUI: true, draggable: false, disableDoubleClickZoom: false, zoomControl: true, mapTypeId: google.maps.MapTypeId.ROADMAP};
                    } else {
                        mapdiv.style.width = '455px';
                        mapdiv.style.height = '300px';
                        variables = {zoom: 14, center: latlng, disableDefaultUI: false, mapTypeId: google.maps.MapTypeId.ROADMAP};
                    }

                    geocoder = new google.maps.Geocoder();
                    var latlng = new google.maps.LatLng(19.432684,-99.133359);
                    var mapOptions = variables;
                    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                    codeAddress();
                }

                function codeAddress() {
                    var address = '<?php echo $json->showground; ?>';
                    geocoder.geocode( { 'address': address}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            var marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location
                            });
                        } else {
                            map.setCenter(latlng);
                            jQuery('#map-canvas').append('<p><?php echo JText::_('NO_ADDRESS'); ?></p>');
                        }
                    });
                }

            </script>

        </div>
        <a class="cerrar"><?php echo JText::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?></a>
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
        var ruta = "libraries/trama/js/raty/img/"
        $('#rating').raty({
            click: function(score, evt) {
                var request = $.ajax({
                    url:"<?php echo MIDDLE.PUERTO.TIMONE; ?>project/rate",
                    data: {
                        "score": score,
                        "projectId": "<?php echo $proyecto; ?>",
                        "token": "<?php echo $token; ?>",
                        "userId": <?php echo $usuario->idMiddleware; ?>
                    },
                    type: 'post'
                });

                request.done(function(result){
                    var obj = eval('(' + result + ')');

                    if(obj.error == "1") {
                        alert('<?php echo JText::_("ERROR_TOKEN"); ?>');

                    } else {

                        if (obj.resultType == 'SUCCESS') {
                            jQuery('#rating').raty({
                                readOnly: true,
                                path 	: ruta,
                                score 	: obj.rate,
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
                    }
                });

                request.fail(function (jqXHR, textStatus) {
                    console.log(jqXHR, textStatus);
                    alert('<?php echo JText::_("RATING_ERROR"); ?> 65654654654654');
                });
            },
            score		: rating,
            path		: ruta,
            //target		: '#texto',
            //targetText	: 'Puntuar'
        });

        $('.shareButton').click(function() {
            var respuesta = $.ajax({
                url:"libraries/trama/js/ajax.php",
                data: {
                    "userId": <?php echo $usuario->id; ?>,
                    "projectId": <?php echo $json->id; ?>,
                    "linkProyecto": "<?php echo JURI::base().'index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$json->id; ?>",
                    "nomUser": "<?php echo userName($usuario->id); ?>",
                    "nomProyecto": "<?php echo $json->name;?>",
                    "fun": 3
                },
                type: 'post'
            });

            respuesta.done(function(result){
                var objShare = eval('('+result+')');

                if (!objShare.shared) {
                    $('.shareButton').parent().append('<span><?php echo JText::_('SHARED_SUCCESS'); ?></span>');
                    $('.shareButton').remove();
                } else {
                    alert('<?php echo JText::_('SHARED_ALREADY'); ?>');
                }
            });
        });




    });

    $(window).load(function() {
        $('#slider').nivoSlider();
    });
</script>