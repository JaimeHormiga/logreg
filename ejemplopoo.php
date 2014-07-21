<?php

echo "Ejemplos de uso de la clase 'logreg'<br>";
echo "-----------------------------------<br><br>";

require_once('logreg_class.php');

$registro = new logreg(1); //activo el modo verbose

//Meto informacion (los sleeps son para que se vea como cambia el tiempo)
$registro->guardarLog("Jose ha entrado al sistema");
sleep(5);
$registro->guardarLog("Paco ha entrado al sistema");
sleep(10);
$registro->guardarLog("Jose esta borrando datos de la tabla productos");

//Muestro el archivo log
echo $registro->mostrarLog();








 ?>