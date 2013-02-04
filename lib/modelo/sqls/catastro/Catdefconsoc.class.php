<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefconsoc extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo,desconsoc as descripcion
          from catconsoc
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
