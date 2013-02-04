<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Farproalt.class.php");
    //require_once("../../lib/general/mc_table.php");

  class pdfreporte extends fpdf
  {

//DECLARACION DE VARIABLES GLOBALES AQUI

    function pdfreporte()
    {
          $this->conf="l";
			$this->fpdf($this->conf,"mm","Letter");

	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
      //CODIGO DE ARTICULO
      $this->cod1=H::GetPost("coddes");
      $this->cod2=H::GetPost("codhas");
      //DESCRIPCION DE ARTICULOS
      $this->desc1=H::GetPost("descmin");
      $this->desc2=H::GetPost("descmax");

      $this->far= new Faproalt();
      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2,$this->desc1,$this->desc2);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[0]="LISTADO DE PRODUCTOS ALTERNOS ";
        $this->titulos[1]="CÓDIGO ";
        $this->titulos[2]="DESCRIPCIÓN ";
        $this->titulos[3]="CÓDIGO ALTERNO ";
        $this->titulos[4]="DESCRIPCION";

  }




    function Header()
    {
         $this->setFont("Arial","B",9);
         $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
         $this->setFont("Arial","",9);
	     //$this->Ln();



    }

    function Cuerpo()
    {
       // $this->ln(30);


	//TITULO DEL REPORTE
	   /* $this->ln();
	    $this->setFont("Arial","B",12);
		$this->SetWidths(array(260));
		$this->SetAligns(array("C"));
		//$this->SetBorder(1);
		$this->Row(array($this->titulos[0]));
		//$this->SetBorder(0);
		$this->SetFillTable(0);*/

   //ENCABEZADO DEL CUADRO
   //$this->ln();
   //$x = $this->getX();
   $y = $this->getY();
   $this->setXY(10,$y);

   $this->SetFont("Arial","B",10);
   $this->SetWidths(array(65,65,65,65));
   $this->SetAligns(array("C","C","C","C"));
   $this->SetBorder(1);
   $this->RowM(array($this->titulos[1],$this->titulos[2],$this->titulos[3],$this->titulos[4]));
   $this->SetBorder(0);
   $this->SetFillTable(0);
   //VIENEN LOS DATOS
   $registro=count($this->arrp);
   $reg = 1;
   foreach($this->arrp as $dato){
       $reg++;
       $y = $this->getY();
	   $this->setXY(10,$y);
       $this->arrp2=$this->far->sqlalt($dato["codalt"]);

	   $this->SetFont("Arial","B",8);
	   $this->SetWidths(array(65,65,65,65));
       $this->SetAligns(array("C","C","C","C"));
	   $this->SetBorder(1);
	   //$mensual = $dato["monanoact"]/12;
	  // print $mensual;exit;
	   $this->RowM(array($dato["codart"],$dato["desart"],$dato["codalt"],$this->arrp2[0][desart]));
	   $this->SetBorder(0);
	   $this->SetFillTable(0);
       //$acummes = $acummes + $mensual;

   }
   if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }



    }
  }
?>
