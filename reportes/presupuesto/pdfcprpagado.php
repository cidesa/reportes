<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
  require_once("../../lib/general/Herramientas.class.php");
  require_once("../../lib/modelo/sqls/presupuesto/Cprpagado.class.php");

  class pdfreporte extends fpdf
  {

    var $indice=0;
    var $cuantos=0;
    var $bd;
    var $tb=array();
    var $arrp=array();
    var $cuentas=array();
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
    var $compdes;
    var $comphas;
    var $fecpag1;
    var $fecpag2;
    var $tippag1;
    var $tippag2;
    var $stacom;
    var $codpre1;
    var $codpre2;
    var $comodin;
    var $posx;
    var $posy;
    var $elaborador;

    function pdfreporte()
    {
      $this->fpdf("p","mm","Letter");
      $this->pagdes=str_replace('*',' ',H::GetPost("refpagdes"));
      $this->paghas=str_replace('*',' ',H::GetPost("refpaghas"));
      $this->bd=new Cprpagado();
      $this->arrp=$this->bd->sqlp($this->pagdes,$this->paghas);
      $this->tb=$this->arrp;
      $this->cuantos=count($this->tb);
      $this->SetAutoPageBreak(false);
    }


   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     function Header()
    {
      if(H::GetPost("titulo")!="")
      {
        $this->getCabecera(H::GetPost("titulo"),"");
      }
      else
      {
        $this->getCabecera(H::GetPost("Comprobante de Pagado"),"");
      }
      $this->Rect(10,6,196,260);

    }
      function Cuerpo()
    {
     $ref="";
     $primera=true;
     $totpag=0;
     $ref2=$this->tb[0]["refpag"];
     foreach( $this->arrp as $arrp){
     	if ($ref != $arrp["refpag"]) {
             $ref= $arrp["refpag"];
     		  if (!$primera){

     		  	    $this->SetFont("arial","",9);
		            $this->SetFillColor(200,200,200);
		            $this->SetY(160);
		            $this->Cell(146,5,"TOTAL AUTORIZACIÓN",1,0,'C',1);
		            $this->Cell(50,5,number_format($totpag,2,'.',','),1,0,'R');
		            $totpag=0;
                    $this->Ln();
                      //buscamos el codigo contable
                      $this->arrp2=$this->bd->sql_contabb($ref2);
                      $ref2=$arrp["refpag"];
                      $this->setWidths(array(25,121,50));
	                  $this->setaligns(array('L','L','R'));
                      $this->SetY(170);
                     foreach( $this->arrp2 as $arrp2){
                     	$this->rowm(array($arrp2["codcta"],$arrp2["descta"],H::FormatoMonto($arrp2["totcta"])));//
                     }

     		  	 $this->AddPage();
     		  }

     		  $primera=false;
		      $this->SetY(35);
		      $this->SetFont("arial","B",11);
		      $this->Cell(0,15,"AUTORIZACIÓN PRESUPUESTARIA",1,0,'C');
		      $this->SetFont("arial","B",9);
		      $this->Ln(18);
		      $this->Cell(10);
		      $this->Cell(88,4,"No. Pagado: ".$arrp["refpag"],0,0,'L');
		      $this->Cell(88,4,"FECHA Pagado: ".$arrp["fecpag"],0,0,'R');
		      $this->Ln(9);
		      $this->Line(10,$this->GetY()-1,206,$this->GetY()-1);
		      $this->Cell(100,4,"BENEFICIARIO: ".$arrp["cedrif"]);
		      $this->Ln(6);
		      $this->Cell(10);
		      $this->MultiCell(176,4,$arrp["nomben"],0,'C');
		      $this->Ln(2);
		      $this->Line(10,$this->GetY()-1,206,$this->GetY()-1);
		      $this->Cell(30,4,"CONCEPTO:");
		      $this->Ln(5);
		      $this->Cell(10);
		      $this->MultiCell(176,4,trim($arrp["despag"]));

		      $this->Ln(2);
		      $this->Line(10,$this->GetY(),206,$this->GetY());
		      $this->SetFillColor(200,200,200);
		      $this->Cell(146,5,"IMPUTACIÓN PRESUPUESTARIA",1,0,'C',1);
		      $this->Cell(50,10,"MONTO",1,0,'C');
		      $this->Ln(5);
		      $this->Cell(12,5,"AÑO",1,0,'C');
		      $this->SetFont("arial","",6);
		      $niveles=$this->bd->sql_cpniveles();
		      $ancho=134/count($niveles);
		      foreach($niveles as $regniv)
		      {
		        $this->Cell($ancho,5,$regniv["nomabr"],1,0,'C');
		      }
		      $empieza=$this->GetY()+5;
		      $this->Line(156,$this->GetY(),156,241);

		      $this->SetFont("arial","B",9);
		      $this->SetY(165);
		      $this->Cell(146,5,"CÓDIGO CONTABLE",1,0,'C',1);
		      $this->Cell(50,5,"MONTO",1,0,'C');

		      $empresa = H::getEmpresa();

		      $info = array();

		      $info['Director(a) de Planificación y PPTO'] = $empresa['dirfin'];

		      $this->getFirmas(1,$info,10);

		      $this->SetY($empieza);
     }//if

        $this->SetFont("arial","",8);
        $this->Cell(12,4,$arrp["anopre"],0,0,'C');
        $niveles=$this->bd->sql_cpniveles();
        $ancho=134/count($niveles);
        $i=0;
        $partecodpre=explode("-",trim($arrp["codpre"]));
        foreach($niveles as $regniv)
        {
          $this->Cell($ancho,5,$partecodpre[$i],0,0,'C');
          $i++;
        }

        $this->Cell(50,8,number_format($arrp["monimp"],2,'.',','),0,0,'R');
        $totpag+=$arrp["monimp"];
        $this->Ln(4);
        $this->SetX(10);
        $this->multiCell(146,4,strtolower($arrp["nompre"]));
        $this->Ln();

     }//foreach
                    $this->SetFont("arial","",9);
		            $this->SetFillColor(200,200,200);
		            $this->SetY(160);
		            $this->Cell(146,5,"TOTAL AUTORIZACIÓN",1,0,'C',1);
		            $this->Cell(50,5,number_format($totpag,2,'.',','),1,0,'R');
		            $totpag=0;
		            //buscamos el codigo contable
		              $this->Ln();
                      $this->arrp2=$this->bd->sql_contabb($arrp["refpag"]);
                      $this->setWidths(array(30,116,50));
	                  $this->setaligns(array('L','L','R'));
                      $this->SetY(170);
                     foreach( $this->arrp2 as $arrp2){
                     	$this->rowm(array($arrp2["codcta"],$arrp2["descta"],H::FormatoMonto($arrp2["totcta"])));//
                     }
     }//cuerpo
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  }
?>