<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");
jimport('trama.class');
$usuario = JFactory::getUser();
$doc = JFactory::getDocument();

$proyecto = new AltaProveedores;

$path = 'components/com_jumi/files/alta_proveedores/';
require_once 'components/com_jumi/files/crear_pro/classIncludes/libreriasPP.php';
$doc->addStyleSheet($path.'alta_proveedores.css');
$proveedores = $proyecto->objDatos->providers;
$token = JTrama::token();
$input 					= JFactory::getApplication()->input;
$proyid 				= $input->get("proyid",0,"int");
$datosObj 				= $proyid == 0 ? null: JTrama::getDatos($proyid);
$comentarios			= '';
$ligaEditProveedores	= '';
$ligaCostosVariable		= '';
$ligaFinantialData		= '';
$accion = MIDDLE.PUERTO.'/trama-middleware/rest/project/saveProvider';
$callback = JURI::base().'index.php?option=com_jumi&view=application&fileid=25&proyid='.$proyid;

JTrama::isEditable($datosObj, $usuario);

class AltaProveedores {
	
	public $diaPagoProveedores = 2; //Martes == 2
	protected $editable;

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

		$proyId = $app -> input -> get('proyid', null, 'INT');
		$this -> objDatos = JTrama::getDatos($proyId);

		$this -> getMoreData();
		$this -> getEditable();
		
		if (!$this->editable) {
			$app -> redirect('index.php ',JText::_('JERROR_ALERTNOAUTHOR'), 'error');
		}
		
		$this -> getMiembrosGrupo();
		$this -> fechas();
		//$this -> getProviders();

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
		    $fechasPago[] = date('d-m-Y', $i);
		}
		$this->fechasPago = $fechasPago;
	}

}

?>

<h1><?php echo JText::_('ALTA_PROVEEDORES'); ?></h1>
	
	<h3><?php echo $proyecto -> objDatos -> name; ?></h3>
	
	<p><?php echo JText::_('FECHA_INICIO_PRODUCCION').' = '.$proyecto -> objDatos -> productionStartDate; ?></p>
	<p><?php echo JText::_('PREMIER_DATE').' = '.$proyecto -> objDatos -> premiereStartDate; ?></p>
	<p><?php echo JText::_('STATUS').' = '.$proyecto -> objDatos -> statusName; ?></p>
	<p><?php echo JText::_('PRESUPUESTO_VISTAS').' = $'.$proyecto -> objDatos -> budget; ?></p>
	
	<form id="agregados">
		<span class="total_proveedor"><?php echo JText::_('TOTAL_PROVEDORES'); ?></span> = <span class="total"></span>
	
	<h3><?php echo JText::_('PROVEEDOR_USUARIOS_MIEMROS'); ?></h3>
<?php
if (isset($proyecto->miembrosGrupo)) {

	$provedores= $proyecto->objDatos->providers;
	
	foreach ($proyecto->miembrosGrupo as $key => $value) {

	$member = $proyecto->miembrosGrupo[$key];
	$advanceQuantity='';
	$settlementQuantity='';
	$fechaAnticipo='';
	$fechaLiquidacion='';
	if(isset($provedores)){
		foreach ($provedores as $indice =>$valor){
			$advanceQuantity= ($valor->providerId == $member->memberid) ? $valor->advanceQuantity : '';
			$settlementQuantity= ($valor->providerId == $member->memberid) ? $valor->settlementQuantity : '';
			$fechaAnticipo= ($valor->providerId == $member->memberid) ? $valor->advanceDate : '';
			$fechaLiquidacion= ($valor->providerId == $member->memberid) ? $valor->settlementDate : '';
		}
	}
	
	$html = '<div class="inputs '. $member->memberid .'">
			<div class="nombre">
			<label class=""><span class="icon-circle-arrow-up">    '. $member->name .'</label></span>
			<span class="total_proveedor">'.JText::_('TOTAL_PROVEEDOR').'</span> = <span class="sub_total"></span>
			</div>
			<div class="rt-grid-4">
			<p>'.JText::_('PROVEEDOR_ANTICIPO').'</p>
			<input type="hidden" name="providerId" value="'.$member->memberid.'" />
			<label for="advanceQuantity">'.JText::_('PROVEEDOR_MONTO').'</label>
			<input name="advanceQuantity" type="number" min="1000" id="monto" value="'.$advanceQuantity.'" />
			<label for="advanceDate">'.JText::_('JDATE').'</label>
			<select name="advanceDate" id="fecha">'; 
	foreach ($proyecto->fechasPago as $key => $value) {
		$selected=($value == $fechaAnticipo ) ? 'selected' : '';
		$html .= '<option value="'.$value.'" '.$selected.' >'.$value.'</option>';
	}
	$html .= '</select>
			</div>
			<div class="rt-grid-4">
			<p>'.JText::_('PROVEEDOR_LIQUIDACION').'</p>
			<label for="settlementQuantity">'.JText::_('PROVEEDOR_MONTO').'</label>
			<input name="settlementQuantity" type="number" min="1000" id="monto" value="'.$settlementQuantity.'" />
			<label for="settlementDate">'.JText::_('JDATE').'</label>
			<select name="settlementDate" id="fecha">';
	foreach ($proyecto->fechasPago as $key => $value) {
		$selected=($value == $fechaLiquidacion ) ? 'selected' : '';
		$html .= '<option value="'.$value.'" '.$selected.' >'.$value.'</option>';
	}
	$html .= '</select>
			</div>
		<div style="clear: both;"></div>'.
		'</div>';
	echo $html;
	}
}
?>
	</form>

<script type="text/javascript">
function noboton(){
	var totalpro	= parseInt( jQuery('#agregados').children('span.total').text());
	var budgetphp	= parseInt(<?php echo $proyecto -> objDatos -> budget;?>);
	
	if (totalpro != budgetphp){
alert('<?php echo JText::_('CONFIRMAR_PRO'); ?>');
	}				
}
	jQuery(document).ready(function() {
		suma(jQuery('input[type="number"]'));
		jQuery("#agregados").validationEngine();
		sumatotal();
		jQuery(".nombre").siblings().hide();
		jQuery('.icon-circle-arrow-up').click(function(){
			if (jQuery(this).hasClass('icon-circle-arrow-up')) {
				jQuery(this).removeClass('icon-circle-arrow-up');
				jQuery(this).addClass('icon-circle-arrow-down');
				jQuery(this).parent().parent().siblings().show('slow');
				jQuery(this).parent().parent().parent().find('input[type="number"]').each(function() {
    				jQuery(this).addClass('validate[required,custom[onlyNumberSp]]');
				});
			}
			else {
			var error = 0;
			jQuery(this).parent().parent().parent().find('input[type="number"]').each(function() {
				if (jQuery(this).val() == '') {
					error++;
				}
			});
			if (error == 1 ) { 
				alert('Debe llenar los dos campos');
				return false;
			};
			jQuery(this).removeClass('icon-circle-arrow-down');
			jQuery(this).addClass('icon-circle-arrow-up');
			jQuery(this).parent().parent().siblings().hide();
			jQuery(this).parent().parent().parent().find('input[type="number"]').each(function() {
				jQuery(this).removeClass('validate[required,custom[onlyNumberSp]]');
			});
			}
		});

		jQuery('input[type="number"]').focusout(function() {
			suma(this);
		});

		function suma (campo){
			var aaa = 0;
			jQuery(campo).parent().parent().find('input[type="number"]').each(function() {
				aaa += parseInt(jQuery(this).val()) || 0;
			});
			jQuery(campo).parent().siblings('.nombre').children('span.sub_total:first').text(aaa);

			sumatotal();
		}

		function sumatotal (){
			var total = 0 ;
			jQuery('#agregados').find('input[type="number"]').each(function() {
				total += parseInt(jQuery(this).val()) || 0;
			});
			jQuery('#agregados').children('span.total').text(total);
			
			}
		
		$('select').change(function(){
	        if(this.name == 'advanceDate') {
	        	var date1 = $(this).val().split('-');
	            var fecha1 = new Date(date1[2]+'-'+date1[1]+'-'+date1[0]);
	            var selectLiquidacion = $(this).parent().next().children('select');

	            $.each(selectLiquidacion[0], function(index, value){
	                var date2 = $(value).val().split('-');
	                var fechaOption = new Date(date2[2]+'-'+date2[1]+'-'+date2[0]);

	                if(fecha1 >= fechaOption) {
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
			<?php 
			if( !is_null($datosObj) ) {
				require_once 'components/com_jumi/files/crear_pro/classIncludes/proyectGroup.php';
			
				$app = JFactory::getApplication();
				if( $datosObj->userId != $usuario->id ) {
					$url = 'index.php';
					$app->redirect($url, JText::_('ITEM_DOES_NOT_EXIST'), 'error');
				}
			
				$mensaje = JText::_('EDIT').' '.JText::_($datosObj->type);
				$ligaPro = '<span class="liga">
							<a href="index.php?option=com_jumi&view=appliction&fileid=27&proyid='.$datosObj->id.'">'.$mensaje.'</a>
						</span>';
			
				if( ($datosObj->status == 0 || $datosObj->status == 2) && ($datosObj->type == 'PROJECT')) {
					if($datosObj->status == 2) {
						$comentarios = '<span class="liga"><a data-rokbox href="#" data-rokbox-element="#divContent">'.JText::_('JCOMENTARIOS').'</a></span>';
					}
			
					if(empty($datosObj->providers)){
						$mensaje = JText::_('ALTA_PROVEEDPORES');
					} else {
						$mensaje = JText::_('EDITAR_PROVEEDPORES');
					}
					$ligaEditProveedores = '<span class="liga">
											<a href="index.php?option=com_jumi&view=appliction&fileid=25&proyid='.$datosObj->id.'">'.$mensaje.'</a>
								   		</span>';
			
					if(!is_null($datosObj->breakeven)){
						$mensajeFinanzas = JText::_('EDITAR_FINANZAS');
			
						$ligaFinantialData = '<span class="liga">
										  	<a href="index.php?option=com_jumi&view=appliction&fileid=28&proyid='.$datosObj->id.'">'.$mensajeFinanzas.'</a>'.
													  	'</span>';
					}
			
					$ligaCostosVariable = '<span class="liga">
									  	<a href="index.php?option=com_jumi&view=appliction&fileid=26&proyid='.$datosObj->id.'">'.$mensaje.'</a>'.
												  	'</span>';
				}
			}

			?>
		jQuery("#guardar").click(function (){

			noboton();

			jQuery('#agregados').find('input[type="number"]').each(function() {
			    if (jQuery(this).val() == '' ) {
			    var parent = jQuery(this).parent().parent();
			        jQuery(parent).remove();
			    }
			});
			
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
			
			jQuery("#proveedores").submit();
		});
	});
</script>
<form action="<?php echo $accion ?>" method="post" class="" id="proveedores" >
	<input type="hidden" value="<?php echo $proyecto -> objDatos -> id; ?>" name="projectId" id="proyid"/>
	<input type="hidden" value="<?php echo $callback; ?>" name='callback' />
	<input type="hidden" value="" name="projectProvider" id="data_send"/>
	<input type="hidden" value="<?php echo $token;?>" name="token">
	<!-- Tabla con proveedores-->
	<div style="margin-bottom: 10px;">
		<table class="table table-striped" width="100%" style="text-align: center;" frame="box" rules="all">
			<tr>
				<th></th>
				<th colspan="2"><?php echo JText::_('ANTICIPO'); ?></th>
				<th colspan="2"><?php echo JText::_('LIQUIDACION'); ?></th>
			</tr>
			<tr>
				<th><?php echo JText::_('PROVEEDOR'); ?></th>
				<th><?php echo JText::_('FECHA'); ?></th>
				<th><?php echo JText::_('MONTO'); ?></th>
				<th><?php echo JText::_('FECHA'); ?></th>
				<th><?php echo JText::_('MONTO'); ?></th>
			</tr>
			<?php
			foreach ($proveedores as $key => $value) {
			?>
			<tr>
				<td><?php echo JFactory::getUser($value->providerId)->name; ?></td>
				<td><?php echo $value->advanceDate; ?></td>
				<td>$<?php echo $value->advanceQuantity; ?></td>
				<td><?php echo $value->settlementDate; ?></td>
				<td>$<?php echo $value->settlementQuantity; ?></td>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
	<!--Fin de tabla-->
	<div class="barra-top" id="otras_ligas">
		<?php 
			echo $ligaPro;
			echo $ligaFinantialData;			
			echo $ligaCostosVariable;
			echo $comentarios; 
		?>
	</div>
	<div class="boton_enviar">
	<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
	<input type="button" value="<?php echo JText::_('GUARDAR');  ?>" id="guardar" class="button" />
	</div>
</form>