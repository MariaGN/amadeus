<?php

/*
 In this task, you have to modify the upload.php procedure in the Amadeus Project, to add the following options:

- The user can upload only jpg, jpeg and png files.

- The picture uploaded should be resized to 250 pixels width, and after resize the picture you can continue with the next option.

- You have to add the transparent watermark.png, on the right-down corner. (5 px margin right and down).

- You have to add to the picture the following text: "Amadeus Copyright 2013." (year should updated automatically), on the right-down corner. (font size 3, 30px margin right and the margin down will be the size of image-18px. Each letter is about 7px width. Text color (RGB): 135,159,0.

HELP functions: imagecreatefromstring(), imagecopy(), imagecreatetruecolor() and imagecopyresampled().
 */


$ruta=file_get_contents("img/logo.png");

# Cargamos la imagen de fondo.
$imagen = imagecreatefromstring($ruta);

//quitqmos a transparencia
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
//cargamosa marca de auga
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
imagealphablending($marcaagua, true);
imagesavealpha($marcaagua,true);


// Enviamos la cabecera de imagen PNG.
// Importantísimo no tener ningún espacio en blanco al principio del fichero PHP
// ni hacer ningún echo o similar, por que entonces el envío de la cabecera fallaría.
Header ("Content-type: image/png");
// Si queremos que almacene la imagen generada, haríamos:
// imagepng($imagen, "fotografia.png");
// Enviamos el contenido de la imagen.
imagepng($imagenredimensionada);
// Destruimos la im agen en el servidor.
imagedestroy($imagenredimensionada);
?>
