<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdeftipviv extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo, destipviv as descripcion
          from cattipviv
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";

   return $this->select($sql);
  }
}
?>
