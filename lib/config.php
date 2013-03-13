<?php
//Datos de configuración de la aplicación
class Config{
    
    
    public static $urlAplicacion='http://www.mariagn.local/amadeus';
    //Configuracion de la bbdd
    public static $dbServidor='mariagn.local';
    public static $dbUsuario="c29a11mariagn";
    public static $dbPassword="abc123.";
    public static $dbDatabase="c29prueba";
    
    
    
    //Parametros de configuración del correo
    public static $mailNombreRemitente='María Nimo';
    public static $mailEmailRemitente ='info@mariagn.local';
    
    //datos de configuración del servidor del correo
    public static $mailServidor='localhost';
    public static $mailUsuario='info@mariagn.local';
    public static $mailPassword='abc123.';
    public static $mailPuerto='25';
    
    //para usarlo con GMAIL usariamos estos datos
    /*
     * public static $mailServidor='smtp.gmail.com';
     * public static $mailPuerto='465';
     */
}
?>
