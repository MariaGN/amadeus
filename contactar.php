<script type="text/javascript" src="js/contactar.js"></script>
<div class="wrapper">

	       <div class="grids top">

		    <div class="grid-6 grid">
			 <h2>Dirección</h2>
			 <div>
			      <p class="bottom">
				   IES San Clemente<br />
				   C./ San Clemente s/n.<br />
				   Santiago de Compostela<br />
				   Spain<br /><br />
				   Telefono: +34 981 580 496<br />
				   Fax: +34 981 580 366<br />
                                   Email: proteger@este-email
                              </p>
			 </div>



		    </div>

    <!--===============================================================  Contact form =====================================================================================-->
		    <div class="grid-10 grid">

			 <h2>Contacto</h2>
			 <form  action="#" method="post" enctype="multipart/form-data" onsubmit="return false" name="formulario" id="formulario">
                              <table class="form">
				   <tr>
					<th>
					     <label for="name">
						  Nombre
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="name" name="name" required="required" />

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
					     <input class="input_full" type="tel" id="tel" name="tel" required="required" />
					</td>
				   </tr>

				   <tr>
					<th>
					     <label for="web">
						  URL
					     </label>
					</th>
					<td>
					     <input class="input_full" type="text" id="web" name="web" placeholder="http://" />
					</td>

				   </tr>
				   <tr>
					<th>
					     <label for="asunto">
						  Asunto
					     </label>
					</th>
					<td>
					     <select class="input_full" id="asunto" name="asunto">

						  <option value="">Elegir Asunto...</option>
						  <option value="Preguntas">Preguntas</option>
						  <option value="Proyecto">Proyecto</option>
						  <option value="Feedback">Feedback</option>
						  <option value="Otros">Otros</option>

					     </select>
					</td>
				   </tr>
				   <tr>

			   </tr>
				   <tr>
					<th>

					     <label for="description">
						  Su<br />
						  mensaje
					     </label>
					</th>
					<td>
					     <textarea id="description" name="description" rows="8" required="required" placeholder="Escriba su mensaje aquí."></textarea>
					</td>

				   </tr>
				   <tr>
					<th>
					     <label for="cc">
						  <abbr title="Courtesy Copy">CC</abbr>
					     </label>

					</th>
					<td>
					     <input type="checkbox" id="cc" name="cc" value="1" />
					     <label for="cc">
						  Enviarme una copia del e-mail
					     </label>
					</td>
				   </tr>
                              </table>

                              <p>
                                  <input type="reset" value="Limpiar" class="float_right">
				   <input type="submit" value="Enviar" class="float_left" />

                              </p>
			 </form>
                         <div id="mensajes"></div>

		    </div><!--end of grid-10-->
	       </div><!--end of grids-->
  </div>