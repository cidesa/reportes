<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefdirvia extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo, desdir as descripcion
          from catdirvia
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";

   return $this->select($sql);
  }
}
?>
