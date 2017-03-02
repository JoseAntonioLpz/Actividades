<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class ControladorGrupo {
    
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
                    case 1: $grupos = $modelo->getGrupos();
                            return $grupos;
                        break;
                    
                    case 2: $grupo = $modelo->getGrupo($this->pRest[1]);
                            return $grupo;
                        break;
                    
                    default: 
                        echo 'URL not valid';
                }
                
            case "POST": //Insertar datos
                $modelo->insertGrupo($this->json);
                break;
                
            case "PUT": //Actualizar datos
                $modelo->updateGrupo($this->json);
                break;
                
            case "DELETE": //Borrar datos
                $modelo->deleteGrupo($this->json);
                break;
                
            default:
                echo 'Error, Wrong protocol!!!!';
        }    
    }
}