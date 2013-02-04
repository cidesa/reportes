<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarlisrel.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			$this->fpdf("l","mm","letter");
			$this->index=0;
			$this->codempdes= H::GetPost('codempdes');
			$this->codemphas= H::GetPost('codemphas');
                        $this->codcatdes= H::GetPost('codcatdes');
			$this->codcathas= H::GetPost('codcathas');
                        $this->codciudes= H::GetPost('codciudes');
			$this->codciuhas= H::GetPost('codciuhas');
                        $this->fecdes= H::GetPost('fecdes');
			$this->fechas= H::GetPost('fechas');
                        $this->agrupor1= H::GetPost('agrupor1');
			$this->agrupor2= $this->agrupor1!='S' ? H::GetPost('agrupor2') : $this->agrupor1;

			$this->cab=new cabecera();
			$this->obj = new Viarlisrel();
			$this->arrp =$this->obj->SQLp($this->codempdes,$this->codemphas,$this->codcatdes,$this->codcathas,$this->codciudes,$this->codciuhas,$this->agrupor1,$this->agrupor2,$this->fecdes,$this->fechas);
                        $this->arreglos();
		}

                function arreglos()
                {
                    if($this->agrupor1=='E')
                    {
                        $this->arreglowidth = array(22,20,20,50,50,20,23,25);
                        $this->arregloalign = array("C","C","C","L","C","C","R");
                        $this->arreglorow =   array("N°RELACION","FECHA",'SOLICIT.','DESCRIPCION',"CATEGORIA","CIUDAD",'COMPROMISO','MONTO');
                    }elseif($this->agrupor1=='C')
                    {
                        $this->arreglowidth = array(22,20,20,50,50,20,23,25);
                        $this->arregloalign = array("C","C","C","L","C","C","R");
                        $this->arreglorow =   array("N°RELACION","FECHA",'SOLICIT.','DESCRIPCION',"EMPLEADO","CIUDAD",'COMPROMISO','MONTO');
                    }
                    elseif($this->agrupor1=='D')
                    {
                        $this->arreglowidth = array(22,20,20,50,40,40,20,23,25);
                        $this->arregloalign = array("C","C","C","L","C","C","R");
                        $this->arreglorow =   array("N°RELACION","FECHA",'SOLICIT.','DESCRIPCION',"EMPLEADO","CATEGORIA",'COMPROMISO','MONTO');
                    }
                    else
                    {
                        $this->arreglowidth = array(22,15,16,50,35,35,20,23,20);
                        $this->arregloalign = array("C","C","C","L","L","C","C","R");
                        $this->arreglorow =   array("N°RELACION","FECHA",'SOLICIT.','DESCRIPCION',"EMPLEADO","CATEGORIA","CIUDAD",'COMPROMISO','MONTO');
                    }
                }

		function header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo").' DEL '.$this->fecdes.' AL '.$this->fechas,"l","s");
			$this->setFont("arial","B",8);
                        $this->setTextColor(0,0,155);
			$this->setwidths($this->arreglowidth);
			$this->setAligns('C');
                        $this->setJump(3);
                        $this->setFillColor(155,155,155);
                        $this->setBorder(true);
                        $this->setFilltable(1);
			$this->Rowm($this->arreglorow);
                        $this->setFilltable(0);
                        $this->setBorder(false);
                        $this->setTextColor(0,0,0);
                        $this->setAligns($this->arregloalign);
                        $this->setFont("arial","",7);
                        $this->ln(1);
		}

		function Cuerpo()
		{
                    $this->setFont("arial","",7);
                    $i=0;
                    $totsol=0;
                    $totsol2=0;
                    $totgensol=0;
                    $ref="";
                    $ref2="";
                    $refcom1="";
                    $refcom2="";
                    if($this->agrupor1=='E')
                    {
                        $refcom1='codemp';
                        $descom1='nomemp';
                        $nombre='EMPLEADO';

                    }elseif($this->agrupor1=='C')
                    {
                        $refcom1='codcat';
                        $descom1='nomcat';
                        $nombre='CATEGORIA';
                    }
                    elseif($this->agrupor1=='D')
                    {
                        $refcom1='codciu';
                        $descom1='nomciu';
                        $nombre='CIUDAD';
                    }
                    elseif($this->agrupor1=='P')
                    {
                        $refcom1='codproced';
                        $descom1='desproced';
                        $nombre='PROCEDENCIA';
                    }elseif($this->agrupor1=='F')
                    {
                        $refcom1='codfortra';
                        $descom1='desfortra';
                        $nombre='FORMA DE TRASLADO';
                    }

                    if($this->agrupor2=='E')
                    {
                        $refcom2='codemp';
                        $descom2='nomemp';
                        $nombre2='EMPLEADO';

                    }elseif($this->agrupor2=='C')
                    {
                        $refcom2='codcat';
                        $descom2='nomcat';
                        $nombre2='CATEGORIA';
                    }
                    elseif($this->agrupor2=='D')
                    {
                        $refcom2='codciu';
                        $descom2='nomciu';
                        $nombre2='CIUDAD';
                    }
                    elseif($this->agrupor2=='P')
                    {
                        $refcom2='codproced';
                        $descom2='desproced';
                        $nombre2='PROCENDENCIA';
                    }elseif($this->agrupor2=='F')
                    {
                        $refcom2='codfortra';
                        $descom2='desfortra';
                        $nombre2='FORMA DE TRASLADO';
                    }

		    foreach($this->arrp as $arr)
		    {
                        eval('$oref1=$arr["'.$refcom1.'"];');
                        eval('$oref2=$arr["'.$refcom2.'"];');
                        if($ref!=$oref1 )
                        {
                            $this->setFont("arial","B",8);
                            if($ref)
                            {
                                $this->ln(1);
                                if($this->agrupor2!='S')
                                    $this->multicell(300,5,"TOTAL  POR $nombre2: ".H::FormatoMonto($totsol2));
                                $this->setTextColor(150,0,0);
                                if($this->agrupor1!='S')
                                    $this->multicell(300,5,"TOTAL POR $nombre: ".H::FormatoMonto($totsol));
                                $totsol=0;
                                $totsol2=0;
                                $this->ln(3);

                            }
                            $this->setTextColor(150,0,0);
                            if($this->agrupor1!='S')
                                eval('$this->multicell(300,5,$nombre."  ".$arr["'.$refcom1.'"]." - ".$arr["'.$descom1.'"]);');
                            $this->setTextColor(0,0,0);
                            if($this->agrupor2!='S')
                                eval('$this->multicell(300,5,$nombre2."  ".$arr["'.$refcom2.'"]." - ".$arr["'.$descom2.'"]);');
                            $this->setFont("arial","",7);

                        }elseif($ref2!=$oref2 )
                        {
                            $this->setFont("arial","B",8);
                            if($ref2)
                            {
                                $this->ln(1);
                                $this->multicell(300,5,"TOTAL  POR $nombre2: ".H::FormatoMonto($totsol2));
                                $totsol2=0;
                                $this->ln(3);

                            }
                            eval('$this->multicell(300,5,$nombre2."  ".$arr["'.$refcom2.'"]." - ".$arr["'.$descom2.'"]);');
                            $this->setFont("arial","",7);
                        }
                        if($this->agrupor1=='E')
                        {
                            $ref=$arr['codemp'];
                            $des=$arr['nomemp'];
                        }elseif($this->agrupor1=='C')
                        {
                            $ref=$arr['codcat'];
                            $des=$arr['nomcat'];
                        }
                        elseif($this->agrupor1=='D')
                        {
                            $ref=$arr['codciu'];
                            $des=$arr['nomciu'];
                        }
                        elseif($this->agrupor1=='P')
                        {
                            $ref=$arr['codproced'];
                            $des=$arr['desproced'];
                        }elseif($this->agrupor1=='F')
                        {
                            $ref=$arr['codfortra'];
                            $des=$arr['desfortra'];
                        }

                        if($this->agrupor2=='E')
                        {
                            $ref2=$arr['codemp'];
                            $des2=$arr['nomemp'];
                        }elseif($this->agrupor2=='C')
                        {
                            $ref2=$arr['codcat'];
                            $des2=$arr['nomcat'];
                        }
                        elseif($this->agrupor2=='D')
                        {
                            $ref2=$arr['codciu'];
                            $des2=$arr['nomciu'];
                        }
                        elseif($this->agrupor2=='P')
                        {
                            $ref2=$arr['codproced'];
                            $des2=$arr['desproced'];
                        }elseif($this->agrupor2=='F')
                        {
                            $ref2=$arr['codfortra'];
                            $des2=$arr['desfortra'];
                        }
                        $tipvia = $arr['tipvia']=='N' ? 'NACIONAL' : 'INTERNACIONAL';
                        if($this->agrupor1=='E')
                            $this->Rowm(array($arr['numrel'],$arr['fecrel'],$arr['numsol'],$arr['desrel'],
                                              $arr['codcat'].'-'.$arr['nomcat'],$arr['nomciu'],
                                              $arr['refcom'],H::FormatoMonto($arr['monto'])));
                        elseif($this->agrupor1=='C')
                            $this->Rowm(array($arr['numrel'],$arr['fecrel'],$arr['numsol'],$arr['desrel'],
                                              $arr['codemp'].'-'.$arr['nomemp'],$arr['nomciu'],
                                              $arr['refcom'],H::FormatoMonto($arr['monto'])));
                        elseif($this->agrupor1=='D')
                            $this->Rowm(array($arr['numrel'],$arr['fecrel'],$arr['numsol'],$arr['desrel'],$arr['codemp'].'-'.$arr['nomemp'],
                                              $arr['codcat'].'-'.$arr['nomcat'],
                                              $arr['refcom'],H::FormatoMonto($arr['monto'])));
                        else
                            $this->Rowm(array($arr['numrel'],$arr['fecrel'],$arr['numsol'],$arr['desrel'],$arr['codemp'].'-'.$arr['nomemp'],
                                              $arr['codcat'].'-'.$arr['nomcat'],$arr['nomciu'],
                                              $arr['refcom'],H::FormatoMonto($arr['monto'])));

                        $totsol+=$arr['monto'];
                        $totsol2+=$arr['monto'];
                        $totgensol+=$arr['monto'];
		    	$i++;
		    }
                    #TOTALES
                    $this->setFont("arial","B",8);
                    if($this->agrupor2!='S')
                        $this->multicell(300,5,"TOTAL POR $nombre2: ".H::FormatoMonto($totsol2));
                    $this->setTextColor(150,0,0);
                    if($this->agrupor1!='S')
                        $this->multicell(300,5,"TOTAL POR $nombre: ".H::FormatoMonto($totsol));
                    $this->multicell(300,5,"TOTAL GENERAL A LA FECHA: ".H::FormatoMonto($totgensol));

		}
	}