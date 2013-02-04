<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefsenvia extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo,dessen  as descripcion
          from catsenvia
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
