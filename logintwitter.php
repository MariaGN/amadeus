<?php
@session_start();
require_once 'lib/config.php';
require_once 'lib/basedatos.php';
require_once 'lib/twitter/twitteroauth.php';

//creamos una instanciade twitteroath
$twitter=new TwitterOAuth(Config::$consumerKey,Config::$consumerSecret);

//comprobamos si tenemos acceso Token
if(empty($_SESSION['access_token']) || empty($_SESSION['access_token_secret']))
{
    //solicitamos un  request token
    $tokens=$twitter->getRequestToken(Config::$callbackUrl);

    //almacenamos los request token recibidos
    $_SESSION['request_token']=$tokens['oauth_token'];
    $_SESSION['request_token_secret']=$tokens['oauth_token_secret'];

    //redireccionamos a la página de autenticacion de Twitter
    if($twitter->http_code==200)
    {
        $url=$twitter->getAuthorizeURL($_SESSION['request_token']);
        header('Location: '.$url);
    }
    else
        die("Problemas accediendo al servicio de Twitter");
}
else //tenemos access token disponible
{
    //aqui dentro, podemos hacer consultas a twitter
    //ya que tenemos el access token disponible
    //configuramos el objeto twitter para las consultas
    $twitter=new TwitterOAuth(Config::$consumerKey,Config::$consumerSecret,$_SESSION['access_token'],$_SESSION['access_token_secret']);


    //conseguimos las credenciales/datos del usuario de twitter
    $informacion=$twitter->get('account/verify_credentials');
   /* highlight_string('<?php'.print_r($informacion,TRUE).'?>'); */

    //almacenamos en variables de sesion los datos del usuario obtenidos de twitter
    $_SESSION['usuario']=$informacion->id;
    $_SESSION['nombre']=$informacion->name;
    $_SESSION['apellidos']='';
    $_SESSION['twitter']=true; //para modificar el menú
    $_SESSION['fototwitter']=$informacion->profile_image_url;

    //almacenamos los datos del usuario en la base de datos
    $mibase=Basedatos::getInstancia();

    //comprobamos si el usuario ya estaba registrado o no
    if($mibase->chequearNick($informacion->id,'twitter')=='Nick disponible')
    {
        echo 'hola';
        //el usuario no estaba registrado
        //lo insertamos en la base de datos
        $mibase->insertarUsuario($informacion->id,'',$informacion->name,'','','','','twitter',$_SESSION['access_token'],$_SESSION['access_token_secret']);





    }

    // redireccionamos a la pagina index.html
    header('Location:index.html');
}
?>
