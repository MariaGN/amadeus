$(document).ready(function()
{

    $("#imprimircarnet").click(function(evento)
    {
    evento.preventDefault();

    //modificar datos usuario
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


    //opciones de imprimir o enviar carnet
    $("#imprimir").click(function()
    {
       window.location='carnet.php?parametro=1';
    });

 


    //darse baixa
     $("#bajausuario").click(function()
    {
        if (confirm("¿Está seguro/a de darse de baja en la web?"))
        {
            // Petición ajax de borrado.
            $.post("peticiones.php?op=6",function(resultado)
            {
                if (resultado=='OK')
                    window.location.href="desconectar.php";

            })
        }
    });







    $("#enviar").click(function(evento)
    {
        if (confirm("Se va a enviar el carnet de socio a su correo"))
        {


            $.post("carnet.php",function(resultado)
            {
                if (true)
                {
                    $("#enviar").fadeOut(function()
                    {
                        $("#mensajes").fadeTo(0,0).css("background-color","green").html(resultado).fadeTo(5500,1,function()
                        {
                            setTimeout('document.location="generarpdf.html"',1000);
                        });
                    });

                }
                else
                    $("#mensajes").fadeTo(0,0).css("background-color","red").html(resultado).fadeTo(400,1).delay(900).fadeTo(1000,0);

            });
        }
    });








});
