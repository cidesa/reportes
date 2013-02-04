<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farecaud extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT
			CODREC as codrec,
			DESREC as desrec,
			(CASE WHEN LIMREC = 'S' THEN 'Si' WHEN LIMREC = 'N' THEN 'No' END ) as limrec
			FROM CARECAUD
			WHERE
			RTRIM(CODREC) >= RTRIM('".$coddes."') AND
			RTRIM(CODREC) <= RTRIM('".$codhas."')
			ORDER BY CODREC	";

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