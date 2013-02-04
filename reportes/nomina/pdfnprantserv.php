<?
  require_once("../../lib/general/fpdf/fpdf.php");
  require_once("../../lib/bd/basedatosAdo.php");
  require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/modelo/sqls/nomina/Nprantserv.class.php");
    //require_once("../../lib/general/mc_table.php");

  class pdfreporte extends fpdf
  {

//DECLARACION DE VARIABLES GLOBALES AQUI

    function pdfreporte()
    {
      $this->fpdf("l","mm","Letter");
      //CODIGO DE LAS CUENTAS
      $this->cedula = H::GetPost("cedula");
      $this->motivo = H::GetPost("motmin");
      $this->fecsol = H::GetPost("fecsol");
      $this->observ = H::GetPost("observ");
      $this->nomdirec = H::GetPost("nomdirrec");
      $this->cardirec = H::GetPost("cardirrec");
      $this->antserv= new Nprantserv();
      $this->cabecera = new cabecera ();
      $this->llenartitulosmaestro();
      $this->arrp=$this->antserv->sqlp($this->cedula);
      //$this->SetAutoPageBreak(true);

        }// fin del pdf

function llenartitulosmaestro()
    {
       /* $this->titulos[0]="CÉDULA";
        $this->titulos[1]="NOMBRE";
        $this->titulos[2]="FECHA DE NACIMIENTO";
        $this->titulos[3]="EDAD";*/

  }




    function Header()
    {
      $this->SetTextColor(0,0,0);
	  $this->cabecera->poner_cabecera($this,$_POST["titulo"],"l","s");
	  $this->setFont("Arial","B",9);
	  $this->ln(5);

    }

    function Cuerpo()
    {

		$this->SetX(180);
		$this->setFont("Arial","",8);
		$this->SetWidths(array(90));
		$this->SetAligns(array("C"));
		$this->SetBorder(1);
		$this->rowm(array("FECHA DE SOLICITUD"));
		$this->SetBorder(0);
    	$this->SetFillTable(0);


		$this->SetX(180);
    	$this->setFont("Arial","",8);
		$this->SetWidths(array(30,30,30));
		$this->SetAligns(array("C","C","C"));
		$this->SetBorder(1);
		$this->rowm(array("DIA","MES","AÑO"));
		$this->SetBorder(0);
		$this->SetFillTable(0);


		$this->SetX(180);
		$this->setFont("Arial","",8);
		$this->SetWidths(array(30,30,30));
		$this->SetAligns(array("C","C","C"));
		$this->SetBorder(1);
		$this->rowm(array(substr($this->fecsol,0,2),substr($this->fecsol,3,2),substr($this->fecsol,6,4)));
		$this->SetBorder(0);
		$this->SetFillTable(0);

		$this->SetFillColor(230,230,230);
		$this->setFont("Arial","B",8);
		$this->SetWidths(array(260));
		$this->SetAligns(array("C"));
		$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("DATOS PERSONALES"));
		$this->SetBorder(0);
    	$this->SetFillTable(0);

        $this->setFont("Arial","",8);
		$this->SetWidths(array(130,130));
		$this->SetAligns(array("L","L"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("NOMBRES Y APELLIDOS:\n".$this->arrp[0][nombre],"Nº DE CÉDULA DE IDENTIDAD:\n".$this->arrp[0][codigo]));
		//$this->SetBorder(0);
    	$this->SetFillTable(0);

    	$this->SetFillColor(230,230,230);
		$this->setFont("Arial","B",8);
		$this->SetWidths(array(260));
		$this->SetAligns(array("C"));
		$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("INGRESO"));
		$this->SetBorder(0);
    	$this->SetFillTable(0);

		$this->arring = $this->antserv->sqldatos($this->cedula,'I');

    	$this->setFont("Arial","",8);
		$this->SetWidths(array(60,40,40,40,40,40));
		$this->SetAligns(array("C","C","C","C","C","C"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("FECHA","TITULO DEL CARGO","CODIGO DE CLASE","GRADO", "HORARIO DE TRABAJO\n"."","HORAS SEMANALES\n".""));
		//$this->SetBorder(0);
    	$this->SetFillTable(0);

    	$this->setFont("Arial","",8);
		$this->SetWidths(array(20,20,20,40,40,40,40,40));
		$this->SetAligns(array("C","C","C","C","C","C","C","C"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("DIA\n".("_____________")."\n".substr($this->arring[0][fechaing],0,2),"MES\n".("_______________")."\n".substr($this->arring[0][fechaing],3,2),"AÑO\n".("___________")."\n".substr($this->arring[0][fechaing],6,4),$this->arring[0][nomcar],"","","8:30 am- 4:30 pm","40"));//LOS DATOS DE CODIGO DE CLASE Y GRADO POR AHORA EN VACIO
		//$this->SetBorder(0);
    	$this->SetFillTable(0);

    	$this->arrpsal1 = $this->antserv->pagos($this->cedula,'I');

    	foreach ($this->arrpsal1 as $dato)
    	{
    		$this->setFont("Arial","",8);
			$this->SetWidths(array(100,160));
			$this->SetAligns(array("L","L"));
			//$this->SetFillTable(1);
			$this->SetBorder(1);
			$this->rowm(array($dato["nomcon"],H::FormatoMonto($dato["monto"])));
			$this->SetBorder(0);
	    	//$this->SetFillTable(0);

    	}

		$this->SetFillColor(230,230,230);
		$this->setFont("Arial","B",8);
		$this->SetWidths(array(260));
		$this->SetAligns(array("C"));
		$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("EGRESO"));
		$this->SetBorder(0);
    	$this->SetFillTable(0);

		$this->arregr = $this->antserv->sqldatos($this->cedula,'E');

    	$this->setFont("Arial","",8);
		$this->SetWidths(array(60,40,40,40,40,40));
		$this->SetAligns(array("C","C","C","C","C","C"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("FECHA","TITULO DEL CARGO","CODIGO DE CLASE","GRADO", "HORARIO DE TRABAJO\n"."","HORAS SEMANALES\n".""));
		//$this->SetBorder(0);
    	$this->SetFillTable(0);

    	$this->setFont("Arial","",8);
		$this->SetWidths(array(20,20,20,40,40,40,40,40));
		$this->SetAligns(array("C","C","C","C","C","C","C","C"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("DIA\n".("_____________")."\n".substr($this->arrp[0][fecret],0,2),"MES\n".("_______________")."\n".substr($this->arregr[0][fechaegr],3,2),"AÑO\n".("___________")."\n".substr($this->arregr[0][fechaegr],6,4),$this->arregr[0][nomcar],"","","8:30 am- 4:30 pm","40"));//LOS DATOS DE CODIGO DE CLASE Y GRADO POR AHORA EN VACIO
		//$this->SetBorder(0);
    	$this->SetFillTable(0);

    	$this->arrpsal2 = $this->antserv->pagos($this->cedula,'E');

    	foreach ($this->arrpsal2 as $dato1)
    	{
    		$this->setFont("Arial","",8);
			$this->SetWidths(array(100,160));
			$this->SetAligns(array("L","L"));
			//$this->SetFillTable(1);
			$this->SetBorder(1);
			$this->rowm(array($dato1["nomcon"],H::FormatoMonto($dato1["monto"])));
			$this->SetBorder(0);
	    	//$this->SetFillTable(0);

    	}

    	$this->setFont("Arial","",8);
		$this->SetWidths(array(30,50,180));
		$this->SetAligns(array("C","C","C"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("TIPO DE EGRESO","PAGO DE PRESTACIONES","FUNDAMENTO LEGAL"));
		//$this->SetBorder(0);
    	$this->SetFillTable(0);

    	$arrppresta = $this->antserv->prespag($this->cedula);
    	if($arrppresta[0][numord]<>"")
    	{
    		$pagada = "CANCELADO";
    	}
    	else
    	{
    		$pagada = "EN TRAMITE";
    	}
    	$cadenafund = "Art. 19 último aparte, 20 en su encabezamiento  y 21 de la Ley del Estatuto de la Función Pública";


    	$this->setFont("Arial","",8);
		$this->SetWidths(array(30,50,180));
		$this->SetAligns(array("C","C","L"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array($this->motivo,$pagada,$cadenafund));
		//$this->SetBorder(0);
    	$this->SetFillTable(0);

    	$this->setFont("Arial","",8);
		$this->SetWidths(array(260));
		$this->SetAligns(array("L"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("OBSERVACIONES:\n".$this->observ));
		//$this->SetBorder(0);
    	//$this->SetFillTable(0);

        $this->setFont("Arial","",8);
		$this->SetWidths(array(60,200));
		$this->SetAligns(array("C","C"));
		//$this->SetFillTable(1);
		$this->SetBorder(1);
		$this->rowm(array("FECHA DE EMISION",""));
		//$this->SetBorder(0);
    	//$this->SetFillTable(0);

    	$this->setFont("Arial","",8);
		$this->SetWidths(array(20,20,20,100,60,40));
		$this->SetAligns(array("C","C","C","C","C","C"));
		$this->SetBorder(1);
		$this->rowm(array("DIA","MES","AÑO","APELLIDOS Y NOMBRES","CARGO","FIRMA Y SELLO"));

		//print date('d').'-'.date('m').'-'.date('y');exit;
		$this->setFont("Arial","",8);
		$this->SetWidths(array(20,20,20,100,60,40));
		$this->SetAligns(array("C","C","C","C","C","C"));
		$this->SetBorder(1);
		$this->rowm(array(date('d'),date('m'),date('Y'),$this->nomdirec,$this->cardirec,""));

    }

 }
?>
