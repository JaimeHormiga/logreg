<?php

echo "Ejemplos de uso de la libreria 'logreg' <br>";
echo "-------------------------------------- <br><br>";

require_once('logreg.php');



//Meto informacion (los sleeps son para que se vea como cambia el tiempo)
guardarLog("Jose ha entrado al sistema");
sleep(5);
guardarLog("Paco ha entrado al sistema");
sleep(10);
guardarLog("Jose esta borrando datos de la tabla productos");

//Muestro el archivo log
mostrarLogActual();








 ?>