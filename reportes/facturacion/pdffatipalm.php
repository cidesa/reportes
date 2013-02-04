<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
  require_once("../../lib/general/Herramientas.class.php");
  require_once("../../lib/modelo/sqls/facturacion/Fatipalm.class.php");


  class pdfreporte extends fpdf
  {

//DECLARACION DE VARIABLES GLOBALES AQUI

    function pdfreporte()
    {
      $this->fpdf("p","mm","Letter");
      //CODIGO DE RECARGO
      $this->cod1=H::GetPost("coddes");
      $this->cod2=H::GetPost("codhas");

      $this->far= new Fatipalm();
      $this->cab=new cabecera();
      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[0]="NOMBRE DEL ALMACEN ";
        $this->titulos[1]="CÓDIGO";
  }

    function Header()
    {
      $this->setFont("Arial","B",9);
      $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
      $this->setFont("Arial","",9);

    }

    function Cuerpo()
    {

   $y = $this->getY();
   $this->setXY(10,$y);

   $this->SetFont("Arial","B",10);
   $this->SetWidths(array(50,140));
   $this->SetAligns(array("C","C"));
   $this->SetBorder(1);
   $this->RowM(array($this->titulos[1],$this->titulos[0]));
   //$this->ln();
   //VIENEN LOS DATOS
   $registro=count($this->arrp);
   $reg = 1;
   foreach($this->arrp as $dato){

       $reg++;
       $y = $this->getY();
	   $this->setXY(10,$y);

	   $this->SetFont("Arial","",8);
	   $this->SetWidths(array(50,140));
       $this->SetAligns(array("C","L"));
	   $this->SetBorder(1);
	   $this->RowM(array($dato["codigo"],$dato["nombre"]));
       $y = $this->GetY();
       if ($y >= 200)
       {
       	 $this->addpage();

       }
   }

    }
  }
?>