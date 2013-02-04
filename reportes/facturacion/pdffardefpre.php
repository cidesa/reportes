<?php
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/modelo/sqls/facturacion/Fardefpre.class.php");

	class pdfreporte extends fpdf
	{
		var $bd;

		function pdfreporte()
		{
			$this->conf="L";
			$this->fpdf($this->conf,"mm","Letter");

	        	$this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();

			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");

			$this->codpdes=H::GetPost("codpdes");
			$this->codphas=H::GetPost("codphas");

			$this->fechamin=H::GetPost("fechamin");
			$this->fechamax=H::GetPost("fechamax");

			$this->fardefpre = new Fardefpre();
		    	$this->arrp = $this->fardefpre->sqlp($this->coddes,$this->codhas,$this->codpdes,$this->codphas,$this->fechamin,$this->fechamax);
			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

		function llenartitulosmaestro()
		{
			$this->titulosm=array();
                	$this->titulosm[0]="Codigo Articulo";
			$this->titulosm[1]="Codigo de Barra";
			$this->titulosm[2]="Descripcion Articulo";
			$this->titulosm[3]="Descripcion Precio";
			$this->titulosm[4]="Precio";
			$this->titulosm[5]="Porcentaje IVA";
			$this->titulosm[6]="Monto IVA";
			$this->titulosm[7]="Precio con IVA";
                        $this->titulosm[8]="Fecha Vigencia";
                        $this->titulosm[9]="Fecha Vencimiento";
		}

		function llenaranchos()
		{
			$this->anchos=array();
			$this->anchos[0]=28;
			$this->anchos[1]=26;
			$this->anchos[2]=55;
			$this->anchos[3]=43;
			$this->anchos[4]=18;
			$this->anchos[5]=18;
                	$this->anchos[6]=18;
                	$this->anchos[7]=18;
			$this->anchos[8]=18;
			$this->anchos[9]=18;
		}

		function Header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			$this->setFont("Arial","",9);
			$this->SetWidths(array($this->anchos[0],$this->anchos[1],$this->anchos[2],$this->anchos[3],$this->anchos[4],$this->anchos[5],$this->anchos[6],$this->anchos[7],$this->anchos[8],$this->anchos[9]));
    	       		$this->SetAligns(array("C","C","C","C","C","C","C","C","C","C"));
    	       		$this->setBorder(1);
    	       		$this->Row(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7],$this->titulosm[8],$this->titulosm[9]));
			$this->SetAligns(array("C","C","L","L","R","R","R","R","L","L"));
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
                			$this->SetWidths(array($this->anchos[0],$this->anchos[1],$this->anchos[2],$this->anchos[3],$this->anchos[4],$this->anchos[5],$this->anchos[6],$this->anchos[7],$this->anchos[8],$this->anchos[9]));
    	        			$this->SetAligns(array("C","C","L","L","R","R","R","R","C","C"));
    	        			$this->setBorder(1);
					$this->RowM(array($dato["codart"],$dato["codbar"],$dato["desart"],$dato["despvp"],$dato["pvpart"],$dato["por_iva"],$dato["monto_iva"],$dato["pvp_mas_iva"],$dato["fecdes"],$dato["fechas"]));
              			}
            		}
			
			if ($reg<=$registro)
		        {
		        	$this->addpage();
		       	}
		}

}//fin de la clase
?>
