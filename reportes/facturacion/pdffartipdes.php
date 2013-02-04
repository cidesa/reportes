<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Fartipdes.class.php");
    //require_once("../../lib/general/mc_table.php");

  class pdfreporte extends fpdf
  {

//DECLARACION DE VARIABLES GLOBALES AQUI

    function pdfreporte()
    {
            $this->conf="p";
			$this->fpdf($this->conf,"mm","Letter");

	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
      //CODIGO TIPO DE despacho
      $this->cod1=H::GetPost("coddes");
      $this->cod2=H::GetPost("codhas");

      $this->far= new Fartipdes();
      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[0]="LISTADO DE TIPOS DE DESPACHO ";
        $this->titulos[1]="CÓDIGO";
        $this->titulos[2]="DESCRIPCIÓN";

  }
    function Header()
    {
         $this->setFont("Arial","B",9);
         $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
         $this->setFont("Arial","",9);
    }

    function Cuerpo()
    {
   $this->SetFont("Arial","B",9);
   $this->SetWidths(array(90,90));
   $this->SetAligns(array("C","C"));
   $this->SetBorder(0);
   $this->RowM(array($this->titulos[1],$this->titulos[2]));
   $this->SetBorder(1);
   $this->SetFillTable(0);
   //VIENEN LOS DATOS
   $registro=count($this->arrp);
   $reg = 1;
   foreach($this->arrp as $dato){
       $reg++;
       $y = $this->getY();
	   $this->setXY(12,$y);

	   $this->SetFont("Arial","B",8);
	   $this->SetWidths(array(90,90));
       $this->SetAligns(array("C","C"));
	   $this->SetBorder(0);
	   //$mensual = $dato["monanoact"]/12;
	  // print $mensual;exit;
	   $this->RowM(array($dato["codigo"],$dato["nombre"]));
	   $this->SetBorder(0);
	   $this->SetFillTable(0);
       //$acummes = $acummes + $mensual;

   }
   if ($reg<=$registro)
		        {
		        	//$this->ln(30);
		        	$this->addpage();
		       }



    }
  }
?>
