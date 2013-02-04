<?
	require_once("../../lib/general/fpdf/fpdf.php");	
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarforrel.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			$this->fpdf("p","mm","letter");
			$this->index=0;
                        $this->numreldes= H::GetPost('numreldes');
			$this->numrelhas= H::GetPost('numrelhas');
			$this->codempdes= H::GetPost('codempdes');
			$this->codemphas= H::GetPost('codemphas');
                        $this->codcatdes= H::GetPost('codcatdes');
			$this->codcathas= H::GetPost('codcathas');
                        $this->codpardes= H::GetPost('codpardes');
			$this->codparhas= H::GetPost('codparhas');
                        $this->codciudes= H::GetPost('codciudes');
			$this->codciuhas= H::GetPost('codciuhas');                        
                        $this->fecdes= H::GetPost('fecdes');
			$this->fechas= H::GetPost('fechas');                              

			$this->cab=new cabecera();
			$this->obj = new Viarforrel();
			$this->arrp =$this->obj->SQLp($this->numreldes,$this->numrelhas,$this->codempdes,$this->codemphas,$this->codcatdes,$this->codcathas,$this->codpardes,$this->codparhas,$this->codciudes,$this->codciuhas,$this->fecdes,$this->fechas);
                        
		}

		function header()
		{
                        $this->setTextColor(0,0,0);
			$this->cab->poner_cabecera($this,"VIATICOS Y TRANSPORTE","p","s");
			$this->setFont("arial","B",10);                        
		}

		function Cuerpo()
		{
                    $ref="";
                    $monto=0;
                    $montorec=0;
                    foreach ($this->arrp as $arr)
                    {
                        if($ref!=$arr['numrel'])
                        {    
                            if($ref)
                            {
                                $this->ln(3);
                                $this->setTextColor(0,0,155);
                                #TOTALES
                                $this->multicell(190,6,"TOTAL RECARGOS RELACION: ".H::FormatoMonto($montorec),1,'R');
                                $this->multicell(190,6,"TOTAL RELACION: ".H::FormatoMonto($monto),1,'R');
                                $this->setTextColor(0,0,0);
                                $monto=0;
                                $montorec=0;
                                $this->addpage();
                            }
                            $this->setFont("arial","",5);
                            $this->cell(155);
                            $this->multicell(35,3,"Relación",0,'C');
                            $this->setFont("arial","B",8);
                            $this->cell(155);
                            $this->multicell(35,6,"Número: ".$arr['numrel'],1,'C');
                            $this->cell(155);
                            $this->multicell(35,6,"Fecha: ".$arr['fecrel'],1,'C');                        
                            $this->setTextColor(150,0,0);
                            $this->multicell(190,6,"RELACION DE VIÁTICOS",0,'C');
                            $this->ln(2);
                            $this->setFont("arial","B",8);
                            $this->setTextColor(0,0,0);
                            $this->ln(3);
                            $this->multicell(190,6,"Tipo Compromiso:  ".$arr['tipcom']." - ".$arr['nomext'],1,'L');
                            $this->multicell(190,6,"Descripción:\n".$arr['desrel'],1,'L');
                            $this->ln(5);
                            $this->setWidths(array(15,35,19 ,18,20,20,20,20,20));
                            $this->setAligns("C");
                            $this->setBorder(true);
                            $this->setTextColor(0,0,155);
                            $this->rowm(array("CODIGO","NOMBRE","FACTURA","FECHA","MONTO NETO","RECARGO","CATEGORIA","PARTIDA","SOLICITUD"));
                            $this->setTextColor(0,0,0);
                            $this->setAligns(array("C","L","C","C","R","R","C","C","C"));
                            
                        }
                        $ref=$arr['numrel'];
                        $this->rowm(array($arr['codemp'],$arr['nomemp'],$arr['numfac'],$arr['fecfac'],H::FormatoMonto($arr['montonet']),H::FormatoMonto($arr['montorec']),
                                          $arr['codcat'],$arr['codpar'],$arr['refsol']));
                        $monto+=$arr['montonet'];
                        $montorec+=$arr['montorec'];                        
                    }
                    #TOTALES
                    $this->ln(3);
                    $this->setTextColor(0,0,155);
                    $this->multicell(190,6,"TOTAL RECARGOS RELACION: ".H::FormatoMonto($montorec),0,'R');
                    $this->multicell(190,6,"TOTAL RELACION: ".H::FormatoMonto($monto),0,'R');
                }
	}