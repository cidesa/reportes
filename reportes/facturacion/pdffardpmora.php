<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Fardpmora.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $reg=0;

		function pdfreporte()
		{
			$this->conf="l";
			$this->fpdf($this->conf,"mm","Letter");
	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
            $this->codclides=H::GetPost("codclides");
			$this->codclihas=H::GetPost("codclihas");
            $this->numdes=H::GetPost("numdes");
            $this->numhas=H::GetPost("numhas");
            $this->fecdes=H::GetPost("fecdes");
            $this->fechas=H::GetPost("fechas");
			$this->fardpmora = new Fardpmora();
		    $this->arrp = $this->fardpmora->sqlp($this->codclides,$this->codclihas,$this->numdes,$this->numhas,$this->fecdes,$this->fechas);
			$this->titulosmestros();
		}


	function titulosmestros()
	{
		$this->titulos[]="Orden de Despacho";
		$this->anchos[]=13;
		$this->titulos[]="No Guia de Transporte";
		$this->anchos[]=15;
		$this->titulos[]="No nota Entrega";
		$this->anchos[]=13;
		$this->titulos[]="Nombre del Transporte y Placas";
		$this->anchos[]=40;
		$this->titulos[]="Fecha de Llegada";
		$this->anchos[]=15;
		$this->titulos[]="Fecha de Descarga";
		$this->anchos[]=15;
		$this->titulos[]="Hora de Llegada";
		$this->anchos[]=15;
		$this->titulos[]="Hora de Descarga";
		$this->anchos[]=15;
		$this->titulos[]="Destino";
		$this->anchos[]=21;
		$this->titulos[]="Contenedor";
		$this->anchos[]=15;
		$this->titulos[]="Cantidad Klg";
		$this->anchos[]=15;
		$this->titulos[]="Producto";
		$this->anchos[]=13;
		$this->titulos[]="Cajas";
		$this->anchos[]=13;
		$this->titulos[]="Horas de Mora";
		$this->anchos[]=15;
		$this->titulos[]="Bs por Destinos";
		$this->anchos[]=15;
		$this->titulos[]="Recargas Mora";
		$this->anchos[]=15;
	}
	function getENcabezado2($cliente,$numero,$rif,$ffactura,$bl,$origendestino){
		$this->SetWidths(array(70,30));
    	$this->SetAligns(array("L","L"));
    	$this->setJump(3);
    	$this->RowM(array("Cliente: ".$cliente," No Factura: ".$numero));
    	$this->SetWidths(array(70,40));
	    $this->SetAligns(array("L","L"));
	    $this->setJump(2);
	    $this->RowM(array("Rif: ".$rif," Fecha Factura: ".$ffactura));
	    $this->setJump(2);
	    $this->RowM(array("B-L: ".$bl));
	    $this->setJump(2);
	    $this->RowM(array("ORIGEN-DESTINO: ".$origendestino));
	    $this->setXY(120,25);
	    $this->multicell(120,3,"TIEMPO DE MORA DESPUES DE 12 HORAS HABILES CONTINUAS DE ARRIBO AL CENTRO DESTINO. INCLUYENDO DOMINGO Y DIAS FERIADOS MORA EN Bs: 40% DEL FLETE C/12 HORAS HABILES TRASLADO: Bs. SEGUN Kms. POR TABULADOR DE RUTA CON SOPORTES PREVIA",0,'C');

	}

		/*function verificar_status()
		{

		if    ($this->estatus=='ACTIVAS'){  //Activas
			  $this->sta='A';


		}else if ($this->estatus=='ANULADAS'){  //Anuladas
			      $this->sta='N';

		}
		return $this->sta;
		}

		function verificar_referencia()
		{

		if    ($this->tiprefe=='NOTAS DE ENTREGA'){
			  $this->refe='NE';


		}else if ($this->tiprefe=='REQUISICION'){
			      $this->refe='R';



		}else if ($this->tiprefe=='DEVOLUCION'){
			      $this->refe='D';

		}

		return $this->refe;
		}*/

function Header()
{
    $this->cab->poner_cabecera($this,"",$this->conf,"s","n");
    $this->setFont("Arial","B",6.5);
    $this->SetWidths($this->anchos);
    $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
    $this->setBorder(0);
    $this->RowM($this->titulos);
    $this->SetLineWidth(0.5);
    $this->line(10,35,270,35);
    $this->line(10,45,270,45);
    $y1=$this->GetY();
    $this->setXY(10,23);
	$this->getEncabezado2($this->arrp[$this->reg]["cliente"],$this->arrp[$this->reg]["numero"],$this->arrp[$this->reg]["rif"],$this->arrp[$this->reg]["ffactura"],$this->arrp[$this->reg]["bl"],$this->arrp[$this->reg]["origendestino"]);
    $this->setY($y1);
}

function Cuerpo()
{
	    $r=0;
		$codpro="";
		$codart="";
		$nronot="";
		$reg1=1;
		$registro=count($this->arrp);
		$this->setFont("Arial","B",5);
		$codigo=$this->arrp[0]["numero"];
		$acumkg=0;
		$acumca=0;
		$acumpre=0;
		foreach($this->arrp as $dato)
        {
        	//esto es una prueba..
        	if($dato["numero"]!=$codigo){
        		$y=$this->GetY();
        		$this->reg++;
        		$this->Ln();
	     		$this->SetWidths($this->anchos);
		 		$this->setY($y);
		 		$this->setFont("Arial","B",6.5);
		 		$this->RowM(array("",$r,"","Totales","","","","","","",H::formatoMonto($acumkg),"",H::formatoMonto($acumca),"",H::formatoMonto($acumpre),""));
		 		$this->setFont("Arial","B",5);
		 		$this->SetLineWidth(0.5);
    	 		$this->line(10,$y,270,$y);
         		$this->line(10,$y+5,270,$y+5);
				$this->addpage();
				$acumkg=0;
				$acumca=0;
				$acumpre=0;
				$r=0;
        	}
        	$this->SetWidths($this->anchos);
        	$this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
			$this->RowM(array($dato["orddespacho"],$dato["guiatransporte"],$dato["nnota"],$dato["chofer"]." ".$dato["placa"],$dato["fllegada"],$dato["fsalida"],$dato["hllegada"],$dato["hsalida"],$dato["origendestino"],$dato["contenedor"],$dato["kg"],$dato["producto"],$dato["cajas"],"",$dato["pdestino"],""));
			$y=$this->GetY();
			$acumkg+=$dato["kg"];
			$acumca+=$dato["cajas"];
			$acumpre+=$dato["pdestino"];
			$r++;

       	}//foreach
	     $this->Ln();
	     $this->SetWidths($this->anchos);
		 $this->setY($y);
		 $this->setFont("Arial","B",6.5);
		 $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
		 $this->RowM(array("",$r,"","Totales","","","","","","",H::formatoMonto($acumkg),"",H::formatoMonto($acumca),"",H::formatoMonto($acumpre),""));
		 $this->SetLineWidth(0.5);
    	 $this->line(10,$y,270,$y);
         $this->line(10,$y+5,270,$y+5);

 }//cuerpo


}//fin de la clase
?>