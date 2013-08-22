<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");

$accion = JURI::base().'index.php?option=com_jumi&view=application&fileid=25';
$accion = 'http://192.168.0.114:7171/trama-middleware/rest/project/saveProvider';
// $accion = 'ajax.php';
/**
 *
 */
class AltaProveedores {
	
	public $diaPagoProveedores = 2; //Martes == 2
	protected $editable;
	protected $providers;

	public function __construct() {
		$this -> usuario = JFactory::getUser();
		$this -> sesion = JFactory::getSession();
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
		$this -> getEditable();
		
		if (!$this->editable) {
			// $app -> redirect('index.php ',JText::_('JERROR_ALERTNOAUTHOR'), 'error');
		}
		
		$this -> getMiembrosGrupo();
		$this -> fechas();
		$this -> getProviders();

	}
	protected function getProviders()
	{
$results2[0] =(object) array('memberid' => 382, 'name' => 'Usuario1');
$results2[1] =(object) array('memberid' => 383, 'name' => 'Usuario2');
$results2[2] =(object) array('memberid' => 379, 'name' => 'Usuario3');
$this->miembrosGrupo = $results2;
		
$proveedores[0] =(object) array('providerId' => 382 , 'advanceDate' => '2013-10-10','advanceQuantity' => 1000,'settlementDate' => '2013-10-17','settlementQuantity' => 2000);
$proveedores[1] =(object) array('providerId' => 383 , 'advanceDate' => '2013-11-20','advanceQuantity' => 3000,'settlementDate' => '2013-11-27','settlementQuantity' => 4000);
		
		foreach ($proveedores as $keyProv => $valueProv) {
			foreach ($this->miembrosGrupo as $keyMiem => $valueMiem) {
					echo 'keym='.$keyMiem.'mem='.$valueMiem->memberid;
				if ($valueProv->providerId == $valueMiem->memberid) {
					$this->miembrosGrupo[$keyMiem]->advanceDate = $valueProv->advanceDate;
					$this->miembrosGrupo[$keyMiem]->advanceQuantity = $valueProv->advanceQuantity;
					$this->miembrosGrupo[$keyMiem]->settlementDate = $valueProv->settlementDate;
					$this->miembrosGrupo[$keyMiem]->settlementQuantity = $valueProv->settlementQuantity;
				}
			}
		}
		$this -> providers = $proveedores;
	}

	protected function getEditable() {
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

	public function getMiembrosGrupo() {
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
	public function fechas() {
		$startDate = $this -> objDatos -> productionStartDate;
		$endDate = $this -> objDatos -> premiereStartDate;
		for ($i = strtotime($startDate); $i <= strtotime($endDate); $i = strtotime('+1 day', $i)) {
		  if (date('N', $i) == $this -> diaPagoProveedores ) 
		    $fechasPago[] = date('Y-m-d', $i);
		}
		$this->fechasPago = $fechasPago;
	}

}

$proyecto = new AltaProveedores;

$doc = JFactory::getDocument();
$path = 'components/com_jumi/files/alta_proveedores/';
$doc->addStyleSheet($path.'alta_proveedores.css');

?>


<h2><?php echo JText::_('ALTA_PROVEEDORES'); ?></h2>
<form action="<?php echo $accion ?>" method="post" class="" id="proveedores" >
	<h3><?php echo $proyecto -> objDatos -> name; ?></h3>
	<p>catName=<?php echo $proyecto -> objDatos -> catName; ?></p>
	<p>subCatName=<?php echo $proyecto -> objDatos -> subCatName; ?></p>
	<p>productionStartDate=<?php echo $proyecto -> objDatos -> productionStartDate; ?></p>
	<p>premiereStartDate=<?php echo $proyecto -> objDatos -> premiereStartDate; ?></p>
	<p>Status=<?php echo $proyecto -> objDatos -> statusName; ?></p>
	<p>Presupuesto=<?php echo $proyecto -> objDatos -> budget; ?></p>
	
	<input type="hidden" value="" name="projectProvider" id="data_send"/>
	
	<input type="submit" value="Enviar" id="guardar" class="button" />
</form>
	<form id="agregados">
		<span class="total_proveedor"><?php echo JText::_('TOTAL'); ?></span> = <span class="total"></span>
		<input type="hidden" value="<?php echo $proyecto -> objDatos -> id; ?>" name="projectId" id="proyid"/>
	</form>

<div id="todos_miembros_grupo">
	<h3><?php echo JText::_('PROVEEDOR_USUARIOS_MIEMROS'); ?></h3>
<?php 
if (isset($proyecto->miembrosGrupo)) {
	foreach ($proyecto->miembrosGrupo as $key => $value) {

	$member = $proyecto->miembrosGrupo[$key];

	$html = '<div class="inputs '. $member->memberid .'">
			<div class="nombre">
			<label class=""><span class="icon-circle-arrow-up">    '. $member->name .'</label></span>
			<span class="total_proveedor">'.JText::_('TOTAL_PROVEEDOR').'</span> = <span class="sub_total"></span>
			</div>
			<div class="rt-grid-4">
			<p>'.JText::_('PROVEEDOR_ANTICIPO').'</p>
			<input type="hidden" name="providerId" value="'.$member->memberid.'" />
			<label for="advanceQuantity">'.JText::_('PROVEEDOR_MONTO').'</label>
			<input name="advanceQuantity" type="number" min="1000" id="monto" class="validate[custom[onlyNumberSp]]" />
			<label for="advanceDate">'.JText::_('JDATE').'</label>
			<select name="advanceDate" id="fecha">'; 
	foreach ($proyecto->fechasPago as $key => $value) {
		$html .= '<option value="'.$value.'">'.$value.'</option>';
	}
	$html .= '</select>
			</div>
			<div class="rt-grid-4">
			<p>'.JText::_('PROVEEDOR_LIQUIDACION').'</p>
			<label for="settlementQuantity">'.JText::_('PROVEEDOR_MONTO').'</label>
			<input name="settlementQuantity" type="number" min="1000" id="monto" class="validate[custom[onlyNumberSp]]" />
			<label for="settlementDate">'.JText::_('JDATE').'</label>
			<select name="settlementDate" id="fecha">';
	foreach ($proyecto->fechasPago as $key => $value) {
		$html .= '<option value="'.$value.'">'.$value.'</option>';
	}
	$html .= '</select>
			</div>
		<div style="clear: both;"></div>'.
		'</div>';
	echo $html;
	}
}
?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".nombre").siblings().hide();
		jQuery('.icon-circle-arrow-up').click(function(){
			if (jQuery(this).hasClass('icon-circle-arrow-up')) {
				jQuery(this).parent().parent().parent().appendTo('#agregados');
				jQuery(this).removeClass('icon-circle-arrow-up');
				jQuery(this).addClass('icon-circle-arrow-down');
				jQuery(this).parent().parent().siblings().show('slow');
			}
			else {
			jQuery(this).parent().parent().parent().appendTo('#todos_miembros_grupo');
			jQuery(this).removeClass('icon-circle-arrow-down');
			jQuery(this).addClass('icon-circle-arrow-up');
			jQuery(this).parent().parent().siblings().hide();
			}
		});

		jQuery('input[type="number"]').focusout(function() {
			var aaa = 0;
			jQuery(this).parent().parent().find('input[type="number"]').each(function() {
				aaa += parseInt(jQuery(this).val()) || 0;
			});
			jQuery(this).parent().siblings('.nombre').children('span.sub_total:first').text(aaa);

			var total = 0 ;
			jQuery(this).parent().parent().parent().find('input[type="number"]').each(function() {
				total += parseInt(jQuery(this).val()) || 0;
			});
			jQuery('#agregados').children('span.total').text(total);
		});
		
		$('select').change(function(){
	        if(this.name == 'advanceDate') {
	            var fecha1 = new Date($(this).val());
	            var selectLiquidacion = $(this).parent().next().children('select');
	
	            $.each(selectLiquidacion[0], function(index, value){
	                var fechaOption = new Date($(value).val());
	                if(fecha1 >= fechaOption) {
	                    console.log(this);
	                    $(this).prop('disabled', true);
	                }else{
	                    $(this).prop('disabled', false);
	                }
	            })
	        }
	    });
	});
</script>

<script>
	jQuery(document).ready(function(){

		jQuery("#guardar").click(function (){
			
			var count = 0;
			data = {};
			dataArray = new Array();
			jQuery.each(jQuery("#agregados").serializeArray(), function () {
				data[this.name] = this.value;
				if (this.name == 'settlementDate') {
					dataArray[count] = JSON.stringify(data) ;
					count++;
				}
			});
			json = dataArray.join(",");
			
			json = '{"projectProviders":[' + json + ']}';

			jQuery("#data_send").val(json);
			
			jQuery("#proveedores").submit(function(){
				// return false;
			});
		});
	});
</script>

<?php 
// var_dump($proyecto);
?>