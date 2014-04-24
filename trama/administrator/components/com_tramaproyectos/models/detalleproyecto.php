<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');

class TramaProyectosModelDetalleProyecto extends JModelList {
	public function getDetalleProyecto() {
		$temporal = JFactory::getApplication() -> input;
		$temporal = $temporal -> get('id');

		$datos = JTrama::getDatos($temporal);

		self::getAutorizable($datos);

		return $datos;
	}

	static function getAutorizable($datos) {
		self::sumProviders($datos);
		// verifica que existan breakeven, budget, revenuePotential dados de alta en el proyecto
		$finData = array($datos -> breakeven, $datos -> budget, $datos -> revenuePotential);
		$finDataResult = count($finData) != count(array_filter($finData));
		$datos -> con['TP_FINANC_DATA'] = !$finDataResult;

		// verifica que exista al menos un proveedor dado de alta en el proyecto
		$datos -> con['TP_PROVEEDORES'] = !empty($datos -> providers);
		// verifica que existan costos variables dados de alta en el proyecto
		$datos -> con['TP_COSTOS_VARI'] = !empty($datos -> variableCosts);
		// verifica que exista inventario dado de alta en el proyecto
		$datos -> con['TP_INV_INICIAL'] = !empty($datos -> projectUnitSales);
		// verifica que el breakeven calcualdo sea igual al breakeven dado de alta
		$calcBE = number_format($datos -> calculatedBreakeven, 0);
		$BE = number_format($datos -> breakeven, 0);
		$deltaBE = 5;
		$datos -> con['BE_VS_CALC_BE'] = ($BE <= ($calcBE + $deltaBE)) && ($BE >= ($calcBE - $deltaBE));
		// verifica que la suma de los proveedores sea igual al presupuesto dado de alta
		$datos -> con['BUDG_VS_CALC_BUDG'] = number_format($datos -> budget, 0) == number_format($datos -> calcBudget, 0);

		self::getFinancialTable($datos);
		
		//Verifica si hay algún dato faltante y asigna boolean a la propiedad
		$datos -> autorizable = !in_array(false, $datos -> con);
	}

	static function getFinancialTable($datos) {
		$igual = $datos -> con['BE_VS_CALC_BE'] ? 'color: green;' : 'color: red;';
		$html = '<div class="tablaFinan" style="' . $igual . '">
				<p>' . JText::_('TP_BE') . ' = <span class="number">' . number_format($datos -> breakeven, 2) . '</span></p>
				<p>' . JText::_('TP_CALC_BE') . ' = <span class="number">' . number_format($datos -> calculatedBreakeven, 2) . '</span></p>
				</div>';

		$igual = $datos -> con['BUDG_VS_CALC_BUDG'] ? 'color: green;' : 'color: red;';
		$html .= '<div class="tablaFinan" style="' . $igual . '">
				<p>' . JText::_('TP_BUDGET') . ' = <span class="number">' . number_format($datos -> budget, 2) . '</span></p>
				<p>' . JText::_('TP_CALC_BUDGET') . ' = <span class="number">' . number_format($datos -> calcBudget, 2) . '</span></p>
				</div>';

		$datos -> financialTable = $html;
	}

	static function sumProviders($datos) {
		$calcBudget = 0;
		foreach ($datos -> providers as $key => $value) {
			$calcBudget += $value -> advanceQuantity + $value -> settlementQuantity;
		}
		$datos -> calcBudget = $calcBudget;
	}

}
