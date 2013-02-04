<?php
require_once("../../lib/modelo/baseClases.class.php");

class Onapre0801 extends baseClases
{
	function sqlp()
	{

   $sql= "select nomemp as nomemp from empresa";

	return $this->select($sql);
	}
}
?>