<?
	require_once("conexionAdo.php");
	class basedatosAdoOra
	{
		var $conn;
		var $bd;
		
		function basedatosAdoOra()
		{
			$this->bd=new conexionAdo();
			$driver="oci8";
			$server="SOPORTE01";
  			$user="SIMA013";
  			$password="SIMA013";
  			$dbname="SIMA";
			$port="";
  			$this->conn=$this->bd->conectar($driver,$server,$user,$password,$port,$dbname);
		}
		
		function select($sql)
		{
			//$this->conn->Execute('SET search_path TO "SIMA011"');
			$rs=$this->conn->Execute($sql);
			return $rs;
		}
		
		function actualizar($sql)
		{
			//$this->conn->Execute('SET search_path TO "SIMA011"');
			$this->conn->Execute($sql);
		}
		function closed()
		{
			$this->conn->Close();
		}

	}
?>