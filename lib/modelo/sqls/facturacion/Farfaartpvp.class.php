<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farfaartpvp extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT
			a.id as codigo,
			a.despvp as despvp,a.codart as codart,a.codpvp as codpvp,a.pvpart as pvp, b.desart as desart
			FROM faartpvp a, caregart b
			WHERE
			a.codart=b.codart and
			RTRIM(a.id) >= RTRIM('".$coddes."') AND
			RTRIM(a.id) <= RTRIM('".$codhas."')
			ORDER BY a.id	";

		//H::PrintR($sql);exit;
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