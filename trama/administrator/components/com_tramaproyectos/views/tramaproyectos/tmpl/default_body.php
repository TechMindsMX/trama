<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php 
jimport('trama.class');

foreach($this->items as $i => $item):
$item->producerName = JFactory::getUser($item->userId)->name;

 ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                
                <td>
                        <a href="index.php?option=com_tramaproyectos&view=detalleproyecto&id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                </td>
                <td>
                        <?php echo $item->producerName; ?>
                </td>
        </tr>
<?php endforeach; ?>