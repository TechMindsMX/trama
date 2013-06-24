<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$path = JConfig::$mw_path.JConfig::$mw_avatar;

$usuario = JFactory::getUser();
$base = JUri::base();
$document = JFactory::getDocument();
$pathJumi = '/herexis/components/com_jumi/files';

if ($_POST[categoria] == "" && $_POST[subcategoria] == "all") {	
	$url = 'http://192.168.0.106:7171/trama-middleware/rest/project/list';
} elseif ($_POST[categoria] != "" && $_POST[subcategoria] == "all") {
	$url = 'http://192.168.0.106:7171/trama-middleware/rest/project/category/'. $_POST[categoria];
} elseif ($_POST[categoria] != "" && $_POST[subcategoria] != "all") {
	$url = 'http://192.168.0.106:7171/trama-middleware/rest/project/subcategory/'. $_POST[subcategoria];
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
console.log(members);
	for ( var i = page_index * items_per_page; i < max_elem; i++ ) {
		newcontent += '<div id="proyecto">';
		newcontent += '<div id="avatar"> <img src="<?php echo $path; ?>' + members[i].projectAvatar.name + '" alt="Avatar" width="235" height="235" /> </div>';
		newcontent += '<div id="titulo">';
		newcontent += '<div id="tituloText">' + members[i].name + '</div>';
		newcontent += '</div>';
		newcontent += '<div id="descripcion">';
		newcontent += '<div id="descText">' + members[i].description + '</div>';
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
