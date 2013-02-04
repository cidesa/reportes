<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fctiplic extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql=  "select  distinct codtiplic as id, destiplic as nombre
   			from fctiplic
   			WHERE

           CODTIPLIC >='".$coddes."' and
           CODTIPLIC <= '".$codhas."' ORDER BY CODTIPLIC ";
		return $this->select($sql);
	}


}
?>