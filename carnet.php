
<?php
                @session_start();
                # Cargamos la librería dompdf y fiunciones.
                require_once 'lib/pdf/dompdf_config.inc.php';
                require_once 'lib/funciones.php';


                 if (isset($_SESSION['twitter']))
                {
                    // Guardamos la ruta de la foto en la variable $rutafoto
                   $rutafoto=$_SESSION['fototwitter'];

                }
                else
                    if(isset($_SESSION['fotografia']) && $_SESSION['fotografia'] != '') //en caso de existir una foto
                        $rutafoto = 'img/usuarios/'.$_SESSION["fotografia"]; //la guardamos en la ruta (esta ruta es común a todos(sólo tenemos permisos aquí))







                    # Contenido HTML del documento que queremos generar en PDF.
                    $html='
                    <html>
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>Carnet de socio.</title>
                    </head>
                    <body>


                    <h5 align="center" style="background-color:green">Carnet socio Amadeus</h5>
                    <table id="carnet" padding=0>
                            <tr><td colspan=2>';
                               if(isset($rutafoto))
                               {
                               $html .= '<img src="'.$rutafoto.'" width="150" height="100"/>';
                               }
                               else
                               {
                                   $html .= '<img src="img/logo.png" width="150" height="100"/>';
                               }

                    $html .= '
                            </td></tr>
                            <tr><td><b>N. socio: <b/></td><td><span id="nick">'.$_SESSION['usuario'].'</span></td></tr>
                            <tr><td><b>Nombre: <b/></td><td><span id="nombre">'.$_SESSION['nombre'].'</span></td></tr>';
                            if(isset($_SESSION['apellidos']) & trim($_SESSION['apellidos']!=''))
                                {
                    $html.='
                            <tr><td><b>Apellidos: <b/></td><td><span id="apellidos">'.$_SESSION['apellidos'].'</span></td></tr>';
                                }
                                if(isset($_SESSION['dni']) & trim($_SESSION['dni']!=''))
                                {
                    $html.='
                            <tr><td><b>Dni: <b/></td><td><span id="dni">'.$_SESSION['dni'].'</span></td></tr>';
                                }

                            if(isset($_SESSION['email']) & trim($_SESSION['email']!=''))
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


                    </body>
                    </html>';


                    # Instanciamos un objeto de la clase DOMPDF.
                    $mipdf = new DOMPDF();

                    # Definimos el tamaño y orientación del papel que queremos.
                    # O por defecto cogerá el que está en el fichero de configuración.
                    $mipdf ->set_paper("A4", "portrait");

                    # Cargamos el contenido HTML.
                    $mipdf ->load_html(utf8_decode($html));

                    # Renderizamos el documento PDF.
                    $mipdf ->render();

                    if(isset($_GET['parametro']))   //se pulsamos imprimir
                    {
                          $mipdf ->stream('CarnetSocio.pdf');
                    }
                    else                            //en caso contrario, enviamos por correo
                    {
                        # Enviamos el fichero PDF al navegador.
                        if(isset($_SESSION['email']) && $_SESSION['email'] != '')
                        {
                                $envio='img/usuarios/'.$_SESSION['nombre'].'.pdf';
                                file_put_contents($envio, $mipdf->output());
                                enviarCorreo($_SESSION['nombre'],$_SESSION['email'],'Carnet socio Amadeus','Estimad@ soci@ '.$_SESSION['nombre'].' le adjuntamos el carnet de socio de nuestra web Amadeus, solicitado por usted el dia '.date("d-m-Y H:i:s"). ' desde el equipo con IP '.obtenerIP(),$envio);
                               echo 'Compruebe su buzón de correo '.$_SESSION['email'];
                               unlink($envio);
                               return true;
                        }
                        else
                        {
                            echo 'El usuario no dispone de email, puede imprimir su carnet de socio';
                            return false;
                        }
                    }
                    header('Location:generarpdf.html');
?>