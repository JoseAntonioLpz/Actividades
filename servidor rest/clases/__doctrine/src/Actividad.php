<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="actividad")
 */
class Actividad {
    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Profesor", inversedBy="idp")
     * @JoinColumn(name="idprofesor", referencedColumnName="id")
     */
    protected $idprofesor;
    
    /**
     * @Column(type="string", length=200, unique=false, nullable=false)
     */
    protected $descripcionCorta;
    
    /**
     * @Column(type="string", length=2000, unique=false)
     */
    protected $descripcionLarga;
    
    /**
     * @ManyToOne(targetEntity="Grupo", inversedBy="idg")
     * @JoinColumn(name="idgrupo", referencedColumnName="id")
     */
    protected $idgrupo;
    
    /**
     * @Column(type="date", unique=false)
     */
    protected $fecha;
    
    /**
     * @Column(type="string", length=50, unique=false)
     */
    protected $lugar;
    
    /**
     * @Column(type="time", unique=false)
     */
    protected $horaInicial;
    
    /**
     * @Column(type="time", unique=false)
     */
    protected $horaFin;
    
    /**
     * @Column(type="string", length=2000, unique=false)
     */
    protected $fotoExcursion;
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setDescripcionCorta($descripcionCorta) {
        $this->descripcionCorta = $descripcionCorta;
        return $this;
    }
    
    public function getDescripcionCorta() {
        return $this->descripcionCorta;
    }
    
    public function setDescripcionLarga($descripcionLarga) {
        $this->descripcionLarga = $descripcionLarga;
        return $this;
    }
    
    public function getDescripcionLarga() {
        return $this->descripcionLarga;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }
    
    public function getFecha() {
        return $this->fecha;
    }
    
    public function setLugar($lugar) {
        $this->lugar = $lugar;
        return $this;
    }
    
    public function getLugar() {
        return $this->lugar;
    }
    
    public function setHoraInicial($horaInicial) {
        $this->horaInicial = $horaInicial;
        return $this;
    }
    
    public function getHoraInicial() {
        return $this->horaInicial;
    }
    
    public function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
        return $this;
    }
    
    public function getHoraFin() {
        return $this->horaFin;
    }
    
    public function setFotoExcursion($fotoExcursion) {
        $this->fotoExcursion = $fotoExcursion;
        return $this;
    }
    
    public function getFotoExcursion() {
        return $this->fotoExcursion;
    }
    
    public function setIdProfesor($profesor) {
        $profesor->addIdp($profesor->getId());
        $this->idprofesor = $profesor;
    }
    
    public function getIdProfesor() {
        return $this->idprofesor;
    }
    
    public function setIdGrupo($grupo) {
        $grupo->addIg($grupo->getId());
        $this->idgrupo = $grupo;
    }
    
    public function getIdGrupo() {
        return $this->idgrupo;
    }
    
    public function getArray(){
        
        return array("id" => $this->id,
                     "idProfesor" => $this->idprofesor->getId(),
                     "idGrupo" => $this->idgrupo->getId(),
                     "descripcionLarga" => $this->descripcionLarga,
                     "descripcionCorta" => $this->descripcionCorta,
                     "lugar" => $this->lugar,
                     "horaInicial" => $this->horaInicial,
                     "horaFin" => $this->horaFin,
                     "fecha" => $this->fecha,
                     "fotoExcursion" => $this->fotoExcursion);
    }
    
    function __toString(){
        return 'Actividad ' . $this->getLugar() . ' ' . $this->getId();
    }
}