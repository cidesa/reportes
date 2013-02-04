<?php
require_once("../../lib/modelo/baseClases.class.php");

class Artser extends baseClases
{
	function sqlp($FECDES,$FECHAS,$STA,$CONPAGDES,$CONPAGHAS)
	{
$estatus='';
if ($STA =='A' OR $STA =='N')
{
	$estatus=  "A.STATUS ='".$STA."' and ";

}

$sql= "SELECT B.CODART,
               C.DESART,
               SUM(B.CANTOT) as CANTIDAD,
               SUM(B.CANTOT*B.PRECIO) as TOTAL

FROM           FAFACTUR A,
               FAARTFAC B,
               CAREGART C,
               FACONPAG D
WHERE  A.REFFAC=B.REFFAC AND
                B.CODART=C.CODART AND
                A.CODCONPAG=D.ID AND
                A.FECFAC>= to_date('".$FECDES."','yyyy/mm/dd') AND
                A.FECFAC<= to_date('".$FECHAS."','yyyy/mm/dd') AND " .$estatus.
                " D.ID>= '".$CONPAGDES."' AND
                D.ID<= '".$CONPAGHAS."'
GROUP BY  B.CODART,C.DESART";
//H::PrintR($sql);//aver
return $this->select($sql);
	}

}
?>