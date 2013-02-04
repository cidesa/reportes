<?php

require_once("../../lib/modelo/baseClases.class.php");


class Catranslados extends baseClases
{


function sqlp($coddphdes,$coddphhas,$coddesde,$codhasta,$fechadesde,$fechahasta)
  {
   $sql="select a.codtra,to_char(a.fectra,'dd/mm/yyyy') as fectra, a.destra, a.almori, a.almdes, a.codubiori,a.codubides, b.codart, b.canart, c.desart  , d.exiact,
(select exiact from caartalmubi where a.almori=codalm and b.codart=codart and a.codubiori=codubi) as exiact2
from catraalm a, cadettra b, CAREGART c, caartalmubi d
where b.codart=c.codart and
a.codtra=b.codtra and
a.codtra>='".$coddphdes."' and a.codtra<='".$coddphhas."' and
b.codart>='".$coddesde."' and b.codart<='".$codhasta."' and
a.fectra>= to_date('".$fechadesde."','dd/mm/yyyy') and a.fectra<= to_date('".$fechahasta."','dd/mm/yyyy')
and a.almdes=d.codalm and b.codart=d.codart and a.codubides=d.codubi "
;
 					//H::PrintR($sql);exit;

   return $this->select($sql);
  }

  function otros()
  {
   $sql="SELECT NOMEMP as nombre,DIREMP as dir,TLFEMP as telf FROM EMPRESA";
 						//print $sql;exit;

   return $this->select($sql);
  }

    function almacen($alm)
  {
   $sql="select nomalm from cadefalm where codalm='".$alm."'";
 						//print $sql;exit;

   return $this->select($sql);
  }
}
?>