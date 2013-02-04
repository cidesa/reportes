<?
	require_once("../../lib/general/fpdf/fpdf.php");	
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarliscalporrub.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			$this->fpdf("l","mm","letter");
			$this->index=0;
			$this->codempdes= H::GetPost('codempdes');
			$this->codemphas= H::GetPost('codemphas');
                        $this->codrubdes= H::GetPost('codrubdes');
			$this->codrubhas= H::GetPost('codrubhas');
                        $this->codcatdes= H::GetPost('codcatdes');
			$this->codcathas= H::GetPost('codcathas');
                        $this->codnivdes= H::GetPost('codnivdes');
			$this->codnivhas= H::GetPost('codnivhas');
                        $this->codciudes= H::GetPost('codciudes');
			$this->codciuhas= H::GetPost('codciuhas');
                        $this->codprodes= H::GetPost('codprodes');
			$this->codprohas= H::GetPost('codprohas');
                        $this->codfordes= H::GetPost('codfordes');
			$this->codforhas= H::GetPost('codforhas');
                        $this->fecdes= H::GetPost('fecdes');
			$this->fechas= H::GetPost('fechas');
                        $this->status= H::GetPost('status');
                        $this->tipvia= H::GetPost('tipvia');
                        $this->agrupor1= 'R';
			$this->agrupor2='S';

			$this->cab=new cabecera();
			$this->obj = new Viarliscalporrub();
			$this->arrp =$this->obj->SQLp($this->codrubdes,$this->codrubhas,$this->codempdes,$this->codemphas,$this->codcatdes,$this->codcathas,$this->codnivdes,$this->codnivhas,$this->codciudes,$this->codciuhas,$this->codprodes,$this->codprohas,$this->codfordes,$this->codforhas,$this->agrupor1,$this->agrupor2,$this->fecdes,$this->fechas,$this->status,$this->tipvia);
                        $this->arreglos();
		}

                function arreglos()
                {
                    $this->arreglowidth = array(22,15,16,20,35,35,20,25,10,20,23,20);
                    $this->arregloalign = array("C","C","C","C","L","L","C","C","C","C","C","R");
                    $this->arreglorow =   array("N°CALCULO","FECHA",'SOLICIT.',"TIPO","EMPLEADO","CATEGORIA","CIUDAD",'FECHA VIAJE','DIAS','STATUS','COMPROMISO','MONTO');
                    
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
                    
                    $refcom1='codrub';
                    $descom1='nomrub';
                    $nombre='RUBROS';

                    
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
                        
                        $ref=$arr['codrub'];
                        $des=$arr['nomrub'];
                        
                        $tipvia = $arr['tipvia']=='N' ? 'NACIONAL' : 'INTERNACIONAL';
                        
                        $this->Rowm(array($arr['numcal'],$arr['feccal'],$arr['numsol'],$tipvia,$arr['codemp'].'-'.$arr['nomemp'],
                                          $arr['codcat'].'-'.$arr['nomcat'],$arr['nomciu'],
                                          $arr['fecdes'].'-'.$arr['fechas'],$arr['numdia'],
                                          $arr['status'],$arr['refcom'],H::FormatoMonto($arr['monto'])));

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