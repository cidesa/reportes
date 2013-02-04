<?php

require_once("../../lib/modelo/baseClases.class.php");

class Tsrtipcue extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "select codtip, destip
						from tstipcue
						where (codtip >= RTRIM('".$coddes."')) and (codtip <= RTRIM('".$codhas."'))
						order by codtip";


//H::PrintR($sql);
   return $this->select($sql);
  }
}
?>