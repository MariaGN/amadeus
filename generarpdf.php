<script type="text/javascript" src="js/pdf.js"></script>
<style type="text/css">
    #mensajes{
        border-radius:15px;
        -moz-border-radius:15px; /* Firefox */
        -webkit-border-radius:15px; /* Safari y Chrome */
        width:400px;
        text-align: center;
        vertical-align: middle;
        font-size: 15px;
        color:white;
    }
</style>
<div class="wrapper">
    <div class="grids top">
        <div class="grid-6 grid">
            <h4>Opciones disponibles:</h4>
            <div>
                <p class="bottom">
                <ul>
                    <li><a href="editarusuario.html" />Modifique sus datos personales</a></li>
                    <li><a href="subirfoto.html" />Subir Fotografía</a></li>
                    <?php
                    if (isset($_SESSION['fotografia']) && $_SESSION['fotografia'] != '')
                            echo '<li><a href="borrarfoto.html" />Borrar Fotografía</a></li>';
                    ?>
                    <li><a href="#" id="imprimircarnet" />Imprimir/Enviar Carnet Socio</a></li>
                    <li><a href="#" id="bajausuario"/>Darse de Baja</a></li>
                </ul>
                </p>
            </div>
        </div>

        <div class="grid-10 grid">
            <h4 id='titulo'>Carnet Socio Amadeus</h4>
          
              <?php
                @session_start();
                # Cargamos la librería dompdf.
                require_once 'lib/pdf/dompdf_config.inc.php';
                //require_once 'lib/basedatos.php'; //cargar tamén as variables de session d dni e tlf na funcion obtenerInfoUsuario (non é necesario o require, pero é para lembrarme de k se engadiron datos dni e telefono as variables)
                if (isset($_SESSION['twitter']))
                {
                    // Guardamos la ruta de la foto en la variable $rutafoto
                   $rutafoto=$_SESSION['fototwitter'];

                }
                else
                    if(isset($_SESSION['fotografia']) && $_SESSION['fotografia'] != '') //en caso de existir una foto
                        $rutafoto = 'img/usuarios/'.$_SESSION["fotografia"]; //la guardamos en la ruta (esta ruta es común a todos(sólo tenemos permisos aquí))


                    # Contenido HTML del documento que queremos generar en PDF. //mensaje en pantalla
                    $html='
                    <h5 align="center" style="background-color:green">Carnet socio Amadeus</h5>
                    <table id="carnet" padding=0>
                            <tr><td colspan=2>';
                               if(isset($rutafoto))
                               {
                               $html .= '<img src="'.$rutafoto.'" width="50" height="100"/>';
                               }
                               else
                               {
                                   $html .= '<img src="img/logo.png" width="150" height="100"/>';
                               }

                    $html .= '
                            </td></tr>
                            <tr><td><b>N. socio: <b/></td><td><span id="nick">'.$_SESSION['usuario'].'</span></td></tr>
                            <tr><td><b>Nombre: <b/></td><td><span id="nombre">'.$_SESSION['nombre'].'</span></td></tr>';
                            if(isset($_SESSION['apellidos']) & trim($_SESSION['apellidos'])!='')
                                {
                    $html.='
                            <tr><td><b>Apellidos: <b/></td><td><span id="apellidos">'.$_SESSION['apellidos'].'</span></td></tr>';
                                }
                                
                            if(isset($_SESSION['dni']) & trim($_SESSION['dni']!=''))
                                {
                    $html.='
                            <tr><td><b>Dni: <b/></td><td><span id="dni">'.$_SESSION['dni'].'</span></td></tr>';
                                }

                            if(isset($_SESSION['email']) & trim($_SESSION['email'])!='')
                                {
                     $html.='
                            <tr><td><b>Email: <b/></td><td><span id="email">'.$_SESSION['email'].'</span></td></tr>';
                                }
                                
                            if(isset($_SESSION['telefono']) & trim($_SESSION['telefono'])!='')
                                {
                     $html.='
                            <tr><td><b>Telefono: <b/></td><td><span id="telefono">'.$_SESSION['telefono'].'</span></td></tr>';
                                }
                     $html.='  </table >
                          
                    ';
                    echo $html;

                    ?>
            <div id="mensajes" style="margin:0 0 0 150px;"></div><br/>
            <div align="center">
                <input type="button" id="imprimir" value="imprimir"></input>
               <?php
                    if(!isset( $_SESSION['email']))
                    {
                        ?>
                <input type="button" id="enviar" value="enviar correo" disabled></input>
                        <?php
                    }   
                ?>
                <input type="button" id="enviar" value="enviar correo"></input>
            </div>
        </div><!--end of grid-10-->
    </div><!--end of grids-->

</div>