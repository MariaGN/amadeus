<script type="text/javascript" src="js/tiempo.js"></script>
<style type="text/css">
    #zonasugerencias{
        position: absolute;
        z-index: 30;
    }

    .enlace_sugerencia_over {
        background-color: #3366CC;
    }

    div.zonaconborde {
        top: 360px;
        width:400px;
        margin-left: 180px;
        background-color: #FFFFFF; 
        text-align: left; 
        border: 1px solid #000000;
        font-size: 12px;
    }

    li{
        list-style: none;
    }
</style> 

<div class="wrapper">
    <div class="grids top">
        <div class="grid-6 grid">
            <h4>Consulta del Tiempo en Tiempo Real</h4>
            <div>
                <p><b>predicción meteorología en tiempo real</b><br/>
                <p>Teclee aeropuerto: <input type="text" name="origen" id="origen" /></p>
                <!--<p><input type="button" name="tiempo" id="tiempo" value="Consultar Predicción"/></p>-->
                <br/><b>Servicio Web</b> facilitado por <a href='http://www.wunderground.com/' target='_blank'>Wunderground</a>, utilizando <a href='http://www.wunderground.com/weather/api/' target='_blank'>Weather API REST</a>.
                
                <div id="zonasugerencias"></div>
                
          
            </div>
        </div>

        <div class="grid-10 grid">
            <div id="botontiempo"> </div>
        </div><!--end of grid-10-->
    </div><!--end of grids-->
</div>
