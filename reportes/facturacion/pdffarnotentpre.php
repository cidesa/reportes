<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Farnotentpre.class.php");
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
      //CODIGO DE CLIENTE
      $this->cli1=H::GetPost("clides");
      $this->cli2=H::GetPost("clihas");
      //FECHA
      $this->fec1=H::GetPost("fechades");
      $this->fec2=H::GetPost("fechahas");
      //ESTATUS
      $this->estatus=H::GetPost("estatus");
      //REFERENCIA
      $this->ref=H::GetPost("referencia");

      //REALIZADO POR, AUTORIZADO POR, RECIBIDO POR
      $this->realizado=H::GetPost("realizado");
      $this->autorizado=H::GetPost("autorizado");
      $this->recibido=H::GetPost("recibido");
      $this->fecharec=H::GetPost("fecharec");



      //print $this->ref."-".$this->estatus;exit;
      //$caso = $this->ref.$this->estatus;
      //print $caso;exit;
      if ($this->estatus == "M" and $this->ref == "T")

      	{$caso = 1;}

      else if ($this->estatus == "M" and ($this->ref<>"T"))

      	{$caso = 2;}

      else if ($this->ref == "T" and ($this->estatus<>"M") )

      	{$caso = 3;}

      else
       {$caso = 4;}

     //  print $caso;exit;


      $this->far= new Farnotentpre();
      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2,$this->cli1,$this->cli2,$this->fec1,$this->fec2,$this->estatus,$this->ref,$caso);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[0]="NOTA DE ENTREGA";
        $this->titulos[1]="Nota de entrega Nro: ";
        $this->titulos[2]="Fecha de Emisión: ";
        $this->titulos[3]="Entregar en: ";
        $this->titulos[4]="Almacén: ";
        $this->titulos[5]="Dirección: ";
        $this->titulos[6]="Cliente N°";
        $this->titulos[7]="Pedido N°";
        $this->titulos[8]="N° O.C";
        $this->titulos[9]="Vendedor";
        $this->titulos[10]="Guía";
        $this->titulos[11]="Fecha Entrega";
        $this->titulos[12]="Código";
        $this->titulos[13]="Descripción";
        $this->titulos[14]="Unidad";
        $this->titulos[15]="Cantidad";
        $this->titulos[16]="Número Lote";
        $this->titulos[17]="Fecha Vencimiento";
        $this->titulos[18]="ESTE DOCUMENTO VA SIN TACHADURA NI ENMENDADURA";
        $this->titulos[19]="Observación: ";
        $this->titulos[20]="Realizado por: ";
        $this->titulos[21]="Autorizado por: ";
        $this->titulos[22]="Recibido por: ";
        $this->titulos[23]="Fecha: ";
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


   //ENCABEZADO DEL CUADRO
  // $this->ln();
   //$x = $this->getX();
   $y = $this->getY();
   $this->setXY(10,$y);

   //VIENEN LOS DATOS
   $registro=count($this->arrp);
   $reg = 1;
   foreach($this->arrp as $dato){


       $reg++;
       //TITULO DEL REPORTE
	    /*$this->ln();
	    $this->setFont("Arial","B",12);
		$this->SetWidths(array(260));
		$this->SetAligns(array("C"));
		//$this->SetBorder(1);
		$this->Row(array($this->titulos[0]));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
        $this->ln();*/
        //linea 2
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(200,60));
		$this->SetAligns(array("L","L"));
		//$this->SetBorder(1);
		$this->Row(array("",$this->titulos[1].""."".$dato["nronot"]));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
		//linea 3
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(200,60));
		$this->SetAligns(array("L","L"));
		//$this->SetBorder(1);
		$this->Row(array("",$this->titulos[2].""."".$dato["fecnot"]));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
		//linea 4
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(80,180));
		$this->SetAligns(array("L","L"));
		//$this->SetBorder(1);
		$this->Row(array($this->titulos[3].""."".$dato["nomcli"],$this->titulos[5].""."".$dato["dircli"]));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
		//linea 5
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(100,160));
		$this->SetAligns(array("L","L"));
		//$this->SetBorder(1);
		$this->Row(array($this->titulos[4].""."".$dato["nomalm"],""));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
		//linea 6
        //print $dato["tipref"];
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(42,42,42,50,42,42));
		$this->SetAligns(array("C","C","C","C","C","C"));
		$this->SetBorder(1);
		$this->Row(array($this->titulos[6]."\n".$dato["codcli"],$this->titulos[7]."\n".$dato["referencia"],$this->titulos[8]."\n"."",$this->titulos[9]."\n".$dato["autpor"], $this->titulos[10]."\n"."",$this->titulos[11]."\n".$dato["fecnot"]));//ojo
		$this->SetBorder(0);
		$this->SetFillTable(0);
		//linea 7
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(42,50,42,42,42,42));
		$this->SetAligns(array("C","C","C","C","C","C"));
		$this->SetBorder(1);
		$this->Row(array($this->titulos[12], $this->titulos[13], $this->titulos[14], $this->titulos[15], $this->titulos[16], $this->titulos[17]));
		$this->SetBorder(0);
		$this->SetFillTable(0);
        //VIENE EL DETALLE
        $this->arrp2 = $this->far->sqldetalle($dato["nronot"],$dato["codalm"]);
        foreach ($this->arrp2 as $dato2)
        {
	        $this->setFont("Arial","",8);
			$this->SetWidths(array(42,50,42,42,42,42));
			$this->SetAligns(array("L","L","L","R","L","L"));
			$this->SetBorder(1);
			$this->Row(array($dato2["codart"], $dato2["desart"], $dato2["unimed"], $dato2["cantot"], $dato2["numlot"], $dato2["fecven"]));
			$this->SetBorder(0);
			$this->SetFillTable(0);

        }

        $this->ln();
        $this->setFont("Arial","B",12);
		$this->SetWidths(array(260));
		$this->SetAligns(array("C"));
		//$this->SetBorder(1);
		$this->Row(array($this->titulos[18]));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
		$this->ln();
		//Observaciones

		$this->setFont("Arial","B",8);
		$this->SetWidths(array(260));
		$this->SetAligns(array("L"));
		//$this->SetBorder(1);
		$this->Row(array($this->titulos[19]."\n".$dato["obsnot"]));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
		//realizado por

		$this->setFont("Arial","B",8);
		$this->SetWidths(array(90,90,80));
		$this->SetAligns(array("L","L","L"));
		//$this->SetBorder(1);
		$this->Row(array($this->titulos[20].""."".$this->realizado, $this->titulos[21].""."".$this->autorizado,$this->titulos[22].""."".$this->recibido."\n".$this->titulos[23].""."".$this->fecharec));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
        if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }
   }
   /*if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }*/



    }
  }
?>
