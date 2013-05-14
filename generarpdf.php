<script type="text/javascript" src="js/pdf.js"></script>
<style type="text/css">

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
                            echo '<li><a href="borrarfoto.php" />Borrar Fotografía</a></li>';
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
                if (isset($_SESSION['twitter']))
                {
                    // Mostramos la imagen de twitter.
                    // Cargamos la librería twitterOAuth
                    $rutafoto=$_SESSION['fototwitter'];

                }


                else if(isset($_SESSION['fotografia']) && $_SESSION['fotografia'] != '')
                        $rutafoto = 'img/usuarios/$_SESSION["fotografia"]';






                    # Cargamos la librería dompdf.
                    require_once 'lib/pdf/dompdf_config.inc.php';

                    # Contenido HTML del documento que queremos generar en PDF.
                    $html='


                    <h5>Carnet socio Amadeus</h5>
                    <table padding=0>
                            <tr><td colspan=2>';
                     if(isset($rutafoto))
                    {
                    $html .= '<img src="'.$rutafoto.'"/>';
                    }else{
                        $html .= "<p>No foto</p>";
                    }

                    $html .= '</td></tr>
                            <tr><td><b>N. socio: <b/></td><td><span id="nick">'.$_SESSION['usuario'].'</span></td></tr>
                            <tr><td><b>Nombre: <b/></td><td><span id="nombre">'.$_SESSION['nombre'].'</span></td></tr>
                            <tr><td><b>Apellidos: <b/></td><td><span id="apellidos">'.$_SESSION['apellidos'].'</span></td></tr>

                            <tr><td><b>Email: <b/></td><td><span id="email">'.$_SESSION['email'].'</span></td></tr>

                    </table >



                    ';
                    echo $html;

                    ?>
            <input type="button" id="imprimir" value="imprimir"></input>
            <input type="button" id="enviar" value="enviar correo"></input>
        </div><!--end of grid-10-->
    </div><!--end of grids-->

</div>