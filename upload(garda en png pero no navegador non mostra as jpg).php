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
            //if (!move_uploaded_file($_FILES['ficherosubido']['tmp_name'], $rutaFicheroAvatar))
              //  die("ERROR: no se puede escribir en la carpeta de destino.");


        // Cargamos a imaxe
        $imagen = imagecreatefromstring(file_get_contents($_FILES['ficherosubido']['tmp_name']));
        //// e lle quitamos a canle alpha
        imagealphablending($imagen, false);



        //cargamos a marca de auga
        $marcaagua = imagecreatefromstring(file_get_contents('img/watermark.png'));
        $anchomarcaagua = imagesx($marcaagua);
        $altomarcaagua = imagesy($marcaagua);
        //calculamos a posicion a colocar a marca de auga
        $posicionxparamarcaagua=imagesx($imagennueva) - $anchomarcaagua - 5;
        $posicionyparamarcaagua=imagesy($imagennueva)-$altomarcaagua -5;




        // Redimensionar
        //para manter o alto proporcional o ancho especificado
        $ratio_org = imagesx($imagen) / imagesy($imagen);
        $altonuevo = 250 / $ratio_org;
        //redimensionamola cas novas medidas xa adaptadas o ancho especificado (250px)
        //imagecreatetruecolor(ancho novo, alto novo) Crea unha nova imagen de color verdadeiro devolvendo un identificador de imaxe que representa unha imaxe en negro do tamaño especificado
        $imagennueva = imagecreatetruecolor(250, $altonuevo);

        //aplicamos transparencia a imaxe redimensionada
        //Asigna un color para una imagen (imaxe, valor de R, valor de G, valor de B
        //Un recurso image, es devuelto por una de las funciones de creación de imágenes, como imagecreatetruecolor().
        //Valor da compoñente vermella, verde, azul e a nivel de transparencia de 0 (opaco) a 127 (transparente)
        $transparencia = imagecolorallocatealpha($imagennueva,0,0,0,127);
        //Lleva a cabo un relleno comenzando en la coordenada dada (superior izquierda es 0, 0), con el color dado, en image.
        //Un recurso image, es devuelto por una de las funciones de creación de imágenes, como imagecreatetruecolor(),Coordenada x del punto de inicio.,Coordenada y del punto de inicio,El color de relleno. Un identificador de color creado con imagecolorallocate().Devuelve TRUE en caso de éxito o FALSE en caso de error.
        imagefill($imagennueva,0,0,$transparencia);

        //encaixamos ambas imaxes imagecopyresampled(imaxe destino,imaxe orixinal,coordenada x destino, coord. y destino,coord x orixinal, coord y orixinal,ancho destino, alto destino, ancho original, alto original)
        imagecopyresampled($imagennueva, $imagen, 0, 0, 0, 0, 250, $altonuevo, imagesx($imagen), imagesy($imagen));
        //e aplicamoslle a canle alpha
        imagealphablending($imagennueva,true);
        imagesavealpha($imagennueva, true);




        //especificamos o texto a engadirlle a imaxe
        $texto="Amadeus Copyright ". date('Y') . ".";
        //especificamos a cor do texto
        $color = imagecolorallocate($imagen, 135, 159, 0);
        //calculamos a distancia (ancho-tamaño de cada letra*tamaño total do texto)-30 de marxe solicitada
        $distancia = (250 - 7 * strlen($texto)) - 30;
        //situamos o texto na imaxe
        //Dibujar una cadena horizontalmente en las coordenadas dadas
        //imagestring(imaxe, tamaño fonte([0-5], coord x, coord y, texto a engadir, color a aplicar)
        imagestring($imagennueva, 3, $distancia, (imagesy($imagennueva)-18), $texto, $color);




        //copiamos a marca de auga na foto redimensionada na posicion calculada anteriormente
        //Copia parte de unha imaxe: imagecopy(destino, imaxe orixinal, coord x destino, coord y destino, coord x orixe, coord y orixe, ancho orixe, altura orixe)
        imagecopy($imagennueva, $marcaagua, $posicionxparamarcaagua , $posicionyparamarcaagua, 0, 0, $anchomarcaagua, $altomarcaagua);
        $compresion=0;

        //finalmente gardamos en disco a imaxe resultante
        //imagepng($imaxecreada, ruta donde se garda [se non se especifica, só se mostra], nivel compresion [0 (sin)-9], filtros (para reducir tamaño do png) ))
        //imagepng($imagennueva,$directorioImagenes.$nombreFicheroSinExtension.".png",$calidad);  //asi gardame efectivamente a png ca marca de auga, pero creame unha jpg se a k subo e jpg e mostrama sen marca de auga,¿x?
        //imagepng($imagennueva,$directorioImagenes.$nombreFicheroSinExtension.'.png',$calidad); //funciona, pero gardama co tipo de extension que ten a foto subida //    MIRAR


        if (!imagepng($imagennueva, $directorioImagenes.$nombreFicheroSinExtension.'.png',0))
    die("ERROR: no se puede escribir en la carpeta de destino.");

        

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
