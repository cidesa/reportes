<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fadefcaj extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT
			CODCAJ as codcaj,
			DESCAJ as descaj
			FROM FADEFCAJ
			WHERE
			RTRIM(CODCAJ) >= RTRIM('".$coddes."') AND
			RTRIM(CODCAJ) <= RTRIM('".$codhas."')
			ORDER BY CODCAJ	";

		//H::PrintR($sql);
		return $this->select($sql);
	}


}
?>