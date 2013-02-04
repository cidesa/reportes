<?php

require_once("../../lib/modelo/baseClases.class.php");

class Caprocom extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql="SELECT codprocom,desprocom
			FROM caprocom
			WHERE
				codprocom >= RTRIM('".$coddes."') AND
				codprocom <= RTRIM('".$codhas."')
			 order by codprocom";

//H::PrintR($sql);
   return $this->select($sql);
  }
}
?>