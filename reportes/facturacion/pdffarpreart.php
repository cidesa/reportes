<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farpreart.class.php");

	class pdfreporte extends fpdf
	{

		var $bd,$y ;

		function pdfreporte()
		{
			$this->conf="l";
			$this->fpdf($this->conf,"mm","Letter");

	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();

			$this->premin=H::GetPost("premin");
			$this->premax=H::GetPost("premax");

			$this->fechamin=H::GetPost("fechamin");
			$this->fechahas=H::GetPost("fechamax");

			$this->codclides=H::GetPost("codclides");
			$this->codclihas=H::GetPost("codclihas");

			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");


			$this->farpreart = new Farpreart();
		    $this->arrp = $this->farpreart->sqlp($this->premin,$this->premax,$this->codclides,$this->codclihas,$this->fechamin,$this->fechahas,$this->coddes,$this->codhas);
			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{

				$this->titulosm[100]="Total Presupuestado";
				$this->titulosm[200]="TOTALES";

				$this->titulosm[0]="Cod. Cliente";
				$this->titulosm[1]="NombreCliente";
				$this->titulosm[2]="Nro. Presupuesto";
				$this->titulosm[3]="Descripcion";
                $this->titulosm[4]="Fecha";

				$this->titulosm[5]="Cod. Articulo";
				$this->titulosm[6]="Unid.Medida";
				$this->titulosm[7]="Cant.Solicitada";
				$this->titulosm[8]="Precio";
				$this->titulosm[9]="Total";
				$this->titulosm[10]="          ";
		}

	function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=120;
		$this->anchos[3]=52;
		$this->anchos[4]=40;
		$this->anchos[5]=30;
		$this->anchos[6]=35;
		$this->anchos[7]=25;
		$this->anchos[8]=28;
		$this->anchos[9]=23;
	    $this->anchos[11]=36;
	}

	function Header()
		{
			    $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);
			    $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	        $this->SetAligns(array("C","C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4]));
                 $this->Ln(0.5);
                $this->SetWidths(array($this->anchos[3],$this->anchos[11],$this->anchos[11],$this->anchos[5],$this->anchos[5],$this->anchos[11],$this->anchos[5]));
    	        $this->SetAligns(array("L","L","L","L","L","L","L"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[10],$this->titulosm[5],$this->titulosm[3],$this->titulosm[6],$this->titulosm[7],$this->titulosm[8],$this->titulosm[9]));

                $this->Ln();



		}

	function Cuerpo()

		{

	    $TotalP=0;
	    $TotalPre=0;
	    $Totalt=0;
	    $reg=1;
		$codcli="";
		$codart="";
		$refpre="";
		$reg1=1;

		$registro=count($this->arrp);

		foreach($this->arrp as $dato)
              {

             $reg++;
             $conta=0;
             if($dato["codcli"]!=$codcli)
                 {
                $this->arrp2 =$this->farpreart->sqlp2($dato["codcli"]);
                 $codcli=$dato["codcli"];


                foreach($this->arrp2 as $dato2)

                     {

                   if($dato2["reffac"]!=$refpre)
                          {


                            if ($conta==0)
                              {
                            	$this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	                        $this->SetAligns(array("c","L","L","L","L"));
    	                        $this->setBorder(0);
    	                        $this->RowM(array($dato["codcli"],$dato["nompro"],$dato2["reffac"],$dato2["despre"],$dato2["fecpre"]));
                            }
                            else
                               {
                                $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	                        $this->SetAligns(array("L","L","L","L","L"));
    	                        $this->setBorder(0);
    	                        $this->RowM(array($this->titulosm[10],$this->titulosm[10],$dato2["reffac"],$dato2["despre"],$dato2["fecpre"]));
                            }
                            $this->Ln();
                            $conta++;
                         $this->arrp1 =$this->farpreart->sqlp1($dato2["reffac"]);
                         $registro1=count($this->arrp1);

                    $precio=0;$total=0;$descuento=0;$recargo=0;
                  //H::PrintR($this->arrp1);



                  foreach($this->arrp1 as $dato1)

                     {

                     if($dato1["codart"]!=$codart)
                          {

                       	$precio=$precio+$dato1["precio"];
                       	$total=$total+ $dato1["totart"];
                       	$presupuestado=$presupuestado+$dato1["cansol"];
                       	$this->SetWidths(array($this->anchos[3],$this->anchos[5],$this->anchos[4],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	                $this->SetAligns(array("L","L","L","R","R","R","R"));
    	                $this->setBorder(0);
    	                $this->Row(array($this->titulosm[10],$dato1["codart"],$dato1["desart"],$dato1["unimed"],H::FormatoMonto($dato1["cansol"]),H::FormatoMonto($dato1["precio"]),H::FormatoMonto($dato1["totart"])));
                        $this->Ln();
                         }

                        $TotalP=$TotalP+$presupuestado;
                        $TotalPre=$TotalPre+$precio;
                        $Totalt=$Totalt+$total;

                      }
                        $this->setFont("Arial","B",9);
                        $this->SetWidths(array($this->anchos[3],$this->anchos[5],$this->anchos[5],$this->anchos[4],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	                $this->SetAligns(array("L","L","L","R","R","R","R"));
    	                $this->setBorder(0);
    	                $this->RowM(array($this->titulosm[10],$this->titulosm[10],$this->titulosm[10],$this->titulosm[100],H::FormatoMonto($presupuestado),H::FormatoMonto($precio),H::FormatoMonto($total)));
                        $this->Ln(0.5);


            if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

                          }//if foreach para el numero de presupuesto

                          }//foreach para el numero de presupuesto


            }//if primer foreach

       }//foreach

                        $this->setFont("Arial","B",9);
                        $this->SetWidths(array($this->anchos[3],$this->anchos[5],$this->anchos[5],$this->anchos[4],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	                $this->SetAligns(array("L","L","L","R","R","R","R"));
    	                $this->setBorder(0);
    	                $this->RowM(array($this->titulosm[10],$this->titulosm[10],$this->titulosm[10],$this->titulosm[200],H::FormatoMonto($TotalP),H::FormatoMonto($TotalPre),H::FormatoMonto($Totalt)));

 }//cuerpo


}//fin de la clase
?>
