$(document).ready(function(){




  
        $("#origen").keyup(function()
        {
            // Averiguamos el nombre del objeto dónde estamos escribiendo.
            casillaclick=$(this).attr('id');

            $.post("peticiones.php?op=8",{
                aeropuerto:$(this).val()
            },function(datos){
                // Convierte a objeto de Javascript el JSON recibido desde PHP.
                aeropuertos = jQuery.parseJSON(datos);
                listado='';

                // Recorremos el array.
                $.each(aeropuertos,function(index,valor)
                {
                    // En index tenemos del 0 al 10 como máximo.
                    // En valor tendremos el objeto con todas sus prop.
                    listado+="<li>"+valor.aeropuerto+", "+valor.ciudad+" - "+valor.pais+"("+valor.iata+")</li>";
                });

                if (aeropuertos.length !=0)
                    $("#zonasugerencias").addClass("zonaconborde");
                else
                    $("#zonasugerencias").removeClass("zonaconborde");

                // Metemos en el contenedor el listado generado con <li>...
                $("#zonasugerencias").html(listado);

                $("#zonasugerencias li").each(function()
                {
                    $(this).mouseover(function()
                    {
                        $(this).addClass("enlace_sugerencia_over");
                    });

                    $(this).mouseout(function()
                    {
                        $(this).removeClass("enlace_sugerencia_over");
                    });

                    $(this).click(function()
                    {
                        $("#"+casillaclick).val($(this).text());

                        // Necesitamos averiguar la posición dónde hemos hecho click, 
                        // para poder ir al array aeropuertos y coger los datos de latitud y longitud de ese aeropuerto.
                        // $(this).parent().children().index($(this));
                        posiciondeclick=$(this).parent().children().index($(this));



                        // Ocultamos el div de sugerencias
                        $("#zonasugerencias").removeClass("zonaconborde").html("");
                        



                        $.post("peticiones.php?op=11",{pais:aeropuertos[posiciondeclick].pais,localidad:aeropuertos[posiciondeclick].ciudad}, function(resultado)
                               {

                                       var tiempo=jQuery.parseJSON(resultado);

                                       if('error' in tiempo.response)
                                       {          
                                           $("#botontiempo").html('No existe la localidad');
                                       }

                                       else
                                       {    

                                           $("#botontiempo").html(tiempo.current_observation.weather);


                                           listado="<h3 >Tiempo.</h3>";
                                           listado+="<table border='1'><thead><th>DIA</th><th>PREVISION</th><th>TEMPERATURA</th></thead>"; 
                                                    $.each(tiempo.forecast.simpleforecast.forecastday, function(index, valores)
                                                    {
                                                        listado+="<tr align='center'><td>"+tiempo.forecast.simpleforecast.forecastday[index].date.pretty+"</td><td>"+tiempo.forecast.simpleforecast.forecastday[index].conditions+"</td><td>Max:"+tiempo.forecast.simpleforecast.forecastday[index].high.celsius+", Min:"+tiempo.forecast.simpleforecast.forecastday[index].low.celsius+"</td></tr>";
                                                    });
                                            listado+="</table>";


                                           $("#botontiempo").html(listado);        

                                       }  

                               });

    
    
    
    
    
    
    
                        
                        
                        
                    });

                });

            });

        });
    
    
    
    

       
   
   
   
   
   
   
});




//Esto non porque seria a peticion directa a wunderground
//$(document).ready(function($) {
 //   $.ajax({ 
  //      url : "http://api.wunderground.com/api/9818492157481090/geolookup/q/SCQ.json",
  //          dataType : "jsonp", 
   //         success : function(parsed_json) 
    //            { var location = parsed_json['location']['city'];
    //                var temp_f = parsed_json['current_observation']['temp_f'];
     //               alert("Current temperature in " + location + " is: " + temp_f);
      //          } 
     //       }); 
       // });