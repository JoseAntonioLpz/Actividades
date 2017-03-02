<?php

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

class GestorActividad{
    private $gestor;
    
    function __construct($entityManager = null){
        $this->gestor = $entityManager;
        if($entityManager===null){
            $b = new Bootstrap();
            $this->gestor = $b->getEntityManager();
        }
    }
     
    function addActividad(Actividad $actividad){
        try{
            $this->gestor->persist($actividad);
            //$this->gestor->merge($actividad);
            $this->gestor->flush();
            return $actividad->getId();
        }catch(Exception $e){
            var_dump($e->getMessage());
            return 0;
        }
    }
    
    function addActividadYConsulta(Actividad $actividad){
        $id = $this->addActividad($actividad);
        if($id > 0) {
            return $this->getActividades();
            //return $actividades;
        }
        return 0;
    }
     
    function deleteActividad(Actividad $actividad){
         try {
             $this->gestor->remove($actividad);
             $this->gestor->flush();
             return 1;
         } catch (Exception $e) {
             return 0;
         }
    }
     
    function updateActividad(Actividad $actividad){
         try{
             $actividad = $actividad;
             //$actividad->setDescripcionLarga('hdoisaghiupasgfipagfip');
             $this->gestor->flush();
             return $actividad->getId();
         }catch(Exception $e){
             $e->getMessage();
             return 0;
         }
    }
    
    function updateActividadYConsulta(Actividad $actividad){
        $id = $this->updateActividad($actividad);
        if($id > 0) {
            $actividades = $this->getActividades();
            return $actividades;
        }
        return 0;
    }
     
    function getActividad($id){
        try{
            $actividad = $this->gestor->getRepository('Actividad')->findOneBy(array('id' => $id));
            return $actividad;
        }catch(Exception $e){
            return 0;
        }
    }
    
    function getActividades(){
        try{
            $repositorio = $this->gestor->getRepository('Actividad');
            $actividades = $repositorio->findAll();
            $response    = array();
            
            foreach ($actividades as $actividad){
                $response[] = $actividad->getArray();
            }
            
            return $response;
            
        }catch(Exception $e){
            return 0;
        }
    }
    
    function getActividadByIdProfesor($idProfesor){
        //Retorna un Array de las actividades del profesor
        $dql = 'select r FROM Actividad r where r.idprofesor = :idprofesor order by r.id desc';
        try{
            $query = $this->gestor->createQuery($dql)
                        ->setParameter('idprofesor', $idProfesor);
            $actividades = $query->getResult();
            $response    = array();
            
            foreach ($actividades as $actividad){
                $response[] = $actividad->getArray();
            }
            
            return $response;
        }catch(Exception $e){
            return 0;
        }
    }
    
    function getActividadByIdGrupo($idGrupo){
         //Retorna un Array de las actividades del grupo
        $dql = 'select r FROM Actividad r where r.idgrupo = :idgrupo order by r.id desc';
        try{
            $query = $this->gestor->createQuery($dql)
                        ->setParameter('idgrupo', $idGrupo);
            $actividades = $query->getResult();
            $response    = array();
            
            foreach ($actividades as $actividad){
                $response[] = $actividad->getArray();
            }
            
            return $response;
        }catch(Exception $e){
            return 0;
        }
    }
}