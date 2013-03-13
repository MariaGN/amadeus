$(document).ready(function()
{
    //Cubrimos los campos del formulario con los datos recibidos del AJAX.
  $.post("peticiones.php?op=4",function(respuesta)
    {
        //gestionar los datos recibidos....
        //Creamos un objeto persona con el JSON  que recibimos de la peticion AJAX
        var persona=jQuery.parseJSON(respuesta);
        
        //Cubrimos los campos del formulario
        $("#nick").val(persona.nick);  //persona.nick  o nome .nick ten que corresponderse con basedatos.php en bind_result de obtenerInfoUsuario
        $("#password").val(persona.password);
        $("#nombre").val(persona.nombre);
        $("#apellidos").val(persona.apellidos);
        $("#dni").val(persona.dni);
        $("#email").val(persona.email);  
        $("#telefono").val(persona.telefono);

    });  
    //Cuando se produzca el submit...
    //hacemos la petición ajax enviando las actuallizaciones al servidor.
    
    $("#formulario").submit(function(evento)  //se fose o botón de tipo button, cambiar submit por click e a seguinte leña é innecesaria
    {
       //Cancelamos el evento por defecto de envio de datos
       evento.preventDefault();
       
       //Metemos todos los datos del formulario en la variable datos.
       var datos=$("#formulario").serializeArray();
       
       //Hacemos la peticion ajax op=5  Actualizar datos usuario logueado
       $.post("peticiones.php?op=5",datos,function(resultado)
        {
            $("#formulario").fadeOut(function()
            {
               $("#mensajes").fadeTo(0,0).css("background-color","green").html(resultado).fadeTo(500,1);
            });
        });
    });
 
 $('#bajausuario').click(function()
{
    if(confirm("¿Está seguro de darse de baja en la web?"))
        //petición ajax de borrado
            $.post("peticiones.php?op=6",function(resultado)
            {
               if(resultado=='OK')
                   window.location.href="desconectar.php"
            });
        
});
 
    
});
