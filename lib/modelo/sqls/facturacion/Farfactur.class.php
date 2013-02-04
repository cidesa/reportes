<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farfactur extends baseClases
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
		A.MONFAC ,
		CASE WHEN A.STATUS='A' THEN 'Activa' WHEN A.STATUS='N' THEN 'Anulada' ELSE 'Ambas' END AS STATUS
		FROM
		FAFACTUR A, 	FACLIENTE D
		WHERE
		A.REFFAC >= '".$CODDES."'  AND
		A.REFFAC <= '".$CODHAS."' AND
		A.CODCLI >= '".$codfacdes."' AND
		A.CODCLI <= '".$codfachas."' AND
		A.FECFAC >= to_date('".$FECDES."','dd/mm/yyyy') AND
		A.FECFAC <= to_date('".$FECHAS."','dd/mm/yyyy')
		" .$estatus." and
		A.CODCLI=D.CODPRO
		ORDER BY   A.REFFAC ,A.CODCLI, A.FECFAC";
		//H::PrintR($sql);exit;
		return $this->select($sql);

		$sql2= "SELECT
		A.REFFAC,
		A.FecAnu,
		A.FECFAC,
		A.CODCLI,
		A.DESFAC,
		A.MONFAC,
		CASE WHEN A.TIPREF='V' THEN 'Venta Directa' WHEN
		A.TIPREF='P' THEN 'Pedido' ELSE 'Despacho' END as tiporeferencia,
		A.MONDESC,
		--B.CODART,
		B.CANTOT,
		B.PRECIO,
		B.MONRGO,
		B.TOTART,
		C.DESART,
		CASE WHEN A.STATUS='A' THEN 'Activo' WHEN
		A.STATUS='N' THEN 'Anulado' END as estatus,
		D.NOMCLI,
		F.DESCONPAG
		FROM
		FAFACTUR A,
		FAARTFAC B,
		CAREGART C,
		FACLIENTE D,
		FACONPAG F

		WHERE
		A.CODCLI=D.CODCLI AND
		B.REFFAC=A.REFFAC AND
		B.CODART=C.CODART AND
		A.CODCONPAG=F.ID AND
		A.REFFAC >= '".$CODDES."'  AND
		A.REFFAC <= '".$CODHAS."' AND
		A.CODCLI >= '".$codfacdes."' AND
		A.CODCLI <= '".$codfachas."' AND
		B.CODART >= '".$codartdes."' AND
		B.CODART <= '".$codarthas."' AND
		A.FECFAC >= to_date('".$FECDES."','yyyy/mm/dd') AND
		A.FECFAC <= to_date('".$FECHAS."','yyyy/mm/dd')
	--	" .$estatus."
				" .$condicion."
		ORDER BY A.CODCLI, A.FECFAC, A.REFFAC ";
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
