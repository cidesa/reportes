<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farffactura.class.php");


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

			$this->condes=H::GetPost("condes");
			$this->conhas=H::GetPost("conhas");

			$this->fechades=H::GetPost("fechamin");
			$this->fechahas=H::GetPost("fechamax");

			$this->codfacdes=H::GetPost("codfacdes");
			$this->codfachas=H::GetPost("codfachas");
                        $this->codartdes=H::GetPost("codartdes");
                        $this->codarthas=H::GetPost("codarthas");
                        $this->codrefdes=H::GetPost("codrefdes");
                        $this->codrefhas=H::GetPost("codrefhas");
                        $this->comodin=H::GetPost("comodin");


            $this->estatus=H::GetPost("estatus");
			$this->plazo=H::GetPost("dias");

			$this->status=$this->verificar_status();

			$this->farffactura = new Farffactura();
		    $this->arrp = $this->farffactura->sqlp($this->fechades,$this->fechahas,$this->estatus,$this->condes,$this->conhas,$this->codfacdes,$this->codfachas,$this->plazo,$this->codartdes,$this->codarthas,$this->codrefdes,$this->codrefhas,$this->comodin);


			$this->verificar_status();
			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{

				$this->titulosm[0]="Cod.Cliente: ";
				$this->titulosm[1]="Rif.Cliente: ";
				$this->titulosm[2]="Nit.Cliente: ";
				$this->titulosm[3]="Direccion: ";

                                $this->titulosm[4]="Cod. Articulo";
				$this->titulosm[5]="Descripcion";
				$this->titulosm[6]="Nota Desp.";
                                $this->titulosm[7]="Cantidad";
				$this->titulosm[8]="Precio/Unitario";
				$this->titulosm[9]="Sub Total";
              //  $this->titulosm[9]="Nombre Cliente: ";


		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=70;
		$this->anchos[4]=40;
           	$this->anchos[5]=30;
                $this->anchos[6]=10;
                $this->anchos[7]=25;
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

		}

function Cuerpo()

		{
	    $reg=1;
		$codpro="";
		$codart="";
		$reg1=1;
		$registro=count($this->arrp);
		$this->fact = new Farffactura();
		$x=15;
		$y=50;
                $tprecio=0;$ttotal=0;$tdescuento=0;$trecargo=0;$tcantidad=0;
	foreach($this->arrp as $dato)
           {   $this->setFont("Arial","",8);
               $reg++;
               if($dato["reffac"]!=$codpro)
             {
             	if ($y>200){
             		  $this->addpage();
             		  $this->SetXY(15,50);
             		  	$x=15;
		                $y=50;
		                $pru=false;
             	}
             	if (!$pru){
             		$yr=50+($y+50);
             	}else $yr=0;
                $this->SetXY($x,$y);
                $this->setFont("Arial","B",9);

                $this->cell(190,6,"Factura: ".$dato["reffac"],0,0,'C');
                $this->setFont("Arial","",8);
                $this->SetXY(130,$y);
                $this->cell(20,6,"",0,1);
                $this->SetWidths(array(95,50,45));
    	        $this->SetAligns(array("L","L","L"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[0].''.$dato["codpro"],"Fecha de Emision: ".$dato["fecfac"],"Estatus: ".$dato["status"]));

                $this->Ln();
    	        $this->SetWidths(array(95,95));
    	        $this->SetAligns(array("L","L"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[1].''.$dato["rifpro"],$this->titulosm[2].''.$dato["nitpro"]));

                $this->Ln();
                $this->SetWidths(array(190));
                $this->SetAligns(array("L"));
                $this->setBorder(1);
                $this->RowM(array($this->titulosm[9].''.$dato["nompro"]));

                $this->Ln();
    	        $this->SetWidths(array(190));
    	        $this->SetAligns(array("L"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[3].''.$dato["dirpro"]));

                $this->Ln();
    	       	$this->SetWidths(array($this->anchos[7],$this->anchos[3],$this->anchos[7],$this->anchos[7],$this->anchos[5],$this->anchos[7]));
    	        $this->SetAligns(array("C","C","C","C","C"));
    	        //  $this->setBorder(1);
    	        $this->setFont("Arial","B",9);
    	        $this->Row(array( $this->titulosm[4], $this->titulosm[5], $this->titulosm[6], $this->titulosm[7], $this->titulosm[8],$this->titulosm[9]));
    	        $this->line(10,$this->GetY(),200,$this->GetY());
    	        $this->setFont("Arial","",9);
                $registro1=count($this->arrp1);
                $codpro=$dato["reffac"];
                $precio=0;$total=0;$descuento=0;$recargo=0;$cantidad=0;
                 $this->arrp1 =$this->fact->sqlp1($dato["codpro"],$dato["reffac"],$this->codartdes,$this->codarthas,$this->codrefdes,$this->codrefhas,$this->comodin);

                 $codart="";
                foreach($this->arrp1 as $dato1)
                {
                    //if($dato1["codart"]!=$codart)
                    //  {
                       	$montototal=0;
                       	$precio=$dato1["precio"]*$dato1["cantot"];
                       	$total=$total+$precio;
                        $cantidad=$cantidad+$dato1["cantot"];
//                     	$descuento=$descuento+$dato1["mondes"];
                       	$descuento=$descuento+$dato1["mondes"];
                       	$recargo=$recargo+$dato1["monrgo"];
                        $ttotal=$ttotal+$precio;
                        $tcantidad=$tcantidad+$dato1["cantot"];
                       	$tdescuento=$tdescuento+$dato1["mondes"];
                       	$trecargo=$trecargo+$dato1["monrgo"];
                       	$this->SetWidths(array($this->anchos[5],$this->anchos[3],$this->anchos[6],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	                $this->SetAligns(array("L","L","L","R","R","R"));
    	               // $this->setBorder(1);
//              H::PrintR($dato["mondes"]);exit;
    	                $this->setFont("Arial","",8);
    	                $this->Row(array($dato1["codart"],$dato1["desart"],$dato1["codref"],H::FormatoMonto($dato1["cantot"]),H::FormatoMonto($dato1["precio"]),''.H::FormatoMonto($precio)));
//    	                $this->Row(array($dato1["codart"],$dato1["desart"],H::FormatoMonto($dato1["mondes"]),H::FormatoMonto($dato1["precio"]),''.H::FormatoMonto($precio)));
                        $codart=$dato1["codart"];
                        $reca+=$dato1["monrgo"];
                     //  }
               }

//H::PrintR($descuento);exit;

                        $this->Ln();
                        $this->SetXY(10,$this->GetY());
                        $montototal=$total-$descuento+$reca;

                        $this->SetWidths(array(20,20,20,20,20,20,20,20,30,30));
    	                $this->SetAligns(array("R","R","R","R","R","R","R","L","L","L"));
    	               // $this->setBorder(1);
    	                 $this->setFont("Arial","B",8);
//$this->Row(array("Sub Total: ",H::FormatoMonto($total),"Cantidad: ",H::FormatoMonto($cantidad),"Descuento: ",H::FormatoMonto($descuento),"Recargo: ",H::FormatoMonto($reca),"MONTO TOTAL: ",H::FormatoMonto($montototal)));
$this->Row(array("Sub Total: ",H::FormatoMonto($total),"Cantidad: ",H::FormatoMonto($cantidad),"Descuento: ",H::FormatoMonto($descuento),"Recargo: ",H::FormatoMonto($reca),"MONTO TOTAL: ",H::FormatoMonto($montototal)));
    	                  $this->setFont("Arial","",9);
                        $y2=$this->GetY();
                        $reca=0;
            if ($reg<=$registro)
		        {
		        	    $this->Ln(10);
		        	    $this->line(10,$y2+10,200,$y2+10);
		        	    $this->Ln();
		        	    $y=$this->GetY();//print $y;
		        	    $x=$this->GetX();//print $y;
		       }

           }//if primer foreach
       }//foreach
       $this->ln(10);
       $this->line(10,$this->GetY(),200,$this->GetY());
       $this->SetWidths(array(20,20,20,20,20,20,20,20,30,30));
       $this->SetAligns(array("R","R","R","R","R","R","l","l","l","l"));
       $this->setFont("Arial","B",8);
       $montototal=$ttotal-$tdescuento+$trecargo;
       $this->Row(array("Sub Total: ",H::FormatoMonto($ttotal),"Cantidad: ",H::FormatoMonto($tcantidad),"Descuento: ",H::FormatoMonto($tdescuento),"Recargo: ",H::FormatoMonto($trecargo),"MONTO TOTAL: ",H::FormatoMonto($montototal)));
       $this->setFont("Arial","",9);
 }//cuerpo

}//fin de la clase
?>
