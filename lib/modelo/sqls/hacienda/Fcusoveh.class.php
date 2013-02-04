<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcusoveh extends BaseClases
{

	function sqlp($CODDES,$CODHAS,$CODVIGDES,$CODVIGHAS)
  {
  	  $sql= "select DISTINCT anovig as vigencia

      from fcusoveh

      where

      anovig >= '".$CODVIGDES."' and
      anovig <= '".$CODVIGHAS."' and
      coduso >= '".$CODDES."' and
      coduso <= '".$CODHAS."' order by anovig"; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

  function sqlp1($vigencia)
  {
  	  $sql="select coduso as codigo, desuso as descripcion, porali as alicuota, anolim as limite, monafo as monto

            from fcusoveh

             where

           anovig = '".$vigencia."' order by codigo "; //H::PrintR($sql);exit;

	return $this->select($sql);
  }

}