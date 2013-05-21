<?php
# Texto a superponer en la imagen.
$texto="E-mail: info@dominio.com";
# Cargamos la imagen de fondo.
$imagen=imagecreatefrompng("img/avion.png");
#Color del texto
$color=imagecolorallocate($imagen,19,107,216);
#Calculamos la distancia para centrar el texto.
$px=(imagesx($imagen)-7.5*strlen($texto))/2;
// Situamos el texto en la imagen.
imagestring($imagen,4,$px,190,$texto,$color);
// Enviamos la cabecera de imagen PNG.
// Importantísimo no tener ningún espacio en blanco al principio del fichero PHP
// ni hacer ningún echo o similar, por que entonces el envío de la cabecera fallaría.
Header ("Content-type: image/png");
// Enviamos el contenido de la imagen.
imagepng($imagen);
// Destruimos la imagen en el servidor.
imagedestroy($imagen);
?>