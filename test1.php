<?php
//require_once 'lib/funciones.php';
//echo enviarCorreo('María Nimo','mari_lesende@hotmail.com','Comprobando envio correo','Proba de envio jejeje','eve-thumb.jpg');

require_once 'lib/basedatos.php';
$mibase=BaseDatos::getInstancia();
echo $mibase->obtenerUsuarios();


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
