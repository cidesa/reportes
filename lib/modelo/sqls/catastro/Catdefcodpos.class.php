<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefcodpos extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo, despos as descripcion
          from catcodpos
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";

   return $this->select($sql);
  }
}
?>
