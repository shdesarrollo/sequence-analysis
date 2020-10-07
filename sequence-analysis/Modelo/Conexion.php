<?php
class Conexion {
	private $mysqli;
	private $resultado;

	public function abrir(){
		$this -> mysqli = new mysqli("localhost", "id12690523_root", "J(Tqr<8Sg[IQ|qY^", "id12690523_bioinformatica", 3306);
		$this -> mysqli -> set_charset("utf8");
	}

	public function ultimoId(){
		return $this -> mysqli -> insert_id;
	}

	public function ejecutar($sentencia){
		$this -> resultado = $this -> mysqli -> query($sentencia);
	}

	public function cerrar(){
		$this -> mysqli -> close();
	}

	public function numFilas(){
		if($this -> resultado!=null){
			return $this -> resultado -> num_rows;
		}else{
			return 0;
		}
	}

	public function extraer(){
		return $this -> resultado -> fetch_row();
	}

	public function sentenciaEjecutada(){
		if($this -> resultado === TRUE){
			return true;
		}else{
			return false;
		}
	}

}
?>
