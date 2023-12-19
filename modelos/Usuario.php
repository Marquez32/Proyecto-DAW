<?php

    class Usuario {

        private $id;
        private $nombre;
        private $apellidos;
        private $nick;
        private $contrasegna;
        private $correo;
        private $telefono;
        private $fechaNacimiento;
        private $idDieta;
        private $idImagen;

        public function __construct($id, $nombre, $apellidos, $nick, $contrasegna, $correo, 
                $telefono, $fechaNacimiento, $idDieta, $idImagen) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->nick = $nick;
            $this->contrasegna = $contrasegna;
            $this->correo = $correo;
            $this->telefono = $telefono;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->idDieta = $idDieta;
            $this->idImagen = $idImagen;
        }

        public function getId() {
            return $this->id;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getApellidos() {
            return $this->apellidos;
        }

        public function getNick() {
            return $this->nick;
        }

        public function getContrasegna() {
            return $this->contrasegna;
        }

        public function getCorreo() {
            return $this->correo;
        }

        public function getTelefono() {
            return $this->telefono;
        }

        public function getFechaNacimiento() {
            return $this->fechaNacimiento;
        }

        public function getIdDieta() {
            return $this->idDieta;
        }

        public function getIdImagen() {
            return $this->idImagen;
        }
        
    }

?>