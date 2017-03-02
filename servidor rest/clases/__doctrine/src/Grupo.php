<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="grupo")
 */
class Grupo{
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
     * @OneToMany(targetEntity="Actividad", mappedBy="grupo")
     */
    protected $idg = null;
    
    public function __construct() {
        $this->idg = new ArrayCollection();
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
    
    public function addIdg($idg){
        $this->idg[] = $idg;
    }
    
    function __toString(){
        return 'Grupo: ' . $this->getId() . ' ' . $this->getNombre();
    }
    // shell> .../vendor/bin/doctrine orm:schema-tool:update --force
}
