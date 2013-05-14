    <?php
                @session_start();
                # Cargamos la librería dompdf y fiunciones.
                require_once 'lib/pdf/dompdf_config.inc.php';
                require_once 'lib/funciones.php';

                if (isset($_SESSION['twitter']))
                {
                    // Mostramos la imagen de twitter.
                    // Cargamos la librería twitterOAuth
                     $foto =  "<img src='{$_SESSION['fototwitter']}' width='50'/>";
                }

                else if (isset($_SESSION['fotografia']) && $_SESSION['fotografia'] != '')
                        $foto = "<img src='img/usuarios/{$_SESSION['fotografia']}' width='250'/>";
                    else
                        $foto = "Foto avatar no disponible.";



                    # Cargamos la librería dompdf.
                    require_once 'lib/pdf/dompdf_config.inc.php';
                    require_once 'lib/funciones.php';
                    # Contenido HTML del documento que queremos generar en PDF.
                    $html='
                    <html>
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>Carnet de socio.</title>
                    </head>
                    <body>

                    <h5>Carnet socio Amadeus</h5>
                    <table padding=0>
                            <tr><td colspan=2><img src=""/>'.$foto.'</td></tr>
                            <tr><td><b>N. socio: <b/></td><td><span id="nick">'.$_SESSION['usuario'].'</span></td></tr>
                            <tr><td><b>Nombre: <b/></td><td><span id="nombre">'.$_SESSION['nombre'].'</span></td></tr>
                            <tr><td><b>Apellidos: <b/></td><td><span id="apellidos">'.$_SESSION['apellidos'].'</span></td></tr>

                            <tr><td><b>Email: <b/></td><td><span id="email">'.$_SESSION['email'].'</span></td></tr>

                    </table >



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

                    if(isset($_GET['parametro']))
                    {
                          $mipdf ->stream('CarnetSocio.pdf');
                    }
                    else
                    {
                        # Enviamos el fichero PDF al navegador.
                        if(isset($_SESSION['email']) && $_SESSION['email'] != '')
                        {
                                $envio='img/usuarios/nimo.pdf';
                                file_put_contents($envio, $mipdf->output());
                                enviarCorreo($_SESSION['nombre'],$_SESSION['email'],'Carnet socio Amadeus','Envio de Carnet',$envio);
                                echo ('Envio realizado');
                        }
                        else {echo 'No email';}
                    }
                    ?>