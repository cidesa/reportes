<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrliqemipic extends baseClases
{
	function sqlp($fecdes,$fechas)
	{

   $sql= "SELECT
					A.NUMPAG,
					A.MONPAG,
					TO_CHAR(A.FECPAG,'dd/mm/yyyy') AS FECPAG,
					C.MONPAG AS MONDEC,
					C.NUMREF,
					C.FUEING,
					C.NUMDEC,
					C.FECVEN,
					C.NUMERO,
					B.NOMCON,
					F.CODFUE,
					F.NOMFUE
					FROM FCPAGOS A, FCCONREP B, FCDECPAG C, FCFUEPRE F
					WHERE
					A.FECPAG>=TO_DATE('".$fecdes."','dd/mm/yyyy') AND
					A.FECPAG<=TO_DATE('".$fechas."','dd/mm/yyyy') AND
					A.RIFCON=B.RIFCON AND
					A.NUMPAG=C.NUMPAG AND
					C.FUEING=F.CODFUE AND
					B.REPCON='C'  AND
					C.FUEING IN ('01','37','47','48','30','45') AND
					A.EDOPAG IS NULL
					ORDER BY A.NUMPAG,C.FECVEN,C.NUMERO"; //H::PrintR($sql); exit;

return $this->select($sql);
	}


		function sqlp1($fecdes,$fechas,$numpag)
	{

   $sql= "SELECT
				SUM(C.MONPAG) AS SUMAMONPAG1
				FROM FCPAGOS A, FCCONREP B, FCDECPAG C, FCFUEPRE F
				WHERE
				A.FECPAG>=TO_DATE('".$fecdes."','dd/mm/yyyy') AND
                A.FECPAG<=TO_DATE('".$fechas."','dd/mm/yyyy') AND
				A.NUMPAG='".$numpag."' AND
                A.RIFCON=B.RIFCON AND
				A.NUMPAG=C.NUMPAG AND
				C.FUEING=F.CODFUE AND
				B.REPCON='C'  AND
                C.FUEING IN ('01','37','47','48','30','45') AND
				A.EDOPAG IS NULL"; //H::PrintR($sql); exit;

return $this->select($sql);
	}

	function sqlp2($fecdes,$fechas,$numpag)
	{

   $sql= "SELECT
				SUM(C.MONPAG) AS SUMAMONPAG1
				FROM FCPAGOS A, FCCONREP B, FCDECPAG C, FCFUEPRE F
				WHERE
				A.FECPAG>=TO_DATE('".$this->fecdes."','dd-mm-yyyy') AND
                A.FECPAG<=TO_DATE('".$this->fechas."','dd-mm-yyyy') AND
				A.NUMPAG='".$numpag."' AND
                A.RIFCON=B.RIFCON AND
				A.NUMPAG=C.NUMPAG AND
				C.FUEING=F.CODFUE AND
				B.REPCON='C'  AND
                C.FUEING IN ('01','37','47','48','30','45') AND
				A.EDOPAG IS NULL"; //H::PrintR($sql); exit;

return $this->select($sql);
	}


}
?>