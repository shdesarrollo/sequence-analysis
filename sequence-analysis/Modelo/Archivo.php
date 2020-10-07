<?php

  require './Controlador/ArchivoDAO.php';

  class Archivo {

    private $id;
    private $nombre;
    private $secuencia;
    private $descripcion;
    private $imagen;
    private $conexion;
    private $archivoDAO;

    function getId(){
        return $this -> id;
    }

    function getNombre(){
        return $this -> nombre;
    }

    function getSecuencia(){
        return $this -> secuencia;
    }

    function getDescripcion(){
        return $this -> descripcion;
    }

    function getImagen(){
        return $this -> imagen;
    }

    function Archivo ($id = "", $nombre = "", $secuencia = "", $descripcion = "", $imagen = "") {
      $this -> id = $id;
      $this -> nombre = $nombre;
      $this -> secuencia = $secuencia;
      $this -> descripcion = $descripcion;
      $this -> imagen = $imagen;
      $this -> conexion = new Conexion();
      $this -> archivoDAO = new ArchivoDAO($id, $nombre, $secuencia, $descripcion, $imagen);
    }

    function autenticar(){
        $this -> conexion -> abrir();
        $this -> conexion -> ejecutar($this -> archivoDAO -> autenticar());
        if($this -> conexion -> numFilas() == 1){
            $registro = $this -> conexion -> extraer();
            $this -> id = $registro[0];
            $this -> nombre = $registro[1];
            $this -> secuencia = $registro[2];
            $this -> descripcion = $registro[3];
            $this -> imagen = $registro[4];
            $this -> conexion -> cerrar();
            return true;
        }else{
            $this -> conexion -> cerrar();
            return false;
        }
    }

    function consultar(){
        $this -> conexion -> abrir();
        $this -> conexion -> ejecutar($this -> archivoDAO -> consultar());
        $registro = $this -> conexion -> extraer();
        $this -> id = $registro[0];
        $this -> nombre = $registro[1];
        $this -> secuencia = $registro[2];
        $this -> descripcion = $registro[3];
        $this -> imagen = $registro[4];
        $this -> conexion -> cerrar();
    }

    function buscar($filtro){
        $this -> conexion -> abrir();
        $this -> conexion -> ejecutar($this -> archivoDAO -> buscar($filtro));
        $registros = array();
        for($i = 0; $i < $this -> conexion -> numFilas(); $i++){
            $registro = $this -> conexion -> extraer();
            $registros[$i] = new Archivo($registro[0], $registro[1], $registro[2], $registro[3], $registro[4]);
        }
        return $registros;
    }

    function consultarTodos(){
        $this -> conexion -> abrir();
        $this -> conexion -> ejecutar($this -> archivoDAO -> consultarTodos());
        $registros = array();
        for($i = 0; $i < $this -> conexion -> numFilas(); $i++){
            $registro = $this -> conexion -> extraer();
            $registros[$i] = new Archivo($registro[0], $registro[1], $registro[2], $registro[3], $registro[4]);
        }
        return $registros;
    }

  }

?>
