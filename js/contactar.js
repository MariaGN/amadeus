$(document).ready(function()
{
        $("#formulario").submit(function(evento)
        {
            // Cancelamos el evento por defecto de envío de datos.
            evento.preventDefault();

           // Activamos todos los campos antes de enviar
            $("input").attr("disabled",false);

            // Metemos todos los datos del formulario en la variable datos.
            var datos=$("#formulario").serializeArray();

            // Hacemos la petición AJAX. op=5 Actualizar datos usuario logueado.
            $.post("peticiones.php?op=13",datos,function(resultado)
            {
                $("#formulario").fadeOut(function()
                {
                    $("#mensajes").fadeTo(0,0).css("background-color","green").html(resultado).fadeTo(500,1);
                });
            });

        });
});
