<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cartipsal extends baseClases
{
	function sqlp($CONPAGDES,$CONPAGHAS)
	{


$sql= "select distinct(codtipsal) as codigo, destipsal as descripcion
     from catipsal where
         codtipsal>= '".$CONPAGDES."' AND
         codtipsal<= '".$CONPAGHAS."'
      order BY  codtipsal";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

}
?>