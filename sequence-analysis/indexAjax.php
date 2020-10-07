<?php

include 'Modelo/Archivo.php';
include 'Modelo/Conexion.php';

include base64_decode($_GET['pid']);
?>
    <script type="text/javascript">
    $(function () {
    	  $('[data-toggle="tooltip"]').tooltip()
    	})
    </script>
