{"filter":false,"title":"cancion.php","tooltip":"/doctrine/cancion.php","undoManager":{"mark":12,"position":12,"stack":[[{"start":{"row":0,"column":0},"end":{"row":37,"column":1},"action":"insert","lines":["<?php","","/**"," * @Entity @Table(name=\"registro\")"," */","class disco {","    ","    /**","     * @var int","     * @Id","     * @Column(type=\"integer\") @GeneratedValue","     */","    protected $id;","    ","    /**","     * @var string","     * @Column(type=\"string\", length=200, unique=true, nullable=false)","     */","    protected $titulo;","    ","    public function getId() {","        return $this->id;","    }","        ","        ","    public function setId($id) {","        $this->id = $id;","        return $this;","    }","    ","    public function getTitulo() {","        return $this->id;","    }","    public function setTitulo($titulo) {","        $this->titulo = $titulo;","        return $this;","    }","}"],"id":1}],[{"start":{"row":5,"column":10},"end":{"row":5,"column":11},"action":"remove","lines":["o"],"id":2}],[{"start":{"row":5,"column":9},"end":{"row":5,"column":10},"action":"remove","lines":["c"],"id":3}],[{"start":{"row":5,"column":8},"end":{"row":5,"column":9},"action":"remove","lines":["s"],"id":4}],[{"start":{"row":5,"column":7},"end":{"row":5,"column":8},"action":"remove","lines":["i"],"id":5}],[{"start":{"row":5,"column":6},"end":{"row":5,"column":7},"action":"remove","lines":["d"],"id":6}],[{"start":{"row":5,"column":6},"end":{"row":5,"column":7},"action":"insert","lines":["c"],"id":7}],[{"start":{"row":5,"column":7},"end":{"row":5,"column":8},"action":"insert","lines":["a"],"id":8}],[{"start":{"row":5,"column":8},"end":{"row":5,"column":9},"action":"insert","lines":["n"],"id":9}],[{"start":{"row":5,"column":9},"end":{"row":5,"column":10},"action":"insert","lines":["c"],"id":10}],[{"start":{"row":5,"column":10},"end":{"row":5,"column":11},"action":"insert","lines":["i"],"id":11}],[{"start":{"row":5,"column":11},"end":{"row":5,"column":12},"action":"insert","lines":["o"],"id":12}],[{"start":{"row":5,"column":12},"end":{"row":5,"column":13},"action":"insert","lines":["n"],"id":13}]]},"ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":15,"column":18},"end":{"row":15,"column":18},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1484762219964,"hash":"48cd01fe3a8413fdc80ab3a412516202d3c2e332"}