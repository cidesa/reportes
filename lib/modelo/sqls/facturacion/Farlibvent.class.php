<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farlibvent extends baseClases
{
	function sqlp($CODDES,$CODHAS,$codfacdes,$codfachas,$codartdes,$codarthas,$FECDES,$FECHAS,$STA,$CONDI)
	{

		//print $CODHAS;exit;
		$estatus='';
	    $condicion='';
		$estatus='';
        if ($STA =='A' OR $STA =='N')
          {
	$estatus=  "AND A.STATUS='".$STA."' ";
           }

		if ($CONDI =='C' OR $CONDI =='R')
		{$condicion=  "AND TIPCONPAG ='".$CONDI."' ";}

		$sql= "SELECT
		A.REFFAC,
		to_char(A.FECFAC, 'dd/mm/yyyy') as fecfac,
		A.CODCLI, D.NOMPRO AS NOMCLI,
		A.DESFAC,
		A.MONFAC ,a.numcom,
		CASE WHEN A.STATUS='A' THEN 'Activa' WHEN A.STATUS='N' THEN 'Anulada' ELSE 'S/D' END AS STATUS
		FROM
		FAFACTUR A, 	FACLIENTE D, FAARTFAC B
		WHERE
		A.REFFAC >= '".$CODDES."'  AND
		A.REFFAC <= '".$CODHAS."' AND
		A.CODCLI >= '".$codfacdes."' AND
		A.CODCLI <= '".$codfachas."' AND
		A.FECFAC >= to_date('".$FECDES."','dd/mm/yyyy') AND
		A.FECFAC <= to_date('".$FECHAS."','dd/mm/yyyy')
		" .$estatus." and
		A.CODCLI=D.CODPRO and
		a.reffac=b.reffac
		ORDER BY   A.REFFAC ,A.CODCLI, A.FECFAC";
	    //H::PrintR($sql);exit;
		return $this->select($sql);


	}

	function sqlp1($codpro)
	{

		$sql="SELECT
		A.MONFAC,
		A.REFFAC,
		A.tipref,
		B.codart,
		C.DESART,
		B.MONRGO,
		B.PRECIO,
		B.CANTOT,
		B.TOTART

		FROM
		FAFACTUR A,
		FAARTFAC B,
		CAREGART C,
		FACLIENTE D,
		FACONPAG F
		WHERE
		A.CODCLI=D.CODPRO AND
		B.REFFAC=A.REFFAC AND
		B.CODART=C.CODART AND
		A.CODCONPAG=F.ID AND
		D.CODPRO= '".$codpro."'

		ORDER BY C.codart";
		//H::PrintR($sql);exit;
		return $this->select($sql);
	}

	function sqlp2($codart,$reffac)
	{

		$sql="SELECT
				B.CANORD,A.CANTOT
			FROM FAARTFAC A,FAARTPED B
			WHERE
		         B.CODART='".$codart."' AND
		         A.REFFAC='".$reffac."' AND
		         A.REFFAC=B.NROPED AND
		         A.CODART=B.CODART


			ORDER BY a.codart";
		//H::PrintR($sql);exit;
		return $this->select($sql);
	}

	function sqlp3($reffac,$codarticulo)
	{

		$sql="SELECT SUM(C.CANDES) as VALOR
		   FROM FAFACTUR A,
		        FANOTENT B,
		        FAARTNOT C
		   WHERE A.REFFAC='".$reffac."' AND
		         B.CODREF='".$reffac."' AND
		         C.CODART='".$codarticulo."' AND
		         B.TIPREF='FD' AND
		         C.NRONOT=B.NRONOT
			GROUP BY c.codart,c.candes
			ORDER BY c.codart";
		//H::PrintR($sql);exit;
		return $this->select($sql);
	}
}
?>
