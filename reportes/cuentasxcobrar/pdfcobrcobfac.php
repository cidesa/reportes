<?
      require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
      require_once("../../lib/modelo/sqls/cuentasxcobrar/Cobrcobfac.class.php");

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

			$this->codfacdes=H::GetPost("codfacdes");
			$this->codfachas=H::GetPost("codfachas");

			$this->fechamin=H::GetPost("fechamin");
			$this->fechamax=H::GetPost("fechamax");

			$this->tipclides=H::GetPost("tipclides");
			$this->tipclihas=H::GetPost("tipclihas");



			$this->cobrcobfac = new Cobrcobfac();
		    $this->arrp = $this->cobrcobfac->sqlp($this->coddes,$this->codhas,$this->codclides,$this->codclihas,$this->codfacdes,$this->codfachas,$this->fechamin,$this->fechamax,$this->tipclides,$this->tipclihas);
            //H::PrintR($this->arrp);
			$this->llenartitulosmaestro();
			$this->llenaranchos();



		}

	function llenartitulosmaestro()
		{
                //$this->titulosm=array();
				$this->titulosm[0]="Transacción";
				$this->titulosm[1]="Fecha";
				$this->titulosm[2]="Descripción";
				$this->titulosm[3]="Cliente";
				$this->titulosm[4]="Monto";
				$this->titulosm[5]="Tipo de Cliente";
				$this->titulosm[6]="Referencia del Abono";
				$this->titulosm[7]="Abono";
				$this->titulosm[8]="Descuento";
				$this->titulosm[9]="Recargo";
				$this->titulosm[10]="Total";

				$this->titulosm[100]="Totales por Transacciones";
				$this->titulosm[200]="Totales por Tipo Cliente";
				$this->titulosm[300]="Totales Generales";
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
		$codtipo="";
		$codcli="";
		$refdoc="";
		$numtra="";
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
			if ($dato["codcli"]!=$coccli)
				{
				$this->Ln();
			    $this->SetWidths(array(30,30,50,50,30));
    	        $this->SetAligns(array("C","C","C","C","R"));
    	        $this->setBorder(1);
    	        $coccli=$dato["codcli"];
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4]));
       			}
                  $this->arrp1 = $this->cobrcobfac->sqlp1($dato["numtra"],$codtipo,$dato["codcli"]);
                  $totclipago=0;$totclidescuento=0;$totclirecargo=0;$totclitotal=0;
                 foreach($this->arrp1 as $dato1)
                   {
                       if($dato1["numtra"]!=$numtra)
                    {
                    $numtra=$dato1["numtra"];
                    $this->SetWidths(array(30,30,50,50,30));
    	            $this->SetAligns(array("C","C","L","L","R"));
    	            $this->setBorder(1);
    	            $this->RowM(array($dato1["numtra"],$dato1["fecha"],$dato1["destra"],$dato1["nombre"],H::FormatoMonto($dato1["mondocfrom"])));
                    $codcli=$dato1["codcli"];
                    $this->arrp2 = $this->cobrcobfac->sql2($dato1["refdoc"],$dato1["codcli"]);
                    $totalpago=0;$totaldescuento=0;$totalrecargo=0;$totaltotal=0;
                    $this->ln();
                    $this->SetWidths(array(38,38,38,38,38));
    	            $this->SetAligns(array("C","C","C","C","C"));
    	            $this->setBorder(1);
    	            $this->RowM(array("Nro. de Factura","Pago","Descuento","Recargo","Total"));
                    $this->ln();
                    foreach($this->arrp2 as $dato2)
                   {
                     if($dato2["refdoc"]!=$refdoc)
                    {
                    $totalpago=$totalpago+$dato2["pago"];
                    $totaldescuento=$totaldescuento+$dato2["descuento"];
                    $totalrecargo=$totalrecargo+$dato2["recargo"];
                    $totaltotal=$totaltotal+$dato2["total"];
                    $this->SetWidths(array(38,38,38,38,38));
    	            $this->SetAligns(array("C","R","R","R","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array($dato2["refdoc"],H::FormatoMonto($dato2["pago"]),H::FormatoMonto($dato2["descuento"]),H::FormatoMonto($dato2["recargo"]),H::FormatoMonto($dato2["total"])));
                    }

                    $totclipago=$totclipago+$totalpago;
                    $totclidescuento=$totclidescuento+$totaldescuento;
                    $totclirecargo=$totclirecargo+$totalrecargo;
                    $totclitotal=$totclitotal+$totaltotal;

                   }
                    $this->Ln();
                    $this->SetWidths(array(38,38,38,38,38));
    	            $this->SetAligns(array("R","R","R","R","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array($this->titulosm[100],H::FormatoMonto($totalpago),H::FormatoMonto($totaldescuento),H::FormatoMonto($totalrecargo),H::FormatoMonto($totaltotal)));
 					$this->Ln();

                   }

                   $totfacpago=$totfacpago+$totclipago;
                   $totfacdescuento=$totfacdescuento+$totclidescuento;
                   $totclirecargo=$totclirecargo+$totalrecargo;
                   $totfactotal=$totfactotal+$totaltotal;


                    }//despues de aqui
            }
                    $this->Ln();
                    $this->SetWidths(array(38,38,38,38,38));
    	            $this->SetAligns(array("R","R","R","R","R"));
    	            $this->setBorder(1);
    	            $this->RowM(array($this->titulosm[300],H::FormatoMonto($totfacpago),H::FormatoMonto($totfacdescuento),H::FormatoMonto($totclirecargo),H::FormatoMonto($totfactotal)));



		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

		}

}//fin de la clase
?>
