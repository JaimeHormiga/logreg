<?php

  //Implementacion de una clase basada en la libreria Logreg v.1.0604
  //Version 0.1403
  //Autor: JaimeWeb / Jaime Hormiga
  //-----------------------------------------------------------------------

class logreg{

    //Propiedades
    private $verbose = false; //indica si se muestran los mensajes de error
    protected $fp; //manejador de fichero
    protected $fichero = ""; //ruta completa del fichero log
    protected $mensaje; //mensaje a añadir al archivo log
    private static $ruta = "data/"; //directorio donde se grabaran los logs
    private static $ext = ".dat"; //extension de los archivos logs

    //Metodos
    function __construct($op=''){

        $this->fichero = self::$ruta;
        $this->fichero .= date("md_Y");
        $this->fichero .= self::$ext;

        switch ($op){
            case 1:
            case 'v':
            case 'V': $this->verbose = true;
                      break;
        }

    }

    //metodos publicos
    public function guardarLog($texto){
        $this->mensaje = $texto;
        $this->abrir_log();
        $this->escribir_linea();
        $this->cerrar_log();

    }

    public function mostrarLog(){
        return $this->mostrar_fichero($this->fichero);
    }

    //Metodos protegidos

    protected function abrir_log(){
      try{
        $this->fp = fopen($this->fichero,'a+');
      }
      catch(Exception $e){
        if($this->verbose):
            echo "ERROR creando log: ".$e->getMessage();
        endif;
      }
    }

    protected function cerrar_log(){
        if($this->fp) fclose($this->fp);
    }

    protected function escribir_linea(){
     $hora = date("H:i:s");
     $total = $hora." :: ".$this->mensaje."\n";
     try{
        fwrite($this->fp,$total);
     }
     catch(Exception $e){
        if($this->verbose):
            echo "ERROR escribiendo en log: ".$e->getMessage();
        endif;
      }

    }

    protected function mostrar_fichero($ruta){

        $contenido = file_get_contents($ruta);
        $contenido = nl2br($contenido);

        return $contenido;
    }

    function __destruct(){
        unset($this);
    }


}//class




 ?>