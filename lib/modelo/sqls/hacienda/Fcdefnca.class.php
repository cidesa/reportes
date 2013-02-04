<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcdefnca extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select a.codpar as codigo, a.numper as numperiodo, a.denumper as desperiodo,a.numniv as niveles, a.nivinm as nivelinmueble,
       a.nomext1 as extnivel1, a.nomabr1 as abreniv1, a.tamano1 as tamniv1,
       a.nomext2 as extnivel2, a.nomabr2 as abreniv2, a.tamano2 as tamniv2,
       a.nomext3 as extnivel3, a.nomabr3 as abreniv3, a.tamano3 as tamniv3,
       a.nomext4 as extnivel4, a.nomabr4 as abreniv4, a.tamano4 as tamniv4,
       a.nomext5 as extnivel5, a.nomabr5 as abreniv5, a.tamano5 as tamniv5,
       a.nomext6 as extnivel6, a.nomabr6 as abreniv6, a.tamano6 as tamniv6,
       a.nomext7 as extnivel7, a.nomabr7 as abreniv7, a.tamano7 as tamniv7,
       a.nomext8 as extnivel8, a.nomabr8 as abreniv8, a.tamano8 as tamniv8,
       a.nomext9 as extnivel9, a.nomabr9 as abreniv9, a.tamano9 as tamniv9,
       (select b.nommun as parroquia from fcmunici b where a.codmun= b.codmun and a.codedo = b.codedo and a.codpai= b.codpai) as parroquia,
       (select C.nomedo as estado from fcestado c where a.codedo = c.codedo and a.codpai= c.codpai) as estado

       FROM fcdefnca A

       where
       a.codpar>= '".$CODDES."' and
       a.codpar<=  '".$CODHAS."' order by a.codpar";//H::PrintR($sql);exit;

	return $this->select($sql);
  }
  function sqlp1()
  {
   	  $sql= "select nomemp as nombrempresa from empresa where codemp='001'";//H::PrintR($sql);exit;

	return $this->select($sql);
  }

}