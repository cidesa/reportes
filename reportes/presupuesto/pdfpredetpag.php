<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{
		var $bd;
		var $sql;
		var $titulos;
		var $refcaudesd;
		var $refcauhast;
		var $fecdes;
		var $fechast;
		var $tipocomdes;
		var $tipocomhas;
		var $status;
		var $codpredesde;
		var $codprehasta;
		var $comodin;
		var $monto;
		var $cedula;


		function pdfreporte()
		{
			$this->fpdf("l","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->arrp=array('no-vacio');
			//Recibir las variables por el Post
			$this->refcaudesd=H::GetPost("refcaudesd");
			$this->refcauhast=H::GetPost("refcauhast");
			$this->fecdes=H::GetPost("feccau1");
			$this->fechast=H::GetPost("feccau2");
			$this->tipocomdes=H::GetPost("tipocomdes");
			$this->tipocomhas=H::GetPost("tipocomhas");
			$this->status=H::GetPost("status");
			$this->codpredesde=H::GetPost("codpredesde");
			$this->codprehasta=H::GetPost("codprehasta");
			$this->comodin=H::GetPost("comodin");
			//$this->cab=new cabecera();
		//	print $this->status; exit;

			if(	$this->status=="A")
				{
				$this->esta="Activos";
				$t=" (A.STAPAG='".$this->status."' OR (A.STAPAG='N' AND A.FECANU>to_date('".$this->fechast."','dd/mm/yyyy'))) AND";
				}
			else if ($this->status=="N")
			{
				$this->esta="Anulados";
				$t=" A.STAPAG='".$this->status."'and A.FECANU <= to_date('".$this->fechast."','dd/mm/yyyy') AND ";
			}

			 $this->sql="select a.refpag,b.refere,
					a.tippag,
					to_char(a.fecpag,'dd/mm/yyyy')as fecpag,
					rtrim(a.despag) as descom,
					rtrim(b.codpre ) as codpre,
					rtrim(c.nompre) as nompre,
					b.monimp,
					b.monaju as ajuste,
					a.cedrif,
					(b.monimp-b.monaju) as mon_aju
					from
					cppagos a,
					cpimppag b,
					cpdeftit c
					where a.refpag = b.refpag and
								   b.codpre = c.codpre  and
								   a.refpag>='".$this->refcaudesd."'   and
								   a.refpag <='".$this->refcauhast."'  and
								   a.fecpag>=to_date('".$this->fecdes."','dd/mm/yyyy') and
								   a.fecpag<=to_date('".$this->fechast."','dd/mm/yyyy') and
								   b.codpre >=('".$this->codpredesde."') and
								   b.codpre <=('".$this->codprehasta."') and
								   a.tippag >= '".$this->tipocomdes."' and
								   a.tippag <= '".$this->tipocomhas."' and
									".$t."
								   (b.codpre like rtrim( '".$this->comodin."') )
					order by b.codpre,a.fecpag";

		//	print '<pre>';print $this->sql;exit;

			$this->llenartitulosmaestro();
			$this->cab=new cabecera();

		}
		function llenartitulosmaestro()
		{
				$this->titulos[0]="CODIGO PRESUPUESTARIO";
				$this->titulos[1]="DESCRIPCION";
				$this->titulos[2]="NRO";
				$this->titulos[6]="PAGADOS";
				$this->titulos[3]="NRO.ORDEN";
				$this->titulos[4]="FECHA";
				$this->titulos[5]="         MONTO";
		}

		function Header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo")." (".$this->esta.")","","s");

			$this->setFont("Arial","B",8);

			if ($this->status=='A')
			{
				$status="ACTIVO";
			}else{
				$status="NULO";
			}


			//$this->cell(80,6,"CONTABILIDAD PRESUPUESTARIA");
			$this->ln(3);
			$this->cell(80,6,"DEL  ".$this->fecdes."  HASTA  ".$this->fechast);
			$this->ln();
			$this->settextcolor(0,0,158);
			$this->cell(45,6,$this->titulos[0]);
			$this->cell(120,6,$this->titulos[1]);
			$this->cell(20,6,$this->titulos[2]);
			$this->cell(20,6,$this->titulos[3]);
			$this->cell(25,6,$this->titulos[4]);
			$this->cell(30,6,$this->titulos[5]);
			$this->ln(3);
			$this->cell(165,6," ");
			$this->cell(30,6,$this->titulos[6]);
			$this->ln();
			$this->settextcolor(0,0,0);
			$this->Line($this->GetX(),$this->GetY()+1,$this->GetX()+260,$this->GetY()+1);
			//$this->ln();


			//$this->cell(15,6,"NOMINA :");
			//$this->Line(10,55,200,55);

		}
		function Cuerpo()
		{
			//$this->setFont("Arial","B",8);
		    $tb=$this->bd->select($this->sql);
			$this->setFont("Arial","",8);
			$monto=0;
			while(!$tb->EOF)
			{
				$this->cell(55,6,$tb->fields["codpre"]);
				//$this->cell(110,6,substr($tb->fields["nompre"],0,68));
				$this->setx(175);
				$this->cell(20,6,$tb->fields["refpag"]);
				$this->cell(20,6,$tb->fields["refere"]);
				$this->cell(25,6,$tb->fields["fecpag"]);
			//	$monto+=$tb->fields["mon_aju"];
				$this->cell(25,6,H::FormatoMonto($tb->fields["mon_aju"]),0,0,'R');
				$monto=$monto+$tb->fields["mon_aju"];
				$this->ln(3);
				//$this->cell(50,6," ");
					$cedula=$tb->fields["cedrif"];
					$tb1=$this->bd->select("select cedrif, nomben from opbenefi where cedrif='$cedula'");
					//$this->cell(120,6,substr($tb1->fields["nomben"],0,68));
				$ben=$tb1->fields["nomben"];
				$this->setx(65);
				$this->multicell(100,3,strtoupper($tb->fields["nompre"])."    ".$ben);


				$this->ln();

				$tb->MoveNext();
			}
			$this->Line($this->GetX()+210,$this->GetY()+1,$this->GetX()+260,$this->GetY()+1);
			$this->cell(215,6," ");
			$this->cell(10,6,"Total  :  ");
			$this->cell(30,6,H::FormatoMonto($monto),0,0,'R');
	/*		while (!$tb->EOF)
			{
				if ($codban!=$tb->fields["codban"]){  //Por codigo del Banco
					if ($cont<>0){
						$this->ln(4);
						$this->cell(80,6,"TOTAL ".$nomban);
						$this->cell(72,6,"");
						$this->cell(35,6,H::FormatoMonto($sum_asig1),0,0,'R');    //Asignacion
						$this->cell(35,6,H::FormatoMonto($sum_deducc1),0,0,'R');  //Deducciones
						$this->cell(35,6,H::FormatoMonto($sum_total1),0,0,'R');   //Monto a Pagar
						$this->ln(4);
						$this->cell(80,6,"CANTIDAD DE TRABAJADORES : ".$cont3,0,0,'R');
						$cont3=0;
						$sum_asig1=0;
						$sum_deducc1=0;
						$sum_total1=0;
					    $this->AddPage();
						}

					$codban=$tb->fields["codban"];
					$nomban=trim($tb->fields["nomban"]);
					$this->cell(260,6,$nomban,0,0,'C');
					$this->ln(4);
					$this->setFont("Arial","B",7);
					$this->Line($this->GetX(),$this->GetY()+1,$this->GetX()+260,$this->GetY()+1);
					$this->cell(20,6,"Nomina: ".$this->codnom);
					$this->cell(30,6,"Empleado Administrativo ");
					$this->setFont("Arial","",7);
					$this->ln();
				}
					$cont=$cont+1; //Contador Total
					$cont2=$cont2+1; //Contador por Grupo
					$cont3=$cont3+1; //Contador por Banco
					$nomcat=$tb->fields["nomcat"];
					if ($codcat!=$tb->fields["codcat"]){
						$codcat=$tb->fields["codcat"];
							$cont2=1;
							$sum_asig=0;
							$sum_deducc=0;
							$sum_total=0;
							$this->ln(4);
							$this->Line($this->GetX(),$this->GetY()+1,$this->GetX()+260,$this->GetY()+1);
							$this->cell(20,6,$tb->fields["codcat"]);
							$this->cell(70,6,$tb->fields["nomcat"]);
							$this->ln();
							$this->setFont("Arial","B",7);
							$this->cell(12,6,$this->titulos[0]);
							$this->cell(40,6,$this->titulos[1]);
							$this->cell(50,6,$this->titulos[2]);
							$this->cell(30,6,$this->titulos[3]);
							$this->cell(20,6,$this->titulos[5]);
							$this->cell(35,6,$this->titulos[6],0,0,'R');
							$this->cell(35,6,$this->titulos[7],0,0,'R');
							$this->cell(35,6,$this->titulos[8],0,0,'R');
							$this->ln(4);
							$this->cell(118,6,$this->titulos[4],0,0,'R');
							$this->cell(140,6,$this->titulos[9],0,0,'R');
							$this->ln(4);
							$this->setFont("Arial","",7);
							$this->Line($this->GetX(),$this->GetY()+1,$this->GetX()+260,$this->GetY()+1);
					}

					$this->cell(12,6,$tb->fields["codemp"]);
					$this->cell(40,6,substr($tb->fields["nomemp"],0,25));
					$this->cell(50,6,substr($tb->fields["nomcar"],0,30));
					$this->cell(30,6,$tb->fields["numrec"]);
					$this->cell(20,6,$tb->fields["cuenta_banco"]);

					//Asignaciones
					$this->sql2="select coalesce(sum(a.saldo),0) as asigna from npnomcal a  where trim(a.codnom)='".trim($tb->fields["codnom"])."' and  trim(a.codemp)='".trim($tb->fields["idemp"])."'  and trim(a.codcar)='".trim($tb->fields["codcar"])."' and a.asided='A'";
					$tb2=$this->bd->select($this->sql2);
					$asigna=$tb2->fields["asigna"];
					$this->cell(35,6,H::FormatoMonto($tb2->fields["asigna"]),0,0,'R');

					//Deducciones
					$this->sql2="select coalesce(sum(a.saldo),0) as deducc from npnomcal a  where trim(a.codnom)='".trim($tb->fields["codnom"])."' and  trim(a.codemp)='".trim($tb->fields["idemp"])."'  and trim(a.codcar)='".trim($tb->fields["codcar"])."' and a.asided='D'";
					$tb2=$this->bd->select($this->sql2);
					$this->cell(35,6,H::FormatoMonto($tb2->fields["deducc"]),0,0,'R');

					//Monto a Pagar
					$this->cell(35,6,H::FormatoMonto(($asigna-$tb2->fields["deducc"])),0,0,'R');

					//Sumatorias Totales
					$sum_asig   = $sum_asig + $asigna;
					$sum_deducc = $sum_deducc + $tb2->fields["deducc"];
					$sum_total = $sum_total + ($asigna-$tb2->fields["deducc"]);

					$this->ln(4);

				$tb->MoveNext();

					//Totales por Grupo
					if ($codcat!=$tb->fields["codcat"]){
						$this->ln(3);
						$this->cell(80,6,"TOTAL ".$nomcat,0,0,'R');
						$this->cell(72,6,"");
						$this->cell(35,6,H::FormatoMonto($sum_asig),0,0,'R');    //Asignacion
						$this->cell(35,6,H::FormatoMonto($sum_deducc),0,0,'R');  //Deducciones
						$this->cell(35,6,H::FormatoMonto($sum_total),0,0,'R');   //Monto a Pagar
						$this->ln(4);
						$this->cell(80,6,"CANTIDAD DE TRABAJADORES : ".$cont2,0,0,'R');
						$this->ln(4);

						$sum_asig1   = $sum_asig1 + $sum_asig;
						$sum_deducc1 = $sum_deducc1 + $sum_asig;
						$sum_total1 = $sum_total1 + $sum_total;
					}
			}*/
		}
	}
?>