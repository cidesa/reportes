<?php

require_once("../../lib/modelo/baseClases.class.php");

class Fadefalm extends baseClases
{


function sqlp($codalm1,$codalm2)
  {
  	 $sql="SELECT codalm as codigo, nomalm as nombre

			FROM cadefalm
			WHERE
				codalm >= '".$codalm1."' AND
				codalm <= RTRIM('".$codalm2."')
			 order by codalm";

//H::PrintR($sql);
   return $this->select($sql);
  }
}
?>
