<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fartipdev extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT
			codtidev as codigo,
			NOMTIDEV as nombre
			FROM FATIPDEV
			WHERE
			codtidev>= '".$coddes."' AND
			codtidev<= '".$codhas."'
			ORDER BY codtidev";

		//H::PrintR($sql);
		return $this->select($sql);
	}

/*unction sqlalt($codart)
	{

		$sql= "SELECT
		DESART as desart
		FROM CAREGART A
		WHERE
		A.CODART= '".$codart."'";

		//H::PrintR($sql);
		return $this->select($sql);
	}*/


}
?>