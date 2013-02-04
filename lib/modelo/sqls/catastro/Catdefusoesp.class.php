<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefusoesp extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo,desuso  as descripcion
          from catusoesp
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
