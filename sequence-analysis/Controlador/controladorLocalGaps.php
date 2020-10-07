<?php 

  include './Vista/localGaps.php';

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

  $matrizalinamiento = array();
  $gaps = -1;
  $conci = 1;
  $dife = -1;
  $condi1 = 0;
  $condi2 = 0;
  $condi3 = 0;

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
                $matrizalinamiento[count($arrLocalA) + 2][count($arrLocalB) + 2] = 0;
                //

                if (count($arrLocalA) <= 20 && count($arrLocalB) <= 20) {

                  if (count($arrLocalA) >= count($arrLocalB)){
                    for ($i=0; $i < (count($arrLocalA) + 2); $i++) {
                      for ($j=0; $j < (count($arrLocalB) + 2); $j++) {
                        if($i == 0 && $j == 0){
                          $matrizalinamiento[$j][$i] = "i \ j";
                        }
                        if ($i == 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i > 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = $arrLocalA[$i-2];
                        }
                        if($i == 0 && $j > 1){
                          $matrizalinamiento[$j][$i] = $arrLocalB[$j-2];
                       }
                        if($i == 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = 0;                     
                        }
                        if($i == 0 && $j == 1){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i == 1 && $j > 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j-1][$i];
                        }
                        if($i > 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j][$i-1];
                        }
    
                        if($i>1 && $j>1){
    
                          if( $matrizalinamiento[$j][0] == $matrizalinamiento[0][$i]){
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $conci;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $conci;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $conci;
    
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;                
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }else{
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $dife;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $dife;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $dife;
                                      
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }
                        }   
                      }   
                    }

                    $j=count($arrLocalB)+1;
                    $i=count($arrLocalA)+1;
                    $resultadoA = array();
                    $resultadoB = array();
                    $f=0;
                    $m=$i;
                    $n=$j;
                    $condi1=0;
                    $condi2=0;
                    $condi3=0;

                    //
                    if($j<$i || $j == $i){
                      while ($j>1 ){
                          if($i>1){
                          
                              $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                              //echo $matrizalinamiento[$j][$i];
                              $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]="-";
                              $j--;
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoB[$f]="-";
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                          }
                          $f=$f+1;
                          
                          }else{
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]="-";
                              $f=$f+1;
                              $j--;
                          }
                      }
                  }else{
                      while ($i>1){
                          
                          //echo $j;
                          if($j>1){
                          $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                          $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                              
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoB[$f]="-";
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                              
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]="-";
                              
                              $j--;
                              
                          }
                          $f=$f+1;
                          }else{
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $resultadoB[$f]="-";
                              $f=$f+1;
                              $i--;
                          }
                      }
                      
                  }

                  for ($j=0; $j < count($resultadoB); $j++) {
                    if($resultadoA[$j]==$resultadoB[$j]&&$resultadoB[$j]!="-"){
                        $puntaje=$puntaje+1;
                    }else if($resultadoB[$j]=="-"||$resultadoA[$j]=="-"){
                        $puntaje=$puntaje-1;
                    }else if($resultadoB[$j]!=$resultadoA[$j]){
                        $puntaje=$puntaje-1;
                    }

                  }
                  //echo $puntaje;

                  //

                  } else if (count($arrLocalB) >= count($arrLocalA)) {
  
                    for ($i=0; $i < (count($arrLocalB) + 2); $i++) {
                      for ($j=0; $j < (count($arrLocalA) + 2); $j++) {
                        if($i == 0 && $j == 0){
                          $matrizalinamiento[$j][$i] = "i \ j";
                        }
                        if ($i == 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i > 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = $arrLocalB[$i-2];
                        }
                        if($i == 0 && $j > 1){
                          $matrizalinamiento[$j][$i] = $arrLocalA[$j-2];
                       }
                        if($i == 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = 0;                     
                        }
                        if($i == 0 && $j == 1){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i == 1 && $j > 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j-1][$i];
                        }
                        if($i > 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j][$i-1];
                        }
    
                        if($i>1 && $j>1){
    
                          if( $matrizalinamiento[$j][0]==$matrizalinamiento[0][$i]){
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $conci;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $conci;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $conci;
    
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;                
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }else{
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $dife;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $dife;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $dife;
                                      
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }  
                        }   
                      }   
                    }

                    $i=count($arrLocalB)+1;
                    $j=count($arrLocalA)+1;
                    $resultadoA = array();
                    $resultadoB = array();
                    $f=0;
                    $m=$i;
                    $n=$j;
                    $condi1=0;
                    $condi2=0;
                    $condi3=0;

                    //
                    if($j>$i){
                      while ($j>1 ||$j==$i ){
                          if($i>1){
                        
                              $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                              //echo $matrizalinamiento[$j][$i];
                              $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]="-";
                              $j--;
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoA[$f]="-";
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                          }
                          $f=$f+1;
                          }else{
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]="-";
                              $f=$f+1;
                              $j--;
                          }
                      }
                  }else{
                      while ($i>1){
 
                          if($j>1){
                              $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                          $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                              
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoA[$f]="-";
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                              
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]="-";
                              
                              $j--;
                              
                          }
                          
                          $f=$f+1;
                          }else{
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $resultadoA[$f]="-";
                              $f=$f+1;
                              $i--;
                          }
                      }
                      
                  }

                  for ($j=0; $j < count($resultadoB); $j++) {
                    if($resultadoA[$j]==$resultadoB[$j]&&$resultadoB[$j]!="-"){
                        $puntaje=$puntaje+1;
                    }else if($resultadoB[$j]=="-"||$resultadoA[$j]=="-"){
                        $puntaje=$puntaje-1;
                    }else if($resultadoB[$j]!=$resultadoA[$j]){
                        $puntaje=$puntaje-1;
                    }

                  }
                  //echo $puntaje;

                  //

                  }

                } else {
                  $error = 8;
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

                // Alineamiento Local con los valores ingresados FASTA

                $matrizalinamiento[count($arrLocalA) + 2][count($arrLocalB) + 2] = 0;
                //

                if (count($arrLocalA) <= 20 && count($arrLocalB) <= 20) {

                  if (count($arrLocalA) >= count($arrLocalB)){
                    for ($i=0; $i < (count($arrLocalA) + 2); $i++) {
                      for ($j=0; $j < (count($arrLocalB) + 2); $j++) {
                        if($i == 0 && $j == 0){
                          $matrizalinamiento[$j][$i] = "i \ j";
                        }
                        if ($i == 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i > 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = $arrLocalA[$i-2];
                        }
                        if($i == 0 && $j > 1){
                          $matrizalinamiento[$j][$i] = $arrLocalB[$j-2];
                       }
                        if($i == 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = 0;                     
                        }
                        if($i == 0 && $j == 1){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i == 1 && $j > 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j-1][$i];
                        }
                        if($i > 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j][$i-1];
                        }
    
                        if($i>1 && $j>1){
    
                          if( $matrizalinamiento[$j][0] == $matrizalinamiento[0][$i]){
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $conci;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $conci;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $conci;
    
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;                
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }else{
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $dife;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $dife;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $dife;
                                      
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }
                        }   
                      }   
                    }

                    $j=count($arrLocalB)+1;
                    $i=count($arrLocalA)+1;
                    $resultadoA = array();
                    $resultadoB = array();
                    $f=0;
                    $m=$i;
                    $n=$j;
                    $condi1=0;
                    $condi2=0;
                    $condi3=0;

                    //
                    if($i<$j){
                      while ($j>1 ){
                          if($i>1){
                          
                              $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                              //echo $matrizalinamiento[$j][$i];
                              $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]="-";
                              $j--;
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoB[$f]="-";
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                          }
                          $f=$f+1;
                          
                          }else{
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]="-";
                              $f=$f+1;
                              $j--;
                          }
                      }
                  }else{
                      while ($i>1){
                          
                          //echo $j;
                          if($j>1){
                          $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                          $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                              
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoB[$f]="-";
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                              
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoB[$f]=$matrizalinamiento[$j][0];
                              $resultadoA[$f]="-";
                              
                              $j--;
                              
                          }
                          $f=$f+1;
                          }else{
                              $resultadoA[$f]=$matrizalinamiento[0][$i];
                              $resultadoB[$f]="-";
                              $f=$f+1;
                              $i--;
                          }
                      }
                      
                  }

                  for ($j=0; $j < count($resultadoB); $j++) {
                    if($resultadoA[$j]==$resultadoB[$j]&&$resultadoB[$j]!="-"){
                        $puntaje=$puntaje+1;
                    }else if($resultadoB[$j]=="-"||$resultadoA[$j]=="-"){
                        $puntaje=$puntaje-1;
                    }else if($resultadoB[$j]!=$resultadoA[$j]){
                        $puntaje=$puntaje-1;
                    }

                  }
                  //echo $puntaje;

                  //

                  } else if (count($arrLocalB) >= count($arrLocalA)) {
  
                    for ($i=0; $i < (count($arrLocalB) + 2); $i++) {
                      for ($j=0; $j < (count($arrLocalA) + 2); $j++) {
                        if($i == 0 && $j == 0){
                          $matrizalinamiento[$j][$i] = "i \ j";
                        }
                        if ($i == 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i > 1 && $j == 0){
                          $matrizalinamiento[$j][$i] = $arrLocalB[$i-2];
                        }
                        if($i == 0 && $j > 1){
                          $matrizalinamiento[$j][$i] = $arrLocalA[$j-2];
                       }
                        if($i == 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = 0;                     
                        }
                        if($i == 0 && $j == 1){
                          $matrizalinamiento[$j][$i] = "-";
                        }
                        if($i == 1 && $j > 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j-1][$i];
                        }
                        if($i > 1 && $j == 1){
                          $matrizalinamiento[$j][$i] = $gaps + $matrizalinamiento[$j][$i-1];
                        }
    
                        if($i>1 && $j>1){
    
                          if( $matrizalinamiento[$j][0]==$matrizalinamiento[0][$i]){
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $conci;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $conci;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $conci;
    
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;                
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }else{
    
                            $condi1 = $matrizalinamiento[$j][$i-1] + $dife;
                            $condi2 = $matrizalinamiento[$j-1][$i-1] + $dife;
                            $condi3 = $matrizalinamiento[$j-1][$i] + $dife;
                                      
                            if($condi1>=$condi2 && $condi1>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi1;
                            }
                            if($condi2>=$condi1 && $condi2>=$condi3){
                              $matrizalinamiento[$j][$i]=$condi2;
                            }
                            if($condi3>=$condi2 && $condi3>=$condi1){
                              $matrizalinamiento[$j][$i]=$condi3;
                            }
                          }  
                        }   
                      }   
                    }

                    $i=count($arrLocalB)+1;
                    $j=count($arrLocalA)+1;
                    $resultadoA = array();
                    $resultadoB = array();
                    $f=0;
                    $m=$i;
                    $n=$j;
                    $condi1=0;
                    $condi2=0;
                    $condi3=0;

                    //
                    if($j>$i){
                      while ($j>1 ){
                          if($i>1){
                          
                              $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                              //echo $matrizalinamiento[$j][$i];
                              $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]="-";
                              $j--;
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoA[$f]="-";
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                          }
                          $f=$f+1;
                          }else{
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]="-";
                              $f=$f+1;
                              $j--;
                          }
                      }
                  }else{
                      while ($i>1){
                          
                          //echo $j;
                          if($j>1){
                          $matrizalinamiento[$j][$i]=" ".$matrizalinamiento[$j][$i];
                          $condi1=$matrizalinamiento[$j-1][$i];
                          $condi2=$matrizalinamiento[$j-1][$i-1];
                          $condi3=$matrizalinamiento[$j][$i-1];
                          
                          if($condi2>=$condi1&&$condi2>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $j--;
                              $i--;
                              
                          }else if($condi3>=$condi1&&$condi3>=$condi2){
                              $resultadoA[$f]="-";
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $i--;
                              
                              
                          }else if($condi1>=$condi2&&$condi1>=$condi3){
                              $resultadoA[$f]=$matrizalinamiento[$j][0];
                              $resultadoB[$f]="-";
                              
                              $j--;
                              
                          }
                          $f=$f+1;
                          }else{
                              $resultadoB[$f]=$matrizalinamiento[0][$i];
                              $resultadoA[$f]="-";
                              $f=$f+1;
                              $i--;
                          }
                      }
                      
                  }

                  $puntaje=0;

                  for ($j=0; $j < count($resultadoB); $j++) {
                      if($resultadoA[$j]==$resultadoB[$j]&&$resultadoB[$j]!="-"){
                          $puntaje=$puntaje+1;
                      }else if($resultadoB[$j]=="-"||$resultadoA[$j]=="-"){
                          $puntaje=$puntaje-1;
                      }else if($resultadoB[$j]!=$resultadoA[$j]){
                          $puntaje=$puntaje-1;
                      }

                  }
                  //echo $puntaje;

                  //
                  }

                } else {
                  $error = 8;
                }
                //
                
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

      <?php } else if ($error == 8) { ?>

        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>!El rango de los valores seleccionados en una de las secuencias es Mayor a 20, intentelo nuevamente!</strong>
        </div>

      <?php } ?>
    </div>
    
    <div class="col-sm-12 ">

      <table class="table table-borderless  text-center">
        <thead>
        <?php

          if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) {
            echo "<tr class='table-primary text-center'>";
            echo "<th colspan='22' scope='col-sm-12 center'>MATRIZ DE PUNTUACION - ALINEAMIENTO LOCAL CON GAPS</th>";
            echo "</tr>";
          }

        ?>
        </thead>
        <tbody>
            <?php
              
              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) {

                if (count($arrLocalA) >= count($arrLocalB)){
                  for ($k = 0; $k < (count($arrLocalB) + 2); $k++) {
                    echo "<tr>";
                    for ($l = 0; $l < (count($arrLocalA) + 2); $l++) {
                      if ($k == 0) {
                        echo "<th style='padding: 3px;' class='bg-info'>" . $matrizalinamiento[$k][$l] . "</th>";
                      } else if ($l == 0){
                        echo "<th style='padding: 3px;' class='bg-success'>" . $matrizalinamiento[$k][$l] . "</th>";
                      } else if (strstr($matrizalinamiento[$k][$l]," ")){
                        echo "<th style='padding: 3px;' class='bg-warning'>" . $matrizalinamiento[$k][$l] . "</th>";
                      } else {
                        echo "<th style='padding: 3px;'>" . $matrizalinamiento[$k][$l] . "</th>";
                      }
                      
                    }
                    echo "</tr>";
                  }
                } else {
                  for ($k = 0; $k < (count($arrLocalB) + 2); $k++) {
                    echo "<tr>";
                    for ($l = 0; $l < (count($arrLocalA) + 2); $l++) {
                      if ($k == 0) {
                        echo "<th style='padding: 3px;' class='bg-info'>" . $matrizalinamiento[$l][$k] . "</th>";
                      } else if ($l == 0){
                        echo "<th style='padding: 3px;' class='bg-success'>" . $matrizalinamiento[$l][$k] . "</th>";
                      } else if (strstr($matrizalinamiento[$l][$k]," ")){
                        echo "<th style='padding: 3px;' class='bg-warning'>" . $matrizalinamiento[$l][$k] . "</th>";
                      } else {
                        echo "<th style='padding: 3px;'>" . $matrizalinamiento[$l][$k] . "</th>";
                      }
                    }
                    echo "</tr>";
                  }
                }
              }
              
            ?>
        </tbody>
      </table>

      
    </div>
    <br>
    <div class="col-sm-12">
      <table class="table table-borderless table-sm  text-center">
        <thead>
          <?php

            if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) {
              echo "<tr class='table-primary text-center'>";
              echo "<th colspan='35' scope='col-sm-12 center'>RESULTADOS ALINEAMIENTO LOCAL CON GAPS</th>";
              echo "</tr>";
            }

          ?>
        </thead>
        <tbody>
          <tr>
            <?php
              
              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) {
                  $resultadoA = array_reverse($resultadoA);
                  for ($i=0; $i < count($resultadoA); $i++) {
                  echo "<th class='bg-info'>" . strtoupper($resultadoA[$i]) . "</th>";
                }
              }

            ?>
          </tr>
          <tr>
            <?php
              
              if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) {
                  $resultadoB = array_reverse($resultadoB);
                  for ($i=0; $i < count($resultadoB); $i++) {
                  echo "<th class='bg-success'>" . strtoupper($resultadoB[$i]) . "</th>";
                }
              }

            ?>
          </tr>
          
        </tbody>
      </table>
    </div>

    <div class="col-sm-4">
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) { ?>

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
    </div>
    <div class="col-sm-4">
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) { ?>

        <div class="card border-primary mb-3" style="max-width: 20rem;">
          <div class="card-header bg-primary text-white text-center"><strong>DATOS SECUENCIA SELECCIONADA</strong></div>
          <div class="card-body">
            <?php

              echo "<strong><span class='badge badge-success'>SECUENCIA ORIGINAL</span></strong><br>";
              echo "<strong>TAMAÑO: " . count($arrDos) . "</strong><br>";
              echo "<strong>ORGANISMO: " . $nomTaxonomiaB . "</strong><br><br>";
              echo "<strong><span class='badge badge-success'>SECUENCIA LOCAL</span></strong><br>";
              echo "<strong>TAMAÑO: " . count($arrLocalB) . "</strong><br>";
              echo "<strong>ORGANISMO: " . $nomTaxonomiaB . "</strong>";

            ?>
          </div>
        </div>

      <?php } ?>
    </div>
    <div class="col-sm-4">
      <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) { ?>
          <div class="card mb-12">
            <div class="card-header text-white text-center bg-primary">
              <strong>PUNTAJE TOTAL OBTENIDO</strong>
            </div>
            <div class="card-body">
              <?php

                echo "<span class='badge badge-warning'>FACTOR DE PUNTUACION : </span><br>";
                echo "<b>A -> A = 1</b>";
                echo "<br>";
                echo "<b>A -> T = -1</b>";
                echo "<br>";
                echo "<b>A -> - = -1</b>";
                echo "<br><span class='badge badge-warning'>PUNTAJE TOTAL : </span>";
                echo "<b> " . $puntaje . "</b>";

              ?>

            </div>
          </div>
        <?php } ?>
        <?php if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) { ?>
        <div class="card mb-12">
          <div class="card-header text-white text-center bg-primary">
            <strong>INFORMACION DE LAS SECUENCIAS</strong>
          </div>
          <div class="card-body">
            <?php
            
              echo "<span class='badge badge-info'>SECUENCIA INGRESADA (J) :   </span><br>";
              for ($i = 0; $i < count($arrLocalA); $i++){
                echo "<b>" . $arrLocalA[$i] . "</b>";
              }
              echo "<br>";
              echo "<span class='badge badge-success'>SECUENCIA SELECCIONADA (I) :   </span><br>";
              for ($i = 0; $i < count($arrLocalB); $i++){
                echo "<b>" . $arrLocalB[$i] . "</b>";
              }

            ?>

          </div>
        </div>
      <?php } ?>
      <br>
    </div>
    <br>
  </div>
</div>
<br>
<?php

  if ($error != 1 && $error != 2 && $error != 3 && $error != 4 && $error != 5 && $error != 6 && $error != 7 && $error != 8) {
    include './Vista/footer.php';
  }

?>