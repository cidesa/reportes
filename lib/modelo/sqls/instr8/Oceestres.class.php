<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oceestres extends baseClases {

	function SQLp($forma)
	{
		$sql="select nrofor,tipo,cuenta,orden,descripcion  from forcfgrepins where nrofor='$forma' order by orden";

		return $this->select($sql);
	}

	function SQLant($cuenta)
	{
		$rs=$this->select("select to_char(feccie,'yyyy') as anofis from contaba");
		$rs2=$this->select("select esquema as schema  from fordefesq where ano='".$rs->fields["anofis"]."' ");
		$sima=$r2->fields["schema"];
		$sql="select sum(salprgper) as saldoant from ".strtoupper($sima).".contabb1 where codcta='$cuenta'";

		return $this->select($sql);
	}

    function SQLp2($trimestre,$codpre,$tipo) {

		if($trimestre=='I')
		{
			$perdesde='01';
			$perhasta='03';
		}elseif($trimestre=='II')
		{
			$perdesde='04';
			$perhasta='06';
		}elseif($trimestre=='III')
		{
			$perdesde='07';
			$perhasta='09';
		}elseif($trimestre=='IV')
		{
			$perdesde='10';
			$perhasta='12';
		}


		if(strtoupper($tipo)=="P")
		{
			$rs = $this->select("select sum(lonniv+1)+1 as long from cpniveles where catpar='C' ");

			$sql="SELECT '$codpre' as codpre,SUM(MONASI) AS MONASI,SUM(MODIFICACION) as MODIFICACION,SUM(MONASITRI) as MONASITRI,SUM(MONEJETRI) as MONEJETRI,SUM(MONASIACUTRI) as MONASIACUTRI,SUM(MONEJEACUTRI) as MONEJEACUTRI,(select nompre from cpdeftit where cpdeftit.codpre like '%$codpre%' and length(trim(cpdeftit.codpre))=(".($rs[0]["long"])."+length(trim('$codpre'))-1) limit 1) as nompre FROM (

					SELECT substr(codpre,".$rs[0]["long"].") as codpre,SUM(MONASI) AS MONASI,SUM(MODIFICACION) as MODIFICACION,SUM(MONASITRI) as MONASITRI,SUM(MONEJETRI) as MONEJETRI,SUM(MONASIACUTRI) as MONASIACUTRI,SUM(MONEJEACUTRI) as MONEJEACUTRI  FROM (

					SELECT CODPRE, PERPRE AS PERMOV,SUM(MONASI) AS MONASI,0 as MODIFICACION,0 as MONASITRI,0 as MONEJETRI,0 as MONASIACUTRI,0 as MONEJEACUTRI FROM CPASIINI
					WHERE  PERPRE = '00' and codpre like '%'||trim('$codpre')||'%'
					GROUP BY CODPRE,PERPRE

					UNION ALL
					SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV,0 AS MONASI,SUM(MONTO) as MODIFICACION,0 as MONASITRI,0 as MONEJETRI,0 as MONASIACUTRI,0 as MONEJEACUTRI FROM
					(
					SELECT 'TRN' AS TIPO, A.CODORI AS CODPRE,B.FECTRA AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV)*-1 AS MONTO FROM CPMOVTRA A, CPTRASLA B
					WHERE A.REFTRA=B.REFTRA AND
					B.PERTRA>='01' AND
					B.PERTRA<='12' AND
					((B.STATRA='A') OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
					GROUP BY A.CODORI, B.FECTRA, A.STAMOV, B.FECANU
					UNION ALL
					SELECT 'TRA' AS TIPO,A.CODDES AS CODPRE, B.FECTRA AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV) AS MONTO FROM CPMOVTRA A, CPTRASLA B
					WHERE A.REFTRA=B.REFTRA AND
					B.PERTRA>='01' AND
					B.PERTRA<='12' AND
					((B.STATRA='A') OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
					GROUP BY A.CODDES, B.FECTRA, A.STAMOV, B.FECANU
					UNION ALL
					SELECT 'ADI' AS TIPO, A.CODPRE,B.FECADI AS FECMOV, A.STAMOV, B.FECANU ,SUM(A.MONMOV) AS MONTO FROM CPMOVADI A, CPADIDIS B
					WHERE B.ADIDIS='A' AND
					A.REFADI=B.REFADI AND
					A.PERPRE>='01' AND
					A.PERPRE<='12' AND
					((B.STAADI='A') OR (B.STAADI='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
					GROUP BY A.CODPRE, B.FECADI, A.STAMOV, B.FECANU
					UNION ALL
					SELECT 'DIS' AS TIPO, A.CODPRE, B.FECADI AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV)*-1 AS MONTO FROM CPMOVADI A, CPADIDIS B
					WHERE B.ADIDIS='D' AND
					A.REFADI=B.REFADI AND
					A.PERPRE>='01' AND
					A.PERPRE<='12' AND
					((B.STAADI='A') OR (B.STAADI='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
					GROUP BY A.CODPRE, B.FECADI, A.STAMOV, B.FECANU)  MODIFICACION
					where codpre like '%'||trim('$codpre')||'%'
					GROUP BY CODPRE,FECMOV

					UNION ALL
					SELECT CODPRE, PERPRE AS PERMOV,0 AS MONASI,0 as MODIFICACION,SUM(MONASI) as MONASITRI,0 as MONEJETRI,0 as MONASIACUTRI,0 as MONEJEACUTRI FROM CPASIINI
					WHERE  PERPRE>='$perdesde' AND PERPRE<='$perhasta' and codpre like '%'||trim('$codpre')||'%'
					GROUP BY CODPRE,PERPRE

					UNION ALL
					SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV,0 AS MONASI,0 as MODIFICACION,0 as MONASITRI,SUM(MONTO) as MONEJETRI,0 as MONASIACUTRI,0 as MONEJEACUTRI FROM
					(
					SELECT 'COM' AS TIPO,A.CODPRE, B.FECCOM AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCOM A, CPCOMPRO B,CPDOCCOM C
					WHERE C.AFECOM='S' AND
					B.TIPCOM=C.TIPCOM AND
					A.REFCOM=B.REFCOM AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE, B.FECCOM, A.STAIMP, B.FECANU
					UNION ALL
					SELECT 'CAU' as TIPO,A.CODPRE, B.FECCAU AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCAU A, CPCAUSAD B, CPDOCCAU C
					WHERE C.AFECOM='S' AND
					B.TIPCAU=C.TIPCAU AND
					A.REFCAU=B.REFCAU AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE, B.FECCAU, A.STAIMP, B.FECANU
					UNION ALL
					SELECT 'PAG' AS TIPO,A.CODPRE, B.FECPAG AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPPAG A, CPPAGOS B, CPDOCPAG C
					WHERE C.AFECOM='S' AND
					B.TIPPAG=C.TIPPAG AND
					A.REFPAG=B.REFPAG AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE, B.FECPAG, A.STAIMP, B.FECANU
					UNION ALL
					SELECT 'AJCO' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPCOM A, CPCOMPRO B, CPAJUSTE C, CPMOVAJU D, CPDOCAJU E
					WHERE
					A.REFCOM=B.REFCOM AND
					A.REFCOM=C.REFERE AND
					C.REFAJU=D.REFAJU AND
					E.TIPAJU=C.TIPAJU AND
					A.CODPRE=D.CODPRE AND
					E.REFIER='C' AND
					((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$perhasta."'))  AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU
					UNION ALL
					SELECT 'AJCA' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPCAU A, CPCAUSAD B, CPAJUSTE C, CPMOVAJU D, CPDOCCAU E,CPDOCAJU F
					WHERE A.REFCAU=B.REFCAU AND
					A.REFCAU=C.REFERE AND
					A.REFERE=D.REFCOM AND
					C.REFAJU=D.REFAJU AND
					B.TIPCAU=E.TIPCAU AND
					A.CODPRE=D.CODPRE AND
					C.TIPAJU=F.TIPAJU AND
					F.REFIER='A' AND
					E.AFECOM='S' AND
					(C.STAAJU='A' OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$perhasta."')) AND
					(A.STAIMP='A'OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU
					UNION ALL
					SELECT 'AJPA' as TIPO, A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPPAG A, CPPAGOS B, CPAJUSTE C, CPMOVAJU D,CPDOCPAG E, CPDOCAJU F
					WHERE A.REFPAG=B.REFPAG AND
					A.REFPAG=C.REFERE AND
					A.REFCOM=D.REFCOM AND
					A.CODPRE=D.CODPRE AND
					C.REFAJU=D.REFAJU AND
					B.TIPPAG=E.TIPPAG AND
					F.TIPAJU=C.TIPAJU AND
					F.REFIER='G' and
					E.AFECOM='S' AND
					((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$perhasta."')) AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU) COMPROMISO
					WHERE TO_CHAR(FECMOV,'MM')>='".$perdesde."' AND TO_CHAR(FECMOV,'MM')<='".$perhasta."'
					and codpre like '%'||trim('$codpre')||'%'
					GROUP BY CODPRE,FECMOV

					UNION ALL
					SELECT CODPRE, PERPRE AS PERMOV,0 AS MONASI,0 as MODIFICACION,0 as MONASITRI,0 as MONEJETRI,SUM(MONASI) as MONASIACUTRI,0 as MONEJEACUTRI FROM CPASIINI
					WHERE  PERPRE>='01' AND PERPRE<='$perhasta' and codpre like '%'||trim('$codpre')||'%'
					GROUP BY CODPRE,PERPRE

					UNION ALL
					SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV,0 AS MONASI,0 as MODIFICACION,0 as MONASITRI,0 as MONEJETRI,0 as MONASIACUTRI,SUM(MONTO) as MONEJEACUTRI FROM
					(
					SELECT 'COM' AS TIPO,A.CODPRE, B.FECCOM AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCOM A, CPCOMPRO B,CPDOCCOM C
					WHERE C.AFECOM='S' AND
					B.TIPCOM=C.TIPCOM AND
					A.REFCOM=B.REFCOM AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE, B.FECCOM, A.STAIMP, B.FECANU
					UNION ALL
					SELECT 'CAU' as TIPO,A.CODPRE, B.FECCAU AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCAU A, CPCAUSAD B, CPDOCCAU C
					WHERE C.AFECOM='S' AND
					B.TIPCAU=C.TIPCAU AND
					A.REFCAU=B.REFCAU AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE, B.FECCAU, A.STAIMP, B.FECANU
					UNION ALL
					SELECT 'PAG' AS TIPO,A.CODPRE, B.FECPAG AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPPAG A, CPPAGOS B, CPDOCPAG C
					WHERE C.AFECOM='S' AND
					B.TIPPAG=C.TIPPAG AND
					A.REFPAG=B.REFPAG AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE, B.FECPAG, A.STAIMP, B.FECANU
					UNION ALL
					SELECT 'AJCO' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPCOM A, CPCOMPRO B, CPAJUSTE C, CPMOVAJU D, CPDOCAJU E
					WHERE
					A.REFCOM=B.REFCOM AND
					A.REFCOM=C.REFERE AND
					C.REFAJU=D.REFAJU AND
					E.TIPAJU=C.TIPAJU AND
					A.CODPRE=D.CODPRE AND
					E.REFIER='C' AND
					((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$perhasta."'))  AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU
					UNION ALL
					SELECT 'AJCA' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPCAU A, CPCAUSAD B, CPAJUSTE C, CPMOVAJU D, CPDOCCAU E,CPDOCAJU F
					WHERE A.REFCAU=B.REFCAU AND
					A.REFCAU=C.REFERE AND
					A.REFERE=D.REFCOM AND
					C.REFAJU=D.REFAJU AND
					B.TIPCAU=E.TIPCAU AND
					A.CODPRE=D.CODPRE AND
					C.TIPAJU=F.TIPAJU AND
					F.REFIER='A' AND
					E.AFECOM='S' AND
					(C.STAAJU='A' OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$perhasta."')) AND
					(A.STAIMP='A'OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU
					UNION ALL
					SELECT 'AJPA' as TIPO, A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPPAG A, CPPAGOS B, CPAJUSTE C, CPMOVAJU D,CPDOCPAG E, CPDOCAJU F
					WHERE A.REFPAG=B.REFPAG AND
					A.REFPAG=C.REFERE AND
					A.REFCOM=D.REFCOM AND
					A.CODPRE=D.CODPRE AND
					C.REFAJU=D.REFAJU AND
					B.TIPPAG=E.TIPPAG AND
					F.TIPAJU=C.TIPAJU AND
					F.REFIER='G' and
					E.AFECOM='S' AND
					((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$perhasta."')) AND
					((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$perhasta."'))
					GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU) COMPROMISO
					WHERE TO_CHAR(FECMOV,'MM')>='01' AND TO_CHAR(FECMOV,'MM')<='".$perhasta."'
					and codpre like '%'||trim('$codpre')||'%'
					GROUP BY CODPRE,FECMOV )
					EJECUCION
					group by codpre
					order by codpre) A

					";

		}elseif(strtoupper($tipo)=="C")
		{
			$sql="select a.*,b.descta as nompre from (
					select distinct '$codpre' as codpre, SUM(coalesce(salpro,0)) as monasi,sum(coalesce(salprotri,0)) as monasitri,sum(coalesce(salejetri,0)) as monejetri,sum(coalesce(salproacutri,0)) as monasiacutri,sum(coalesce(salejeacutri,0)) as monejeacutri From (

					select codcta,pereje,sum(salprgper) as salpro,0 as salprotri,0 as salejetri,0 as salproacutri,0 as salejeacutri From contabb1 where codcta like trim('$codpre')||'%'
					group by codcta,pereje

					UNION ALL
					select codcta,pereje,0 as salpro,sum(salprgper) as salprotri,0 as salejetri,0 as salproacutri,0 as salejeacutri From contabb1
					where codcta like trim('$codpre')||'%' and pereje>='$perdesde' and  pereje<='$perhasta'
					group by codcta,pereje

					UNION ALL
					select codcta,pereje,0 as salpro,0 as salprotri,sum(salact) as salejetri,0 as salproacutri,0 as salejeacutri From contabb1
					where codcta like trim('$codpre')||'%' and  pereje>='$perdesde' and  pereje<='$perhasta'
					group by codcta,pereje

					UNION ALL
					select codcta,pereje,0 as salpro,0 as salprotir,0 as salejetri,sum(salprgper) as salproacutri,0 as salejeacutri From contabb1
					where codcta like trim('$codpre')||'%' and pereje>='01' and  pereje<='$perhasta'
					group by codcta,pereje

					UNION ALL
					select codcta,pereje,0 as salpro,0 as salprotir,0 as salejetri,0 as salproacutri,sum(salact) as salejeacutri From contabb1
					where codcta like trim('$codpre')||'%' and pereje>='01' and  pereje<='$perhasta'
					group by codcta,pereje )a
					group by codpre ) a, contabb b where a.codpre=b.codcta";
		//		sprint "<pre>".$sql;exit;
		}elseif(strtoupper($tipo)=="I")
		{
			$sql="SELECT a.codpre,SUM(MONASI) AS MONASI,SUM(MODIFICACION) as MODIFICACION,SUM(MONASITRI) as MONASITRI,SUM(COMPROMISO) as MONEJETRI,SUM(MONASIACUTRI) as MONASIACUTRI,SUM(acuCOMPROMISO) as MONEJEACUTRI,b.NOMPRE FROM (
					SELECT '$codpre' as codpre ,SUM(MONASI) AS MONASI,SUM(MODIFICACION) as MODIFICACION,SUM(MONASITRI) as MONASITRI,SUM(COMPROMISO) as MONEJETRI,SUM(MONASIACUTRI) as MONASIACUTRI,SUM(acuCOMPROMISO) as MONEJEACUTRI  FROM (

			SELECT CODPRE,SUM(MONASI) AS MONASI,0 as MONASITRI,0 AS COMPROMISO,0 as MONASIACUTRI, 0 AS acuCOMPROMISO,0 as MODIFICACION   FROM ciasiini
			WHERE  PERPRE = '00'
			GROUP BY CODPRE,PERPRE
			UNION ALL

			SELECT CODPRE,0 AS MONASI,SUM(MONASI) as MONASITRI,0 AS COMPROMISO,0 as MONASIACUTRI, 0 AS acuCOMPROMISO,0 as MODIFICACION   FROM ciasiini
			WHERE  PERPRE>='".$this->perdesde."' AND PERPRE<='".$this->perhasta."'
			GROUP BY CODPRE,PERPRE
			UNION ALL

			SELECT CODPRE,0 AS MONASI,0 as MONASITRI,0 AS COMPROMISO,SUM(MONASI) as MONASIACUTRI, 0 AS acuCOMPROMISO,0 as MODIFICACION   FROM ciasiini
			WHERE  PERPRE>='01' AND PERPRE<='".$this->perhasta."'
			GROUP BY CODPRE,PERPRE
			UNION ALL

			SELECT CODPRE,0 AS MONASI,0 as MONASITRI,SUM(MONTO) AS COMPROMISO,0 as MONASIACUTRI, 0 AS acuCOMPROMISO,0 as MODIFICACION   FROM
			(

			SELECT 'COM'AS TIPO,A.CODPRE,A.FECING AS FECMOV,A.STAIMP,B.FECANU,SUM(A.MONTOT) as Monto
			FROM CIIMPING A, CIREGING B
			where
			a.refing=b.refing and
			a.fecing=b.fecing and
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'$this->perhasta'))
			group by A.CODPRE,A.FECING,A.STAIMP,B.FECANU
			) COMPROMISO
			WHERE TO_CHAR(FECMOV,'MM')>='$this->perdesde' AND TO_CHAR(FECMOV,'MM')<='$this->perhasta'
			GROUP BY CODPRE,FECMOV

			UNION ALL
			SELECT CODPRE,0 AS MONASI,0 as MONASITRI,0 AS COMPROMISO,0 as MONASIACUTRI, SUM(MONTO) AS acuCOMPROMISO,0 as MODIFICACION   FROM
			(SELECT 'COM'AS TIPO,A.CODPRE,A.FECING AS FECMOV,A.STAIMP,B.FECANU,SUM(A.MONTOT) as Monto
			FROM CIIMPING A, CIREGING B
			where
			a.refing=b.refing and
			a.fecing=b.fecing and
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'$this->perhasta'))
			group by A.CODPRE,A.FECING,A.STAIMP,B.FECANU
			) COMPROMISO
			WHERE TO_CHAR(FECMOV,'MM')>='01' AND TO_CHAR(FECMOV,'MM')<='".$this->perhasta."'
			GROUP BY CODPRE,FECMOV
			UNION ALL

			SELECT CODPRE,0 AS MONASI,0 as MONASITRI,0 AS COMPROMISO,0 as MONASIACUTRI, 0 AS acuCOMPROMISO,SUM(MONTO) as MODIFICACION   FROM
			(
			SELECT 'TRN' AS TIPO, A.CODORI AS CODPRE,B.FECTRA AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV)*-1 AS MONTO FROM CIMOVTRA A, CITRASLA B
			WHERE A.REFTRA=B.REFTRA AND
			B.PERTRA>='01' AND
			B.PERTRA<='12' AND
			((B.STATRA='A') OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
			GROUP BY A.CODORI, B.FECTRA, A.STAMOV, B.FECANU
			UNION ALL
			SELECT 'TRA' AS TIPO,A.CODDES AS CODPRE, B.FECTRA AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV) AS MONTO FROM CIMOVTRA A, CITRASLA B
			WHERE A.REFTRA=B.REFTRA AND
			B.PERTRA>='01' AND
			B.PERTRA<='12' AND
			((B.STATRA='A') OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
			GROUP BY A.CODDES, B.FECTRA, A.STAMOV, B.FECANU
			UNION ALL
			SELECT 'ADI' AS TIPO, A.CODPRE,B.FECADI AS FECMOV, A.STAMOV, B.FECANU ,SUM(A.MONMOV) AS MONTO FROM CIMOVADI A, CIADIDIS B
			WHERE B.ADIDIS='A' AND
			A.REFADI=B.REFADI AND
			A.PERPRE>='01' AND
			A.PERPRE<='12' AND
			((B.STAADI='A') OR (B.STAADI='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
			GROUP BY A.CODPRE, B.FECADI, A.STAMOV, B.FECANU
			UNION ALL
			SELECT 'DIS' AS TIPO, A.CODPRE, B.FECADI AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV)*-1 AS MONTO FROM CIMOVADI A, CIADIDIS B
			WHERE B.ADIDIS='D' AND
			A.REFADI=B.REFADI AND
			A.PERPRE>='01' AND
			A.PERPRE<='12' AND
			((B.STAADI='A') OR (B.STAADI='N' AND TO_CHAR(B.FECANU,'MM')>'12'))
			GROUP BY A.CODPRE, B.FECADI, A.STAMOV, B.FECANU)  MODIFICACION GROUP BY CODPRE,FECMOV

			)
			EJECUCION
			group by codpre
			order by codpre) A , CIDEFTIT B WHERE A.CODPRE=B.CODPRE
			group by a.codpre,b.nompre
			";
		}


		return $this->select($sql);
    }
}
?>