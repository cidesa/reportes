<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcvalinm extends BaseClases
{

	function sqlp($CODDES,$CODHAS,$CODVIGDES,$CODVIGHAS)
  {
  	  $sql= "select DISTINCT anovig as vigencia

      from fcvalinm

      where

      anovig >= '".$CODVIGDES."' and
      anovig <= '".$CODVIGHAS."' and
      codzon >= '".$CODDES."' and
      codzon <= '".$CODHAS."' order by anovig "; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

  function sqlp1($vigencia)
  {
  	  $sql=  "select codzon as codigo,deszon as descripcion, valmtr as valor, valfis as valorfiscal,
       porvalfis as porcentaje,
       codtip as codigotipo, destip as destipo, alitip as alicuotatip1,anual as bsanual1,
       alitipt as alicuotatip2,anualt as bsanual2

       from fcvalinm
       where
       anovig = '".$vigencia."' order by codzon limit 100"; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

}