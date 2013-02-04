<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farfamarca extends baseClases
{
   function sqlp($coddes,$codhas)
	{

$sql= "SELECT
ID, NOMMAR
FROM FAMARCA
WHERE
ID >= '".$coddes."' AND
ID <= '".$codhas."'
ORDER BY ID";
//H::PrintR($sql);
return $this->select($sql);
	}

}
?>
