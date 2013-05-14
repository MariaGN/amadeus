<!--
<script type="text/javascript">  
   // $(document).ready(function(){
   //     $("#nick").blur(function(){
   //         $.post("chequeanick.php",{nick: $(this).val()},function(resultados){
    //            $("#mensajes").clearQueue().fadeTo(0,0).html(resultados)
     //           .css("background-color","green").fadeTo(1000,1).fadeTo(1000,0);
     //       });
     //       
      //  });
      
      //  });
 </script>
-->
 
<?php
require("conexion.php");
$sql=sprintf("select nick from amadeus-usuarios where nick='%s'",$_POST['nick']);
$resultados=mysql_query($sql,$conexion) or die(mysql_error());

if (mysql_num_rows($resultados)== 0)
        echo json_encode (array("estado"=>"OK","mensaje"=>"Nick libre"));
else
        echo json_encode(array("estado"=>"ERROR","mensaje"=>"!Nick no disponible!"));


//if(!isset($_POST['nick']) || $_POST['nick'] =="")
 //   echo "ERROR";
//else
//    echo "OK";    
?>