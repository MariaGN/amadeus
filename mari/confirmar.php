<script type="text/javascript" src="js/registro.js"></script>
<div class="wrapper">

	       <div class="grids top">

		    <div class="grid-6 grid">
			<h4>Registros</h4>
                        En la zona de la derecha podrá consulttar su estado de registro.
                    </div>
	      

		    <!--===============================================================  Contact form =====================================================================================-->
		    <div class="grid-10 grid">

			 <h2>Confirmación del registro</h2>
                            <?php
                            //Cargamos la clase basedatos.
                            require_once 'lib/basedatos.php';
                            
                            
                            //Creamos el objeto de basedatos
                            $mibase=Basedatos::getInstancia();
                            
                            //Llamamos al método confirmarRegistro de la clase basedatos
                            echo $mibase->confirmarRegistro($_GET['nick'],$_GET['token']);
                            
                            ?>

		    </div><!--end of grid-10-->
	       </div><!--end of grids-->