<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/presupuesto/PrePrc.class.php");

	class pdfreporte extends fpdf
	{
		var $titulos;
		var $titulos2;
		var $pre1;
	    var $pre2;
		var $fecprc1;
		var $fecprc2;
		var $tipprc1;
		var $tipprc2;
		var $combodes;
		var $codpre1;
		var $codpre2;

		function pdfreporte()
		{
                      $this->cab=new cabecera();
			$this->fpdf("l","mm","Letter");
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();

			// nro de compromiso
			$this->pre1=H::GetPost("pre1");
			$this->pre2=H::GetPost("pre2");
			// fecha del compromiso
			$this->fecprc1=H::GetPost("fecprc1");
			$this->fecprc2=H::GetPost("fecprc2");
			// tipo
			$this->tipprc1=H::GetPost("tipprc1");
			$this->tipprc2=H::GetPost("tipprc2");
			// combo
		    $this->combodes=H::GetPost("combodes");
			$this->combohas=H::GetPost("combohas");
			// codigo presupuestario
			$this->codpre1=H::GetPost("codpre1");
			$this->codpre2=H::GetPost("codpre2");
			//comodin
			$this->comodin=H::GetPost("comodin");
           if ($this->comodin=="")
		{
			 $this->comodin="%%";
		}

		   $this->PrePrc= new PrePrc();
		   $this->arrp=$this->PrePrc->sqlp($this->fecprc1,$this->fecprc2,$this->tipprc1,$this->tipprc2,$this->pre1,$this->pre2,$this->codpre1,$this->codpre2,$this->comodin,$this->combodes,$this->combohas);
		//  H::printR($this->arrp);
     		$this->llenartitulosmaestro();
			$this->llenartitulosmaestro2();
			$this->llenaranchos();
			$this->llenaranchos2();
	}

		function llenartitulosmaestro()
		{
				$this->titulos[0]="Referencia";
				$this->titulos[1]="Tipo";
				$this->titulos[2]="Fecha";
				$this->titulos[3]="Déscripción";
		}

		function llenartitulosmaestro2()
		{
				$this->titulos2[0]="Imputaciones Presupuestarias";
				$this->titulos2[1]="Precomprometido";
				$this->titulos2[2]="Ajustado";
				$this->titulos2[3]="Monto Ajustado";
				$this->titulos2[4]="Comprometido";
				$this->titulos2[5]="Causado";
				$this->titulos2[6]="Pagado";

		}
  function llenaranchos2()
	{
		$this->anchos2=array();
		$this->anchos2[0]=100;
		$this->anchos2[1]=25;
		$this->anchos2[2]=25;
		$this->anchos2[3]=25;
		$this->anchos2[4]=25;
		$this->anchos2[5]=25;
		$this->anchos2[6]=25;

	}
  function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=35;
		$this->anchos[1]=35;
		$this->anchos[2]=35;
		$this->anchos[3]=100;


	}


		function Header()
		{

			$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","s");
			$this->setFont("Arial","B",9);
			$ncampos=count($this->titulos);
			$ncampos2=count($this->titulos2);


			for($i=0;$i<= 5;$i++)
			{
				$this->cell($this->anchos[$i],10,$this->titulos[$i],0,0,'C');
			}
			$this->ln();
			for($i=0;$i<= 6;$i++)
			{
				$this->cell($this->anchos2[$i],10,$this->titulos2[$i],0,0,'C');
			}
			$this->ln();
			$this->ln();
			$this->Line(10,60,265,60);

		}

		function Cuerpo()
		{
			$ref="";
			$cont = 0;
			$acum_pre1=0;
			$acum_cau1=0;
			$acum_pag1=0;
			$acum_aju1=0;
			$acum_a1=0;
			$acum_com1=0;

			foreach($this->arrp as $dato)
			{
				$cont++;
				if($dato["referencia"]!=$ref)
				{
					if($cont ==1)
					{
						$this->referencia=$dato["referencia"];
						$this->descripcion=$dato["descripcion"];
						$this->tipo=$dato["tipo"];
						$this->fecha=$dato["fecha"];
						$acum_pre1=0;
						$acum_cau1=0;
						$acum_pag1=0;
						$acum_aju1=0;
						$acum_a1=0;
						$acum_com1=0;

				     	$this->setFont("Arial","B",7);
						$this->cell($this->anchos[0],4,$this->referencia);
						$this->cell($this->anchos[1],4,$this->tipo);
						$this->cell($this->anchos[2],4,$this->fecha);
						$this->multicell(120,4,$this->descripcion);
					}
					else
					{
						$this->setxy(10,$this->gety());
						$this->setFont("Arial","",7);
						$this->SetWidths(array(80,20,20,20,25,25,25,25,25));
						$this->SetAligns(array("R","R","R","R","R","R","R","R","R"));
						//$this->SetBorder(1);
						$this->Row(array("TOTAL ".$ref," ",H::FormatoMonto($acum_pre1),H::FormatoMonto($acum_cau1),H::FormatoMonto($acum_aju1),H::FormatoMonto($acum_a1),H::FormatoMonto($acum_pag1),H::FormatoMonto($acum_com1)));
						//$this->SetBorder(0);
						$this->SetFillTable(0);
						$this->ln(4);

						$this->referencia=$dato["referencia"];
						$this->descripcion=$dato["descripcion"];
						$this->tipo=$dato["tipo"];
						$this->fecha=$dato["fecha"];
						$acum_pre1=0;
						$acum_cau1=0;
						$acum_pag1=0;
						$acum_aju1=0;
						$acum_a1=0;
						$acum_com1=0;

				     	$this->setFont("Arial","B",7);
						$this->cell($this->anchos[0],4,$this->referencia);
						$this->cell($this->anchos[1],4,$this->tipo);
						$this->cell($this->anchos[2],4,$this->fecha);
						$this->multicell(120,4,$this->descripcion);
					}



				}
				$ref=$dato["referencia"];
				$this->codpre=$dato["codigo"];
				$this->nompre=$dato["nompre"];
				$this->imputado=$dato["imputado"];
				$this->comprometido=$dato["comprometido"];
				$this->causado=$dato["causado"];
				$this->pagado=$dato["pagado"];
				$this->ajuste=$dato["ajuste"];
				$this->mon_aju=$dato["mon_aju"];
					$this->setFont("Arial","",7);
					$this->cell($this->anchos2[0],4,$this->codpre);
					$this->setx(110);
					$this->cell(20,4,H::FormatoMonto($this->imputado),0,0,'R');
	                $this->cell(20,4,H::FormatoMonto($this->ajuste),0,0,'R');
					$this->cell(25,4,H::FormatoMonto($this->mon_aju),0,0,'R');
	                $this->cell(25,4,H::FormatoMonto($this->comprometido),0,0,'R');
	                $this->cell(25,4,H::FormatoMonto($this->causado),0,0,'R');
	                $this->cell(25,4,H::FormatoMonto($this->pagado),0,0,'R');
					$this->setx(55);
	                $this->multicell(55,4,$this->nompre);

	            $this->ln(5);
				//ACUMULADO PARA ESTE PRECOMPROMISO
				$acum_pre1=$acum_pre1 + $this->imputado;
				$acum_cau1=$acum_cau1 + $this->ajuste;
				$acum_pag1=$acum_pag1 + $this->mon_aju;
				$acum_aju1=$acum_aju1 + $this->comprometido;
				$acum_a1=$acum_a1 + $this->causado;
				$acum_com1=$acum_com1 + $this->pagado;

				$acum_pre=$acum_pre + $this->imputado;
				$acum_cau=$acum_cau + $this->ajuste;
				$acum_pag=$acum_pag + $this->mon_aju;
				$acum_aju=$acum_aju + $this->comprometido;
				$acum_a=$acum_a + $this->causado;
				$acum_com=$acum_com + $this->pagado;
			}
			$this->ln();
			$this->Line(10,$this->GetY(),265,$this->GetY());
			$this->ln();
			$this->setx(75);
			$this->setFont("Arial","B",7);
			$this->cell($this->anchos4[0]+10,8,'TOTALES.......... ');
			$this->setx(110);
					$this->cell(20,4,H::FormatoMonto($acum_pre),0,0,'R');
	                $this->cell(20,4,H::FormatoMonto($acum_cau),0,0,'R');
					$this->cell(25,4,H::FormatoMonto($acum_pag),0,0,'R');
	                $this->cell(25,4,H::FormatoMonto($acum_aju),0,0,'R');
	                $this->cell(25,4,H::FormatoMonto($acum_a),0,0,'R');
	                $this->cell(25,4,H::FormatoMonto($acum_com),0,0,'R');
			//---------------------------------------------------------------------
				unset($this->PrePrc);
		}
	}
?>