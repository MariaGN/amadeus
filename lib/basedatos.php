<?php
//Gestion de la bbdd mysql


//ejemplo de dirname
//dirname("/etc/passwd.txt")  -->devuelve /etc/
//__FILE__ -->contiene la ruta física del fichero

//librerias necesarias
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/funciones.php';

class Basedatos{
    /**
     *
     * @var Basedatos Contiene la instancia de la bbdd 
     */
    private static $_instancia;  //objeto de la abbdd  .servinos para indicar se está ou non creada a instancia
    
    /**
     *
     * @var boolean|mysqli Contiene el objeto mysqli despues de que se haya establecido la conexion 
     */
    private static $_mysqli=false;
    
    
    private function __construct(){
        
    }
    
    /**
     * Crea la conexión al servidor o devuelve error parando la ejecución
     * 
     * @return  Basedatos  Devuelve la referencia al objeto Basedatos
     */
    
    public static function getInstancia(){
        if(! self::$_instancia instanceof self){ //ou ben  Basedatos::$_instancia  //se nn é un objeto de unha instancia de unha clase (clase Basedatos)
           
            ////////////////// singleton
            //Creamos una nueva instancia de bbdd
            self::$_instancia= new self;  // ou ben   new Basedatos();
            
            //Creamos el  objeto mysqli y lo asignamos a $_mysqli
            self::$_mysqli=@new mysqli(Config::$dbServidor,Config::$dbUsuario,Config::$dbPassword,Config::$dbDatabase);  //datos presentes en config.php, cuia clase é Config  e a cal chamamos o principio //@ é para non mostrar os erros
            if (self::$_mysqli->connect_error){
                echo "Error conectando Base Datos".self::$_mysqli->connect_error;  //sacamos o erro da conexion
                self::$_mysqli=false;  //para indicar que non se pudo crear esa conexion
                die();
            }
          /////////////////////// 
            
            //Si la instancia ya estaba creada la devolvemos
            return self::$_instancia;   
         }   
    }
  
    
    
    
         /**
          * Cierra una conexion activa con el servidor
          * 
          * @access public
          * @return boolean   Siempre devuelve  true(verdadero)
          */
     public function close(){
         if(self::$_mysqli){
             self::$_mysqli->close();
             self::$_mysqli=false;
         }
         return true;
     }
    
    
         
        
         
         
         
         public function insertarUsuario($nick,$password,$nombre,$apellidos,$dni,$email,$telefono){
             //Preparamos la instruccion SQL.
             $stmt=self::$_mysqli->prepare("insert into amadeus_usuarios (nick,password,nombre,apellidos,dni,email,telefono) values(?,?,?,?,?,?,?)") or die (self::$_mysqli->error);
             //objeto tipo stement para
             
             //Enlazamos los parametros
             
             // (sustituimos encriptar($password,10) en $stmt->bind_param('sssssss',$nick,encriptar($password,10),$nombre,$apellidos,$dni,$email,$telefono);
             // e gardamos ese valor na variable $encriptada para evitar o warning que saia  )
             $encriptada = encriptar($password, 10);
             $stmt->bind_param('sssssss',$nick,$encriptada,$nombre,$apellidos,$dni,$email,$telefono);  //a pass a gardamos encriptada=> chamamos funcion encriptar de funciones.php
             
             
             //Ejecutamos la instruccion
             $stmt->execute() or die(self::$_mysqli->error);
             
             return "OK";
         }
    
         
         
             public function chequearnick($nick){
                 // Preparamos la consulta.
                 $stmt = self::$_mysqli->prepare("SELECT * from amadeus_usuarios where nick=?") or die(self::$_mysqli->error);

                 // Enlazamos los parÃ¡metros (s string)
                 // http://es2.php.net/manual/es/mysqli-stmt.bind-param.php
                 $stmt->bind_param("s",$nick);


                 // Ejecutamos la consulta preparada.
                 $stmt->execute();

                 // Si es una consulta de select almacenamos el resultado.
                 $stmt->store_result();

                 // NÃºmero de filas obtenidas.
                 $numfilas=$stmt->num_rows;   
                   
                 // Liberamos el espacio que ocupa ese resultado en memoria.
                 $stmt -> free_result();              
                 
                 if ($numfilas==1)
                      return "Nick en uso";
                 else
                      return "Nick disponible";

                 /* Liberamos el espacio que ocupa ese resultado en memoria.
                 $stmt -> free_result();   
                  
                  Se o deixamos aquí non o executaría nunca pois o ter return sempre terminaría ahí
                  */           
                 
                 
                 
         }
         
    
}
?>
