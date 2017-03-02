<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class ControladorProfesor {
    
    private $metodo, $json, $pRest, $pGet;
    function __construct($metodo, $json, $pRest, $pGet){
        $this->metodo = $metodo;
        $this->json = $json;
        $this->pRest = $pRest;
        $this->pGet = $pGet;
    }
    
    function realizarOperacion(){
        
        $modelo = new Modelo();
        
        switch ($this->metodo){
            case "GET": //Obtener datos
                switch(count($this->pRest)){
                    case 1: $profesores = $modelo->getProfesores();
                            return $profesores;
                        break;
                    
                    case 2: $profesor = $modelo->getProfesor($this->pRest[1]);
                            return $profesor;
                        break;
                    
                    default: 
                        echo 'URL not valid';
                }
                
            case "POST": //Insertar datos
                $modelo->insertProfesor($this->json);
                break;
                
            case "PUT": //Actualizar datos
                $modelo->updateProfesor($this->json);
                break;
                
            case "DELETE": //Borrar datos
                $modelo->deleteProfesor($this->json);
                break;
                
            default:
                echo 'Error, Wrong protocol!!!!';
        }    
    }
}