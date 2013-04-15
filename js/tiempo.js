$(document).ready(function(){

$("#tiempo").click(function()
{
    $.post("peticiones.php?op=11",{localidad:$("#origen").val()}, function(resultado)
    {
        
        if( $("#origen").val()!='' )
        {
        
        
            var tiempo=jQuery.parseJSON(resultado);

            $("#botontiempo").html(tiempo.current_observation.weather);


            listado="<h3>Tiempo.</h3>";
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