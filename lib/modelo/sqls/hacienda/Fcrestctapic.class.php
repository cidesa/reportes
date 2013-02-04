<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrestctapic extends baseClases
{
	function sqlp($RIFDES,$RIFHAS,$NUMDES,$NUMHAS,$FECHA)
	{

$sql= "SELECT ALL
					D.DIRPRI as dirpic,
					D.NUMSOL,
					D.NOMNEG,
					D.NUMLIC as numlic,
					D.RIFCON as rifcon,
					D.NOMCON as nomconpic,
					A.EDODEC,
					A.MONDEC as mondec,
					A.MORA,
					A.fundec,
					A.NUMDEC,
					A.NUMERO,
					A.PRONTOPG,
					(A.MONDEC+A.MORA-A.PRONTOPG) as neto,
					to_char(A.FECDEC,'dd/mm/yyyy') as fecdec,
					to_char(A.FECVEN,'dd/mm/yyyy')as fecven,
					B.CODFUE,
					A.FUEING,
					B.NOMFUE,
					B.NOMABR,
					A.NUMREF,
					A.NOMBRE,
					MAX(C.NOMCON) as nomcon,
					MAX(C.DIRCON) as dircon,
					MAX(C.TELCON) as telcon,
					MAX(C.EMACON) as emacon
					FROM FCDECLAR  A right outer join FCFUEPRE B on (A.FUEING=B.CODFUE)
       				right outer join FCCONREP C on (A.RIFCON = C.RIFCON),
					FCSOLLIC D
					WHERE
					A.RIFCON>=('".$RIFDES."') AND
					A.RIFCON<=('".$RIFHAS."')  AND
					A.NUMREF>=LPAD('".$NUMDES."',10,'0') AND
					A.NUMREF<=LPAD('".$NUMHAS."',10,'0')  AND
					A.EDODEC<>'P' AND
					A.NUMREF=D.NUMLIC AND
					D.NUMLIC>=LPAD('".$NUMDES."',10,'0')AND
					D.NUMLIC<=LPAD('".$NUMHAS."',10,'0')
					GROUP BY
					D.DIRPRI,
					D.NUMSOL,
					D.NOMNEG,
					D.NUMLIC,
					D.RIFCON,
					D.NOMCON,
					A.EDODEC,
					A.MONDEC,
					A.fundec,
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
					A.NOMBRE
					ORDER BY A.NUMREF,A.FECVEN,A.NOMBRE DESC" ;
					// H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
