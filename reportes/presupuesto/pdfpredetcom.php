<?
//Definiciones de Funciones
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");

/*
AYUDA:
Cell(with,healt,Texto,border,linea,align,fillm-Fondo,link)
AddFont(family,style,file)
ln() -> Salto de Linea
$this->GetY()  -> Posicion del cursor
$this->GetX()  -> Posicion del cursor
*/

	class pdfreporte extends fpdf
	{
		//Def de Variables a utilizar
		var $bd;
		var $titulos;
		var $numcomp1;
		var $numcomp2;
		var $fechcomp1;
		var $fechcomp2;
		var $tipcomp1;
		var $tipcomp2;
		var $status;
		var $codpresu1;
		var $codpresu2;
		var $comodin;


		function pdfreporte()
		{
			$this->fpdf("l","mm","Letter");  //constructor
			$this->bd=new basedatosAdo();

			//Recibir las variables por el Post
			$this->numcomp1=$_POST["numcomp1"];
			$this->numcomp2=$_POST["numcomp2"];
			$this->fechcomp1=$_POST["fechcomp1"];
			$this->fechcomp2=$_POST["fechcomp2"];
			$this->tipcomp1=$_POST["tipcomp1"];
			$this->tipcomp2=$_POST["tipcomp2"];
			$this->status=$_POST["status"];
			$this->codpresu1=$_POST["codpresu1"];
			$this->codpresu2=$_POST["codpresu2"];
			$this->comodin=$_POST["comodin"];
			$this->cab=new cabecera();
			if ($this->status=='A'){
				$this->status='A';
				$this->pstatus='ACTIVOS';
			}else {
				$this->pstatus='ANULADOS'; $this->status='N';
			}
		}


		function Header()
		{
			$dir = parse_url($_SERVER["HTTP_REFERER"]);
			$parte = explode("/",$dir["path"]);
			$ubica = count($parte)-2;
			$this->cab->poner_cabecera_f_b($this," DETALLE DE COMPROMISOS A LA FECHA","l","s","s");

			$this->Cell(0,10,$this->pstatus.'  '.'DEL '.$this->fechcomp1.' AL '.$this->fechcomp2,0,0,'C');
			//$this->Cell(10,10,'                                    DEL:                        AL:');
			//$this->Cell(3,3,'AL');
			$this->ln(6);

			//$fecha=date("d/m/Y");
			//$this->Cell(15,0,'                                                                                                          FECHA:   '.$fecha);//,0,0,'C');
			$this->ln(10);
			//$this->Line(10,47,270,47);

			$this->ln(-16);
			$this->cell(70,10, ' ');

			//$this->line();
	//		$this->Cell(0,10,'DEL: '.$this->fechcomp1.' AL: '.$this->fechcomp2,0,0,'C');
			//$this->cell(30,10,$this->fechcomp1,0,0,'C');
			$this->cell(4,10, ' ');
			//$this->cell(40,10,$this->fechcomp2);
			$this->ln(16);
			$this->setFont("Arial","B",9);
			$this->ln(-2);
			//$this->line(10,56,270,56);
		    $this->cell(40,10,"CODIGO PRESUPUESTARIO",0,0,'C');
			$this->cell(78,10,"BENEFICIARIO",0,0,'C');
			$this->cell(35,10,"           # MOVIMIENTO",0,0,'C');
                        $this->cell(35,10,"           TIPO DOCUMENTO",0,0,'C');
			$this->cell(30,10,"                       FECHA");
			$this->cell(35,10,"                            MONTO");
			$this->GetY();
			$this->Line(10,$this->GetY()+8,270,$this->GetY()+8);
			$this->ln(9);$this->setFont("Arial","",9);
		}

		function Cuerpo()
		{

			if ($this->status=="A"){

  	   	$stacom="AND A.STACOM='A'";
  	  	$stacau="AND A.STACAU='A'";
  	  	$stapag="AND A.STAPAG='A'";
  	  }
  	  else if($this->status=="N"){
  	   	$stacom="AND A.STACOM='N'";
  	  	$stacau="AND A.STACAU='N'";
  	  	$stapag="AND A.STAPAG='N'";
  	  }

  	  if ($this->comodin=="")
  	  {
  	  	$filtro = "";
  	  }
  	  else
  	  {
  	  	$filtro = "and B.CODPRE like '%".$this->comodin."%'";
  	  }


			$this->setFont("Arial","",9);
			$sql2="SELECT A.refcom, A.tipcom, to_char(A.feccom,'DD/MM/YYYY')as fecha, A.descom, B.CodPre, C.NomPre,
			B.monimp, B.moncau, B.monpag, B.monaju, A.cedrif, (B.monimp-B.monaju) as Mon_Aju
			FROM CPCOMPRO A, CPIMPCOM B, CPDEFTIT C WHERE A.refcom = B.refcom AND B.codpre = C.codpre
			AND A.refcom>=('".$this->numcomp1."')  AND A.refcom <=('".$this->numcomp2."')
			AND A.feccom>=to_date('".$this->fechcomp1."','DD/MM/YYYY')
			AND A.feccom<=to_date('".$this->fechcomp2."','DD/MM/YYYY')
			AND B.codpre >=('".$this->codpresu1."') AND B.CODPRE <= ('".$this->codpresu2."')
			AND A.TIPCOM >= ('".$this->tipcomp1."') AND A.TIPCOM <= ('".$this->tipcomp2."')
			AND A.STACOM=('".$this->status."') AND  B.codpre LIKE ('".$this->comodin."')
			ORDER BY  A.refcom,A.feccom,B.codpre";
		//	print '<pre>';print $sql;
			$tb12=$this->bd->select("SELECT A.refcom, A.tipcom, to_char(A.feccom,'DD/MM/YYYY')as fecha, A.descom, B.CodPre, C.NomPre,
			B.monimp, B.moncau, B.monpag, B.monaju, A.cedrif, (B.monimp-B.monaju) as Mon_Aju
			FROM CPCOMPRO A, CPIMPCOM B, CPDEFTIT C WHERE A.refcom = B.refcom AND B.codpre = C.codpre
			AND A.refcom>=('".$this->numcomp1."')  AND A.refcom <=('".$this->numcomp2."')
			AND A.feccom>=to_date('".$this->fechcomp1."','DD/MM/YYYY')
			AND A.feccom<=to_date('".$this->fechcomp2."','DD/MM/YYYY')
			AND B.codpre >=('".$this->codpresu1."') AND B.CODPRE <= ('".$this->codpresu2."')
			AND A.TIPCOM >= ('".$this->tipcomp1."') AND A.TIPCOM <= ('".$this->tipcomp2."')
			AND A.STACOM=('".$this->status."') AND  B.codpre LIKE ('".$this->comodin."')
			ORDER BY  A.refcom,A.feccom,B.codpre");// AND  B.codpre LIKE ('".$this->comodin."')

			  $tb1=$this->bd->select("  SELECT codigo as  CodPre , cedrif as cedrif,   referencia as refcom,fecha, imputado as monimp,tipo as tipo
               FROM (SELECT
				A.refcom as referencia,
				RTRIM(A.descom) as descripcion,
				A.tipcom as tipo,
				to_char(A.feccom,'DD/MM/YYYY') as fecha,
				A.CEDRIF as cedrif,
				a.stacom as estat,
				RTRIM(B.CodPre) as codigo,
				B.monimp as imputado,
				B.monimp as comprometido,
				B.moncau as causado,
				B.monpag as pagado,
				B.monaju as Ajuste,
				(B.monimp-B.monaju)as Mon_Aju, c.nomben,   	  a.moncom as monto
				FROM
				CPCOMPRO as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
				CPIMPCOM as B,
				CPDOCCOM as D
				WHERE
				A.TIPCOM=D.TIPCOM AND RTRIM(D.AFECOM)='S'
				AND A.REFCOM = B.REFCOM
				AND (A.FECCOM >=to_date('".$this->fechcomp1."','dd/mm/yyyy') AND A.FECCOM <=to_date('".$this->fechcomp2."','dd/mm/yyyy'))
				AND (RTRIM(A.TIPCOM) >= RTRIM('".$this->tipcomp1."') AND RTRIM(A.TIPCOM) <= RTRIM('".$this->tipcomp2."'))
				AND (A.REFCOM)>=RTRIM('".$this->numcomp1."')  AND (A.REFCOM) <=RTRIM('".$this->numcomp2."')
				AND (B.CODPRE >=RTRIM('".$this->codpresu1."') AND B.CODPRE<=RTRIM('".$this->codpresu2."'))
				".$stacom." $filtro
				UNION
				SELECT
				A.refcau as referencia,
				RTRIM(A.descau)as descripcion,
				A.tipcau as tipo,
				to_char(A.feccau,'dd/mm/yyyy') as fecha,
				A.CEDRIF as cedrif,
				a.stacau as estat,
				RTRIM(B.CodPre ) as codigo,
				B.monimp as imputado,
				B.monimp as comprometido,
				B.monIMP as causado,
				B.monpag as pagado,
				B.monaju as Ajuste,
				(B.monimp-B.monaju) as Mon_Aju, c.nomben, a.moncau as monto
				FROM
				CPCAUSAD as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
				CPIMPCAU as B,
				CPDOCCAU as D
				WHERE
				A.TIPCAU=D.TIPCAU AND RTRIM(D.AFECOM)='S'
                AND A.REFCAU = B.REFCAU
                AND (A.FECCAU >=to_date('".$this->fechcomp1."','dd/mm/yyyy') AND A.FECCAU <=to_date('".$this->fechcomp2."','dd/mm/yyyy'))
				AND (RTRIM(A.TIPCAU) >=  RTRIM('".$this->tipcomp1."') AND RTRIM(A.TIPCAU) <=  RTRIM('".$this->tipcomp2."'))
				AND (A.REFCAU)>=RTRIM('".$this->numcomp1."') AND (A.REFCAU) <=RTRIM('".$this->numcomp2."')
				AND (B.CODPRE >=RTRIM('".$this->codpresu1."') AND B.CODPRE<=RTRIM('".$this->codpresu2."'))
				".$stacau." $filtro
				UNION
				SELECT
				A.refpag as referencia,
				RTRIM(A.despag)as descripcion,
				A.tippag as tipo,
				to_char(A.fecpag,'dd/mm/yyyy') as fecha,
				A.CEDRIF as cedrif,
				a.stapag as estat,
				RTRIM(B.CodPre ) as codigo,
				B.monimp as imputado,
				B.monimp as comprometido,
				B.monIMP as causado,
				B.monIMP as pagado,
				B.monaju as Ajuste,
				(B.monimp-B.monaju) as Mon_Aju, c.nomben, a.monpag as monto
				FROM
				CPPAGOS as A left outer join opbenefi C on A.CEDRIF=C.CEDRIF,
				CPIMPPAG as B,
				CPDOCPAG as D
				WHERE
				A.TIPPAG=D.TIPPAG
				AND RTRIM(D.AFECOM)='S'
                AND A.REFPAG = B.REFPAG
                AND (A.FECPAG >=to_date('".$this->fechcomp1."','dd/mm/yyyy') AND A.FECPAG <=to_date('".$this->fechcomp2."','dd/mm/yyyy'))
				AND (A.TIPPAG >=  RTRIM('".$this->tipcomp1."') AND RTRIM(A.TIPPAG) <=  RTRIM('".$this->tipcomp2."'))
				AND (A.REFPAG)>=RTRIM('".$this->numcomp1."') AND (A.REFPAG) <=RTRIM('".$this->numcomp2."')
				AND (B.CODPRE >=RTRIM('".$this->codpresu1."') AND B.CODPRE<=RTRIM('".$this->codpresu2."'))
			    ".$stapag."  $filtro
				 		ORDER BY fecha,referencia asc,codigo,estat
			    ) as J left outer join CPDEFTIT P on (RTRIM(J.CODIGO)=RTRIM(P.CODPRE))");
			//print '<pre>';print $sql;
				$total=0;
			while(!$tb1->EOF)
			{$this->setFont("Arial","",9);
				$cont=$cont+1;
				$this->ln(4);
				$this->cell(62,4,$tb1->fields["codpre"]);
				//$this->cell(118,10,substr($tb1->fields["nompre"],0,60));
				$this->cell(78,4,"");$y=$this->gety();
                           	$this->cell(30,4,substr($tb1->fields["refcom"],0,30));
                                $this->cell(35,4,substr($tb1->fields["tipo"],0,30));
				$this->cell(20,4,substr($tb1->fields["fecha"],0,60));
				$this->cell(30,4,number_format($tb1->fields["monimp"],2,',','.'),0,0,'R');
				//esto es si quieren una linea despues de cada fila
				//$this->ln(4);
				//$this->Line(10,$this->GetY()+4,270,$this->GetY()+4);
				$total=$total+$tb1->fields["monimp"];
				$tb2=$this->bd->select("SELECT nomben FROM opbenefi WHERE trim(cedrif)=trim('".$tb1->fields["cedrif"]."')");
				while(!$tb2->EOF)
				{	$this->setFont("Arial","",9);
					//$this->ln(4);
					//$this->cell(62+30,10,' ');
					$this->setxy(68,$y);
					$this->multicell(78,4,strtoupper($tb2->fields["nomben"]));
					$tb2->MoveNext();
				}

				$tb1->MoveNext();
			}
				$this->setFont("Arial","B",9);
			$this->ln(4);
			$this->Line(10,$this->GetY()+4,270,$this->GetY()+4);
			$this->ln(4);
			$this->cell(212,10,"");
			$this->cell(17,10,"TOTAL");
			$this->cell(30,10,number_format($total,2,',','.'),0,0,'C');
 			// $this->cell(35,10,number_format($this->total,2,'.',','));
 			$this->setFont("Arial","",9);
		}


	}
?>