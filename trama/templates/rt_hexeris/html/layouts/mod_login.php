<?php
/**
* @version   $Id: mod_login.php 7372 2013-02-08 07:29:00Z josh $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*
* Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
*
*/
defined('JPATH_BASE') or die();

gantry_import('core.gantrylayout');

/**
 *
 * @package gantry
 * @subpackage html.layouts
 */
class GantryLayoutMod_Login extends GantryLayout {
    var $render_params = array(
        'contents'       =>  null,
        'position'      =>  null,
        'gridCount'     =>  null,
        'pushPull'      =>  ''
    );
    function render($params = array()){
        global $gantry;

        $rparams = $this-> _getParams($params);
        ob_start();
    // XHTML LAYOUT
?>

<div id="rt-popuplogin">
  <?php echo $rparams->contents; ?>
</div>

<?php
        return ob_get_clean();
    }
}