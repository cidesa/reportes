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
		var $comodin;
		var $archtxt;
		var $nrorup;

		var $fecperdes;
		var $feccie;

		var $cuenta;
		var $perant;
		var $salant;

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
			$this->comodin=$_POST["comodin"];
			$this->archtxt=$_POST["archtxt"];
			$this->nrorup=$_POST["nrorup"];
			$this->actualiza=$_POST["actualiza"];
			$this->obtenerFecha();
			$this->ChequearActualizar();
			$this->sql="select orden,
						rtrim(titulo) as titulo,
						rtrim(cuenta) as cuenta,
						rtrim(nombre) as nombre,
						debito,
						credito,
						saldo,
						(debito-credito) as salper,
						cargable
						from cfbalcom
						where length(rtrim(substr(cuenta,1,32)))<= ".$this->nivel."  and
						rtrim(substr(cuenta,1,32)) >= rtrim('".$this->codcta1."') and
						rtrim(substr(cuenta,1,32)) <=rtrim('".$this->codcta2."')  and
						rtrim(substr(cuenta,1,32)) like rtrim('".$this->comodin."')  and
						(saldo<>0 or debito<>0 or credito<> 0)
						group by orden,
						rtrim(titulo),
						rtrim(cuenta),
						rtrim(nombre),
						debito, credito,
						saldo,
						(debito-credito),
						cargable
						order by orden";


						//print $this->sql;
			$this->llenartitulosmaestro();
			$this->cab=new cabecera();
		}

		function ChequearActualizar(){
		  if ($this->actualiza=='SI'){
			 $this->ReactualizarSaldosAnteriores();
			 $this->ActualizarMaestro();
		  } //EndIf;
		} //Return

		function ReactualizarSaldosAnteriores(){
			$tb30=$this->bd->select("SELECT
										   SUBSTR(CODCTA,1,14) AS CUENTA,
										   SUM(COALESCE(SALANT,0)) AS SALDO
									FROM
										CONTABB
									WHERE
										upper(CARGAB)='C'
									GROUP BY SUBSTR(CODCTA,1,14)");

					while(!$tb30->EOF){
						$this->bd->actualizar("update contabb set salant=".$tb30->fields["saldo"]." where codcta=rpad('".$tb30->fields["cuenta"]."',32,' ')");
					$tb30->MoveNext(); }
				//--------------

			   $tb30=$this->bd->select("SELECT SUBSTR(CODCTA,1,10) as CUENTA,SUM(coalesce(SALANT,0)) as SALDO FROM CONTABB WHERE upper(CARGAB)='C' GROUP BY SUBSTR(CODCTA,1,10)");
					while(!$tb30->EOF){
						$this->bd->actualizar("update contabb set salant=".$tb30->fields["saldo"]." where codcta=rpad('".$tb30->fields["cuenta"]."',32,' ')");
					$tb30->MoveNext(); }
				//--------------

			   $tb30=$this->bd->select("SELECT SUBSTR(CODCTA,1,07) as CUENTA,SUM(coalesce(SALANT,0)) as SALDO FROM CONTABB WHERE upper(CARGAB)='C' GROUP BY SUBSTR(CODCTA,1,07)");
					while(!$tb30->EOF){
						$this->bd->actualizar("update contabb set salant=".$tb30->fields["saldo"]." where codcta=rpad('".$tb30->fields["cuenta"]."',32,' ')");
					$tb30->MoveNext(); }
				//--------------

			   $tb30=$this->bd->select("SELECT SUBSTR(CODCTA,1,03) as CUENTA,SUM(coalesce(SALANT,0)) as SALDO FROM CONTABB WHERE upper(CARGAB)='C' GROUP BY SUBSTR(CODCTA,1,03)");
					while(!$tb30->EOF){
						$this->bd->actualizar("update contabb set salant=".$tb30->fields["saldo"]." where codcta=rpad('".$tb30->fields["cuenta"]."',32,' ')");
					$tb30->MoveNext(); }
				//--------------

			   $tb30=$this->bd->select("SELECT SUBSTR(CODCTA,1,01) as CUENTA,SUM(coalesce(SALANT,0)) as SALDO FROM CONTABB WHERE upper(CARGAB)='C' GROUP BY SUBSTR(CODCTA,1,01)");
					while(!$tb30->EOF){
						$this->bd->actualizar("update contabb set salant=".$tb30->fields["saldo"]." where codcta=rpad('".$tb30->fields["cuenta"]."',32,' ')");
					$tb30->MoveNext(); }
				//--------------
		} //Fin Return


		function ActualizarMaestro(){
			$tb06=$this->bd->select("select substr(codcta,1,14) as codcta,
											 RTRIM(to_char(a.feccom,'MM')) as mes,
											 sum(CASE WHEN a.debcre='D' THEN a.monasi ELSE 0 END) AS DEB,
											 sum(CASE WHEN a.debcre='C' THEN a.monasi ELSE 0 END) as CRE
									  from
									  		contabc1 a,
											contabc b
									where
											a.numcom=b.numcom and
											a.feccom = b.feccom and
											b.stacom='A'
									group by substr(codcta,1,14),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb04=$this->bd->select("select substr(codcta,1,10) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,sum(CASE WHEN a.debcre='D' THEN a.monasi ELSE 0 END) AS DEB,sum(CASE WHEN a.debcre='C' THEN a.monasi ELSE 0 END) as CRE from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,10),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb03=$this->bd->select("select substr(codcta,1,7) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,sum(CASE WHEN a.debcre='D' THEN a.monasi ELSE 0 END) AS DEB,sum(CASE WHEN a.debcre='C' THEN a.monasi ELSE 0 END) as CRE from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,7),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb02=$this->bd->select("select substr(codcta,1,3) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,sum(CASE WHEN a.debcre='D' THEN a.monasi ELSE 0 END) AS DEB,sum(CASE WHEN a.debcre='C' THEN a.monasi ELSE 0 END) as CRE from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,3),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb01=$this->bd->select("select substr(codcta,1,1) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,sum(CASE WHEN a.debcre='D' THEN a.monasi ELSE 0 END) AS DEB,sum(CASE WHEN a.debcre='C' THEN a.monasi ELSE 0 END) as CRE from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,1),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$cuentas=$this->bd->select("select codcta,to_char(fecini,'dd/mm/yyyy') as fecini,to_char(feccie,'dd/mm/yyyy') as feccie from contabb");
				//--------------

			$this->bd->actualizar("update contabb1 set totdeb=0,totcre=0,salact=0");
			//------ 06 --------
			while(!$tb06->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=".$tb06->fields["deb"].",totcre=".$tb06->fields["cre"]." where codcta=rpad('".$tb06->fields["codcta"]."',32,' ') and pereje='".$tb06->fields["mes"]."'");
			$tb06->MoveNext(); }
			//------ 04 --------
			while(!$tb04->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=".$tb04->fields["deb"].",totcre=".$tb04->fields["cre"]." where codcta=rpad('".$tb04->fields["codcta"]."',32,' ') and pereje='".$tb04->fields["mes"]."'");
			$tb04->MoveNext(); }
			//------ 03 --------
			while(!$tb03->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=".$tb03->fields["deb"].",totcre=".$tb03->fields["cre"]." where codcta=rpad('".$tb03->fields["codcta"]."',32,' ') and pereje='".$tb03->fields["mes"]."'");
			$tb03->MoveNext(); }
			//------ 02 --------
			while(!$tb02->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=".$tb02->fields["deb"].",totcre=".$tb02->fields["cre"]." where codcta=rpad('".$tb02->fields["codcta"]."',32,' ') and pereje='".$tb02->fields["mes"]."'");
			$tb02->MoveNext(); }
			//------ 01 --------
			while(!$tb01->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=".$tb01->fields["deb"].",totcre=".$tb01->fields["cre"]." where codcta=rpad('".$tb01->fields["codcta"]."',32,' ') and pereje='".$tb01->fields["mes"]."'");
			$tb01->MoveNext(); }
			//-----------------//

			  while(!$cuentas->EOF){
				  $this->ActualizarSaldos($cuentas->fields["codcta"],$cuentas->fields["fecini"],$cuentas->fields["feccie"]);
				  $cuentas->MoveNext(); }
		} //Return

		//------------------------------------------------------------------------------------------------------//
		function ActualizarSaldos($codigo_cta,$fecha_ini,$fecha_cie){
  			 $tb10=$this->bd->select("SELECT CODCTA,TO_CHAR(FECINI,'DD/MM/YYYY') AS FECINI,
			                          TO_CHAR(FECCIE,'DD/MM/YYYY') AS FECCIE,PEREJE,TOTDEB,TOTCRE,
									  SALACT
										 FROM CONTABB1
										 WHERE CODCTA = rpad('".$codigo_cta."',32,' ')
												 AND FECINI = to_date('".$fecha_ini."','dd/mm/yyyy')
												 AND FECCIE = to_date('".$fecha_cie."','dd/mm/yyyy')
										 ORDER BY PEREJE;");

   			 $tb11=$this->bd->select("SELECT
									   SALANT as SALDO_ANT
									   FROM CONTABB
									   WHERE CODCTA = rpad('".$codigo_cta."',32,' ') AND
											FECINI = to_date('".$fecha_ini."','dd/mm/yyyy') AND
											FECCIE = to_date('".$fecha_cie."','dd/mm/yyyy');");
			$periodo_ant = '00';
			   while(!$tb10->EOF){
				   $this->bd->actualizar("UPDATE CONTABB1
						SET SALACT = (".$tb10->fields["totdeb"]."  + ".$tb11->fields["saldo_ant"].") - ".$tb10->fields["totcre"]."
					  WHERE CODCTA = ('".$tb10->fields["codcta"]."') AND
							PEREJE = ('".$tb10->fields["pereje"]."') AND
							FECINI = to_date('".$tb10->fields["fecini"]."','dd/mm/yyyy') AND
							FECCIE = to_date('".$tb10->fields["feccie"]."','dd/mm/yyyy');");


					   $periodo_ant = str_pad(strval(intval($periodo_ant)+1),2,'0',STR_PAD_LEFT);

					   $tb11=$this->bd->select("SELECT SALACT as SALDO_ANT
												 FROM CONTABB1
												 WHERE CODCTA = rpad('".$codigo_cta."',32,' ') AND
														FECINI = to_date('".$fec_ini."','dd/mm/yyyy') AND
														FECCIE = to_date('".$fec_cie."','dd/mm/yyyy') AND
														PEREJE = '".$periodo_ant."';");
				$tb10->MoveNext(); }
		}		// Return


		function obtenerFecha()
		{
		  $tb3=$this->bd->select("select to_char(fecini,'dd/mm/yyyy') as fechainic, forcta as forcta from contaba");
			if (!$tb3->EOF){
				$this->fechainicio=$tb3->fields["fechainic"];
				$this->forcta=$tb3->fields["forcta"];
				}

			$this->valor=instr($this->forcta,'-',0,1);
  		   $tb4=$this->bd->select("SELECT coalesce(coalesce(LENGTH(SUBSTR(FORCTA,1,".$this->valor."))-1, 0), 0) as LONIV1,
		   								to_char(FECINI,'dd/mm/yyyy') as fecha_ini,
										to_char(FECCIE,'dd/mm/yyyy') as fecha_cie
								   FROM
										CONTABA");

				if (!$tb4->EOF)
				{
					$this->loniv1=$tb4->fields["loniv1"];
					$this->fecha_ini=$tb4->fields["fecha_ini"];
					$this->fecha_cie=$tb4->fields["fecha_cie"];
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
 				    $tb5=$this->bd->select("SELECT coalesce(coalesce(LENGTH(SUBSTR(FORCTA,1,'".$this->valor."'))-1, 0), 0) as nivel FROM contaba");
						if (!$tb5->EOF)
						{
							$this->nivel=$tb5->fields["nivel"];
						}					//EndIf
			   } //EndIf
		}	//Return



		function llenartitulosmaestro()
		{
				$this->anchos[0]=120;
				$this->anchos[1]=40;
				$this->anchos[2]=40;
				$this->anchos[3]=45;
				$this->anchos[4]=75;
		}

		function Header()
		{

			$this->setFont("Arial","",9);
			$fecha=date("d/m/Y");
			$this->SetX(220);
			$this->Cell(30,15,'Fecha: '.$fecha);
			$this->ln(5);
			$this->SetX(220);
			$this->Cell(30,15,'Pagina: '.$this->PageNo().' de {nb}');
			$this->setFont("Arial","B",10);
			$this->SetTextColor(0,0,128);
			$this->SetXY(10,20);
			$this->Cell(170,5,'Sistema de Contabilidad Financiera');
			$this->ln(5);
			$this->setFont("Arial","B",12);
			$this->Cell(170,5,'BALANCE DE COMPROBACION');

			$f=$this->bd->select("select b.fecdes as fecperdes, b.fechas as fecperhas from contaba a, contaba1 b
  								where a.fecini = b.fecini and a.feccie = b.feccie and b.pereje = '".$this->periodo."'");

			$this->SetTextColor(0,0,0);
			$this->setFont("Arial","B",10);
			$this->SetXY(10,28);
			$this->Cell(270,10,'Del '.$f->fields["fecperdes"].' Al '.$f->fields["fecperhas"].'  (Periodo  '.$this->periodo.')');
			$this->SetXY(10,40);
			$this->cell($this->anchos[1],10,"Codigo de Cuenta");
			$this->cell($this->anchos[4],10,"Descripcion de Cuenta");

			$this->cell(35,10,"Saldo Anterior",0,0,'R');
			$this->cell(35,10,"Debe",0,0,'R');
			$this->cell(35,10,"Haber",0,0,'R');
 			$this->cell(40,10,"Saldo Actual",0,0,'R');
			$this->Line(10,48,270,48);
			$this->ln();
		}

		function fecha(){
			  $tb36=$this->bd->select("SELECT to_char(B.FECDES,'dd/mm/yyyy') as fecperdes
									  FROM
									  	CONTABA A, CONTABA1 B
									  WHERE A.FECINI = B.FECINI AND
											A.FECCIE = B.FECCIE AND
											B.PEREJE = '".$this->periodo."'");
					if (!$tb36->EOF){  $this->fecperdes=$tb36->fields["fecperdes"]; }

				 $tb36=$this->bd->select("SELECT to_char(B.FECHAS,'dd/mm/yyyy') as fecperhas
									FROM CONTABA A, CONTABA1 B
									WHERE A.FECINI = B.FECINI AND
											A.FECCIE = B.FECCIE AND
											B.PEREJE = '".$this->periodo."'");

					if (!$tb36->EOF){  $this->fecperhas=$tb36->fields["fecperhas"]; }
	         //Calcular el Periodo Anterior = perant
					  if($this->periodo=='01'){  $this->perant='12'; }
					  if($this->periodo=='02'){  $this->perant='01'; }
					  if($this->periodo=='03'){  $this->perant='02'; }
					  if($this->periodo=='04'){  $this->perant='03'; }
					  if($this->periodo=='05'){  $this->perant='04'; }
					  if($this->periodo=='06'){  $this->perant='05'; }
					  if($this->periodo=='07'){  $this->perant='06'; }
					  if($this->periodo=='08'){  $this->perant='07'; }
					  if($this->periodo=='09'){  $this->perant='08'; }
					  if($this->periodo=='10'){  $this->perant='09'; }
					  if($this->periodo=='11'){  $this->perant='10'; }
					  if($this->periodo=='12'){  $this->perant='11'; }
  			  ///////////////////
		} // Return

		function Cuerpo()
		{
			$tb=$this->bd->select($this->sql);
			$acum_saldo_ant=0;
			$acum_debe=0;
			$acum_haber=0;
			$acum_saldo_act=0;
  		    $this->setFont("Arial","",8);
  		    $y= 48;
			while(!$tb->EOF)
			{
				if ($y>=170){
					$this->AddPage();
					$y= 48;
				}
				$this->SetY($y);
				if ($tb->fields["titulo"]!=" "){
 				     $this->cuenta=$tb->fields["cuenta"];
					$this->Buscar_Saldo_Anterior();
					 if (ltrim(rtrim($tb->fields["titulo"]))=='TOTAL')
					 {
 					    $this->Line(119,$y,270,$y);//$this->GetY()+3,270,$this->GetY()+3);
						$this->cell($this->anchos[1],4," ");
						$this->setFont("Arial","B",8);
						$this->SetXY($this->anchos[1]+$this->anchos[4],$y);
							$this->cell(35,4,number_format(abs($this->salant),2,'.',','),0,0,'R');
							$this->cell(35,4,number_format(abs($tb->fields["debito"]),2,'.',','),0,'R',0);
							$this->cell(35,4,number_format(abs($tb->fields["credito"]),2,'.',','),0,'R',0);
							$this->cell(40,4,number_format(abs($tb->fields["saldo"]),2,'.',','),0,'R',0);
						$this->SetX($this->anchos[1]);
						$this->Multicell($this->anchos[4],4,strtoupper($tb->fields["titulo"]." ".$tb->fields["nombre"]));
						$this->ln(1);
						$y2=$this->GetY();
					$this->setFont("Arial","",8);
					 }
					 else
					 {
  					    $this->cell($this->anchos[1],4,$this->cuenta);
						$this->Multicell($this->anchos[4],4,strtoupper($tb->fields["nombre"]));
						$this->ln(1);
						$y2=$this->GetY();
					 }   //EndIF

					if ($tb->fields["cargable"]=='C')
					{
						$this->SetXY($this->anchos[1]+$this->anchos[4],$y);
						$this->cell(35,4,number_format(abs($this->salant),2,'.',','),0,0,'R');
						$this->cell(35,4,number_format($tb->fields["debito"],2,'.',','),0,0,'R');
						$this->cell(35,4,number_format($tb->fields["credito"],2,'.',','),0,0,'R');
						$this->cell(40,4,number_format(abs($tb->fields["saldo"]),2,'.',','),0,0,'R');
					}
					$y=$y2;
				}  //EndIf
			$tb->MoveNext();
			} //End While
			$tb_temp=$this->bd->select("SELECT SUM(B.TOTDEB)
										 AS TOTAL_DEB, SUM(B.TOTCRE) AS TOTAL_CRE
										 FROM CONTABB A,
											  CONTABB1 B,
											  CONTABA C
										WHERE A.CODCTA = B.CODCTA AND
											  A.CARGAB = 'C' AND
											  B.PEREJE = '".$this->periodo."' AND
											  B.FECINI = C.FECINI AND
											  B.FECCIE = C.FECCIE AND
											  RTRIM(SUBSTR(A.CODCTA,1,23)) >= RTRIM('".$this->codcta1."') AND
											  RTRIM(SUBSTR(A.CODCTA,1,23)) <= RTRIM('".$this->codcta2."')");
					if (!empty($tb_temp->fields["total_deb"])){
							$this->setFont("Arial","B",9);
							$this->ln();
							$this->cell($this->anchos[1],4," ");
							 $this->cell($this->anchos[4],4,"TOTAL DEBITO  :");
							 $this->cell(35,4,number_format($tb_temp->fields["total_deb"],2,'.',','),0,0,'R');
							 $this->ln(4);
							 $this->cell($this->anchos[1],4," ");
							 $this->cell($this->anchos[4],4,"TOTAL CREDITO:");
							 $this->cell(35,4,number_format($tb_temp->fields["total_cre"],2,'.',','),0,0,'R');
							 }
		}


	function Buscar_Saldo_Anterior(){
			  if (('".$this->periodo."') == '01'){
					$tb999=$this->bd->select("SELECT A.SALANT as salant
												FROM
													CONTABB A, CONTABA B
												WHERE
													A.CODCTA=rpad('".$this->cuenta."',32,' ') AND
													A.FECINI = B.FECINI AND
													A.FECCIE = B.FECCIE AND
													B.CODEMP='001'");
		  	  }else{
					$tb999=$this->bd->select("SELECT B.SALACT as salant
												FROM
													CONTABB1 B, CONTABA C
												WHERE
													B.CODCTA = rpad('".$this->cuenta."',32,' ') AND
													B.PEREJE = '".$this->perant."' AND
													B.FECINI = C.FECINI AND
													B.FECCIE = C.FECCIE AND
													C.CODEMP='001'"); }
					if (!$tb999->EOF){	$this->salant=$tb999->fields["salant"];	}else{  $this->salant=0; }
	}  //Fin Return

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
								    A.FECCIE = B.FECCIE");

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

						   if ((rtrim($cuenta_capital)==rtrim($cuenta_pasivo))) { $resultado = 0;  }
						   else {  $tb99=$this->bd->select("SELECT A.SALACT as resultado
														   FROM
															 CONTABB1 A,
															 CONTABA B
														   WHERE
																A.CODCTA=rpad(B.CODCTD,32,' ') AND
																A.PEREJE = ('".$this->periodo."') AND
																A.FECINI = B.FECINI AND
																A.FECCIE = B.FECCIE");

												$resultado=$tb99->fields["resultado"]; }

						   if (abs($ingreso) > abs($egreso))
						   {  $this->Total_Resultado=(abs($pasivo+$capital+$resultado-(abs($ingreso)-abs($egreso))));   }
						   else { $this->Total_Resultado=(abs($pasivo+$capital+$resultado-(abs($ingreso)-abs($egreso)))); }
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


			}			//Return
	} //	Fin
?>