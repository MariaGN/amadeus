

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
                    if(isset($_SESSION['fotografia'])&& $_SESSION['fotografia']!='')
                        echo '<li><a href="borrarfoto.php"/>Borrar fotografía</a></li>';
                    ?>
                    <li><a href="bajausuario.html" />Darse de Baja</a></li>
                </ul>
                </p>
            </div>
        </div>

        <div class="grid-6 grid">
            <h3>Fotografía de su perfil</h3>
            <div id="mensajes"></div>
            <form action="upload.php" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
                <p>
                    <input type="file" name="ficherosubido" name="ficherosubido" /><br/> Exensiones: jpg, jpeg, gif, png.
                    
                </p>

                <p>
                    <input type="reset" value="Limpiar" class="float_right">
                    <input type="submit" value="Modificar" class="float_right" />
                </p>
            </form>

        </div><!--end of grid-6-->
        <div class="grid-4 grid">
            <?php
                if(isset($_SESSION['fotografia'])&& $_SESSION['fotografia']!='')
                    echo "<img src='img/usuarios/{$_SESSION['fotografia']}'";
                else
                    echo "Foto avatar no disponible";
            ?>
        </div>
    </div><!--end of grids-->

</div>