<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fccominm extends BaseClases
{

	function sqlp($CODDES,$CODHAS,$CODVIGDES,$CODVIGHAS)
  {
  	  $sql= "select DISTINCT anovig as vigencia

      from fccominm

      where

      anovig >= '".$CODVIGDES."' and
      anovig <= '".$CODVIGHAS."' and
      codcom >= '".$CODDES."' and
      codcom <= '".$CODHAS."' order by anovig"; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

  function sqlp1($vigencia)
  {
  	  $sql= "select DISTINCT codcom as codcom, descom as descripcion,
                case when afeinm='C' then 'CONSTRUCCION' when afeinm='T' then 'TERRENO' END AS afecta,
                case when opecom='S' then 'SUMA' when opecom='R' then 'RESTA' ELSE 'NO AFECTA' END AS exonera,
                valcom as valor

            from fccominm

             where

           anovig = '".$vigencia."' order by codcom ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }

}