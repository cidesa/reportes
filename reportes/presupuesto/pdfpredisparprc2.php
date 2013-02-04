<?
	require_once("../../lib/general/fpdf/fpdf.php");
    require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/negociorpresupuesto.php");



	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $anchos2;
		var $campos;
		var $sql1;
		var $sql2;
		var $rep;
		var $numero;
		var $cab;
		var $perdesde;
		var $perhasta;
		var $nivdesde;
		var $nivhasta;
		var $agrupar;
		var $asignacion;
		var $codpredes;
		var $codprehas;
		var $comodin;
		var $totalprc;
		var $totalcom;
		var $totalcau;
		var $totalpag;
		var $totalmod;
   	    var $totalaco;
		var $totaldeu;
		var $totaldis;
		var $perasi;
		var $consec;
        var $grupo;
		var $cuantos;
		var $longrupo;
		var $lonpartida;
		var $cadena;
		var $totalprccat;
		var $totalcomcat;
		var $totalcaucat;
		var $totalpagcat;
		var $totalmodcat;
   	    var $totalacocat;
		var $totaldeucat;
		var $totaldiscat;
		var $categoria;
		var $nivel;
		var $posY;
		var $inipartida;
		var $nomcat;
		function pdfreporte()
		{
			$this->fpdf("l","mm","letter");
			$this->bd=new basedatosAdo();
//			$this->bd->validar();
			$this->clasepresup=new negociorpresupuesto;
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->perdesde=$_POST["perdesde"];
			$this->perhasta=$_POST["perhasta"];
			$this->consepar=$_POST["consepar"];
			$this->nivhasta=$_POST["nivhasta"];
			$this->asignacion=$_POST["asignacion"];
			$this->agrupar=$_POST["agrupar"];
			$this->codpredes=$_POST["codpredes"];
			$this->codprehas=$_POST["codprehas"];
			$this->comodin=$_POST["comodin"];
			$this->titulo=$_POST["titulo"];
			$this->fecdes=$_POST["fecdes"];
			$this->fechas=$_POST["fechas"];

			$t=$this->bd->select("select to_char(fecper,'yyyy') as perfis from cpdefniv");
			$this->perfis=$t->fields["perfis"];
			if($this->asignacion=="Acumulados")
			{
			$this->perasi=$this->perhasta;
			}
			else
			{
			$this->perasi="12";
			}

			$this->cuantos=strpos($this->agrupar, "-")-1;
			$this->consec=substr($this->agrupar,0,$this->cuantos);
			$this->nivel=substr($this->agrupar,$this->cuantos+1);
			$this->sql="SELECT (SUM(LONNIV)+COUNT(CATPAR)-1) as LONGRUPO FROM CPNIVELES WHERE CATPAR='C' AND CONSEC<=".$this->consec.";";
		    $tb=$this->bd->select($this->sql);
		    if (!empty($tb->fields["longrupo"]))
				$longrupo=$tb->fields["longrupo"];
			else
				$longrupo=0;

			$this->sql="SELECT (SUM(LONNIV)+COUNT(CATPAR)-1) as LONPARTIDA FROM CPNIVELES WHERE CATPAR='P' AND CONSEC<=".$this->nivhasta.";";
		    $tb=$this->bd->select($this->sql);
			if (!empty($tb->fields["lonpartida"]))
				$lonpartida=$tb->fields["lonpartida"];
			else
				$lonpartida=0;

			$this->sql="SELECT (SUM(LONNIV)+COUNT(CATPAR)-1) as TPARTIDA FROM CPNIVELES WHERE CATPAR='P' AND CONSEC<=".$this->consepar.";";
		    $tb=$this->bd->select($this->sql);
			if (!empty($tb->fields["tpartida"]))
				$tpartida=$tb->fields["tpartida"];
			else
				$tpartida=0;

			$this->sql="SELECT (SUM(LONNIV)+COUNT(CATPAR)+1) as inipartida FROM CPNIVELES WHERE CATPAR='C';";
		    $tb=$this->bd->select($this->sql);
			$inipartida=$tb->fields["inipartida"];

			$this->lonpartida=$lonpartida;
			if ($longrupo!=0 && $lonpartida!=0)
			{
				$parchesql="SUBSTR(EJECUCION.CODPRE,1,".$longrupo.") AS CATEGORIA,SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$tpartida.") AS partida,
			SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$lonpartida.") AS CODPRE,";
				$parchesqlg="SUBSTR(EJECUCION.CODPRE,1,".$longrupo."),SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$tpartida."),
			SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$lonpartida.")";
			}
			elseif ($longrupo==0)
			{
				$parchesql="SUBSTR(EJECUCION.CODPRE,1,".$longrupo.") AS CATEGORIA,SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$tpartida.") AS partida,
			SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$lonpartida.") AS CODPRE,";
				$parchesqlg="SUBSTR(EJECUCION.CODPRE,1,".$longrupo."),SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$tpartida."),
			SUBSTR(EJECUCION.CODPRE,".$inipartida.",".$lonpartida.")";
			}
			else
			{
				$parchesql=" '' AS CATEGORIA,'' as partida,
			SUBSTR(EJECUCION.CODPRE,1,".$longrupo.") AS CODPRE,";
				$parchesqlg="SUBSTR(EJECUCION.CODPRE,1,".$longrupo.")";
			}


$this->sql="SELECT ".$parchesql." MIN(CPDEFTIT.NOMPRE) AS NOMPRE, SUM(MONASI) AS ASIGNACION,SUM(PRECOMPROMISO) AS PRECOMPROMISO,SUM(COMPROMISO) AS COMPROMISO, SUM(CAUSADO) AS CAUSADO, SUM(PAGADO) AS PAGADO, SUM(MODIFICACION) AS MODIFICADO  FROM
			(

			SELECT CODPRE, PERPRE AS PERMOV,SUM(MONASI) AS MONASI ,0 AS PRECOMPROMISO,0 AS COMPROMISO, 0 AS CAUSADO, 0 AS PAGADO, 0 AS MODIFICACION   FROM CPASIINI
			WHERE  PERPRE = '00'
			GROUP BY CODPRE,PERPRE
			UNION ALL

			SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV,0 AS MONASI, SUM(MONTO) AS PRECOMPROMISO,0 AS COMPROMISO ,0 AS CAUSADO, 0 AS PAGADO, 0 AS MODIFICACION  FROM
			(
			SELECT 'PRC' AS TIPO,A.CODPRE, B.FECPRC AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPPRC A, CPPRECOM B
			WHERE
			A.REFPRC=B.REFPRC AND
			B.FECPRC>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECPRC<=to_date('$this->fechas','dd/mm/yyyy') and
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECPRC, A.STAIMP, B.FECANU
			UNION ALL
			SELECT 'COM' AS TIPO,A.CODPRE, B.FECCOM AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCOM A, CPCOMPRO B,CPDOCCOM C
			WHERE C.AFEPRC='S' AND
			B.FECCOM>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECCOM<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPCOM=C.TIPCOM AND
			A.REFCOM=B.REFCOM AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECCOM, A.STAIMP, B.FECANU
			UNION ALL
			SELECT 'CAU' as TIPO,A.CODPRE, B.FECCAU AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCAU A, CPCAUSAD B, CPDOCCAU C
			WHERE C.AFEPRC='S' AND
			B.FECCAU>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECCAU<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPCAU=C.TIPCAU AND
			A.REFCAU=B.REFCAU AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECCAU, A.STAIMP, B.FECANU
			UNION ALL
			SELECT 'PAG' AS TIPO,A.CODPRE, B.FECPAG AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPPAG A, CPPAGOS B, CPDOCPAG C
			WHERE C.AFEPRC='S' AND
			B.FECPAG>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECPAG<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPPAG=C.TIPPAG AND
			A.REFPAG=B.REFPAG AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECPAG, A.STAIMP, B.FECANU
			UNION ALL
			SELECT 'AJPR' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPPRC A, CPPRECOM B, CPAJUSTE C, CPMOVAJU D, CPDOCAJU E
			WHERE
			A.REFPRC=B.REFPRC AND
			A.REFPRC=C.REFERE AND
			C.REFAJU=D.REFAJU AND
			E.TIPAJU=C.TIPAJU AND
			A.CODPRE=D.CODPRE AND
			E.REFIER='P' AND
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."'))  AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU
			UNION ALL
			SELECT 'AJCO' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 as MONTO FROM CPIMPCOM A, CPCOMPRO B, CPAJUSTE C, CPMOVAJU D, CPDOCCOM E,CPDOCAJU F
			WHERE
			A.REFCOM=B.REFCOM AND
			A.REFCOM=C.REFERE AND
			C.REFAJU=D.REFAJU AND
			B.TIPCOM=E.TIPCOM AND
			A.CODPRE=D.CODPRE AND
			C.TIPAJU=F.TIPAJU AND
			F.REFIER='C' AND
			E.AFEPRC='S' AND
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."'))  AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
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
			E.AFEPRC='S' AND
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			(C.STAAJU='A' OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."')) AND
			(A.STAIMP='A'OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
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
			E.AFEPRC='S' AND
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."')) AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU) COMPROMISO
			WHERE TO_CHAR(FECMOV,'MM')>='".$this->perdesde."' AND TO_CHAR(FECMOV,'MM')<='".$this->perhasta."'
			GROUP BY CODPRE,FECMOV
			UNION ALL


			SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV,0 AS MONASI,0 AS PRECOMPROMISO,SUM(MONTO) AS COMPROMISO, 0 AS CAUSADO, 0 AS PAGADO, 0 AS MODIFICACION  FROM
			(
			SELECT 'COM' AS TIPO,A.CODPRE, B.FECCOM AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCOM A, CPCOMPRO B,CPDOCCOM C
			WHERE C.AFECOM='S' AND
			B.FECCOM>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECCOM<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPCOM=C.TIPCOM AND
			A.REFCOM=B.REFCOM AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECCOM, A.STAIMP, B.FECANU
			UNION ALL
			SELECT 'CAU' as TIPO,A.CODPRE, B.FECCAU AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPCAU A, CPCAUSAD B, CPDOCCAU C
			WHERE C.AFECOM='S' AND
			B.FECCAU>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECCAU<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPCAU=C.TIPCAU AND
			A.REFCAU=B.REFCAU AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECCAU, A.STAIMP, B.FECANU
			UNION ALL
			SELECT 'PAG' AS TIPO,A.CODPRE, B.FECPAG AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) as Monto FROM CPIMPPAG A, CPPAGOS B, CPDOCPAG C
			WHERE C.AFECOM='S' AND
			B.FECPAG>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECPAG<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPPAG=C.TIPPAG AND
			A.REFPAG=B.REFPAG AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
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
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."'))  AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
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
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			(C.STAAJU='A' OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."')) AND
			(A.STAIMP='A'OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
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
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."')) AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU) COMPROMISO
			WHERE TO_CHAR(FECMOV,'MM')>='".$this->perdesde."' AND TO_CHAR(FECMOV,'MM')<='".$this->perhasta."'
			GROUP BY CODPRE,FECMOV
			UNION ALL

			SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV, 0 AS MONASI,0 AS PRECOMPROMISO, 0 AS COMPROMISO, SUM(MONTO) AS CAUSADO, 0 AS PAGADO, 0 AS MODIFICACION  FROM
			(
			SELECT 'CAU' AS TIPO,A.CODPRE, B.FECCAU AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP)  AS Monto FROM CPIMPCAU A, CPCAUSAD B,CPDOCCAU C
			WHERE C.AFECAU='S' AND
			B.FECCAU>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECCAU<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPCAU=C.TIPCAU AND
			A.REFCAU=B.REFCAU AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,B.FECCAU,A.STAIMP,B.FECANU
			UNION ALL
			SELECT 'PAG' AS TIPO,A.CODPRE, B.FECPAG AS FECMOV, A.STAIMP, B.FECANU, SUM(A.MONIMP) AS  Monto FROM CPIMPPAG A, CPPAGOS B, CPDOCPAG C
			WHERE C.AFECAU='S' AND
			B.FECPAG>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECPAG<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPPAG=C.TIPPAG AND
			A.REFPAG=B.REFPAG AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,B.FECPAG,A.STAIMP,B.FECANU
			UNION ALL
			SELECT 'AJCA' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 AS Monto FROM CPIMPCAU A, CPCAUSAD B, CPAJUSTE C, CPMOVAJU D, CPDOCAJU E
			WHERE
			A.REFCAU=B.REFCAU AND
			A.REFCAU=C.REFERE AND
			A.REFERE=D.REFCOM AND
			A.CODPRE=D.CODPRE AND
			C.REFAJU=D.REFAJU AND
			E.TIPAJU=C.TIPAJU AND
			E.REFIER='A' AND
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."')) AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU
			UNION ALL
			SELECT 'AJPA' AS TIPO,A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU,SUM(D.MONAJU)*-1 AS Monto FROM CPIMPPAG A, CPPAGOS B, CPAJUSTE C, CPMOVAJU D, CPDOCPAG E, CPDOCAJU F
			WHERE  A.REFPAG=B.REFPAG AND
			A.REFPAG=C.REFERE AND
			A.REFCOM=D.REFCOM AND
			A.CODPRE=D.CODPRE AND
			C.REFAJU=D.REFAJU AND
			B.TIPPAG=E.TIPPAG AND
			F.TIPAJU=C.TIPAJU AND
			F.REFIER='G' and
			E.AFECAU='S' AND
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."')) AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU) CAUSADOS
			WHERE TO_CHAR(FECMOV,'MM')>='".$this->perdesde."' AND TO_CHAR(FECMOV,'MM')<='".$this->perhasta."'
			GROUP BY CODPRE,FECMOV
			UNION ALL

			SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV, 0 AS MONASI,0 AS PRECOMPROMISO, 0 AS COMPROMISO, 0 AS CAUSADO, SUM(MONTO) AS PAGADO, 0 AS MODIFICACION  FROM
			(
			SELECT 'PAG' AS TIPO,A.CODPRE, B.FECPAG AS FECMOV, A.STAIMP, B.FECANU,SUM(A.MONIMP) AS Monto FROM CPIMPPAG A, CPPAGOS B, CPDOCPAG C
			WHERE C.AFEPAG='S' AND
			B.FECPAG>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECPAG<=to_date('$this->fechas','dd/mm/yyyy') and
			B.TIPPAG=C.TIPPAG AND
			A.REFPAG=B.REFPAG AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,B.FECPAG,A.STAIMP,B.FECANU
			UNION ALL
			SELECT 'AJPA' AS TIPO, A.CODPRE, C.FECAJU AS FECMOV, A.STAIMP, B.FECANU, SUM(D.MONAJU)*-1 AS Monto FROM CPIMPPAG A, CPPAGOS B, CPAJUSTE C, CPMOVAJU D, CPDOCAJU E
			WHERE A.REFPAG=B.REFPAG AND
			A.REFPAG=C.REFERE AND
			A.CODPRE=D.CODPRE AND
			C.REFAJU=D.REFAJU AND
			E.TIPAJU=C.TIPAJU AND
			E.REFIER='G' AND
			C.FECAJU>=to_date('$this->fecdes','dd/mm/yyyy') and
			C.FECAJU<=to_date('$this->fechas','dd/mm/yyyy') and
			((C.STAAJU='A') OR (C.STAAJU='N' AND TO_CHAR(C.FECANU,'MM')>'".$this->perhasta."')) AND
			((A.STAIMP='A') OR (A.STAIMP='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE,C.FECAJU,A.STAIMP,B.FECANU) PAGADOS
			WHERE TO_CHAR(FECMOV,'MM')>='".$this->perdesde."' AND TO_CHAR(FECMOV,'MM')<='".$this->perhasta."'
			GROUP BY CODPRE,FECMOV
			UNION ALL

			SELECT CODPRE, TO_CHAR(FECMOV,'MM') AS PERMOV, 0 AS MONASI,0 AS PRECOMPROMISO, 0 AS COMPROMISO, 0 AS CAUSADO, 0 AS PAGADO, SUM(MONTO) AS MODIFICACION FROM
			(
			SELECT 'TRN' AS TIPO, A.CODORI AS CODPRE,B.FECTRA AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV)*-1 AS MONTO FROM CPMOVTRA A, CPTRASLA B
			WHERE A.REFTRA=B.REFTRA AND
			B.PERTRA>='".$this->perdesde."' AND
			B.PERTRA<='".$this->perhasta."' AND
			B.FECTRA>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECTRA<=to_date('$this->fechas','dd/mm/yyyy') and
			((B.STATRA='A') OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODORI, B.FECTRA, A.STAMOV, B.FECANU
			UNION ALL
			SELECT 'TRA' AS TIPO,A.CODDES AS CODPRE, B.FECTRA AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV) AS MONTO FROM CPMOVTRA A, CPTRASLA B
			WHERE A.REFTRA=B.REFTRA AND
			B.PERTRA>='".$this->perdesde."' AND
			B.PERTRA<='".$this->perhasta."' AND
			B.FECTRA>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECTRA<=to_date('$this->fechas','dd/mm/yyyy') and
			((B.STATRA='A') OR (B.STATRA='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODDES, B.FECTRA, A.STAMOV, B.FECANU
			UNION ALL
			SELECT 'ADI' AS TIPO, A.CODPRE,B.FECADI AS FECMOV, A.STAMOV, B.FECANU ,SUM(A.MONMOV) AS MONTO FROM CPMOVADI A, CPADIDIS B
			WHERE B.ADIDIS='A' AND
			A.REFADI=B.REFADI AND
			A.PERPRE>='".$this->perdesde."' AND
			A.PERPRE<='".$this->perhasta."' AND
			B.FECADI>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECADI<=to_date('$this->fechas','dd/mm/yyyy') and
			((B.STAADI='A') OR (B.STAADI='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECADI, A.STAMOV, B.FECANU
			UNION ALL
			SELECT 'DIS' AS TIPO, A.CODPRE, B.FECADI AS FECMOV, A.STAMOV, B.FECANU,SUM(A.MONMOV)*-1 AS MONTO FROM CPMOVADI A, CPADIDIS B
			WHERE B.ADIDIS='D' AND
			A.REFADI=B.REFADI AND
			A.PERPRE>='".$this->perdesde."' AND
			A.PERPRE<='".$this->perhasta."' AND
			B.FECADI>=to_date('$this->fecdes','dd/mm/yyyy') and
			B.FECADI<=to_date('$this->fechas','dd/mm/yyyy') and
			((B.STAADI='A') OR (B.STAADI='N' AND TO_CHAR(B.FECANU,'MM')>'".$this->perhasta."'))
			GROUP BY A.CODPRE, B.FECADI, A.STAMOV, B.FECANU)  MODIFICACION GROUP BY CODPRE,FECMOV
			)
			EJECUCION, CPDEFTIT WHERE EJECUCION.CODPRE=CPDEFTIT.CODPRE AND EJECUCION.CODPRE>='".$this->codpredes."' AND EJECUCION.CODPRE<='".$this->codprehas."' AND EJECUCION.CODPRE LIKE '".$this->comodin."'
			 GROUP BY ".$parchesqlg."
			 ORDER BY ".$parchesqlg." ";

//H::printR($this->sql);exit;

			$this->llenartitulosmaestro();

			$this->cab=new cabecera();
			$this->arrp=$this->bd->select($this->sql);

		}
		function llenartitulosmaestro()
		{
			$this->setFont("Arial","B",7);
				$this->titulos[0]="CODIGO PRESUPUESTO";
				$this->titulos[1]="DENOMINACION";
				$this->titulos[2]="ASIGNADO INICIAL";
				$this->titulos[3]="MODIFICACION(+/-)";
				$this->titulos[4]="TOTAL ASIGNADO";
				$this->titulos[5]="PRECOMP.";
				$this->titulos[6]="COMPROMISO";
				$this->titulos[7]="CAUSADO";
				$this->titulos[8]="PAGADO";
				$this->titulos[9]="% EJECUTADO";
			    $this->titulos[10]="DISP. POR PRECOM.";
			    $this->titulos[11]="DISP. POR COMPRO.";

		}


		function Header()
		{

				$this->anchos[0]=25;
				$this->anchos[1]=37;
				$this->anchos[2]=20;
				$this->anchos[3]=20;
				$this->anchos[4]=20;
				$this->anchos[5]=20;
				$this->anchos[6]=20;
				$this->anchos[7]=20;
				$this->anchos[8]=20;
				$this->anchos[9]=20;
				$this->anchos[10]=20;
				$this->anchos[11]=20;

			/*$aux = split("-",$this->agrupar);
			if(strtoupper(trim($aux[1]))=="SECTOR" && $this->nivhasta=="")
			{
				$this->titulo.="  Por Sectores";
			}elseif($this->nivhasta=="6" && trim($this->agrupar)=="")
			{
				$this->titulo.="  Por Partidas";
			}*/
			$this->cab->poner_cabecera($this,$this->titulo,"l","s");
			$this->setFont("Arial","B",7);
			$y=$this->getY();
			$this->setXY(230,28);
			$this->cell(40,4,"Período Fiscal: ".$this->perfis);
			$this->setXY(220,31);
			//$this->cell(40,4,"Desde:  ".$this->periodo($this->perdesde,1)."   Hasta:  ".$this->periodo($this->perhasta,2));
			$this->cell(40,4,"Desde:  ".$this->fecdes."   Hasta:  ".$this->fechas);
			$this->setY($y);
			$this->setWidths($this->anchos);
			$this->setAligns('C');
			$this->rowm($this->titulos);
			$this->ln(3);
			$this->Line(10,45,270,45);
			$this->ln(2);
		}

		function periodo($periodo,$inifin)
		{
			if($inifin==1)
				return "01/".$periodo."/".$this->perfis;
			else
			{
				if($periodo=="01"||$periodo=="03"||$periodo=="05"||$periodo=="07"||$periodo=="08"||$periodo=="10"||$periodo=="12")
					return "31/".$periodo."/".$this->perfis;
				elseif($periodo=="04"||$periodo=="06"||$periodo=="09"||$periodo=="11")
				    return "30/".$periodo."/".$this->perfis;
				else
				    return "29/".$periodo."/".$this->perfis;
			}

		}

		function Cuerpo()
		{
			/*$nombre_archivo="ejecucion_presupuestaria_".date("d_m_y").".xls";
			 if (!file_exists($nombre_archivo))
			 {
		 		 fopen($nombre_archivo,"w");
			 }
			 chmod ($nombre_archivo,0755);
			 $ejecucion = fopen($nombre_archivo,'w+');*/
		    $tb=$this->arrp;
		    $contpar=0;
			$contcat=0;
			$conttot=0;

			$ref="";
			$totalprc=0;
            $totalcom=0;
	        $totalcau=0;
	 	    $totalpag=0;
 	        $totalmod=0;
            $totalasi=0;
            $totalaco=0;
	        $totaldeu=0;
	 	    $totaldis=0;
			$totaldis2=0;

			$totalprcpar=0;
            $totalcompar=0;
	        $totalcaupar=0;
	 	    $totalpagpar=0;
 	        $totalmodpar=0;
            $totalasipar=0;
            $totalacopar=0;
	        $totaldeupar=0;
	 	    $totaldispar=0;
	 	     $totaldispar2=0;
	 	    $totalejepar=0;

			$totalprccat=0;
            $totalcomcat=0;
	        $totalcaucat=0;
	 	    $totalpagcat=0;
 	        $totalmodcat=0;
            $totalasicat=0;
            $totalacocat=0;
	        $totaldeucat=0;
	 	    $totaldiscat=0;
	 	    $totaldiscat2=0;
	 	    $totalejecat=0;
			$categoria="-1";
			$partida="-1";
			#$cadena="";
			#$cadena="CODIGO\tDENOMINACIÓN\tLEY\tMODIFICACIÓN\tACORDADO\tPRECOMPROMETIDO\tDISPONIBILIDAD\tCOMPROMISO\tCAUSADO\tPAGADO\tEJECUTADO".chr(13).chr(10);
	 		#fputs($ejecucion,$cadena);
			while(!$tb->EOF)
			{

				//Total por Categoria esto lo puedo mejorar, me parece que hay mucho codigo. despues le doy la vuelta
				//mostramos el titulo del primer prograna
                if ($categoria=="-1")
				{
  				 $this->setFont("Arial","B",7);
				 if (!empty($tb->fields["categoria"]))
				 {
				 	$this->cell(24,4,$tb->fields["categoria"],0,0,'L');

				 	#$cadena.=$tb->fields["categoria"];
				 	$this->SetX(36);
				 	$tbcod=$this->bd->select("select upper(nompre) as nompre from cpdeftit where trim(codpre) = '".$tb->fields["categoria"]."'");
				 	$this->cell(23,4,strtoupper($tbcod->fields["nompre"]),0,0,'L');
				 	$this->ln(6);
				 	#$cadena=$tb->fields["categoria"]."\t".trim(strtoupper($tbcod->fields["nompre"])).chr(13).chr(10);
	 				#fputs($ejecucion,$cadena);
				 }

				}
				//TOTALES POR PARTIDA

				if (($partida!=$tb->fields["partida"] && $partida!="-1" ) || ($categoria!=$tb->fields["categoria"])&&($categoria!="-1"))
				{
				    if (!empty($tb->fields["partida"]))
				    {
				    	$this->setFont("Arial","B",7);
						$this->ln(2);
						$this->cell(62,4,"SubT. ".$partida." ",0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totalasipar),0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totalmodpar),0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totalacopar),0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totalprcpar),0,0,'R');

						$this->cell(20,4,H::FormatoMonto($totalcompar),0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totalcaupar),0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totalpagpar),0,0,'R');
						$this->cell(20,4,H::FormatoMonto(($totalcaupar/$totalacopar)*100),0,0,'R');
							$this->cell(20,4,H::FormatoMonto($totaldispar),0,0,'R');
							$this->cell(20,4,H::FormatoMonto($totaldispar2),0,0,'R');
						#$cadena="\t"."TOTAL PARTIDA\t".H::FormatoMonto($totalasipar)."\t".H::FormatoMonto($totalmodpar)."\t".H::FormatoMonto($totalacopar)."\t".H::FormatoMonto($totalprcpar)."\t".H::FormatoMonto($totaldispar)."\t".H::FormatoMonto($totalcompar)."\t"
						#		.H::FormatoMonto($totalcaupar)."\t".H::FormatoMonto($totalpagpar)."\t".H::FormatoMonto(($totalcaupar/$totalacopar)*100)."\t".chr(13).chr(10);
	 					#fputs($ejecucion,$cadena);
						$contpar=0;
						/*$this->ln(6);
	 				    $this->cell(24,4,$tb->fields["partida"],0,0,'L');
					    $this->SetX(36);
					    $det1=$this->bd->select("select max(nompre) as nompre from cpdeftit where trim(codpre) like '%".$tb->fields["categoria"]."'");
					 	$this->cell(23,4,$det1->fields["nompre"]);*/
					    $this->ln(6);
						$this->setFont("Arial","",7);
						$totalprcpar=$tb->fields["precompromiso"];
						$totalcompar=$tb->fields["compromiso"];
						$totalcaupar=$tb->fields["causado"];
						$totalpagpar=$tb->fields["pagado"];
						$totalmodpar=$tb->fields["modificado"];
						$totalasipar=$tb->fields["asignacion"];
						$totalacopar=$tb->fields["asignacion"]+$tb->fields["modificado"];
						$totaldispar=$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["precompromiso"];
							$totaldispar2=$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["compromiso"];
						$acordado=$tb->fields["asignacion"]+$tb->fields["modificado"];
						if($acordado!=0)
						     $totalejepar=($tb->fields["causado"]/($acordado))*100;
						 else
						     $totalejepar=0;
						//$totaldeupar=$tb->fields["causado"]-$tb->fields["pagado"];
				    }

				}
				else
				{
					//ACUMULADOR POR CATEGORIAS
					$totalprcpar+=$tb->fields["precompromiso"];
					$totalcompar+=$tb->fields["compromiso"];
					$totalcaupar+=$tb->fields["causado"];
					$totalpagpar+=$tb->fields["pagado"];
					$totalmodpar+=$tb->fields["modificado"];
					$totalasipar+=$tb->fields["asignacion"];
					$totalacopar+=$tb->fields["asignacion"]+$tb->fields["modificado"];
					$totaldispar+=$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["precompromiso"];
					$totaldispar2+=$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["compromiso"];
					//$totaldeupar+=$tb->fields["causado"]-$tb->fields["pagado"];
					$acordado=$tb->fields["asignacion"]+$tb->fields["modificado"];
					if($acordado!=0)
					     $totalejepar+=($tb->fields["causado"]/($acordado))*100;
				}
				//TOTALES POR CATEGORIA
				$this->setFont("Arial","",7);
				if (($categoria!=$tb->fields["categoria"])&&($categoria!="-1") )
				{
				    $this->setFont("Arial","B",7);
					$this->ln(2);
					$this->cell(62,4,"SUB-TOTAL ".$categoria." ",0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totalasicat),0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totalmodcat),0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totalacocat),0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totalprccat),0,0,'R');

					$this->cell(20,4,H::FormatoMonto($totalcomcat),0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totalcaucat),0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totalpagcat),0,0,'R');
					$this->cell(20,4,H::FormatoMonto(($totalcaucat/$totalacocat)*100),0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totaldiscat),0,0,'R');
						$this->cell(20,4,H::FormatoMonto($totaldiscat2),0,0,'R');
					#$cadena="\t"."TOTALES CATEGORIA\t".H::FormatoMonto($totalasicat)."\t".H::FormatoMonto($totalmodcat)."\t".H::FormatoMonto($totalacocat)."\t".H::FormatoMonto($totalprccat)."\t".H::FormatoMonto($totaldiscat)."\t".H::FormatoMonto($totalcomcat)."\t"
					#			.H::FormatoMonto($totalcaucat)."\t".H::FormatoMonto($totalpagcat)."\t".H::FormatoMonto(($totalcaucat/$totalacocat)*100)."\t".chr(13).chr(10);
	 				#fputs($ejecucion,$cadena);
					$contcat=0;
					$this->ln(6);
 				    $this->cell(24,4,$tb->fields["categoria"],0,0,'L');
				    $this->SetX(36);
				    $det1=$this->bd->select("select upper(nompre) as nompre from cpdeftit where trim(codpre) = '".$tb->fields["categoria"]."'");
				 	$this->cell(23,4,strtoupper($det1->fields["nompre"]));
				 	#$cadena=$tb->fields["categoria"]."\t".trim(strtoupper($det1->fields["nompre"])).chr(13).chr(10);
	 				#fputs($ejecucion,$cadena);
				    $this->ln(6);
					$this->setFont("Arial","",7);
					$totalprccat=$tb->fields["precompromiso"];
					$totalcomcat=$tb->fields["compromiso"];
					$totalcaucat=$tb->fields["causado"];
					$totalpagcat=$tb->fields["pagado"];
					$totalmodcat=$tb->fields["modificado"];
					$totalasicat=$tb->fields["asignacion"];
					$totalacocat=$tb->fields["asignacion"]+$tb->fields["modificado"];
					$totaldiscat=$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["precompromiso"];
					$totaldiscat2=$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["compromiso"];
					$acordado=$tb->fields["asignacion"]+$tb->fields["modificado"];
						if($acordado!=0)
						     $totalejecat=($tb->fields["causado"]/($acordado))*100;
						 else
						     $totalejecat=0;
					//$totaldeucat=$tb->fields["causado"]-$tb->fields["pagado"];
				}
				else
				{
					//ACUMULADOR POR CATEGORIAS
					$totalprccat=$totalprccat+$tb->fields["precompromiso"];
					$totalcomcat=$totalcomcat+$tb->fields["compromiso"];
					$totalcaucat=$totalcaucat+$tb->fields["causado"];
					$totalpagcat=$totalpagcat+$tb->fields["pagado"];
					$totalmodcat=$totalmodcat+$tb->fields["modificado"];
					$totalasicat=$totalasicat+$tb->fields["asignacion"];
					$totalacocat=$totalacocat+$tb->fields["asignacion"]+$tb->fields["modificado"];
					$totaldiscat=$totaldiscat+$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["precompromiso"];
					$totaldiscat2=$totaldiscat2+$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["compromiso"];
					//$totaldeucat=$totaldeucat+$tb->fields["causado"]-$tb->fields["pagado"];
					$acordado=$tb->fields["asignacion"]+$tb->fields["modificado"];
					if($acordado!=0)
						$totalejecat+=($tb->fields["causado"]/($acordado))*100;
				}
				$categoria=$tb->fields["categoria"];
				$partida=$tb->fields["partida"];

				//Detalle
				$contpar++;
				$contcat++;
				$conttot++;
				$this->setFont("Arial","",6.5);
				$this->cell(34,4,$tb->fields["codpre"]);
                $this->SetX(72);
				$this->cell(20,4,H::FormatoMonto($tb->fields["asignacion"]),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($tb->fields["modificado"]),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($tb->fields["asignacion"]+$tb->fields["modificado"]),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($tb->fields["precompromiso"]),0,0,'R');

				$this->cell(20,4,H::FormatoMonto($tb->fields["compromiso"]),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($tb->fields["causado"]),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($tb->fields["pagado"]),0,0,'R');
				$acordado=$tb->fields["asignacion"]+$tb->fields["modificado"];
				if (($acordado)==0)
				{
					$this->cell(17,4,H::FormatoMonto(0),0,0,'R');
					$acor=0;
				}
				else
				{
					$this->cell(17,4,H::FormatoMonto(($tb->fields["causado"]/($acordado))*100),0,0,'R');
					$acor=(($tb->fields["causado"]/($acordado))*100);
				}

               $this->cell(20,4,H::FormatoMonto($tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["precompromiso"]),0,0,'R');
                $this->cell(20,4,H::FormatoMonto($tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["compromiso"]),0,0,'R');
                $this->SetX(36);
                if($this->lonpartida==0 )
                   $tbcod=$this->bd->select("select upper(nompre) as nompre from cpdeftit where trim(codpre) = '".$tb->fields["codpre"]."'");
                else
                   $tbcod=$this->bd->select("select max(nompre) as nompre from cpdeftit where trim(codpre) like '%".$tb->fields["categoria"]."%%-".$tb->fields["codpre"]."' group by codpre order by codpre");
                //H::printR($this->bd->select("select max(nompre) as nompre from cpdeftit where trim(codpre) like '%".$tb->fields["categoria"]."%%".$tb->fields["codpre"]."'"));exit;
				$this->multicell(37,4,(strtoupper($tbcod->fields["nompre"])));
				#$cadena=$tb->fields["codpre"]."\t".trim(strtoupper($tbcod->fields["nompre"]))."\t".H::FormatoMonto($tb->fields["asignacion"])."\t".
				#				H::FormatoMonto($tb->fields["modificado"])."\t".H::FormatoMonto($tb->fields["asignacion"]+$tb->fields["modificado"])."\t".H::FormatoMonto($tb->fields["precompromiso"])."\t".
				#				H::FormatoMonto($tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["precompromiso"])."\t".H::FormatoMonto($tb->fields["compromiso"])."\t"
				#				.H::FormatoMonto($tb->fields["causado"])."\t".H::FormatoMonto($tb->fields["pagado"])."\t".H::FormatoMonto($acor)."\t".chr(13).chr(10);
	 			#fputs($ejecucion,$cadena);

				//ACUMULADOR GENERAL
				$totalprc=$totalprc+$tb->fields["precompromiso"];
		        $totalcom=$totalcom+$tb->fields["compromiso"];
		        $totalcau=$totalcau+$tb->fields["causado"];
	  		    $totalpag=$totalpag+$tb->fields["pagado"];
 		        $totalmod=$totalmod+$tb->fields["modificado"];
		        $totalasi=$totalasi+$tb->fields["asignacion"];
		        $totalaco=$totalaco+$tb->fields["asignacion"]+$tb->fields["modificado"];
	  		    $totaldis=$totaldis+$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["precompromiso"];
	  		    $totaldis2=$totaldis2+$tb->fields["asignacion"]+$tb->fields["modificado"]-$tb->fields["compromiso"];
 		        //$totaldeu=$totaldeu+$tb->fields["causado"]-$tb->fields["pagado"];
				$acordado=$tb->fields["asignacion"]+$tb->fields["modificado"];
					if($acordado!=0)
						$totaleje+=($tb->fields["causado"]/($acordado))*100;

				$tb->MoveNext();
				if ($this->GetY()>=170){
					$this->AddPage();
				}
			}//while
			$tb->Close();
			$this->setFont("Arial","B",6.5);
			if ($partida!="")
			{
				//IMPRIMO EL ULTIMO TOTAL DE PAR
				$this->cell(62,4,"SubT. ".$partida." ",0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalasipar),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalmodpar),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalacopar),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalprcpar),0,0,'R');

				$this->cell(20,4,H::FormatoMonto($totalcompar),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalcaupar),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalpagpar),0,0,'R');
			//	$this->cell(21,4,H::FormatoMonto(($totalcaupar/$totalacopar)*100),0,0,'R');
			$this->cell(20,4,H::FormatoMonto($totaldispar),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totaldispar2),0,0,'R');
				$this->ln();
				#$cadena="\t"."TOTAL PARTIDA\t".H::FormatoMonto($totalasipar)."\t".H::FormatoMonto($totalmodpar)."\t".H::FormatoMonto($totalacopar)."\t".H::FormatoMonto($totalprcpar)."\t".H::FormatoMonto($totaldispar)."\t".H::FormatoMonto($totalcompar)."\t"
				#				.H::FormatoMonto($totalcaupar)."\t".H::FormatoMonto($totalpagpar)."\t".H::FormatoMonto(($totalcaupar/$totalacopar)*100)."\t".chr(13).chr(10);
	 			#fputs($ejecucion,$cadena);
			}
			if ($categoria!="")
			{
				//IMPRIMO EL ULTIMO TOTAL DE CAT
	  		    $this->cell(62,4,"SUB-TOTAL ".$categoria."     ",0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalasicat),0,0,'R');
	 			$this->cell(20,4,H::FormatoMonto($totalmodcat),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalacocat),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalprccat),0,0,'R');

				$this->cell(20,4,H::FormatoMonto($totalcomcat),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalcaucat),0,0,'R');
				$this->cell(20,4,H::FormatoMonto($totalpagcat),0,0,'R');
				$this->cell(20,4,H::FormatoMonto(($totalcaucat/$totalacocat)*100),0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totaldiscat),0,0,'R');
					$this->cell(20,4,H::FormatoMonto($totaldiscat2),0,0,'R');
				$this->ln();
				#$cadena="\t"."TOTALES CATEGORIA\t".H::FormatoMonto($totalasicat)."\t".H::FormatoMonto($totalmodcat)."\t".H::FormatoMonto($totalacocat)."\t".H::FormatoMonto($totalprccat)."\t".H::FormatoMonto($totaldiscat)."\t".H::FormatoMonto($totalcomcat)."\t"
				#				.H::FormatoMonto($totalcaucat)."\t".H::FormatoMonto($totalpagcat)."\t".H::FormatoMonto(($totalcaucat/$totalacocat)*100)."\t".chr(13).chr(10);
	 			#fputs($ejecucion,$cadena);
			}
			//AHORA EL TOTAL GENERAL
			$this->Line(10,$this->GetY(),270,$this->GetY());
			$this->cell(62,7,"TOTAL GENERAL",0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totalasi),0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totalmod),0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totalaco),0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totalprc),0,0,'R');

			$this->cell(20,7,H::FormatoMonto($totalcom),0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totalcau),0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totalpag),0,0,'R');
			$this->cell(20,7,H::FormatoMonto(($totalcau/$totalaco)*100),0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totaldis),0,0,'R');
			$this->cell(20,7,H::FormatoMonto($totaldis2),0,0,'R');
            $this->setFont("Arial","",7);
            #$cadena="\t"."TOTAL GENERAL\t".H::FormatoMonto($totalasi)."\t".H::FormatoMonto($totalmod)."\t".H::FormatoMonto($totalaco)."\t".H::FormatoMonto($totalprc)."\t".H::FormatoMonto($totaldis)."\t".H::FormatoMonto($totalcom)."\t"
			#					.H::FormatoMonto($totalcau)."\t".H::FormatoMonto($totalpag)."\t".H::FormatoMonto(($totalcau/$totalaco)*100)."\t".chr(13).chr(10);
	 		#fputs($ejecucion,$cadena);

	 		//ARCHIVO DE TEXTO
			 /*$dir = parse_url($_SERVER['HTTP_REFERER']);
			 $parte = explode("/",$dir['path']);
			 for($i=0;$i<count($parte)-1;$i++)
			 {
		 		 $agregar.=$parte[$i]."/";
			 }
			 $dir = $dir['scheme'].'://'.$dir['host'].$agregar;
			 $this->ln();
			 $this->PutLink( $dir.'descargar.php?archivo='.$nombre_archivo,'EXCEL DE EJECUCION PRESUPUESTARIA');
			 fclose($ejecucion);*/
            $this->bd->closed();
		}
	}
?>