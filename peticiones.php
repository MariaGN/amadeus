<?php

// Activamos las variables de sesión.
@session_start();

// Para bloquear la cache en navegadores para las peticiones AJAX.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1973 00:00:00 GMT');

// Cargamos la clase basedatos.
require_once("lib/basedatos.php");
require_once("lib/rss.php");

// Creamos el objeto con el patrón diseño Singleton.
// No podemos usar $mibase= new Basedatos(), por que
// el constructor es privado en la clase Basedatos.
$mibase = Basedatos::getInstancia();

switch ($_GET['op'])
{
    case 1:  // Chequear nick
        echo $mibase->chequearNick($_POST['nick']);
        break;

    case 2: // Alta de usuarios
        echo $mibase->insertarUsuario($_POST['nick'], $_POST['password'], $_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['email'], $_POST['telefono']);
        // Enviamos a continuación el correo de registro.
        break;

    case 3: // Chequear Inicio sesión
        echo $mibase->chequearAcceso($_POST['nick'], $_POST['password']);
        break;


    case 4: // Obtener los datos del usuario
        echo $mibase->obtenerInfoUsuario();
        break;

    case 5: // Actualizamos datos usuario logueado.
        echo $mibase->actualizarUsuario($_POST['password'], $_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['email'], $_POST['telefono']);
        break;

    case 6: // Borrado de usuario y fotografías en el servidor.
        echo $mibase->borrarUsuario();
        break;

    case 7: // Petición ajax de carga de aeropuertos.
        echo $mibase->obtenerAeropuertos($_POST['latNE'], $_POST['lonNE'], $_POST['latSW'], $_POST['lonSW']);
        break;

    case 8: // Petición ajax de sugerencias de aeropuertos.
        echo $mibase->sugerirAeropuertos($_POST['aeropuerto']);
        break;

    case 9: // Petición JSON a flightRadar24.
        echo file_get_contents("http://www.flightradar24.com/AirportInfoService.php?airport={$_POST['iata']}&type={$_POST['tipo']}");
        break;

    case 10: // Consultas RSS
        $mirss = new rss($_POST['titulo'], $_POST['url']);
        echo $mirss->contenidoRSS();

    case 11: //Peticion JSON a wunderground.com
        echo file_get_contents("http://api.wunderground.com/api/9818492157481090/conditions/forecast/lang:SP/q/{$_POST['pais']}/{$_POST['localidad']}.json");
        break;

    case 12: //Peticion JSON a dev.twitter.com
        include_once 'lib/twitter/twitteroauth.php';
        $twitter = new TwitterOAuth(Config::$consumerKey, Config::$consumerSecret, $_SESSION['access_token'], $_SESSION['access_token_secret']);









        switch ($_POST['opcion'])
        {
            case 'misdatos':
                $informacion = $twitter->get('account/verify_credentials');
                print_r('<h4>Id del usuario: ' . $informacion->id . '</h4><h4>Nombre: ' . $informacion->name . '</h4>');


                break;
            case "status":
                $informacion = $twitter->get('statuses/home_timeline');
                echo '<h4>Creado el: </h4>' . $informacion[0]->created_at . '<h4>Usuario: </h4>' . $informacion[0]->user->name . '<h4>Ultimo Twiteo: </h4>' . $informacion[0]->text;

                break;

            case "timeline":
                $informacion = $twitter->get('statuses/user_timeline', array('screen_name' => '@mari_lesende'));
                if(isset($informacion->errors))
                {
                    echo('El usuario no existe');
                }
                else if(isset($informacion->error))
                {
                    echo('No tiene permisos para twittear');
                }
                else if (empty($informacion))
                {
                    echo "El usuario no tiene twittes.";
                }
                else
                {
                    echo '<h4>Nombre de usuario: </h4>' . $informacion[0]->user->name . '<h4>Localización: </h4>' . $informacion[0]->user->location;


                    for ($i = 0; $i < count($informacion); $i++)
                    {
                        //if (isset($informacion[$i]->text))
                            echo '<h4>Twitters: </h4>' . $informacion[$i]->text . '<h4>Total retwiteos: </h4>' . $informacion[$i]->retweet_count;
                    }

                }
                break;

            case "publicar":
                $texto = $_POST['texto'];
                //$mensaje=array('status'=>$texto);
                $informacion = $twitter->post('statuses/update', array('status' => $texto));

                echo $texto;

                break;
        }
}
?>