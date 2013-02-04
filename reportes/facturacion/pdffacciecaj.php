<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Facciecaj.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;

		function pdfreporte()
		{
			$this->conf="l";
			$this->fpdf($this->conf,"mm","Letter");

	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();

			$this->fechades=H::GetPost("fechades");
			$this->fechahas=H::GetPost("fechahas");
			$this->detalle=H::GetPost("detalle");



			$this->facciecaj = new Facciecaj();
		    $this->arrp = $this->facciecaj->sqlp($this->fechades,
		                                         $this->fechahas,
		                                         $this->detalle);


			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{

				$this->titulosm[30]="";
				$this->titulosm[40]="CIERRE DE CAJA DEL";
				$this->titulosm[50]="AL";
                $this->titulosm[60]="ARQUEO DE CAJA";

				$this->titulosm[0]="Tipo";
				$this->titulosm[1]="Descripcion";
				$this->titulosm[2]="Cant. Transacciones";
				$this->titulosm[3]="Monto Total Tipo";

                $this->titulosm[4]="Factura";
				$this->titulosm[5]="Banco";
				$this->titulosm[6]="Referencia";
				$this->titulosm[7]="Monto Transaccion";

				$this->titulosm[8]="Monto Real";
				$this->titulosm[9]="Diferencia";

				$this->titulosm[10]="Total";




		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=70;
		$this->anchos[4]=50;
		$this->anchos[5]=45;
		$this->anchos[6]=25;
	}


function Header()
		{
			    $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);

			    $this->SetWidths(array($this->anchos[3],$this->anchos[3]));
    	        $this->SetAligns(array("C","C",));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[40],$this->titulosm[50]));
                $this->Ln();

    	        $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	        $this->SetAligns(array("C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3]));
                $this->Ln(0.5);
                $this->SetWidths(array($this->anchos[4],$this->anchos[4],$this->anchos[4],$this->anchos[4]));
    	        $this->SetAligns(array("C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7]));
		}

function Cuerpo()

		{

	    $reg=1;
		$tippag="";
		$reffac="";
		$reg1=1;
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
           {

             $reg++;
               if($dato["tippag"]!=$tippag)
             {

    	        $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	        $this->SetAligns(array("C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($dato["tippag"],$dato["desconpag"],$dato["reffac"],$dato["monpag"]));
                $this->Ln(0.5);
                $this->arrp1 = $this->facciecaj->sqlp1($dato["reffac"]);

              foreach($this->arrp1 as $dato1)

                {
                     $monto=0;
                    if($dato1["tippag"]!=$tippag)
                      {
                       	$this->SetWidths(array($this->anchos[4],$this->anchos[4],$this->anchos[4],$this->anchos[4]));
    	                $this->SetAligns(array("C","C","C","C"));
    	                $this->setBorder(0);
    	                $this->RowM(array($dato1["reffac"],$dato1["nomban"],$dato1["numero"],$dato1["monfac"]));
                        $monto=$dato1["monfac"];

                       }
                     $total=$total+$monto;


                   }
                         $this->SetWidths(array($this->anchos[2],$this->anchos[3],$this->anchos[5]));
    	        		 $this->SetAligns(array("C","C","C"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$this->titulosm[10],$total));


            if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

           }//if primer foreach
       }//foreach

                         $this->SetWidths(array($this->anchos[2]));
    	        		 $this->SetAligns(array("C"));
    	        		 $this->setBorder(0);
    	        		 $this->Row(array($this->titulosm[60]));
    	        		 $this->Ln();
    	        		 $this->SetWidths(array($this->anchos[4],$this->anchos[4],$this->anchos[4]));
    	                 $this->SetAligns(array("C","C","C"));
    	                 $this->setBorder(0);
    	                 $this->RowM(array($this->titulosm[30],$this->titulosm[8],$this->titulosm[9]));

    	                 $this->SetWidths(array($this->anchos[4],$this->anchos[4],$this->anchos[4]));
    	                 $this->SetAligns(array("C","C","C","C"));
    	                 $this->setBorder(0);
    	                 $this->RowM(array($dato1["desarq"],$dato1["montarq"],$dato1["diferencia"]));

 }//cuerpo


}//fin de la clase
?>
