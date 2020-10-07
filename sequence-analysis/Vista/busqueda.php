<?php

  include 'nav.php';

?>

<!-- Busqueda -->
<div class="container">
  <br>
  <div class="col-mb-12">
    <div class="card border-primary mb-12">
      <div class="card-header text-white text-center bg-primary"><strong>BUSQUEDA DE ORGANISMO</strong></div>
      <div class="card-body">
          <div class="row">
            <div class="form-group col-sm-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Ingrese Identificador - Organismo">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="" id="resultados"></div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#busqueda").keyup(function(){
		if($("#busqueda").val()!=""){
			var ruta = "indexAjax.php?pid=<?php echo base64_encode("./Controlador/controladorBusqueda.php"); ?>&busqueda="+$("#busqueda").val();
			$("#resultados").load(ruta);
		}
	});
});
</script>
