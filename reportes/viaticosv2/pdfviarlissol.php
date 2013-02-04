<?
	require_once("../../lib/general/fpdf/fpdf.php");	
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarlissol.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			$this->fpdf("l","mm","legal");
			$this->index=0;
			$this->codempdes= H::GetPost('codempdes');
			$this->codemphas= H::GetPost('codemphas');
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
                        $this->agrupor1= H::GetPost('agrupor1');
			$this->agrupor2= $this->agrupor1!='S' ? H::GetPost('agrupor2') : $this->agrupor1;

			$this->cab=new cabecera();
			$this->obj = new Viarlissol();
			$this->arrp =$this->obj->SQLp($this->codempdes,$this->codemphas,$this->codcatdes,$this->codcathas,$this->codnivdes,$this->codnivhas,$this->codciudes,$this->codciuhas,$this->codprodes,$this->codprohas,$this->codfordes,$this->codforhas,$this->agrupor1,$this->agrupor2,$this->fecdes,$this->fechas,$this->status,$this->tipvia);
                        $this->arreglos();
		}

                function arreglos()
                {
                    if($this->agrupor1=='E')
                    {
                        $this->arreglowidth = array(16,13,20,50,50,50,20,35,35,25,8,20);
                        $this->arregloalign = array("C","C","C","L","L","L","C","L","L","C","C","C");
                        $this->arreglorow =   array("SOLICITUD ","FECHA","TIPO","CATEGORIA","NIVEL","DESCRIPCION","CIUDAD",'PROCEDENCIA','FORMA TRASLADO','FECHA VIAJE','DIAS','STATUS');
                    }elseif($this->agrupor1=='C')
                    {
                        $this->arreglowidth = array(16,13,20,50,50,50,20,35,35,25,8,20);
                        $this->arregloalign = array("C","C","C","L","L","L","C","L","L","C","C","C");
                        $this->arreglorow =   array("SOLICITUD ","FECHA","TIPO","EMPLEADO","NIVEL","DESCRIPCION","CIUDAD",'PROCEDENCIA','FORMA TRASLADO','FECHA VIAJE','DIAS','STATUS');
                    }
                    elseif($this->agrupor1=='D')
                    {
                        $this->arreglowidth = array(16,13,20,45,45,45,45,30,30,25,8,20);
                        $this->arregloalign = array("C","C","C","L","L","L","L","L","L","C","C","C");
                        $this->arreglorow =   array("SOLICITUD ","FECHA","TIPO","EMPLEADO","CATEGORIA","NIVEL","DESCRIPCION",'PROCEDENCIA','FORMA TRASLADO','FECHA VIAJE','DIAS','STATUS');
                    }
                    elseif($this->agrupor1=='P')
                    {
                        $this->arreglowidth = array(16,13,20,45,45,45,45,20,30,25,8,20);
                        $this->arregloalign = array("C","C","C","L","L","L","L","C","L","C","C","C");
                        $this->arreglorow =   array("SOLICITUD ","FECHA","TIPO","EMPLEADO","CATEGORIA","NIVEL","DESCRIPCION",'CIUDAD','PROCEDENCIA','FECHA VIAJE','DIAS','STATUS');
                    }
                    elseif($this->agrupor1=='F')
                    {
                        $this->arreglowidth = array(16,13,20,45,45,45,45,20,30,25,8,20);
                        $this->arregloalign = array("C","C","C","L","L","L","L","C","L","C","C","C");
                        $this->arreglorow =   array("SOLICITUD ","FECHA","TIPO","EMPLEADO","CATEGORIA","NIVEL","DESCRIPCION",'CIUDAD','FORMA TRASLADO','FECHA VIAJE','DIAS','STATUS');
                    }
                    else
                    {
                        $this->arreglowidth = array(16,13,20,40,40,40,40,20,30,30,25,8,20);
                        $this->arregloalign = array("C","C","C","L","L","L","L","C","L","L","C","C","C");
                        $this->arreglorow =   array("SOLICITUD ","FECHA","TIPO","EMPLEADO","CATEGORIA","NIVEL","DESCRIPCION",'CIUDAD','PROCEDENCIA','FORMA TRASLADO','FECHA VIAJE','DIAS','STATUS');
                    }
                    
                }

		function header()
		{
			$this->cab->poner_cabecera_legal($this,H::GetPost("titulo").' DEL '.$this->fecdes.' AL '.$this->fechas,"l","s");
			$this->setFont("arial","B",7);
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
                        $this->setFont("arial","",6);
                        $this->ln(1);
		}

		function Cuerpo()
		{                    
                    $this->setFont("arial","",6);
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
                            $this->setFont("arial","B",7);                            
                            if($ref)
                            {
                                if($this->agrupor2!='S')
                                    $this->multicell(300,5,"TOTAL SOLICITUDES POR $nombre2: ".$totsol2);
                                $this->setTextColor(150,0,0);
                                if($this->agrupor1!='S')
                                    $this->multicell(300,5,"TOTAL SOLICITUDES POR $nombre: ".$totsol);
                                $totsol=0;
                                $totsol2=0;

                            }
                            $this->setTextColor(150,0,0);
                            if($this->agrupor1!='S')
                                eval('$this->multicell(300,5,$nombre."  ".$arr["'.$refcom1.'"]." - ".$arr["'.$descom1.'"]);');
                            $this->setTextColor(0,0,0);
                            if($this->agrupor2!='S')
                                eval('$this->multicell(300,5,$nombre2."  ".$arr["'.$refcom2.'"]." - ".$arr["'.$descom2.'"]);');
                            $this->setFont("arial","",6);
                            
                        }elseif($ref2!=$oref2 )
                        {
                            $this->setFont("arial","B",7);
                            if($ref2)
                            {
                                $this->multicell(300,5,"TOTAL SOLICITUDES POR $nombre2: ".$totsol2);
                                $totsol2=0;

                            }
                            eval('$this->multicell(300,5,$nombre2."  ".$arr["'.$refcom2.'"]." - ".$arr["'.$descom2.'"]);');
                            $this->setFont("arial","",6);
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
                            $this->Rowm(array($arr['numsol'],$arr['fecsol'],$tipvia,
                                              $arr['codcat'].'-'.$arr['nomcat'],$arr['codniv'].'-'.$arr['desniv'],$arr['dessol'],$arr['nomciu'],
                                              $arr['desproced'],$arr['desfortra'],$arr['fecdes'].'-'.$arr['fechas'],$arr['numdia'],
                                              $arr['status']));
                        elseif($this->agrupor1=='C')
                            $this->Rowm(array($arr['numsol'],$arr['fecsol'],$tipvia,
                                              $arr['codemp'].'-'.$arr['nomemp'],$arr['codniv'].'-'.$arr['desniv'],$arr['dessol'],$arr['nomciu'],
                                              $arr['desproced'],$arr['desfortra'],$arr['fecdes'].'-'.$arr['fechas'],$arr['numdia'],
                                              $arr['status']));
                        elseif($this->agrupor1=='D')
                            $this->Rowm(array($arr['numsol'],$arr['fecsol'],$tipvia,$arr['codemp'].'-'.$arr['nomemp'],
                                              $arr['codcat'].'-'.$arr['nomcat'],$arr['codniv'].'-'.$arr['desniv'],$arr['dessol'],
                                              $arr['desproced'],$arr['desfortra'],$arr['fecdes'].'-'.$arr['fechas'],$arr['numdia'],
                                              $arr['status']));
                        elseif($this->agrupor1=='P')
                            $this->Rowm(array($arr['numsol'],$arr['fecsol'],$tipvia,$arr['codemp'].'-'.$arr['nomemp'],
                                              $arr['codcat'].'-'.$arr['nomcat'],$arr['codniv'].'-'.$arr['desniv'],$arr['dessol'],
                                              $arr['nomciu'],$arr['desproced'],$arr['fecdes'].'-'.$arr['fechas'],$arr['numdia'],
                                              $arr['status']));
                        elseif($this->agrupor1=='F')
                            $this->Rowm(array($arr['numsol'],$arr['fecsol'],$tipvia,$arr['codemp'].'-'.$arr['nomemp'],
                                              $arr['codcat'].'-'.$arr['nomcat'],$arr['codniv'].'-'.$arr['desniv'],$arr['dessol'],
                                              $arr['nomciu'],$arr['desfortra'],$arr['fecdes'].'-'.$arr['fechas'],$arr['numdia'],
                                              $arr['status']));
                        else
                            $this->Rowm(array($arr['numsol'],$arr['fecsol'],$tipvia,$arr['codemp'].'-'.$arr['nomemp'],
                                              $arr['codcat'].'-'.$arr['nomcat'],$arr['codniv'].'-'.$arr['desniv'],$arr['dessol'],$arr['nomciu'],
                                              $arr['desproced'],$arr['desfortra'],$arr['fecdes'].'-'.$arr['fechas'],$arr['numdia'],
                                              $arr['status']));

                        $totsol++;
                        $totsol2++;
                        $totgensol++;
		    	$i++;
		    }
                    #TOTALES
                    $this->setFont("arial","B",7);
                    if($this->agrupor2!='S')
                        $this->multicell(300,5,"TOTAL SOLICITUDES POR $nombre2: ".$totsol2);
                    $this->setTextColor(150,0,0);
                    if($this->agrupor1!='S')
                        $this->multicell(300,5,"TOTAL SOLICITUDES POR $nombre: ".$totsol);
                    $this->multicell(300,5,"TOTAL GENERAL DE SOLICITUDES A LA FECHA: ".$totgensol);

		}
	}