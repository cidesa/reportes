<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farmercon extends baseClases
{
	function sqlp($CODDES,$CODHAS,$codprodes,$codprohas,$codartdes,$codarthas,$codalmdes,$codalmhas,$fechades,$fechahas,$estat)
	{


      $estatus='';
        if ($estat =='A' OR $estat =='N')
          {
	$estatus=  "AND status ='".$estat."' ";

           }

$sql= "SELECT
A.CONMER,
A.DESCON,
A.FECCON,
A.MONCON,
A.CODALM,
A.CODPRO,
G.NOMPRO,
B.CODART,
C.DESART,
C.UNIMED,
B.CANREC,
B.CANDEV,
C.COSPRO,
B.MONTOT,
CASE WHEN A.STACON='A' THEN 'Activo' WHEN
A.STACON='N' THEN 'Anulado' END,
TRIM(E.NOMALM) as NOMALM
FROM CACONMER A,CAMERCON B,CAREGART C,CADEFALM E,CAPROVEE G
WHERE
B.CONMER=A.CONMER AND
C.CODART=B.CODART AND
E.CODALM=A.CODALM AND
G.CODPRO=A.CODPRO AND
A.CONMER >= '".$CODDES."' AND
A.CONMER <= '".$CODHAS."' AND
A.CODPRO >= '".$codprodes."' AND
A.CODPRO <= '".$codprohas."' AND
B.CODART >= '".$codartdes."' AND
B.CODART <= ".$codarthas."' AND
A.CODALM >= ".$codalmdes."' AND
A.CODALM <= :".$codalmhas."'AND
A.FECCON >= to_date('".$fechades."','yyyy/mm/dd') AND
A.FECCON <= to_date('".$fechahas."','yyyy/mm/dd')
" .$estatus."
ORDER BY A.CONMER";
//H::PrintR($sql);
return $this->select($sql);
	}

	function sqlp1($codpro)
	{

$sql="SELECT
A.MONFAC,
C.codart,
C.DESART,
B.MONRGO,
B.PRECIO,
B.CANREC,
B.TOTART,
B.CANTOT
FROM
FAFACTUR A,
FAARTFAC B,
CAREGART C,
FACLIENTE D,
CACONPAG F
WHERE
A.CODCLI=D.CODPRO AND
D.CODPRO= '".$codpro."'

ORDER BY C.codart";
		//H::PrintR($sql);
		return $this->select($sql);
		//print $sql; exit;
	}
}
?>
