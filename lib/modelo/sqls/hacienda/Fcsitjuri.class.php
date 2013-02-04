<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcsitjuri extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select distinct codsitinm as codigo, nomsitinm as descripcion,
       CASE WHEN STASITINM='S' THEN 'SI' WHEN STASITINM='N' THEN 'NO' END AS EXENTO
 		from fcsitjurinm
 		where
 		codsitinm >= '".$CODDES."' AND
 		codsitinm <= '".$CODHAS."'
		ORDER BY codsitinm ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }
}