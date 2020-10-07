<?php

  $filtro = $_GET['busqueda'];
  $archivo = new Archivo();
  $archivos = $archivo -> buscar($filtro);

  if (count($archivos) > 0) {

?>

<table class="table table-hover">
  <thead>
    <tr class="bg-primary text-white text-center">
      <th scope="col">ID</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">CONSULTAR</th>
    </tr>
  </thead>
  <tbody>
    <?php

      foreach ($archivos as $key => $a) {
        echo "<tr class=''>";
        echo "<th>" . $a -> getId() . "</th>";
        echo "<th>" . $a -> getNombre() . "</th>";
        echo "<td class='text-center'>";
        echo "<a href='index.php?pid=" . base64_encode("./Controlador/controladorBusquedaArchivos.php") . "&id=" . $a -> getId() . "'>";
        echo "<div  class='fa fa-search-plus text-black' data-toggle='tooltip' data-placement='left' title='Consultar Organismo'></div>";
        echo "</td>";
        echo "</tr>";
      }

    ?>
  </tbody>
</table>


<!-- Errror -->
<?php } else {?>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!No se encontraron resultados!</strong>
        </div>
    </div>
  </div>
</div>
<?php } ?>
