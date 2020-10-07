<?php

  include 'nav.php';

?>

<!-- Alineamiento Local -->
<div class="container">
  <br>
  <div class="card border-primary mb-12">
    <div class="card-header text-white text-center bg-primary"><strong>ALINEAMIENTO LOCAL CON GAPS</strong></div>
    <div class="card-body">
      <form action="index.php?pid=<?php echo base64_encode("./Controlador/controladorLocalGaps.php")?>" enctype="multipart/form-data" method="post">
        <!-- Secuencias -->
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
                <input type="file" class="custom-file-input" name="secuenciaFasta" id="secuenciaFasta" accept=".txt,.fasta">
                <label class="custom-file-label" for="secuenciaFasta">FASTA UNO</label>
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
        <!-- Posiciones -->
        <div class="row">
          <div class="col-sm-1" style="margin-top: 6px;">
            <span class="badge badge-info">SECUENCIA 1</span>
          </div>
          <div class="form-group col-sm-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-hashtag" aria-hidden="true"></i></span>
              </div>
              <input type="number" name="unoA" class="form-control" min="0" max="60" placeholder="Desde">
            </div>
          </div>
          <div class="form-group col-sm-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-hashtag" aria-hidden="true"></i></span>
              </div>
              <input type="number" name="dosA" class="form-control" min="0" max="60" placeholder="Hasta">
            </div>
          </div>
          <div class="col-sm-1 align-middle" style="margin-top: 6px;">
            <span class="badge badge-success">SECUENCIA 2</span>
          </div>
          <div class="form-group col-sm-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-hashtag" aria-hidden="true"></i></span>
              </div>
              <input type="number" name="unoB" class="form-control" min="0" max="60" placeholder="Desde">
            </div>
          </div>
          <div class="form-group col-sm-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-hashtag" aria-hidden="true"></i></span>
              </div>
              <input type="number" name="dosB" class="form-control" min="0" max="60" placeholder="Hasta">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>