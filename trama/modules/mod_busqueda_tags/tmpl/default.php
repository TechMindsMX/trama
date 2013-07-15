<?php
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();

$doc -> addScript('modules/mod_busqueda_tags/js/lib.js');
?>

<script>
	jQuery(document).ready(function() {
		jQuery('#tags').inputlimiter({
			limit : 1,
			limitBy : 'words',
			remText : '',
			limitText : '<?php echo JText::_('MOD_BUSQUEDA_TAGS_CAMPO_LIMITADO'); ?> %n <?php echo JText::_('MOD_BUSQUEDA_TAGS_PALABRA'); ?>.'
		});

	}); 
</script>

<form action="<?php echo $url; ?>" id="busqueda_tags" method="post">

	<input type="text" name="tags" id="tags" size="30" />
	<input type="submit" class="button" value="<?php echo JText::_('BUSCAR'); ?>" />

</form>

