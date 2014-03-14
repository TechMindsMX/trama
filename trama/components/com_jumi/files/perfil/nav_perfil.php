<?php 

/**
 *  Botones de navegación tipo wizard, formularios de perfil
 */
class NavPefil {
	
	protected $links = '';
	public $existe;
	
	function __construct($fileid, $existe, $generales, $data) {
		$this->perJuridca = $generales->perfil_personalidadJuridica_idpersonalidadJuridica;
		$this->data = $data;
		
		$this->itemidnumber = 199;
		$itemid = '&Itemid='.$this->itemidnumber;
		$this->links['general']['enlace'] = 'index.php?option=com_jumi&view=application&fileid=5'.$itemid;
		$this->links['general']['texto'] = JText::_('PERFIL_NAV_GENERALES');
		$this->links['empresa']['enlace'] = 'index.php?option=com_jumi&view=application&fileid=13'.$itemid;
		$this->links['empresa']['texto'] = JText::_('PERFIL_NAV_EMPRESA');
		$this->links['contacto']['enlace'] = 'index.php?option=com_jumi&view=application&fileid=16'.$itemid;
		$this->links['contacto']['texto'] = JText::_('PERFIL_NAV_CONTACTO');
		
		$this->existe = $existe;
	}
	
	function navWizardHtml() {

		$disabledClass = ' btn-disabled';

		$esEmpresa = array(2,3);
		$disabledEmpresa = in_array($this->perJuridca, $esEmpresa) ? false : true;
		$disabledContact = !isset($this->data);

		$html = '
		<ul class="menu barra-top">
			<li class="item-'.$this->itemidnumber.'">'.
			'<a href="'.$this->links['general']['enlace'].'">'.
			$this->links['general']['texto'].'
			</a>';
		$html .= '</li>';
		
		if(empty($disabledEmpresa)) {
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
			
		if(empty($disabledContact)) {
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