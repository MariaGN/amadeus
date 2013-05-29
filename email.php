<?php
# Texto a superponer en la imagen.
$texto = "E-mail: info@dominio.com";
# Cargamos la imagen de fondo.
$imagen = imagecreatefrompng("img/aa.png");
#Color del texto
$color = imagecolorallocate($imagen, 111, 111, 111);
#Calculamos la distancia para centrar el texto.
$px = (imagesx($imagen) - 7.5 * strlen($texto)) / 2;
// Situamos el texto en la imagen.(cuidado con 4ºparam, tamaño imaxe(se>, non aparece o texto)
imagestring($imagen, 4, $px, 50, $texto, $color);
// En caso de tener transparencias, almacenar el canal Alpha completo.
imagesavealpha($imagen,true);
// Enviamos la cabecera de imagen PNG.
// Importantísimo no tener ningún espacio en blanco al principio del fichero PHP
// ni hacer ningún echo o similar, por que entonces el envío de la cabecera fallaría.
Header ("Content-type: image/png");
// Si queremos que almacene la imagen generada, haríamos:
// imagepng($imagen, "fotografia.png");
// Enviamos el contenido de la imagen.
imagepng($imagen);
// Destruimos la imagen en el servidor.
imagedestroy($imagen);
?>