<?php

require_once("../../lib/modelo/baseClases.class.php");

class Bnrinvbieinm extends baseClases
{
	function sqlp($codactdes, $codacthas,$codinmdes,$codinmhas,$fecdes,$fechas,$codubides,$codubihas)
	  {

	  	$sql="SELECT distinct dirinm as dir, nroexp as nro,
			  	A.CODUBI  as acodubi,
				SUBSTR(A.CODACT,1,10) as acodact,
				A.CODinm as acodinm,
				A.DESinm  as descri,
			--	A.MARinm as marinm,
			--	A.SERinm as serinm,
				A.VALINI as avalini,
				A.FECCOM as afeccom,
				substring(substring(A.FECREG,6,7),1,2) as mes,
				substring(A.FECREG,-5,10) as ano,
				A.FECREG as afecreg,
				B.DESUBI as bdesubi
			FROM
				BNREGinm A,
				BNUBIBIE B
			WHERE
				RTRIM(A.CODUBI)  = RTRIM(B.CODUBI) AND
				RTRIM(A.CODACT) >= RTRIM('".$codactdes."') AND
				RTRIM(A.CODACT) <= RTRIM('".$codacthas."') AND
				RTRIM(A.CODinm) >= RTRIM('".$codinmdes."') AND
				RTRIM(A.CODinm) <= RTRIM('".$codinmhas."') AND --a.fecreg is null and
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') >= to_date(RTRIM('".$fecdes."'),'dd/mm/yyyy') AND
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') <= to_date(RTRIM('".$fechas."'),'dd/mm/yyyy') AND
	            RTRIM(A.CODUBI) >= RTRIM('".$codubides."') AND RTRIM(A.CODUBI) <= RTRIM('".$codubihas."')";

	         //   print '<pre>'; print $sql; exit;

		$sqlviejo="SELECT distinct
	  			A.CODUBI  as acodubi,
	  			SUBSTR(A.CODACT,1,10) as acodact,
	  			A.CODinm as acodinm,
	  			A.DESinm as adesinm,
	  			A.FECCOM as afeccom,
	  			A.FECREG as afecreg,
	  			A.VALINI as avalini,
	  			A.VIDUTI as aviduti,
				A.DIRinm as adirinm,
				A.STAinm as astainm,
				A.ORDCOM as aordcom,
				A.MARinm as amarinm,
				A.SERinm as aserinm,
				A.DETinm as adetinm,
				B.DESUBI as bdesubi

			FROM
				BNREGinm A,
				BNUBIBIE B
			WHERE
				RTRIM(A.CODUBI)  = RTRIM(B.CODUBI) AND
				RTRIM(A.CODACT) >= RTRIM('".$codactdes."') AND
				RTRIM(A.CODACT) <= RTRIM('".$codacthas."') AND
				RTRIM(A.CODinm) >= RTRIM('".$codinmdes."') AND
				RTRIM(A.CODinm) <= RTRIM('".$codinmhas."') AND
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') >= to_date(RTRIM('".$fecdes."'),'dd/mm/yyyy') AND
				to_date(RTRIM(A.FECREG),'yyyy-mm-dd') <= to_date(RTRIM('".$fechas."'),'dd/mm/yyyy') AND
	            RTRIM(A.CODUBI) >= RTRIM('".$codubides."') AND RTRIM(A.CODUBI) <= RTRIM('".$codubihas."')";



	  	return $this->select($sql);
	  }
}
?>