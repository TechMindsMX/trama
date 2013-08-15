<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");

$accion = JURI::base().'index.php?option=com_jumi&view=application&fileid=25';
/**
 *
 */
class AltaProveedores {

	function __construct() {
		$this -> usuario = JFactory::getUser();
		$app = JFactory::getApplication();

		if ($this -> usuario -> guest == 1) {
			$return = JURI::getInstance() -> toString();
			$url = 'index.php?option=com_users&view=login';
			$url .= '&return=' . base64_encode($return);
			$app -> redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
		}

		require_once 'components/com_jumi/files/crear_proyecto/classIncludes/clase.php';
		$proyId = $app -> input -> get('proyid', '', 'INT');
		$this -> objDatos = claseTraerDatos::getDatos('project', (!empty($proyId)) ? $proyId : null);

		$this -> getMoreData();
		$this -> getMiembrosGrupo();
		$this -> editable();
		$this->fechas();

	}

	function editable() {
		$checkUser = ($this -> usuario -> id == $this -> objDatos -> userId);
		$checkStatus = ($this -> objDatos -> status == 2 || $this -> objDatos -> status == 0);
		$this -> editable = ($checkUser && $checkStatus);
	}

	public function getMoreData() {
		jimport('trama.class');
		$this -> objDatos -> catName = JTrama::getCatName($this -> objDatos -> subcategory);
		$this -> objDatos -> subCatName = JTrama::getSubCatName($this -> objDatos -> subcategory);
		$this -> objDatos -> statusName = JTrama::getStatusName($this -> objDatos -> status);
	}

	function getMiembrosGrupo() {
		$db = JFactory::getDbo();
		$query = $db -> getQuery(true);
		$query	-> select('id') 
				-> from('#__community_groups') 
				-> where('proyid = ' . $this -> objDatos -> id);
		$db -> setQuery($query);
		$results = $db -> loadResult();

		if ($results != null) {
			$query2 = $db -> getQuery(true);
			$query2 -> select('a.memberid, b.name') 
					-> from('#__community_groups_members AS a, #__users AS b') 
					-> where('a.groupid = ' . $results . ' AND a.memberid = b.id');
			$db -> setQuery($query2);
			$results2 = $db -> loadObjectList();

			$this->miembrosGrupo = $results2;
		}
	}
	function fechas() {
		$startDate = $this -> objDatos -> productionStartDate;
		$endDate = $this -> objDatos -> premiereStartDate;
		for ($i = strtotime($startDate); $i <= strtotime($endDate); $i = strtotime('+1 day', $i)) {
		  if (date('N', $i) == 2) //Martes == 2
		    $fechasPago[] = date('l Y-m-d', $i);
		}
		$this->fechasPago = $fechasPago;
	}

}

$proyecto = new AltaProveedores;
var_dump($proyecto);

$doc = JFactory::getDocument();
$path = 'components/com_jumi/files/alta_proyectos/';
$doc->addStyleSheet($path.'alta_proyectos.css');
?>


<h2><?php echo JText::_('ALTA_PROVEEDORES'); ?></h2>
<form action="<?php echo $accion ?>" method="post" class="" id="">
	<h3><?php echo $proyecto -> objDatos -> name; ?></h3>
	<p>catName=<?php echo $proyecto -> objDatos -> catName; ?></p>
	<p>subCatName=<?php echo $proyecto -> objDatos -> subCatName; ?></p>
	<p>productionStartDate=<?php echo $proyecto -> objDatos -> productionStartDate; ?></p>
	<p>premiereStartDate=<?php echo $proyecto -> objDatos -> premiereStartDate; ?></p>
	<p>Status=<?php echo $proyecto -> objDatos -> statusName; ?></p>
	<div id="agregados"></div>
	
	<input type="submit" value="Enviar" />
</form>

<div class="todos_miembros_grupo">
	<h3><?php echo JText::_('USUARIOS_MIEMROS'); ?></h3>
	<?php 
	if (isset($proyecto->miembrosGrupo)) {
		foreach ($proyecto->miembrosGrupo as $key => $value) {
		echo '<div>'.
			'<p class="miembro_grupo" id="'.$value->memberid.'">Miembroid='.$value->name.'</p>'.
			'<input type="hidden" name="memberid[]" value="'.$value->memberid.'" />'.
			'</div>';
		}
	}
	?>
</div>
<div class="inputs">
	<input type="checkbox" name="check" /><label for="check">Aquí</label>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.miembro_grupo').click(function(){
			jQuery(this).parent().appendTo('#agregados');
			jQUery('.inputs').insertAfter(this);
		});
	});
</script>