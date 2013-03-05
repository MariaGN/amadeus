<?php
@session_start();
if(isset($_SESSION['fotografia'])&& $_SESSION['fotografia']!='')
{
    //Directorio de envio de imagenes
    $directorioImagenes=substr(__FILE__,0,strlen(__FILE__) - strlen(basename(__FILE__))).'img/usuarios/';
    $rutaFicheroAvatar=$directorioImagenes.$_SESSION['fotografia'];
    
    //Borramos el fichero físicamente.
    if(unlink($rutaFicheroAvatar))
    {
        //Actualizamos el campo fotografía de la base de datos
        require_once 'lib/basedatos.php';
        $mibase=  Basedatos::getInstancia();
        
        //Actualizamos el campo fotografia en la tabla.
        if($mibase->borrarFoto())
        {
            $_SESSION['fotografia']='';
        }
    }
    
} 
header ('Location:subirfoto.html');
?>
