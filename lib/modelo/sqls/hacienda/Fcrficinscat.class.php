<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrficinscat extends baseClases
{
	function sqlp($CODDES)
	{

$sql=" select
			a.codcatinm,
			a.nroinm,
			a.rifcon,
			a.nomcon,
			b.dircon,
			b.telcon,
			a.numdoc,
			a.folio,
			a.tomo,
			to_char(a.fecdoc,'dd/mm/yyy') as fecdoc,
			a.bster,
			a.mtrter,
			a.bscon,
			a.mtrcon,
			a.codcatfis,
			a.coduso,
			a.dirinm,
			a.linnor,
			a.linsur,
			a.linest,
			a.linoes,
			a.tridoc as tri,
			a.prodoc as prot,
			a.valinm
			from fcreginm a,fcconrep b
			where
			rtrim(a.codcatinm)=rtrim('".$CODDES."') and
			a.rifcon=b.rifcon
			order by a.codcatinm,a.nroinm" ;// H::PrintR($sql); exit;

return $this->select($sql);
	}
    function sqllong()
	   {

           $sql="SELECT
      					A.NOMABR1,A.NOMABR2,A.NOMABR3,A.NOMABR4,A.NOMABR5,A.NOMABR6,
      					A.NOMABR7,A.NOMABR8,A.NOMABR9,A.TAMANO1 as lon1,A.TAMANO2 as lon2,
      					A.TAMANO3 as lon3,A.TAMANO4 as lon4,A.TAMANO5 as lon5,
      					A.TAMANO6 as lon6,A.TAMANO7 as lon7,
      					A.TAMANO8 as lon8,A.TAMANO9 as lon9,A.NUMNIV
						FROM FCDEFNCA A" ;//H::PrintR($sql); exit;

      return $this->select($sql);
	}

}
?>
