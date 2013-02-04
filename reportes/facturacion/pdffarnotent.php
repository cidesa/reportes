<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farnotent.class.php");

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

            $this->codartdes=H::GetPost("codartdes");
			$this->codarthas=H::GetPost("codarthas");

			$this->fechades=H::GetPost("fechades");
			$this->fechahas=H::GetPost("fechahas");

			$this->estatus=H::GetPost("estatus");
			$this->tipnota=H::GetPost("tipnota");

			$this->status=$this->verificar_status();
			$this->tiponota=$this->verificar_condicion();

			$this->farnotent = new Farnotent();
		    $this->arrp = $this->farnotent->sqlp($this->coddes,$this->codhas,$this->codclides,$this->codclihas,$this->codartdes,$this->codarthas,$this->fechades,$this->fechahas,$this->status,$this->tiponota);

			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{

				$this->titulosm[30]="";
				$this->titulosm[0]="Cod.Cliente";
				$this->titulosm[1]="Nombre/R. Social";
				$this->titulosm[2]="Nro.N/Entrega";
				$this->titulosm[3]="Descripcion";
                $this->titulosm[4]="Fecha";
				$this->titulosm[5]="Estatus";
				$this->titulosm[6]="Referencia";
				$this->titulosm[7]="Tipo";

				$this->titulosm[8]="Cod.Articulo";
				$this->titulosm[9]="Desc.Articulo";
				$this->titulosm[10]="Nro. Lote";
				$this->titulosm[11]="Cantidad Solicitada";
				$this->titulosm[12]="Cantidad Entregada";
                $this->titulosm[13]="Cantidad Despachada";
				$this->titulosm[14]="Cantidad Ajustada";
				$this->titulosm[15]="Cantidad Devuelta";
				$this->titulosm[16]="Cantidad Total";
				$this->titulosm[17]="Precio";
				$this->titulosm[18]="Total";

				$this->titulosm[19]="Nota Entrega";
				$this->titulosm[20]="TOTALES";


		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=70;
		$this->anchos[4]=35;
		$this->anchos[5]=30;
		$this->anchos[6]=25;
		$this->anchos[7]=40;
		$this->anchos[8]=40;
		$this->anchos[9]=20;
		//$this->anchos[10]=5;
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

		if    ($this->tipnota=='DONACIONES'){
			  $this->nota='D';


		}else if ($this->tipnota=='OTROS'){
			      $this->nota='O';

		}
		return $this->nota;
		}

function Header()
		{
			    $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","B",8);


		}

function Cuerpo()

		{

	    $reg=1;
		$codpro="";
		$codart="";
		$nronot="";
		$reg1=1;
		$registro=count($this->arrp);
		//$this->fact = new Farnotent();
		//H::PrintR($this->arrp);
		foreach($this->arrp as $dato)
           {

             $reg++;
               if($dato["codcli"]!=$codpro)
             {
               $this->setFont("Arial","B",9);
                $this->SetWidths(array($this->anchos[6],$this->anchos[4]));
    	        $this->SetAligns(array("C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1]));
                $this->Ln(0.5);
                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[6],$this->anchos[4]));
    	        $this->SetAligns(array("C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($dato["codcli"],$dato["nompro"]));
                $this->Ln();

                $codpro=$dato["codcli"];
                $this->arrp1 = $this->farnotent->sqlp2($codpro);
                $registro1=count($this->arrp1);

                $precio=0;$total=0;$descuento=0;$recargo=0;
                foreach($this->arrp1 as $dato1)

                {

                    if($dato1["nronot"]!=$nronot)
                      {
                      $this->setFont("Arial","B",9);
                      $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[7],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	              $this->SetAligns(array("C","C","C","C","C","C"));
    	              $this->setBorder(0);
    	              $this->RowM(array($this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7]));
                      $this->Ln(0.5);
                      $this->setFont("Arial","",9);
                      $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[7],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	              $this->SetAligns(array("C","C","C","C","C","C"));
    	              $this->setBorder(0);
    	              $this->RowM(array($dato1["nronot"],$dato1["desnot"],$dato1["fecnot"],$dato1["status"],$dato1["codref"],$dato1["tipref"]));
                      $nronot=$dato1["nronot"];
                      $this->arrp2 = $this->farnotent->sqlp3($nronot);
                      // H::PrintR($this->arrp2);
                      foreach($this->arrp2 as $dato2)

                             {

                              if($dato2["codart"]!=$codart)
                             {

						        $montototal=0;
                              	$precio=$precio+$dato1["preart"];
                       	        $total=$total+ $dato1["TOTART"];

                            	$cansolicitada=$cansolicitada+$dato2["cansol"];
                            	$canentregada=$canentregada+$dato2["cantent"];
                            	$candespachada=$candespachada+$dato2["cantdes"];
                            	$canajustada=$canajustada+$dato2["cantaju"];
                            	$candevuelta=$candevuelta+$dato2["cantdev"];
                            	$cantotal=$cantotal+$dato2["cantot"];
                            	$montototal=$dato2["preart"]*$dato2["cantot"];
                               // H::PrintR($montototal);
                                 $this->setFont("Arial","B",9);
						         $this->SetWidths(array($this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	                         $this->SetAligns(array("C","C","C","C","C","C"));
    	                         $this->setBorder(0);
    	                         $this->RowM(array($this->titulosm[8],$this->titulosm[9],$this->titulosm[10],$this->titulosm[11],$this->titulosm[12],$this->titulosm[13],$this->titulosm[14],$this->titulosm[15],$this->titulosm[16],$this->titulosm[17],$this->titulosm[18]));
                                 $this->Ln(0.5);
                                 $this->setFont("Arial","",9);
                        		 $this->SetWidths(array($this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	                		 $this->SetAligns(array("C","C","C","C","C","C"));
    	               		     $this->setBorder(0);
    	                 		 $this->RowM(array($dato2["codart"],$dato2["desart"],$dato2["numlot"],$dato2["cansol"],$$dato2["cantent"],$dato2["cantdes"],$dato2["cantaju"],$dato2["cantdev"],$dato2["cantot"],$dato2["preart"],$montototal));
                             }

                               $totalsolicitado=$totalsolicitado+$cansolicitada;
                               $totalentregado=$totalentregado+$canentregada;
                               $totaldespachado=$totaldespachado+$candespachada;
                               $totalajustado=$totalajustado+$canajustada;
                               $totaldevuelta=$totaldevuelta+$candevuelta;
                               $totalcantotal=$totalcantotal+$cantotal;
                               $totalmontotal=$totalmontotal+$montototal;
                       }
                         $this->Ln();
                         $this->setFont("Arial","B",9);
                         $this->SetWidths(array($this->anchos[8],$this->anchos[5],$this->anchos[5],$this->anchos[6],$this->anchos[6],$this->anchos[9],$this->anchos[9],$this->anchos[5],$this->anchos[6],$this->anchos[6]));
    	        		 $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$this->titulosm[19],$cansolicitada,$canentregada,$candespachada,$canajustada,$candevuelta,$cantotal,$this->titulosm[30],$montototal));

               }



                }


           }//if primer foreach
       }//foreach
                         $this->Ln();
                         $this->SetWidths(array($this->anchos[8],$this->anchos[5],$this->anchos[5],$this->anchos[6],$this->anchos[6],$this->anchos[9],$this->anchos[9],$this->anchos[5],$this->anchos[6],$this->anchos[6]));
    	        		 $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$this->titulosm[20],$totalsolicitado,$totalentregado,$totaldespachado,$totalajustado,$totaldevuelta,$totalcantotal,$this->titulosm[30],$totalmontotal));

            if ($reg<=$registro)
		        {
		        	$this->addpage();
		        }


 }//cuerpo


}//fin de la clase
?>
