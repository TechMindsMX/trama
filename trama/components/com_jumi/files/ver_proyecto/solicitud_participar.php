<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$usuario = JFactory::getUser();
?>

<p><a href="#" data-rokbox="" data-rokbox-element="div.modalcontact">Solicitud de participar</a><a href="#" data-rokbox="" data-rokbox-element="div.popup_contact"></a></p>
<div class="esconder" style="position: absolute; left: -1000px;">
<div class="modalcontact">
<div class="inside" style="width: 300px;"><form id="" action="" method="post">
<input id="nombre" type="text" name="remitente" value="<?php echo $usuario->name; ?>" disabled />
<label for="mensaje">Mensaje</label>
<textarea name="mensaje"></textarea> <input type="hidden" name="receptor" />
<input type="submit" value="Enviar" /></form></div>
</div>
</div>