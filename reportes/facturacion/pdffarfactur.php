<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farfactur.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;

		function pdfreporte()
		{
			$this->conf="l";
			$this->fpdf($this->conf,"mm","Letter");

			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();

			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");

			$this->fechades=H::GetPost("fechades");
			$this->fechahas=H::GetPost("fechahas");

			$this->estatus=H::GetPost("estatus");
			$this->condipago=H::GetPost("condipago");

			$this->codfacdes=H::GetPost("codfacdes");
			$this->codfachas=H::GetPost("codfachas");

			$this->status=$this->verificar_status();
			$this->condi=$this->verificar_condicion();

			$this->farfactur = new Farfactur();
            $this->arrp = $this->farfactur->sqlp($this->coddes,
		                                         $this->codhas,
		                                         $this->codfacdes,
		                                         $this->codfachas,
		                                         $this->codartdes,
		                                         $this->codarthas,
		                                         $this->fechades,
		                                         $this->fechahas,
		                                         $this->estatus,
		                                         $this->condi);

		}




		function verificar_status()
		{

		if    ($this->estatus=='ACTIVAS'){  //Activas
			  $this->sta='A';


		}else if ($this->estatus=='ANULADAS'){  //Anuladas
			      $this->sta='N';

		}
		return $this->sta;
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
			    $this->setFont("Arial","B",12);
			    $this->SetWidths(array(25,80,25,25,60,20,25));
    	        $this->SetAligns(array("C","C","C","C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array("Codigo","Cliente","Factura","Fecha","Descripción","Estatus","Monto"));
    	        $this->SetAligns(array("C","L","C","C","L","C","R"));
    	        $this->line(10,$this->GetY(),270,$this->GetY());
    	        $this->ln();
		}

function Cuerpo()
{

	    $reg=1;
        $registro=count($this->arrp);
		foreach($this->arrp as $dato)
           {
                 $reg++;
                 $this->SetWidths(array(25,80,25,25,60,20,25));
    	         $this->SetAligns(array("C","L","C","C","L","C","R"));
    	         $this->setBorder(0);
    	         $this->setFont("Arial","",9);
    	         $this->RowM(array($dato["codcli"],$dato["nomcli"],$dato["reffac"],$dato["fecfac"],$dato["desfac"],$dato["status"],H::FormatoMonto($dato["monfac"])));
    	         $monto+=$dato["monfac"];
                 $this->Ln();
           }
             	 $this->setFont("Arial","B",12);
                 $this->SetWidths(array(215,45));
    	         $this->SetAligns(array("R","R"));
    	         $this->setBorder(0);
    	         $this->RowM(array("Total General",H::FormatoMonto($monto)));
    	         $monto=0;
        if ($reg<=$registro)
		        {
		        	$this->addpage();

		        }

}//cuerpo
}//fin de la clase
?>
