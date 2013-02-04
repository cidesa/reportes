<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefconinm extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo, desconinm as descripcion
          from catconinm
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";

   return $this->select($sql);
  }
}
?>
