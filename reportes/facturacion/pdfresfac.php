<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/facturacion/Resfac.class.php");
    //require_once("../../lib/general/mc_table.php");

  class pdfreporte extends fpdf
  {

//DECLARACION DE VARIABLES GLOBALES AQUI

    function pdfreporte()
    {
      $this->fpdf("l","mm","Letter");
      //CODIGO DE CONDICION
      $this->cod1=H::GetPost("conddes");
      $this->cod2=H::GetPost("condhas");
      //FECHA
      $this->fec1=H::GetPost("fechades");
      $this->fec2=H::GetPost("fechahas");

      //ESTATUS
      $this->estatus=H::GetPost("estatus");

      if ($this->estatus == "M")

      	{$caso = 1;}

      else
         {$caso = 0;}


      $this->far = new Resfac();
      $this->arrp2=$this->far->datos($this->cod1);//desde
      $this->arrp3=$this->far->datos($this->cod2);//hasta

      $this->llenartitulosmaestro();
      $this->arrp=$this->far->sqlp($this->cod1,$this->cod2,$this->fec1,$this->fec2,$this->estatus,$caso);


        }// fin del pdf

function llenartitulosmaestro()
    {
        $this->titulos[0]="RESUMEN DE VENTAS A ";
        $this->titulos[1]="Fecha: ";
        $this->titulos[2]="Hora: ";
        $this->titulos[3]="Status: ";
        $this->titulos[4]="Desde: ";
        $this->titulos[5]="Hasta: ";
        $this->titulos[6]="Código";
        $this->titulos[7]="Fecha ";
        $this->titulos[8]="Nombre o Razón Social ";
        $this->titulos[9]="Con IVA ";
        $this->titulos[10]="Sin IVA";
        $this->titulos[11]="Descuento";
        $this->titulos[12]="IVA";
        $this->titulos[13]="Total";
        $this->titulos[14]="Totales";
        /*$this->titulos[15]="Cantidad";
        $this->titulos[16]="Precio Unitario";
        $this->titulos[17]="Total";
        $this->titulos[18]="ESTE DOCUMENTO VA SIN TACHADURA NI ENMENDADURA";
        $this->titulos[19]="Total: ";
        $this->titulos[20]="Condiciones: ";
        $this->titulos[21]="Elaborado por: ";
        $this->titulos[22]="Revisado por: ";*/
        //$this->titulos[23]="Fecha: ";
  }




    function Header()
    {
      $this->setFont("Arial","B",9);
      $this->Image("../../img/logo_1.jpg",7,5,20);
      $this->Image("../../img/logo.jpg",243,5,20);


    }

    function Cuerpo()
    {
        $this->ln(25);


   //ENCABEZADO DEL CUADRO
   //$x = $this->getX();
   $y = $this->getY();
   $this->setXY(10,$y);
   $this->ln();
	    //linea 1
   $fecha_actual=date("d/m/Y");
   $hora = date(" H:i",time());
   $this->setFont("Arial","B",8);
   $this->SetWidths(array(200,60));
   $this->SetAligns(array("L","L"));
   //$this->SetBorder(1);
   $this->Row(array("",$this->titulos[1].""."".$fecha_actual));
   //$this->SetBorder(0);
   $this->SetFillTable(0);
    //linea 2
   $this->setFont("Arial","B",8);
   $this->SetWidths(array(200,60));
   $this->SetAligns(array("L","L"));
   //$this->SetBorder(1);
   $this->Row(array("",$this->titulos[2].""."".$hora));
   //$this->SetBorder(0);
   $this->SetFillTable(0);
   $this->ln();
   //linea3

   $this->arrp2=$this->far->datos($this->cod1);//desde
   $this->arrp3=$this->far->datos($this->cod2);//hasta
   $this->setFont("Arial","B",12);
   $this->SetWidths(array(260));
   $this->SetAligns(array("L"));
   //$this->SetBorder(1);
   //print $this->arrp2[0][despag];exit;
   $this->Row(array($this->titulos[0].""."".$this->arrp2[0][despag]." "." "."Y"." "." ".$this->arrp3[0][despag]));
   //$this->SetBorder(0);
   $this->SetFillTable(0);

   //linea 4

   $this->setFont("Arial","B",12);
   $this->SetWidths(array(200,60));
   $this->SetAligns(array("L","L"));
   //$this->SetBorder(1);
   $this->Row(array($this->titulos[4].""."".$this->fec1." "." ".$this->titulos[5].""."".$this->fec2,$this->titulos[3].""."".$this->arrp[0][status]));
   //$this->SetBorder(0);
   $this->SetFillTable(0);
   //linea 5
   $this->ln();
   $this->setFont("Arial","B",8);
   $this->SetWidths(array(30,50,30,30,30,30,30,30));
   $this->SetAligns(array("C","C","C","C","C","C","C","C"));
   $this->SetBorder(1);
   $this->Row(array($this->titulos[6],$this->titulos[7],$this->titulos[8],$this->titulos[9],$this->titulos[10],$this->titulos[11],$this->titulos[12],$this->titulos[13]));
   $this->SetBorder(0);
   $this->SetFillTable(0);


   //VIENEN LOS DATOS
   $registro=count($this->arrp);
   $reg = 1;
   $acumconiva= 0;
   $acumsiniva= 0;
   $acumdcto= 0;
   $acumiva= 0;
   $acumtotal= 0;

   foreach($this->arrp as $dato){


       $reg++;

	   $this->setFont("Arial","B",8);
	   $this->SetWidths(array(30,50,30,30,30,30,30,30));
	   $this->SetAligns(array("L","L","L","R","R","R","R","R"));
	   $this->SetBorder(1);
	   $this->Row(array($dato["reffac"],$dato["fecfac"],$dato["nomcli"],H::FormatoMonto($dato["coniva"]),H::FormatoMonto($dato["siniva"]),H::FormatoMonto($dato["descuento"]),H::FormatoMonto($dato["iva"]),H::FormatoMonto($dato["monfac"])));
	   $this->SetBorder(0);
	   $this->SetFillTable(0);

       $acumconiva = $acumconiva + $dato["coniva"];
       $acumsiniva = $acumsiniva + $dato["siniva"];
       $acumdcto = $acumdcto + $dato["descuento"];
       $acumiva = $acumiva +   $dato["iva"];
       $acumtotal = $acumtotal + $dato["monfac"];


   }

        //totales
        $this->setFont("Arial","B",8);
		$this->SetWidths(array(110,30,30,30,30,30));
		$this->SetAligns(array("L","R","R","R","R","R"));
		$this->SetBorder(1);
		$this->Row(array($this->titulos[14],H::FormatoMonto($acumconiva),H::FormatoMonto($acumsiniva),H::FormatoMonto($acumdcto),H::FormatoMonto($acumiva),H::FormatoMonto($acumtotal)));
		$this->SetBorder(0);
		$this->SetFillTable(0);

   if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }



    }
  }
?>
