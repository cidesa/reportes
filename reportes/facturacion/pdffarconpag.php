<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farconpag.class.php");

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
			$this->condipago=H::GetPost("condipago");
			$this->condicion=$this->verificar_condicion();

			$this->farconpag = new Farconpag();
           // print "$this->condicion";
		    $this->arrp = $this->farconpag->sqlp($this->coddes,$this->codhas,$this->condicion);
			$this->verificar_condicion();
			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{
				$this->titulosm[0]="CODIGO";
				$this->titulosm[1]="DECRIPCION";
				$this->titulosm[2]="TIPO";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=90;
		$this->anchos[3]=50;
		$this->anchos[4]=40;
	}


		function verificar_condicion()
		{

		if    ($this->condipago=='CONTADO'){
			  $this->condicion='C';


		}else if ($this->condipago=='CREDITO'){
			      $this->condicion='R';

		}
		return $this->condicion;
		}

function Header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			$this->setFont("Arial","",9);
			//$this->setFont("Arial","B",14);
			//$this->cell(220,5, $this->titulosm[100],0,0,'C');
			$this->Ln();
			$this->SetWidths(array($this->anchos[3],$this->anchos[2],$this->anchos[3]));
    	    $this->SetAligns(array("C","C","C"));
    	    $this->setBorder(1);
    	    $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2]));

		}

function Cuerpo()

		{

	    $reg=1;
		$codconpag="";
		$registro=count($this->arrp);
		//H::PrintR($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["codconpag"]!=$codconpag)
             {
                $this->SetWidths(array($this->anchos[3],$this->anchos[2],$this->anchos[3]));
    	        $this->SetAligns(array("L","L","C"));
    	        $this->setBorder(1);
    	        $this->RowM(array($dato["codconpag"],$dato["desconpag"],$dato["case"]));

            }

            }
		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }



		}

}//fin de la clase

?>