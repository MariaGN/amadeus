<?php
@session_start();

// Directorio de envío de imágenes.
$directorioImagenes = substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__))) . 'img/usuarios/';

// Extensiones permitidas de archivos.
//$formatosPermitidos = array('jpg', 'jpeg', 'gif', 'png');
$formatosPermitidos = array('jpg', 'jpeg', 'png');

if (isset($_SESSION['usuario'])) {

    // Si recibimos fichero...
    if ( $_FILES['ficherosubido']['size'] >0) {
        $partesFichero = pathinfo($_FILES['ficherosubido']['name']);

        // Comprobamos si es un extensión permitida.
        if (in_array(strtolower($partesFichero['extension']), $formatosPermitidos)) {
            // nombreficheroAvatar.
            $nombreFicheroSinExtension = md5("semoladetrigo" . $_SESSION['usuario']);
            $nombreFicheroAvatar = md5("semoladetrigo" . $_SESSION['usuario']) . "." . strtolower($partesFichero['extension']);

            $rutaFicheroAvatar = $directorioImagenes . $nombreFicheroAvatar;


            // Movemos el archivo del directorio temporal a la carpeta definitiva.
           // if (!move_uploaded_file($_FILES['ficherosubido']['tmp_name'], $rutaFicheroAvatar))
             //   die("ERROR: no se puede escribir en la carpeta de destino.");




# Cargamos a imaxe temporal.
$imagen = imagecreatefromstring(file_get_contents($_FILES['ficherosubido']['tmp_name']));

// e lle quitamos a transparencia
imagealphablending($imagen,false);


# Texto a superponer en la imagen.
$texto = "Amadeus Copyright ".date('Y');
#Color del texto
$color = imagecolorallocate($imagen, 135, 159, 0);
#Calculamos la distancia para centrar el texto.
$px = (imagesx($imagen) - 7 * strlen($texto)) -30;
// Situamos el texto en la imagen.
imagestring($imagen, 3, $px,imagesy($imagen)-18, $texto, $color);



//Redimensionamos a imaxe cargada
$imagennueva=imagecreatetruecolor(250,imagesy($imagen));
imagecopyresampled($imagennueva,$imagen,0,0,0,0,250,imagesy($imagennueva),imagesx($imagen),imagesy($imagen));
$imagenredimensionada=$imagennueva;





//Marca de auga
//cargamos a marca de auga
$marcaagua=imagecreatefromstring(file_get_contents("img/watermark.png"));
//indicamos a posición x e y de onde se vai a colocar a marca de auga
$anchomarcaagua=imagesx($marcaagua);
$altomarcaagua=imagesy($marcaagua);

$posicionXmarcaagua=imagesx($imagenredimensionada)-$anchomarcaagua-5;
$posicionYmarcaagua=imagesy($imagenredimensionada)-$altomarcaagua-5;



//copiamos a marca de auga na foto redimensionada na posicion calaculada anteriormente
imagecopy($imagenredimensionada,$marcaagua,$posicionXmarcaagua,$posicionYmarcaagua,0,0,$anchomarcaagua,$altomarcaagua);


//aplicamos agora a transparencia as imagenes
imagealphablending($imagenredimensionada, true);
//imagealphablending($marcaagua, true);
imagealphablending($marcaagua,true);



if (!imagepng($imagenredimensionada, 'img/usuarios/'.$nombreFicheroSinExtension.'.png'))
    die("ERROR: no se puede escribir en la carpeta de destino.");

// Destruimos la imagen en el servidor.
imagedestroy($imagenredimensionada);





            // Actualizamos la base de datos.
            require_once("lib/basedatos.php");
            $mibase = Basedatos::getInstancia();

            // Si ese ususario tenía una fotografía antigua, la borramos del servidor.
            if (isset($_SESSION['fotografia']) && $_SESSION['fotografia']!='')
            {
                $ficheroBorrar=$directorioImagenes.$_SESSION['fotografia'];
                unlink($ficheroBorrar);
            }

            // Actualizamos la foto en la base de datos.
            if ($mibase->actualizarFoto($nombreFicheroAvatar)) {
                $_SESSION['fotografia'] = $nombreFicheroAvatar;
                // Nos redirecciona a la página de subirfoto.html.
                header("location: subirfoto.html");
            }
        }
        else
            echo "ERROR: El formato de archivo no está permitido.";
    } // EMPTY FILES.
    header("location: subirfoto.html");
} //
else
    echo "ERROR: Acceso no permitido a la aplicación.";
?>
