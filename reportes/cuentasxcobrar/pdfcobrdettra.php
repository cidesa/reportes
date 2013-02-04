<?php
      require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
      require_once("../../lib/modelo/sqls/cuentasxcobrar/Cobrdettra.class.php");

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

            $this->tipmovdes=H::GetPost("tipmovdes");
			$this->tipmovhas=H::GetPost("tipmovhas");

			$this->tipclides=H::GetPost("tipclides");
			$this->tipclihas=H::GetPost("tipclihas");

			$this->cobrdettra = new Cobrdettra();
		    $this->arrp = $this->cobrdettra->sqlp($this->coddes,$this->codhas,$this->codclides,$this->codclihas,$this->fechamin,$this->fechamax,$this->tipmovdes,$this->tipmovhas,$this->tipclides,$this->tipclihas);
            //H::PrintR($this->arrp);
			$this->llenartitulosmaestro();
			$this->llenaranchos();



		}

	function llenartitulosmaestro()
		{
                //$this->titulosm=array();
				$this->titulosm[0]="Nro.Trasaccion";
				$this->titulosm[1]="Fecha";
				$this->titulosm[2]="Descripción";
				$this->titulosm[3]="Cliente";
				$this->titulosm[4]="Movimiento";
				$this->titulosm[5]="Monto";

				$this->titulosm[6]="Referencia del Documento";
				$this->titulosm[7]="Abono";
				$this->titulosm[8]="Retenciones";
				$this->titulosm[9]="Recargo";
				$this->titulosm[10]="Total";

				$this->titulosm[99]="";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=70;
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
		$numtra="";
		$codtipo="";
		$refdoc="";
        $coccli="";
		$registro=count($this->arrp);

		$totfacpago=0;$totfacdescuento=0;$totfacrecargo=0;$totfactotal=0;

		foreach($this->arrp as $dato)

            {
             $reg++;
			         if($dato["codtipo"]!=$codtipo)
			             {
			                $this->setFont("Arial","B",10);
				            $this->Ln();
				            $this->SetWidths(array(190));
    	                    $this->SetAligns(array("L"));
					        $this->setBorder(1);
					        $this->RowM(array("TIPO: ".$dato["tipo"]));
						    $this->ln();
				            $codtipo=$dato["codtipo"];
				            $this->setFont("Arial","",9);

				          }

				          if ($dato["codpro"]!=$coccli){

    	                $this->Ln();
                        $this->SetWidths(array(50,140));
    	                $this->SetAligns(array("L","L"));
    	                $this->setBorder(1);
    	                $this->setFont("Arial","B",10);
    	                $this->RowM(array('Codigo: '.$dato["codpro"],'Nombre: '.$dato["nomcli"]));
    	                $this->setFont("Arial","",9);
    	                $coccli=$dato["codpro"];

				          }


                       $this->arrp1 = $this->cobrdettra->sqlp1($dato["numtra"],$codtipo,$dato["codpro"]);

                       $totclipago=0;$totclidescuento=0;$totclirecargo=0;$totclitotal=0;

                 foreach($this->arrp1 as $dato1)

                   {

                     if($dato1["numtra"]!=$numtra)
                    {
                        $numtra=$dato1["numtra"];

		                $this->Ln();
					    $this->SetWidths(array(30,30,50,50,30));
		    	        $this->SetAligns(array("C","C","C","C","C","C"));
		    	        $this->setBorder(1);
		    	        $this->setFont("Arial","B",9);
		    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],"Descripción Trasacción","Descripción Movimiento","Monto Trasacción"));
		    	        $this->setFont("Arial","",9);
		                $this->Ln();

		                $this->SetWidths(array(30,30,50,50,30));
			            $this->SetAligns(array("L","L","L","L","R"));
			            $this->setBorder(0);
			            $this->RowM(array($dato1["numtra"],$dato1["fectra"],$dato1["destra"],$dato1["desmov"],H::FormatoMonto($dato1["montra"])));

		                $this->Ln();
					    $this->SetWidths(array(31,31,31,31,31,35));
		    	        $this->SetAligns(array("C","C","C","C","C","C","C"));
		    	        $this->setBorder(1);
		    	        $this->setFont("Arial","B",9);
		    	        $this->RowM(array("Referencia de Documento","Monto Total","Pago","Descuentos","Recargo","Saldo"));
		    	        $this->setFont("Arial","",9);
		                $this->Ln();

                    $codpro=$dato1["codpro"];
                    $numtra=$dato["numtra"];
                    $this->arrp2 = $this->cobrdettra->sqlp2($dato1["numtra"],$dato1["tipcli"]);

                    $totalmondoc=0;$totalpago=0;$totaldescuento=0;$totalrecargo=0;$totaltotal=0;
                    $totfacpago=0;$totfacdescuento=0;$totfacrecargo=0;$totfactotal=0;
                    foreach($this->arrp2 as $dato2)

                   {
                  //$reg++;
                     if($dato2["refdoc"]!=$refdoc)
                    {
                    $totalmondoc=$totalmondoc+$dato2["mondoc"];
                    $totalpago=$totalpago+$dato2["pago"];
                    $totaldescuento=$totaldescuento+$dato2["descuento"];
                    $totalrecargo=$totalrecargo+$dato2["recargo"];
                    $totaltotal=$totaltotal+$dato2["saldoc"];

                    $this->SetWidths(array(31,31,31,31,31,35));
    	            $this->SetAligns(array("C","R","R","R","R","R"));
    	            $this->setBorder(0);
    	             $this->setFont("Arial","",9);
    	            $this->RowM(array($dato2["refdoc"],H::FormatoMonto($dato2["mondoc"]),H::FormatoMonto($dato2["pago"]),H::FormatoMonto($dato2["descuento"]),H::FormatoMonto($dato2["recargo"]),H::FormatoMonto($dato2["saldoc"])));

                     if ($this->GetY()>250)
		                 {
					        $this->addpage();

					        $this->Ln();
						    $this->SetWidths(array(190));
			    	        $this->SetAligns(array("C"));
			    	        $this->setBorder(0);
			    	        $this->RowM(array("CONTINUACIÓN"));

					        $this->Ln();
						    $this->SetWidths(array(30,30,50,50,30));
			    	        $this->SetAligns(array("C","C","C","C","C","C"));
			    	        $this->setBorder(1);
			    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],"Descripción Trasacción","Descripción Movimiento","Monto Trasacción"));
			                $this->Ln();

			                $this->SetWidths(array(30,30,50,50,30));
				            $this->SetAligns(array("L","L","L","L","R"));
				            $this->setBorder(0);
				            $this->RowM(array($dato1["numtra"],$dato1["fectra"],$dato1["destra"],$dato1["desmov"],H::FormatoMonto($dato1["montra"])));

					        $this->Ln();
						    $this->SetWidths(array(38,38,38,38,38));
			    	        $this->SetAligns(array("C","C","C","C","C","C"));
			    	        $this->setBorder(1);
			    	        $this->RowM(array("Referencia de Documento","Pago","Descuentos","Recargo","Total"));
			                $this->Ln();

		                 }//FIN SALTO DE PAGINA
                    }

                    $totclimondoc=$totclimondoc+$totalmondoc;
                    $totclipago=$totclipago+$totalpago;
                    $totclidescuento=$totclidescuento+$totaldescuento;
                    $totclirecargo=$totclirecargo+$totalrecargo;
                    $totclitotal=$totclitotal+$totaltotal;

                   }
                    $this->Ln();
                    $this->SetWidths(array(31,31,31,31,31,35));
    	            $this->SetAligns(array("C","R","R","R","R","R"));
    	            $this->setBorder(1);
    	            $this->RowM(array("TOTAL: ",H::FormatoMonto($totalmondoc),H::FormatoMonto($totalpago),H::FormatoMonto($totaldescuento),H::FormatoMonto($totalrecargo),H::FormatoMonto($totaltotal)));
    	            $totclimondocd=$totclimondocd+$totalmondoc;
    	            $totclipagod=$totclipagod+$totalpago;
                    $totclidescuentod=$totclidescuentod+$totaldescuento;
                    $totclirecargod=$totclirecargod+$totalrecargo;
                    $totclitotald=$totclitotald+$totaltotal;
                    $totalmondoc=0;$totalpago=0;$totaldescuento=0;$totalrecargo=0;$totaltotal=0;
                   }
                    $totfacmondoc=$totfacmondoc+$totclimondoc;
                   $totfacpago=$totfacpago+$totclipago;
                   $totfacdescuento=$totfacdescuento+$totclidescuento;
                   $totclirecargo=$totclirecargo+$totalrecargo;
                   $totfactotal=$totfactotal+$totaltotal;

               /*    $totfacpago=$totfacpago+$totalpago;
                   $totfacdescuento=$totfacdescuento+$totaldescuento;
                   $totclirecargo=$totclirecargo+$totalrecargo;
                   $totfactotal=$totfactotal+$totaltotal;*/

                    }//despues de aqui

                // } FIN DEL PRIMER IF
            }
                    $this->Ln();
                   $this->SetWidths(array(31,31,31,31,31,35));
    	            $this->SetAligns(array("C","R","R","R","R","R"));
    	            $this->setBorder(1);
    	            //$this->RowM(array("TOTAL GENERAL: ",H::FormatoMonto($totfacpago),H::FormatoMonto($totfacdescuento),H::FormatoMonto($totclirecargo),H::FormatoMonto($totfactotal)));
    	             $this->RowM(array("TOTAL GENERAL: ",H::FormatoMonto($totclimondocd),H::FormatoMonto($totclipagod),H::FormatoMonto($totclidescuentod),H::FormatoMonto($totclirecargod),H::FormatoMonto($totclitotald)));

    	            $totfacpago=0;
    	            $totfacdescuento=0;
    	            $totclirecargo=0;
    	            $totfactotal;

			if ($reg<=$registro)
	        {
	        	$this->addpage();
	        }

		}

}//fin de la clase
?>
