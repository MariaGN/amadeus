<?php
//Datos de configuración de la aplicación
class Config{


    public static $urlAplicacion='http://www.mariagn.local/amadeus';
    //Configuracion de la bbdd
    public static $dbServidor='mariagn.local';
    public static $dbUsuario="c29a11mariagn";
    public static $dbPassword="abc123.";
    public static $dbDatabase="c29prueba";

    public static $webmaster="mari_lesende@yahoo.es";



    //Parametros de configuración del correo
    public static $mailNombreRemitente='María Nimo';
    public static $mailEmailRemitente ='info@mariagn.local';

    //datos de configuración del servidor del correo
    public static $mailServidor='localhost';
    public static $mailUsuario='info@mariagn.local';
    public static $mailPassword='abc123.';
    public static $mailPuerto='25';

    // Datos configuración autenticación LDAP
    public static $ldapServidor='10.0.4.1';
    public static $ldapPuerto='389';
    public static $ldapDominio='sanclemente.local';


    // Datos autenticación OAuth en Twitter obtenidos de nuestra configuración en:
    // http://dev.twitter.com
    // Cada usuario deberá poner sus propios datos aquí.
    //public static $consumerKey='GXRtix4VvRoik7mq3z0w';
    //public static $consumerSecret='oac66gVZkA2vYM9m2dLeUinLQV5W4nxUUuXnpCOUbo';
    public static $consumerKey='A2n01hQkR1TfVHGTqz2kw';
    public static $consumerSecret='OC6l7VnRybWL1M2DsSoDW7cMS9xIAgHy55ih7E7VE';

    public static $requestTokenUrl='https://api.twitter.com/oauth/request_token';
    public static $authorizeUrl='https://api.twitter.com/oauth/authorize';
    public static $accessTokenUrl='https://api.twitter.com/oauth/access_token';
    //public static $callbackUrl='http://www.mariagn.local/amadeus/twittertest/callback.php';
    public static $callbackUrl='http://www.mariagn.local/amadeus/callback.php';


    // Datos de configuración del servidor de correo para cuenta de GMAIL.
    // IMPORTANTE si usáis XAMPP:
    //
    // Para que funcione en XAMPP el envío con SSL (puerto 465) en GMAIL, hay que activar en el fichero \xampp\php\php.ini, la siguiente extensión:
    // extension=php_openssl.dll
    // y reiniciar de nuevo XAMPP.

    // Para usarlo con GMAIL aquí van un ejemplo de configuración:
    /*
* public static $mailNombreRemitente = 'Nombre y Apellidos';
* public static $mailEmailRemitente = 'usuario@gmail.com';
* public static $mailServidor = 'smtp.gmail.com';
* public static $mailPuerto = '465';
* public static $mailUsuario = 'usuario@gmail.com';
* public static $mailPassword = 'xxxxxx';
*/
}
?>
