<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fccarinm extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select distinct codcarinm as codigo, nomcarinm as descripcion,
       case when stacarinm='T' then 'TERRENO' WHEN stacarinm='C' then 'CONSTRUCCION' WHEN stacarinm='A' then 'AMBOS' END AS TIPO

       FROM FCCARINM

       WHERE

       codcarinm >= '".$CODDES."' AND
       codcarinm <=  '".$CODHAS."'
       ORDER BY codcarinm ";//H::PrintR($sql);exit;

	return $this->select($sql);
  }
}