<?
	require_once("../../lib/general/fpdf/fpdf.php");	
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarlistiptra.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			parent::FPDF("P");
			$this->index=0;
			$this->codtipdes= H::GetPost('codtipdes');
			$this->codtiphas= H::GetPost('codtiphas');
			$this->cab=new cabecera();
			$this->obj = new Viarlistiptra();
			$this->arrp =$this->obj->SQLp($this->codtipdes,$this->codtiphas);
		}

		function header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo"),"p","s");
			$this->setFont("arial","B",11);
                        $this->setTextColor(0,0,155);
			$this->setwidths(array(40,100));
			$this->setAligns('C');
                        $this->setJump(5);
                        $this->setFillColor(155,155,155);
                        $this->setBorder(true);
                        $this->setFilltable(1);
			$this->Rowm(array("CODIGO TIPOS DE TRASLADO","DESCRIPCION TIPOS DE TRASLADO"));
                        $this->setFilltable(0);
                        $this->setBorder(false);
                        $this->setTextColor(0,0,0);
                        $this->setAligns(array("C","C"));
                        $this->setFont("arial","",10);
                        $this->ln(4);
		}

		function Cuerpo()
		{                    
                    $this->setFont("arial","",10);
                    $i=0;
		    foreach($this->arrp as $arr)
		    {
		    	$this->Rowm($arr);
                        $i++;
		    }
                    #TOTALES
                    $this->ln(4);
                    $this->setFont("arial","B",11);
                    $this->setTextColor(0,0,155);
                    $this->multicell(180,5,'TOTAL CANTIDAD DE TIPOS DE TRASLADOS:  '.$i);
		}
	}