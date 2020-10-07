<?php

  include './Vista/busqueda.php';
  $archivo = new Archivo($_GET['id']);
  $archivo -> consultar();

?>

<!-- Resultados Seleccion Organismo -->
<div class="container">
  <br>
  <div class="row">
    <div class="col-sm-3">
      <div class="card border-primary">
      <div class="card-header bg-primary text-white text-center"><strong>IMAGEN</strong></div>
          <?php
            echo "<img src='" . $archivo -> getImagen() . "' style='height: 180px; width: 100%; display: block;''>";
          ?>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="card border-primary">
      <div class="card-header bg-primary text-white text-center"><strong>INFORMACION DEL ORGANISMO</strong></div>
        <div class="card-body text-justify">
          <?php
            echo "<b><span class='badge badge-primary'>SECUENCIA </span>";
            echo "<h7> : " . $archivo -> getSecuencia() . "</h7><br><br>";
	    echo "<b><span class='badge badge-primary'>LONGITUD </span>";
            echo "<h7> : 60</h7><br><br>";
            echo "<span class='badge badge-primary'>NOMBRE CIENTIFICO </span>";
            echo "<h7> : " . $archivo -> getNombre() . "</h7><br><br>";
            echo "<span class='badge badge-primary'>DESCRIPCION </span>";
            echo "<h7> : " . $archivo -> getDescripcion() . "</h7>";
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
