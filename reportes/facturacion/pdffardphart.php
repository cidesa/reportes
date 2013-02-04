<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Fardphart.class.php");

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
			$this->codalmhas=H::GetPost("codalmhas");

			$this->codalmdes=H::GetPost("codalmdes");
			$this->codarthas=H::GetPost("codarthas");

			$this->fechades=H::GetPost("fechades");
			$this->fechahas=H::GetPost("fechahas");

			$this->estatus=H::GetPost("estatus");
			$this->tiprefe=H::GetPost("tiprefe");

			$this->status=$this->verificar_status();
			$this->tiporefe=$this->verificar_referencia();

			$this->fardphart = new Fardphart();
		    $this->arrp = $this->fardphart->sqlp($this->coddes,
		                                         $this->codhas,
		                                         $this->codclides,
		                                         $this->codclihas,
		                                         $this->codartdes,
		                                         $this->codarthas,
		                                         $this->codalmdes,
		                                         $this->codalmhas,
		                                         $this->fechades,
		                                         $this->fechahas,
		                                         $this->status,
		                                         $this->tiporefe);

			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{

				$this->titulosm[30]="";
				$this->titulosm[0]="Cod.Cliente";
				$this->titulosm[1]="Nombre/R. Social";
				$this->titulosm[2]="Nro.Despacho";
				$this->titulosm[3]="Descripcion";
                $this->titulosm[4]="Factura";
                $this->titulosm[5]="Fecha";
				$this->titulosm[6]="Estatus";
				$this->titulosm[7]="Forma Despacho";
				$this->titulosm[8]="Descripcion";

				$this->titulosm[9]="Cod.Articulo";
				$this->titulosm[10]="Desc.Articulo";
				$this->titulosm[11]="Lote";
				$this->titulosm[12]="Cantidad Solicitada";
                $this->titulosm[13]="Cantidad Despachada";
				$this->titulosm[14]="Cantidad Devuelta";
				$this->titulosm[15]="Precio";
				$this->titulosm[16]="Total";

				$this->titulosm[19]="Nota Despacho";
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
		$this->anchos[7]=20;
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

		function verificar_referencia()
		{

		if    ($this->tiprefe=='NOTAS DE ENTREGA'){
			  $this->refe='NE';


		}else if ($this->tiprefe=='REQUISICION'){
			      $this->refe='R';



		}else if ($this->tiprefe=='DEVOLUCION'){
			      $this->refe='D';

		}

		return $this->refe;
		}

function Header()
		{
			    $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","B",9);
			    $this->SetWidths(array($this->anchos[6],$this->anchos[4],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[7],$this->anchos[5],$this->anchos[6]));
    	        $this->SetAligns(array("C","C","C","C","C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7],$this->titulosm[8]));
                $this->Ln();
                $this->SetWidths(array($this->anchos[6],$this->anchos[4],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	        $this->SetAligns(array("R","R","R","R","R","R","R","R"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[30],$this->titulosm[9],$this->titulosm[10],$this->titulosm[11],$this->titulosm[12],$this->titulosm[13],$this->titulosm[14],$this->titulosm[15],$this->titulosm[16]));



		}

function Cuerpo()

		{

	    $reg=1;
		$codpro="";
		$codart="";
		$nronot="";
		$reg1=1;
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
           {

             $reg++;
               if($dato["codcli"]!=$codpro)
             {
                $this->setFont("Arial","",9);
                $this->SetWidths(array($this->anchos[6],$this->anchos[4],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	        $this->SetAligns(array("C","C","C","C","C","C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($dato["codcli"],$dato["nompro"],$dato["dphart"],$dato["desdph"],$dato["codalm"],$dato["fecdph"],$dato["stadph"],$dato["fordesp"],$dato["nomalm"]));
                $this->Ln();
                $codpro=$dato["codcli"];

                $this->arrp1 = $this->fardphart->sqlp1($codpro);
               // H::PrintR($this->arrp1);
                $registro1=count($this->arrp1);
                foreach($this->arrp1 as $dato1)

                {

                    if($dato1["codart"]!=$codart)
                      {
                       	$candespachada=$candespachada+$dato["candph"];
                       	$candevuelta=$candevuelta+$dato["candev"];
                       	$cantotal=$cantotal+$dato["cantot"];
                       	$canprecio=$canprecio+$dato["cospro"];
                       	$total=$total+$dato["montot"];

                        $articulo= $dato1["codart"];
                        $tipodespacho= $dato1["tipdph"];
                        $reg=$dato1["reqart"];

                          $this->arrp2 = $this->fardphart->sqlp2($articulo,$tipodespacho,$reg);
                          $cansolicitada=$cansolicitada+$this->arrp2[0]["canord"];
                           //H::PrintR($dato1);
                          $this->SetWidths(array($this->anchos[6],$this->anchos[4],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	                  $this->SetAligns(array("R","R","R","R","R","R","R","R","R"));
    	                  $this->setBorder(0);
    	                  $this->RowM(array($this->titulosm[30],$dato1["codart"],$dato1["desart"],$dato1["numlot"], $this->arrp2[0]["canord"],$dato1["candph"],$dato1["candev"],$dato1["cospro"],$dato1["montot"]));
                          $this->Ln();
                      }

                               $totalsolicitado=$totalsolicitado+$cansolicitada;
                               $totaldespachado=$totaldespachado+$candespachada;
                               $totaldevuelta=$totaldevuelta+$candevuelta;
                               $totalcantotal=$totalcantotal+$cantotal;
                               $totalprecio=$totalprecio+$canprecio;
                               $totaltotal=$totaltotal+$total;
                       }
                         $this->setFont("Arial","B",9);
                         $this->SetWidths(array($this->anchos[6],$this->anchos[5],$this->anchos[6],$this->anchos[5],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	        		 $this->SetAligns(array("C","C","C","C","R","R","R","R","R"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$this->titulosm[30],$this->titulosm[30],$this->titulosm[19],$cansolicitada,$candespachada,$candevuelta,$canprecio,$total));
    	              }

       }//foreach

                         $this->Ln();
                         $this->SetWidths(array($this->anchos[6],$this->anchos[4],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6]));
    	        		 $this->SetAligns(array("C","C","C","C","R","R","R","R","R"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$this->titulosm[30],$this->titulosm[30],$this->titulosm[20],$totalsolicitado,$totaldespachado,$totaldevuelta,$totalprecio,$totaltotal));

            if ($reg<=$registro)
		        {
		        	$this->addpage();
		        }


 }//cuerpo


}//fin de la clase
?>