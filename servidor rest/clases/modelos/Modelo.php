<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class Modelo {
    
    private $gestorActividad, $gestorProfesor, $gestorGrupo, $gestor;
    
    function __construct(){
        $b = new Bootstrap();
        $this->gestor = $b->getEntityManager();
        $this->gestorProfesor = new GestorProfesor($this->gestor);
        $this->gestorActividad = new GestorActividad($this->gestor);
        $this->gestorGrupo = new GestorGrupo($this->gestor);
    }
    
    function insertProfesor($objeto){
        $prof = new Profesor();
        $prof->setNombre($objeto->nombre);
        return $this->gestorProfesor->addProfesor($prof);
    }
    
    function insertActividad($objeto){
        $ruta1 = '../Imagenes/';
        $ruta2 = 'http://192.168.208.18:8181/ws/Imagenes/';
        $rand = rand();
        $act = new Actividad();
        $profesor = $this->gestorProfesor->getProfesor($objeto->idProfesor);
        $act->setProfesor($profesor);
        $grupo = $this->gestorGrupo->getGrupo($objeto->idGrupo);
        $act->setGrupo($grupo);
        $act->setDescripcionCorta($objeto->descripcionCorta);
        $act->setDescripcionLarga($objeto->descripcionLarga);
        $act->setFecha(date_create($objeto->fecha));
        $act->setLugar($objeto->lugar);
        $act->setHoraInicial(date_create($objeto->horaInicial));
        $act->setHoraFin(date_create($objeto->horaFin));
        // $act->setFotoExcursion($objeto->fotoExcursion);
        $Base64Img = $objeto->fotoExcursion;
        if($Base64Img != ""){
            $Base64Img = base64_decode($Base64Img);
            file_put_contents($ruta1 . $rand . '.png', $Base64Img);
            $act->setFotoExcursion($ruta2 . $rand . '.png');
        }
        return $this->gestorActividad->addActividadYConsulta($act);
    }
    
    function insertGrupo($objeto){
        $grupo = new Grupo();
        $grupo->setNombre($objeto->nombre);
        return $this->gestorGrupo->addGrupo($grupo);
    }
    
    function deleteProfesor($objeto){
        $profesor = $this->gestorProfesor->getProfesor($objeto->id);
        return $this->gestorProfesor->deleteProfesor($profesor);
    }
    
    function deleteActividad($objeto){
        $actividad = $this->gestorActividad->getActividad($objeto->id);
        return $this->gestorActividad->deleteActividad($actividad);
    }
    
    function deleteGrupo($objeto){
        $grupo = $this->gestorGrupo->getGrupo($objeto->id);
        return  $this->gestorGrupo->deleteGrupo($grupo);
    }
    
    function updateProfesor($objeto){
        $prof = $this->gestorProfesor->getProfesor($objeto->id);
        $prof->setNombre($objeto->nombre);
        
        return $this->gestorProfesor->updateProfesor($prof);
    }
    
    function updateActividad($objeto){
        $ruta1 = '../Imagenes/';
        $ruta2 = 'http://192.168.208.18:8181/ws/Imagenes/';
        $rand = rand();
        $act = $this->gestorActividad->getActividad($objeto->id);
        $profesor = $this->gestorProfesor->getProfesor($objeto->idProfesor);
        $act->setProfesor($profesor);
        $grupo = $this->gestorGrupo->getGrupo($objeto->idGrupo);
        $act->setGrupo($grupo);
        $act->setDescripcionCorta($objeto->descripcionCorta);
        $act->setDescripcionLarga($objeto->descripcionLarga);
        $act->setFecha(date_create($objeto->fecha));
        $act->setLugar($objeto->lugar);
        $act->setHoraInicial(date_create($objeto->horaInicial));
        $act->setHoraFin(date_create($objeto->horaFin));
        //$act->setFotoExcursion($objeto->fotoExcursion);
         $Base64Img = $objeto->fotoExcursion;
        if($Base64Img != ""){
            $Base64Img = base64_decode($Base64Img);
            file_put_contents($ruta1 . $rand . '.png', $Base64Img);
            $act->setFotoExcursion($ruta2 . $rand . '.png');
        }
        
        return $this->gestorActividad->updateActividadYConsulta($act);
    }
    
    function updateGrupo($objeto){
        $grupo = $this->gestorGrupo->getGrupo($objeto->id);
        $grupo->setNombre($objeto->nombre);
        
        return $this->gestorGrupo->updateGrupo($grupo);
    }
    
    function getProfesor($paramsRest){
        $profesor = $this->gestorProfesor->getProfesorArray($paramsRest);
        return $profesor;
    }
    
    function getActividad($paramsRest){
        $actividad = $this->gestorActividad->getActividad($paramsRest);
        return $actividad;
    }
    
    function getGrupo($paramsRest){
        $grupo = $this->gestorGrupo->getGrupoArray($paramsRest);
        return $grupo;
    }
    
    function getGrupos(){
        $grupos = $this->gestorGrupo->getGrupos();
        return $grupos;
    }
    
    function getActividades(){
        $actividades = $this->gestorActividad->getActividades();
        return $actividades;
    }
    
    function getProfesores(){
        $profesores = $this->gestorProfesor->getProfesores();
        return $profesores;
    }
    
    function getActividadByIdProfesor($paramsRest){
        $actividades = $this->gestorActividad->getActividadByIdProfesor($paramsRest);
        return $actividades;
    }
    
    function getActividadByIdGrupo($paramsRest){
        $actividades = $this->gestorActividad->getActividadByIdGrupo($paramsRest);
        return $actividades;
    }
}