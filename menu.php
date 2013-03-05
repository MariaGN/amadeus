<script type="text/javascript"  src="js/menu.js"></script>
<div class="wrapper">
     <a href="./" id="logo"><img src="img/logo.png" alt="something" />
	  <h1 class="accessibility">Amadeus - Desarrollo Web Entorno Servidor Modular - San Clemente.</h1></a>

     <div class="social">
         <?php
         //Collemos calque dos 4 datos que temos en basedatos.php na function chequearAcceso
         if(isset($_SESSION['usuario']))
         {
             echo "Usuario conectado:{$_SESSION['nombre']} {$_SESSION['apellidos']}.";
         }
         
         ?>
	  <a href="http://www.facebook.com/profile.php?id=100001520859552" title="facebook"><img src="img/facebook.png" width="20" height="20" alt="facebook"></a>
	  <a href="http://twitter.com/#!/sg_layout" title="twitter"><img src="img/twitter.png" width="20" height="20" alt="twitter"></a>
	  <a href="#" title="linkedin"><img src="img/linkedin.png" width="20" height="20" alt="linkedin"></a>
	  <a href="#" title="vcard"><img src="img/vcard.png" width="20" height="20" alt="vcard"></a>
	  <a href="#" title="picasa"><img src="img/picasa.png" width="20" height="20" alt="picasa"></a>
     </div>

     <!-- Menú de opciones -->
     <ul id="nav" class="main">
	  <li><a href="index.html" >Inicio</a></li>
          <li><a href="contactar.html">Contactar</a></li>
          <?php
         //si hai un usuario conectado
         if(isset($_SESSION['usuario']))
         {
             echo '<li><a href="editarusuario.html">Modificar datos</a></li> ';
             echo '<li><a href="desconectar.php">Desconectar</a></li> ';
         }
         else
         {
             echo '<li><a href="acceso.html">Acceso</a></li> ';
             echo '<li><a href="registrar.html">Registro</a></li> ';
         }
         ?>
	 
     </ul>
</div>

<div class="clear"></div>