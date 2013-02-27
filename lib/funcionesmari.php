<?php
// Librería de funciones.

/**
 * Función de encriptación en Blowfish
 *
 * @param string $password La contraseña a encriptar.
 * @param int $vueltas Número de vueltas entre 04 y 31, 7 por defecto
 * @return string Contraseña encriptada
 *
 * Ejemplo de uso:
 * $encriptado = encriptar('mipassword',10);
 * if (crypt('mipassword',$encriptado) == $encriptado) { OK }
 *
 */
function encriptar($password, $vueltas=7)
{
    $caracteres='./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    // http://php.net/manual/es/function.crypt.php
    // Para BlowFish, la cabecera es: $2a$ + coste + 22 caracteres del alfabeto de caracteres.
    // %02d -> es para que ponga el número con dos dígitos.
    // $vueltas -> número entre 04 y 31, Se recomienda 7 por defecto por ejemplo

    $semilla=sprintf('$2a$%02d$',$vueltas);
    for($i=0;$i<22;$i++)
     $semilla.=$caracteres[rand(0,63)];


    return crypt($password,$semilla);
}


function chequearSpam($campo) {
//Array con las posibles cabeceras a utilizar por un spammer
    $spam = array("Content-Type:",
        "MIME-Version:",
        "Content-Transfer-Encoding:",
        "Return-path:",
        "Subject:",
        "From:",
        "Envelope-to:",
        "To:",
        "bcc:",
        "cc:",
        "link=",
        "url=");

//Comprobamos que entre los datos no se encuentre alguna de
//las cadenas del array. Si se encuentra alguna cadena se
//dirige a una pagina de Forbidden
    foreach ($spam as $patron) 
    {
        // strpos(pajar,aguja) devuelve FALSE si no encuentra la cadena.
        //(esto significa que non  se atopou)
        if (strpos(strtolower($campo), strtolower($patron)) !== false) {
            echo "<br/><br/><h3><CENTER>!! Error: Caracteres SPAM detectados en el correo !! </h3>";
            echo "<h2><CENTER>!! Spammers no permitidos. Solicitud cancelada. !! </h2>.<br/></CENTER>";
            exit;
        }
    }

    return true;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////
function chequearEmail($campo) {
    if (!filter_var($campo, FILTER_VALIDATE_EMAIL)) {
        echo "<br/><br/><h3><CENTER>!! Error: Formato de e-mail incorrecto </font>!! </h3>";
        echo "<h2><CENTER>!! Solicitud cancelada !! </h2>.<br/></CENTER>";
        exit;
    }
    return true;
}



////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerIP() {
    return $_SERVER['REMOTE_ADDR'];
}










//$nombreRemitente=''  facemos esto pois estos datos son opcionais
function enviarCorreo($nombreDestinatario,$emailDestinatario,$asunto,$contenido,$fichero,$nombreRemitente='',$emailRemitente='',$servidorCorreo='',$usuarioCorreo='',$passwordCorreo='', $puerto=''){
    if (isset ($emailDestinatario) && $emailDestinatario!=''){
        //comenzamos con la configuracion del correo
        //
        //Cambiamos estas 3 lineas poras seguintes
        //cargamos las librerias de php mailer
       // require_once dirname(__FILE__).'/class.phpmailer.php';
       // require_once dirname(__FILE__).'/class.smtp.php';
       //require_once dirname(__FILE__).'/config.php';
        
        
        require_once dirname(__FILE__) . '/phpmailer/class.phpmailer.php';
        require_once dirname(__FILE__) . '/phpmailer/class.smtp.php';
        require_once dirname(__FILE__) . '/config.php';
        
        if($nombreRemitente=='')
            $nombreRemitente=Config::$mailNombreRemitente;
        if($emailRemitente=='')
            $emailRemitente=Config::$mailEmailRemitente;
        if($servidorCorreo=='')
            $servidorCorreo=Config::$mailServidor;
        if($usuarioCorreo=='')
            $usuarioCorreo=Config::$mailUsuario;
        if($passwordCorreo=='')
            $passwordCorreo=Config::$mailPassword;
        if($puerto=='')
            $puerto=Config::$mailPuerto;
        
         echo($servidorCorreo);
        //Está configurado el servidor de correo?
        if($servidorCorreo !='' && $usuarioCorreo != '' && $passwordCorreo !=''){
            //pendiente validación de SPAM en el correo
           if(chequearSpam($nombreDestinatario)&& chequearSpam($emailDestinatario)&& chequearSpam($asunto)&& chequearSpam($contenido)){
            

            //creamos el objeto de tipo phpmailer
            $correo= new PHPMailer();
            
            $correo->IsSMTP(); //Indicamos que vamos a usar SMTP
            $correo->SMTPDebug=1; //habilitamos el debug al enviar correo
            
            //autenticacion del correo a true
            $correo->SMTPAuth=true;
            $correo->Charset='UTF-8';
            
            //configuramos el servidor
            $correo->Host=$servidorCorreo;
            $correo->Port='$puerto';
            
            //si estamos usando GMAIL
            if($puerto==465 || $puerto==587)
                $correo->SMTPSecure='ssl';
            
            
            //datos del correo
            $correo->Username=$usuarioCorreo;
            $correo->Password=$passwordCorreo;
            $correo->SetFrom($emailRemitente,$nombreRemitente);
            $correo->AddReplyTo($emailRemitente,$nombreRemitente);
            $correo->AddAddress($emailDestinatario,$nombreDestinatario);
            $correo->Subject=$asunto;
            $correo->AltBody='Para ver este mensaje utilice un visor compatible con HTML.';
            $correo->MsgHTML($contenido);
            $correo->IsHTML(true);
            
            //Si recibimos un fichero lo adjuntamos al correo.
            if ($fichero!='')
                $correo->AddAttachment ($fichero);
            
            /**
             * Si queremos enviar ficheros adjuntos
             * 
             * $correo->AddAttachment('rutafichero/billete.pdf');
             */
            
            //$correo->IsHTML(true);
            //$correo->AddAddress($emailDestinatario,$nombreDestinatario);
            
            //POR FIn enviamos el correo.
            if($correo->Send()){
                return TRUE;}
            else{
                echo $correo->ErrorInfo;
                //return FALSE;
                }
            
                
           } //chave de validacion de spam
        }
        
    }
    
    
}
?>
