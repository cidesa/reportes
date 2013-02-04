<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcringramdet extends baseClases
{
	function sqlp($fecdes,$fechas,$cajdesde,$cajhasta,$codfuedes,$codfuehas)
	{
		$this->sql= "select b.fueing, c.fueing as fuente, a.fecpag,substr(b.nomfue,1,40) as nomfue, b.fueing as codprei,
						sum(case when c.numpag is null then a.monpag else c.monpag end) as monpag,d.nomcon,a.rifcon,a.funpag
						from fcpagos a,fcfuepre b,fcdecpag c,fcconrep d
						where
						a.fecpag>=to_date('".$fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$cajhasta."')
						and coalesce(a.edopag,' ')<>'A'
						and a.numpag=c.numpag
						and c.fueing>='".$codfuedes."'
						and c.fueing<='".$codfuehas."'
						and a.rifcon=d.rifcon
						and coalesce(a.edopag,' ')<>'P'
						and c.fueing=b.codfue
						group by b.codprei,b.fueing,b.nomfue,c.fueing,a.fecpag,d.nomcon,a.rifcon,a.funpag
						order by c.fueing,d.nomcon";
		//	H::PrintR($this->sql);exit;
      return $this->select($this->sql);
	}

}
?>