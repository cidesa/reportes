<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farffactura extends baseClases
{
	function sqlp($FECDES,$FECHAS,$STA,$CODFDES,$CODFHAS,$CODDES,$CODHAS,$PLAZO,$CODARTDES,$CODARTHAS,$CODREFDES,$CODREFHAS,$COMODIN)
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
B.MONDES,
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
B.CODART >= '".$CODARTDES."' AND
B.CODART <= '".$CODARTHAS."' AND
A.FECFAC >= to_date('".$FECDES."','dd/mm/yyyy') AND
A.FECFAC <= to_date('".$FECHAS."','dd/mm/yyyy') AND
B.reffac >= '".$CODREFDES."' AND
B.reffac <= '".$CODREFHAS."' AND
C.DESART LIKE '".$COMODIN."'
".$estatus."
ORDER BY A.REFFAC";

//H::PrintR($sql);exit;
return $this->select($sql);
	}


function sqlp1($codpro,$ref,$CODARTDES,$CODARTHAS,$CODREFDES,$CODREFHAS,$COMODIN)
	{

	$sql=" select distinct (c.codart), c.desart, b.reffac,b.cantot,b.precio, b.monrgo,b.mondes
      from FAARTFAC B,
           CAREGART C
      where B.REFFAC='".$ref."'  AND
            B.CODART >= '".$CODARTDES."' AND
            B.CODART <= '".$CODARTHAS."' AND
            B.reffac >= '".$CODREFDES."' AND
            B.reffac <= '".$CODREFHAS."' AND
            B.CODART=C.CODART AND
            C.DESART LIKE '".$COMODIN."'";




//		H::PrintR($sql);exit;
		return $this->select($sql);
//		print $sql; exit;
	}




}
?>
