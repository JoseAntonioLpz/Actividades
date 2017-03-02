<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class GestorGrupo {
    private $gestor;
    
    function __construct($entityManager = null){
        $this->gestor = $entityManager;
        if($entityManager===null){
            $b = new Bootstrap();
            $this->gestor = $b->getEntityManager();
        }
    }
    
    function addGrupo(Grupo $grupo){
        try{
            $this->gestor->persist($grupo);
            $this->gestor->flush();
            return $grupo->getId();
        }catch(Exception $e){
            return -1;
        }
    }
    
    function getGrupo($id){
        try{
            //$grupo = $this->gestor->getReference('Grupo', $id);
            $grupo = $this->gestor->getRepository('Grupo')->findOneBy(array('id' => $id));
            return $grupo;
        }catch(Exception $e){
            return -1;
        }
    }
    
    function getGrupoArray($id){
        try{
            //$grupo = $this->gestor->getReference('Grupo', $id);
            $grupo = $this->gestor->getRepository('Grupo')->findOneBy(array('id' => $id));
            return $grupo->getArray();
        }catch(Exception $e){
            return -1;
        }
    }
    
    function getGrupos(){
        try{
            $repositorio = $this->gestor->getRepository('Grupo');
            $grupos = $repositorio->findAll();
            $response = array();
            
            foreach ($grupos as $grupo){
                $response[] = $grupo->getArray();
            }
            return $response;
        }catch(Exception $e){
            return -1;
        }
    }
    
    function updateGrupo(Grupo $grupo){
        try{
             $grupo = $grupo;
             $this->gestor->flush();
             return $grupo->getId();
         }catch(Exception $e){
             return -1;
         }
    }
    
    function deleteGrupo(Grupo $grupo){
        try {
             $this->gestor->remove($grupo);
             $this->gestor->flush();
             return 1;
         } catch (Exception $e) {
             return 0;
         }
    }
}