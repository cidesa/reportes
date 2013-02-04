<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
   require_once("../../lib/modelo/sqls/facturacion/Fadtocte.class.php");
    //require_once("../../lib/general/mc_table.php");

  class pdfreporte extends fpdf
  {


    function pdfreporte()
    {
      $this->conf="p";
	  $this->fpdf($this->conf,"mm","Letter");

	  $this->arrp=array("no_vacio");
	  $this->cab=new cabecera();
	  $this->bd=new basedatosAdo();
      //CODIGO DE RECARGO
      $this->cod1=H::GetPost("coddes");
      $this->cod2=H::GetPost("codhas");

      $this->far= new Fadtocte();

      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[1]="TIPO DE CLIENTE";
        $this->titulos[2]="DESCRIPCIÓN TIPO DE CLIENTE";


  }




    function Header()
    {
         $this->setFont("Arial","B",9);
         $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"p","n");
         $this->setFont("Arial","B",9);
	     $this->Ln(3);
	     $this->SetWidths(array(40,140));
       	 $this->SetAligns(array("L","L"));
	     $this->RowM(array($this->titulos[1],$this->titulos[2]));
	     $this->ln(2);
	     $this->setX(20);
	     $this->SetWidths(array(40,80,30,30));
         $this->SetAligns(array("C","L","C","C"));
	     $this->RowM(array("CÓDIGO DESCUENTO","DESCRIPCIÓN","MONTO","TIPO"));
	     $this->line(10,$this->getY()+2,200,$this->getY()+2);
	     $this->ln(6);

    }

    function Cuerpo()
    {
   $registro=count($this->arrp);
   $reg = 1;
   foreach($this->arrp as $dato){

       $reg++;

	   $this->SetFont("Arial","B",9);
	   $this->SetWidths(array(40,140));
       $this->SetAligns(array("L","L"));
	   $this->RowM(array($dato["codtipcte"],$dato["nomtipcte"]));
	   $this->ln();

	   $this->arrdet=$this->far->sqldet($dato["codtipcte"]);
	   foreach($this->arrdet as $det){

	   	$this->SetFont("Arial","",8);
		$this->setX(20);
	   	$this->SetWidths(array(40,80,30,30));
       	$this->SetAligns(array("C","L","C","C"));
	   	$this->RowM(array($det["coddto"],$det["desdesc"],H::FormatoMonto($det["mondesc"])." % ",$det["tipdesc"]));

	   }
	   $this->ln();
	   $this->line(10,$this->getY(),200,$this->getY());
	   $this->ln();

	   $this->SetBorder(0);
	   $this->SetFillTable(0);
       $y = $this->GetY();
       if ($y >= 200)
       {

       	 $this->addpage();

       }
   }


    }
  }
?>
