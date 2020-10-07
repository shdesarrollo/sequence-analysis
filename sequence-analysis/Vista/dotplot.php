<?php 

  include 'nav.php';

?>

<!-- Alineamiento Dotplot -->
<div class="container">
  <br>
  <div class="card border-primary mb-12">
    <div class="card-header text-white text-center bg-primary"><strong>ALINEAMIENTO DOTPLOT</strong></div>
    <div class="card-body">
      <form action='index.php?pid=<?php echo base64_encode("./Controlador/controladorDotplot.php")?>' enctype="multipart/form-data" method="post">
        <div class="row">
          <div class="form-group col-sm-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dna"></i></span>
              </div>
              <input type="text" class="form-control" name="secuencia" placeholder="Ingrese Secuencia Uno">
            </div>
          </div>
          <div class="form-group col-sm-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dna"></i></span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="secuenciaFasta" id="inputGroupFile02" accept=".txt,.fasta">
                <label class="custom-file-label" for="inputGroupFile02">FASTA UNO</label>
              </div>
            </div>
          </div>
          <div class="form-group col-sm-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dna"></i></span>
              </div>
              <select class="custom-select" name="secuenciaDos">
                <option value="">Seleccione Secuencia Dos</option>
                <?php

                  $archivo = new Archivo();
                  $archivos = $archivo -> consultarTodos();

                  foreach ($archivos as $key => $a) {
                    echo "<option value='" . $a -> getNombre() . "'>" . $a -> getNombre() . "</option>";
                  }

                ?>
              </select>
            </div>
          </div>
          <div class="form-group col-sm-2">
            <button type="submit" class="btn btn-success btn-block" name="alinear">ALINEAR</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
