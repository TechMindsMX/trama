var counter = 0;

function moreFields() {
	counter++;
	var newFields = document.getElementById('readroot').cloneNode(true);
	newFields.id = '';
	newFields.style.display = 'block';
	var newField = newFields.childNodes;
	for (var i=0;i<newField.length;i++) {
		var theName = newField[i].name
		if (theName)
			newField[i].name = theName + counter;
	}
	var insertHere = document.getElementById('writeroot');
	insertHere.parentNode.insertBefore(newFields,insertHere);
}

jQuery(document).ready(function(){

jQuery("#form2 select").click(function() {
	
	var seleccion = jQuery(this).find('option:selected');
	temp = seleccion.text();
	bandera = jQuery(this).attr("id");
	
	if (bandera == 'selectCategoria') {
		
		var subSeleccion = jQuery('#subcategoria').find('option:selected');
		tmpSub = subSeleccion.text();
		
	} else if (bandera == 'subcategoria') {
		
		var subSeleccion = jQuery('#selectCategoria').find('option:selected');
		tmpSub = subSeleccion.text();
		
	}
	
});

jQuery("#form2 select").change(function(){

	var categoriaSeleccionada = jQuery(this).find('option:selected');
	var selectedCategoria = categoriaSeleccionada.text();
	var valortextarea = $('#tagsArea').val();

	if (valortextarea == "") {

	    $('#tagsArea').val(selectedCategoria);

	} else {

	    var arreglo = valortextarea.split(',');
	    var cuantos = arreglo.length;
	    	    
	    arrayCat = findReplace(cuantos, selectedCategoria, arreglo, temp, tmpSub);
	    valor_final = arrayCat.join(',');
	    $('#tagsArea').val(valor_final);

	}

});

function findReplace(cuantos, valor, arreglo, tmpCategoriaSeleccionada, tmpSubCategoriaSeleccionada) {

	for (var i = 0; i < cuantos; i++) {

	    if (arreglo[i] == valor || arreglo[i] == tmpCategoriaSeleccionada || arreglo[i] == tmpSubCategoriaSeleccionada) {
	    
	        arreglo[i] = valor;
	        
	        break;

	    } else if (i == cuantos-1){

	        arreglo[cuantos] = valor;

	    }

	}

	return arreglo;

}

emptyKeys();

});

function emptyKeys() {

	var valorKeysArea = $('#tagsArea').val();

	if (valorKeysArea == "") {

		var catSeleccionada = jQuery('#selectCategoria').find('option:selected');
		var selectedCat = catSeleccionada.text();
		var subCatSeleccionada = jQuery('#subcategoria').find('option:selected');
		var selectedSubCat = subCatSeleccionada.text();

		$('#tagsArea').val(selectedSubCat+','+selectedCat);

	}
	
}