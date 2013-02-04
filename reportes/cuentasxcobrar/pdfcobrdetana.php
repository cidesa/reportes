<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
      require_once("../../lib/modelo/sqls/cuentasxcobrar/Cobrdetana.class.php");

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

            $this->tipmovdes=H::GetPost("tipmovdes");
			$this->tipmovhas=H::GetPost("tipmovhas");

			$this->tipclides=H::GetPost("tipclides");
			$this->tipclihas=H::GetPost("tipclihas");

				$this->fac=H::GetPost("fac");

			$this->cobrdetana = new Cobrdetana();
		    $this->arrp = $this->cobrdetana->sqlp($this->coddes,$this->codhas,$this->codclides,$this->codclihas,$this->fechamin,$this->fechamax,$this->tipmovdes,$this->tipmovhas,$this->tipclides,$this->tipclihas,$this->fac);

			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{
				$this->titulosm[0]="TIPO DE CLIENTE";
				$this->titulosm[1]="Cliente";
				$this->titulosm[2]="Ref. Fac";
				$this->titulosm[3]="Tipo Mov";
				$this->titulosm[4]="Fecha Emi.";
				$this->titulosm[5]="Fecha Venc.";
				$this->titulosm[6]="Dia al Venci";
				$this->titulosm[7]="Monto";
				$this->titulosm[8]="Recargo ";
				$this->titulosm[9]="Retención";
				$this->titulosm[10]="Abono";
				$this->titulosm[11]="Saldo";
				$this->titulosm[100]="Totales por Tipo Cliente";
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
		$this->anchos[5]=24;
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
	    $reg=0;
		$codtipo="";
		$codpro=$this->arrp[0]["codpro"];
		$numtra="";
		$refdoc="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
            {

             $totmonto=0;$totrecargo=0;$totdescuento =0;$totabono=0;$totabono=0;

              if($dato["codtipo"]!=$codtipo)
                 {
                $this->SetWidths(array($this->anchos[2]));
    	        $this->SetAligns(array("L"));
    	        $this->setBorder(1);
    	        $this->setFont("Arial","B",10);
    	        $this->RowM(array($this->titulosm[0].': '.$dato["tipo"]));
    	        $this->setFont("Arial","",9);
			    $this->Ln();
                $codtipo=$dato["codtipo"];
                }

            //  if($dato["codpro"]!=$codpro)
                 {
                $reg++;

                $this->arrp1 = $this->cobrdetana->sqlp1($dato["codpro"],$this->fac);
                $registro1=count($this->arrp1);
                $this->SetWidths(array($this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]+$this->anchos[5]));
    	        $this->SetAligns(array("L"));
    	        $this->setBorder(1);
    	     //   $this->RowM(array($this->titulosm[1].': '.$this->arrp1[0]["nompro"].$reg.'               '.'Codigo: '.$codpro));
    	        $this->RowM(array($this->titulosm[1].': '.$dato["nomcli"].'               '.'Codigo: '.$dato["codpro"]));


                $this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]+8,$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]+$this->anchos[5]-8));
    	        $this->SetAligns(array("C","C","C","C","C","C","C","C","C","C"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6],$this->titulosm[7],$this->titulosm[8],$this->titulosm[9],$this->titulosm[10],$this->titulosm[11]));
                $this->Ln();

                $abono1=0;$descuento=0;$recargo=0;$saldo=0;$monto=0;


	             $refdoc=$this->arrp[0]["refdoc"];
                 foreach($this->arrp1 as $dato1)
                   { $this->setFont("Arial","",9);

                     if($dato1["refdoc"]!=$refdoc)
                    {
                    	$this->SetWidths(array($this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]+8,$this->anchos[5],$this->anchos[5],$this->anchos[5],$this->anchos[5]+$this->anchos[5]-8));
    	                $this->SetAligns(array("C","C","C","C","C","R","R","R","R","R"));
    	                $this->setBorder(0);
                         if ($dato1["fec"]< 0){
                         	$dato1["diav"]=abs($dato1["fec"]);
                         }
                         if ($dato1["fec"]> 0){
                         	$dato1["diav"]=0;
                         }
                         if ($this->fac=="T" and $dato1["saldoc"]==0){
                          $dato1["diav"]=0;
                         }
    	                $this->RowM(array($dato1["refdoc"],$dato1["nomabr"],$dato1["fecemi"],$dato1["fecven"],(abs($dato1["diav"]))." Dias",H::FormatoMonto($dato1["mondoc"]),H::FormatoMonto($dato1["recdoc"]),H::FormatoMonto($dato1["dscdoc"]),H::FormatoMonto($dato1["abodoc"]),H::FormatoMonto($dato1["saldoc"])));
                        $this->Ln();
                        $refdoc=$dato1["refdoc"];

                    $monto=$monto+$dato1["mondoc"];
                    $recargo=$recargo+$dato1["recdoc"];
                    $descuento=$descuento+$dato1["dscdoc"];
                    $abono1=$abono1+$dato1["abodoc"];
                    $saldo=$saldo+$dato1["saldoc"];
                   }//if dato1

                    }

                   $totmonto2=$totmonto2+$monto;
                   $totrecargo=$totrecargo+$recargo;
                   $totdescuento=$totdescuento+$descuento;
                   $totabono1=$totabono1+$abono1;
                   $totsaldo=$totsaldo+$saldo;

                $this->SetWidths(array(120,$this->anchos[5]+8,$this->anchos[5],$this->anchos[5],$this->anchos[5],40));
    	        $this->SetAligns(array("R","R","R","R","R","R"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[100],H::FormatoMonto($monto),H::FormatoMonto($recargo),H::FormatoMonto($descuento),H::FormatoMonto($abono1),H::FormatoMonto($saldo)));
                $this->Ln();

                 }//if dato
            }
                $this->SetWidths(array(120,$this->anchos[5]+8,$this->anchos[5],$this->anchos[5],$this->anchos[5],40));
    	        $this->SetAligns(array("R","R","R","R","R","R"));
    	        $this->setBorder(0);
    	        $this->RowM(array($this->titulosm[100],H::FormatoMonto($totmonto2),H::FormatoMonto($totrecargo),H::FormatoMonto($totdescuento),H::FormatoMonto($totabono1),H::FormatoMonto($totsaldo)));
                $this->Ln();
                   $totmonto2=0;
                   $totrecargo=0;
                   $totdescuento=0;
                   $totabono=0;
                   $totsaldo=0;

		if ($reg<$registro)
		        {
		        	$this->addpage();
		       }
		}

}//fin de la clase
?>