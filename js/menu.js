$(document).ready(function()
{
    //Almacenamos la url que aparece en el navegador
    var url=window.location.href;   //podemos engadir ''+  (concatenar un caracter vacio para evitar o erro de indexof, que so admite strings
    //pero mellor con window.location.href


    // si tenemos url´s absolutas en el menu
    //$("#nav a[href='"+url+"']").addClass("active");

    $("ul#nav a").filter(function()
    {
        return this.href==url;
    }).addClass('active');

    if(url.indexOf("subirfoto.html") != -1)
    {
        $("ul#nav a[href='editarusuario.html']").addClass('active');
    }
});
