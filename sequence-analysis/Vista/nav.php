
<!-- Nav -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php"><i class="fas fa-dna"></i> Alineamientos</a>
  <ul class="nav nav-pills">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">Alineamiento</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="index.php?pid=<?php echo base64_encode("./Vista/busqueda.php")?>">Busqueda</a>
        <a class="dropdown-item" href="index.php?pid=<?php echo base64_encode("./Vista/global.php")?>">Global</a>
        <a class="dropdown-item" href="index.php?pid=<?php echo base64_encode("./Vista/local.php")?>">Local</a>
      </div>
    </li>
  </ul>
  <div>
    <a href="index.php?pid=<?php echo base64_encode("./Vista/dotplot.php")?>">Dotplot</a>
  </div>
  <ul class="nav nav-pills">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">Alineamiento Con Gaps</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="index.php?pid=<?php echo base64_encode("./Vista/localGaps.php")?>">Local Con Gaps</a>
      </div>
    </li>
  </ul>
</nav>
