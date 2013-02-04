<?php

require_once("../../lib/modelo/baseClases.class.php");

class Bnrrescuebie extends baseClases
{
	function sqlp($codubides,$codubihas,$codmuedes,$codmuehas,$fecdes,$fechas)
	  {
        $sql="SELECT distinct
	 			a.codubi as acodubi,'M' as tipo,
	 			c.coddis,
				sum(case when c.desinc ='S' then b.mondismue else 0 end) as des,
				sum(case when c.desinc ='N' then b.mondismue else 0 end) as inc,
				trim(d.desubi) as desubi
			FROM
				BNREGMUE A,
				BNDISMUE B,
				BNDISBIE C,
				BNUBIBIE D
			WHERE
				(A.CODubi) >= ('".$codubides."') AND
				(A.CODubi) <= ('".$codubihas."') AND
				(A.CODMUE) >= ('".$codmuedes."') AND
				(A.CODMUE) <= ('".$codmuehas."') AND
				A.FECREG >= to_date(('".$fecdes."'),'dd/mm/yyyy') AND
				A.FECREG <= to_date(('".$fechas."'),'dd/mm/yyyy') AND
				(A.CODACT)=(B.CODACT) and
			    (A.CODMUE)=(B.CODMUE) and
			    (A.CODUBI)=(D.CODUBI) and
			    trim(substr(b.tipdismue,1,6))=trim(c.coddis)
			    group by a.codubi,d.desubi,c.coddis
			 order by a.codubi
	";

	  	return $this->select($sql);
	  }

	 function sqlestado($codubi)
	  {
        $sql="SELECT substr(a.codubi,1,2) as estado,(select desubi from bnubibie where codubi=substr(a.codubi,1,2)) as nomest,
        	substr(a.codubi,1,5) as munic,(select desubi from bnubibie where codubi=substr(a.codubi,1,5)) as nommun,
        	substr(a.codubi,1,8) as parrq,(select desubi from bnubibie where codubi=substr(a.codubi,1,8)) as nompar
			FROM
				BNUBIBIE A
			WHERE
				(A.CODubi) = ('".$codubi."')	";

	  	return $this->select($sql);
	  }

	  	function sqlexistencia($codubi,$fecdes)
	  {
 	 	$sql="SELECT distinct( sum(  a.valini )) as existencia_ant
			FROM
				BNREGMUE A,
				BNDISMUE B,
				BNDISBIE C
			WHERE
				(A.CODubi) = '".$codubi."' AND
				A.FECREG < to_date(('".$fecdes."'),'dd/mm/yyyy') AND
				(A.CODACT)=(B.CODACT) and
			    (A.CODMUE)=(B.CODMUE) and
			    trim(substr(b.tipdismue,1,6))=trim(c.coddis)

	";

	  	return $this->select($sql);
	  }

}
?>