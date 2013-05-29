<?php

//Almacenamos la imagen dentro de una variable:

$ruta_marca = 'img/watermark.png';
$watermark = imagecreatefrompng($ruta_marca);

//Ahora procederemos a crear el fichero JPEG final -con marca de agua- a partir de una imagen inicial que almacenaremos en la variable $imagen.

$ruta_imagen = 'img/logo.png';
$imagen = imagecreatefrompng($ruta_imagen);

//La variables $ruta_imagen y $ruta_marca deberán incluir las ruta necesarias para acceder a ambos ficheros.

//Lo siguiente que hacemos es, obtener las dimensiones de la imagen, sustraer las dimensiones de la marca de agua y, dejando un margen de 5 px, obtener las posiciones x e y sobre las que se colocará la marca de agua.

$tamanyo_imagen = getimagesize($ruta_imagen);
$tamanyo_marca = getimagesize($ruta_marca);
$dest_x = $tamanyo_imagen[0] - $tamanyo_marca[0] - 5;
$dest_y = $tamanyo_imagen[1] - $tamanyo_marca[1] - 5;

// Ahora tan sólo queda unir la imagen y la marca de agua. Para ello nos valemos de la función imagecopymerge. La sintaxis es:imagecopymerge(resource $dst_im,resource $src_im, int $dst_x, int $dst_y, int $src_x, int $src_y, int $src_w, int $src_h, int $pct)
//
//Lo que hace es copiar $src_im en $dst_im, comenzando en las coordenadas x e y especificadas en src_x, src_y, con un ancho y alto especificados en $src_w y $src_h y unidas de acuerdo con el pct especificado

imagecopymerge($imagen, $watermark, $dest_x, $dest_y, 0, 0,$tamanyo_marca[0], $tamanyo_marca[1], 100);


//Para, finalmente mostrar la imagen resultante necesitaremos estas tres líneas de código:

imagejpeg($imagen);  //Mostrar la imagen
imagedestroy($imagen);  //Libera la memoria asociada a la imagen
imagedestroy($watermark); //Libera la memoria asociada a la marca de agua


?>
