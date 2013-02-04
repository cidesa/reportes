<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farmercon.class.php");

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

			$this->condes=H::GetPost("condes");
			$this->conhas=H::GetPost("conhas");

			$this->codprodes=H::GetPost("codprodes");
			$this->codprohas=H::GetPost("codprohas");

			$this->codartdes=H::GetPost("codartdes");
			$this->codarthas=H::GetPost("codarthas");

			$this->codalmdes=H::GetPost("codalmdes");
			$this->codalmhas=H::GetPost("codalmhas");

			$this->fechades=H::GetPost("fechades");
			$this->fechahas=H::GetPost("fechahas");

			$this->estatus=H::GetPost("estatus");

			$this->status=$this->verificar_status();

			$this->farmercon = new Farmercon();
		    $this->arrp = $this->farmercon->sqlp($this->condes,
		                                         $this->conhas,
		                                         $this->ccodprodes,
		                                         $this->codprohas,
		                                         $this->codartdes,
		                                         $this->codarthas,
		                                         $this->fechades,
		                                         $this->fechahas,
		                                         $this->status);

			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{

				$this->titulosm[30]="";
				$this->titulosm[0]="Cod.Cliente";
				$this->titulosm[1]="Nombre/R. Social";
				$this->titulosm[2]="Nro.Recepcion";
				$this->titulosm[3]="Descripcion";
				$this->titulosm[4]="Factura";
                $this->titulosm[5]="Fecha";
				$this->titulosm[6]="Estatus";
				$this->titulosm[7]="Forma Despacho";
				$this->titulosm[8]="Descripcion";

				$this->titulosm[9]="Cod.Articulo";
				$this->titulosm[10]="Desc.Articulo";
				$this->titulosm[11]="U/Medida";
				$this->titulosm[12]="Cantidad Solicitada";
				$this->titulosm[13]="Cantidad Despachada";
                $this->titulosm[14]="Cantidad Devuelta";
				$this->titulosm[15]="Precio";
				$this->titulosm[16]="Total";

				$this->titulosm[17]="Total Factura";
				$this->titulosm[18]="TOTALES";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=80;
		$this->anchos[4]=35;
		$this->anchos[5]=30;
		$this->anchos[6]=25;
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

function Header()
		{
			    $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);
			    $this->SetWidths(array($this->anchos[6],$this->anchos[4],$this->anchos[5],$this->anchos[5],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[4]));
    	        $this->SetAligns(array("C","C","C","C","C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7],$this->titulosm[8]));
                $this->Ln(1);
                $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[4],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[4]));
    	        $this->SetAligns(array("C","C","C","C","C","C","C","C"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[30],$this->titulosm[9],$this->titulosm[10],$this->titulosm[11],$this->titulosm[12],$this->titulosm[13],$this->titulosm[14],$this->titulosm[15],$this->titulosm[16]));
                $this->Ln();

		}

function Cuerpo()

		{

	    $reg=1;
		$codpro="";
		$codart="";
		$reg1=1;
		$registro=count($this->arrp);
		$this->fact = new Farmercon();
		foreach($this->arrp as $dato)
           {

             $reg++;
               if($dato["codpro"]!=$codpro)
             {
                 $this->SetWidths(array($this->anchos[6],$this->anchos[4],$this->anchos[5],$this->anchos[5],$this->anchos[6],$this->anchos[6],$this->anchos[5],$this->anchos[5]));
    	         $this->SetAligns(array("C","C","C","C","C","C","C","C"));
    	         $this->setBorder(0);
    	         $this->RowM(array($dato["codpro"],$dato["nompro"],$dato["CONMER"],$dato["DESCON"],$dato["fecfac"],$dato["status"],$dato["tipref"],$dato["MONDESC"],$dato["MONFAC"]));
                 $this->Ln();

                $registro1=count($this->arrp1);

                $precio=0;$total=0;$descuento=0;$recargo=0;
                foreach($this->arrp1 as $dato1)

                {

                    if($dato1["codart"]!=$codart)
                      {
                       	$montototal=0;
                       	$precioarticulo=0;

                       	$total=$total+ $dato1["TOTART"];

                       	$candespachada=$candespachada+$dato["no definido"];
                       	$candevuelta=$candevuelta+$dato["candev"];

                       	$cansol=$cansol+$dato["cantot"];
                        if ($dato1["canrec"]>0)
                        {
                        $precioarticulo=$dato1["preart"]/$dato1["canrec"];
                        }

                         $this->SetWidths(array($this->anchos[3],$this->anchos[5],$this->anchos[4],$this->anchos[6],$this->anchos[6],$this->anchos[6],$this->anchos[5],$this->anchos[4]));
    	        		 $this->SetAligns(array("C","C","C","C","C","C","C","C"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$dato1["codart"],$dato["desart"],$dato1["unimed"],"","",$dato1["candev"],$precioarticulo,$dato1["TOTART"]));

                       }
                     $totalsolicitado=$totalsolicitado+$cansol;
                     $totaldespachada=$totaldespachada+$candespachada;
                     $totaldevuelta=$totaldevuelta+$candevuelta;
                     $totalprecio=$totalprecio+$precioarticulo;
                     $totaltotal=$totaltotal+$total;

               }

                         $this->SetWidths(array($this->anchos[3],$this->anchos[5],$this->anchos[4],$this->anchos[6],$this->anchos[5]));
    	        		 $this->SetAligns(array("C","C","C","C","C"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$this->titulosm[17],$candespachada,$candevuelta,$total));




            if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

           }//if primer foreach
       }//foreach

                         $this->SetWidths(array($this->anchos[3],$this->anchos[5],$this->anchos[4],$this->anchos[6],$this->anchos[6]));
    	        		 $this->SetAligns(array("C","C","C","C","C"));
    	        		 $this->setBorder(0);
    	        		 $this->RowM(array($this->titulosm[30],$this->titulosm[18],$totaldespachada,$totaldevuelta,$totaltotal));


 }//cuerpo


}//fin de la clase
?>