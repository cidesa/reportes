<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Faforsol.class.php");
    //require_once("../../lib/general/mc_table.php");

  class pdfreporte extends fpdf
  {

//DECLARACION DE VARIABLES GLOBALES AQUI

    function pdfreporte()
    {
      $this->fpdf("p","mm","Letter");
      //CODIGO DE RECARGO
      $this->cod1=H::GetPost("coddes");
      $this->cod2=H::GetPost("codhas");

      $this->far= new Farfarsol();
      $this->cab=new cabecera();
      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[0]="FORMAS DE SOLICITUD ";
        $this->titulos[1]="CÓDIGO SOLICITUD";
        $this->titulos[2]="DESCRIPCIÓN SOLICITUD";
  }




    function Header()
    {
     $this->setFont("Arial","B",9);
      $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"p","n");
      $this->setFont("Arial","",9);
	  $this->Ln(5);


    }

    function Cuerpo()
    {



   $this->SetFont("Arial","B",8);
   $this->SetWidths(array(50,140));
   $this->SetAligns(array("C","L"));
   $this->RowM(array($this->titulos[1],$this->titulos[2]));
   $this->line(10,$this->getY(),200,$this->getY());
   $this->ln();
   $this->SetBorder(0);
   $this->SetFillTable(0);
   //$this->ln();
   //VIENEN LOS DATOS
   $registro=count($this->arrp);
   $reg = 1;
   foreach($this->arrp as $dato){

       $reg++;
       $y = $this->getY();

	   $this->SetFont("Arial","",8);
	   $this->SetWidths(array(50,140));
       $this->SetAligns(array("C","L"));
	   //$mensual = $dato["monanoact"]/12;
	  // print $mensual;exit;
	   $this->RowM(array($dato["id"],$dato["nombre"]));
	   $this->SetBorder(0);
	   $this->SetFillTable(0);
       //$acummes = $acummes + $mensual;
       $y = $this->GetY();
       //print $y;
       if ($y >= 200)
       {

       	 $this->addpage();

       }
   }
   /*if ($reg<=$registro)
		        {
		        	//$this->ln(30);
		        	$this->addpage();
		       }*/



    }
  }
?>
