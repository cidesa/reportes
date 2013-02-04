<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fctippro extends BaseClases
{

	function sqlp($CODDES,$CODHAS,$CODVIGDES,$CODVIGHAS)
  {
  	  $sql= "select DISTINCT anovig as vigencia

      from fctippro

      where

      anovig >= '".$CODVIGDES."' and
      anovig <= '".$CODVIGHAS."' and
      tippro >= '".$CODDES."' and
      tippro <= '".$CODHAS."' order by anovig"; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

  function sqlp1($vigencia)
  {
  	  $sql="select a.tippro as codigo, a.destip as descripcion, a.unipar as fraccion,
		case when a.frepar='0' then 'PAGO UNICO' when a.frepar='1' then 'ANUALIDAD'
		WHEN a.frepar='2' then 'MENSUALIDAD'  WHEN a.frepar='3' then 'SEMANAL'
		WHEN a.frepar='4' then 'DIARIA' END AS frecuencia,
		b.tipvar as variable, b.valor as valor, b.tipo as tipo

		from fctippro a, fctipproDET b

		 where
 		   a.tippro=b.tippro and
           a.anovig = '".$vigencia."' order by a.tippro "; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

}