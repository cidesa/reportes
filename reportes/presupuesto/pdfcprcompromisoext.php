<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
  require_once("../../lib/general/Herramientas.class.php");
  require_once("../../lib/modelo/sqls/presupuesto/Cprcompromisoext.class.php");

  class pdfreporte extends fpdf
  {
    var $indice=0;
    var $cuantos=0;
    var $bd;
    var $tb=array();
    var $arrp=array();
    var $arrp2=array();
    var $cuentas=array();
    var $titulos;
    var $titulos2;
    var $anchos;
    var $anchos2;
    var $campos;

    function pdfreporte()
    {
      $this->fpdf("p","mm","Letter");
      $this->compdes=str_replace('*',' ',H::GetPost("refcomdes"));
      $this->comphas=str_replace('*',' ',H::GetPost("refcomhas"));
      $this->codmondes=str_replace('*',' ',H::GetPost("codmondes"));
      $this->codmonhas=str_replace('*',' ',H::GetPost("codmonhas"));
      
        $this->anapre=str_replace('*',' ',H::GetPost("anapre"));
          $this->diradm=str_replace('*',' ',H::GetPost("diradm"));
            $this->dirgen=str_replace('*',' ',H::GetPost("dirgen"));
      $this->bd=new Cprcompromisoext();
      $this->arrp=$this->bd->sqlp($this->compdes,$this->comphas,$this->codmondes,$this->codmonhas);
      $this->tb=$this->arrp;
      $this->cuantos=count($this->tb);
      $this->SetAutoPageBreak(false);
    }

    function Header()
    {
      if(H::GetPost("titulo")!="")
      {
        $this->getCabecera(H::GetPost("titulo"),"");
      }
      else
      {
        $this->getCabecera(H::GetPost("Comprobante de Compromiso"),"");
      }
      $this->Rect(10,6,196,260);

    }
      function Cuerpo()
    {
     $ref="";
     $primera=true;
     $totcom=0;
     $ref2=$this->tb[0]["refcomext"];
       $this->entro=0;
     foreach( $this->arrp as $arrp){
     	if ($ref != $arrp["refcomext"]) {
             $ref= $arrp["refcomext"];
     		  if (!$primera){


     		  	    $this->SetFont("arial","",9);
		            $this->SetFillColor(200,200,200);
		            $this->SetY(160);
		            $this->Cell(146,5,"TOTAL AUTORIZACIÓN",1,0,'C',1);
		            $this->Cell(50,5,number_format($totcom,2,'.',','),1,0,'R');
		            $totcom=0;
                    $this->Ln();

                      //buscamos el codigo contable
                      $this->arrp2=$this->bd->sql_contabb($ref2);
                      $ref2=$arrp["refcomext"];    if ( $this->entro<>1){
                      $this->setWidths(array(25,121,50));
	                  $this->setaligns(array('L','L','R'));
                      $this->SetY(170);
                      $lineas=1;
                     foreach( $this->arrp2 as $arrp2){
                        if ($lineas<15)
                     	   $this->rowm(array($arrp2["codcta"],$arrp2["descta"],H::FormatoMonto($arrp2["totcta"])));//
                        $lineas=$lineas+1;

                     }
                         } $this->entro=0;
     		  	 $this->AddPage();
     		  }

     		  $primera=false;
		      $this->SetY(35);
		      $this->SetFont("arial","B",11);
		      $this->Cell(0,15,"AUTORIZACIÓN PRESUPUESTARIA",1,0,'C');
		      $this->SetFont("arial","B",9);
		      $this->Ln(18);
		      $this->Cell(10);
		      $this->Cell(88,4,"REFERENCIA: ".$arrp["refcomext"]."                   NRO. COMPROMISO: ".$arrp["refcom"],0,0,'L');
		      $this->Cell(88,4,"FECHA COMPROMISO: ".$arrp["feccom"],0,0,'R');
                      $this->Ln(7);
                      $this->Cell(10);
                      $this->Cell(88,4,"TIPO DE MONEDA: ".$arrp["nommon"],0,0,'L');
		      $this->Cell(88,4,"TASA DE CAMBIO: ".$arrp["valmon"],0,0,'R');
                      
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
		      $this->MultiCell(176,4,trim($arrp["descom"]));

		      $this->Ln(2);
		      $this->Line(10,$this->GetY(),206,$this->GetY());
		      $this->SetFillColor(200,200,200);
		      $this->Cell(146,5,"IMPUTACIÓN PRESUPUESTARIA",1,0,'C',1);
		      $this->Cell(50,10,"MONTO",1,0,'C');
		      $this->Ln(5);
		      $this->Cell(12,5,"AÑO",1,0,'C');
		      $this->SetFont("arial","",6);
		      $niveles=$this->bd->sql_cpniveles();
		      $ancho=60/count($niveles);
		      foreach($niveles as $regniv)
		      {
		        $this->Cell($ancho,5,$regniv["nomabr"],1,0,'C');
		      }
		      $this->multiCell(74,5,"DENOMINACIONES",1,'C',0);
		      $empieza=$this->GetY()+5;
		      $this->Line(156,$this->GetY(),156,231);

		      $this->SetFont("arial","B",9);
		      $this->SetY(165);
		      $this->Cell(146,5,"CÓDIGO CONTABLE",1,0,'C',1);
		      $this->Cell(50,5,"MONTO",1,0,'C');
$y=0;
    $this->SetFont("Arial","B",7);
    $this->Rect(10,$y+231,196,3);
    $this->SetXY(10,$y+231);
    $this->Cell(196,3,'FIRMAS Y SELLOS PARA LA APROBACIÓN',0,0,'C');

    $this->SetFont("arial","B",7);

    $this->Rect(10,$y+234,196,19);  $this->Ln(10);

                        $linea='_____________________';
		                $this->setWidths(array(61,61,61));
		                $this->setaligns(array('C','C','C'));
		                $this->rowm(array( $this->anapre,$this->diradm, $this->dirgen));
		                $this->rowm(array($linea,$linea,$linea));
                              $this->rowm(array("ANALISTA DE PRESUPUESTO","JEFE DE PRESUPUESTO","DIRECTOR DE PLANIFICACION Y PRESUPUESTO"));


		      $this->SetY($empieza);
     }//if

        $this->SetFont("arial","",8);
        $this->Cell(12,4,$arrp["anopre"],0,0,'C');
        $niveles=$this->bd->sql_cpniveles();
        $ancho=60/count($niveles);
        $i=0;
        $partecodpre=explode("-",trim($arrp["codpre"]));
        foreach($niveles as $regniv)
        {
          $this->Cell($ancho,5,$partecodpre[$i],0,0,'C');
          $i++;
        }
        $y=$this->getY();
        $this->multiCell(75,4,strtolower($arrp["nompre"]));
        $this->SetXY(156,$y);
        $this->Cell(50,8,number_format($arrp["monimp"],2,'.',','),0,0,'R');
        $totcom+=$arrp["monimp"];
        $this->Ln();

        if ($this->gety()>150) {
        $this->entro=1;
        	   //buscamos el codigo contable
		              $this->Ln();
                      $this->arrp2=$this->bd->sql_contabb($arrp["refcomext"]);
                      $this->setWidths(array(25,121,50));
	                  $this->setaligns(array('L','L','R'));
                      $this->SetY(170);
                      $lineas=1;
                     foreach( $this->arrp2 as $arrp2){
                        if ($lineas<15)
                     	   $this->rowm(array($arrp2["codcta"],$arrp2["descta"],H::FormatoMonto($arrp2["totcta"])));//
                        $lineas=$lineas+1;
                     	
                     }
        	$this->addpage();
        	 $this->SetY(35);
		      $this->SetFont("arial","B",11);
		      $this->Cell(0,15,"AUTORIZACIÓN PRESUPUESTARIA",1,0,'C');
		      $this->SetFont("arial","B",9);
		      $this->Ln(18);
		      $this->Cell(10);
		      $this->Cell(88,4,"No. COMPROMISO: ".$arrp["refcomext"],0,0,'L');
		      $this->Cell(88,4,"FECHA COMPROMISO: ".$arrp["feccom"],0,0,'R');
                      $this->Ln(7);
                      $this->Cell(10);
                      $this->Cell(88,4,"TIPO DE MONEDA: ".$arrp["nommon"],0,0,'L');
		      $this->Cell(88,4,"TASA DE CAMBIO: ".$arrp["valmon"],0,0,'R');
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
		      $this->MultiCell(176,4,trim($arrp["descom"]));
		      $this->Ln(2);
		      $this->Line(10,$this->GetY(),206,$this->GetY());
		      $this->SetFillColor(200,200,200);
		      $this->Cell(146,5,"IMPUTACIÓN PRESUPUESTARIA",1,0,'C',1);
		      $this->Cell(50,10,"MONTO",1,0,'C');
		      $this->Ln(5);
		      $this->Cell(12,5,"AÑO",1,0,'C');
		      $this->SetFont("arial","",6);
		      $niveles=$this->bd->sql_cpniveles();
		      $ancho=60/count($niveles);
		      foreach($niveles as $regniv)
		      {
		        $this->Cell($ancho,5,$regniv["nomabr"],1,0,'C');
		      }
		      $this->multiCell(74,5,"DENOMINACIONES",1,'C',0);
		      $empieza=$this->GetY()+5;
		      $this->Line(156,$this->GetY(),156,231);

		      $this->SetFont("arial","B",9);
		      $this->SetY(165);
		      $this->Cell(146,5,"CÓDIGO CONTABLE",1,0,'C',1);
		      $this->Cell(50,5,"MONTO",1,0,'C');
$y=0;
    $this->SetFont("Arial","B",7);
    $this->Rect(10,$y+231,196,3);
    $this->SetXY(10,$y+231);
    $this->Cell(196,3,'FIRMAS Y SELLOS PARA LA APROBACIÓN',0,0,'C');

    $this->SetFont("arial","B",7);

    $this->Rect(10,$y+234,196,19);  $this->Ln(10);

                        $linea='_____________________';
		                $this->setWidths(array(61,61,61));
		                $this->setaligns(array('C','C','C'));
		                $this->rowm(array( $this->anapre,$this->diradm, $this->dirgen));
		                $this->rowm(array($linea,$linea,$linea));
                     	$this->rowm(array("ANALISTA DE PRESUPUESTO","JEFE DE PRESUPUESTO","DIRECTOR DE PLANIFICACION Y PRESUPUESTO"));

		      $this->SetY($empieza);
        }// fin si es mayor a 160

     }//foreach
                    $this->SetFont("arial","",9);
		            $this->SetFillColor(200,200,200);
		            $this->SetY(160);
		            $this->Cell(146,5,"TOTAL AUTORIZACIÓN",1,0,'C',1);
		            $this->Cell(50,5,number_format($totcom,2,'.',','),1,0,'R');
		            $totcom=0;
		            //buscamos el codigo contable
		            if ( $this->entro<>'1'){
		              $this->Ln();
                      $this->arrp2=$this->bd->sql_contabb($arrp["refcomext"]);
                      $this->setWidths(array(25,121,50));
	                  $this->setaligns(array('L','L','R'));
                      $this->SetY(170);
                     $lineas=1;
                     foreach( $this->arrp2 as $arrp2){
                        if ($lineas<15)
                     	   $this->rowm(array($arrp2["codcta"],$arrp2["descta"],H::FormatoMonto($arrp2["totcta"])));//
                        $lineas=$lineas+1;
                     	
                     }
		            }//fin entro
     }//cuerpo

  }
?>
