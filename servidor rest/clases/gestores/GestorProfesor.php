<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class GestorProfesor {
    private $gestor;
    
    function __construct($entityManager = null){
        $this->gestor = $entityManager;
        if($entityManager===null){
            $b = new Bootstrap();
            $this->gestor = $b->getEntityManager();
        }
    }
    
    function addProfesor(Profesor $profesor){
        try{
            $this->gestor->persist($profesor);
            $this->gestor->flush();
            return $profesor->getId();
        }catch(Exception $e){
            return 0;
        }
    }
    
    function getProfesor($id){
        
        try{
            //$profesor = $this->gestor->getReference('Profesor', $id);
            $profesor = $this->gestor->getRepository('Profesor')->findOneBy(array('id' => $id));
            return $profesor;
        }catch(Exception $e){
            return 0;
        }
    }
    
    function getProfesorArray($id){
        echo $id;
        try{
            //$profesor = $this->gestor->getReference('Profesor', $id);
            $profesor = $this->gestor->getRepository('Profesor')->findOneBy(array('id' => $id));
            return $profesor->getArray();
        }catch(Exception $e){
            return 0;
        }
    }
    
    function getProfesores(){
        try{
            $repositorio = $this->gestor->getRepository('Profesor');
            $profesores = $repositorio->findAll();
            $response = array();
            
            foreach ($profesores as $profesor){
                $response[] = $profesor->getArray();
            }
            return $response;
        }catch(Exception $e){
            return 0;
        }
    }
    
    function updateProfesor(Profesor $profesor){
        try{
             $profesor = $profesor;
             $this->gestor->flush();
             return $profesor->getId();
         }catch(Exception $e){
             return 0;
         }
    }
    
    function deleteProfesor(Profesor $profesor){
        try {
            $this->gestor->remove($profesor);
            $this->gestor->flush();
            return 1;
         }catch (Exception $e) {
            return 0;
         }
    }
}