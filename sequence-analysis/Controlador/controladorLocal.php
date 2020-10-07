<?php

  include './Vista/local.php';

  $error = 0;
  $puntaje = 0;
  $arrFastaUno = "secuenciaA.txt";
  $arrFastaDos = "secuenciaB.txt";
  $arrAlineamiento = array();
  $aUno = 0;
  $aDos = 0;
  $bUno = 0;
  $bDos = 0;
  $arrLocalA = array();
  $arrLocalB = array();
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
    $arrDos = str_split($secuenciaDos);
  }

  // Valores escritos
  if (isset($_POST['unoA'])) {
    $aUno = $_POST['unoA'];
  }
  if (isset($_POST['dosA'])) {
    $aDos = $_POST['dosA'];
  }
  if (isset($_POST['unoB'])) {
    $bUno = $_POST['unoB'];
  }
  if (isset($_POST['dosB'])) {
    $bDos = $_POST['dosB'];
  }

  // Alineamiento
  if (isset($_POST['alinear'])) {
    if ($_POST['secuencia'] !== "" && !file_exists($_FILES['secuenciaFasta']['tmp_name']) && $_POST['secuenciaDos'] !== "") {

      // Alineamiento Local
      $alineamiento = "";
      $contador = 0;
      $permitidos = " AaTtGgCc";

      // Datos Secuencia Dos
      //
      $archivo = new Archivo("", $_POST['secuenciaDos']);

      if ($archivo -> autenticar()) {
        $nomTaxonomiaB = $archivo -> getNombre();
      } else {
        $nomTaxonomiaB = "";
      }
      //

      for ($i=0; $i < count($arrUno); $i++) {
        if (strpos($permitidos, substr($secuencia, $i, 1), 0)) {

        } else {
          $error = 4;
        }
      }

      if ($error != 4) {
        if (count($arrUno) <= 60) {
          if (count($arrUno) >= 30) {
            if ($aDos > $aUno && $bDos > $bUno) {
              if (count($arrUno) >= $aUno && count($arrUno) >= $aDos) {
                $contA = 0;
                for ($i=$aUno; $i < $aDos; $i++) {
                  $arrLocalA[$contA] = $arrUno[$i];
                  $contA++;
                }
                $contB = 0;
                for ($i=$bUno; $i < $bDos; $i++) {
                    $arrLocalB[$contB] = $arrDos[$i];
                    $contB++;
                }

                // Alineamiento Local con los valores ingresados
                if (count($arrLocalA) < count($arrLocalB)) {
                  for ($i=0; $i < count($arrLocalA) ; $i++) {
                      if ($arrLocalA[$i] == $arrLocalB[$i]) {
                          $contador++;
                          $arrAlineamiento[$i] = "|";
                      } else {
                          $arrAlineamiento[$i] = "_";
                      }
                  }
                  $arrLocalAA = implode(" ", $arrLocalA);
                  $arrLocalBB = implode(" ", $arrLocalB);
                  $alineamiento = implode(" ", $arrAlineamiento);
                } else if (count($arrLocalA) == count($arrLocalB)) {
                  for ($i=0; $i < count($arrLocalA) ; $i++) {
                      if ($arrLocalA[$i] == $arrLocalB[$i]) {
                          $contador++;
                          $arrAlineamiento[$i] = "|";
                      } else {
                          $arrAlineamiento[$i] = "_";
                      }
                  }
                  $alineamiento = implode(" ", $arrAlineamiento);
                  $puntaje = ($contador * 100) / count($arrLocalA);
                  $arrLocalAA = implode(" ", $arrLocalA);
                  $arrLocalBB = implode(" ", $arrLocalB);
                } else {
                  for ($i=0; $i < count($arrLocalB) ; $i++) {
                      if ($arrLocalA[$i] == $arrLocalB[$i]) {
                          $contador++;
                          $arrAlineamiento[$i] = "|";
                      } else {
                          $arrAlineamiento[$i] = "_";
                      }
                  }
                  $arrLocalAA = implode(" ", $arrLocalA);
                  $arrLocalBB = implode(" ", $arrLocalB);
                  $alineamiento = implode(" ", $arrAlineamiento);
                }
              } else {
                $error = 7;
              }
            } else {
              $error = 6;
            }
          } else {
            $error = 3;
          }
        } else {
          $error = 2;
        }
      }

    } else if (file_exists($_FILES['secuenciaFasta']['tmp_name']) && $_POST['secuencia'] == "" && $_POST['secuenciaDos'] !== "") {

      // Alineamiento Local FASTA

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
      $cadenaUno = substr($tokenA[1], 0, 60);
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
        if (count($arrUno) <= 60) {
          if (count($arrUno) >= 30) {
            if ($aDos > $aUno && $bDos > $bUno) {
              if (count($arrUno) >= $aUno && count($arrUno) >= $aDos) {
                $contA = 0;
                for ($i=$aUno; $i < $aDos; $i++) {
                  $arrLocalA[$contA] = $arrUno[$i];
                  $contA++;
                }
                $contB = 0;
                for ($i=$bUno; $i < $bDos; $i++) {
                    $arrLocalB[$contB] = $arrDos[$i];
                    $contB++;
                }

                // Alineamiento Local con los valores ingresados
                if (count($arrLocalA) < count($arrLocalB)) {
                  for ($i=0; $i < count($arrLocalA) ; $i++) {
                      if ($arrLocalA[$i] == $arrLocalB[$i]) {
                          $contador++;
                          $arrAlineamiento[$i] = "|";
                      } else {
                          $arrAlineamiento[$i] = "_";
                      }
                  }
                  $arrLocalAA = implode(" ", $arrLocalA);
                  $arrLocalBB = implode(" ", $arrLocalB);
                  $alineamiento = implode(" ", $arrAlineamiento);
                } else if (count($arrLocalA) == count($arrLocalB)) {
                  for ($i=0; $i < count($arrLocalA) ; $i++) {
                      if ($arrLocalA[$i] == $arrLocalB[$i]) {
                          $contador++;
                          $arrAlineamiento[$i] = "|";
                      } else {
                          $arrAlineamiento[$i] = "_";
                      }
                  }
                  $alineamiento = implode(" ", $arrAlineamiento);
                  $puntaje = ($contador * 100) / count($arrLocalA);
                  $arrLocalAA = implode(" ", $arrLocalA);
                  $arrLocalBB = implode(" ", $arrLocalB);
                } else {
                  for ($i=0; $i < count($arrLocalB) ; $i++) {
                      if ($arrLocalA[$i] == $arrLocalB[$i]) {
                          $contador++;
                          $arrAlineamiento[$i] = "|";
                      } else {
                          $arrAlineamiento[$i] = "_";
                      }
                  }
                  $arrLocalAA = implode(" ", $arrLocalA);
                  $arrLocalBB = implode(" ", $arrLocalB);
                  $alineamiento = implode(" ", $arrAlineamiento);
                }
              } else {
                $error = 7;
              }
            } else {
              $error = 6;
            }
          } else {
            $error = 3;
          }
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
          <strong>!La cadena es mayor a 60, intentelo nuevamente!</strong>
        </div>

      <?php } else if ($error == 3) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!La cadena es menor a 30, intentelo nuevamente!</strong>
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

      <?php } else if ($error == 6) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!Valores locales mal seleccionados, intentelo nuevamente!</strong>
        </div>

      <?php } else if ($error == 7) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!Uno de los valores locales sobrepasa la secuencia, intentelo nuevamente!</strong>
        </div>

      <?php } ?>
    </div>
    <div class="col-sm-4">
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>DATOS SECUENCIA INGRESADA</strong></div>
          <div class="card-body">
            <?php

              echo "<strong><span class='badge badge-info'>SECUENCIA ORIGINAL</span></strong><br>";
              echo "<strong>TAMAÑO: " . count($arrUno) . "</strong><br>";
              echo "<strong>ORGANISMO: ";
              echo ($_POST['secuencia'] == "") ? $nomTaxonomiaA : "No aplica";
              echo "</strong><br><br>";
              echo "<strong><span class='badge badge-info'>SECUENCIA LOCAL</span></strong><br>";
              echo "<strong>TAMAÑO: " . count($arrLocalA) . "</strong><br>";
              echo "<strong>ORGANISMO: ";
              echo ($_POST['secuencia'] == "") ? $nomTaxonomiaA : "No aplica";
              echo "</strong>";

            ?>
          </div>
        </div>

      <?php } ?>
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>DATOS SECUENCIA SELECCIONADA</strong></div>
          <div class="card-body">
            <?php

              echo "<strong><span class='badge badge-info'>SECUENCIA ORIGINAL</span></strong><br>";
              echo "<strong>TAMAÑO: " . count($arrDos) . "</strong><br>";
              echo "<strong>ORGANISMO: " . $nomTaxonomiaB . "</strong><br><br>";
              echo "<strong><span class='badge badge-info'>SECUENCIA LOCAL</span></strong><br>";
              echo "<strong>TAMAÑO: " . count($arrLocalB) . "</strong><br>";
              echo "<strong>ORGANISMO: " . $nomTaxonomiaB . "</strong>";

            ?>
          </div>
        </div>

      <?php } ?>

      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>DATOS ALINEAMIENTO</strong></div>
          <div class="card-body">
            <?php

              echo "<strong>PUNTAJE: " . $contador . "</strong><br>";
              echo "<strong>PORCENTAJE: ";
              echo (count($arrLocalA) == count($arrLocalB)) ? round($puntaje, 2) : "No aplica";
              echo "%</strong><br>";

            ?>
          </div>
        </div>

      <?php } ?>
    </div>
    <div class="col-sm-8">
      <!-- Tabla seceuncias originales -->
        <table class="table table-hover text-center">
          <thead>
            <?php

              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                echo "<tr class='table-primary text-center'>";
                echo "<th colspan='20' scope='col-sm-12 center'>SECUENCIAS ORIGINALES</th>";
                echo "</tr>";
              }

            ?>
          </thead>
          <tbody>
            <tr>
              <th>
                <?php

                  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                    echo "<span class='badge badge-success'>SECUENCIA 1</span> ";
                    for ($i=0; $i < count($arrUno); $i++) {
                      echo strtoupper($arrUno[$i]);
                    }
                  }

                ?>
              </th>
            </tr>
            <tr>
              <th>
                <?php

                  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                    echo "<span class='badge badge-success'>SECUENCIA 2</span> ";
                    for ($i=0; $i < count($arrDos); $i++) {
                      echo strtoupper($arrDos[$i]);
                    }
                  }

                ?>
              </th>
            </tr>
          </tbody>
        </table>
      <!-- Tabla de Resultados -->
      <table class="table table-hover text-center">
        <thead>
          <?php

            if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
              echo "<tr class='table-primary text-center'>";
              echo "<th colspan='20' scope='col-sm-12 center'>RESULTADOS ALINEAMIENTO LINEAS (1 - 20)</th>";
              echo "</tr>";
            }

          ?>
        </thead>
        <tbody>
          <tr>
            <?php

              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                for ($i=0; $i < count($arrLocalA) && $i < 20; $i++) {
                  echo "<th>" . strtoupper($arrLocalA[$i]) . "</th>";
                }
              }

            ?>
          </tr>
          <tr>
            <?php

              for ($i=0; $i < count($arrAlineamiento) && $i < 20; $i++) {
                if ($arrAlineamiento[$i] == "|") {
                  echo "<th class='bg-success'></th>";
                } else {
                  echo "<th class='bg-white'></th>";
                }
              }

            ?>
          </tr>
          <tr>
            <?php

              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                for ($i=0; $i < count($arrLocalB) && $i < 20; $i++) {
                  echo "<th>" . strtoupper($arrLocalB[$i]) . "</th>";
                }
              }

            ?>
          </tr>
        </tbody>
      </table>

      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {?>
        <?php if (count($arrLocalA) > 20 || count($arrLocalB) > 20) { ?>

          <!-- Tabla de Resultados -->
          <table class="table table-hover text-center">
            <thead>
              <?php

                if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                  echo "<tr class='table-primary text-center'>";
                  echo "<th colspan='20' scope='col-sm-12 center'>RESULTADOS ALINEAMIENTO LINEAS (21 - 40)</th>";
                  echo "</tr>";
                }

              ?>
            </thead>
            <tbody>
              <tr>
                <?php

                  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                    for ($i=20; $i < count($arrLocalA) && $i < 40; $i++) {
                      echo "<th>" . strtoupper($arrLocalA[$i]) . "</th>";
                    }
                  }

                ?>
              </tr>
              <tr>
                <?php

                  for ($i=20; $i < count($arrAlineamiento) && $i < 40; $i++) {
                    if ($arrAlineamiento[$i] == "|") {
                      echo "<th class='bg-success'></th>";
                    } else {
                      echo "<th class='bg-white'></th>";
                    }
                  }

                ?>
              </tr>
              <tr>
                <?php

                  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                    for ($i=20; $i < count($arrLocalB) && $i < 40; $i++) {
                      echo "<th>" . strtoupper($arrLocalB[$i]) . "</th>";
                    }
                  }

                ?>
              </tr>
            </tbody>
          </table>

        <?php } ?>
      <?php } ?>

      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) { ?>
        <?php if (count($arrLocalA) > 40 || count($arrLocalB) > 40) { ?>

          <!-- Tabla de Resultados -->
          <table class="table table-hover text-center">
            <thead>
              <?php

                if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                  echo "<tr class='table-primary text-center'>";
                  echo "<th colspan='20' scope='col-sm-12 center'>RESULTADOS ALINEAMIENTO LINEAS (41 - 60)</th>";
                  echo "</tr>";
                }

              ?>
            </thead>
            <tbody>
              <tr>
                <?php

                  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                    for ($i=40; $i < count($arrLocalA) && $i < 60; $i++) {
                      echo "<th>" . strtoupper($arrLocalA[$i]) . "</th>";
                    }
                  }

                ?>
              </tr>
              <tr>
                <?php

                  for ($i=40; $i < count($arrAlineamiento) && $i < 60; $i++) {
                    if ($arrAlineamiento[$i] == "|") {
                      echo "<th class='bg-success'></th>";
                    } else {
                      echo "<th class='bg-white'></th>";
                    }
                  }

                ?>
              </tr>
              <tr>
                <?php

                  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
                    for ($i=40; $i < count($arrLocalB) && $i < 60; $i++) {
                      echo "<th>" . strtoupper($arrLocalB[$i]) . "</th>";
                    }
                  }

                ?>
              </tr>
            </tbody>
          </table>

        <?php } ?>
      <?php } ?>

    </div>
  </div>
</div>
<br>
<?php

  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7) {
    include './Vista/footer.php';
  }

?>
