<?php
//página que gestionará todas las peticiones Ajax

//para bloquear la caché de los navegadores
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1990 00:00:00 GMT');

//Cargamos la clase Basedatos
require_once('lib/basedatos.php');

//creamos objeto; dado que Base datos é privado, non podemos acceder, facemolo con getInstancia que é public static //ver basedatos.php
//Creamos el objeto con el patrón diseño Singleton
//no podemos usar $mibase=new Basedatos porque el constructor es privado en la clase Basedatos
$mibase=Basedatos::getInstancia();
switch($_GET['op']){
    case 1: //chequear nick
        echo $mibase->chequearnick($_POST['nick']);    
        break;
    
    case 2: //alta usuarios
        echo $mibase->insertarUsuario($_POST['nick'],$_POST['password'],$_POST['nombre'],$_POST['apellidos'],$_POST['dni'],$_POST['email'],$_POST['telefono']);
        
        break;
    
    case 3: //listado de usuarios
        
        break;
}
?>
