<?php
//Activamos las sesiones
@session_start();

//Comprobamos si existe el fichero a cargar
if (isset($_GET['inc'])&& $_GET['inc']!= "")
    //comprobas si existe el fichero fisico a cargar
    if (!file_exists("{$_GET['inc']}.php")) //vai entre {x ser 1 array}
    {//sacamos página de error personalizada
        header("HTTP/1.0 404 Not Found");
        require 'error/404.html';
    }
    else
    {
        require_once 'header.html';
        require_once 'menu.php';
        require_once "{$_GET['inc']}.php";
        require_once 'footer.html';
    }
?>