<script type="text/javascript">  
  
    
    
    $(document).ready(function(){
       //alert("Documento preparado!");
      
      
      
      
      
      $("#telefono").val("981-");
       
       //alert($("#telefono").val());
       
       $("#e-mail").click(function(){
          $("#e-mail").val("@");
          //outra forma seria a seguinte
          //$(this).val("@");
       });
       
       
       
       
       
       
       
        $("#nombre").blur(function(){
            if($(this).val()==""){
                //falla o focus , ainda que funciona en chrome
                // $(this).focus();
               // alert ("El campo nombre es obligatorio");
               //outra forma: metemos un div despois dos botons e accedemos aqui o mensaxe
               $("#mensajes").hide().html("El campo nombre es obligatorio").fadeIn(1000)
               .css("background-color","red")
               .delay(2000).fadeOut(1000,function(){
                   $("#nombre").focus();
                });
               //programar que espere ese tempo, sería asi:
              // .fadeIn(1000,function(){
               //    alert("termino el FadeIn");
               //    $(this).css("color","red");
              // });
            
            }
        });
        
        
        
        
        
       // $("#nick").keyup(function(){
         //   alert("peticion ajax ...");
        //});
        
        $("#nick").blur(function(){
          // $("#mensajes").load("pasos.txt").fadeIn();
          
          //outra forma serían as seguintes tres liñas          
          $.get("pasos.txt",function(resultado){
              $("#mensajes").html(resultado).fadeIn();
          });
          
          
          
          
         
          $.post("chequearnick.php",{nick: $("#nick").val()},function(respuesta){
              
             if(respuesta == "Nick en uso") {
                 setTimeout('$("#nick").focus()',0);
             }
          });
          
          
          
          
        });
        
        
        
        
            
        
        
        
        
        $("#nick").keyup(function(){
          
            $.post("chequearnick.php",{nick:$("#nick").val()},function(respuesta){
                
                if (respuesta=="Nick en uso"){
                    $("#nick").css("background-color","red");
                    $("#mensajes").clearQueue().fadeTo(0,0).html(respuesta)
                .css("background-color","red").fadeTo(500,1).fadeTo(500,0);
                }
                
                else
                    $("#nick").css("background-color","green");
            });
            
        });
        
        
        
        
        
        
        
    });
    
    
    
    
    
    
      
      
     
    
    
    
    
    
    
    
    
 </script>
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
			 <form  action="#" method="post" enctype="multipart/form-data" onsubmit="return false">
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

					     <input class="input_full" type="email" id="e-mail" name="e-mail" required="required" />
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
                                    <div id="mensajes"></div>
                              </p>
                              
                               <p>
                                    <div id="errores" class="verdes"></div>
                              </p>
                              
			 </form>


		    </div><!--end of grid-10-->
	       </div><!--end of grids-->