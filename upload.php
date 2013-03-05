<?php
@session_start();

//Directorio de envío de imagenes
$directorioImagenes=substr(__FILE__,0,strlen(__FILE__) - strlen(basename(__FILE__))).'img/usuarios/';

//Extensiones permitidas de archivos.
$formatosPermitidos=array('jpg','jpeg','gif','jpeg');

//
if(isset($_SESSION['usuario']))
{
    //si recibimos fichero.
    if(!empty($_FILES))
    {
        $partesFichero=pathinfo($_FILES['ficherosubido']['name']);
        //Comprobamos si es una extensión permitida
        if(in_array(strtolower($partesFichero['extension']),$formatosPermitidos))
        {
                $partesFichero=pathinfo($_FILES['ficherosubido']['name']);

                //nombre fichero avatar
                $nombreFicheroAvatar=md5("semoladetrigo".$_SESSION['usuario']).".".strtolower($partesfichero['extension']);


                $rutaFicheroAvatar=$directorioImagenes.$nombreFicheroAvatar;

                //Movemos el archivo del directorio temporal a la carpeta definitiva
                if(!move_uploaded_file($_FILES['ficherosubido']['tmp_name'],$rutaFicheroAvatar))
                    die ("ERROR: no se puede escribir en la carpeta de destino.");
               //Actualizamos la base de datos
                require_once("lib/basedatos.php");
                $mibase=  Basedatos::getInstancia();

                //si pudo actualizar la foto en la base de datos
                if($mibase->actualizarFoto($nombreFicheroAvatar))
                {
                   $_SESSION['fotografia']=$nombreFicheroAvatar;
                   //Nos redirecciona a la página de subirfoto.html.
                   header("Location:subirfoto.html");

                }
         }//endif de extension
         
         else 
             echo "ERROR: El formato de archivo no está permitido" ;
             
         
    }
    
}
else
    echo "ERROR:Acceso no permitido a la aplicacion";