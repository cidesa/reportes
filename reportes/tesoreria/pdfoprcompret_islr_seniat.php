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
		var $sqla;
		var $sqlx;
		var $sqlb;
		var $sqlc;
		var $sqld;
		var $sqlmes;
		var $sqldia;
		var $sql1;
		var $sql2;
		var $sql3;
		var $sql4;
		var $sql5;
		var $ag;
		var $rif;
		var $dire;
		var $orde;
		var $ben;
		var $corr;
		var $corre;
		var $cormanual;
		var $benalt;
		var $fechasys;
		var $correlativo;
		var $mes;
		var $ano;


		function pdfreporte()
		{
			$this->fpdf("l","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			//$this->ag=$_POST["ag"];
			//$this->rif=$_POST["rif"];
			//$this->dire=$_POST["dire"];
			$this->orde=$_POST["orde"];
			$this->ben=$_POST["ben"];
                        $pos = strpos($this->ben, "?");
                        if ($pos>1) {
                        $this->ben = substr($this->ben, 0,$pos);
                        }                             
			$this->responsable=$_POST["responsable"];
			$this->fechaentrega=$_POST["fechaentrega"];
			$this->feccomp=trim(H::GetPost("feccomp"));
			$this->numcomp=trim(H::GetPost("numcomp"));
			$this->corr=H::GetPost("corr");//1
			$this->actcor=H::GetPost("actcor");
			$this->cont=$_POST["cont"];
			$this->diradm=$_POST["diradm"];
			$this->benalt=$_POST["ben"];

			    $this->sqlempresa="SELECT nomemp as nomageret,diremp as dirageret,'G200040564' as rifageret from empresa";
                $datos=$this->bd->select($this->sqlempresa);
                $this->ag=$datos->fields["nomageret"];
                $this->rif=$datos->fields["rifageret"];
                $this->dire=$datos->fields["dirageret"];

                        $this->sql2 = "update opfactur set rifalt=(select max(cedrif) from opordpag where  numord='$this->orde')
                                        where numord='" . $this->orde . "' and (trim(rifalt)='' or rifalt is null)";
                        $this->bd->actualizar($this->sql2);
                        
				$this->sql="select a.numord,a.rifalt as cedrif,d.nomben,d.nitben, d.dirben, d.telben,to_char(b.fecemi,'dd/mm/yyyy') as fecemi,to_char(a.fecfac,'dd/mm/yyyy') as fecfac,a.numfac,to_char(b.fecpag,'dd/mm/yyyy') as fecpag,
							a.numctr,a.tiptra,a.facafe,b.monord, b.monord as monto,
							a.totfac,a.exeiva,a.basislr,a.porislr,a.basimp,a.monislr, b.numche, to_char(c.feclib,'dd/mm/yyyy') as feclib
	                        from opbenefi d,opfactur a,opordpag b  left outer join tsmovlib c on b.numche=c.reflib and c.numcom is not null
							where
                                                        a.rifalt=d.cedrif and
							a.numord='".$this->orde."' and
                                                        a.rifalt=(case when '".trim($this->ben)."'='' then b.cedrif else '$this->ben' end) and                
							a.numord=b.numord
							order by a.numord";
							//print '<pre>'; print $this->sql; exit;

			$this->cab=new cabecera();
			$this->SetAutoPageBreak(true,50);
            $this->tb=$this->bd->select($this->sql);
		}

function br()
		{

		if(empty($this->feccomp))
		{
			$this->fechasys=date('d/m/Y');
			$this->ano=date('Y');
			$this->mes=date('m');
		}else
		{
			$aux=split("/",$this->feccomp);
			$this->fechasys=$this->feccomp;
			$this->ano=$aux[2];
			$this->mes=$aux[1];
		}
//-----------------------------------------------------------------------------------------------------------------------//
		$this->sql1="select distinct a.comretislr,a.feccomretislr, to_char(a.feccomretislr,'dd/mm/yyyy') as feccomretc 
                    from opfactur a,opordpag b where a.numord=b.numord and a.numord='".$this->orde."' and a.rifalt=(case when '".trim($this->ben)."'='' then b.cedrif else '$this->ben' end)";
                
		$tb1=$this->bd->select($this->sql1);
		if ($tb1->fields["comretislr"]==NULL)
		{$comret=" ";}
		else
		{$comret=$tb1->fields["comretislr"];}
		$feccomret=$tb1->fields["feccomretislr"];
		$feccomretc=$tb1->fields["feccomretc"];

	//----GENERAR CORRELATIVO
		if (strtoupper($this->corr)=="N")//NO
		{
			if ($comret==" ")
			{
			if(empty($this->numcomp))
			{
				$this->sql3="select nextval('correlativo_islr') as correlativo";
				$tb3=$this->bd->select($this->sql3);
				$this->correlativo=$tb3->fields["correlativo"];
			}
			else
				$this->correlativo=$this->numcomp;

			$this->sql4="update opfactur set comretislr='".$this->correlativo."', feccomretislr=to_date('".$this->fechasys."','dd/mm/yyyy')
						where numord='".$this->orde."' and rifalt=(case when '".trim($this->ben)."'='' then (select cedrif from opordpag where numord='" . $this->orde . "') else '$this->ben' end)";
						$this->actualizo=true;

			$tb4=$this->bd->actualizar($this->sql4);
			}
			else
			{
				if(empty($this->numcomp))
				{
					$this->correlativo=$comret;
				}
				else
					$this->correlativo=$this->numcomp;

				if(empty($this->feccomp))
				{
					if ($feccomretc==NULL)
					{
						$feccomretc=" ";
					}
					if ($feccomretc<>" ")
					{
						$this->fechasys=$feccomretc;
						$aux=split("/",$this->fechasys);
						$this->ano=$aux[2];
						$this->mes=$aux[1];
					}
				}
				$this->sql4="update opfactur set comretislr='".$this->correlativo."', feccomretislr=to_date('".$this->fechasys."','dd/mm/yyyy')
						where numord='".$this->orde."' and rifalt=(case when '".trim($this->ben)."'='' then (select cedrif from opordpag where numord='" . $this->orde . "') else '$this->ben' end)";
						$this->actualizo=true;

				$tb4=$this->bd->actualizar($this->sql4);
			}
		}
		else
		{
		//SI
			if(empty($this->numcomp))
			{
				$this->sql3="select nextval('correlativo_islr') as correlativo";
				$tb3=$this->bd->select($this->sql3);
				$this->correlativo=$tb3->fields["correlativo"];
			}
			else
				$this->correlativo=$this->numcomp;



			$this->sql4="update opordpag set comretislr='".$this->correlativo."', feccomretislr=to_date('".$this->fechasys."','dd/mm/yyyy')
						where numord='".$this->orde."' and rifalt=(case when '".trim($this->ben)."'='' then (select cedrif from opordpag where numord='" . $this->orde . "') else '$this->ben' end)";
						$this->actualizo=true;
			$this->bd->actualizar($this->sql4);
		}
		$numcom=intval($this->numcomp)+1;
		if(strtoupper($this->actcor)=='S')
		{
			$this->bd->actualizar("ALTER SEQUENCE correlativo_islr
				    INCREMENT 1  MINVALUE 0
				    MAXVALUE 9999999999999999  RESTART $numcom
				    CACHE 1  NO CYCLE;
				    COMMIT;");
		}

		}

		function Footer()
		{
			$this->SetFont("Arial","B",9);
			$this->SetXY(15,180);
			$this->Line(15,$this->GetY(),115,$this->GetY());
			$this->MultiCell(100,5,$_POST["responsable"]."\nFirma y Sello \nAgente de Retención",0,'C');
			$this->SetXY(210-20,180);
			$this->cell(100,5,"Recibido por: _______________________________",0,'C');
			$this->ln();
			$this->SetX(227-20);
			$this->cell(100,5,"C.I: _______________________________",0,'C');
			$this->ln();
			$this->SetX(215-20);
			$this->cell(100,5,"        Fecha: _______________________________",0,'C');
			$this->ln();
			$this->SetX(215-20);
			$this->cell(100,5,"        Firma: _______________________________",0,'C');
		    $this->SetY(205);
		    $this->SetFont("Arial","",6);
			$this->cell(250,5,"ORIGINAL: PARA PROVEEDOR."."\n  COPIA: SOPORTE CONTABLE/ARCHIVO",0,0,'C');
		}

		function Header()
		{
			$this->cab->poner_cabecera($this,$_POST["titulo"],"l","s");
		    $x=$this->getX();
		    $y=$this->getY();
		    $this->SetFont("Arial","B",7);
			$this->setXY($x,$y);
			$this->br();
			$this->SetFillColor(190,190,190);
			$this->Rect(165,36,45,12,"DF");
			$this->Rect(225,36,45,12);
			$this->setFont("Arial","B",9);
			$this->ln(-1);
		    $this->cell(163,5,'');
			$this->setFont("Arial","",7);
			$this->cell(54,5,"Número Comprobante:");
			$this->cell(50,5,"Fecha:");
			$this->ln(11);
			$this->sqla="select nomemp from empresa where codemp='001'";
			$tba=$this->bd->select($this->sqla);
			$this->setFont("Arial","B",8);
			$this->cell(95,5,'');
			$this->setFont("Arial","B",8);
			$this->cell(50,5,"Datos del Agente de Retención");
			$this->ln();
			$this->Rect(10,$this->GetY(),145,8);
			$this->Rect(155,$this->GetY(),50,8);
			$this->Rect(210,$this->GetY(),60,13);
			$this->Rect(10,$this->GetY()+10,195,11);
			$this->ln(1);
			$this->cell(1,5,"");
			$this->cell(160,5,"Nombre:");
			$this->cell(150,5,"No. R.I.F.:                                        ");
			$this->ln(-1);
			$this->cell(218,5,"");
			$this->cell(20,5,"Periodo Fiscal");
			$this->ln(6);
			$this->cell(203,5,"");
			$this->cell(33,5,"Año:");
			$this->cell(20,5,"Mes:");
		    $this->ln(6);
			$this->cell(1,5,"");
			$this->cell(110,5,"Dirección:");
			$this->cell(60,5,"");
			$this->ln(10);
			$this->cell(99,5,"");
			$this->cell(50,5,"Datos del Contribuyente");
			$this->Rect(10,$this->GetY()+5,100,15);
			$this->Rect(120,$this->GetY()+5,85,15);
			//$this->Rect(210,$this->GetY()+5,60,15);
			$this->ln();
			$this->cell(2,5,"");
			$this->cell(110,5,"Nombre o Razon Social:");
			$this->cell(50,5,"RIF. del Sujeto Retenido:");

            $this->setX(210);
			//$this->cell(55,5,"Dirección: ");
			$this->ln(17);
			$this->Rect(10,$this->GetY()+5,260,10,"DF");
			$this->ln();
			$this->setFont("Arial","",7);
			//$this->Rect(10,$this->GetY(),260,14.8,"DF");
            $this->setFont("Arial","",7);
			$this->cell(20,10,"Fecha Ord. Pago ",1,0,"C");
			$this->cell(20,10,"Ord. Pago N°",1,0,"C");
			$this->cell(20,10,"Fecha de Factura",1,0,"C");
			$this->cell(20,10,"N° Factura",1,0,"C");
			$this->cell(20,10,"Fecha de Pago",1,0,"C");
			$this->cell(20,10,"N° de Cheque",1,0,"C");
			$this->cell(20,10,"%De Retención",1,0,"C");
			$this->cell(40,10,"Monto de la O.P ",1,0,"C");
			$this->cell(40,10,"Base Imponible",1,0,"C");
			$this->cell(40,10,"Monto Retenido",1,0,"C");
			$this->ln(10);
			$this->setFont("Arial","B",9);
			$this->ln(12);
			$this->ln(-80);
		 $this->setFont("Arial","B",9);
		 $this->cell(160,5,"");
		 $this->cell(65,5,$this->ano."  -  ".$this->mes."  -  ".str_pad($this->correlativo,8,"0",STR_PAD_LEFT));
	  	 $this->cell(20,5,$this->fechasys);
		 $this->setFont("Arial","",7);
		 $this->ln(11);
		 $this->cell(13,5,"");
		 $this->cell(130,3,strtoupper($this->ag),0,0,'');
		 $this->ln(2);
		 $this->setFont("Arial","",8);
		 $this->cell(160,5,"",0,0,'');
		 $this->cell(30,5,strtoupper($this->rif),0,0,'');
		 $this->ln(3);
		 $this->cell(212,5,"");
		 $este=explode("/",$this->fechaentrega);
		 $this->cell(34,3,$this->ano);
		 $this->cell(30,3,$this->mes);
		 $this->ln(7);
		 $this->setFont("Arial","",7);
		 $this->cell(16,5,"");
		 $this->cell(115,5,strtoupper($this->dire),0,0,'L');
		 $this->ln(17);

// if ($this->ben<>"")
//		 {
//		 	$pos=strpos($this->ben,"?");
//		 	$ben=substr($this->benalt,$pos+1,strlen($this->benalt));
//			$tira=substr($this->ben,0,$pos);
//			$this->sqlben="select c.nomben, c.nitben, c.dirben, c.telben  from opbenefi c where c.cedrif='".$tira."'";
//			$tbben=$this->bd->select($this->sqlben);
//             $ben=$tbben->fields["nomben"];
//		   	 $nit=$tbben->fields["nitben"];
//			 $dir=$tbben->fields["dirben"];
//			 $tel=$tbben->fields["telben"];
//			 	$this->cell(5,5,"");
//		$this->cell(119,5,strtoupper($ben));
//		$this->cell(50,5,strtoupper($tira));
//		$this->cell(50,5,strtoupper($nit));
//		$this->setX(210);
//		$this->multicell(60,3,$dir.' Tlf: '.$tel);
//		 }
// if ($this->ben=="")
//		 {
			 $ben=$this->tb->fields["nomben"];
			 $tira=$this->tb->fields["cedrif"];
			 $nit=$this->tb->fields["nitben"];
			 $dir=$this->tb->fields["dirben"];
			 $tel=$this->tb->fields["telben"];
		$this->cell(5,5,"");
		$this->cell(119,5,strtoupper($this->tb->fields["nomben"]));
		$this->cell(50,5,strtoupper($this->tb->fields["cedrif"]));
		$this->cell(50,5,strtoupper($this->tb->fields["nitben"]));
		$this->setX(210);
		//$this->multicell(60,3,$this->tb->fields["dirben"].' Tlf: '.$this->tb->fields["telben"]);
//		 }
		$this->ln(20.2);
		}
		function Cuerpo()
		{
		 $tb2=$this->tb;
		 $this->SetWidths(array(25,35,30,30,50,45,45));
     	 $this->SetAligns(array("C","C","C","C","C","C","C"));
     	 $this->Setborder(array(true));
		 $totfac=0;
		 $exeiva=0;
		 $basimp=0;
		 $moniva=0;
		 $monret=0;
		 $cont=0;
		while (!$this->tb->EOF)
		{
		//Detalle
		$this->setFont("Arial","",6);
		$ref=$this->tb->fields["numord"];
		$cont=$cont + 1;
		$this->setFont("Arial","",7);
		$this->ln(7.75);
    	$this->SetWidths(array(20,20,20,20,20,20,20,40,40,40));
		$this->SetBorder(true);
		$this->SetJump(5);
		$this->SetAligns(array("C","C","C","C","C","C","R","R","R","R"));
		$this->Row(array($this->tb->fields["fecemi"],$this->tb->fields["numord"],$this->tb->fields["fecfac"],$this->tb->fields["numfac"],$this->tb->fields["fecpag"],$this->tb->fields["numche"],number_format($this->tb->fields["porislr"],2,'.',','),number_format($this->tb->fields["monto"],2,'.',','),number_format($this->tb->fields["basislr"],2,'.',','),number_format($this->tb->fields["monislr"],2,'.',',')));
		$totfac=$totfac+$this->tb->fields["totfac"];
		$exeiva=$exeiva+$this->tb->fields["basislr"];
		$porislr=$porislr+$this->tb->fields["porislr"];
		$basimp=$basimp+$this->tb->fields["monislr"];
		if ($this->gety()>160){
			$this->addpage();
		}
		$this->tb->MoveNext();
		}
		$this->setFont("Arial","B",9);
		$this->ln(5);
		$this->setx(100);
		$this->cell(25,5,"Totales...");
		$this->ln(1.5);
		$this->ln(-1);
		$this->setx(150);
		$this->cell(40,5,H::FormatoMonto($totfac),1,0,"R");
		$this->cell(40,5,H::FormatoMonto($exeiva),1,0,"R");
		$this->cell(40,5,H::FormatoMonto($basimp),1,0,"R");
		$this->ln();


		}
	}
?>
