<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class Api {
    
    private $gestor;
    private $metodo, $json, $pRest, $pGet;
    private $respuesta;
    
    function __construct($metodo, $json, $parametrosRest, $parametrosGet) {
        $this->metodo = $metodo;
        $this->json = $json;
        $this->pRest = $parametrosRest;
        $this->pGet = $parametrosGet;
        $b = new Bootstrap();
        $this->gestor = $b->getEntityManager();
    }
    
    function doJob(){
        switch($this->pRest[0]){
            case 'actividad':
                //Llamar a controlador de la actividad aqui, pasandole los datos $metodo, $json, $pRest, $pGet
                $controlador = new ControladorActividad($this->metodo, $this->json, $this->pRest, $this->pGet);
                $this->respuesta = $controlador->realizarOperacion();
                break;
                
            case 'grupo':
                $controlador = new ControladorGrupo($this->metodo, $this->json, $this->pRest, $this->pGet);
                $this->respuesta = $controlador->realizarOperacion();
                break;
                
            case 'profesor':
                $controlador = new ControladorProfesor($this->metodo, $this->json, $this->pRest, $this->pGet);
                $this->respuesta = $controlador->realizarOperacion();
                break;
                
            default:
                echo 'Error, the value ' . $this->pRest[0] . ' not exist in database';
        }
        
    }

    function getResponse(){
        return $this->respuesta;
    }
}