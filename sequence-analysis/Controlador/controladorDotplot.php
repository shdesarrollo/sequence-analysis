<?php

  include './Vista/dotplot.php';

  $error = 0;
  $puntaje = 0;
  $arrFastaUno = "secuenciaA.txt";
  $arrAlineamiento = array();
  $secuencia = "";
  $secuenciaDos = "";

  // Secuencia escrita
  if (isset($_POST['secuencia'])) {
    $secuencia = $_POST['secuencia'];
    $secuencia1 = strtoupper($secuencia);
    $arrUno = str_split($secuencia1);
  }

  // Secuencia Seleccionada
  if (isset($_POST['secuenciaDos'])) {
    $archivo = new Archivo("", $_POST['secuenciaDos']);
    if ($archivo -> autenticar()) {
      $secuenciaDos = $archivo -> getSecuencia();
    }
    $secuenciaDos = substr($secuenciaDos, 0, 20);
    $arrDos = str_split($secuenciaDos);
  }

  // Alineamiento
  if (isset($_POST['alinear'])) {

    if ($_POST['secuencia'] !== "" && !file_exists($_FILES['secuenciaFasta']['tmp_name']) && $_POST['secuenciaDos'] !== "") {
      // Alineamiento Global

      // Datos Secuencia Dos
      //
      $archivo = new Archivo("", $_POST['secuenciaDos']);

      if ($archivo -> autenticar()) {
        $nomTaxonomiaB = $archivo -> getNombre();
      } else {
        $nomTaxonomiaB = "";
      }
      //
      //
      $alineamiento = "";
      $contador = 0;
      $permitidos = " AaTtGgCc";

      for ($i=0; $i < count($arrUno); $i++) {
        if (strpos($permitidos, substr($secuencia, $i, 1), 0)) {

        } else {
          $error = 4;
        }
      }

      if ($error != 4) {
        if (count($arrUno) <= 20) {
          //if (count($arrUno) >= 20) {
            if (count($arrUno) < count($arrDos)) {
              for ($i=0; $i < count($arrUno) ; $i++) {
                if ($arrDos[$i] == $arrUno[$i]) {
                  $contador++;
                  $arrAlineamiento[$i] = "|";
                } else {
                  $arrAlineamiento[$i] = "_";
                }
                $alineamiento = implode(" ", $arrAlineamiento);
              }
            } else if (count($arrUno) > count($arrDos)) {
              for ($i=0; $i < count($arrDos) ; $i++) {
                if ($arrDos[$i] == $arrUno[$i]) {
                  $contador++;
                  $arrAlineamiento[$i] = "|";
                } else {
                  $arrAlineamiento[$i] = "_";
                }
                $alineamiento = implode(" ", $arrAlineamiento);
              }
            } else {
              for ($i=0; $i < count($arrDos) ; $i++) {
                if ($arrDos[$i] == $arrUno[$i]) {
                  $contador++;
                  $arrAlineamiento[$i] = "|";
                } else {
                  $arrAlineamiento[$i] = "_";
                }
                $alineamiento = implode(" ", $arrAlineamiento);
                $puntaje = ($contador * 100) / count($arrUno);
              }
            }
          //} else {
            //$error = 3;
          //}
        } else {
          $error = 2;
        }
      }

    } else if (file_exists($_FILES['secuenciaFasta']['tmp_name']) && $_POST['secuencia'] == "" && $_POST['secuenciaDos'] !== "") {
      // Alineamiento Global FASTA

      // Archivo A
      if (!file_exists($arrFastaUno) && $secuencia === "") {
        $carpeta = "./";
        opendir($carpeta);
        $destino = 'secuenciaA.txt';
        copy($_FILES['secuenciaFasta']['tmp_name'], $destino);
      } else if (file_exists($arrFastaUno) && $secuencia === "") {
        $carpeta = "./";
        opendir($carpeta);
        $destino = 'secuenciaA.txt';
        copy($_FILES['secuenciaFasta']['tmp_name'], $destino);
      }
      //

      $alineamiento = "";
      $contador = 0;
      $permitidos = ' AaTtGgCc';

      $contenidoFastaUno = file_get_contents($arrFastaUno);

      $taxonomiaA = explode("|", $contenidoFastaUno);
      $nomTaxonomiaA = substr($taxonomiaA[1], 0);
      $tokenA = explode("\n", $contenidoFastaUno);
      $cadenaUno = substr($tokenA[1], 0, 20);
      $secuenciaUno = strval($cadenaUno);
      $secuenciaUnoFasta = str_split($secuenciaUno);
      $arrUno = $secuenciaUnoFasta;

      //
      $archivo = new Archivo("", $_POST['secuenciaDos']);

      if ($archivo -> autenticar()) {
        $nomTaxonomiaB = $archivo -> getNombre();
      } else {
        $nomTaxonomiaB = "";
      }
      //

      for ($i=0; $i < count($arrUno); $i++) {
        if (strpos($permitidos, substr($secuenciaUno, $i, 1), 0)) {

        } else {
          $error = 4;
        }
      }

      if ($error != 4) {
        if (count($arrUno) <= 20) {
          //if (count($arrUno) >= 20) {
            if (count($arrUno) < count($arrDos)) {
              for ($i=0; $i < count($arrUno); $i++) {
                if ($arrDos[$i] == $arrUno[$i]) {
                  $contador++;
                  $arrAlineamiento[$i] = "|";
                } else {
                  $arrAlineamiento[$i] = "_";
                }
                $alineamiento = implode(" ", $arrAlineamiento);
              }
            } else if (count($arrUno) > count($arrDos)) {
              for ($i=0; $i < count($arrDos) ; $i++) {
                if ($arrDos[$i] == $arrUno[$i]) {
                  $contador++;
                  $arrAlineamiento[$i] = "|";
                } else {
                  $arrAlineamiento[$i] = "_";
                }
                $alineamiento = implode(" ", $arrAlineamiento);
              }
            } else {
              for ($i=0; $i < count($arrDos); $i++) {
                if ($arrDos[$i] == $arrUno[$i]) {
                  $contador++;
                  $arrAlineamiento[$i] = "|";
                } else {
                  $arrAlineamiento[$i] = "_";
                }
                $alineamiento = implode(" ", $arrAlineamiento);
                $puntaje = ($contador * 100) / count($arrUno);
              }
            }
          //} else {
            //$error = 3;
          //}
        } else {
          $error = 2;
        }
      }

    } else if (file_exists($_FILES['secuenciaFasta']['tmp_name']) && $_POST['secuencia'] !== "") {
      $error = 5;
    } else {
      $error = 1;
    }
  }

?>

<!-- Resultados -->
<br>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <!-- Erorres -->
      <?php if ($error == 1) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!Por favor ingrese un dato valido!</strong>
        </div>

      <?php } else if ($error == 2) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!La cadena es mayor a 20, intentelo nuevamente!</strong>
        </div>

      <?php } else if ($error == 3) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!La cadena es menor a 20, intentelo nuevamente!</strong>
        </div>

      <?php } else if ($error == 4) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!Hay caracteres invalidos en la cadena, intentelo nuevamente!</strong>
        </div>

      <?php } else if ($error == 5) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!Ingrese solo la cadena escrita o por archivo FASTA, intentelo nuevamente!</strong>
        </div>

      <?php } ?>
    </div>
    <div class="col-sm-4">
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>SECUENCIAS</strong></div>
          <div class="card-body">
            <?php

              echo '<strong>SECUENCIA INGRESADA: <span class="badge badge-info">AZUL</span></strong>';
              echo '<strong>SECUENCIA SELECCIONADA: <span class="badge badge-danger">ROJA</span></strong>';

            ?>
          </div>
        </div>

      <?php } ?>
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>DATOS SECUENCIA INGRESADA</strong></div>
          <div class="card-body">
            <?php

              echo "<strong>TAMAÑO: " . count($arrUno) . "</strong><br>";
              echo "<strong>ORGANISMO: ";
              echo ($_POST['secuencia'] == "") ? $nomTaxonomiaA : "No aplica";
              echo "</strong>";

            ?>
          </div>
        </div>

      <?php } ?>
      <br>
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>DATOS SECUENCIA SELECCIONADA</strong></div>
          <div class="card-body">
            <?php

              echo "<strong>TAMAÑO: " . count($arrDos) . "</strong><br>";
              echo "<strong>ORGANISMO: " . $nomTaxonomiaB . "</strong>";

            ?>
          </div>
        </div>

      <?php } ?>
      <br>
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>DATOS ALINEAMIENTO</strong></div>
          <div class="card-body">
            <?php

              echo "<strong>PUNTAJE: " . $contador . "</strong><br>";
              echo "<strong>PORCENTAJE: ";
              echo (count($arrUno) == count($arrDos)) ? round($puntaje, 2) : "No aplica";
              echo "%</strong><br>";

            ?>
          </div>
        </div>

      <?php } ?>
    </div>
    <div class="col-sm-8">
      <!-- Tabla de Resultados -->
      <table class="table table-hover table-borderless" style='border-collapse: collapse;'>
        <thead>
          <?php

            if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) {
              echo "<tr class='table-primary text-center'>";
              echo "<th colspan='21' scope='col-sm-12 center'>RESULTADOS ALINEAMIENTO DOTPLOT</th>";
              echo "</tr>";
            }

          ?>
        </thead>
        <tbody class="bg-white">
            <?php
              $arrUno = array_reverse($arrUno);
              $arrAlineamiento = array_reverse($arrAlineamiento);
              $colspan = count($arrUno);

              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) {
                for ($i=0; $i < count($arrUno); $i++) {
                  echo "<tr>";
                  echo "<th style='padding: 3px;' colspan='" . $colspan ."' class='align-left text-info'><strong>" . strtoupper($arrUno[$i]) . "</srong></th>";

                  if ($arrAlineamiento[$i] == "|") {
                    echo "<th style='padding: 2px;' class='bg-success'></th>";
                  } else {
                    echo "<th style='padding: 2px;' class='bg-light'></th>";
                  }
                  echo "</tr>";
                  $colspan--;
                }
              }

            ?>
          
          <tr>
            <?php
    
              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) {
                echo "<th style='padding: 2px;'></th>";
                for ($i=0; $i < count($arrDos); $i++) {
                  echo "<th style='padding: 4px;' class='text-center text-danger'> " . strtoupper($arrDos[$i]) . "</th>";
                }
              }

            ?>
          </tr>
        </tbody>
      </table>
    </div>
    <br>
  </div>
</div>
<br>
<?php

  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5) {
    include './Vista/footer.php';
  }

?>