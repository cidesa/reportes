<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
      require_once("../../lib/modelo/sqls/cuentasxcobrar/Cobrdoccli.class.php");

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

			$this->codclides=H::GetPost("codclides");
			$this->codclihas=H::GetPost("codclihas");

			$this->fechamin=H::GetPost("fechamin");
			$this->fechamax=H::GetPost("fechamax");

			$this->tipclides=H::GetPost("tipclides");
			$this->tipclihas=H::GetPost("tipclihas");

			$this->cobrdoccli = new Cobrdoccli();
		    $this->arrp = $this->cobrdoccli->sqlp($this->coddes,$this->codhas,$this->codclides,$this->codclihas,$this->fechamin,$this->fechamax,$this->tipclides,$this->tipclihas);

			$this->llenartitulosmaestro();
			$this->llenaranchos();



		}

	function llenartitulosmaestro()
		{
                //$this->titulosm=array();
				$this->titulosm[0]="TIPO DE CLIENTE";
				$this->titulosm[1]="Cliente";
				$this->titulosm[2]="R.I.F";
				$this->titulosm[3]="N.I.T";
				$this->titulosm[4]="Fecha de Emisión";
				$this->titulosm[5]="Ref. del Documento";
				$this->titulosm[6]="TIPO DE CLIENTE: ";
				$this->titulosm[7]="Centro de Acopio";
				$this->titulosm[8]="Descripción de Documento";
				$this->titulosm[9]="Saldo Documento";
				$this->titulosm[10]="Saldo Acumulado";
				$this->titulosm[100]="Total por Cliente";
				$this->titulosm[200]="";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=60;
		$this->anchos[5]=30;
		$this->anchos[6]=40;
		$this->anchos[7]=20;
		$this->anchos[8]=20;
	}

function Header()
		{
				$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);


		}

function Cuerpo()

		{

	    $reg=1;
		$codtipo="";
		$codpro="";
		$refdoc="";
		$referencia="";
		$codproma=$this->arrp[0]["codpro"];
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)

            {

             $reg++;
             if($dato["codtipo"]!=$codtipo)
                 {

                $this->SetWidths(array($this->anchos[2]));
    	        $this->SetAligns(array("L"));
    	        $this->setBorder(1);
    	         $this->setFont("Arial","B",10);
    	        $this->RowM(array($this->titulosm[0].': '.$dato["tipo"]));
    	         $this->setFont("Arial","",9);
			    $this->Ln();
                $codtipo=$dato["codtipo"];}


                $this->arrp1 = $this->cobrdoccli->sqlp1($dato["codpro"],$codtipo);

                        $monto=0;
                        $this->Ln();
                        $this->SetWidths(array(100,40,40));
    	                $this->SetAligns(array("L","L","L","L","L","L"));
    	                $this->setBorder(1);
    	                $this->RowM(array($this->titulosm[1].': '.$this->arrp1[0]["nompro"],$this->titulosm[2].': '.$this->arrp1[0]["rifpro"],$this->titulosm[3].': '.$this->arrp1[0]["nitpro"]));
                        $this->Ln();
                        $this->codpro=$dato["codpro"];
						//por cada proveedor se imprime el titulo del detalle
                       $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[5]));
    	               $this->SetAligns(array("L","L","L","C"));
    	               $this->setBorder(0);
    	                 $this->setFont("Arial","B",9);
    	               $this->RowM(array($this->titulosm[4],$this->titulosm[5],'Descripción','Saldo'));
    	               $this->line(10,$this->GetY(),180,$this->GetY());
    	                 $this->setFont("Arial","",9);

    	                $codproma=$dato["codpro"];

                 foreach($this->arrp1 as $dato1)//muestra el detalle
                   {
                     if($dato1["referencia"]!=$referencia)
                      {
                       $referencia=$dato1["referencia"];
                       $this->arrp2 = $this->cobrdoccli->sqlp2($this->codpro,$dato1["referencia"]);
                          foreach($this->arrp2 as $dato2)
		                   {
		                    $monto=$monto+$dato2["mondoc"];
		                    $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[5]));
		    	            $this->SetAligns(array("L","L","L","R"));
		    	            $this->setBorder(0);
		    	            $this->RowM(array($dato2["fecha"],$dato2["referencia"],$dato2["descripcion"],H::FormatoMonto($dato2["mondoc"])));
		                    $refdoc=$dato2["referencia"];
		                   }//foreach $dato2
                      }//if dato1

                    }//foreach $dato1
                    $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[7],$this->anchos[5]));
    	            $this->SetAligns(array("L","L","L","C","L","R"));
    	            $this->setBorder(0);
    	            $this->setFont("Arial","B",9);
    	             $this->SetAligns(array("L","L","L","C","R"));
    	            $this->RowM(array($this->titulosm[200],$this->titulosm[200],$this->titulosm[100],'',H::FormatoMonto($monto)));
    	            $totmonto=$totmonto+$monto;
    	            $monto=0;
    	            $this->setFont("Arial","",9);

            }//el foreach grande

                    $this->setFont("Arial","B",11);
                    $this->ln();

                    $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[7],$this->anchos[5]));
    	            $this->SetAligns(array("L","L","L","C","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array($this->titulosm[200],$this->titulosm[200],"Total General",'',H::FormatoMonto($totmonto)));


		if ($reg<$registro)
		        {
		        	$this->addpage();
		       }

		}

}//fin de la clase
?>
