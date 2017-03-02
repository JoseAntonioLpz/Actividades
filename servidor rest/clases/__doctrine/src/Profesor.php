<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="profesor")
 */
class Profesor{
    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    protected $id;
    
    /**
     * @Column(type="string", length=50, unique=false, nullable=false)
     */
    protected $nombre;
    
    /**
     * @OneToMany(targetEntity="Actividad", mappedBy="profesor")
     */
    protected $idp = null;
    
    public function __construct() {
        $this->idp = new ArrayCollection();
    }

    
        public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }
    
    public function addIdp($idp){
        $this->idp[] = $idp;
    }
    
    function __toString(){
        return 'Profesor: ' . $this->getId() . ' ' . $this->getNombre();
    }
}
