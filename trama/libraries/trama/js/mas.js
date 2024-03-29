var counter = 0;

function moreFields() {
	counter++;
	var newFields = document.getElementById('readroot').cloneNode(true);
	newFields.id = '';
	newFields.style.display = 'block';
    var newField = newFields.childNodes;
    for (var i=0;i<newField.length;i++) {
        jQuery(newField[i]).prop('disabled',false);
        var theName = newField[i].name;
		if (theName)
			newField[i].name = theName + counter;
	}
	var insertHere = document.getElementById('writeroot');
	insertHere.parentNode.insertBefore(newFields,insertHere);
}

jQuery(document).ready(function(){
	
	var $object = $('#tagsArea');
	if($object.length) {
		var valortextarea = $('#tagsArea').val();
	}
	jQuery("#form2 select").bind("change", function(){
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
		var $object = $('#tagsArea');
		if($object.length) {
		    putTags(valortextarea, temp, tmpSub);
		} 
	});

	function putTags(valortextarea, temp, tmpSub){
		var catSelec = jQuery('#selectCategoria').find('option:selected');
		var selectedCategoria = catSelec.text();
		var subCatSelec = jQuery('#subcategoria').find('option:selected');
		var selectedSubCategoria = subCatSelec.text();
	
	    var arreglo 	= $.map(valortextarea.split(","), $.trim);
	    var cuantos 	= arreglo.length;
	    var arrayCat 	= findReplace(cuantos, selectedCategoria, selectedSubCategoria, arreglo, temp, tmpSub);
	    var uniqueList 	= unique(arrayCat);
	    uniqueList		= uniqueList.sort();

		var valorFinal 	= uniqueList.join(',');
		
	    $('#tagsArea').val(valorFinal);
	    
	    return;
	}
	
	function unique(array) {
	    return jQuery.grep(array, function(el, index) {
	    	if (el != "") {
	        	return index == $.inArray(el, array);
	        }
	    });
	}
	
	function findReplace(cuantos, valor1, valor2, arreglo, tmpCategoriaSeleccionada, tmpSubCategoriaSeleccionada) {
		valor1 = capitaliseFirstLetter(valor1.trim());
		valor2 = capitaliseFirstLetter(valor2.trim());

		for (var i = 0; i < cuantos; i++) {
			var posArreglo = capitaliseFirstLetter(arreglo[i].trim());
			
			// Find and remove item from an array
			var indice = arreglo.indexOf(tmpCategoriaSeleccionada);
			if(indice != -1) {
				arreglo.splice(indice, 1);
			}
			var indice = arreglo.indexOf(tmpSubCategoriaSeleccionada);
			if(indice != -1) {
				arreglo.splice(indice, 1);
			}
			arreglo.push(valor1);
			arreglo.push(valor2);
			
		}
		return arreglo;
	}
	
	function capitaliseFirstLetter(string)
	{
    	return string.charAt(0).toUpperCase() + string.slice(1);
	}
	
	// emptyKeys();

});

function emptyKeys() {

	var valorKeysArea = $('#tagsArea').val();

	if (valorKeysArea == "") {

		var catSeleccionada = jQuery('#selectCategoria').find('option:selected');
		temp = catSeleccionada.text();
		var subCatSeleccionada = jQuery('#subcategoria').find('option:selected');
		tmpSub = subCatSeleccionada.text();

		$('#tagsArea').val(tmpSub+','+temp);

	}
	
}

//validacion banner
function loadImage(input1) {
    var input, file, fr, img;

    if (typeof window.FileReader !== 'function') {
        write("The file API isn't supported on this browser yet.");
        return;
    }

    input = document.getElementById(input1.id);
    if (!input) {
        write("Um, couldn't find the imgfile element.");
    }
    else if (!input.files) {
        write("This browser doesn't seem to support the `files` property of file inputs.");
    }
    else if (!input.files[0]) {
        write("Please select a file before clicking 'Load'");
    }
    else {
        file = input.files[0];
        fr = new FileReader();
        fr.onload = createImage;
        fr.readAsDataURL(file);
    }
	
	var fileInput = jQuery('#'+input1.id)[0];
    peso = fileInput.files[0].size;
	
    function createImage() {
        img = document.createElement('img');
        img.onload = imageLoaded;
        img.style.display = 'none'; // If you don't want it showing
        img.src = fr.result;
        document.body.appendChild(img);
    }

    function imageLoaded() {
    	console.log( img.width, img.height );
		if( (img.width > 1920) || (img.height > 1200) || (img.width < 800) || (img.height < 600) || (peso  > 4096000) ){
			
			
		alert ("Solo se aceptan imagenes de resolucion entre 800 x 600, 1920 x 1080 y con un peso no mayor a 4 mb, su imagen no sera subida. ");
		$fileupload = $('#'+input1.id);  
		$fileupload.replaceWith($fileupload.clone(true)); 
		$('#'+input1.id).val(""); 
        // This next bit removes the image, which is obviously optional -- perhaps you want
        // to do something with it!
        img.parentNode.removeChild(img);
        img = undefined;}
        
    }


}
//validacion avatar
function loadImage2(input1) {
    var input, file, fr, img;

    if (typeof window.FileReader !== 'function') {
        write("The file API isn't supported on this browser yet.");
        return;
    }

    input = document.getElementById(input1.id);
    if (!input) {
        write("Um, couldn't find the imgfile element.");
    }
    else if (!input.files) {
        write("This browser doesn't seem to support the `files` property of file inputs.");
    }
    else if (!input.files[0]) {
        write("Please select a file before clicking 'Load'");
    }
    else {
        file = input.files[0];
        fr = new FileReader();
        fr.onload = createImage;
        fr.readAsDataURL(file);
    }
	
	var fileInput = jQuery('#'+input1.id)[0];
    peso = fileInput.files[0].size;
	
    function createImage() {
        img = document.createElement('img');
        img.onload = imageLoaded;
        img.style.display = 'none'; // If you don't want it showing
        img.src = fr.result;
        document.body.appendChild(img);
    }

    function imageLoaded() {
		if(img.width > 1024 || img.height > 1024 || img.width < 360 || img.height < 360 || peso  > 4096000){
			
			
		alert ("Solo se aceptan imagenes de resolución entre 1024x1024 y 360x360, y con un peso no mayor a 4 mb, su imagen no sera subida. ");
		$fileupload = $('#'+input1.id);  
		$fileupload.replaceWith($fileupload.clone(true)); 
		$('#'+input1.id).val(""); 
        // This next bit removes the image, which is obviously optional -- perhaps you want
        // to do something with it!
        img.parentNode.removeChild(img);
        img = undefined;}
        
    }
}