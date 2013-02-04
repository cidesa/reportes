<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrestctainm extends baseClases
{
	function sqlp($rifdes,$rifhas,$numerodes,$numerohas)
	{

$sql=   "SELECT ALL
					D.DIRINM,
					D.NROINM,
					D.RIFCON,
					A.fundec,
					D.NOMCON AS NOMCONINM,
					A.EDODEC,
					A.MONDEC AS MONDEC,
					A.MORA,
					A.NUMDEC,
					A.NUMERO,
					A.PRONTOPG,
					(A.MONDEC+A.MORA-A.PRONTOPG) AS NETO,
					TO_CHAR(A.FECDEC,'dd/mm/yyyy') AS FECDEC,
					TO_CHAR(A.FECVEN,'dd/mm/yyyy') AS FECVEN,
					B.CODFUE,
					A.FUEING,
					B.NOMFUE,
					B.NOMABR,
					A.NUMREF as codcatinm,
					A.NOMBRE,
					MAX(C.NOMCON) AS NOMCON,
					MAX(C.DIRCON) AS DIRCON,
					MAX(C.TELCON) AS TELCON,
					MAX(C.EMACON) AS EMACON,
					D.CODCATINM
					FROM
    				FCDECLAR A RIGHT OUTER JOIN FCFUEPRE B ON (A.FUEING=B.CODFUE)
    				RIGHT OUTER JOIN FCCONREP C ON(A.RIFCON=C.RIFCON),FCREGINM D
					WHERE
					A.RIFCON>=('".$rifdes."') AND
					A.RIFCON<=('".$rifhas."')  AND
					A.NUMREF>=('".$numerodes."') AND
					A.NUMREF<=('".$numerohas."')  AND
     				A.NUMREF=D.CODCATINM AND
     				A.EDODEC<>'P'
					GROUP BY
      				D.DIRINM,
					D.NROINM,
					D.RIFCON,
					D.NOMCON,
					A.fundec,
					A.EDODEC,
					A.MONDEC,
					A.MORA,
					A.NUMDEC,
					A.NUMERO,
					A.PRONTOPG,
					(A.MONDEC+A.MORA-A.PRONTOPG),
					A.FECDEC,
					A.FECVEN,
					B.CODFUE,
					A.FUEING,
					B.NOMFUE,
					B.NOMABR,
					A.NUMREF,
					A.NOMBRE,
					D.CODCATINM
					ORDER BY A.NUMREF,A.FECVEN,A.NOMBRE DESC";
					//H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>