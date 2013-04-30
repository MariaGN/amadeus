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


}
?>
