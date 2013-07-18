<?php
defined('_JEXEC') or die('Restricted access');
JImport('trama.class');

include_once JPATH_ROOT . '/components/com_community/libraries/core.php';
include_once JPATH_ROOT . '/components/com_community/libraries/user.php';


$obj =& CFactory::getUser();

$otro = new stdClass;
$otro->ids = $obj->getFriendIds();

$proyId = $_GET['proyid'];

if (!isset($proyId)) {
	$mensaje = 'Acceso Prohibido';
	
	$allDone =& JFactory::getApplication();
	$allDone->redirect('index.php', $mensaje );
}

?>
<form method="post" name="form1" id="form1" action="http://localhost/prueba.php">
	<input type="hidden" name="proyid" value="<?php echo $proyId; ?>" />
	<?php
	foreach ($otro->ids as $key => $value) {
	?>
		<input type="checkbox" name="userIds[]" value="<?php echo $value; ?>" />
		<?php echo JTrama::getProducerName($value); ?>
		<br />
	<?php
	}
	?>
	<br /><br />
	<input type="submit" value="enviar" />
</form>