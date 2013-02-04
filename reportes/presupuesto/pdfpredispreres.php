<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");

 require_once("../../lib/general/cabecera.php");
	class pdfreporte extends fpdf
	{

	var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $anchos2;
		var $campos;
		var $sql;
		var $perdesde;
		var $perhasta;
		var $nivdesde;
		var $nivhasta;
		var $codpredes;
		var $codprehas;
		var $tippre;
		var $conf;

		function pdfreporte()
		{
			$this->conf="p";
			$this->fpdf($this->conf,"mm","Letter");
			$this->bd=new basedatosAdo();
	$this->cab=new cabecera();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->perdesde=$_POST["perdesde"];
			$this->perhasta=$_POST["perhasta"];
			$this->nivdesde=$_POST["nivdesde"];
			$this->nivhasta=$_POST["nivhasta"];
			$this->codpredes=$_POST["codpredes"];
			$this->codprehas=$_POST["codprehas"];
			$this->tippre=$_POST["tippre"];
			$this->filtro=$_POST["filtro"];
			$this->gaceta=H::GetPost("gaceta");
			$this->decre=H::GetPost("decre");
         	$this->revisado=H::GetPost("revisado");
			$this->conformado=H::GetPost("conformado");

			if (trim($this->tippre) == "General"){
	   			$tipopresup1 = "I";
      			$tipopresup2 = "F";
			}
  			if (trim($this->tippre) == "Inversión"){
  	   			$tipopresup1 = "I";
      			$tipopresup2 = "I";
  			}
  			if (trim($this->tippre) == "Funcionamiento")
  			{
  	   			$tipopresup1 = "F";
  				$tipopresup2 = "F";
  			}


			$this->despuesParametro();
			$this->antesreporte();


			$this->sql="SELECT SUBSTR(A.CODPRE,1,2) as sector,
						SUBSTR(A.CODPRE,1,5) as programa ,
						SUBSTR(A.CODPRE,1,11) as actividad ,
						A.CODPRE as codpre,
						RTRIM(B.Nompre) as NomPre,
						A.Modificacion, A.MonPrc, A.MonCom,
						A.MonCau, A.MonPag,
						(case when LENGTH(RTRIM(A.CODPRE))='".$this->lonnivhas."' then A.MODIFICACION else 0 end) as monmodult,
						(case when LENGTH(RTRIM(A.CODPRE))='".$this->lonnivhas."' then A.MONPRC else 0 end) as MONPRCULT,
						(case when LENGTH(RTRIM(A.CODPRE))='".$this->lonnivhas."' then A.MONCOM else 0 end) as MONCOMULT,
						(case when LENGTH(RTRIM(A.CODPRE))='".$this->lonnivhas."' then A.MONCAU else 0 end) as MONCAUULT,
						(case when LENGTH(RTRIM(A.CODPRE))='".$this->lonnivhas."' then A.MONPAG else 0 end) as MONPAGULT
						FROM cpdisniv".$this->aleatorio." A, CPDEFTIT B WHERE RTRIM(B.CODPRE)=RTRIM(A.CODPRE) AND
            			LENGTH(RTRIM(A.CODPRE))>= '".$this->lonnivdes."' AND
            			LENGTH(RTRIM(A.CODPRE))<= '".$this->lonnivhas."' AND
            			RTRIM(B.CODPRE) >= RTRIM('".$this->codpredes."') AND
            			RTRIM(B.CODPRE) <= RTRIM('".$this->codprehas."') -- AND
            			--(B.ESTATUS = '".$tipopresup1."' OR
            			--B.ESTATUS = '".$tipopresup2."')
						ORDER BY A.CODPRE";
  //	$this->cab=new cabecera();
		//print $this->sql;
		//exit;
		}



 		function despuesParametro(){

  			$this->sql01 =  "SELECT SUM(COALESCE(LENGTH(RTRIM(NOMABR)), 0)) as LONNIVDES
    						FROM CPNIVELES WHERE CONSEC <= '".$this->nivdesde."'";
    		$tb01=$this->bd->select($this->sql01);
   			$this->lonnivdes=$tb01->fields["lonnivdes"]+($this->nivdesde-1);

  			$this->sql02= "SELECT SUM(COALESCE(LENGTH(RTRIM(NOMABR)), 0)) as LONNIVHAS
    					  FROM CPNIVELES WHERE CONSEC <= '".$this->nivhasta."'";
     		$tb02=$this->bd->select($this->sql02);
    		$this->sql02;
			$this->lonnivhas=$tb02->fields["lonnivhas"]+($this->nivhasta-1);
		}

		function antesreporte(){

			$this->sql3="select consec as consec,
					            lonniv as lonniv from cpniveles
  								where consec <= '".$this->nivhasta."' order by consec desc";
  			$tb3=$this->bd->select($this->sql3);

			$this->sql4="SELECT NOMEMP as EMPRESA FROM EMPRESA";
 			$tb4=$this->bd->select($this->sql4);


			$this->sql5="select sum(lonniv) as lenmascara from cpniveles
  						where consec<='".$this->nivhasta."'";

  			$tb5=$this->bd->select($this->sql5);
			$this->lenmascara= $tb5->fields["lenmascara"]+$this->nivhasta-1;

			$this->crearTablaTemporal();
			while(!$tb3->EOF)
			{
		 		$this->Temporal($this->lenmascara);
				$this->cont=$tb3->fields["lonniv"];

		 		if ($tb3->fields["consec"] <> 1) {
       				$this->lenmascara=($this->lenmascara-$this->cont-1);
		 		}
    	 		else{
       				$this->lenmascara=($this->lenmascara-$this->cont);
    			}
				$tb3->MoveNext();
    		}
		}


		function crearTablaTemporal(){
					$this->aleatorio=rand(1,1000);
			$this->sqlT2="CREATE TEMPORARY TABLE cpdisniv".$this->aleatorio." (codpre VARCHAR(32) NOT NULL,
  							monasi NUMERIC(14,2),
  							modificacion NUMERIC(20,2),
  							asigactual NUMERIC(20,2),
  							monprc NUMERIC(20,2),
  							moncom NUMERIC(14,2),
  							moncau NUMERIC(14,2),
  							monpag NUMERIC(14,2),
  							monaju NUMERIC(14,2),
  							mondis NUMERIC(14,2),
  							deuda NUMERIC(20,2)
						) WITHOUT OIDS";
				$tbT2=$this->bd->select($this->sqlT2);

		}

		function Temporal($mascara){
			$this->sqlT1="SELECT substr(A.codpre,1,".$mascara.") as codpre,
 					sum(A.MonAsi) as Monasi,
 					(sum(A.Montra)+sum(A.MonAdi)-sum(A.Montrn)-sum(A.MonDim)) as Modificacion,
 					(sum(A.MonAsi)+sum(A.Montra)+sum(A.MonAdi)-sum(A.Montrn)-sum(A.MonDim)) as AsigActual,
  					sum(A.MonPrc) as Monprc,
  					sum(A.MonCom) as moncom,
  					sum(A.MonDis) as mondis,
  					sum(A.MonCau) as moncau,
  					sum(A.MonPag) as monpag,
  					(sum(A.MonCau)-sum(A.MonPag)) as Deuda
					FROM CPASIINI A,
     					 CPDEFNIV B
					WHERE
   						B.CodEmp = '001' AND
   						A.PerPre >= '".$this->perdesde."' AND
   						A.PerPre <= '".$this->perhasta."' AND
   						A.AnoPre >= RTRIM(TO_CHAR(B.FecIni,'YYYY')) And
   						A.AnoPre <= RTRIM(TO_CHAR(B.FecCie,'YYYY')) And
   						RTRIM(A.codpre) >= '".$this->codpredes."' AND
   						RTRIM(A.codpre) <= '".$this->codprehas."' AND
   						substr(A.codpre,1,".$mascara.") LIKE substr(A.codpre,1,".$mascara.")||'%' AND
   						RTRIM(A.codpre) LIKE '".$this->filtro."'
   						group by substr(A.codpre,1,".$mascara.")";


   			$tbT1=$this->bd->select($this->sqlT1);

			while(!$tbT1->EOF){
				$this->sqlT3="insert into cpdisniv".$this->aleatorio." (codpre,monasi,modificacion,asigactual,monprc,moncom,moncau,monpag,mondis,deuda) values ('".$tbT1->fields["codpre"]."','".$tbT1->fields["monasi"]."','".$tbT1->fields["modificacion"]."','".$tbT1->fields["asigactual"]."','".$tbT1->fields["monprc"]."','".$tbT1->fields["moncom"]."','".$tbT1->fields["moncau"]."','".$tbT1->fields["monpag"]."','".$tbT1->fields["mondis"]."','".$tbT1->fields["deuda"]."')";
						$tbT3=$this->bd->select($this->sqlT3);
				$tbT1->MoveNext();
			} 
		} 

		function Header()
		{
     //Logo de la Empresa
     // $this->Image("../../img/logo_1.jpg",10,8,11);
$this->cab->poner_cabecera_f($this,'',$this->conf,"n","n");
      $this->ln(10);

		}

		function Cuerpo(){
			$this->ln(5);
			$this->sql03= "SELECT TO_CHAR(FECPER,'YYYY') as ANO  FROM CPDEFNIV";
			$tb03=$this->bd->select($this->sql03);
			$tb=$this->bd->select($this->sql);
			while(!$tb->EOF){
				$this->SetxY(15,55);
$this->multicell(180,4,"Asignados a este Órgano de Control los Créditos presupuestarios, mediante LEY DE PRESUPUESTO PARA EL EJERCICIO ECONÓMICO FINANCIERO AÑO ".$tb03->fields["ano"]." DE RNV,C.A, publicada en GACETA OFICIAL NÚMERO EXTRAORDINARIO: ".$this->gaceta." Y DE DECRETO N ° ".$this->decre.", y registrados los compromisos, certifico que existe a la fecha la siguiente disponibilidad presupuestaria : "
				);
				$this->SetY(75);
				$this->setFont("Arial","B",9);
				$this->SetTextColor(0,0,128);
				$this->cell(15,5,"Año",0,0,'R');
				$this->cell(15,5,$tb03->fields["ano"],0,0,'L');
				$this->cell(100,12,"CERTIFICACION PRESUPUESTARIA",0,0,'C');
				$this->ln(3);
				$this->cell(155,12,"(En Bolivares)",0,0,'C');
				$this->ln(1);
				$this->SetTextColor(0,0,0);
				$this->setx(135);
				$this->cell(35,5,"Periodo: 01/01/".$tb03->fields["ano"]." ". " AL ".$this->FecPerEje($this->perhasta)."   ",0,0,'l');
//				$this->FecPerEje($this->perdesde). " AL ".$this->FecPerEje($this->perhasta)."   ",0,0,'l');
				$this->ln();
				$this->SetX(135);
				$this->cell(35,5,"Fecha de Emisión ".date("d/m/Y")."   ",0,0,'l');
				$this->Line(15,75,192,75);
				$this->ln(10);
				$this->sql2= "SELECT SUM(MONASI) as MONTO FROM CPASIINI  WHERE CODPRE LIKE RTRIM('".$tb->fields["codpre"]."')||'%'AND
          PERPRE='00'";
         		$tb2=$this->bd->select($this->sql2);
				$y=$this->GetY();
				$this->setFont("Arial","B",7);
					$this->SetX(17);
				$this->cell(12,5,"Código  ");
				$this->setFont("Arial","",8);
				$this->cell(43,5,$tb->fields["codpre"]);
				$this->Multicell(60,5,$tb->fields["nompre"]);
				$y2=$this->GetY();
				$this->SetXY(135,$y);
				$this->setFont("Arial","B",8);
				$this->cell(27,5,"       Asignación Inicial: ",0,0,'R');
				$this->setFont("Arial","",8);

				$hasta="trim(to_char(to_number('".$this->perdesde."' ,'99')-1,'00'))";
			    $this->sqla11="select monasi-
			      (coalesce(obtener_ejecucion(codpre,'01',$hasta,anopre,'PRC'),0)+
			       coalesce(obtener_ejecucion(codpre,'01',$hasta,anopre,'TRN'),0)+
			       coalesce(obtener_ejecucion(codpre,'01',$hasta,anopre,'DIS'),0))+
			      (coalesce(obtener_ejecucion(codpre,'01',$hasta,anopre,'TRA'),0)+
			       coalesce(obtener_ejecucion(codpre,'01',$hasta,anopre,'ADI'),0)) as ASIGNA
			       from cpasiini where
			       CODPRE= ('".$tb->fields["codpre"]."' ) AND PERPRE='00' ";

			        $this->sqla="select monasi  as ASIGNA
			       from cpasiini where
			       CODPRE= ('".$tb->fields["codpre"]."' ) AND PERPRE='00' ";
			  //   print '<pre>'; print  $this->sqla;

			       	$tba=$this->bd->select($this->sqla);
			       	 	$tba1=$this->bd->select($this->sqla11);

				 if ($this->perdesde=='01'){
					if ($tb2->fields["monto"]<0){
						$this->cell(30,5,"(".number_format(-1*$tb2->fields["monto"],'2',',','.').")",0,0,'L');
					}else $this->cell(30,5,number_format($tb2->fields["monto"],'2',',','.'),0,0,'L');
				 }else
				 {
				 if ($tba->fields["asigna"]<0){
						$this->cell(30,5,"(".number_format(-1*$tba->fields["asigna"],'2',',','.').")",0,0,'L');
					}else $this->cell(30,5,number_format($tba->fields["asigna"],'2',',','.'),0,0,'L');
				 }
				$this->SetXY(10,$y2);
				$this->ln();

				$this->setFont("Arial","B",8);
	$this->SetX(23);
				$this->cell(35,5,"  Modificaciones: ");
				$this->setFont("Arial","",8);
				if ($tb->fields["modificacion"]<0){
					$this->cell(40,5,"(".number_format(-1*$tb->fields["modificacion"],'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($tb->fields["modificacion"],'2',',','.'),0,0,'R');
				$asigactual=$tb2->fields["monto"]+$tb->fields["modificacion"];
				$this->setFont("Arial","B",8);
				$this->cell(40,5,"     Asignación actual: ");
				$this->setFont("Arial","",8);
				if ($asigactual<0){
					$this->cell(40,5,"(".number_format(-1*$asigactual,'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($asigactual,'2',',','.'),0,0,'R');
				$this->ln();
				$this->setFont("Arial","B",8);
				$this->SetX(23);
				$this->cell(35,5,"  Precomprometido: ");
				$this->setFont("Arial","",8);
				if ($tb->fields["monprc"]<0){
					$this->cell(40,5,"(".number_format(-1*$tb->fields["monprc"],'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($tb->fields["monprc"],'2',',','.'),0,0,'R');
				$disponibilidad=$asigactual-$tb->fields["monprc"];
                //$disponibilidad=$tba1->fields["asigna"];
				$this->setFont("Arial","B",8);
				$this->cell(40,5,"     Disponibilidad: ");
				$this->setFont("Arial","",8);
				if ($disponibilidad<0){
					$this->cell(40,5,"(".number_format(-1*$disponibilidad	,'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($disponibilidad	,'2',',','.'),0,0,'R');
				$this->ln();
				$this->setFont("Arial","B",8);
				$this->SetX(23);
				$this->cell(35,5,"  Comprometido: ");
				$this->setFont("Arial","",8);
				if ($tb->fields["moncom"]<0){
					$this->cell(40,5,"(".number_format(-1*$tb->fields["moncom"],'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($tb->fields["moncom"],'2',',','.'),0,0,'R');
				$neta=$asigactual-$tb->fields["moncom"];
				$this->setFont("Arial","B",8);
				$this->cell(40,5,"     Saldo por Comprometer: ");
				$this->setFont("Arial","",8);
				if ($neta<0){
					$this->cell(40,5,"(".number_format(-1*$neta,'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($neta,'2',',','.'),0,0,'R');
				$this->ln();
				$this->setFont("Arial","B",8);
				$this->SetX(23);
				$this->cell(35,5,"  Causado: ");
				$this->setFont("Arial","",8);
				if ($tb->fields["moncau"]<0){
					$this->cell(40,5,"(".number_format(-1*$tb->fields["moncau"],'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($tb->fields["moncau"],'2',',','.'),0,0,'R');
				$saldoporcausar=$tb->fields["moncom"]-$tb->fields["moncau"];
				$this->setFont("Arial","B",8);
				$this->cell(40,5,"     Saldo por Causar: ");
				$this->setFont("Arial","",8);
				if ($saldoporcausar<0){
					$this->cell(40,5,"(".number_format(-1*$saldoporcausar,'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($saldoporcausar,'2',',','.'),0,0,'R');
				$this->ln();
				$this->setFont("Arial","B",8);
				$this->SetX(23);
				$this->cell(35,5,"  Pagado: ");
				$this->setFont("Arial","",8);
				if ($tb->fields["monpag"]<0){
					$this->cell(40,5,"(".number_format(-1*$tb->fields["monpag"].")",'2',',','.'),0,0,'R');
				}
				else $this->cell(40,5,number_format($tb->fields["monpag"],'2',',','.'),0,0,'R');
				$saldoporpagar=$tb->fields["moncau"]-$tb->fields["monpag"];
				$this->setFont("Arial","B",8);
				$this->cell(40,5,"     Saldo por Pagar: ");
				$this->setFont("Arial","",8);
				if ($saldoporpagar<0){
					$this->cell(40,5,"(".number_format(-1*$saldoporpagar,'2',',','.').")",0,0,'R');
				}
				else $this->cell(40,5,number_format($saldoporpagar,'2',',','.'),0,0,'R');
				$this->ln();
				$tb->MoveNext();
				$this->Line(15,75,15,$this->GetY());
				$this->Line(192,75,192,$this->GetY());
				$this->Line(15,$this->GetY(),192,$this->GetY());
				if (!$tb->EOF){
					 $this->sety(240);
            $this->SetWidths(array(100,100));
		    $this->SetAligns(array("C","C"));
		    $this->SetBorder(1);
            $this->ln();
			$this->Row(array("REVISADO","CONFORMADO"));
			// $this->ln();
			$this->setJump(8);
		    $this->Row(array($this->revisado,$this->conformado));
		    $this->setJump(2);
		     $this->setFont("Arial","B",7);
		     $this->Row(array("Analista de Presupuesto","Director de Planificación y Presupuesto"));
					$this->AddPage();

				}
			}
            $this->sety(240);
            $this->SetWidths(array(100,100));
		    $this->SetAligns(array("C","C"));
		    $this->SetBorder(1);
            $this->ln();
			$this->Row(array("REVISADO","CONFORMADO"));
			// $this->ln();
			$this->setJump(8);
		    $this->Row(array($this->revisado,$this->conformado));
		    $this->setJump(2);
		     $this->setFont("Arial","B",7);
		     $this->Row(array("Analista de Presupuesto","Director de Planificación y Presupuesto"));

			}
	}
?>
