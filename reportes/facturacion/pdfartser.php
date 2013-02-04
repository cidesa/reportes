<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Artser.class.php");

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

			$this->conpagdes=H::GetPost("coddesp");
			$this->conpaghas=H::GetPost("codhasp");
			$this->estatus=H::GetPost("estatus");
			///Verificar Status

			$this->status=$this->verificar_status();
             //print $this->estatus;
            // print $this->status;exit;
			$this->artser = new Artser();
		    $this->arrp = $this->artser->sqlp($this->fechades,$this->fechahas,$this->status,$this->conpagdes,$this->conpaghas);
			$this->verificar_status();
			$this->llenartitulosmaestro();
			$this->llenaranchos();
			///

		}

	function llenartitulosmaestro()
		{

				$this->titulosm[100]="RESUMEN DE ARTICULOS Y SERVICIOS";
				$this->titulosm[0]="CODIGO";
				$this->titulosm[1]="DECRIPCION";
				$this->titulosm[2]="CANTIDAD";
				$this->titulosm[3]="TOTAL";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=70;
		$this->anchos[4]=40;



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

			    $this->Ln();
			    $this->SetWidths(array($this->anchos[4],$this->anchos[3],$this->anchos[4],$this->anchos[4]));
    	        $this->SetAligns(array("C","C","C","C"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3]));

		}

function Cuerpo()

		{

	    $reg=1;
		$codart="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["codart"]!=$codart)
              {
                $this->SetWidths(array($this->anchos[4],$this->anchos[3],$this->anchos[4],$this->anchos[4]));
    	        $this->SetAligns(array("L","L","R","R"));
    	        $this->setBorder(1);
    	        $this->RowM(array($dato["codart"],$dato["desart"],$dato["cantidad"],H::FormatoMonto($dato["total"])));

            }

            }

		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }



		}

}//fin de la clase
?>