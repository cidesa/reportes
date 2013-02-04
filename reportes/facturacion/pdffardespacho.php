<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Fardespacho.class.php");
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

      //trabajo
      $this->estatus=H::GetPost("estatus");

      if ($this->estatus == "M")

      	{$caso = 1;}

      else
         {$caso = 0;}



      $this->far= new Fardespacho();
      //$this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2,$this->cli1,$this->cli2,$this->fec1,$this->fec2,$this->estatus,$caso);


        }// fin del pdf

function llenartitulosmaestro()
    {
        /*$this->titulos[0]="PRESUPUESTO";
        $this->titulos[1]="Fecha: ";
        $this->titulos[2]="Hora: ";
        $this->titulos[3]="Nº: ";
        $this->titulos[4]="Cliente: ";
        $this->titulos[5]="Rif: ";
        $this->titulos[6]="Fecha de solicitud: ";
        $this->titulos[7]="Dirección: ";
        $this->titulos[8]="Fax: ";
        $this->titulos[9]="Teléfonos: ";
        $this->titulos[10]="E-mail: ";
        $this->titulos[11]="Atención: ";
        $this->titulos[12]="Referido por: ";
        $this->titulos[13]="Validez de la oferta: ";
        $this->titulos[14]="Tiempo de ejecución ";
        $this->titulos[15]="Código";
        $this->titulos[16]="Descripción";
        $this->titulos[17]="Cantidad";
        $this->titulos[18]="Precio Unitario";
        $this->titulos[19]="Total";
        $this->titulos[20]="ESPECIFICACIONES DEL TRABAJO ";
        $this->titulos[21]="UNIDAD QUE ELABORA EL TRABAJO: ";
        $this->titulos[22]="TRABAJO A REALIZAR: ";
        $this->titulos[23]="Sub Total: ";
        $this->titulos[24]="Descuento: ";
        $this->titulos[25]="IVA: ";
        $this->titulos[26]="TOTAL: ";
        $this->titulos[27]="ELABORADO POR: ";
        $this->titulos[28]="APROBADO POR: ";*/


  }




    function Header()
    {
      $this->setFont("Arial","B",9);
      $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
      $this->setFont("Arial","",9);
	 // $this->Ln();


    }

    function Cuerpo()
    {
       // $this->ln(30);


   //ENCABEZADO DEL CUADRO
   //$this->ln();
   //$x = $this->getX();
   $y = $this->getY();
   $this->setXY(10,$y);

   //VIENEN LOS DATOS
   $registro=count($this->arrp);
   $reg = 1;
   foreach($this->arrp as $dato){


       $reg++;
        //linea 1
        /*$this->setFont("Arial","B",12);
		$this->SetWidths(array(260));
		$this->SetAligns(array("L","L"));
		//$this->SetBorder(1);
		$this->Row(array("DESPACHOS"));
		//$this->SetBorder(0);
		$this->SetFillTable(0);
		$this->ln();*/
		//linea 2
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(200,60));
		$this->SetAligns(array("L","L"));
		$this->SetBorder(1);
		$this->Row(array("Despacho: "." ".$dato["dphart"],"Fecha Emisión: "."".$dato["fecdph"]));
		$this->SetBorder(0);
		$this->SetFillTable(0);
        //linea 3
        $this->ln();
	    $this->setFont("Arial","B",8);
		$this->SetWidths(array(55,150,55));
		$this->SetAligns(array("L","L","L"));
		$this->SetBorder(1);
		$this->Row(array("RIF Cliente: "." ".$dato["rifpro"],"Nombre o razón social: "." ".$dato["nompro"],"Teléfono"." ".$dato["telpro"]));
		$this->SetBorder(0);
		$this->SetFillTable(0);
        $this->ln();

        //linea 4
        $this->ln();
	    $this->setFont("Arial","B",8);
		$this->SetWidths(array(260));
		$this->SetAligns(array("L"));
		$this->SetBorder(1);
		$this->Row(array("Dirección: "." ".$dato["dirpro"]));
		$this->SetBorder(0);
		$this->SetFillTable(0);
        //$this->ln();

        //linea 5
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(180,40,40));
		$this->SetAligns(array("L","L","L"));
		$this->SetBorder(1);
		$this->Row(array("Observación: "." ".$dato["obsdph"],"Forma despacho: "." ".$dato["nomdes"],"Estatus: "." ".$dato["stadph"]));
		$this->SetBorder(0);
		$this->SetFillTable(0);
		//VIENE EL DETALLE
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(30,80,30,30,30,30,30));
		$this->SetAligns(array("C","C","C","C","C","C","C"));
		$this->SetBorder(1);
		$this->Row(array("Código artículo","Descripción","Lote","Fecha Vencimiento","Cantidad","Precio","Total"));
		$this->SetBorder(0);
		$this->SetFillTable(0);

        $this->arrp2 = $this->far->sqldetalle($dato["dphart"]);
        $acum = 0;
        foreach ($this->arrp2 as $dato2)
        {
	        $this->setFont("Arial","",8);
			$this->SetWidths(array(30,80,30,30,30,30,30));
		    $this->SetAligns(array("L","L","R","L","R","R","R"));
		    $this->SetBorder(1);
			$subtotal = $dato2["cantot"] * $dato2["precio"];
			$acum = $acum + $subtotal;
			$this->Row(array($dato2["codart"], $dato2["desart"], $dato2["numlot"], $dato2["fecven"], $dato2["cantot"],H::FormatoMonto($dato2["precio"]), H::FormatoMonto($subtotal)));
			$this->SetBorder(0);
			$this->SetFillTable(0);

        }

        //$this->ln();
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(200,60));
		$this->SetAligns(array("L","L"));
		$this->SetBorder(1);
		$this->Row(array("","Total Despacho"." ".H::FormatoMonto($acum)));
		$this->SetBorder(0);
		$this->SetFillTable(0);
		/*//descuento
		$this->setFont("Arial","B",12);
		$this->SetWidths(array(200,60));
		$this->SetAligns(array("L","L"));
		$this->SetBorder(1);
		$this->Row(array("",$this->titulos[24].""));//no se de donde se saca esto
		$this->SetBorder(0);
		$this->SetFillTable(0);
		//IVA
		$this->setFont("Arial","B",12);
		$this->SetWidths(array(200,60));
		$this->SetAligns(array("L","L"));
		$this->SetBorder(1);
		$imp = $acum * 0.09;
		$this->Row(array("",$this->titulos[25]."".H::FormatoMonto($imp)));
		$this->SetBorder(0);
		$this->SetFillTable(0);
		//
		$this->setFont("Arial","B",12);
		$this->SetWidths(array(200,60));
		$this->SetAligns(array("L","L"));
		$this->SetBorder(1);
		$total = $acum + $imp;
		$this->Row(array("",$this->titulos[26]."".H::FormatoMonto($total)));
		$this->SetBorder(0);
		$this->SetFillTable(0);
		//Observaciones

		$this->setFont("Arial","B",8);
		$this->SetWidths(array(260));
		$this->SetAligns(array("C"));
		$this->SetBorder(1);
		$this->Row(array($this->titulos[20]));
		$this->SetBorder(0);
		$this->SetFillTable(0);
		//realizado por

		$this->setFont("Arial","B",8);
		$this->SetWidths(array(130,130));
		$this->SetAligns(array("L","L"));
		$this->SetBorder(1);
		$this->Row(array($this->titulos[21].""."".$this->unidad, $this->titulos[22].""."".$this->trabajo));
		$this->SetBorder(0);
		$this->SetFillTable(0);

		//realizado por

		$this->setFont("Arial","B",8);
		$this->SetWidths(array(130,130));
		$this->SetAligns(array("L","L"));
		$this->SetBorder(1);
		$this->Row(array($this->titulos[27].""."".$this->elaborado, $this->titulos[28].""."".$this->revisado));
		$this->SetBorder(0);
		$this->SetFillTable(0);*/

     if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }


   }



    }
  }
?>
