<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fccatfis extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select codcatfis as codigo,
 		    nomcatfis as nombre,linnor as norte,linsur as sur,linest as este,linoes as oeste

              from
                fccatfis

                 where
  				codcatfis >= '".$CODDES."' and
  				codcatfis <= '".$CODHAS."' order by codcatfis";// H::PrintR($sql);exit;

	return $this->select($sql);
  }
}