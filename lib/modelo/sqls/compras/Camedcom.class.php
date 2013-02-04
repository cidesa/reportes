<?php

require_once("../../lib/modelo/baseClases.class.php");

class Camedcom extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql="SELECT codmedcom,desmedcom
			FROM camedcom
			WHERE
				codmedcom >= RTRIM('".$coddes."') AND
				codmedcom <= RTRIM('".$codhas."')
			 order by codmedcom";

//H::PrintR($sql);
   return $this->select($sql);
  }
}
?>