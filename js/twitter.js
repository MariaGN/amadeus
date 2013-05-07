$(document).ready(function(){
    $("#botonesrss input").click(function(){
		bclick=$(this).attr('id');
        if(bclick!='publicar')
        {
            $.post('peticiones.php?op=12',{opcion:bclick},function(resultado)
            {
                 $("#twitter").html(resultado);
            });
        }
          else
        {
            var twittear=prompt('Introduzca twitter');
            $.post('peticiones.php?op=12',{opcion:bclick,texto:twittear},function(resultado)
            {
                $("#twitter").html(resultado);
            });


        }

    });
});