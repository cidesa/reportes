<?
	require_once("../../lib/general/fpdf/fpdf.php");	
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/viaticos/Viarforsol.class.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		function pdfreporte()
		{
			$this->fpdf("p","mm","letter");
			$this->index=0;
                        $this->numsoldes= H::GetPost('numsoldes');
			$this->numsolhas= H::GetPost('numsolhas');
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
			$this->obj = new Viarforsol();
			$this->arrp =$this->obj->SQLp($this->numsoldes,$this->numsolhas,$this->codempdes,$this->codemphas,$this->codcatdes,$this->codcathas,$this->codnivdes,$this->codnivhas,$this->codciudes,$this->codciuhas,$this->codprodes,$this->codprohas,$this->codfordes,$this->codforhas,$this->fecdes,$this->fechas,$this->tipvia);
                        
		}

		function header()
		{
			$this->cab->poner_cabecera($this,"VIÁTICOS Y TRANSPORTE","p","s");
			$this->setFont("arial","B",10);                        
		}

		function Cuerpo()
		{
                    foreach ($this->arrp as $arr)
                    {
                        $this->setFont("arial","B",6);
                        $this->cell(155);
                        $this->multicell(35,2,"Solicitud",0,'C');
                        $this->setFont("arial","B",8);
                        $this->cell(155);
                        $this->multicell(35,6,"Número: ".$arr['numsol'],1,'C');
                        $this->cell(155);
                        $this->multicell(35,6,"Fecha: ".$arr['fecsol'],1,'C');
                        $this->setFont("arial","B",12);
                        $this->setTextColor(150,0,0);
                        $this->multicell(190,6,"S O L I C I T U D",0,'C');
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
                        $this->ln(4);
                        $this->multicell(190,6,"DATOS DEL VIAJE ",1,'C');
                        $this->setWidths(array(30,30,30,30,35,35));
                        $this->setAligns("C");
                        $this->setBorder(true);
                        if($arr['tipvia']=='N')
                        {
                            $this->rowm(array("ESTADO","CIUDAD","FECHA DE SALIDA","FECHA DE REGRESO","DIAS CON PERNOCTA","DIAS SIN PERNOCTA"));
                            $this->setFont("arial","",8);
                            $this->rowm(array("\n".$arr['nomest'],"\n".$arr['nomciu'],"\n".$arr['fecdes'],"\n".$arr['fechas'],"\n".($arr['numdia']-1),"\n1"));
                        }
                        else
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
                        $this->setFont("arial","B",8);
                        $this->multicell(190,6,"DATOS FUNCIONARIO QUE AUTORIZA LA COMISION",1,'C');
                        $this->setWidths(array(60,30,50,50));
                        $this->setAligns("C");
                        $this->setBorder(true);
                        $this->rowm(array("APELLIDOS Y NOMBRES ","C.I.","UNIDAD ADSCRIPCION","CARGO"));
                        $this->setFont("arial","",8);
                        $auxvar=split("-",$arr['catcaraut']);                        
                        $this->rowm(array("\n".$arr['nomempaut'],"\n".$arr['codempaut'],"\n".$auxvar[0],"\n".$auxvar[1],"\n"));
                        $this->multicell(190,5,"NIVELES DE AUTORIZACIÓN",1,"C");
                        $this->setWidths(array(95,95));
                        $this->setAligns("C");
                        $this->setBorder(true);
                        $this->rowm(array("GERENCIA DE SOLICITANTE","GERENCIA DE GESTIÓN DE ADMINISTRACIÓN"));
                        $this->setWidths(array(45,50,45,50));
                        $this->setBorder(true);
                        $this->setFont("arial","",4);
                        $this->rowm(array("\n\n\n\n\nFirma del Funcionario Solicitante",
                                          "\n\n\n\n\nNombre, Apellido y Firma del Gerente",
                                          "\n\n\n\n\nNombre, Apellido y Firma del Fucionario Receptor",
                                          "\n\n\n\n\nNombre, Apellido y Firma del Gerente"));
                        
                        
                        $this->addpage();
                    }
                }
	}