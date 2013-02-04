<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcusoinm extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql=  " select distinct codusoinm as codigo, nomusoinm as descripcion, factor as factor
   from FCUSOINM

   WHERE

    codusoinm >= '".$CODDES."' AND
   codusoinm <=  '".$CODHAS."'

   ORDER BY codusoinm ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }
}