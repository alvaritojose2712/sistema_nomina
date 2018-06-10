<?php 
	date_default_timezone_set("America/Caracas");

class sql
	{
		private $campos;
		private $tabla;
		private $where;

		function __construct($tabla,$where="",$campos="*")
		{
			$this->campos=$campos;
			$this->tabla=$tabla;
			$this->where=$where;
		}
		public function conectar(){
			$con = new mysqli('localhost','root','','sistema_nomina');

			if ($con->connect_error) {
			    die('Error de conexión: ' . $con->connect_error);
			}else{
				$con->set_charset("utf8");
				return $con;
			}
		}
		function select(){
			$con = $this->conectar();
			$sql = $con->query("SELECT $this->campos FROM $this->tabla $this->where");	
			if (!$sql) {
        		return "Error: \n".$con->error;
    		}else{
				return $sql;
    		}
		}
		function update(){
			$con = $this->conectar();
			$sql = $con->query("UPDATE $this->tabla SET $this->campos $this->where");	
			if (!$sql) {
        		return "Error: \n".$con->error;
    		}elseif($con->affected_rows==0){
        		return "0 registros afectados";

    		}else{
    			return $sql;
    		}
		}
		function insert(){
			$con = $this->conectar();
			$sql = $con->query("INSERT INTO $this->tabla ($this->campos) VALUES ($this->where)");	
			if (!$sql) {
        		return "Error: \n".$con->error;
    		}else{
    			return $sql;
    		}
		}
		function delete(){
			$con = $this->conectar();
			$sql = $con->query("DELETE FROM $this->tabla WHERE $this->where");	
			if (!$sql) {
        		return "Error: ".$con->error;
    		}elseif ($con->affected_rows==0) {
    			return "Error: Ningún registro afectado!";
    		}else{
    			return $sql;
    		}
		}

		
	}
 ?>
