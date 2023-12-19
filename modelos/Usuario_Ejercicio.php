<?php

    class Usuario_Ejercicio {

        private $id;
        private $idEj;
        private $fechaRealizado;
        private $peso;
        private $numSeries;

        public function __construct($id, $idEj, $fechaRealizado, $peso, $numSeries) {
            $this->id = $id;
            $this->idEj = $idEj;
            $this->fechaRealizado = $fechaRealizado;
            $this->peso = $peso;
            $this->numSeries = $numSeries;
        }

        public function getId() {
            return $this->id;
        }

        public function getIdEj() {
            return $this->idEj;
        }

        public function getFechaRealizado() {
            return $this->fechaRealizado;
        }

        public function getPeso() {
            return $this->peso;
        }

        public function getNumSeries() {
            return $this->numSeries;
        }
    }
?>