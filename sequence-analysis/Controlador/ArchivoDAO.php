<?php

  class ArchivoDAO {

    private $id;
    private $nombre;
    private $secuencia;
    private $descripcion;
    private $imagen;

    function ArchivoDAO ($id = "", $nombre = "", $secuencia = "", $descripcion = "", $imagen = "") {
      $this -> id = $id;
      $this -> nombre = $nombre;
      $this -> secuencia = $secuencia;
      $this -> descripcion = $descripcion;
      $this -> imagen = $imagen;
    }

    function autenticar(){
        return "select *
                from bases b
                where b.NOMBRE = '" . $this -> nombre . "'";
    }

    function consultar(){
        return "select *
                from bases b
                where b.ID = '" . $this -> id . "'";
    }

    function buscar($filtro){
        return "select ID, NOMBRE, SECUENCIA, DES, IMG
                from bases
                where NOMBRE LIKE '%" . $filtro . "%' OR ID LIKE '%" . $filtro . "%'";
    }

    function consultarTodos(){
        return "select ID, NOMBRE, SECUENCIA, DES, IMG
                from bases";
    }

  }

?>
