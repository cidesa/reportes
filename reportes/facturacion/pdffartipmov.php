<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Fartipmov.class.php");
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

      $this->far= new Fartipmov();
      $this->cab=new cabecera();
      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[0]="TIPOS DE MOVIMIENTO ";
        $this->titulos[1]="CÓDIGO";
        $this->titulos[2]="DESCRIPCIÓN";
        $this->titulos[3]="NOMBRE ABREVIADO";
        $this->titulos[4]="CODIGO DE CUENTA";
        $this->titulos[5]="TIPO DE MOV. DEBITO/CREDITO";
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
   $this->SetWidths(array(25,60,30,45,30));
   $this->SetAligns(array("C","L","C","C","C"));
   $this->RowM(array($this->titulos[1],$this->titulos[2],$this->titulos[3],$this->titulos[4],$this->titulos[5]));
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


	   $this->SetFont("Arial","",8);
	   $this->SetWidths(array(25,60,30,45,30));
	   $this->SetAligns(array("C","L","C","L","C"));
	   $this->RowM(array($dato["id"],$dato["desmov"],$dato["nomabr"],$dato["codcta"],$dato["debcre"]));
	   $this->SetBorder(1);
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
