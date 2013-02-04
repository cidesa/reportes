<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cobrdetana extends baseClases
{
	function sqlp($coddes,$codhas,$codctedes,$codctehas,$fechades,$fechahas,$tipmovdes,$tipmovhas,$tipctedes,$tipctehas,$fac) //
	{

			if($fac=="P"){
		$fac="and A.SALDOC = 0";
		}
		if($fac=="N"){
		$fac="and A.SALDOC > 0";
		}
		if($fac=="T"){
		$fac="";
		}

$sql="SELECT DISTINCT (B.CODPRO) AS CODPRO,D.NOMTIPCTE AS TIPO,D.ID AS  CODTIPO, B.NOMPRO AS NOMCLI
FROM COBDOCUME A, FACLIENTE B, FATIPMOV C, FATIPCTE D
WHERE A.REFDOC >= '".$coddes."' AND
A.REFDOC <= '".$codhas."' AND
A.CODCLI >= '".$codctedes."' AND
A.CODCLI <= '".$codctehas."' AND
A.FATIPMOV_ID >= '".$tipmovdes."' AND
A.FATIPMOV_ID <= '".$tipmovhas."' AND
A.FECEMI >= to_date('".$fechades."','yyyy/mm/dd') AND
A.FECEMI<= to_date('".$fechahas."','yyyy/mm/dd') AND
B.FATIPCTE_ID >= '".$tipctedes."' AND
B.FATIPCTE_ID <= '".$tipctehas."' AND
A.STADOC='A' AND
A.CODCLI=B.CODPRO AND
B.FATIPCTE_ID=D.ID AND
A.FATIPMOV_ID=C.ID ".$fac."
ORDER BY B.CODPRO";


//print '<pre>'; H::PrintR($sql);
return $this->select($sql);
	}

  function sqlp1($codcli,$fac)
	{

		$where="";
		$from="";
		$selec="";
		$gro="";
        if($fac=="P"){
		$fac="and A.SALDOC = 0";
		$where="AND  A.REFDOC=F.REFDOC AND F.NUMTRA=E.NUMTRA";
		$from=", COBDETTRA F, COBTRANSA E";
		$selec=", E.FECTRA, (A.FECVEN-E.FECTRA) AS FEC";
		$gro=", E.FECTRA";
		}
		if($fac=="N"){
		$fac="and A.SALDOC > 0";
		}
		if($fac=="T"){
		$fac="";
		}


$sql= " SELECT A.REFDOC, A.FECEMI,
A.FECVEN,
A.ORIDOC,
A.DESDOC,
A.MONDOC,
A.RECDOC,
A.DSCDOC,
A.ABODOC,
A.SALDOC,
B.NOMPRO AS NOMPRO,
C.DESMOV,
A.NUMCOM,
A.FATIPMOV_ID AS CODMOV,
C.NOMABR,
D.NOMTIPCTE,
A.REFFAC,
(NOW() -(A.FECVEN)) AS  DIAV ".$selec."
FROM COBDOCUME A, FACLIENTE B, FATIPMOV C, FATIPCTE D ".$from."
WHERE
A.CODCLI=B.CODPRO AND
B.FATIPCTE_ID=D.ID AND
A.FATIPMOV_ID=C.ID AND
(A.CODCLI) = '".$codcli."' ".$fac." ".$where."
GROUP BY A.REFDOC,B.CODPRO,
A.FECEMI,
A.FECVEN,
A.ORIDOC,
A.DESDOC,
A.MONDOC,
A.RECDOC,
A.DSCDOC,
A.ABODOC,
A.SALDOC,
B.NOMPRO,
C.DESMOV,
A.NUMCOM,
A.FATIPMOV_ID,
C.NOMABR,
D.NOMTIPCTE,
REFFAC ".$gro."
ORDER BY A.REFDOC,B.CODPRO,
A.FECEMI,
A.FATIPMOV_ID";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

}

