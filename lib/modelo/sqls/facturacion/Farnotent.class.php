<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farnotent extends baseClases
{
	function sqlp($CODDES,$CODHAS,$codclides,$codclihas,$codartdes,$codarthas,$fechades,$fechahas,$estatus,$tipnota)
	{

$tiponota='';
$estatusnota='';
if ($estatus =='A' OR $estatus =='N')
          {
	$estatusnota=  "AND status ='".$estatus."' ";
          }
if ($tipnota =='D' OR $tipnota =='O')
          {
	$tiponota=  "AND TIPNOT ='".$tipnota."' ";

          }

$sql= "SELECT
A.NRONOT,
A.FECNOT,
A.CODCLI,
A.DESNOT,
A.MONNOT,
A.CODREF,
B.CODART,
B.NUMLOT,
B.CANSOL,
B.CANENT,
B.CANDES,
B.CANAJU,
B.CANDEV,
B.CANTOT,
B.PREART,
B.TOTART,
C.DESART,
D.FECVEN,
E.nompro,
CASE WHEN A.TIPREF='P' THEN 'Pedido' WHEN
A.TIPREF='F' THEN 'Factura' END,
CASE WHEN A.STATUS='A' THEN 'Activo' WHEN
A.STATUS='N' THEN 'Anulado' ELSE 'Ambas' END,
CASE WHEN A.TIPNOT='D' THEN 'Donaciones' WHEN
A.TIPNOT='O' THEN 'Otros' END
FROM
FANOTENT A,
FAARTNOT B,
CAREGART C,
FADEFLOT D,
FACLIENTE E
WHERE
A.CODCLI=E.CODPRO AND
B.NRONOT=A.NRONOT AND
D.NUMLOT=B.NUMLOT AND
C.CODART=B.CODART AND
D.CODART=B.CODART AND
A.NRONOT >= '".$CODDES."' AND
A.NRONOT <= '".$CODHAS."' AND
A.CODCLI >= '".$codclides."' AND
A.CODCLI <= '".$codclihas."' AND
A.FECNOT >= to_date('".$fechades."','yyyy/mm/dd') AND
A.FECNOT <= to_date('".$fechahas."','yyyy/mm/dd') AND
B.CODART >= '".$codartdes."' AND
B.CODART <= '".$codarthas."'
--A.TIPNOT = DECODE(:TIPDONOTR,'Ambos',A.TIPNOT,'Donaciones','D','Otros','O')
" .$estatusnota."" .$tiponota." ORDER BY A.CODCLI, A.FECNOT, A.NRONOT";
//H::PrintR($sql);
return $this->select($sql);
	}

	function sqlp2($codpro)
	{

	$sql="SELECT
			A.NRONOT,
			A.FECNOT,
			A.CODCLI,
			A.DESNOT,
			A.MONNOT,
			A.CODREF,
			A.TIPREF,
			A.status,
			B.CODART
	    FROM FANOTENT A,
FAARTNOT B,
CAREGART C,
FADEFLOT D
	    WHERE
            B.NRONOT=A.NRONOT AND
	        D.NUMLOT=B.NUMLOT AND
		    C.CODART=B.CODART AND
            D.CODART=B.CODART AND
            A.CODCLI='".$codpro."'

	ORDER BY A.NRONOT";
		//H::PrintR($sql);
		return $this->select($sql);
		//print $sql; exit;
	}

	function sqlp3($nronot)
	{

$sql="SELECT

B.CODART,
B.NUMLOT,
B.CANSOL,
B.CANENT,
B.CANDES,
B.CANAJU,
B.CANDEV,
B.CANTOT,
B.PREART,
B.TOTART,
C.DESART,
D.FECVEN
	FROM FANOTENT A,
FAARTNOT B,
CAREGART C,
FADEFLOT D
	WHERE
            B.NRONOT=A.NRONOT AND
	        D.NUMLOT=B.NUMLOT AND
		    C.CODART=B.CODART AND
            D.CODART=B.CODART AND
            B.NRONOT='".$nronot."'
	ORDER BY b.codart";
		//H::PrintR($sql);
		return $this->select($sql);
		//print $sql; exit;
	}

}
?>
