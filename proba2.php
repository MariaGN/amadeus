<?php
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



if (!imagepng($imagenredimensionada, 'img/usuarios/zzz.png'))
    die("ERROR: no se puede escribir en la carpeta de destino.");

// Destruimos la imagen en el servidor.
imagedestroy($imagenredimensionada);

?>
