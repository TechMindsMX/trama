<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php 
jimport('trama.class');
$urls = new JTrama;

foreach($this->items as $i => $item):
	if ( $item->type != 'REPERTORY' ) {
		$user_revision = $item->logs;
		$revisado_por = JFactory::getUser($user_revision[0]->userId)->name;
		$item->producerName = JFactory::getUser($item->userId)->name;
 ?>
        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
                <td>
                	<?php echo $item->id; ?>
                </td>
                <td>
                	<a href="index.php?option=com_tramaproyectos&view=detalleproyecto&id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                </td>
                <td>
                	<?php echo $item->producerName; ?>
                </td>
                <td>
                	<?php echo $urls::tipoProyProd($item); ?>
                </td>
                <td>
                	<?php echo $urls::getStatusName($item->status); ?>
                </td>
                <td>
                	<?php echo $revisado_por; ?>
                </td>
        </tr>
<?php 
	}
endforeach; 
?>