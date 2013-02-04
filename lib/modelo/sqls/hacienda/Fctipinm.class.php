<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fctipinm extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select distinct CODESTINM as codigo, DESESTINM as descripcion
 			from FCESTINM
 				where

 				CODESTINM >= '".$CODDES."' and
 				CODESTINM <= '".$CODHAS."' ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }
}