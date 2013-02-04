<?php

require_once("../../lib/modelo/baseClases.class.php");

class Bnrlisbiemue extends baseClases
{
	function sqlp($codactdes, $codacthas)
	  {
	 	$sql="SELECT
	  			A.CODUBI  as acodubi,
	  			SUBSTR(A.CODACT,1,10) as acodact,
	  			A.CODMUE as acodmue,
	  			trim(generar_descripcion(a.codmue)) as adesmue,
	  			A.FECCOM as afeccom,
	  			A.FECREG as afecreg,
	  			A.VALINI as avalini,
	  			A.VIDUTI as aviduti,
				A.MODMUE as amodmue,
				A.STAMUE as astamue,
				A.ORDCOM as aordcom,
				A.MARMUE as amarmue,
				A.SERMUE as asermue,
				A.DETMUE as adetmue,
				B.DESUBI as bdesubi

			FROM
				BNREGMUE A,
				BNUBIBIE B
			WHERE
				RTRIM(A.CODUBI)  = RTRIM(B.CODUBI) AND
				RTRIM(A.CODACT) >= RTRIM('".$codactdes."') AND
				RTRIM(A.CODACT) <= RTRIM('".$codacthas."')
			ORDER BY
				A.CODUBI,
				A.CODACT";

	  	return $this->select($sql);
	  }
}
?>