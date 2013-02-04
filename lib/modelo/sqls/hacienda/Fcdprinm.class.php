<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcdprinm extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select DISTINCT anovig as vigencia

      from fcdprinm

      where

      anovig >= '".$CODDES."' and
      anovig <= '".$CODHAS."' order by anovig"; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

  function sqlp1($vigencia)
  {
  	  $sql=" SELECT a.codestinm as codigo,a.antinm as antiguedad,b.desestinm as estado,a.mondpr as monto

         from fcdprinm a, Fcestinm b

         where
           a.codestinm=b.codestinm and
 		   a.anovig = '".$vigencia."' order by a.codestinm"; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

}