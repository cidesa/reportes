<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/modelo/sqls/contabilidad/Conbalgen1.class.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/business/contabilidad.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $ancho;
		var $campos;

		var $codcta1;
		var $codcta2;
		var $periodo;
 		var $auxnivel;
		var $auxnivel2;
		var $nrorup;
		var $comodin;

		var $loniv1;
		var $fecha_ini;
		var $fecha_cie;
		var $nivel;
		var $fechainicio;
		var $total;
		var $saldo;
		var $cuenta_resultado;
		var $resultado;
		var $Total_Resultado;


		function pdfreporte()
		{
                     $this->cab=new cabecera();
			$this->fpdf("p","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->campos    = array();
			$this->anchos    = array();
			$this->titulos   = array();
			$this->codcta1   = H::GetPost('codcta1');
			$this->codcta2   = H::GetPost('codcta2');
			$this->periodo   = H::GetPost('periodo');
			$this->auxnivel  = H::GetPost('auxnivel');
			$this->auxnivel2 = H::GetPost('auxnivel2');
			$this->comodin   = H::GetPost('comodin');
			$this->nrorup    = H::GetPost('nrorup');
			$this->nrorup2   = H::GetPost('nrorup2');
			$this->obtenerFecha();

 			$objConbalgen1 = new Conbalgen1();
 			$this->arrp = $objConbalgen1->SQLP($this->periodo, $this->fecha_ini, $this->fecha_cie, $this->nivel, $this->codcta1, $this->codcta2, $this->comodin);

 			$this->arrp_detalles = $objConbalgen1->arrp_detalles($this->periodo, $this->fecha_ini, $this->fecha_cie, $this->nivel, $this->codcta1, $this->codcta2, $this->comodin);

			$this->llenartitulosmaestro();
		}

		function obtenerFecha()
		{
			$temp = new Conbalgen1();
			$this->arrp2 = $temp->SQLContaba();

			if ($this->arrp2)
			{
				$this->fechainicio = $this->arrp2[0]["fechainic"];
				$this->forcta      = $this->arrp2[0]["forcta"];
			}

			$this->valor = H::instr($this->forcta,'-',0,1);

  		    $this->arrp2 = $temp->SQLContaba_loniv1($this->valor);

				if ($this->arrp2)
				{
					$this->loniv1    = $this->arrp2[0]["loniv1"];
					$this->fecha_ini = $this->arrp2[0]["fecha_ini"];
					$this->fecha_cie = $this->arrp2[0]["fecha_cie"];
					$this->cuenta_resultado = $this->arrp2[0]["cuenta_resultado"];
				} //EndIf

			////// AUXNIVEL 1   ////////

			  if ($this->auxnivel==$this->nrorup)
			   {
			   			$this->arrp2 = $temp->SQLContaba_nivel();

						if ($this->arrp2)
						{
							$this->nivel=$this->arrp2[0]["nivel"];
						}			 //EndIf
			   }	  //EndIf
			   else
			   {
	 			    $this->valor=H::instr($this->forcta,'-',0,$this->auxnivel);
	 			    $this->arrp2 = $temp->SQLContaba_nivel2($this->valor);

						if ($this->arrp2)
						{
							$this->nivel=$this->arrp2[0]["nivel"];
						}					//EndIf
			   } //EndIf


			////// AUXNIVEL 2   ////////

			  if ($this->auxnivel2==$this->nrorup)
			   {
			   			$this->arrp2 = $temp->SQLContaba_nivel();

						if ($this->arrp2)
						{
							$this->nivel2=$this->arrp2[0]["nivel"];
						}			 //EndIf
			   }	  //EndIf
			   else
			   {
	 			    $this->valor=H::instr($this->forcta,'-',0,$this->auxnivel2);
	 			    $this->arrp2 = $temp->SQLContaba_nivel2($this->valor);

						if ($this->arrp2)
						{
							$this->nivel2=$this->arrp2[0]["nivel"];
						}					//EndIf
			   } //EndIf


		  unset($temp);
		}

		function llenartitulosmaestro()
		{
				$this->anchos[0]=70;
				$this->anchos[1]=30;
				$this->anchos[2]=30;
				$this->anchos[3]=80;
		}

		function Header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","s");
			$this->setFont("Arial","B",9);
			$year = substr($this->fecha_ini,0,4);
			$mes = substr($this->fecha_ini,5,2);
			$dia = substr($this->fecha_ini,8,2);
		  //  $this->cell(40,10,"Desde: ".$this->FecPerEje($this->periodo,'i'));


			$year = substr($this->fecha_cie,0,4);
			$mes = substr($this->fecha_cie,5,2);
			$dia = substr($this->fecha_cie,8,2);
                        $this->cell(80);
			$this->cell(40,10,"AL: ".$this->FecPerEje($this->periodo,'f'));
                        $this->ln();
                        $this->cell(65);
                        $this->cell(50,10,"EXPRESADO EN BsF.",0,0,"C");
                        $this->Line(10,55,250,55);
			$this->ln();
		}


		function Cuerpo()
		{
			for ($i=1;$i<2;$i++){ $this->Datos($i);	 }
		}


	function Datos($i){

		$objConbalgen1 = new Conbalgen1();

		 if ($i==1)
		 {
		 	$this->arrp;
		 }
	    //    $sw=1;
			foreach ($this->arrp as $arrp)
			{
				if($arrp["titulo"]!=" ")
				{
				 $this->setFont("Arial","",5);

						/////////////////////////////////////////////
								$palabra=$arrp["cuenta"];
								$tamano=strlen($palabra);
								$niv=1;
								for ($qi=0;$qi<=$tamano;$qi++){
									if ($palabra[$qi]=='-'):
										$niv=$niv+1;
									endif;
								}
								//print "    ".$niv." - ";
								//print $this->nrorup."<br>";
						/////////////////////////////////////////////
			 $sw1=0;
					  if (($niv == ($this->nrorup) and (trim($arrp["cargable"]=='C'))) ){
					       $sw1=1; }
  				      else{
							   if ((($niv == (($this->nrorup)-1) and (($this->nrorup)-1) >0) or
									($niv == (($this->nrorup)-2) and (($this->nrorup)-2) >0) or
									($niv == (($this->nrorup)-3) and (($this->nrorup)-3) >0) or
									($niv == (($this->nrorup)-4) and (($this->nrorup)-4) >0) or
									($niv == (($this->nrorup)-5) and (($this->nrorup)-5) >0) or
									($niv == (($this->nrorup)-6) and (($this->nrorup)-6) >0) or
									($niv == (($this->nrorup)-7) and (($this->nrorup)-7) >0)) ){

									if ((strlen(rtrim($arrp["cuenta"]))) <= ($this->nivel2)){
										$sw1=1; }
								}
						  }
					  //and (trim($arrp["saldo"]<>0))) ){

					 if ((ltrim(rtrim($arrp["titulo"]))=='TOTAL') ) {
					 	 //if ((ltrim(rtrim($arrp["titulo"]))=='TOTAL') and (trim($arrp["saldo"]<>0))) {
						//$this->setX(10);
						//$this->cell($this->anchos[0],10,$arrp["cuenta"]);
						$this->setX(30);
						$this->setFont("Arial","B",5);
				 		 $descta=strtoupper('  '.$arrp["titulo"]." ".$arrp["nombre"]);
						 $this->cell($this->anchos[0],10,substr($descta,0,65));

						 $sw=0;
					 } elseif ($sw1==1) {
					 		 //} elseif ($sw1==1 and (trim($arrp["saldo"]<>0))) {
						$this->setX(10);
						$this->cell($this->anchos[0],10,$arrp["cuenta"]);
  					    $this->setX(25);
  					    $this->setFont("Arial","",5);
						//print $this->s=str_pad(' ',strlen(rtrim($arrp["cuenta"]))*2,' ',STR_PAD_RIGHT);
						 $descta=strtoupper('  '.$arrp["nombre"]);

					    $this->cell(70,10,substr($descta,0,65));
						 $sw=1;
					 }   //EndIF

					/* if ($sw1==1){
						 $descta=strtoupper(str_pad(' ',strlen(rtrim($arrp["cuenta"]))*2,' ',STR_PAD_RIGHT).$arrp["nombre"]);
						$this->cell($this->anchos[0],10,$descta);

					 }*/



				$this->CalcularIngresoYEgreso();


						/////////////////////////////////////////////
								$palabra=$arrp["cuenta"];
								$tamano=strlen($palabra);
								$niv=1;
								for ($wi=0;$wi<=$tamano;$wi++){
									if ($palabra[$wi]=='-'):
										$niv=$niv+1;
									endif;
								}
								//print "    ".$niv." - ";
								//print $this->nrorup."<br>";
						/////////////////////////////////////////////
						  $tb_temp=$this->bd->select("SELECT CARGAB as mov FROM CONTABB  WHERE RTRIM(CODCTA)=RTRIM('".$arrp["cuenta"]."')");
						    if (!empty($tb_temp->fields["mov"])){ $mov=$tb_temp->fields["mov"]; }

						//$this->nrorup=(($this->nrorup)-1);
			  if (($niv == ($this->nrorup)  and (trim($arrp["cargable"]=='C')) ) ){
			  		  //if (($niv == ($this->nrorup)  and (trim($arrp["cargable"]=='C')) and (trim($arrp["saldo"]<>0))) ){
$this->SetX(90);
					 $this->cell(20,10,H::FormatoMonto($arrp["saldo"]),0,0,'R');
						 //$this->Line($this->GetX(),$this->GetY()+2,200,$this->GetY()+2);
						  }

						//  $this->cell($this->anchos[1],10,number_format($arrp["saldo"],2,'.',','),0,0,'R');


			   if ((($niv == (($this->nrorup)-1) and (($this->nrorup)-1) >0) or
					($niv == (($this->nrorup)-2) and (($this->nrorup)-2) >0) or
					($niv == (($this->nrorup)-3) and (($this->nrorup)-3) >0) or
					($niv == (($this->nrorup)-4) and (($this->nrorup)-4) >0) or
					($niv == (($this->nrorup)-5) and (($this->nrorup)-5) >0) or
					($niv == (($this->nrorup)-6) and (($this->nrorup)-6) >0) or
					($niv == (($this->nrorup)-7) and (($this->nrorup)-7) >0) or
					(trim($arrp["titulo"]=='TOTAL')) )  and

	 			   (trim($arrp["cargable"]=='C'))  )
				   {  //print $arrp["nombre"]."<br>";
				   				///$this->cell($this->anchos[1],10," ");
								///$this->cell($this->anchos[2],10,number_format($arrp["saldo"],2,'.',','),0,0,'R');
//$this->setx(70);
$this->SetX(110);
				   	if ((strlen(rtrim($arrp["cuenta"]))) <= ($this->nivel2)){
								//$this->cell($this->anchos[1],10," ");
								$this->cell(20,10,H::FormatoMonto($arrp["saldo"]),0,0,'R');
								 }
					}

				   if ((trim($arrp["titulo"]=='TOTAL')) ){
				   	   //if ((trim($arrp["titulo"]=='TOTAL')) and (trim($arrp["saldo"]<>0))){
							//	$a=$objConbalgen1->SQL_calcular($arrp["cuenta"]);
							//	$monto=$a[0]["saldo"];
	                            if (strlen(trim($arrp["cuenta"]))==5)
	                            {$this->SetX(150);
	                            $this->cell(20,10,H::FormatoMonto($arrp["saldo"]),0,0,'R');
								$this->Line(150,$this->GetY()+2,170,$this->GetY()+2);
	                            }
	                            else if ((strlen(trim($arrp["cuenta"]))==3))
	                            {$this->SetX(170);
	                            $this->cell(20,10,H::FormatoMonto($arrp["saldo"]),0,0,'R');
								$this->Line(170,$this->GetY()+2,190,$this->GetY()+2);
	                            }
	                            else if ((strlen(trim($arrp["cuenta"]))==1))
	                            { $this->SetX(190);
	                            $this->cell(20,10,H::FormatoMonto($arrp["saldo"]),0,0,'R');
								$this->Line(190,$this->GetY()+2,210,$this->GetY()+2);
	                            }
	                            else
	                            { $this->SetX(130);
								$this->cell(20,10,H::FormatoMonto($arrp["saldo"]),0,0,'R');
								$this->Line(130,$this->GetY()+2,150,$this->GetY()+2);
  	                            }
				   }

			   if ((
					($niv == (($this->nrorup)-2) and (($this->nrorup)-2) >0) or
					($niv == (($this->nrorup)-3) and (($this->nrorup)-3) >0) or
					($niv == (($this->nrorup)-4) and (($this->nrorup)-4) >0) or
					($niv == (($this->nrorup)-5) and (($this->nrorup)-5) >0) or
					($niv == (($this->nrorup)-6) and (($this->nrorup)-6) >0) or
					($niv == (($this->nrorup)-7) and (($this->nrorup)-7) >0) or
 					($niv == (($this->nrorup)-8) and (($this->nrorup)-8) >0)) and
	 			    ($mov<>'C') and (trim($arrp["titulo"]=='TOTAL'))  )
					//print $arrp["cuenta"]."   -  ".$arrp["nombre"]."   - ".$this->saldo."   -".strlen(rtrim($arrp["cuenta"]))." - ".$this->nivel2."<br>";
				   	if ((strlen(rtrim($arrp["cuenta"]))) <= ($this->nivel2)){
//						   $this->Line($this->GetX()+3,$this->GetY()+2,$this->GetX()-30,$this->GetY()+2);
						   }


			   if (
 					($niv == (($this->nrorup)-1)) and ((($this->nrorup)-1) >0) and
	 			    ($mov<>'C') and (trim($arrp["titulo"]=='TOTAL')) ){
					//print $arrp["cuenta"]."   -  ".$arrp["nombre"]."   - ".$this->saldo."   -".strlen(rtrim($arrp["cuenta"]))." - ".$this->nivel2."<br>";
						  //$this->Line($this->GetX()-70,$this->GetY()+2,$this->GetX()-10,$this->GetY()+2);
						   }


				/*if ($sw==0){
						// $this->ln(4);
						 $this->cell($this->anchos[1],10," ");
						 $this->cell($this->anchos[2],10,number_format($arrp["saldo"],2,'.',','),0,0,'R');
						 $this->Line($this->GetX(),$this->GetY()+2,200,$this->GetY()+2);

				} else {
						if ($arrp["cargable"]=='C')
						{ $this->cell($this->anchos[1],10,number_format($arrp["saldo"],2,'.',','),0,0,'R'); }
						}*/

				// if ((trim($arrp["saldo"]<>0)))
				 {
				   $this->ln(5);
				 }


		        }  //EndIF


			}
		/*	if ($i==1)
			{    $this->setX(35);
	 			 $this->setFont("Arial","B",7);
				 $this->cell($this->anchos[0],10,"PASIVO + CAPITAL");
				 $this->CalcularResultado();
	 			 $this->cell(40,10,H::FormatoMonto($this->Total_Resultado),0,0,'R');
				 $this->ln(4);
	 		     $this->Line(115,$this->GetY()+3,130,$this->GetY()+3);
				 $this->ln(4);
				 $this->Line(115,$this->GetY(),130,$this->GetY());
			}*/
	}


	function CalcularResultado()
	{
		$temp = new Conbalgen1();
		$tb = $temp->SQLContaba2();

		if ($tb)
		{
			$cuenta_pasivo    = $tb[0]["cuenta_pasivo"];
			$cuenta_capital   = $tb[0]["cuenta_capital"];
			$cuenta_resultado = $tb[0]["cuenta_resultado"];
		}

		if (!$tb = $temp->SQLContabb1_pasivo($this->periodo))
		{
			   if (rtrim($cuenta_capital) == rtrim($cuenta_pasivo))
			   {
			   		$capital = 0;
			   }else{
					if ($tb = $temp->SQLContabb1_capital($this->periodo))
					{
						$capital = $tb[0]["capital"];
					}else{ $capital=0; }
			   }

				if ($tb = $temp->SQLContabb1_ingreso($this->periodo))
				{
					$ingreso = $tb[0]["ingreso"];
				}else{ $ingreso=0; }

				if ($tb = $temp->SQLContabb1_egreso($this->periodo))
				{
					$egreso = $tb[0]["egreso"];
				}else{ $egreso=0; }

			   if ((rtrim($cuenta_resultado)==rtrim($cuenta_pasivo)))
			   {
			   		$resultado = 0;
			   }else{
					if ($tb = $temp->SQLContabb1_resultado($this->periodo))
					{
						$resultado = $tb[0]["resultado"];
					}
				}
//FALTA BUSCAR LA VARIABLE PASIVO
			   if (abs($ingreso) > abs($egreso))
			   {
			   		$this->Total_Resultado=(abs($pasivo+$capital+$resultado-(abs($ingreso)-abs($egreso))));
			   }else{
			   		$this->Total_Resultado=(abs($pasivo+$capital+$resultado-(abs($ingreso)-abs($egreso))));
			   }

			}
		}

	function CalcularIngresoYEgreso(){
		$temp = new Conbalgen1();
		if ($tb = $temp->SQLContabb1_ingreso($this->periodo))
		{
			$Tingreso = $tb[0]["ingreso"];

		}else{ $Tingreso = 0; }

		if ($tb = $temp->SQLContabb1_egreso($this->periodo))
		{
			$Tegreso = $tb[0]["egreso"];

		}else{ $Tegreso = 0; }


		$this->total=(abs((abs($Tingreso)-abs($Tegreso))*-1));
		$this->saldo=$this->saldo + ((abs($Tingreso)-abs($Tegreso))*-1);

		/*  SET SALDO = SALDO + (ABS(INGRESOS) - ABS(EGRESOS))*(-1)
		 WHERE RTRIM(CUENTA)>=SUBSTR(CUENTA_RESULTADO,1,INSTR(CUENTA_RESULTADO,'-',1,1)-1) AND
			   RTRIM(CUENTA)<=RTRIM(CUENTA_RESULTADO) AND
			   INSTR(RTRIM(CUENTA_RESULTADO),RTRIM(CUENTA))<>0;				*/

			}
	}
?>