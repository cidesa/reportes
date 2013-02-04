<?php

require_once("../../lib/modelo/baseClases.class.php");

class Fatipalm extends baseClases
{


function sqlp($codalm1,$codalm2)
  {
  	 $sql="SELECT id as codigo, nomtip as nombre

			FROM catipalm
			WHERE
				id >= '".$codalm1."' AND
				id <= RTRIM('".$codalm2."')
			 order by id";

//H::PrintR($sql);
   return $this->select($sql);
  }
}
?>