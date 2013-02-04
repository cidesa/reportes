<?php

require_once("../../lib/modelo/baseClases.class.php");

class Catdefdivgeo extends baseClases
{


function sqlp($coddes,$codhas)
  {
  	 $sql= "SELECT DISTINCT coddivgeo as codigo
          from catdivgeo
           where

    		  coddivgeo >= '".$coddes."' and
      		  coddivgeo <= '".$codhas."' and
      		  length(coddivgeo)>=14
      		  order by coddivgeo";//H::PrintR($sql);exit;

   return $this->select($sql);
  }

}
?>
