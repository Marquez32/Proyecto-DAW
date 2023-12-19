<?php

    class Usuario_Clase {

        private $id;
        private $idClase;

        public function __construct($id, $idClase) {
            $this->id = $id;
            $this->idClase = $idClase;
        }

        public function getId() {
            return $this->id;
        }

        public function getIdClase() {
            return $this->idClase;
        }
        
    }
?>