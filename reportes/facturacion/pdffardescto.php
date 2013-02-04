<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Fardescto.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;

		function pdfreporte()
		{
			$this->conf="p";
			$this->fpdf($this->conf,"mm","Letter");

	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");
			$this->descuento=H::GetPost("descuento");
			$this->condicion=$this->verificar_condicion();

			$this->fardescto = new Fardescto();
		    $this->arrp = $this->fardescto->sqlp($this->coddes,$this->codhas,$this->condicion);
			$this->verificar_condicion();
			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{
				$this->titulosm[0]="CODIGO";
				$this->titulosm[1]="DECRIPCION";
				$this->titulosm[2]="CUENTA CONTABLE";
				$this->titulosm[3]="TIPO DESCUENTO";
				$this->titulosm[4]="MONTO";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=90;
		$this->anchos[3]=50;
		$this->anchos[4]=35;
	}


		function verificar_condicion()
		{

		if    ($this->descuento=='PORCENTUAL'){
			  $this->condicion='P';


		}else if ($this->descuento=='PUNTUAL'){
			      $this->condicion='M';

		}
		return $this->condicion;
		}

function Header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"P","n");
			$this->setFont("Arial","B",8);
			//$this->setFont("Arial","B",14);
			//$this->cell(220,5, $this->titulosm[100],0,0,'C');
			$this->Ln(5);
			$this->SetWidths(array($this->anchos[4],$this->anchos[3],$this->anchos[4],$this->anchos[4],$this->anchos[4]));
    	    $this->SetAligns(array("C","L","C","C","C"));
    	    $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4]));
    	    $this->line(10,$this->getY(),200,$this->getY());
   			$this->ln();

		}

function Cuerpo()

		{

	    $reg=1;
		$coddesc="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["coddesc"]!=$coddesc)
             {
				$this->setFont("Arial","",8);
                $this->SetWidths(array($this->anchos[4],$this->anchos[3],$this->anchos[4],$this->anchos[4],$this->anchos[4]));
    	        $this->SetAligns(array("C","L","C","C","R"));
    	        $this->RowM(array($dato["coddesc"],$dato["desdesc"],$dato["codcta"],$dato["tipodescuento"],H::FormatoMonto($dato["mondesc"])));

            }

            }
		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }



		}

}//fin de la clase

?>