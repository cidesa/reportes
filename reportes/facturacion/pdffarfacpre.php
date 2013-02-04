<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
  require_once("../../lib/general/funciones.php");
  require_once("../../lib/general/Herramientas.class.php");
  require_once("../../lib/modelo/sqls/facturacion/Farfacpre.class.php");


  class pdfreporte extends FPDF
  {

    var $i=0;
    var $bd;
    var $arrp=array();
    var $cab;
    var $titulo;
    var $coddes;
    var $codhas;
    var $codfacdes;
    var $codfachas;
    var $codartdes;
    var $codarthas;
    var $fecdes;
    var $fechas;
    var $subtotal2;

    function pdfreporte()
    {
      $this->conf="p";
      $this->fpdf($this->conf,"mm","Letter");
      $this->coddes=str_replace('*',' ',H::GetPost("coddes"));
      $this->codhas=str_replace('*',' ',H::GetPost("codhas"));
      $this->codfacdes=str_replace('*',' ',H::GetPost("codfacdes"));
      $this->codfachas=str_replace('*',' ',H::GetPost("codfachas"));
      $this->codartdes=str_replace('*',' ',H::GetPost("codartdes"));
      $this->codarthas=str_replace('*',' ',H::GetPost("codarthas"));
      $this->fecdes=str_replace('*',' ',H::GetPost("fecdes"));
      $this->fechas=str_replace('*',' ',H::GetPost("fechas"));

      $this->bd = new Farfacpre();
      $this->arrp = $this->bd->sqlp($this->coddes,$this->codhas,$this->codfacdes,$this->codfachas,$this->codartdes,$this->codarthas,$this->fecdes,$this->fechas);
    }


    function Header()
    {

      $this->SetAutoPageBreak(true,0.5);
      $this->SetFont("Arial","B",9);
      $this->formato();
      if ($this->arrp[$this->i]["status"]=='Anulado')
      {
        $this->SetLineWidth(1);
        $this->SetDrawColor(100,1,1);
        $this->SetFont("Arial","B",84);
        $this->SetTextColor(100,1,1);
        //$this->SetAlpha(0.5);
        $this->Rotate(45,40,160);
        $this->RoundedRect(40, 160, 150, 25, 2.5, 'D');
        $this->Text(42,183,'ANULADA');
        $this->Rotate(0);
        $this->SetDrawColor(0);
        $this->SetTextColor(0);
        //$this->SetAlpha(1);
        $this->SetLineWidth(0);
      }

      /////////////////////////////////////////

      //$this->SetXY(180,15);
       $this->SetXY(10,217);
      $this->SetFont("Arial","",8);
      $this->Cell(20,2,'FAC: '.$this->arrp[$this->i]["reffac"]);
      $this->SetFont("Arial","B",11);
	  $dia= substr($this->arrp[$this->i]["fecfac"],0,2);
	  $mes= substr($this->arrp[$this->i]["fecfac"],3,2);
      $ano= substr($this->arrp[$this->i]["fecfac"],6,4);
	  $this->SetFont("Arial","",8);
	  $this->SetXY(42,53);
	  $this->Cell(5,3,$dia);
	  $this->Cell(5,3,'');
	  $this->Cell(5,3,$mes);
	  $this->Cell(5,3,'');
	  $this->Cell(5,3,$ano);

      $this->SetFont("Arial","",8);
      $this->SetXY(50,68);
      $this->MultiCell(100,3,$this->arrp[$this->i]["nomcli"]);
      $this->SetXY(170,68);
      $this->Cell(100,3,$this->arrp[$this->i]["codcli"]);
	  $this->SetFont("Arial","",7);
      $this->SetXY(40,75);
      $this->Cell(12,3,$this->arrp[$this->i]["dircli"]);
      $this->SetFont("Arial","",8);
	  $this->SetXY(26,90);
      $this->Cell(160,3,$this->arrp[$this->i]["telcli"]);
	  $this->SetXY(162,90);
      $this->Cell(12,3,$this->arrp[$this->i]["desconpag"]);
       $this->SetXY(100,90);
      $this->Cell(12,3,$this->arrp[$this->i]["nronot"]);


    }


    function formato()
    {
      $this->Rect(10,47,65,10);
	  $this->line(10,52,75,52);//LINEAS HORIZONTALES
	  $this->SetFont("Arial","B",8);
	  $this->SetXY(10,48);
	  $this->Cell(30,4,'FECHA DE EMISION: ',0,0,'L');
	  $this->Cell(10,4,'DIA ',0,0,'C');
	  $this->line(40,47,40,57);//LINEAS VERTICALES
	  $this->line(50,47,50,57);
	  $this->Cell(12,4,'MES ',0,0,'C');
	  $this->line(60,47,60,57);//LINEAS VERTICALES
	  $this->Cell(10,4,'ANO ',0,0,'C');
	  $this->SetFont("Arial","",8);
	  $this->SetXY(10,53);
	  $this->Cell(10,3,'EN: ',0,0,'L');
	  $this->Cell(30,3,'CARACAS',0,0,'L');
	  $this->line(18,57,18,52);//LINEAS VERTICALES

	  $this->Rect(10,67,190,28);
	  $this->line(10,74,200,74);//LINEAS HORIZONTALES
	  $this->line(10,88,200,88);
	  $this->line(10,81,200,81);

	  $this->SetFont("Arial","",8);
	  $this->SetXY(10,68);
	  $this->Cell(30,4,'NOMBRE O RAZON SOCIAL: ',0,0,'L');
	  $this->SetX(150);
	  $this->Cell(30,4,'Nro DE RIF: ',0,0,'L');
	  $this->SetXY(10,75);
	  $this->Cell(30,4,'DOMICILIO FISCAL: ',0,0,'L');
	  $this->SetFont("Arial","B",8);
	  $this->SetXY(8,82);
	  $this->Cell(60,4,'TELEFONOS ',0,0,'C');
	  $this->Cell(7,4,'',0,0,'C');
	  $this->Cell(67,4,'ORDEN DE ENTREGA/GUIA DESPACHO ',0,0,'C');
	  $this->Cell(65,4,'CONDICIONES DE PAGO',0,0,'C');

	  $this->line(150,67,150,73);//LINEAS VERTICALES
	  $this->line(40,74,40,81);
	  $this->line(150,81,150,94);
	  $this->line(70,81,70,94);

	  $this->Rect(10,100,190,115);
      $this->line(10,109,200,109);//LINEAS HORIZONTALES
	  $this->line(25,100,25,215);//LINEAS VERTICALES
	  $this->line(150,100,150,215);
	  $this->line(175,100,175,215);

	  $this->SetXY(15,105);
	  $this->Cell(5,4,'CANT.',0,0,'C');
	  $this->SetX(55);
	  $this->Cell(60,4,'DESCRIPCION ',0,0,'C');
	  $this->SetXY(147,101);
	  $this->Cell(30,3,'PRECIO ',0,0,'C');
	  $this->SetXY(147,105);
	  $this->Cell(30,3,'UNITARIO ',0,0,'C');
	  $this->SetXY(172,105);
	  $this->Cell(30,4,'TOTAL ',0,0,'C');

	  $this->SetXY(145,215);
	  $this->Cell(30,4,'SUB-TOTAL',0,0,'R');
	  $this->ln();
	  $this->SetX(145);
	  $this->Cell(30,4,'MONTO EXENTO',0,0,'R');
	  $this->ln();
	  $this->SetX(145);
	  $this->Cell(30,4,'MONTO GRAVADO',0,0,'R');
	  $this->ln();
	  $this->SetX(145);
	  $this->Cell(30,4,'IVA 12%',0,0,'R');
	  $this->ln();
	  $this->SetX(145);
	  $this->Cell(30,4,'TOTAL NETO Bs.',0,0,'R');
	  $this->line(15,229,55,229);//LINEAS HORIZONTALES
	  $this->SetXY(20,230);
	  $this->Cell(30,4,'RECIBI CONFORME:',0,0,'R');
    }

    function Cuerpo()
    {
      $eof=count($this->arrp);
      $ref=$this->arrp[$this->i]["reffac"];
      $contador=1;
      $primeravez=true;
      $subtotal=0;
      $subtotal2=0;
      $iva=0;
      $total=0;
     // $fecha=explode("/",$this->arrp[$this->i]["fecord"]);
	  $x=$this->GetX();
      $y=$this->GetY();

		 $this->SetXY(11,110);
     while($this->i < $eof and $ref==$this->arrp[$this->i]["reffac"])
      {

          $this->SetFont("Arial","",8);
          $this->SetWidths(array(15,118,25,30));
          $this->SetAligns(array('C','J','R','R'));
          $paginaantes=$this->PageNo();
          $this->Row(array($this->arrp[$this->i]["cantot"],($this->arrp[$this->i]["desart"]),H::FormatoMonto($this->arrp[$this->i]["precio"]),H::FormatoMonto(($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["precio"]))));
          $subtotal+=($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["precio"]);
          $subtotal2+=$this->arrp[$this->i]["monrgo"];
          $monfact=$this->arrp[$this->i]["monfac"];
          $mondes+=$this->arrp[$this->i]["mondesc"];
          $monexo+=$this->arrp[$this->i]["monext"];


      if ($this->GetY()>205){
      	 $this->AddPage();
         $this->SetXY(11,100);

      }

        $this->i++;
        $contador++;

        if ($ref!=$this->arrp[$this->i]["reffac"] and $this->i !=$eof){
        	 $this->SetXY(170,215);
	  $this->Cell(30,4,H::FormatoMonto($subtotal),0,0,'R');
	  $this->ln();
	  $this->SetX(170);
	  $this->Cell(30,4,H::FormatoMonto($monexo),0,0,'R');
	 /* $this->ln();
	  $this->SetX(170);
	  $this->Cell(30,4,H::FormatoMonto($mondes),0,0,'R');*/
	  $this->ln();
	  $this->SetX(170);
	  $this->Cell(30,4,H::FormatoMonto($subtotal-$monexo-$mondes),0,0,'R');
	  $this->ln();
	  $this->SetX(170);
	  $this->Cell(30,4,H::FormatoMonto($subtotal2),0,0,'R');
	  $this->ln();
	  $this->SetX(170);
	   $this->Cell(30,4,H::FormatoMonto(($subtotal-$monexo)+$subtotal2),0,0,'R');

	      $subtotal=0;
          $subtotal2=0;
          $monfact=0;
          $monexo=0;

          $this->AddPage();
          $this->SetXY(11,100);
        }
 $ref=$this->arrp[$this->i]["reffac"];

   }//fin de while grande
      $this->SetXY(170,215);
	  $this->Cell(30,4,H::FormatoMonto($subtotal),0,0,'R');
	  $this->ln();
	  $this->SetX(170);
	  $this->Cell(30,4,H::FormatoMonto($monexo),0,0,'R');
	  $this->ln();
	  $this->SetX(170);
	   $this->Cell(30,4,H::FormatoMonto($subtotal-$monexo-$mondes),0,0,'R');
	  $this->ln();
	  $this->SetX(170);
	  $this->Cell(30,4,H::FormatoMonto($subtotal2),0,0,'R');
	  $this->ln();
	  $this->SetX(170);
	  $this->Cell(30,4,H::FormatoMonto($subtotal+$subtotal2),0,0,'R');

      //$this->Cell(30,4,H::FormatoMonto(($subtotal-$monexo)+$subtotal2),0,0,'R')
          $subtotal=0;
          $subtotal2=0;
          $monfact=0;
          $monexo=0;

    }
  }
?>
