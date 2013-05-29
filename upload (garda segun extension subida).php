<?php
@session_start();

// Directorio de envío de imágenes.
$directorioImagenes = substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__))) . 'img/usuarios/';

// Extensiones permitidas de archivos.
$formatosPermitidos = array('jpg', 'jpeg', 'png');

if (isset($_SESSION['usuario'])) {

    // Si recibimos fichero...
    if ( $_FILES['ficherosubido']['size'] >0) {
        $partesFichero = pathinfo($_FILES['ficherosubido']['name']);

        // Comprobamos si es un extensión permitida.
        if (in_array(strtolower($partesFichero['extension']), $formatosPermitidos)) {
            // nombreficheroAvatar.
            $nombreFicheroAvatar = md5("semoladetrigo" . $_SESSION['usuario']) . "." . strtolower($partesFichero['extension']);
            $nombreFicheroSinExtension = md5("semoladetrigo" . $_SESSION['usuario']);
            $rutaFicheroAvatar = $directorioImagenes . $nombreFicheroAvatar;

            // Movemos el archivo del directorio temporal a la carpeta definitiva.
            if (!move_uploaded_file($_FILES['ficherosubido']['tmp_name'], $rutaFicheroAvatar))
                die("ERROR: no se puede escribir en la carpeta de destino.");


        // Cargamos a imaxe
        $imagen = imagecreatefromstring(file_get_contents($rutaFicheroAvatar));
        //// e lle quitamos a canle alpha
        imagealphablending($imagen, false);


      
        //cargamos a marca de auga
        $marcaagua = imagecreatefromstring(file_get_contents('img/watermark.png'));
        $anchomarcaagua = imagesx($marcaagua);
        $altomarcaagua = imagesy($marcaagua);
        //calculamos a posicion a colocar a marca de auga
        $posicionxmarcaagua=imagesx($imagennueva) - $anchomarcaagua - 5;
        $posicionymarcaagua=imagesy($imagennueva)-$altomarcaagua -5;

 
    
    
        // Redimensionar
        //para manter o alto proporcional o ancho especificado
        $ratio_org = imagesx($imagen) / imagesy($imagen);
        $altonuevo = 250 / $ratio_org;
        //redimensionamola cass novas medidas xa adaptadas o ancho especificado (250px)
        $imagennueva = imagecreatetruecolor(250, $altonuevo);

        //aplicamos transparencia a imaxe redimensionada
        $transparencia = imagecolorallocatealpha($imagennueva,0,0,0,127);
        imagefill($imagennueva,0,0,$transparencia);

        //encaixamos ambas imaxes
        imagecopyresampled($imagennueva, $imagen, 0, 0, 0, 0, 250, $altonuevo, imagesx($imagen), imagesy($imagen));
        //e aplicamoslle a canle alpha
        imagealphablending($imagennueva,true);
        imagesavealpha($imagennueva, true);

     
       
     
        //especificamos o texto a engadirlle a imaxe
        $texto="Amadeus Copyright ". date('Y') . ".";
        //especificamos a cor do texto
        $color = imagecolorallocate($imagen, 135, 159, 0);  
        //calculamos a distancia
        $distancia = (250 - 7 * strlen($texto)) - 30;
        //situamos o texto na imaxe
        imagestring($imagennueva, 3, $distancia, (imagesy($imagennueva)-18), $texto, $color);


   
       
        //copiamos a marca de auga na foto redimensionada na posicion calculada anteriormente
        imagecopy($imagennueva, $marcaagua, $posicionxmarcaagua , $posicionymarcaagua, 0, 0, $anchomarcaagua, $altomarcaagua);
        $calidad=0;

        //finalmente gardamos en disco a imaxe resultante
        //imagepng($imagennueva,$directorioImagenes.$nombreFicheroSinExtension.".png",$calidad);  //asi gardame efectivamente a png ca marca de auga, pero creame unha jpg se a k subo e jpg e mostrama sen marca de auga,¿x?
        imagepng($imagennueva,$rutaFicheroAvatar,$calidad); //funciona, pero gardama co tipo de extension que ten a foto subida //    MIRAR
        
        
           // Actualizamos la base de datos
        require_once 'lib/basedatos.php';
        $mibase = Basedatos::getInstancia();
        // Si pudo actualizar la foto en la base de datos.
        if( $mibase->actualizarFoto($nombreFicheroAvatar))
        {

            $_SESSION['fotografia'] = $nombreFicheroAvatar;
            // Nos redirecciona a la página de subirfoto.html
             header('location:subirfoto.html');
        }
        imagedestroy($imagen);
        imagedestroy($imagennueva);
    }

        else
            echo "ERROR: El formato de archivo no está permitido.";
    } // EMPTY FILES.
    header("location: subirfoto.html");
} //
else
    echo "ERROR: Acceso no permitido a la aplicación.";
?>
