<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cartiprec extends baseClases
{
	function sqlp($CONPAGDES,$CONPAGHAS)
	{


$sql= "select distinct(codtiprec) as codigo, destiprec as descripcion
     from catiprec where
         codtiprec>= '".$CONPAGDES."' AND
         codtiprec<= '".$CONPAGHAS."'
      order BY  codtiprec";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

}
?>