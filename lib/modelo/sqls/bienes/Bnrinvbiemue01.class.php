<?php

require_once("../../lib/modelo/baseClases.class.php");

class Bnrinvbiemue01 extends baseClases
{
	function sqlp($codactdes, $codacthas,$codmuedes,$codmuehas,$fecdes,$fechas,$codubides,$codubihas)
	  {

	  	$sql="SELECT distinct
			  	A.CODUBI  as acodubi,
				SUBSTR(A.CODACT,1,10) as acodact,
				A.CODMUE as acodmue,
				A.DESMUE  as descri,
				A.MARMUE as marmue,
				A.SERMUE as sermue,
				A.VALINI as avalini,
				A.FECCOM as afeccom,
				A.FECREG as afecreg,
				B.DESUBI as bdesubi
			FROM
				BNREGMUE A,
				BNUBIBIE B
			WHERE
				RTRIM(A.CODUBI)  = RTRIM(B.CODUBI) AND
				RTRIM(A.CODACT) >= RTRIM('".$codactdes."') AND
				RTRIM(A.CODACT) <= RTRIM('".$codacthas."') AND
				RTRIM(A.CODMUE) >= RTRIM('".$codmuedes."') AND
				RTRIM(A.CODMUE) <= RTRIM('".$codmuehas."') AND
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') >= to_date(RTRIM('".$fecdes."'),'dd/mm/yyyy') AND
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') <= to_date(RTRIM('".$fechas."'),'dd/mm/yyyy') AND
	            RTRIM(A.CODUBI) >= RTRIM('".$codubides."') AND RTRIM(A.CODUBI) <= RTRIM('".$codubihas."')
	            and rtrim(a.valini)=rtrim('1.00') or rtrim(a.valini)=rtrim('0.00')		";

  //print '<pre>'; print $sql; exit;


	  	return $this->select($sql);
	  }
}
?>