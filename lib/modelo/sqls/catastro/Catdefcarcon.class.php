<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefcarcon extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT id as codigo,nomcarcon as descripcion, tipo
          from catcarcon
           where

    		  id >= $coddes and
      		  id <= $codhas order by id";//H::PrintR($sql); exit;

   return $this->select($sql);
  }
}
?>
