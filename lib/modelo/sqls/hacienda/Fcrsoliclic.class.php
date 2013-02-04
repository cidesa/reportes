<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrsoliclic extends BaseClases
{

	function sqlp($soldes)
  {
  	  $sql= "Select distinct
      					(case when a.stasol = 'A' then 'APROBADA' else
      					(case when a.stasol = 'P' then 'PROCESO' else
      					(case when a.stasol = 'N' then 'NEGADA' end) end) end) as estado,
      					(case when a.tipsol = 'N' then 'NUEVA' else
      					(case when a.tipsol = 'H' then 'EXTENSION DE HORARIO' else
      					(case when a.tipsol = 'R' then 'RENOVACION' end) end) end) as tipo,
      					a.numsol, to_char(a.fecsol,'dd/mm/yyyy') as fecsol,
      					a.rifcon, a.rifrep, a.nomneg, a.dircon, a.capsoc,
      					a.fecven, a.tipsol, a.stasol, b.nomcon,
      					c.desact, d.numdoc,d.codact,c.afoact,c.mintri,d.monact,e.valunitri,
						to_char(a.fecini,'dd/mm/yyyy') as ini,to_char(a.fecsol,'dd/mm/yyyy') as emision,
						to_char(a.fecfin,'dd/mm/yyyy') as fin
						from fcsollic a left outer join fcconrep b on (a.rifrep=b.rifcon),
    					fcactcom c, fcactpic d,fcdefins e
						where
     					rtrim(a.numsol)=rtrim('".$soldes."') AND
     					(d.anodec is null or coalesce(d.modo,' ')='M') and
     					rtrim(a.numsol)=rtrim(d.numdoc) and
     					rtrim(d.codact)=rtrim(c.codact) and
     					A.STALIC<>'C' and
     					A.STALIC<>'N' and
     					A.STALIC<>'S' and
     					c.anoact=to_char(a.fecsol,'yyyy')
						order by numsol";

	//H::PrintR($sql);exit;
	return $this->select($sql);
  }

}