<?
	require_once('../../adodb/adodb.inc.php');
	require_once("conexionAdo.php");
	class basedatosAdo
	{
		var $conn;
		var $bd;

		function basedatosAdo()
		{
			$this->bd=new conexionAdo();
			$hostname="192.168.11.100";
  			$user="postgres";
  			$password="Auto403";
  			$dbname="REPORTES";
			$port="5432";
  			$this->conn=$this->bd->conectar("postgres",$hostname,$user,$password,$port,$dbname);
		}

		function select($sql)
		{
			$this->conn->Execute('SET search_path TO "SIMA055"');
			$rs=$this->conn->Execute($sql);
			return $rs;
		}

		function selectp($sql)
		{
			$this->conn->Execute('SET search_path TO "public"');
			$rs=$this->conn->Execute($sql);
			return $rs;
		}

		function selectu($sql)
		{
			$this->conn->Execute('SET search_path TO "SIMA_USER"');
			$rs=$this->conn->Execute($sql);
			return $rs;
		}

		function actualizar($sql)
		{
			$this->conn->Execute('SET search_path TO "SIMA055"');
			$this->conn->Execute($sql);
		}

		function actualizaru($sql)
		{
			$this->conn->Execute('SET search_path TO "SIMA_USER"');
			$this->conn->Execute($sql);
		}

		function closed()
		{
			$this->conn->Close();
		}

	}
?>
