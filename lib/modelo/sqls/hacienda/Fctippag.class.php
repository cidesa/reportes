<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fctippag extends baseClases
{
	function sqlp($coddes,$codhas)
	{

		$sql= "SELECT ID as id, despag as nombre " .
				"from fctippag where id >='".$coddes."' and id <= '".$codhas."'";
		return $this->select($sql);
	}


}
?>