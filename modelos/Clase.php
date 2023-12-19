<?php 

    class Clase {

        private $idClase;
        private $nombreClase;
        private $nivel;
        private $diaSemana;
        private $horaInicio;
        private $horaFin;

        public function __construct($idClase, $nombreClase, $nivel, $diaSemana, $horaInicio, $horaFin) {
            $this->idClase = $idClase;
            $this->nombreClase = $nombreClase;
            $this->nivel = $nivel;
            $this->diaSemana = $diaSemana;
            $this->horaInicio = $horaInicio;
            $this->horaFin = $horaFin;
        }

        public function getIdClase() {
            return $this->idClase;
        }

        public function getNombreClase() {
            return $this->nombreClase;
        }

        public function getNivel() {
            return $this->nivel;
        }

        public function getDiaSemana() {
            return $this->diaSemana;
        }

        public function getHoraInicio() {
            return $this->horaInicio;
        }

        public function getHoraFin() {
            return $this->horaFin;
        }
    }
?>