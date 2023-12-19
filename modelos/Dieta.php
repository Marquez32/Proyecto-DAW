<?php

    class Dieta {

        private $idDieta;
        private $nombreDieta;
        private $tipoDieta;
        private $descripcionDieta;
        private $observacionesDieta;

        public function __construct($idDieta, $nombreDieta, $tipoDieta, $descripcionDieta, $observacionesDieta) {
            $this->idDieta = $idDieta;
            $this->nombreDieta = $nombreDieta;
            $this->tipoDieta = $tipoDieta;
            $this->descripcionDieta = $descripcionDieta;
            $this->observacionesDieta = $observacionesDieta;
        }

        public function getIdDieta() {
            return $this->idDieta;
        }

        public function getNombreDieta() {
            return $this->nombreDieta;
        }

        public function getTipoDieta() {
            return $this->tipoDieta;
        }

        public function getDescripcionDieta() {
            return $this->descripcionDieta;
        }

        public function getObservacionesDieta() {
            return $this->observacionesDieta;
        }
        

        public function setTipoDieta($tipoDieta) {
            $this->tipoDieta = $tipoDieta;
        }
    }
?>