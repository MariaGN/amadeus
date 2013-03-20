function distancia(punto1, punto2)
{
    lon1= punto1.lng().toString();
    lat1= punto1.lat().toString();
    lon2= punto2.lng().toString();
    lat2= punto2.lat().toString();

              
     
    rad = function(x) {
        return x*Math.PI/180;
    }

    var R     = 6378.137;                          //Radio de la tierra en km
    var dLat  = rad( lat2 - lat1 );
    var dLong = rad( lon2 - lon1 );

    var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;

    return d.toFixed(3);                      //Retorna tres decimales
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  function toggleBounce(nombreMarcador)
    {
       if (nombreMarcador.getAnimation() != null)
            nombreMarcador.setAnimation(null);
        else
            nombreMarcador.setAnimation(google.maps.Animation.BOUNCE); 
        
    }
    
////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
function crearMarcador(posicion,titulo)
{
    var marcador = new google.maps.Marker(
    {
        map: mapa,
        draggable: false,
        //animation: google.maps.Animation.DROP,
        position: posicion,
        title: titulo
    });
    return marcador;    
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function dibujarRuta(rutadepuntos)
{
    
     var linea=  new google.maps.Polyline(
   {
       map:mapa,
       path: rutadepuntos,
       geodesic: true,
       strokeColor: "FF0000", //cor da liña
       strokeOpacity: 1.0,
       strokeWeight: 2
   });
   return linea;
   
   //ou ben return=new google.maps.Polyline  sen reutrn ó final
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function crearInfo(contenido,marcador)
{
    var ventana= new google.maps.InfoWindow(
    {
        maxWidth:120,
        content: contenido
    });
    
    google.maps.event.addListener(marcador,'click',function(){
       ventana.open(mapa,marcador);        
    });
    
    google.maps.event.addListener(marcador,'mouseover',function(){
       ventana.open(mapa,marcador);        
    });
    
      google.maps.event.addListener(marcador,'mouseout',function(){
       ventana.close();        
    });
    
    
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function puntoMedio(punto1,punto2)
{
    lon1=parseFloat(punto1.lng().toString()); //longitud do objeto
    lat1=parseFloat(punto1.lng().toString());
    
    lon2=parseFloat(punto1.lng().toString());
    lat2=parseFloat(punto1.lng().toString());
    
    lonMedio=(lon1+lon2)/2;
    latMedio=(lat1+lat2)/2;
    
    
    return  new google.maps.LatLng(latMedio,lonMedio);
}



$(document).ready(function()
{
    // Latitud NORTE(valores +) |ecuador| SUR(valores -)
    // Longitud OESTE(valores -) |Meridiano Greenwich| ESTE (valores +) 
    // Creamos dos puntos geográficos (latitud,longitud).
    var madrid = new google.maps.LatLng(40.4167754,-3.7037902);
    var instituto = new google.maps.LatLng(42.878676, -8.547272);
    var nyork = new google.maps.LatLng(40.7143528,-74.0059731);
    var miami = new google.maps.LatLng(25.7889689,-80.2264393);
	
    // Definimos las opciones de mapa en un objeto de tipo MapOptions
    // https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var opcionesMapa ={
        center: instituto,
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.ROADMAP    
    };
    
    // document.getElementById('objeto'); //returns a HTML DOM Object
    // var contents = $('#objeto');  //returns a jQuery Object
    // Calling $('#id') will return a jQuery object that wraps the DOM object and provides jQuery methods.
    // 
    // Si queremos obtener el objeto DOM lo haríamos con:
    // var contents = $('#objeto')[0];
    // 
    // En nuestro caso:
    // document.getElementById("mimapa");
    // o tambien: $("#mimapa")[0];
    mapa = new google.maps.Map($("#mimapa")[0],opcionesMapa);
    
    
    // Creamos un objeto de tipo Market en el instituto.
    var marcaInstituto = crearMarcador(instituto,'IES San Clemente');
    var marcaMadrid = crearMarcador(madrid,'Madrid');
    
    /* var marcaMadrid = new google.maps.Marker(
    {
        map: mapa,
        draggable: false,
        animation: google.maps.Animation.DROP,
        position: madrid,
        title: 'Madrid' 
    }); así serí a sen a función*/
    
    crearInfo('Madrid, capital de España',marcaMadrid);
    
    mapa.setZoom(6);
       
       
  


    // Programamos que al hacer click en el marcador
    // del instituto haga una animación.
    google.maps.event.addListener(marcaInstituto,'click',function(){
       toggleBounce(marcaInstituto);        
    });
    
    
   //Dibujamos una linea entre instituto y madrid, 1º creamola
/*   var linea=  new google.maps.Polyline(
   {
      // map:mapa, //se comentamos non nos mostra a liña, outra forma de vela sería con nome_variable_da_poliline.setMap(nomedamapa)
       path: [instituto, madrid],
       geodesic: true,
       strokeColor: "FF0000", //cor da liña
       strokeOpacity: 1.0,
       strokeWeight: 2
   });*/
   
   //creada a función dibujar ruta
   var linea=dibujarRuta([instituto,madrid]);
   
   mapa.setCenter(puntoMedio(instituto,madrid));
   
   
    linea.setMap(mapa);
    //para OCULTAR a liña
    //linea.setVisible(false);
    ///para SACAR a liña
    //linea.setMapa(null);
    
    mensaje="<p> La distancia entre el Instituto y Madrid es de "+distancia(instituto,madrid)+" Km.</p>"
    $('#opciones').html(mensaje);
   //asi sería con javascript document.getElementById("opciones").innerHTML=mensaje;
});  // document.ready.