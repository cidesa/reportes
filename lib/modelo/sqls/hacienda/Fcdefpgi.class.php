<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcdefpgi extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select id as codigo, despgi as descripcion,desabr as abreviada,mondes as desde, monhas as hasta,
          numpor as porciones, monpag as monto

          from fcdefpgi
        where
  	   id >= $CODDES AND
       id <= $CODHAS  ORDER BY id ";//H::PrintR($sql);exit;

	return $this->select($sql);
  }
}
