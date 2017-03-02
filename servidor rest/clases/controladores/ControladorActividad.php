<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class ControladorActividad{
    
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
                switch(count($this->pRest)) {
                    
                    case 1: $actividades = $modelo->getActividades();
                            return $actividades;
                        break;
                    
                    case 2: $actividad = $modelo->getActividad($this->pRest[1]);
                            return $actividad; 
                        break;
                        
                    case 3: 
                        switch($this->pRest[1]){
                            case 'profesor': $actividad = $modelo->getActividadByIdProfesor($this->pRest[2]);
                                            return $actividad;
                                break;
                            
                            case 'grupo': $actividad = $modelo->getActividadByIdGrupo($this->pRest[2]);
                                        return $actividad;
                                break;
                                
                            default: 
                                return 'Params not valids';
                        }
                    
                    default:
                        return 'URL not valid';
                }
                
                break;
                
            case "POST": //Insertar datos
                return $modelo->insertActividad($this->json);
                break;
                
            case "PUT": //Actualizar datos
                return $modelo->updateActividad($this->json);
                break;
                
            case "DELETE": //Borrar datos
                return $modelo->deleteActividad($this->json);
                break;
               
            default:
                echo 'Error, Wrong protocol!!!!';
        }
    }
    
}  