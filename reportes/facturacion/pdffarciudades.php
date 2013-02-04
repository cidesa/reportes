<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farciudades.class.php");

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
			$this->codpahas=H::GetPost("codpahas");

			$this->codciudes=H::GetPost("codciudes");
			$this->codciuhas=H::GetPost("codciuhas");

			$this->farciudades = new Farciudades();
		    $this->arrp = $this->farciudades->sqlp($this->codpades,$this->codpahas,$this->coddes,$this->codhas,$this->codciudes,$this->codciuhas);
			$this->llenartitulosmaestro();
			$this->llenaranchos();

		}

	function llenartitulosmaestro()
	  {

				$this->titulosm[0]="Código Pais";
				$this->titulosm[1]="Nombre del País";

				$this->titulosm[2]="Código Estado";
				$this->titulosm[3]="Nombre del Estado";

				$this->titulosm[4]="Código Ciudad";
				$this->titulosm[5]="Nombre de la Ciudad";
				$this->titulosm[6]="";
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
		$this->anchos[8]=30;

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
		$codciudad="";
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

                $codpai=$dato["codpais"];
                $this->Ln();
                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[0],$this->anchos[7],$this->anchos[6]));
    	        $this->SetAligns(array("L","L","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[6],$this->titulosm[2],$this->titulosm[3]));
                $this->Ln(1);

                $this->arrp1 = $this->farciudades->sqlp1($codpai);
                foreach($this->arrp1 as $dato1)
                 {

               if($dato1["codedo"]!=$codedo)
              {

                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[0],$this->anchos[6],$this->anchos[1]));
    	        $this->SetAligns(array("L","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[6],$dato1["codedo"],$dato1["nomedo"]));

    	        $this->Ln();
                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[0],$this->anchos[0],$this->anchos[7],$this->anchos[6]));
    	        $this->SetAligns(array("C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[6],$this->titulosm[6],$this->titulosm[4],$this->titulosm[5]));
                $codedo=$dato1["codedo"];
                $this->arrp2 = $this->farciudades->sqlp2($codedo);
                foreach($this->arrp2 as $dato2)
                 {

               if($dato1["codciudad"]!=$codciudad)
              {
                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[8],$this->anchos[0],$this->anchos[6],$this->anchos[1]));
    	        $this->SetAligns(array("C","C","L","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[6],$this->titulosm[6],$dato2["codciudad"],$dato2["nomciu"]));
    	        $codciudad=$dato1["codciudad"];


              }

                 }

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