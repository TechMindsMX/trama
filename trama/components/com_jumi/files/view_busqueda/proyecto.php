<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$path = MIDDLE.AVATAR."/";

$usuario = JFactory::getUser();
$base = JUri::base();
$document = JFactory::getDocument();
$pathJumi = Juri::base().'/components/com_jumi/files';

if ($_POST['categoria'] == "" && $_POST['subcategoria'] == "all") {	
	$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/list';
} elseif ($_POST['categoria'] != "" && $_POST['subcategoria'] == "all") {
	$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/category/'. $_POST['categoria'];
} elseif ($_POST['categoria'] != "" && $_POST['subcategoria'] != "all") {
	$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/subcategory/'. $_POST['subcategoria'];
}
	
$json0 = file_get_contents($url);
$json2 = json_decode($json0);

$document->addScript('http://code.jquery.com/jquery-1.9.1.js');
$document->addScript($pathJumi.'/view_busqueda/js/jquery.pagination.js');
$document->addStyleSheet($pathJumi.'/view_busqueda/css/pagination.css');
?>

<script type="text/javascript">	
var members = <?php echo $json0; ?>;

function pageselectCallback (page_index, jq) {
	var items_per_page = 10;
	var max_elem = Math.min((page_index+1) * items_per_page, members.length);
	var newcontent = '';
	var columnas = 3;
	var ancho = Math.floor(100/columnas);
	var countCol = 0;

	for ( var i = page_index * items_per_page; i < max_elem; i++ ) {

		var link = 'index.php?option=com_jumi&view=appliction&fileid=9&proyid=' + members[i].id;
		
		countCol++;
		if (countCol == columnas) {
			countCol = countCol - columnas;
			last='-last';
		}
		else {
			last='';
		}
		newcontent += '<div class="proyecto col' + last + ' ancho' + ancho + '">';
		newcontent += '<div class="inner">';
		newcontent += '<div class="titulo">';
		newcontent += '<div class="tituloText inner">';
		newcontent += '<h4><a href="' + link + '">' + members[i].name + '</h4></a></div>';
		newcontent += '</div>';
		newcontent += '<div class="avatar">';
		newcontent += '<a href="' + link + '">';
		newcontent += '<img src="<?php echo $path; ?>' + members[i].projectAvatar.name + '" alt="Avatar" /></a></div>';
		newcontent += '<div class="descripcion">';
		newcontent += '<div class="inner">';
			var descripcion = members[i].description;
			var largo = 80;
			var trimmed = descripcion.substring(0, largo);
		newcontent += '<div class="descText">' + trimmed + '</div>';
		newcontent += '<p class="readmore">';
		newcontent += '<a href="' + link + '" class="leerText">' + "Ver más...";
		newcontent += '</a>';
		newcontent += '</p>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
	}
               
	jQuery('#Searchresult').html(newcontent);
            
	return false;
}
            
function initPagination() {			 
	var num_entries = members.length;
	var pags = (members.length/num_entries) + 1;

	jQuery("#Pagination").pagination(num_entries, {
		num_display_entries: pags,
		callback: pageselectCallback
	});
}
	                   
$(document).ready(function(){      
	initPagination();
});
</script>


<title>Pagination</title>
</head>
<body>
	<dl id="Searchresult"></dl>
	<div id="Pagination" class="pagination"></div>
</body>
</html>
