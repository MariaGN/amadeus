<?php
//Borrar este fichero dado que la funcion de chequear nick la introducimos en basedatos.php y modificamos por tanto el fichero registro.js y peticiones.js


// Datos configuraciÃ³n de la conexiÃ³n al MySQL.
$nombrebase="c29prueba";
$usuario="c29a11mariagn";
$servidor="mariagn.local";
$password="abc123.";
//////////////////////////////////////
// Hacemos la conexiÃ³n al servidor de MySQL utilizando mysqli.

$mysqli=@new mysqli($servidor,$usuario,$password,$nombrebase);

if ($mysqli->connect_error)
{
	die ("Error en conexiÃ³n base datos: ".$mysqli->connect_error);
}

// Preparamos la consulta.
$sentencia = $mysqli->prepare("SELECT * from amadeus_usuarios where nick=?") or die($mysqli->error);

// Enlazamos los parÃ¡metros (s string)
// http://es2.php.net/manual/es/mysqli-stmt.bind-param.php

$sentencia->bind_param("s",$_POST['nick']);


// Ejecutamos la consulta preparada.
$sentencia->execute();

// Si es una consulta de select almacenamos el resultado.
$sentencia->store_result();

// NÃºmero de filas obtenidas.
$numfilas=$sentencia->num_rows;
if ($numfilas==1)
     echo "Nick en uso";
else
     echo "Nick disponible";

// Liberamos el espacio que ocupa ese resultado en memoria.
$sentencia -> free_result();

// Cerramos la conexiÃ³n con el servidor mysql.
$mysqli->close();
?>