<?php 

/**
 *  Botones de navegación tipo wizard, formularios de perfil
 */
class NavPefil extends getDatosObj {
	
	protected $links = '';
	
	function __construct($params) {
		$this->setParams($params);
		
		$this->getDatos();
		
		$this->deshabilita();

		$this->itemidnumber = 199;
		$itemid = '&Itemid='.$this->itemidnumber;
		$this->links['general']['enlace'] = 'index.php?option=com_jumi&view=application&fileid=5'.$itemid;
		$this->links['general']['texto'] = JText::_('PERFIL_NAV_GENERALES');
		$this->links['empresa']['enlace'] = 'index.php?option=com_jumi&view=application&fileid=13'.$itemid;
		$this->links['empresa']['texto'] = JText::_('PERFIL_NAV_EMPRESA');
		$this->links['contacto']['enlace'] = 'index.php?option=com_jumi&view=application&fileid=16'.$itemid;
		$this->links['contacto']['texto'] = JText::_('PERFIL_NAV_CONTACTO');
var_dump($this);
	}
	
	function setParams($params)	{
		foreach ($params as $key => $value) {
			$this->params->$key = $value;
		}
	}
	
	function getDatos() {
		$tipoContacto = 1;
		$this->datGen = $this->datosGenerales($this->params->idUsuario, $tipoContacto);
		$this->params->idPersona = $this->datGen->id;
		$this->datGen->direccion = $this->domicilio($this->params->idPersona, 1);
		$this->perJuridica = $this->datGen->perfil_personalidadJuridica_idpersonalidadJuridica;
	}
	
	function deshabilita() {
		$esEmpresa = array(2,3);
		$this->disabledEmpresa = in_array($this->perJuridica, $esEmpresa) ? false : true;
		$this->disabledContact = !isset($this->datGen->direccion->nomCalle);
	}
	
	function navWizardHtml() {

		$disabledClass = ' btn-disabled';

		$html = '
		<ul class="menu barra-top">
			<li class="item-'.$this->itemidnumber.'">'.
			'<a href="'.$this->links['general']['enlace'].'">'.
			$this->links['general']['texto'].'
			</a>';
		$html .= '</li>';
		
		if(empty($this->disabledEmpresa)) {
			$html .= '<li class="item-'.$this->itemidnumber.'">'.
						'<a href="'.$this->links['empresa']['enlace'].'">'.
						$this->links['empresa']['texto'].'
						</a>'.
						'</li>';
		} else {
			$html .= '<li class="item-'.$this->itemidnumber.$disabledClass.'">'.
						$this->links['empresa']['texto'].
						'</li>';
		}
			
		if(empty($this->disabledContact)) {
			$html .= '<li class="item-'.$this->itemidnumber.'">'.
						'<a href="'.$this->links['contacto']['enlace'].'">'.
						$this->links['contacto']['texto'].'
						</a>'.
						'</li>';
		} else {
			$html .= '<li class="item-'.$this->itemidnumber.$disabledClass.'">'.
						$this->links['contacto']['texto'].
						'</li>';
		}
		$html .= '</ul>';
		
		return $html;
	}
}

?>