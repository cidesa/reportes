<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/general/funcionescontabilidad.php");	
/*
AYUDA:
Cell(with,healt,Texto,border,linea,align,fillm-Fondo,link)
AddFont(family,style,file)
ln() -> Salto de Linea
*/
	
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
			$this->fpdf("l","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->campos=array();
			$this->anchos=array();
			$this->titulos=array();						
			$this->codcta1=$_POST["codcta1"];
			$this->codcta2=$_POST["codcta2"];
			$this->periodo=$_POST["periodo"];
			$this->auxnivel=$_POST["auxnivel"];
			$this->auxnivel2=$_POST["auxnivel2"];
			$this->comodin=$_POST["comodin"];
			$this->nrorup=$_POST["nrorup"];
			$this->nrorup2=$_POST["nrorup2"];			
			$this->obtenerFecha();
			$this->sql="SELECT  A.ORDEN,
								A.TITULO,
								A.CUENTA,
								A.NOMBRE,
								A.DEBITO,
								A.CREDITO,
								A.SALDO as SALDO,
								A.CARGABLE
						FROM 
							(SELECT RTRIM(A.CODCTA) AS ORDEN,
									A.CODCTA AS TITULO,
									A.CODCTA AS CUENTA,						 	
									substr(B.DESCTA,1,60) AS NOMBRE,
									A.TOTDEB AS DEBITO,
									A.TOTCRE AS CREDITO,
									 A.SALACT AS SALDO,
									B.CARGAB AS CARGABLE,'C'
								 FROM 
									CONTABB1 A,
									CONTABB B
								 WHERE 
									A.CODCTA=B.CODCTA AND
									A.PEREJE = ('".$this->periodo."') AND
									A.FECINI = ('".$this->fecha_ini."') AND
									A.FECCIE = ('".$this->fecha_cie."') 
								UNION ALL 
								SELECT RTRIM(A.CODCTA)||'T' AS ORDEN,'TOTAL' AS TITULO,
									A.CODCTA AS CUENTA,						 	
									substr(B.DESCTA,1,60) AS NOMBRE,
									A.TOTDEB AS DEBITO,
									A.TOTCRE AS CREDITO,
									 A.SALACT AS SALDO,
									B.CARGAB AS CARGABLE,'C'
								 FROM 
									CONTABB1 A,
									CONTABB B
									
								 WHERE A.CODCTA=B.CODCTA AND
									   A.PEREJE = ('".$this->periodo."') AND
									   A.FECINI = ('".$this->fecha_ini."') AND
									   A.FECCIE = ('".$this->fecha_cie."') AND
									   B.CARGAB<>'C') A,

								CONTABA B
						WHERE 
								LENGTH(RTRIM(A.CUENTA))<= ('".$this->nivel."') AND
								RTRIM( A.CUENTA) >= RTRIM('".$this->codcta1."') AND
								RTRIM(A.CUENTA) <= RTRIM('".$this->codcta2."')  AND  
								RTRIM(A.CUENTA) LIKE RTRIM('".$this->comodin."') AND
								((A.CARGABLE='C' AND A.SALDO <> 0 ) OR (A.CARGABLE<>'C')) AND
								( A.CUENTA LIKE (RTRIM(B.CODTESACT)||'%')  OR
								A.CUENTA LIKE (RTRIM(B.CODTESPAS)||'%') OR
								A.CUENTA LIKE (RTRIM(B.CODCTA)||'%') OR
								A.CUENTA LIKE (RTRIM(B.CODCTD)||'%') )
								ORDER BY A.ORDEN  ";
								//print $this->sql;


			$this->sql2="SELECT  A.ORDEN,
								A.TITULO,
								A.CUENTA,
								A.NOMBRE,
								A.DEBITO,
								A.CREDITO,
								A.SALDO as SALDO,
								A.CARGABLE
						FROM 
							(SELECT RTRIM(A.CODCTA) AS ORDEN,
									A.CODCTA AS TITULO,
									A.CODCTA AS CUENTA,						 	
									substr(B.DESCTA,1,60) AS NOMBRE,
									A.TOTDEB AS DEBITO,
									A.TOTCRE AS CREDITO,
									 A.SALACT AS SALDO,
									B.CARGAB AS CARGABLE,'C'
								 FROM 
									CONTABB1 A,
									CONTABB B
								 WHERE 
									A.CODCTA=B.CODCTA AND
									A.PEREJE = ('".$this->periodo."') AND
									A.FECINI = ('".$this->fecha_ini."') AND
									A.FECCIE = ('".$this->fecha_cie."') 
								UNION ALL 
								SELECT RTRIM(A.CODCTA)||'T' AS ORDEN,'TOTAL' AS TITULO,
									A.CODCTA AS CUENTA,						 	
									substr(B.DESCTA,1,60) AS NOMBRE,
									A.TOTDEB AS DEBITO,
									A.TOTCRE AS CREDITO,
									 A.SALACT AS SALDO,
									B.CARGAB AS CARGABLE,'C'
								 FROM 
									CONTABB1 A,
									CONTABB B
									
								 WHERE A.CODCTA=B.CODCTA AND
									   A.PEREJE = ('".$this->periodo."') AND
									   A.FECINI = ('".$this->fecha_ini."') AND
									   A.FECCIE = ('".$this->fecha_cie."') AND
									   B.CARGAB<>'C') A,

								CONTABA B
						WHERE 
								LENGTH(RTRIM(A.CUENTA))<= ('".$this->nivel."') AND
								RTRIM( A.CUENTA) >= RTRIM('".$this->codcta1."') AND
								RTRIM(A.CUENTA) <= RTRIM('".$this->codcta2."')  AND  
								RTRIM(A.CUENTA) LIKE RTRIM('".$this->comodin."') AND
								((A.CARGABLE='C' AND A.SALDO <> 0 ) OR (A.CARGABLE<>'C')) AND
								( A.CUENTA LIKE (RTRIM(B.CODORD)||'%') )
								ORDER BY A.ORDEN";
		//print $this->sql2;											
			$this->llenartitulosmaestro();
			$this->cab=new cabecera();			
		}
		
		function instr($palabra,$busqueda,$comienzo,$concurrencia){

		$tamano=strlen($palabra);

		$cont=0;
		$cont_conc=0;

		for ($i=$comienzo;$i<=$tamano;$i++){
			$cont=$cont+1;
			if ($palabra[$i]==$busqueda):
				$cont_conc=$cont_conc+1;

				if ($cont_conc==$concurrencia):
					$i=$tamano;
				endif;
			endif;
		}
			if ($concurrencia > $cont_conc ):
				 $cont=0;
			else:
				 $cont;
			endif;

		return $this->instr=$cont;
		}

		function obtenerFecha()
		{					
		  $tb3=$this->bd->select("select fecini  as fechainic, forcta as forcta from contaba");
			if (!$tb3->EOF){
				$this->fechainicio=$tb3->fields["fechainic"];
				$this->forcta=$tb3->fields["forcta"];	
				}					
				
			$this->valor=instr($this->forcta,'-',0,1);		
//		   $tb4=$this->bd->select("SELECT coalesce(LENGTH(SUBSTR(FORCTA,1,position('-' in FORCTA)-1)), 0) as LONIV1,
		   $tb4=$this->bd->select("SELECT coalesce(coalesce(LENGTH(SUBSTR(FORCTA,1,".$this->valor."))-1, 0), 0) as LONIV1,
	   								FECINI as fecha_ini,
									FECCIE as fecha_cie,		
									CODRES as cuenta_resultado
 								  FROM 
									CONTABA");
									
				if (!$tb4->EOF)
				{
					$this->loniv1=$tb4->fields["loniv1"];
					$this->fecha_ini=$tb4->fields["fecha_ini"];
					$this->fecha_cie=$tb4->fields["fecha_cie"];
					$this->cuenta_resultado=$tb4->fields["cuenta_resultado"];					
				} //EndIf

			
			$tb11=$this->bd->select("SELECT to_char(B.FECDES,'dd/mm/yyyy') as fecdes, to_char(B.FECHAS,'dd/mm/yyyy') as fechas FROM CONTABB1 A, CONTABA1 B WHERE A.PEREJE=B.PEREJE and a.pereje=('".$this->periodo."') ");	
			//print $tb11;
			if (!$tb11->EOF)
				{
					
					$this->fecdes=$tb11->fields["fecdes"];
					$this->fechas=$tb11->fields["fechas"];
					
				} //EndIf
  		   							
			////// AUXNIVEL 1   ////////

			  if ($this->auxnivel==$this->nrorup) 
			   {
					$tb5=$this->bd->select("SELECT coalesce(LENGTH(RTRIM(FORCTA)), 0) as nivel FROM contaba"); 			
						if (!$tb5->EOF)
						{
							$this->nivel=$tb5->fields["nivel"];
						}			 //EndIf	
			   }	  //EndIf 
			   else
			   {
	 			    $this->valor=instr($this->forcta,'-',0,$this->auxnivel);		
					//$tb5=$this->bd->select("SELECT coalesce(LENGTH(SUBSTR(FORCTA,1,position('-' in FORCTA)-1)), 0) as nivel FROM contaba");
					//SELECT NVL(LENGTH(SUBSTR(FORCTA,1,INSTR(FORCTA,'-',1,:AUXnivel)-1)), 0) INTO :Nivel FROM CONTABA; 					
 				    $tb5=$this->bd->select("SELECT coalesce(coalesce(LENGTH(SUBSTR(FORCTA,1,'".$this->valor."'))-1, 0), 0) as nivel FROM contaba");
						if (!$tb5->EOF)
						{
							$this->nivel=$tb5->fields["nivel"];								
						}					//EndIf
			   } //EndIf
		

   			////// AUXNIVEL 2   ////////
			  if ($this->auxnivel2==$this->nrorup) 
			   {
					$tb6=$this->bd->select("SELECT coalesce(LENGTH(RTRIM(FORCTA)), 0) as nivel2 FROM contaba"); 					
						if (!$tb6->EOF)
						{
							$this->nivel2=$tb6->fields["nivel2"];
						}			 //EndIf	
			   }	  //EndIf 
			   else
			   {
	  			    $this->valor=instr($this->forcta,'-',0,$this->auxnivel2);		
					$tb6=$this->bd->select("SELECT coalesce(LENGTH(SUBSTR(FORCTA,1,'".$this->valor."'))-1, 0) as nivel2 FROM contaba");
			//								SELECT NVL(LENGTH(SUBSTR(FORCTA,1,INSTR(FORCTA,'-',1,:AUXnivel2)-1)), 0) INTO :Nivel2 FROM CONTABA; 
					//$tb6=$this->bd->select("SELECT coalesce(LENGTH(SUBSTR(FORCTA,1,position('-' in FORCTA)-1)), 0) as nivel2 FROM contaba"); 
						if (!$tb6->EOF)
						{
							$this->nivel2=$tb6->fields["nivel2"];								
						}					//EndIf
			   } //EndIf
			   
		}	//Return


		function llenartitulosmaestro()
		{
				$this->anchos[0]=140;
				$this->anchos[1]=40;
				$this->anchos[2]=40;
				$this->anchos[3]=120;				
		}

		function Header()
		{
			$this->cab->poner_cabecera($this,$_POST["titulo"],"l","s");
			$this->setFont("Arial","",9);
			$this->cell(30,5,'                                                                                                                                     Expresado en Bolivares');
			$this->setFont("Arial","B",9);
			$this->SetX(10);
			$this->cell(40,10,"Desde: ".$this->fecdes);
			$this->cell(40,10,"Hasta: ".$this->fechas);		
			$this->ln(5);
			$this->cell($this->anchos[1],10,"Codigo de Cuenta");
			$this->cell($this->anchos[0],10,"Descripcion de Cuenta");
			//$this->cell(35,10,"Columna 1",0,0,'R');			 				
			//$this->cell(35,10,"Columna 2",0,0,'R');			 				
			$this->Line(10,49,270,49);
			$this->ln(); 
			
		}
		
		
		function Cuerpo()
		{
			for ($i=1;$i<3;$i++){ $this->Datos($i);	 }    
		}
		
		
	function Datos($i){
		 if ($i==1){	$tb=$this->bd->select($this->sql);	}
		 else{	$tb=$this->bd->select($this->sql2);	}
		 
	        $sw=1;
			while(!$tb->EOF)			
			{ 
				if($tb->fields["titulo"]!=" ")
				{	
				 $this->setFont("Arial","",8);				    			

						/////////////////////////////////////////////
								$palabra=$tb->fields["cuenta"];
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
					  if (($niv == ($this->nrorup) and (trim($tb->fields["cargable"]=='C'))) ){
					       $sw1=1; }
  				      else{
							   if ((($niv == (($this->nrorup)-1) and (($this->nrorup)-1) >0) or 
									($niv == (($this->nrorup)-2) and (($this->nrorup)-2) >0) or 			   
									($niv == (($this->nrorup)-3) and (($this->nrorup)-3) >0) or 
									($niv == (($this->nrorup)-4) and (($this->nrorup)-4) >0) or 
									($niv == (($this->nrorup)-5) and (($this->nrorup)-5) >0) or 			   
									($niv == (($this->nrorup)-6) and (($this->nrorup)-6) >0) or 
									($niv == (($this->nrorup)-7) and (($this->nrorup)-7) >0)) ){

									if ((strlen(rtrim($tb->fields["cuenta"]))) <= ($this->nivel2)){ 
										$sw1=1; }
								}
						  }   
					  //and (trim($tb->fields["saldo"]<>0))) ){						  
				 
					 if ((ltrim(rtrim($tb->fields["titulo"]))=='TOTAL') and $sw1==1) {			
						$this->setFont("Arial","B",8); 			 							
				 		 $descta=strtoupper(str_pad(' ',strlen(rtrim($tb->fields["cuenta"]))*2,' ',STR_PAD_RIGHT).$tb->fields["titulo"]." ".$tb->fields["nombre"]);
						  $this->cell($this->anchos[0],10,$descta);
						 $sw=0;
					 } elseif ($sw1==1) {
  					    $this->setFont("Arial","",8); 		
						//print $this->s=str_pad(' ',strlen(rtrim($tb->fields["cuenta"]))*2,' ',STR_PAD_RIGHT);
						 $descta=strtoupper(str_pad(' ',strlen(rtrim($tb->fields["cuenta"]))*2,' ',STR_PAD_RIGHT).$tb->fields["nombre"]);
						$this->cell($this->anchos[0],10,$descta); 
						 $sw=1;
					 }   //EndIF
					 
					/* if ($sw1==1){
						 $descta=strtoupper(str_pad(' ',strlen(rtrim($tb->fields["cuenta"]))*2,' ',STR_PAD_RIGHT).$tb->fields["nombre"]);
						$this->cell($this->anchos[0],10,$descta); 
					 	
					 }*/
	
				 

				$this->CalcularIngresoYEgreso();


						/////////////////////////////////////////////
								$palabra=$tb->fields["cuenta"];
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
						  $tb_temp=$this->bd->select("SELECT CARGAB as mov FROM CONTABB  WHERE RTRIM(CODCTA)=RTRIM('".$tb->fields["cuenta"]."')");
						    if (!empty($tb_temp->fields["mov"])){ $mov=$tb_temp->fields["mov"]; }
						
						//$this->nrorup=(($this->nrorup)-1);
			  if (($niv == ($this->nrorup)  and (trim($tb->fields["cargable"]=='C')) and (trim($tb->fields["saldo"]<>0))) ){
						 
						 $this->cell($this->anchos[1],10,number_format($tb->fields["saldo"],2,'.',','),0,0,'R');				 
						 //$this->Line($this->GetX(),$this->GetY()+2,200,$this->GetY()+2);
						  }
			  
						//  $this->cell($this->anchos[1],10,number_format($tb->fields["saldo"],2,'.',','),0,0,'R');


			   if ((($niv == (($this->nrorup)-1) and (($this->nrorup)-1) >0) or 
					($niv == (($this->nrorup)-2) and (($this->nrorup)-2) >0) or 			   
					($niv == (($this->nrorup)-3) and (($this->nrorup)-3) >0) or 
					($niv == (($this->nrorup)-4) and (($this->nrorup)-4) >0) or 
					($niv == (($this->nrorup)-5) and (($this->nrorup)-5) >0) or 			   
					($niv == (($this->nrorup)-6) and (($this->nrorup)-6) >0) or 
					($niv == (($this->nrorup)-7) and (($this->nrorup)-7) >0) or					
					(trim($tb->fields["titulo"]=='TOTAL')) )  and 
 					
	 			   (trim($tb->fields["cargable"]=='C'))  )
				   {  //print $tb->fields["nombre"]."<br>";
				   				///$this->cell($this->anchos[1],10," ");														 					 
								///$this->cell($this->anchos[2],10,number_format($tb->fields["saldo"],2,'.',','),0,0,'R'); 					

				   	if ((strlen(rtrim($tb->fields["cuenta"]))) <= ($this->nivel2)){
								$this->cell($this->anchos[1],10," ");														 					 								
								$this->cell($this->anchos[2],10,number_format($tb->fields["saldo"],2,'.',','),0,0,'R'); 					
								 }
					}

				   if ((trim($tb->fields["titulo"]=='TOTAL')) and (trim($tb->fields["saldo"]<>0)) ){				   
								$this->cell($this->anchos[1],10," ");
								$this->cell($this->anchos[2],10,number_format($tb->fields["saldo"],2,'.',','),0,0,'R'); 				   
								$this->Line($this->GetX()+3,$this->GetY()+2,$this->GetX()-30,$this->GetY()+2); 
				   }
						
			   if ((
					($niv == (($this->nrorup)-2) and (($this->nrorup)-2) >0) or 				   
					($niv == (($this->nrorup)-3) and (($this->nrorup)-3) >0) or 
					($niv == (($this->nrorup)-4) and (($this->nrorup)-4) >0) or 
					($niv == (($this->nrorup)-5) and (($this->nrorup)-5) >0) or 			   
					($niv == (($this->nrorup)-6) and (($this->nrorup)-6) >0) or 
					($niv == (($this->nrorup)-7) and (($this->nrorup)-7) >0) or					
 					($niv == (($this->nrorup)-8) and (($this->nrorup)-8) >0)) and 
	 			    ($mov<>'C') and (trim($tb->fields["titulo"]=='TOTAL'))  )
					//print $tb->fields["cuenta"]."   -  ".$tb->fields["nombre"]."   - ".$this->saldo."   -".strlen(rtrim($tb->fields["cuenta"]))." - ".$this->nivel2."<br>";
				   	if ((strlen(rtrim($tb->fields["cuenta"]))) <= ($this->nivel2)){										
//						   $this->Line($this->GetX()+3,$this->GetY()+2,$this->GetX()-30,$this->GetY()+2); 
						   }


			   if (
 					($niv == (($this->nrorup)-1)) and ((($this->nrorup)-1) >0) and 
	 			    ($mov<>'C') and (trim($tb->fields["titulo"]=='TOTAL')) ){ 
					//print $tb->fields["cuenta"]."   -  ".$tb->fields["nombre"]."   - ".$this->saldo."   -".strlen(rtrim($tb->fields["cuenta"]))." - ".$this->nivel2."<br>";					
						  //$this->Line($this->GetX()-70,$this->GetY()+2,$this->GetX()-10,$this->GetY()+2); 
						   }

				
				/*if ($sw==0){  
						// $this->ln(4);	 	
						 $this->cell($this->anchos[1],10," ");														 					 
						 $this->cell($this->anchos[2],10,number_format($tb->fields["saldo"],2,'.',','),0,0,'R');				 
						 $this->Line($this->GetX(),$this->GetY()+2,200,$this->GetY()+2);
						 
				} else { 
						if ($tb->fields["cargable"]=='C')
						{ $this->cell($this->anchos[1],10,number_format($tb->fields["saldo"],2,'.',','),0,0,'R'); }
						}*/
				 $this->ln(5);
						 
		        }  //EndIF
	
				$tb->MoveNext();
			}			
			if ($i==1){
 			 $this->setFont("Arial","B",10);
			 $this->cell($this->anchos[0],10,"PASIVO + CAPITAL");			
			 $this->CalcularResultado();
 			 $this->cell($this->anchos[1]+6,10,number_format($this->Total_Resultado,2,'.',','),0,0,'R');				 						 
			 $this->ln(4);
 		     $this->Line(165,$this->GetY()+3,200,$this->GetY()+3);
			 $this->ln(4);			 
			 $this->Line(165,$this->GetY(),200,$this->GetY());  }
	}


	function CalcularResultado(){
	
	  $tb99=$this->bd->select("SELECT 
	  							CODTESPAS as CUENTA_PASIVOS,
						        CODCTA as CUENTA_CAPITAL,
								CODRESANT as CUENTA_RESULTADO
							FROM 
								CONTABA
						   WHERE
						   		CODEMP= '001'");
					if (!$tb99->EOF){  
							$cuenta_pasivo=$tb99->fields["cuenta_pasivo"];
							$cuenta_capital=$tb99->fields["cuenta_capital"];
							$cuenta_resultado=$tb99->fields["cuenta_resultado"];	}			 
							
		  $tb990=$this->bd->select("SELECT
                  (A.SALACT) as PASIVO
                FROM
                  CONTABB1 A,
                    CONTABA B
                  WHERE
                  RTRIM(A.CODCTA)=RTRIM(B.CODTESPAS) AND
                    A.PEREJE = ('".$this->periodo."') AND
                  A.FECINI = B.FECINI AND
                    A.FECCIE = B.FECCIE");   //Valor de los pasivos
					//print $tb990;
					//$pasivo=$tb990;
					$pasivo=$tb990->fields["pasivo"];
					//echo $pasivo;
								 
							if (!$tb990->EOF)
							{  							 
								   if (rtrim($cuenta_capital)==rtrim($cuenta_pasivo)) { $capital= 0;  }
								   	else {  $tb99=$this->bd->select("SELECT 
									  								A.SALACT as capital										   
															   FROM 
															   		CONTABB1 A,	
																	CONTABA B
															   WHERE
															   		A.CODCTA=rpad(B.CODCTA,32,' ') AND
																	A.PEREJE = ('".$this->periodo."') AND
																	A.FECINI = B.FECINI AND
																	A.FECCIE = B.FECCIE"); 
																																		
											$capital=$tb99->fields["capital"]; } 
											
								$tb99=$this->bd->select("SELECT A.SALACT as INGRESO
														 FROM 
															CONTABB1 A, 
															CONTABA B
														 WHERE 
															A.CODCTA=rpad(B.CODIND,32,' ') AND
															A.PEREJE = ('".$this->periodo."') AND
															A.FECINI = B.FECINI AND
															A.FECCIE = B.FECCIE");
															
												$ingreso=$tb99->fields["ingreso"];			
						   
								 $tb99=$this->bd->select("SELECT (A.SALACT) as EGRESO
														  FROM 
															CONTABB1 A, 
															CONTABA B
														  WHERE 
															A.CODCTA=rpad(B.CODEGD,32,' ') AND
															A.PEREJE = ('".$this->periodo."') AND
															A.FECINI = B.FECINI AND
															A.FECCIE = B.FECCIE");
															
												$egreso=$tb99->fields["egreso"];
												
						   if ((rtrim($cuenta_resultado)==rtrim($cuenta_pasivo))) { $resultado = 0;  } 
						   else {  $tb99=$this->bd->select("SELECT A.SALACT as resultado
														   FROM
															 CONTABB1 A, 
															 CONTABA B
														   WHERE 
																A.CODCTA=rpad(B.CODCTD,32,' ') AND
																A.PEREJE = ('".$this->periodo."') AND
																A.FECINI = B.FECINI AND
																A.FECCIE = B.FECCIE"); 
											
												  $patrimonio=$tb99->fields["resultado"];  //Valor del patrimonio
						//echo $resultado;
						}
				$resultado=abs($ingreso)-abs($egreso);
              if (abs($ingreso) > abs($egreso))
              {  $this->Total_Resultado=(abs($pasivo+$capital+$patrimonio))-abs($resultado);   }
              else { $this->Total_Resultado=(abs($pasivo+$capital+$patrimonio))-abs($resultado); }
						} 
				}
	
	function CalcularIngresoYEgreso(){

			$tb50=$this->bd->select("SELECT A.SALACT as INGRESO
									FROM 
										CONTABB1 A, 
										CONTABA B
								   WHERE 
										 RTRIM(A.CODCTA) = RTRIM(B.CODIND) AND
										 A.PEREJE = '".$this->periodo."' AND
										 A.FECINI = B.FECINI AND
										 A.FECCIE = B.FECCIE");
			if (!$tb50->EOF){
				$Tingreso=$tb50->fields["ingreso"]; 
				}		 			

			$tb50=$this->bd->select("SELECT A.SALACT as EGRESO
									FROM 
										CONTABB1 A, 
										CONTABA B
								   WHERE 
										 RTRIM(A.CODCTA) = RTRIM(B.CODEGD) AND
										 A.PEREJE = '".$this->periodo."' AND
										 A.FECINI = B.FECINI AND
										 A.FECCIE = B.FECCIE");
			if (!$tb50->EOF){
				$Tegreso=$tb50->fields["egreso"]; 
				}		 			
				
			$this->total=(abs((abs($Tingreso)-abs($Tegreso))*-1));		
			$this->saldo=$this->saldo + ((abs($Tingreso)-abs($Tegreso))*-1);  
		/*  SET SALDO = SALDO + (ABS(INGRESOS) - ABS(EGRESOS))*(-1)
		 WHERE RTRIM(CUENTA)>=SUBSTR(CUENTA_RESULTADO,1,INSTR(CUENTA_RESULTADO,'-',1,1)-1) AND
			   RTRIM(CUENTA)<=RTRIM(CUENTA_RESULTADO) AND
			   INSTR(RTRIM(CUENTA_RESULTADO),RTRIM(CUENTA))<>0;				*/											
		
			}					
	}
?>