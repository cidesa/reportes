<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Oce0443 extends baseClases{

	function sql(){
		$sql="";
		//print"<pre> sql=".$sql;exit;
		return $this->select($sql);
	}
}
?>