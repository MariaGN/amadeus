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
                        
                        $("#tiempo").html("<img src='img/tiempo.gif'/>");


                        $.post("peticiones.php?op=11",{pais:aeropuertos[posiciondeclick].pais.replace(/ /gi,'_'),localidad:aeropuertos[posiciondeclick].ciudad.replace(/ /gi,'_')}, function(resultado)
                               {
                                       var tempo=jQuery.parseJSON(resultado);
                                       if('error' in tempo.response)
                                       {          
                                           $("#tiempo").html('No existe predicción para la localidad solicitada');
                                       }
                                       else
                                       {    
                                           $("#tiempo").html(tempo.current_observation.weather);
                                           listado="<h3 >Tiempo previsto para "+$("#origen").val().substr(val(),0,length-5)+"</h3>";
                                           listado+="<table border='1'><thead><th>DIA</th><th>PREVISION</th><th>TEMPERATURA</th></thead>"; 
                                                    $.each(tempo.forecast.simpleforecast.forecastday, function(index, valores)
                                                    {
                                                        listado+="<tr align='center'><td>"+tempo.forecast.simpleforecast.forecastday[index].date.pretty+"</td><td>"+tempo.forecast.simpleforecast.forecastday[index].conditions+"</td><td>Max:"+tempo.forecast.simpleforecast.forecastday[index].high.celsius+", Min:"+tempo.forecast.simpleforecast.forecastday[index].low.celsius+"</td></tr>";
                                                    });
                                            listado+="</table>";
                                           $("#tiempo").html(listado);  
                                           $("#origen").val('');
                                       }  
                               });
   
                        
                    });

                });

            });

        });
        
        
});



