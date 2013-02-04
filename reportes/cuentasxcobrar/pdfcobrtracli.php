<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
      require_once("../../lib/modelo/sqls/cuentasxcobrar/Cobrtracli.class.php");

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

			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");

			$this->codclides=H::GetPost("codclides");
			$this->codclihas=H::GetPost("codclihas");

			$this->fechamin=H::GetPost("fechamin");
			$this->fechamax=H::GetPost("fechamax");

            $this->codmovdes=H::GetPost("codmovdes");
			$this->codmovhas=H::GetPost("codmovhas");

			$this->tipclides=H::GetPost("tipclides");
			$this->tipclihas=H::GetPost("tipclihas");

			$this->cobrtracli = new Cobrtracli();
		    $this->arrp = $this->cobrtracli->sqlp($this->coddes,$this->codhas,$this->codclides,$this->codclihas,$this->fechamin,$this->fechamax,$this->codmovdes,$this->codmovhas,$this->tipclides,$this->tipclihas);

			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{
				$this->titulosm[0]="TIPO DE CLIENTE";
				$this->titulosm[1]="Cliente";
				$this->titulosm[2]="R.I.F";
				$this->titulosm[3]="N.I.T";
				$this->titulosm[4]="Fecha de Transaccion";
				$this->titulosm[5]="Nro. de Transaccion";
				$this->titulosm[6]="Ref. del Documento: ";
				$this->titulosm[7]="Abono";
				$this->titulosm[8]="Total Descuento";
				$this->titulosm[9]="Total Recargo";
				$this->titulosm[10]="Total Transaccion";

				$this->titulosm[100]="Totales por Cliente";
				$this->titulosm[101]="Totales Generales";

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
		$numtra="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)

            {

             $reg++;
             if($dato["tipo"]!=$codtipo)
                 {

                $this->SetWidths(array($this->anchos[2]));
    	        $this->SetAligns(array("L"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[0].''.$dato["tipo"]));
			    $this->Ln();
                $codtipo=$dato["codtipo"];
                $this->arrp1 = $this->cobrtracli->sqlp1($dato["codpro"],$codtipo);

                  $abono=0;$descuento=0;$recargo=0;$transaccion=0;
                 foreach($this->arrp1 as $dato1)

                   {
                  //$reg++;
                     if($dato1["codpro"]!=$codpro)
                    {
                    	$this->SetWidths(array($this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	                $this->SetAligns(array("C","C","C","C","C","C"));
    	                $this->setBorder(0);
    	                $this->RowM(array($this->titulosm[1].$dato1["nompro"],$this->titulosm[2].$dato1["rifpro"],$this->titulosm[3].$dato1["nitpro"]));
                        $this->Ln();
                        $codpro=$dato1["codpro"];

                       $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[6],$this->anchos[5]));
    	               $this->SetAligns(array("L","L","L","C","L","L"));
    	               $this->setBorder(0);
    	               $this->RowM(array($this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7],$this->titulosm[8]));

                       $this->arrp2 = $this->cobrtracli->sqlp2($codpro,$dato1["numtra"]);

                      $totabono=0;$totdescuento=0;$totrecargo=0;$tottransaccion=0;
                 foreach($this->arrp2 as $dato2)

                   {
                  //$reg++;
                     if($dato2["numtra"]!=$numtra)
                    {

                    $abono=$abono+$dato2["monpag"];
                    $descuento=$descuento+$dato2["mondsc"];
                    $recargo=$recargo+$dato2["mondsc"];
                    $transaccion=$transaccion+$dato2["totpag"];

                    $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[6],$this->anchos[5]));
    	            $this->SetAligns(array("L","L","L","C","L","L"));
    	            $this->setBorder(0);
    	            $this->RowM(array($dato2["fectra"],$dato2["numtra"],$dato2["refdoc"],$dato2["monpag"],$dato2["mondsc"],$dato2["monrec"],$dato2["totpag"]));
                    $numtra=$dato2["numtra"];

                    }//if
                   }//foreach

                   }//if dato1

                   $totabono=$totabono+$abono;
                   $totdescuento=$totdescuento+$descuento;
                   $totrecargo=$totrecargo+$recargo;
                   $tottransaccion=$tottransaccion+$transaccion;

                    }
                    $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[7],$this->anchos[5],$this->anchos[5]));
    	            $this->SetAligns(array("L","L","L","C","L","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array($this->titulosm[100],$abono,$this->titulosm[200],$descuento,$recargo,$transaccion));
                    $this->Ln();
                 }//if dato
            }
                    $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[3],$this->anchos[7],$this->anchos[5],$this->anchos[5]));
    	            $this->SetAligns(array("R","L","L","C","L","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array($this->titulosm[101],$totabono,$this->titulosm[200],$totdescuento,$totrecargo,$tottransaccion));

		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }
		}

}//fin de la clase
?>