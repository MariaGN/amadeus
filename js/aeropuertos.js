$(document).ready(function()
   {
        var madrid = new google.maps.LatLng(40.4167754,-3.7037902);
        var instituto = new google.maps.LatLng(42.878676,-8.547272);

        var opcionesMapa = {
           center: instituto,
           zoom: 16,
           mapTypeId: google.maps.MapTypeId.ROADMAP  //SATELLITE
   };
   
   //document.getElementById('mimapa'); así en javascript
   mapa = new google.maps.Map(document.getElementById('mimapa'),opcionesMapa);
   
   //Creamos un marcador para el Instituto
   var marcaInstituto = new google.maps.Marker(
   {
       map: mapa,//indicar o mapa onde queremos poñer o marcador
       draggable: true, //poder mover o sitio, se false, non se pode
       animation: google.maps.Animation.DROP, //salta
       position: instituto,
       title: 'IES an Clemente'
   });//marcaInstituto
   
   //Programamos que al hacer click en el marcador del instituto haga una animación (objeto,evento,función)
   google.maps.event.addListener(marcaInstituto,'click',function(){
       if(marcaInstituto.getAnimation()!= null) //se está en movemento
           marcaInstituto.setAnimation(null);
       else
           marcaInstituto.setAnimation(google.maps.Animation.BOUNCE);
   });
   
});