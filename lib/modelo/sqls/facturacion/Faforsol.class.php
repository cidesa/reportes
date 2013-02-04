<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farfarsol extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT ID as id, nomsol as nombre " .
				"from faforsol where id >='".$coddes."' and id <= '".$codhas."' order by id";
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