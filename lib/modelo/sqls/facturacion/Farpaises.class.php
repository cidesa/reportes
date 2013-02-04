<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farpaises extends baseClases
{
	function sqlp($coddes,$codhas)
	{

$sql= "SELECT
id,
nompai
FROM FAPAIS
WHERE
id >= '".$coddes."' AND
id <= '".$codhas."'
ORDER BY id";
//H::PrintR($sql);
return $this->select($sql);
	}

}
?>
