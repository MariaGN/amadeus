/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


  
    
    
    $(document).ready(function(){
       //alert("Documento preparado!");
      
      
      
      
      
      $("#telefono").val("981-");
       
       //alert($("#telefono").val());
       
       $("#email").click(function(){
          $("#email").val("@");
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
          
          
          
          
          //Operación op=1 -> chequear nick
          $.post("peticiones.php?op=1",{nick: $("#nick").val()},function(respuesta){
              
             if(respuesta == "Nick en uso") {
                 setTimeout('$("#nick").focus()',0);
             }
          });
          
          
          
          
        });
        
        
        
        
            
        
        
        
        
        $("#nick").keyup(function(){
          
            $.post("peticiones.php?op=1",{nick:$("#nick").val()},function(respuesta){
                
                if (respuesta=="Nick en uso"){
                    $("#nick").css("background-color","red");
                    $("#mensajes").clearQueue().fadeTo(0,0).html(respuesta)
                .css("background-color","red").fadeTo(500,1).fadeTo(500,0);
                }
                
                else
                    $("#nick").css("background-color","green");
            });
            
        });
        
        
        
        
       //programar evento de envio
       $("#formulario").submit(function(evento){
           evento.preventDefault();
          // $.post("pagina.php",{nick:$("#nick").val(),nombre:$("#nombre").val(),campo1:valor1, campo2:valor2 ,....},function(resultado)....) )
         
         // metodo rápido de envío con JQuery
         datos=$("#formulario").serializeArray();
         console.log(datos);
         
         //op=2 es alta de usuarios  //ver peticiones.php
         $.post("peticiones.php?op=2",datos,function(resultado){
              //quitamos a comparacion do if dado que xa non temos nunca a mensaxe OK, kitamos en basedatos.php
            // if(resultado=="OK"){
                 $("#formulario").fadeOut(function(){
                     $("#mensajes").fadeTo(0,0).css("background-color","green").html(resultado).fadeTo(1,1);
                 });
             //}
         });
       });
        
        
        
        
        
        
        
    });
    