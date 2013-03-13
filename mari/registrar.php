<script type="text/javascript" src="js/registro.js"></script>
<div class="wrapper">

	       <div class="grids top">

		    <div class="grid-6 grid">
			<h4>Ventajas como usuario registrado</h4>
	       <div>
		    <p class="bottom">
		    <ul>
			 <li>Billetes + baratos</li>
			 <li>Low cost airlines</li>
			 <li>Todas las compañías aéreas</li>
			 <li>Volamos a todo el mundo</li>
			 <li>Número ilimitado de reservas</li>
			 <li>Notificaciones automáticas de su reserva</li>
			 <li>Información de cambios</li>
			 <li>Mapas de aeropuertos</li>
			 <li>Información meteorológica en destino</li>
			 <li>Etc...</li>
		    </ul>
		    </p>
			 </div>
		    </div>




		    <!--===============================================================  Contact form =====================================================================================-->
		    <div class="grid-10 grid">

			 <h2>Formulario de registro</h2>
                        <p>
                              <div id="mensajes"></div>
                         </p>
			 <form  action="#" name="formulario" id="formulario" method="post">
                              <table class="form">
                                   <tr>
					<th>
					     <label for="nick">
						  Nick
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="nick" name="nick" required="required" />

					</td>
				   </tr>
                                    <tr>
					<th>
					     <label for="password">
						  Contraseña
					     </label>
					</th>
					<td>
					     <input class="input_full" type="password" id="password" name="password" required="required" />

					</td>
				   </tr>
                                    <tr>
					<th>
					     <label for="name">
						  Nombre
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="nombre" name="nombre" required="required" />

					</td>
				   </tr>
                                   <tr>
					<th>
					     <label for="surname">
						  Apellidos
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="apellidos" name="apellidos" required="required" />

					</td>
				   </tr>
                                   <tr>
					<th>
					     <label for="dni">
						  DNI
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="dni" name="dni" required="required" />

					</td>
				   </tr>
				  
				   <tr>
					<th>
					     <label for="email">
						  Email
					     </label>
					</th>
					<td>

					     <input class="input_full" type="email" id="email" name="email" required="required" />
					</td>
				   </tr>

				   <tr>

					<th>
					     <label for="tel">
						  Telefono
					     </label>
					</th>
					<td>
					     <input class="input_full" type="tel" id="telefono" name="telefono" required="required" />
					</td>
				   </tr>
                              </table>

                              <p>
				   <input type="submit" value="Enviar" class="float_left" />
				   <input type="reset"  value="Borrar" class="float_right">
                              </p>
                              
                              
                              
                               <p>
                                    <div id="errores" class="verdes"></div>
                              </p>
                              
			 </form>


		    </div><!--end of grid-10-->
	       </div><!--end of grids-->