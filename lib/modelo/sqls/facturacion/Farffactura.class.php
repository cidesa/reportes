<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farffactura extends baseClases
{
	function sqlp($FECDES,$FECHAS,$STA,$CODFDES,$CODFHAS,$CODDES,$CODHAS,$PLAZO)
	{
      $estatus='';
        if ($STA =='A' OR $STA =='N')
          {
	$estatus=  "AND A.STATUS='".$STA."' ";
           }

$sql= "SELECT
A.REFFAC,
to_char(fecfac,'dd/mm/yyyy') as fecfac,
A.DESFAC,
A.MONFAC,
A.MONDESC,
CASE WHEN A.STATUS='A' THEN 'Activa' WHEN
A.STATUS='N' THEN 'Anulada' ELSE 'Ambas' END AS STATUS,
A.OBSERV,
A.TIPREF,
B.CODART,
B.CODREF,
B.CANTOT,
B.PRECIO,
B.MONRGO,
B.TOTART,
RTRIM(C.DESART) as DESART,
C.UNIMED,
D.CODPRO AS CODPRO,
D.NOMPRO AS NOMPRO,
D.RIFPRO AS RIFPRO,
D.NITPRO AS NITPRO,
D.DIRPRO AS DIRPRO--,
--D.TIPO--,
--D.TIPCLI AS TIPPRO
--E.TIPCONPAG
FROM FAFACTUR A,
FAARTFAC B,
CAREGART C,
FACLIENTE D
--cobclient D
--FACONPAG E
WHERE B.REFFAC=A.REFFAC AND
A.CODCLI=D.CODPRO AND
B.CODART=C.CODART AND
A.REFFAC >= ('".$CODFDES."')  AND
A.REFFAC <= ('".$CODFHAS."')  AND
A.CODCLI >='".$CODDES."' AND
A.CODCLI <= '".$CODHAS."' AND
A.FECFAC >= to_date('".$FECDES."','dd/mm/yyyy') AND
A.FECFAC <= to_date('".$FECHAS."','dd/mm/yyyy')
".$estatus."
ORDER BY A.REFFAC ";

//H::PrintR($sql);
return $this->select($sql);
	}

	function sqlp1($codpro,$ref)
	{

	$sql=" select distinct (c.codart), c.desart, b.cantot,b.precio, b.monrgo
      from FAFACTUR A,
         FAARTFAC B,
         CAREGART C,
        --FACLIENTE D--,
         cobclient D,
         CACONPAG E
      where B.REFFAC=A.REFFAC AND
A.CODCLI=D.CODCLI AND
B.CODART=C.CODART AND d.codcli='".$codpro."' and a.reffac='".$ref."'";


	//	H::PrintR($sql);
		return $this->select($sql);
		//print $sql; exit;
	}




}
?>
