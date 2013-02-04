<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefproter extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo,descatproter  as descripcion
          from catproter
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
