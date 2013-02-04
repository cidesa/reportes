<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fartipdes extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT
			ID as codigo,
			NOMDES as nombre
			FROM FAFORDES
			WHERE
			ID>= '".$coddes."'  AND
			ID<= '".$codhas."'
			ORDER BY ID";

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