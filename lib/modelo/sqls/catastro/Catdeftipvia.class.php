<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdeftipvia extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo,desvia  as descripcion
          from cattipvia
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
