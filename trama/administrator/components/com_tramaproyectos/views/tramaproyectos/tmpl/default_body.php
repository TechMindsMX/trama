<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php 
jimport('trama.class');

foreach($this->items as $i => $item):
$item->producerName = JFactory::getUser($item->userId)->name;
	
	var_dump($item);
 ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                        <?php echo $item->name; ?>
                </td>
                <td>
                        <?php echo $item->producerName; ?>
                </td>
        </tr>
<?php endforeach; ?>