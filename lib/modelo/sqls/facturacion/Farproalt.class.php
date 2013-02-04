<?php
require_once("../../lib/modelo/baseClases.class.php");

class Faproalt extends baseClases
{
	function sqlp($coddes,$codhas,$descdes,$deschas)
	{

		$sql= "SELECT
		A.CODART as codart,
		A.CODALT as codalt,
		B.DESART as desart,
		b.cospro
		FROM FAPROALT A,CAREGART B
		WHERE
		A.CODART=B.CODART AND
		A.CODART>= '".$coddes."' AND
		A.CODART<= '".$codhas."' AND
		B.DESART>= '".$descdes."' AND
		B.DESART<= '".$deschas."'
		ORDER BY A.CODART";

		//H::PrintR($sql);
		return $this->select($sql);
	}

	function sqlalt($codart)
	{

		$sql= "SELECT
		DESART as desart
		FROM CAREGART A
		WHERE
		A.CODART= '".$codart."'";

		//H::PrintR($sql);
		return $this->select($sql);
	}


}
?>