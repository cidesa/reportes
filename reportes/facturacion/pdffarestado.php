<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farestado.class.php");

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
			$this->codpades=H::GetPost("codpades");
			$this->codpadhas=H::GetPost("codpahas");

			$this->farestado = new Farestado();
		    $this->arrp = $this->farestado->sqlp($this->coddes,$this->codhas,$this->codpades,$this->codpadhas);
			$this->llenartitulosmaestro();
			$this->llenaranchos();

		}

	function llenartitulosmaestro()		{

				$this->titulosm[0]="Código Pais";
				$this->titulosm[1]="Descripción";

				$this->titulosm[2]="Código Estado";
				$this->titulosm[3]="Descripción";
				$this->titulosm[4]="";
		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=20;
		$this->anchos[1]=150;
		$this->anchos[2]=160;
		$this->anchos[3]=80;
		$this->anchos[5]=40;
		$this->anchos[6]=50;
		$this->anchos[7]=55;

	}

function Header()
		{
		    	$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);
			    $this->Ln();
			    $this->SetWidths(array($this->anchos[5],$this->anchos[6]));
    	        $this->SetAligns(array("L","C"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[0],$this->titulosm[1]));
                $this->Ln(0.5);

		}

function Cuerpo()

		{
	    $reg=1;
		$codpai="";
		$codedo="";
		$registro=count($this->arrp);
        //H::PrintR($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["codpais"]!=$codpai)
              {
                $this->setFont("Arial","B",12);
                $this->SetWidths(array($this->anchos[6],$this->anchos[2]));
    	        $this->SetAligns(array("L","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($dato["codpais"],$dato["nompai"]));

                $this->Ln();
                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[0],$this->anchos[7],$this->anchos[6]));
    	        $this->SetAligns(array("L","L","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[4],$this->titulosm[2],$this->titulosm[3]));
                $this->Ln(0.5);
                $codpai=$dato["codpais"];
                $this->arrp1 = $this->farestado->sqlp1($codpai);

                foreach($this->arrp1 as $dato1)
                 {

               if($dato1["id"]!=$codedo)
              {
                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[0],$this->anchos[6],$this->anchos[2]));
    	        $this->SetAligns(array("C","L","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[4],$dato1["id"],$dato1["nomedo"]));
                $codedo=$dato1["id"];
              }
                }


              }


            }
            if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }
		}

}//fin de la clase
?>
