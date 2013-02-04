<?php

require_once("../../lib/modelo/baseClases.class.php");

class Bnrmovbiemue extends baseClases
{
	function sqlp($codactdes, $codacthas,$codmuedes,$codmuehas,$fecdes,$fechas)
	  {
	 	$sql="SELECT distinct
	  			A.CODUBI  as acodubi,
	  			SUBSTR(A.CODACT,1,10) as acodact,
	  			A.CODMUE as acodmue,
	  			trim(generar_descripcion(a.codmue)) as adesmue,
	  			A.FECCOM as afeccom,
	  			A.FECREG as afecreg,
	  			A.VALINI as avalini,
	  			A.VIDUTI as aviduti,
				A.DIRMUE as adirmue,
				A.STAMUE as astamue,
				A.ORDCOM as aordcom,
				A.MARMUE as amarmue,
				A.SERMUE as asermue,
				A.DETMUE as adetmue,
				(case when c.desinc ='S' then b.mondismue else 0 end) as des,
				(case when c.desinc ='N' then b.mondismue else 0 end) as inc
			FROM
				BNREGMUE A,
				BNDISMUE B,
				BNDISBIE C
			WHERE
				(A.CODACT) >= rpad('".$codactdes."',30,' ') AND
				(A.CODACT) <= rpad('".$codacthas."',30,' ') AND
				(A.CODMUE) >= rpad('".$codmuedes."',20,' ') AND
				(A.CODMUE) <= rpad('".$codmuehas."',20,' ') AND
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') >= to_date(RTRIM('".$fecdes."'),'dd/mm/yyyy') AND
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') <= to_date(RTRIM('".$fechas."'),'dd/mm/yyyy') AND
				(A.CODACT)=(B.CODACT) and
			    (A.CODMUE)=(B.CODMUE) and
			    b.mondismue>0 and
			    trim(substr(b.tipdismue,1,6))=trim(c.coddis)
	";

	  	return $this->select($sql);
	  }

	  	function sqlexistencia($codactdes, $codacthas,$codmuedes,$codmuehas,$fecdes)
	  {
	 	$sql="SELECT distinct( sum(  a.valini )) as existencia_ant
			FROM
				BNREGMUE A,
				BNDISMUE B,
				BNDISBIE C
			WHERE
				(A.CODACT) >= rpad('".$codactdes."',30,' ') AND
				(A.CODACT) <= rpad('".$codacthas."',30,' ') AND
				(A.CODMUE) >= rpad('".$codmuedes."',20,' ') AND
				(A.CODMUE) <= rpad('".$codmuehas."',20,' ') AND
				to_date(RTRIM(A.feccom),'yyyy-mm-dd') < to_date(RTRIM('".$fecdes."'),'dd/mm/yyyy') AND
				(A.CODACT)=(B.CODACT) and
			    (A.CODMUE)=(B.CODMUE) and
			    a.valini>0 and
			    trim(substr(b.tipdismue,1,6))=trim(c.coddis)
	";

	  	return $this->select($sql);
	  }

}
?>