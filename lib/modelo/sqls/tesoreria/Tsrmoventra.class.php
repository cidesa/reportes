<?php

require_once("../../lib/modelo/baseClases.class.php");

class Tsrmoventra extends baseClases
{


function sqlp($coddes,$codhas, $tipdoc)// Revisar bine este SQL para ver si cumple con los Requerimientos del Reporte
  {
  	 $sql= "select numcue as numcue, mescon as mescon, anocon as anocon, refere as refere, movlib as movlib,
           movban as movban, feclib as feclib, fecban as fecban, desref as desref, monlib as monlib,
           monban as monban, result as result
              from tsconcil
       			where (numcue >= RTRIM('".$coddes."')) and
       			      (numcue <= RTRIM('".$codhas."')) and
       			       refere = ('".$tipdoc."')
						order by numcue";
//H::PrintR($sql);exit;
   return $this->select($sql);
  }
}
?>