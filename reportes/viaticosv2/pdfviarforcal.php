<?
	require_once("../../lib/general/fpdf/fpdf.php");	
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarforcal.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			$this->fpdf("p","mm","letter");
			$this->index=0;
                        $this->numcaldes= H::GetPost('numcaldes');
			$this->numcalhas= H::GetPost('numcalhas');
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
                        $this->tipvia= H::GetPost('tipvia');
                        

			$this->cab=new cabecera();
			$this->obj = new Viarforcal();
			$this->arrp =$this->obj->SQLp($this->numcaldes,$this->numcalhas,$this->codempdes,$this->codemphas,$this->codcatdes,$this->codcathas,$this->codnivdes,$this->codnivhas,$this->codciudes,$this->codciuhas,$this->codprodes,$this->codprohas,$this->codfordes,$this->codforhas,$this->fecdes,$this->fechas,$this->tipvia);
                        
		}

		function header()
		{
                        $this->setTextColor(0,0,0);
			$this->cab->poner_cabecera($this,"VIÁTICOS Y TRANSPORTE","p","s");
			$this->setFont("arial","B",10);                        
		}

		function Cuerpo()
		{
                    $ref="";
                    $montodol=0;
                    $monto=0;
                    foreach ($this->arrp as $arr)
                    {
                        if($ref)
                        {    $this->addpage();}
                        $this->setFont("arial","B",6);
                        $this->cell(155);
                        $this->multicell(35,2,"Calculo",0,'C');
                        $this->setFont("arial","B",8);
                        $this->cell(155);
                        $this->multicell(35,6,"Número: ".$arr['numcal'],1,'C');
                        $this->cell(155);
                        $this->multicell(35,6,"Fecha: ".$arr['feccal'],1,'C');
                        $this->cell(155);
                        $this->multicell(35,6,"Solicitud Nro.: ".$arr['numsol'],1,'C');
                        $this->setFont("arial","B",12);
                        $this->setTextColor(150,0,0);
                        $this->multicell(190,6,"C A L C U L O",0,'C');
                        $this->ln(2);
                        $this->setFont("arial","B",8);
                        $this->setTextColor(0,0,0);
                        $this->multicell(190,6,"DATOS DEL FUNCIONARIO ",1,'C');
                        $this->setWidths(array(60,30,50,50));
                        $this->setAligns("C");
                        $this->setBorder(true);
                        $this->rowm(array("APELLIDOS Y NOMBRES ","C.I.","UNIDAD ADSCRIPCION","CARGO"));
                        $this->setFont("arial","",8);
                        $this->rowm(array("\n".$arr['nomemp'],"\n".$arr['codemp'],"\n".$arr['nomcat'],"\n".$arr['nomcar']));
                        $this->setFont("arial","B",8);
                        $this->multicell(190,6,"ACOMPAÑANTE DE MAYOR NIVEL",1,'C');
                        $this->setWidths(array(60,50,50,30));
                        $this->setAligns("C");
                        $this->setBorder(true);
                        $this->rowm(array("APELLIDOS Y NOMBRES ","UNIDAD ADSCRIPCION","CARGO","TIPO VIATICO"));                        
                        $this->setFont("arial","",8);                        
                        $auxvar=split("-",$arr['catcar']);
                        $tipvia = $arr['tipvia']=='N' ? 'NACIONAL' : 'INTERNACIONAL';
                        $this->rowm(array("\n".$arr['nomempaco'],"\n".$auxvar[0],"\n".$auxvar[1],"\n".$tipvia));
                        $this->setFont("arial","B",8);
                        $this->multicell(190,6,"DATOS DEL VIAJE ",1,'C');
                        $this->setWidths(array(30,30,30,30,35,35));
                        $this->setAligns("C");
                        $this->setBorder(true);
                        if($arr['tipvia']=='N')
                        {
                            $this->rowm(array("ESTADO","CIUDAD","FECHA DE SALIDA","FECHA DE REGRESO","DIAS CON PERNOCTA","DIAS SIN PERNOCTA"));
                            $this->setFont("arial","",8);
                            $this->rowm(array("\n".$arr['nomest'],"\n".$arr['nomciu'],"\n".$arr['fecdes'],"\n".$arr['fechas'],"\n".($arr['numdia']-1),"\n1"));
                        }else
                        {
                            $this->rowm(array("PAIS","ESTADO","FECHA DE SALIDA","FECHA DE REGRESO","DIAS CON PERNOCTA","DIAS SIN PERNOCTA"));
                            $this->setFont("arial","",8);
                            $this->rowm(array("\n".$arr['nompai'],"\n".$arr['nomest'],"\n".$arr['fecdes'],"\n".$arr['fechas'],"\n".($arr['numdia']-1),"\n1"));
                        }                        
                        $this->setFont("arial","B",8);
                        $this->setWidths(array(95,95));
                        $this->setAligns("C");
                        $this->setBorder(true);
                        $this->rowm(array("PROCEDENCIA","FORMA DE TRASLADO"));
                        $this->setFont("arial","",8);
                        $this->rowm(array("\n".$arr['desproced'],"\n".$arr['desfortra']));
                        $this->setFont("arial","B",8);
                        $this->multicell(190,5,"MOTIVOS DEL VIATICO",1,"C");
                        $this->multicell(190,5,"\n".$arr['dessol']."\n",1);
                        $arrvia =$this->obj->SQLvia($arr['numcal'],$arr['tipvia']);
                        $this->multicell(190,5,"DATOS CALCULO VIATICO",1,"C");
                        $this->setFont("arial","B",8);                        
                        if($arr['tipvia']=='I')
                        {
                            $this->setWidths(array(70,10,20,25,15,25,25));
                            $this->setAligns("C");
                            $this->setBorder(true);
                            $this->rowm(array("CONCEPTOS","DIAS","MONTO DIARIO ($)","MONTO DIARIO x DIA ($)","CAMBIO","MONTO DIARIO (BSF)","DIAS x MONTO DIARIO"));
                            $this->setAligns(array("L","C","R","R","R","R","R"));
                            $this->setFont("arial","",8);
                            foreach($arrvia as $r)
                            {
                               $this->rowm(array($r['desrub'],$r['numdia'],H::FormatoMonto($r['mondia']/$r['valdolar']),H::FormatoMonto(($r['mondia']/$r['valdolar'])*$r['numdia']),H::FormatoMonto($r['valdolar']),H::FormatoMonto($r['mondia']),H::FormatoMonto($r['montot'])));
                               $monto+=$r['montot'];
                               $montodol+=($r['mondia']/$r['valdolar'])*$r['numdia'];
                            }
                            $this->setFont("arial","B",8);
                            $this->rowm(array("TOTAL EN DOLARES","","",H::FormatoMonto($montodol)));
                            $this->rowm(array("TOTAL A PAGAR","","","","","",H::FormatoMonto($monto)));
                        }else
                        {
                            $this->setWidths(array(80,30,40,40));
                            $this->setAligns("C");
                            $this->setBorder(true);
                            $this->rowm(array("CONCEPTOS","DIAS","MONTO DIARIO","DIAS x MONTO DIARIO"));
                            $this->setAligns(array("L","C","C","R","R"));
                            $this->setFont("arial","",8);
                            foreach($arrvia as $r)
                            {
                               $this->rowm(array($r['desrub'],$r['numdia'],H::FormatoMonto($r['mondia']),H::FormatoMonto($r['montot'])));
                               $monto+=$r['montot'];
                            }
                            $this->setFont("arial","B",8);
                            $this->rowm(array("TOTAL A PAGAR","","",H::FormatoMonto($monto)));
                        }                        
                        $this->setFont("arial","",7);
                        $this->multicell(190,5,"TOTAL BOLIVARES FUERTES (Escrito en Letras)\n".H::obtenermontoescrito($monto),1);
                        $this->multicell(190,5,"OBSERVACIONES\n".$arr['observaciones'],1);
                        
                        $this->setWidths(array(60,30,100));
                        $this->setAligns("L");
                        $this->setBorder(true);
                        $this->setFont("arial","",4);
                        $this->rowm(array("Elaborado Por:\n\n\n\n\n",
                                          "Fecha:",
                                          "Nombre, Apellido y Firma del Gerente:"));
                        $ref=$arr['numcal'];
                    }
                }
	}