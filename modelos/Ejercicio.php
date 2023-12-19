<?php

    class Ejercicio {

        private $idEj;
        private $nombreEj;
        private $zonaTrabajada;
        private $intensidad;

        public function __construct($idEj, $nombreEj, $zonaTrabajada, $intensidad) {
            $this->idEj = $idEj;
            $this->nombreEj = $nombreEj;
            $this->zonaTrabajada = $zonaTrabajada;
            $this->intensidad = $intensidad;
        }

        public function getIdEj() {
            return $this->idEj;
        }

        public function getNombreEj() {
            return $this->nombreEj;
        }

        public function getZonaTrabajada() {
            return $this->zonaTrabajada;
        }

        public function getIntensidad() {
            return $this->intensidad;
        }

    }
?>