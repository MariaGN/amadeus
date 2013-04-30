<?php

//cargamos clase LDAP
require_once 'lib/ldap.php';

//crear obj ldap
$ldap=new ldap("10.0.4.1");

//validar  ("ldap2","sanclemente.local","abc123..")
if($ldap->validarUsuario("a11mariagn","sanclemente.local","inicio"))
{
        echo "Ok usuario validado en AD <br/>";
       // $ldap->ojearUsuarios('nimo');
        $ldap->infoUsuario('nimo');
}
else
        echo "Datos incorrectos";

?>
