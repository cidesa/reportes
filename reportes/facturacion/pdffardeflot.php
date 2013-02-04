<?php
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Fardeflot.class.php");

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

			$this->fechades=H::GetPost("fechamin");
			$this->fechahas=H::GetPost("fechamax");

			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");

			$this->nummin=H::GetPost("nummin");
			$this->nummax=H::GetPost("nummax");

			$this->fardeflot = new Fardeflot();
		    $this->arrp = $this->fardeflot->sqlp($this->coddes,$this->codhas,$this->fechades,$this->fechahas,$this->nummin,$this->nummax);

			$this->llenartitulosmaestro();
			$this->llenaranchos();

		}

	function llenartitulosmaestro()
	  	{

				$this->titulosm[0]="Cod. Articulo";
				$this->titulosm[1]="Descripcion";
				$this->titulosm[2]="Cod. Lote";
				$this->titulosm[3]="Almacen";
				$this->titulosm[4]="Fecha. Vcto";
				$this->titulosm[5]="Cantidad";
				$this->titulosm[6]="Costo";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=60;
		$this->anchos[5]=23;

	}

function Header()
		{

			    $this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);
			    $this->Ln();
			    $this->SetWidths(array($this->anchos[5],$this->anchos[3],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	        $this->SetAligns(array("C","C","C","C","C","C"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6]));

		}

function Cuerpo()

		{

	    $reg=1;
		$codart="";
		$registro=count($this->arrp);
		//H::PrintR($this->arrp);exit;
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["codart"]!=$codart)
               {
                $this->SetWidths(array($this->anchos[5],$this->anchos[3],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]));
    	        $this->SetAligns(array("L","L","C","C","C","L","R"));
    	        $this->setBorder(1);
    	        $this->RowM(array($dato["codart"],$dato["desart"],$dato["numlot"],$dato["nomalm"],$dato["fecven"],$dato["canlot"],H::FormatoMonto($dato["coslot"])));

              }
            }

		   if ($reg<=$registro)
		        {
		        	$this->addpage();
		        }

		}

}//fin de la clase

?>
