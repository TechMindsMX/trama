<div id="datos_finanzas_proy">
	<h2><?php echo JText::_('LABEL_FINANZAS'); ?></h2>
	<fieldset class="fieldset">
	<LEGEND class="legend">
	<label class="label_public" for="priv"><?php echo JText::_('DATA_PUBLIC'); ?></label>
	<div class="radios_public">
	<input 
		type="radio" 
		name="numberPublic" 
		value="1" 
		id="numberPublic" 
		<?php echo $checkednumbers?'checked="checked"':'';?>>Si</input>
	<input 
		type="radio" 
		name="numberPublic" 
		value="0" 
		id="numberPublic"
		<?php echo $checkednumbers?'':'checked="checked"';?>>No</input>
	</div>
	</LEGEND><br />	
	
	<div><a href="#"><?php echo JText::_('PLANTILLAS_EXCEL'); ?></a></div>
	
	<label for="plantilla"><?php echo JText::_('BUSINESS_CASE'); ?>*:</label> 
	<input type="file" class="<?php echo $validacion; ?>" id="plantilla" name="businessCase"> 
	<br />
	
	<label for="presupuesto"><?php echo JText::_('PRESUPUESTO').JText::_('PROYECTO'); ?>*:</label> 
	<input 
		type="number" 
		class="validate[required]"
		id="presupuesto"
		value="<?php echo isset($objDatosProyecto) ? $objDatosProyecto->budget : ''; ?>"
		name="budget" /> 
	<br /> 
	
	<br /> <?php echo JText::_('PRECIOS_SALIDA').JText::_('PROYECTO')?>*: 
	<br />
	<br /> 
	
	<label for="seccion"><?php echo JText::_('SECCION'); ?>*:</label>
	<input 
		type="text" 
		id="seccion" 
		class="validate[required,custom[onlyLetterNumber]]"
		value="<?php echo isset($objDatosProyecto) ? $datosRecintos[0]->section : ''; ?>" 
		name="section"> 
	<br />
	
	<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
	<input 
		type="text" 
		id="unidad" 
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($objDatosProyecto) ? $datosRecintos[0]->unitSale : ''; ?>" 
		name="unitSale"> 
	<br> 
	
	<label for="inventario"><?php echo JText::_('INVENTARIOPP'); ?>*:</label>
	<input 
		type="text"
		id="inventario" 
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($objDatosProyecto) ? $datosRecintos[0]->unit : ''; ?>"  
		name="capacity"> 
	<br />
	<br />
	
	<?php
		for($i = 1; $i < $countunitSales; $i++) {
			$valorSection = isset($objDatosProyecto) ? $datosRecintos[$i]->section : '';
			$valorUnitSales = isset($objDatosProyecto) ? $datosRecintos[$i]->unitSale : '';
			$valorCapacity = isset($objDatosProyecto) ? $datosRecintos[$i]->unit : '';
			
			$unitsales = '<label for="seccion_E'.$i.'">'.JText::_('SECCION').'*:</label>';
			$unitsales .= '<input'; 
			$unitsales .= '		type = "text"'; 
			$unitsales .= '		id = "seccion_E'.$i.'"'; 
			$unitsales .= '		class = "validate[required,custom[onlyLetterNumber]]"'; 
			$unitsales .= '		value = "'.$valorSection.'"';
			$unitsales .= '		name = "section_E'.$i.'"/>'; 
			$unitsales .= '	<br />';
				
			$unitsales .= '	<label for="unidad_E'.$i.'">'.JText::_('PRECIO_UNIDAD').'*:</label>'; 
			$unitsales .= '	<input ';
			$unitsales .= '		type="text" ';
			$unitsales .= '		id="unidad_E'.$i.'" ';
			$unitsales .= '		class="validate[required,custom[onlyNumberSp]]"';
			$unitsales .= '		value="'.$valorUnitSales.'"';
			$unitsales .= '		name = "unitSale_E'.$i.'" />'; 
			$unitsales .= '	<br> ';
				
			$unitsales .= '	<label for="inventario_E'.$i.'">'.JText::_('INVENTARIOPP').'*:</label>';
			$unitsales .= '	<input ';
			$unitsales .= '		type="text" id="inventario"';
			$unitsales .= '		id="inventario_E'.$i.'" ';
			$unitsales .= '		class="validate[required,custom[onlyNumberSp]]"';
			$unitsales .= '		value="'.$valorCapacity.'"';
			$unitsales .= '		name = "capacity_E'.$i.'" />'; 
			$unitsales .= '	<br />';
			$unitsales .= '	<br />';
			
			echo $unitsales;
		}
	?>
	 
	<span id="writeroot"></span> 
	<input type="button" class="button" onclick="moreFields()" value="<?php echo JText::_('AGREGAR_CAMPOS')?>" /> <br /> 
	<br /> 
	
	<label for="potenicales"><?php echo JText::_('INGRESOS_POTENCIALES').JText::_('PROYECTO'); ?>*:</label> 
	<input 
		type="number" 
		id="potenciales"
		class="validate[required,custom[onlyNumberSp]]"
		value="<?php echo isset($objDatosProyecto) ? $objDatosProyecto->revenuePotential : ''; ?>"
		name="revenuePotential"
		step="any" /> 
	<br>
	
	<label for="equilibrio"><?php echo JText::_('PUNTO_EQUILIBRIO'); ?>*:</label>
	<input
		type = "number" 
		id = "equilibrio"
		class = "validate[required,custom[onlyNumberSp]]"
		value = "<?php echo isset($objDatosProyecto) ? $objDatosProyecto->breakeven : ''; ?>"
		name = "breakeven"
		step="any" /> 
	<br>
	
	<label for="productionStartDate"><?php echo JText::_('FECHA_INICIO_PRODUCCION')?>*:</label> 
	<input
		type = "text" 
	    id = "productionStartDate" 
	    class = "validate[required, custom[date], custom[funciondate]]"
	    value = "<?php echo isset($objDatosProyecto) ? $objDatosProyecto->productionStartDate : ''; ?>" 
	    name = "productionStartDate" /> 
	<br>
	
	<label for="premiereStartDate"><?php echo JText::_('FECHA_FIN_INICIO')?>*:</label> 
	<input 
		type = "text" 
	    id = "premiereStartDate" 
	    class = "validate[required, custom[date], custom[fininicio]]"
	    value = "<?php echo isset($objDatosProyecto) ? $objDatosProyecto->premiereStartDate : ''; ?>" 
	    name = "premiereStartDate" />
	       
	<br> 
	
	<label for="premiereEndDate"><?php echo JText::_('FECHA_CIERRE')?>*:</label> 
	<input 
		type = "text" 
		id = "premiereEndDate" 
		class = "validate[required, custom[date], custom[cierre]]"
		value = "<?php echo isset($objDatosProyecto) ? $objDatosProyecto->premiereEndDate : ''; ?>" 
		name = "premiereEndDate">
	<br /> 
	<br />
	
	<label for="tags"><?php echo JText::_('KEYWORDS'); ?><br /><span style="font-size: 12px;">(separarlas por comas)</span></label>
	<textarea id="tagsArea" name="tags" cols="60" rows="5"><?php
		if( isset($objDatosProyecto) && !empty($objDatosProyecto->tags)) {
			foreach ($objDatosProyecto->tags as $key => $value) {
				$array[] = $value->tag;
			}
			$tags = implode($array, ', ');
			echo $tags;
			
		}else {
			echo '';
		}
	?></textarea>
	</fieldset>
	</div>