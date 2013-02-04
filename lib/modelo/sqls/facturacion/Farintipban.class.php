<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farintipban extends baseClases
{
   function sqlp($coddes,$codhas)
	{

$sql= "SELECT
id as codigo, nomban as nombre
FROM FABANCOS
WHERE
id >= '".$coddes."' AND
id <= '".$codhas."'
ORDER BY id";

return $this->select($sql);
	}

}
?>
