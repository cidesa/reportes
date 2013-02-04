<?
	require_once("../../lib/general/fpdf/fpdf.php");	
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarliscalrub.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			parent::FPDF("P");
			$this->index=0;
			$this->codrubdes= H::GetPost('codrubdes');
			$this->codrubhas= H::GetPost('codrubhas');
			$this->cab=new cabecera();
			$this->obj = new Viarliscalrub();
			$this->arrp =$this->obj->SQLp($this->codrubdes,$this->codrubhas);
		}

		function header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo"),"p","s");
			$this->setFont("arial","B",11);
                        $this->setTextColor(0,0,155);
			$this->setwidths(array(20,60,35,35,40));
			$this->setAligns('C');
                        $this->setJump(5);
                        $this->setFillColor(155,155,155);
                        $this->setBorder(true);
                        $this->setFilltable(1);
			$this->Rowm(array("CODIGO RUBRO ","DESCRIPCION RUBRO","CANTIDAD DE UNIDADES TRIBUTARIAS","VALOR UNIDAD TRIBUTARIA","MONTO DIARIO VIATICO"));
                        $this->setFilltable(0);
                        $this->setBorder(false);
                        $this->setTextColor(0,0,0);
                        $this->setAligns(array("C","C","R","R","R"));
                        $this->setFont("arial","",10);
                        $this->ln(4);
		}

		function Cuerpo()
		{                    
                    $this->setFont("arial","",10);
                    $i=0;
                    $ref="";
		    foreach($this->arrp as $arr)
		    {
                        if($ref!=$arr[codrub])
                        {
                            if($ref)
                                $this->ln(4);
                            $this->Rowm(array($arr['codrub'],$arr['desrub'],H::FormatoMonto($arr['canunitri']),H::FormatoMonto($arr['valunitri']),H::FormatoMonto($arr['monto'])));
                        }else {
                            $this->Rowm(array('','',H::FormatoMonto($arr['canunitri']),H::FormatoMonto($arr['valunitri']),H::FormatoMonto($arr['monto'])));
                        }
		    	$ref=$arr[codrub];
                        $i++;
		    }
		}
	}