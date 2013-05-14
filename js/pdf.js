$(document).ready(function()
{

  // $("#imprimircarnet").click(function()
  // {
  //    // header('Location:generarpdf.php');
   //   window.location='http://www.mariagn.local/amadeus/generarpdf.php';
   //});

$("#imprimircarnet").click(function(evento)
{
    evento.preventDefault();

    $.post("peticiones.php?op=4",function(respuesta){
        // gestionar los datos recibidos...
        // Creamos un objeto persona con el JSON que recibimos de la petición AJAX
        var persona=jQuery.parseJSON(respuesta);



            // Cubrimos los campos del formulario.
            $("#nick").html(persona.nick);

            $("#nombre").html(persona.nombre);
            $("#apellidos").html(persona.apellidos);
            $("#dni").html(persona.dni);
            $("#email").html(persona.email);
            $("#telefono").html(persona.telefono);

          if (persona.token=='ldap')
            {
                // Indicamos que son datos obtenidos de LDAP.
                $("#titulo").append(" (usuario LDAP).");
                // Sólo permitimos modificar los campos:
                // DNI y teléfono. Desactivamos los otros.
                $("#password").attr("disabled","disabled");
                $("#nombre").attr("disabled","disabled");
                $("#apellidos").attr("disabled","disabled");
                $("#email").attr("disabled","disabled");
            }

            if (persona.token=='twitter')
            {
                // Indicamos que son datos obtenidos de LDAP.
                $("#titulo").append(" (usuario TWITTER).");
                // Sólo permitimos modificar los campos:
                // DNI y teléfono. Desactivamos los otros.
                $("#password").attr("disabled","disabled");
                $("#nombre").attr("disabled","disabled");
            }

        });
    });



    $("#imprimir").click(function()
    {
       window.location='carnet.php?parametro=1';
    });

    $("#enviar").click(function()
    {
        window.location='carnet.php';
    });

});
