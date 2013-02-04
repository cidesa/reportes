<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefcarter extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo,dester as descripcion,tertip as tipo
          from catcarter
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
