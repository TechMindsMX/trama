<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
jimport("trama.class");
jimport("trama.jsocial");
require_once 'components/com_jumi/files/perfil_usuario/usuario_class.php';
$input = JFactory::getApplication()->input;
$userid = $input->get("userid",0,"int");
$objuserdata = new UserData;

$usuario = JFactory::getUser();
$userid = ($userid==0)? $usuario->id: $userid ;
$document = JFactory::getDocument();
$base = JUri::base();
$proyectos = JTrama::getProjectsByUser($userid);		 
$pathJumi = $base.'components/com_jumi/files/perfil_usuario/';
$document->addStyleSheet($pathJumi.'css/style.css');

$datosgenerales = $objuserdata::datosGr($userid);

if(is_null($datosgenerales)){
	$redirect = JFactory::getApplication();
	$redirect->redirect('index.php', 'No hay datos de usuario','notice');
}

$id_datos_generales = $datosgenerales->id;

$proyectos_pasados = $objuserdata::pastProjects($id_datos_generales);
$promedio = $objuserdata->scoreUser($userid);

?>

    <body>
        
      <script type="text/javascript" src="components/com_jumi/files/crear_proyecto/js/raty/jquery.raty.js"></script>
        
      <div id="contenido"><?php echo JTramaSocial::addFriendJS($userid, $usuario); ?>
      	
      	<div id="raty">
      	 <div id="datos">
		       <?php 
		      echo $datosgenerales->nomNombre." ".$datosgenerales->nomApellidoPaterno;
		       
		       ?>
		       </div>
		       	<div id="calif"></div>
				<div id="texto"><?php echo number_format($promedio->score ,1); ?></div>
				<div style="clear: both"></div>
			</div>
			
			<section class="ac-container">
				<div id="foto"><img src="<?php echo $datosgenerales->Foto; ?>"  /></div>
				<div>
					<div style="clear: both"></div>
					<input id="ac-2" name="accordion-1" type="radio" />
					<label for="ac-2">Perfil Extendido</label>
					<article class="ac-medium">
						<p>
						<?php
						 $objuserdata->generacampos(0, 'perfilx_catalogoperfil', 'idcatalogoPerfil', 'idcatalogoPerfilPadre', 'nomNombreCategoria', 'respuestaPerfil', $userid); 
						 ?>
						 </p>
					</article>
				</div>
				<div>
					<input id="ac-3" name="accordion-1" type="radio" />
					<label for="ac-3">Funciograma</label>
					<article class="ac-large">
						<p>
							<?php $objuserdata->generacampos(0, 'perfilx_catalogofuncion', 'idcatalogoFuncion', 'idcatalogoFuncionPadre', 'nomNombreCategoria', 'respuestaFuncion', $userid); ?>
						 </p>
					</article>
				</div>
				<div>
					<input id="ac-4" name="accordion-1" type="radio" />
					<label for="ac-4">Producci&oacute;n</label>
					<article class="ac-large">
						<p>
							<?php $objuserdata->generacampos(0, 'perfilx_catalogoproduccion', 'idcatalogoProduccion', 'idcatalogoProduccionPadre', 'nomNombreCategoria', 'respuestaProduccion', $userid); ?>
						 </p>
					</article>
				</div>
			</section>
       
   
		       
		       
			<section class="ac-container2">
				
				<div>
					<input id="ac-2a" name="accordion-2" type="radio" checked />
					<label for="ac-2a">Descripci&oacute;n</label>
					<article class="ac-medium">
						<p> 
							<?php 
		      					echo $datosgenerales->dscDescripcionPersonal;		       
		       				?>	
						</p>
					</article>
				</div>
				<div>
					<input id="ac-3a" name="accordion-2" type="radio" />
					<label for="ac-3a">Curr&iacute;culum</label>
					<article class="ac-large">
						<p>
							<?php 
		      					echo $datosgenerales->dscCurriculum;		       
		       				?>		
						</p>
					</article>
				</div>
				<div>
					<input id="ac-4a" name="accordion-2" type="radio" />
					<label for="ac-4a">Proyectos pasados</label>
					<article class="ac-large">
						<p>
							<?php 
								foreach ($proyectos_pasados as $key => $value) {
		      					
								echo '<a href="'.$value->urlProyectosPasados.'" target="_blank">'.$value->nomNombreProyecto.'</a>';		
								echo "<br />" ; 
								echo "<br />"  ;   
								echo $value->dscDescripcionProyecto;		
								echo "<br />"  ;   
								echo "<br />"  ;  
								}   
		       				?>	
						</p>
					</article>
                    </div>
                    <div>
                    <input id="ac-5a" name="accordion-2" type="radio" />
					<label for="ac-5a">Proyectos actuales</label>
					<article class="ac-large">
						<p>
							<?php 
								foreach ($proyectos as $key => $value) {
								echo "<ul>";	
								echo '<li><a href="index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$value->id.'"  >'.$value->name.'</a></li>';
								echo "</ul>";
								}							
							?>							
						</p>
					</article>
				</div>
				
			</section>
        <div style="clear: both"></div>
       </div>
       
       <script type="text/javascript">
		var ruta = "components/com_jumi/files/crear_proyecto/js/raty/img/"
		 
		jQuery(document).ready(function () {
			jQuery('#calif').raty({
				click: function (score) {
					var request = $.ajax({
		     			url:"components/com_jumi/files/busqueda/ajax.php",
		 				data: {
		  					"score": score,
		  					"calificador": <?php echo $usuario->id; ?>,
		  					"calificado": <?php echo $userid; ?>,
		  					"fun": 1
		 				},
		 				type: 'post'
					});
		
					request.done(function(result){
			 			obj = eval('(' + result + ')');
			 			promedio = parseFloat(obj.score);
			 
			 			jQuery('#calif').raty({
			  				readOnly: true,
			  				path  : ruta,
			  				score  : obj.score,
			  				target  : '#texto',
			  				targetText : promedio.toFixed(1)
			 			});
					});
			
					request.fail(function (jqXHR, textStatus) {
			 			console.log('Surguieron problemas al almacenar tu calificación');
			    	});
			   },
			   score  : <?php echo $datosgenerales->score; ?>,
			   path  : ruta
			});
		});
		</script>
    