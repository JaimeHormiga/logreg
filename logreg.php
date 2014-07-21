<?php

  //Funciones para la creacion y manipulacion de Registros de Actividades
  //Version 1.06.04
  //Autor: JaimeWeb / Jaime Hormiga
  //-----------------------------------------------------------------------

   //NOTA:
   // No se controlan los errores porque el usuario no se debe dar cuenta de que esto  esta funcionando.
   // Lo ideal seria controlar los errores volcandolos en un archivo de texto.
   //-------------------------------------------------------------------------------


  //Abre (o crea) un archivo conla fecha actual en modo 'anadir'
  //Devuelve un manejador de archivo abierto
  function abrirLog(){
      $nombre = date("md_Y");
      $nombre .= ".dat";
      $fichero = fopen("data/$nombre",'a+');
      return $fichero;
  }//abrirLog


  //Cierra el fichero al que apunta el manejador pasado como argumento
  function cerrarLog($fichero){
   fclose($fichero);
  }//cerrarLog


  //Escribe una entrada en el registro
  //Necesita el manejador del fichero abierto para escribir y el mensaje a escribir.
  //Adjunta la hora actual al mensaje que se le pasa como argumento.
  function escribirLinea($fichero,$mensaje){
     $hora = date("H:i:s");
     $total = $hora." :: ".$mensaje."\n";
     fwrite($fichero,$total);
  }

  //Muestra el contenido de un fichero
  //Necesita la RUTA del fichero en el argumento
  function leerFichero($ruta){
      echo nl2br(file_get_contents($ruta));
  }


  //---------------------------------------------------------------------------
  //Esta son las unicas funciones que es necesariamos colocar en el archivo PHP
  //que queremos usar.


  //Realiza la secuencia completa necesaria para escribir en el fichero de registro.
  //El unico argumento que necesita es el mensaje a escribir.
  function guardarLog($mensaje){
    $fp = abrirLog();
    escribirLinea($fp,$mensaje);
    cerrarLog($fp);
  }//guardarLog


  //Muestra el fichero de registro de la fecha actual
  //No necesita ningún argumento porque él mismo
  //crea la ruta.
  //Se usa: echo mostrarLogActua();
  function mostrarLogActual(){
    $nombre = date("md_Y");
    $nombre .= ".dat";
    $ruta = "data/$nombre";
    leerFichero($ruta);
  }


// Funciones complementarias implimentadas por terceros
//-----------------------------------------------------
function getRealIP()
{

   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );

      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR

      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\\./',
                  '/^127\\.0\\.0\\.1/',
                  '/^192\\.168\\..*/',
                  '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/',
                  '/^10\\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }

   return $client_ip;

}

/* EJEMPLOS DE USO:

   //Guardar anotacion
   include_once("incl/logreg.php");
  guardarLog("$_SESSION[nombre] ha accedido al sistema.");


 //Mostrar contenido
  <textarea id="salida" readonly="readonly">
    <? php mostrarLogActual(); ? >
  </textarea>

*/


?>