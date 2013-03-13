<?php

// Gestión de la base de datos MySQL.
// Ejemplo de dirname:
// La constante predefinida __FILE__ de php contiene la ruta fisica real del fichero, por ejemplo para este fichero podría ser: /var/www/amadeus/basedatos.php
// dirname ("/var/www/amadeus/basedatos.php") --> devuelve /var/www/amadeus

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/funciones.php';

class Basedatos {

    /**
     * @var Basedatos Contiene la instancia de Basedatos. 
     */
    private static $_instancia;

    /**
     *
     * @var boolean|mysqli Contiene el objeto mysqli después de que se haya 
     * establecido la conexión.
     */
    private static $_mysqli = false;

    //----------------------------------------------------------------------------------------------------
    /**
     * Crea la conexión al servidor o devuelve error parando la ejecución.
     * 
     * @return Basedatos Devuelve la referencia al objeto Basedatos.
     */
    public static function getInstancia() {
        if (!self::$_instancia instanceof self) {
            // Creamos una nueva instancia de basedatos.
            self::$_instancia = new self;
        }

        // Si la instancia ya estaba creada, la devolvemos.
        return self::$_instancia;
    }

    
    private function __construct()
    {
                   // Creamos el objeto mysqli y lo asignamos a $_mysqli
            self::$_mysqli = @new mysqli(Config::$dbServidor, Config::$dbUsuario, Config::$dbPassword, Config::$dbDatabase);
            if (self::$_mysqli->connect_error) {
                echo "Error conectando Base Datos" . self::$_mysqli->connect_error;
                self::$_mysqli = false;
                die();
            } 
    }
    
    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Función close()
     * Cierra una conexión activa con el servidor
     * 
     * @access public
     * @return boolean Siempre devolverá true.
     */
    public function close() {
        if (self::$_mysqli) {
            self::$_mysqli->close();
            self::$_mysqli = false;
        }
        return true;
    }

    //----------------------------------------------------------------------------------------------------
    /**
     * Función insertarUsuario()
     * Inserta los datos recibidos como parámetros en la tabla de usuarios.
     * 
     * @param string $nick
     * @param string $password
     * @param string $nombre
     * @param string $apellidos
     * @param string $dni
     * @param string $email
     * @param string $telefono
     * @return string "OK" indicando que se ha realizado con éxito la insercción de datos.
     */
    public function insertarUsuario($nick, $password, $nombre, $apellidos, $dni, $email, $telefono) {
        // Preparamos la instrucción SQL.
        $stmt = self::$_mysqli->prepare("insert into amadeus_usuarios(nick,password,nombre,apellidos,dni,email,telefono,token) values(?,?,?,?,?,?,?,?)") or die(self::$_mysqli->error);

        // Enlazamos los parámetros.
        $nick = strtolower($nick);
        $encriptada = encriptar($password, 10);
        $token = md5($encriptada);
        $stmt->bind_param('ssssssss', $nick, $encriptada, $nombre, $apellidos, $dni, $email, $telefono, $token);

        // Ejecutamos la instrucción
        $stmt->execute() or die(self::$_mysqli->error);

        $contenido = "Estimado señor/a $nombre $apellidos.<br/><br/>Hemos recibido una petición de registros en nuestra web de viajes Amadeus.";
        $contenido.="Si usted no ha realizado dicha petición, simplemente borre este correo y en breve el registro será borrado de nuestra base de datos.<br/><br/>";
        $contenido.="En otro caso, confirme su registro antes de 24 H en la siguiente dirección de Amadeus:<br/>";
        $contenido.="<a href='" . Config::$urlAplicacion . "/confirmar.html?nick=$nick&token=$token'>Confirmación registro en web viajes Amadeus</a><br/><br/>";
        $contenido.="IP registrada: " . obtenerIP() . "<br/><br/>";
        $contenido.="Reciba un cordial saludo.<br/><br/>Agencia de viajes Amadeus &copy; 2013.";

        if (enviarCorreo($nombre . ' ' . $apellidos, $email, 'Confirmación registro en Viajes Amadeus', $contenido))
            return "Registro realizado correctamente.<br/><br/>Le hemos enviado una confirmación a su correo electrónico:<br/>$email";
        else
            return "!! ATENCION !!<br/><br/>Se ha producido un fallo al enviar el correo a $email.<br/>Contacte con " . Config::$mailEmailRemitente . " para informar del problema.";
    }

    //----------------------------------------------------------------------------------------------------
    /**
     * Función chequearNick()
     * Comprueba si existe el nick en la base de datos.
     * 
     * @param string $nick Nick del usuario.
     * @return string Mensaje de en uso o disponible.
     */
    public function chequearNick($nick) {
        // Preparamos la consulta.
        $stmt = self::$_mysqli->prepare("SELECT * from amadeus_usuarios where nick=?") or (self::$_mysqli->error);

        // Enlazamos los parámetros (s string)
        // http://es2.php.net/manual/es/mysqli-stmt.bind-param.php

        $stmt->bind_param("s", $nick);

        // Ejecutamos la consulta preparada.
        $stmt->execute();

        // Si es una consulta de select almacenamos el resultado.
        $stmt->store_result();

        // Número de filas obtenidas.
        $numfilas = $stmt->num_rows;

        // Liberamos el espacio que ocupa ese resultado en memoria.
        $stmt->free_result();

        if ($numfilas == 1)
            return "Nick en uso";
        else
            return "Nick disponible";
    }

    //----------------------------------------------------------------------------------------------------
    /**
     * Función confirmarRegistro()
     * Actualiza el token del usuario enviado por e-mail
     * 
     * @param string $nick Nick del usuario.
     * @param string $token Token recibido por e-mail.
     * @return string Mensaje de confirmación de actualización.
     */
    public function confirmarRegistro($nick, $token) {
        $nick = strtolower($nick);

        $stmt = self::$_mysqli->prepare("select * from amadeus_usuarios where nick=? and token=?") or die(self::$_mysqli->error);

        // Enlazamos los parámetros con bind_param.
        $stmt->bind_param("ss", $nick, $token);

        // Ejecutamos la consulta
        $stmt->execute();

        // Almacenamos el resultado.
        $stmt->store_result();

        // Número de filas obtenidas en la consulta.
        $numfilas = $stmt->num_rows;

        if ($numfilas == 1) {
            // Los datos son correctos.
            // Actualizamos el token a OK.
            // Preparamos la consulta de actualizacion
            $stmt = self::$_mysqli->prepare("update amadeus_usuarios set token='OK' where nick=?") or die(self::$_mysqli->error);

            // Enlazamos el parámetro
            $stmt->bind_param('s', $nick);

            // Ejecutamos la instrucción
            $stmt->execute() or die(self::$_mysqli->error);

            // Devolvemos el mensaje
            return "<h3>Su registro ha sido confirmado satisfactoriamente</h3>";
        }
        else
            return "Error: los datos de validación son incorrectos";
    }

    //----------------------------------------------------------------------------------------------------
    /**
     * 
     * @param string $nick Nick del usuario a comprobar
     * @param string $pass Contraseña a comprobar.
     * @return string Mensaje de confirmación. OK si todo fue correcto.
     */
    public function chequearAcceso($nick, $pass) {
        // Preparamos la consulta.
        $nick = strtolower($nick);

        $stmt = self::$_mysqli->prepare("select nombre, apellidos, password, token, fotografia from amadeus_usuarios where nick=?") or die(self::$_mysqli->error);

        $stmt->bind_param("s", $nick);

        // Ejecutamos la consulta
        $stmt->execute();

        // Es una consulta select.... almacenamos el resultado.
        $stmt->store_result();

        $stmt->bind_result($nombre, $apellidos, $password, $token, $fotografia);

        // Número de filas obtenidas
        $numfilas = $stmt->num_rows;

        if ($numfilas == 1) {
            // Leemos la fila del recordset
            $stmt->fetch();

            if ($token != 'OK')
                return 'Su e-mail no fue validado. Compruebe su buzón';

            // Comprobamos la contraseña
            if (crypt($pass, $password) == $password) {
                // Creamos las variables de sesión para el usuario conectado.
                $_SESSION['usuario'] = $nick;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellidos'] = $apellidos;
                $_SESSION['fotografia'] = $fotografia;
                return "OK";
            }
            else
                return "ERROR: datos de acceso incorrectos.";
        }
        else
            return "ERROR: datos de acceso incorrectos.";
    }

 
    //----------------------------------------------------------------------------------------------------
    /**
     * Función obtenerInfoUsuario
     * Devuelve la información del usuario en formato JSON que hay en la base de datos, y actualiza las variables de sesión.
     * 
     * 
     */
    public function obtenerInfoUsuario()
    {
        // Preparamos la consulta.
        $stmt = self::$_mysqli->prepare("select password, nombre, apellidos, dni, email, telefono, token, fotografia from amadeus_usuarios where nick=?") or die (self::$_mysqli->error);
        
        $nick=$_SESSION['usuario'];
        $stmt->bind_param("s",$nick);
        
        // Ejecutamos la consulta.
        $stmt->execute();
        
        // Almacenamos el resultado.
        $stmt->store_result();
        
        // Vinculamos las variables para el recordset.
        $stmt->bind_result($password, $nombre, $apellidos, $dni, $email, $telefono, $token, $fotografia);
        
        // Leemos la fila del recordset
        $stmt->fetch();
        
        // Metemos todos los datos en un array.
        $datos=array("nick"=>$nick,"password"=>$password, "nombre"=>$nombre, "apellidos"=>$apellidos, "dni"=>$dni, "email"=>$email, "telefono"=>$telefono, "token"=>$token, "fotografia"=>$fotografia);
        
        $_SESSION['nombre']=$nombre;
        $_SESSION['apellidos']=$apellidos;
        $_SESSION['password']=$password;
        $_SESSION['email']=$email;
        $_SESSION['token']=$token;
        $_SESSION['fotografia']=$fotografia;
        
        // Devolvemos el array a la pagina ajax en formato JSON
        echo json_encode($datos);
        
        // Liberamos el espacio ocupado por el recordset
        $stmt->free_result();
    }
    
    
    
    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Función actualizarUsuario
     * Actualiza la información del usuario en la base de datos.
     * 
     * 
     * @param string $pass
     * @param string $nombre
     * @param string $apellidos
     * @param string $dni
     * @param string $email
     * @param string $telefono
     * @return string Mensaje de confirmación de la actualización de confirmación del usuario.
     */
    public function actualizarUsuario($pass, $nombre, $apellidos, $dni, $email, $telefono){
        // Usamos el nick del usuario logueado.
        $nick = $_SESSION['usuario'];
        
        // Comprobamos si se modificó la contraseña original.
        if ($pass != $_SESSION['password'])
            $encriptada= encriptar($pass,10);
        else
            $encriptada = $_SESSION['password'];
        
        
        // Comprobamos si se modificó el e-mail.
        // Si se modificó, tenemos que modificar el token.
        if ($email != $_SESSION['email'])
            $token = md5($encriptada);
        else
            $token = $_SESSION['token'];
        
        // Preparamos la instrucción SQL.
        $stmt=self::$_mysqli->prepare("update amadeus_usuarios set password=?, nombre=?, apellidos=?, dni=?, email=?, telefono=?, token=? where nick=?") or die(self::$_mysqli->error);
        
        // Enlazamos los parámetros.
        $stmt->bind_param("ssssssss",$encriptada, $nombre, $apellidos, $dni, $email, $telefono, $token, $nick);
        
        // Ejecutamos la instrucción.
        $stmt->execute() or die(self::$_mysqli->error);
        
        // Si el email se modificó reenviamos el correo.
        if ($email != $_SESSION['email'])
        {
            $contenido = "Estimado señor/a $nombre $apellidos.<br/><br/>Hemos recibido una petición de modificación de e-mail en su cuenta de viajes Amadeus.";
        $contenido.="Debe confirmar este cambio de correo para poder volver acceder a la web Amadeus. Hágalo en la siguiente dirección:<br/>";
        $contenido.="<a href='" . Config::$urlAplicacion . "/confirmar.html?nick=$nick&token=$token'>Confirmación cambio de e-mail en web viajes Amadeus</a><br/><br/>";
        $contenido.="IP registrada: " . obtenerIP() . "<br/><br/>";
        $contenido.="Reciba un cordial saludo.<br/><br/>Agencia de viajes Amadeus &copy; 2013.";

        if (enviarCorreo($nombre . ' ' . $apellidos, $email, 'Confirmación cambio e-mail en Viajes Amadeus', $contenido))
            return "Cambios realizados correctamente.<br/><br/>Acceda a su correo electrónico:<br/>$email<br/>para confirmar el cambio.";
        else
            return "!! ATENCION !!<br/><br/>Se ha producido un fallo al enviar el correo a $email.<br/>Contacte con " . Config::$mailEmailRemitente . " para informar del problema.";
       
        }
        
        return "Se han realizados los cambios correctamente.";
        
        
    }
    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Función actualizarFoto
     * Actualiza el nombre de la fotografía en la tabla del usuario.
     * 
     * @param string $fotografia El nombre del fichero que se actualizará en el campo de la tabla.
     * @return boolean true cuando termina la actualización de la fotografía.
     */
    public function actualizarFoto($fotografia) {
        // El nick es el del usuario logueado.
        $nick = $_SESSION['usuario'];

        // Preparamos la instrucción SQL.
        $stmt = self::$_mysqli->prepare("update amadeus_usuarios set fotografia=? where nick=?") or die(self::$_mysqli->error);

        // Enlazamos los parámetros.
        $stmt->bind_param('ss', $fotografia, $nick);

        // Ejecutamos la instrucción
        $stmt->execute() or die(self::$_mysqli->error);

        return true;
    }
    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Función borrarFoto
     * Actualiza el campo fotografia en la tabla.
     * 
     * @return boolean true al termina.
     */
    public function borrarFoto()
    {
        // El nick del usuario es:
        $nick = $_SESSION['usuario'];
        
        // Preparamos la instrucción SQL.
        $stmt=self::$_mysqli->prepare("update amadeus_usuarios set fotografia='' where nick=?") or die(self::$_mysqli->error);
        
        // Enlazamos el parámetro ?
        $stmt->bind_param("s",$nick);
        
        // Ejecutamos la instrucción.
        $stmt->execute() or die(self::$_mysqli->error);
        
        return true;
    }
    
    
    
    
    
    
    
    
}
?>
