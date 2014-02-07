<?php

defined('JPATH_PLATFORM') or die ;

class JTrama 
{
	public $nomCat = null;
	
	public $nomCatPadre = null;

	//Metodos que usan Servicios MIDDLEWARE
	public function	getAllSubCats() {
		$url = MIDDLE . PUERTO . '/trama-middleware/rest/category/subcategories/all';
		$subcats = json_decode(@file_get_contents($url));
		
		return $subcats;
	}	

	public function	getAllCatsPadre() {
	  	$url = MIDDLE.PUERTO.'/trama-middleware/rest/category/categories';
		$cats = json_decode(@file_get_contents($url));
		
		return $cats;
	}

	public static function getStatusName ($id) {
		$allNames = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));
		
		if (!empty($allNames)) {
			foreach ($allNames as $llave => $valor) {
				if ( $valor->id == $id ) {
					$valor->fullName 		= JText::_('TIP_'.strtoupper($valor->name).'_FULLNAME');
					$valor->tooltipTitle 	= JText::_('TIP_'.strtoupper($valor->name).'_TITLE');
					$valor->tooltipText 	= JText::_('TIP_'.strtoupper($valor->name).'_TEXT');
				break;
				}
			}
		}
		return $valor;
	}
	
	public static function getStatus(){
		$status = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));
		
		return $status;
	}
	
	public function getProjectsByUser ($userid) {
		$projectList = json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/getByUser/'.$userid));

		return $projectList;
	}
	
	public static function allProjects(){
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/all';
		$jsonAllProjects = file_get_contents($url);
		$json = json_decode($jsonAllProjects);
		
		if (!empty($json)) {
			foreach ($json as $key => $value) {
				JTrama::formatDatosProy($value);
			}
		}
		return $json;
	}

	public static function getDatos ( $id ) {
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$id;
		$json = file_get_contents($url);
		$respuesta = json_decode($json); 
		
		//JTrama::checkValidId($respuesta);
		JTrama::formatDatosProy($respuesta);
			
		return $respuesta;
	}
	
	public static function token(){
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/security/getKey';
		$token = file_get_contents($url);
		
		return $token;
	}

	//Metodos que no usan servicios MIDDLEWARE
	public function fetchAllCats()	{
		$cats = JTrama::getAllSubCats();
		$subcats = JTrama::getAllCatsPadre();
		$cats = array_merge($cats, $subcats);
		
		return $cats;
	}

	public function getSubCatName($data) {
		$cats = JTrama::fetchAllCats();
		foreach ($cats as $key => $value) {
			if ($value -> id == $data ) {
				$nomCat = $value -> name;
			}
		}
		return $nomCat;
	}

	public function getCatName($data) {
		$cats = JTrama::fetchAllCats();
		foreach ($cats as $key => $value) {
			if ($value -> id == $data ) {
				$nomCat = $value -> name;
				$idFather = $value -> father;
				if ($idFather >= 0) {
					foreach ($cats as $indice => $valor) {
						if ( $valor->id == $idFather ) {
							$nomCatPadre = $valor->name;
						}
					}
				}
				else {
					$nomCatPadre = '';
				}
			}
		}
		return $nomCatPadre;
	}
	
	public function getProducerProfile($data) {
		include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
		$link = JRoute::_('index.php?option=com_jumi&view=application&fileid=17&userid='.$data);
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query
		->select(array('a.nomNombre','a.nomApellidoPaterno'))
		->from('perfil_persona AS a')
		->where('a.users_id = '.$data.' && a.perfil_tipoContacto_idtipoContacto = 1');
		
		$db->setQuery($query);
		$producer = $db->loadRow();
		if (!is_null($producer)) {
			$producer = implode(' ',$producer);
		}
		else {
			$producer = 'Anonimo';
		}
		$html = '<a href="'.$link.'" mce_href="'.$link.'">'.$producer.'</a>';
		return $html;
	}
	
	public function getEditUrl($value) {
		$value->viewUrl = 'index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$value->id;
		switch ($value->type) {
			case 'PROJECT':
				$value->editUrl = 'index.php?option=com_jumi&view=appliction&fileid=27&proyid='.$value->id;
				break;
			case 'PRODUCT':
				$value->editUrl = 'index.php?option=com_jumi&view=appliction&fileid=29&proyid='.$value->id;
				break;
			case 'REPERTORY':
				$value->editUrl = 'index.php?option=com_jumi&view=appliction&fileid=30&proyid='.$value->id;
				break;
			}
		$this->proy = $value;
		return $this->proy;
	}
	
	public static function tipoProyProd($data) {
		$tipo = $data->type;
		switch ($tipo) {
			case 'PRODUCT':
				$tipoEtiqueta = JText::_('PRODUCT');
				$data->editUrl = '12';
				break;
			case 'REPERTORY':
				$tipoEtiqueta = JText::_('REPERTORIO');
				$data->editUrl = '14';
				break;
			default:
				$tipoEtiqueta = JText::_('PROJECT');
				$data->editUrl = '9';
				break;
		}
		return $tipoEtiqueta;
	}

	public static function searchGroup($id){
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query
		->select('id')
		->from('c3rn2_community_groups')
		->where('proyid = '.$id);
		
		$db->setQuery( $query );
		
		$idGroup = $db->loadObject();
		
		return $idGroup;
		
	}
	
	public static function checkValidId($data) {
		$app = JFactory::getApplication();
		if(!isset($data->id)) {
			$url = 'index.php';
			$app->redirect($url, JText::_('ITEM_DOES_NOT_EXIST'), 'error');
		}
	}
	
	public static function formatDatosProy ($value) {
		foreach ($value->projectFinancialData as $key => $valor) {
			if($key != 'id'){	
				$value->$key = $valor;
			}
		}
		
		$value->fundStartDateCode 		= $value->fundStartDate;
		$value->fundEndDateCode 		= $value->fundEndDate;
		$value->productionStartDateCode = $value->productionStartDate;
		$value->premiereStartDateCode 	= $value->premiereStartDate;
		$value->premiereEndDateCode 	= $value->premiereEndDate;

		if (isset($value->fundStartDate)) {
			$value->fundStartDate = date('d-m-Y', ($value->fundStartDateCode/1000) );
		}
		if (isset($value->fundEndDate)) {
			$value->fundEndDate = date('d-m-Y', ($value->fundEndDateCode/1000) );
		}
		if (isset($value->productionStartDate)) {
			$value->productionStartDate = date('d-m-Y', ($value->productionStartDateCode/1000) );
		}
		if (isset($value->premiereStartDate)) {
			$value->premiereStartDate = date('d-m-Y', ($value->premiereStartDateCode/1000) );
		}
		if (isset($value->premiereEndDate)) {
			$value->premiereEndDate = date('d-m-Y', ($value->premiereEndDateCode/1000) );
		}
		
		if($value->providers){
			foreach ($value->providers as $clave => $valor) {
				$valor->advanceDateCode 		= $valor->advanceDate; 
				$valor->settlementDateCode 		= $valor->settlementDate;
				$valor->advancePaidDateCode 	= $valor->advancePaidDate;
				$valor->settlementPaidDateCode 	= $valor->settlementPaidDate;
				
				if( !is_null($valor->advanceDate) ){
					$valor->advanceDate = date('d-m-Y', ($valor->advanceDateCode/1000) );
				}
				if( !is_null($valor->settlementDate) ){
					$valor->settlementDate = date('d-m-Y', ($valor->settlementDateCode/1000) );
				}
				if( !is_null($valor->advancePaidDate) ){
					$valor->advancePaidDate = date('d-m-Y', ($valor->advancePaidDateCode/1000) );
				}
				if( !is_null($valor->settlementPaidDate) ){
					$valor->settlementPaidDate = date('d-m-Y', ($valor->settlementPaidDateCode/1000) );
				}
			}	
		}
		$value->projectFinancialData = null;
	}
	
	public static function isEditable($data, $userMiddleware){
		if($data === null){
			return false;
		}
		
		$app = JFactory::getApplication();

		$editableStatuses = array(0,2);
		$editable = in_array($data->status, $editableStatuses);
		
		if ($editable === false) {
			$url = 'index.php';
			$mensaje = JText::_('EL_STATUS_DEL_PROY').JText::_('NO_PERMITE_EDIC');
		}
		if( $data->userId != $userMiddleware ) {
			$url = 'index.php';
			$mensaje = JText::_('ITEM_DOES_NOT_EXIST');
		}
		if (isset($mensaje)) {
			$app->redirect($url, $mensaje, 'error');
		}
	}
	
	public static function getStateResult($proyId){
		$dataProyecto				 	= json_decode(@file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/tx/getProjectStatement/'.$proyId));
		$dataGral 						= self::getDatos($proyId);
		$user							= UserData::getUserJoomlaId($dataGral->userId);
		$usuario						= JFactory::getUser($user);
		$objagrupado				 	= self::agrupaIngresosEgresos($dataProyecto);
		$objagrupado				 	= self::sumatoriaIngresos($objagrupado);
		$objagrupado					= self::sumatoriaEgresos($objagrupado);
		$objagrupado					= self::operacionesEstadoResult($objagrupado,$dataGral);
		$objagrupado['proyectName'] 	= $dataGral->name;
		$objagrupado['producerName'] 	= $usuario->name;
		$objagrupado['breakeven'] 		= $dataGral->breakeven;
		$objagrupado['presupuesto'] 	= $dataGral->budget;
		$objagrupado['balance'] 		= $dataGral->balance;
		$objagrupado['tri'] 			= $dataGral->tri;
		$objagrupado['trf']	 			= $dataGral->trf;
		$objagrupado['cre'] 			= $dataGral->cre;
				
		return $objagrupado;
	}
	
	public static function agrupaIngresosEgresos($dataProyecto){
		$respuesta 	= array();
		$respuesta['ingresos'] 	= array();
		$respuesta['egresos'] 	= array();
		
		$respuesta['totalIngresos']	= 0;
		$respuesta['totalEgresos']	= 0;
		
		foreach ($dataProyecto as $key => $value) {
			switch ($value->type) {
				case 'CREDIT':
					$respuesta['ingresos'][] = $value;
					$respuesta['totalIngresos'] = $respuesta['totalIngresos']+$value->amount;
					break;
				case 'DEBIT':
					$respuesta['egresos'][] = $value;
					$respuesta['totalEgresos'] = $respuesta['totalEgresos']+$value->amount;
					break;
				default:					
					break;
			}			
		}
		
		return $respuesta;
	}
	
	public static function sumatoriaIngresos($objAgrupado){
		//Ingresos
		$objAgrupado['totFundin'] = 0;
		$objAgrupado['totInvers'] = 0;
		$objAgrupado['totVentas'] = 0;
		$objAgrupado['totPatroc'] = 0;
		$objAgrupado['toApoDona'] = 0;
		$objAgrupado['totalOtro'] = 0;
		$objAgrupado['toAporCap'] = 0;
		
		foreach ($objAgrupado['ingresos'] as $key => $value) {
			switch ($value->description) {
				case 'FUNDING':
					$objAgrupado['totFundin'] = $objAgrupado['totFundin']+$value->amount;
					break;
				case 'INVESTMENT':
					$objAgrupado['totInvers'] = $objAgrupado['totInvers']+$value->amount;
					break;
				case 'SALES':
					$objAgrupado['totVentas'] = $objAgrupado['totVentas']+$value->amount;
					break;
				case 'SPONSORSHIP':
					$objAgrupado['totPatroc'] = $objAgrupado['totPatroc']+$value->amount;
					break;
				case 'SUPPORTDONATIONS':
					$objAgrupado['toApoDona'] = $objAgrupado['toApoDona']+$value->amount;
					break;
				case 'OTHERS':
					$objAgrupado['totalOtro'] = $objAgrupado['totalOtro']+$value->amount;
					break;
				case 'CAPITALCONTRIBUTIONS':
					$objAgrupado['toAporCap'] = $objAgrupado['toAporCap']+$value->amount;
					break;
				default:
					break;
			}
		}
		
		return $objAgrupado;
	}

	public static function sumatoriaEgresos($objAgrupado){
		//egresos
		$objAgrupado['toProveed'] = 0;
		$objAgrupado['toCapital'] = 0;
		$objAgrupado['toReemCap'] = 0;
		$objAgrupado['toProduct'] = 0;
		$objAgrupado['toCostFij'] = 0;
		$objAgrupado['toCostVar'] = 0;
		
		foreach ($objAgrupado['egresos'] as $key => $value) {
			switch ($value->description) {
				case 'PROVIDERS':
					$objAgrupado['toProveed'] = $objAgrupado['toProveed']+$value->amount;
					break;
				case 'CAPITAL':
					$objAgrupado['toCapital'] = $objAgrupado['toCapital']+$value->amount;
					break;
				case 'CAPITALREPAYMENT':
					$objAgrupado['toReemCap'] = $objAgrupado['toReemCap']+$value->amount;
					break;
				case 'PRODUCER_PAYMENT':
					$objAgrupado['toProduct'] = $objAgrupado['toProduct']+$value->amount;
					break;
				case 'FEXEDCOSTS':
					$objAgrupado['toCostFij'] = $objAgrupado['toCostFij']+$value->amount;
					break;
				case 'VARCOSTS':
					$objAgrupado['toCostVar'] = $objAgrupado['toCostVar']+$value->amount;
					break;
				default:
					break;
			}
		}
		
		return $objAgrupado;
	}

	public static function operacionesEstadoresult($objagrupado, $dataGral){
		$objagrupado['resultadoIE'] 	= $objagrupado['totalIngresos']-$objagrupado['totalEgresos'];
		$objagrupado['porcVentas'] 		= ($objagrupado['totVentas'] + $objagrupado['toAporCap'])/($objagrupado['totalIngresos']==0?1:$objagrupado['totalIngresos']);
		$objagrupado['porcInver'] 		= ($objagrupado['totInvers'] + $objagrupado['totFundin'])/($objagrupado['totalIngresos']==0?1:$objagrupado['totalIngresos']);
		$objagrupado['fincol3'] 		= $objagrupado['resultadoIE'] * $objagrupado['porcVentas'];
		$objagrupado['retornos']	 	= $dataGral->tri+$dataGral->trf;
		$objagrupado['resultReden']		= $objagrupado['fincol3'] * 0.10;
		$objagrupado['resultFinan']		= $objagrupado['fincol3'] - $objagrupado['resultReden'];
		$objagrupado['resultInver']		= ($objagrupado['resultadoIE'] * $objagrupado['porcInver']);
		$objagrupado['resultComic']		= 0;
		$objagrupado['resultOtros']		= 0;
		$objagrupado['toResultado']		= $objagrupado['resultReden'] + $objagrupado['resultFinan'] + $objagrupado['resultInver'] + $objagrupado['resultComic'] + $objagrupado['resultOtros'];
		$objagrupado['porcentaTRI']		=$objagrupado['resultadoIE']/($objagrupado['totalIngresos']==0?1:$objagrupado['totalIngresos']);
		$objagrupado['porcentaTRF']		=$objagrupado['resultFinan']/($objagrupado['totalIngresos']==0?1:$objagrupado['totalIngresos']);
		
		return $objagrupado;
	}
}
?>
