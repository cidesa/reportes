<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farpedart extends baseClases
{
	function sqlp($CODDES,$CODHAS,$codclides,$codclihas,$codartdes,$codarthas,$fechades,$fechahas,$estatus)
	{

$estatuspedido='';
if ($estatuspedido =='A' OR $estatus =='N')
          {
	$estatuspedido=  "AND status ='".$estatus."' ";
          }

$sql= "SELECT
A.NROPED,
A.FECPED,
A.DESPED,
A.OBSPED,
A.CODCLI,
B.CODART,
B.CANORD,
B.CANAJU,
B.CANDES,
B.CANTOT,
C.DESART,
C.UNIMED,
B.PREART,
B.TOTART,
D.NOMPRO as NOMPRO,
CASE WHEN A.STATUS='A' THEN 'Activo' WHEN
A.STATUS='N' THEN 'Anulado' ELSE 'Ambas' END
FROM FAPEDIDO A,FAARTPED B,
CAREGART C,FACLIENTE D
WHERE
B.NROPED=A.NROPED AND
C.CODART=B.CODART AND
D.CODPRO=A.CODCLI AND
A.NROPED >= '".$CODDES."' AND
A.NROPED <= '".$CODHAS."' AND
A.CODCLI >= '".$codclides."' AND
A.CODCLI <= '".$codclihas."' AND
B.CODART >= '".$codartdes."' AND
B.CODART <= '".$codarthas."' AND
A.FECPED >= to_date('".$fechades."','yyyy/mm/dd') AND
A.FECPED <= to_date('".$fechahas."','yyyy/mm/dd')
" .$estatuspedido."
ORDER BY A.NROPED";
//H::PrintR($sql); EXIT
return $this->select($sql);
	}

	function sqlp1($codpro)
	{

	$sql="SELECT
			A.CODCLI,
			B.CODART,
			B.CANORD,
			B.CANAJU,
			B.CANDES,
			B.CANTOT,
			C.DESART,
			C.UNIMED,
			B.PREART,
			B.TOTART

	    FROM
	       FAPEDIDO A,FAARTPED B,
           CAREGART C,FACLIENTE D
	    WHERE
           B.NROPED=A.NROPED AND
		   C.CODART=B.CODART AND
           D.CODPRO=A.CODCLI AND
           D.CODPRO='".$codpro."'
	ORDER BY B.CODART";
		//H::PrintR($sql); EXIT;
		return $this->select($sql);
		//print $sql; exit;
	}

}
?>
