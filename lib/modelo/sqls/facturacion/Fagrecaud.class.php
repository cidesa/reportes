<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fagrecaud extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT
			CODTIPREC as codtiprec,
			DESTIPREC as destiprec
			FROM CATIPREC
			WHERE
			RTRIM(CODTIPREC) >= RTRIM('".$coddes."') AND
			RTRIM(CODTIPREC) <= RTRIM('".$codhas."')
			ORDER BY CODTIPREC	";

		//H::PrintR($sql);
		return $this->select($sql);
	}


}
?>