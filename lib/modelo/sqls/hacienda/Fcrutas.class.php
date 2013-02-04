<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrutas extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql=" select codrut as codigo, desrut as desrutas

       from FCRUTAS
       where
       CODRUT >= '".$CODDES."'AND
       CODRUT <= '".$CODHAS."'
       order by CODRUT ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }
}