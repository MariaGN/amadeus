<?php
@session_start();
require_once 'lib/config.php';
require_once 'lib/twitter/twitteroauth.php';

//si regresamos de twitter tendremos unos parametros especificos en la url
if(!empty($_GET['oauth_verifier'])&& !empty($_SESSION['request_token']) && !empty($_SESSION['request_token_secret']))
{
    //podemos pedir entonces el acces token y access token secret
    //configuramos el objeto $twitter
    $twitter=new TwitterOAuth(Config::$consumerKey,Config::$consumerSecret,$_SESSION['request_token'],$_SESSION['request_token_secret']);

    //una vez configurado el objeto, pedimos el cambio por un acess token
    $accesstoken=$twitter->getAccessToken($_GET['oauth_verifier']);

    //almacenamos en dos variables de sesion el acces token y el access token seret
    $_SESSION['access_token']=$accesstoken['oauth_token'];
    $_SESSION['access_token_secret']=$accesstoken['oauth_token_secret'];

    //eliminamos las variables de sesion request_token
    unset($_SESSION['request_token']);
    unset($_SESSION['request_token_secret']);

    //redireccionamos a logintwitter.php
    header('Location:logintwitter.php');
}

?>
