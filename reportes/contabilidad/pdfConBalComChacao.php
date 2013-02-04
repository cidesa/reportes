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
			$this->codcta1=$_POST["CODCTA"];
			$this->codcta2=$_POST["CODCTA1"];
			$this->periodo=$_POST["periodo"];
			$this->auxnivel=$_POST["auxnivel"];
			$this->comodin=$_POST["comodin"];
			$this->archtxt=$_POST["archtxt"];
			$this->nrorup=$_POST["nrorup"];
			$this->actualizar=$_POST["actualizar"];
			$this->ChequearActualizar();
			$this->obtenerFecha();
			$this->periodoant=$this->periodo-1;
			if($this->periodoant<=9)
				$this->periodoant='0'.$this->periodoant;

			$this->sql="SELECT ORDEN,
								RTRIM(TITULO) as TITULO,
								RTRIM(CUENTA) as CUENTA,
								RTRIM(NOMBRE) as NOMBRE,
								DEBITO,
								CREDITO,
								--SALDO,
								(saldo+(DEBITO-CREDITO)) AS SALDO,
								CARGABLE
						FROM
							(SELECT RTRIM(A.CODCTA) AS ORDEN,
									A.CODCTA AS TITULO,
									A.CODCTA AS CUENTA,
									B.DESCTA AS NOMBRE,
									A.TOTDEB AS DEBITO,
									A.TOTCRE AS CREDITO,
									case when '$this->periodo'='01' then  b.SALant else (select salact from contabb1 where codcta=a.codcta and pereje='$this->periodoant') end  AS SALDO,
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
									B.DESCTA AS NOMBRE,
									A.TOTDEB AS DEBITO,
									A.TOTCRE AS CREDITO,
									case when '$this->periodo'='01' then  b.SALant else (select salact from contabb1 where codcta=a.codcta and pereje='$this->periodoant') end  AS SALDO,
									B.CARGAB AS CARGABLE,'C'
								 FROM
									CONTABB1 A,
									CONTABB B

								 WHERE A.CODCTA=B.CODCTA AND
									   A.PEREJE = ('".$this->periodo."') AND
									   A.FECINI = ('".$this->fecha_ini."') AND
									   A.FECCIE = ('".$this->fecha_cie."') AND
									   B.CARGAB<>'C') as A
						WHERE
								LENGTH(RTRIM(SUBSTR(CUENTA,1,32))) <= ('".$this->nivel."')  AND
								RTRIM(SUBSTR(CUENTA,1,32)) >= RTRIM('".$this->codcta1."') AND
								RTRIM(SUBSTR(CUENTA,1,32)) <=RTRIM('".$this->codcta2."')  AND
								RTRIM(SUBSTR(CUENTA,1,32)) LIKE RTRIM('".$this->comodin."')  AND
					--			((  ((A.CARGABLE='C' AND (ABS(A.SALDO+(A.DEBITO-A.CREDITO))) <> 0 ) OR (A.DEBITO<>0 OR A.CREDITO<>0) OR (A.CARGABLE<>'C'))
							(((A.SALDO<>0  OR A.DEBITO<>0 OR A.CREDITO<> 0) AND CUENTA NOT LIKE '7%') OR CUENTA LIKE '7%')
						--		( (A.CARGABLE='C' AND A.SALDO <> 0 ) OR (A.DEBITO<>0 OR A.CREDITO<>0) OR (A.CARGABLE<>'C'))
				 		--				AND CUENTA NOT LIKE '7%') OR CUENTA LIKE '7%')
								ORDER BY ORDEN";
//print "<pre>".$this->sql;exit;
			$this->llenartitulosmaestro();
			$this->cab=new cabecera();
		} 

		function ChequearActualizar(){
		  if ($this->actualizar=='SI'){
			 //print "hola";exit;
			 $this->bd=new basedatosAdo();
			 $this->ReactualizarSaldoAnteriores();
			 //$this->ActualizarMaestro;
		  } //EndIf;
		} //Return

		function ReactualizarSaldoAnteriores(){

				$this->bd->actualizar("

							--UPDATE CONTABB
								--SET SALANT=SALANT*-1 WHERE DEBCRE='C';

								UPDATE CONTABB1 SET TOTDEB=0,TOTCRE=0,SALACT=0;

								CREATE OR REPLACE VIEW SALDOS AS (
								SELECT SUBSTR(CODCTA,1,1) AS CUENTA,SUM(SALANT) AS SALDO
								FROM CONTABB
								WHERE CARGAB='C'
								GROUP BY SUBSTR(CODCTA,1,1)
								UNION
								SELECT SUBSTR(CODCTA,1,3) AS CUENTA,SUM(SALANT) AS SALDO
								FROM CONTABB
								WHERE CARGAB='C'
								GROUP BY SUBSTR(CODCTA,1,3)
								UNION
								SELECT SUBSTR(CODCTA,1,5) AS CUENTA,SUM(SALANT) AS SALDO
								FROM CONTABB
								WHERE CARGAB='C'
								GROUP BY SUBSTR(CODCTA,1,5)
								UNION
								SELECT SUBSTR(CODCTA,1,8) AS CUENTA,SUM(SALANT) AS SALDO
								FROM CONTABB
								WHERE CARGAB='C'
								GROUP BY SUBSTR(CODCTA,1,8)
								UNION
								SELECT SUBSTR(CODCTA,1,11) AS CUENTA,SUM(SALANT) AS SALDO
								FROM CONTABB
								WHERE CARGAB='C'
								GROUP BY SUBSTR(CODCTA,1,11)
								UNION
								SELECT SUBSTR(CODCTA,1,14) AS CUENTA,SUM(SALANT) AS SALDO
								FROM CONTABB
								WHERE CARGAB='C'
								GROUP BY SUBSTR(CODCTA,1,14)
								UNION
								SELECT SUBSTR(CODCTA,1,18) AS CUENTA,SUM(SALANT) AS SALDO
								FROM CONTABB
								WHERE CARGAB='C'
								GROUP BY SUBSTR(CODCTA,1,18));


								CREATE OR REPLACE VIEW CONBB1 AS SELECT * FROM CONTABB1 WHERE PEREJE='01';
								CREATE OR REPLACE VIEW CONBB2 AS SELECT * FROM CONTABB1 WHERE PEREJE='02';
								CREATE OR REPLACE VIEW CONBB3 AS SELECT * FROM CONTABB1 WHERE PEREJE='03';
								CREATE OR REPLACE VIEW CONBB4 AS SELECT * FROM CONTABB1 WHERE PEREJE='04';
								CREATE OR REPLACE VIEW CONBB5 AS SELECT * FROM CONTABB1 WHERE PEREJE='05';
								CREATE OR REPLACE VIEW CONBB6 AS SELECT * FROM CONTABB1 WHERE PEREJE='06';
								CREATE OR REPLACE VIEW CONBB7 AS SELECT * FROM CONTABB1 WHERE PEREJE='07';
								CREATE OR REPLACE VIEW CONBB8 AS SELECT * FROM CONTABB1 WHERE PEREJE='08';
								CREATE OR REPLACE VIEW CONBB9 AS SELECT * FROM CONTABB1 WHERE PEREJE='09';
								CREATE OR REPLACE VIEW CONBB10 AS SELECT * FROM CONTABB1 WHERE PEREJE='10';
								CREATE OR REPLACE VIEW CONBB11 AS SELECT * FROM CONTABB1 WHERE PEREJE='11';
								CREATE OR REPLACE VIEW CONBB12 AS SELECT * FROM CONTABB1 WHERE PEREJE='12';

								CREATE OR REPLACE VIEW SALDOS_DEBCRE AS (
								SELECT SUBSTR(A.CODCTA,1,1) AS CUENTA,TO_CHAR(A.FECCOM,'MM') AS PERIODO,SUM(CASE A.DEBCRE WHEN 'D' THEN A.MONASI ELSE 0 END) AS DEBITO,SUM(CASE A.DEBCRE WHEN 'C' THEN A.MONASI ELSE 0 END) AS CREDITO
								FROM CONTABC1 A,CONTABC B
								WHERE B.STACOM='A'AND
								A.NUMCOM=B.NUMCOM AND
								A.FECCOM=B.FECCOM
								GROUP BY SUBSTR(CODCTA,1,1),TO_CHAR(A.FECCOM,'MM')
								UNION
								SELECT SUBSTR(A.CODCTA,1,3) AS CUENTA,TO_CHAR(A.FECCOM,'MM') AS PERIODO,SUM(CASE A.DEBCRE WHEN 'D' THEN A.MONASI ELSE 0 END) AS DEBITO,SUM(CASE A.DEBCRE WHEN 'C' THEN A.MONASI ELSE 0 END) AS CREDITO
								FROM CONTABC1 A,CONTABC B
								WHERE B.STACOM='A'AND
								A.NUMCOM=B.NUMCOM AND
								A.FECCOM=B.FECCOM
								GROUP BY SUBSTR(CODCTA,1,3),TO_CHAR(A.FECCOM,'MM')
								UNION
								SELECT SUBSTR(A.CODCTA,1,5) AS CUENTA,TO_CHAR(A.FECCOM,'MM') AS PERIODO,SUM(CASE A.DEBCRE WHEN 'D' THEN A.MONASI ELSE 0 END) AS DEBITO,SUM(CASE A.DEBCRE WHEN 'C' THEN A.MONASI ELSE 0 END) AS CREDITO
								FROM CONTABC1 A,CONTABC B
								WHERE B.STACOM='A'AND
								A.NUMCOM=B.NUMCOM AND
								A.FECCOM=B.FECCOM
								GROUP BY SUBSTR(CODCTA,1,5),TO_CHAR(A.FECCOM,'MM')
								UNION
								SELECT SUBSTR(A.CODCTA,1,8) AS CUENTA,TO_CHAR(A.FECCOM,'MM') AS PERIODO,SUM(CASE A.DEBCRE WHEN 'D' THEN A.MONASI ELSE 0 END) AS DEBITO,SUM(CASE A.DEBCRE WHEN 'C' THEN A.MONASI ELSE 0 END) AS CREDITO
								FROM CONTABC1 A,CONTABC B
								WHERE B.STACOM='A'AND
								A.NUMCOM=B.NUMCOM AND
								A.FECCOM=B.FECCOM
								GROUP BY SUBSTR(CODCTA,1,8),TO_CHAR(A.FECCOM,'MM')
								UNION
								SELECT SUBSTR(A.CODCTA,1,11) AS CUENTA,TO_CHAR(A.FECCOM,'MM') AS PERIODO,SUM(CASE A.DEBCRE WHEN 'D' THEN A.MONASI ELSE 0 END) AS DEBITO,SUM(CASE A.DEBCRE WHEN 'C' THEN A.MONASI ELSE 0 END) AS CREDITO
								FROM CONTABC1 A,CONTABC B
								WHERE B.STACOM='A'AND
								A.NUMCOM=B.NUMCOM AND
								A.FECCOM=B.FECCOM
								GROUP BY SUBSTR(CODCTA,1,11),TO_CHAR(A.FECCOM,'MM')
								UNION
								SELECT SUBSTR(A.CODCTA,1,14) AS CUENTA,TO_CHAR(A.FECCOM,'MM') AS PERIODO,SUM(CASE A.DEBCRE WHEN 'D' THEN A.MONASI ELSE 0 END) AS DEBITO,SUM(CASE A.DEBCRE WHEN 'C' THEN A.MONASI ELSE 0 END) AS CREDITO
								FROM CONTABC1 A,CONTABC B
								WHERE B.STACOM='A'AND
								A.NUMCOM=B.NUMCOM AND
								A.FECCOM=B.FECCOM
								GROUP BY SUBSTR(CODCTA,1,14),TO_CHAR(A.FECCOM,'MM')
								UNION
								SELECT SUBSTR(A.CODCTA,1,18) AS CUENTA,TO_CHAR(A.FECCOM,'MM') AS PERIODO,SUM(CASE A.DEBCRE WHEN 'D' THEN A.MONASI ELSE 0 END) AS DEBITO,SUM(CASE A.DEBCRE WHEN 'C' THEN A.MONASI ELSE 0 END) AS CREDITO
								FROM CONTABC1 A,CONTABC B
								WHERE B.STACOM='A'AND
								A.NUMCOM=B.NUMCOM AND
								A.FECCOM=B.FECCOM
								GROUP BY SUBSTR(CODCTA,1,18),TO_CHAR(A.FECCOM,'MM'));

								UPDATE CONTABB
								SET SALANT=SALDOS.SALDO
								FROM SALDOS
								WHERE CUENTA=RTRIM(CONTABB.CODCTA);

								UPDATE CONTABB1
								SET SALACT=CONTABB.SALANT
								FROM CONTABB
								WHERE CONTABB.CODCTA=CONTABB1.CODCTA;

								UPDATE CONTABB1
								SET TOTDEB=SALDOS_DEBCRE.DEBITO,
								TOTCRE=SALDOS_DEBCRE.CREDITO
								FROM SALDOS_DEBCRE
								WHERE RTRIM(SALDOS_DEBCRE.Cuenta)=RTRIM(CONTABB1.CODCTA)  AND
								SALDOS_DEBCRE.PERIODO=CONTABB1.PEREJE;

								update contabb1
								set salact=salact+totdeb-totcre;

								UPDATE CONTABB1
								SET SALACT=CONBB1.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB1
								WHERE CONBB1.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='02';

								UPDATE CONTABB1
								SET SALACT=CONBB2.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB2
								WHERE CONBB2.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='03';

								UPDATE CONTABB1
								SET SALACT=CONBB3.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB3
								WHERE CONBB3.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='04';

								UPDATE CONTABB1
								SET SALACT=CONBB4.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB4
								WHERE CONBB4.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='05';

								UPDATE CONTABB1
								SET SALACT=CONBB5.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB5
								WHERE CONBB5.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='06';

								UPDATE CONTABB1
								SET SALACT=CONBB6.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB6
								WHERE CONBB6.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='07';

								UPDATE CONTABB1
								SET SALACT=CONBB7.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB7
								WHERE CONBB7.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='08';

								UPDATE CONTABB1
								SET SALACT=CONBB8.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB8
								WHERE CONBB8.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='09';

								UPDATE CONTABB1
								SET SALACT=CONBB9.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB9
								WHERE CONBB9.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='10';

								UPDATE CONTABB1
								SET SALACT=CONBB10.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB10
								WHERE CONBB10.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='11';

								UPDATE CONTABB1
								SET SALACT=CONBB11.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
								FROM CONBB11
								WHERE CONBB11.CODCTA=CONTABB1.CODCTA  AND
								CONTABB1.PEREJE='12';
					");
				} //Fin Return

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
  			  ///////////////////
		} // Return

		function ActualizarMaestro(){
			$tb06->$this->bd->select("select substr(codcta,1,18) as codcta,
											 RTRIM(to_char(a.feccom,'MM')) as mes,
											 sum((case when a.debcre='D' then a.monasi else 0 end))                                             AS DEB,
											 sum((case when a.debcre='C' then a.monasi else 0 end )) as                                             CRE
									  from
									  		contabc1 a,
											contabc b
									where
											a.numcom=b.numcom and
											a.feccom = b.feccom and
											b.stacom='A'
									group by substr(codcta,1,18),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb05->$this->bd->select("select substr(codcta,1,14) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,
sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
			from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,14),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb04->$this->bd->select("select substr(codcta,1,11) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,
sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
			from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,11),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb03->$this->bd->select("select substr(codcta,1,8) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,
sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
			from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,8),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb02->$this->bd->select("select substr(codcta,1,5) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,
sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
			from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,5),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$tb01->$this->bd->select("select substr(codcta,1,3) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,
sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
			from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,3),RTRIM(to_char(a.feccom,'MM'))");
			$tb00->$this->bd->select("select substr(codcta,1,1) as codcta, RTRIM(to_char(a.feccom,'MM')) as mes,
sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
			from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,1),RTRIM(to_char(a.feccom,'MM'))");
				//--------------
			$cuentas->$this->bd->select("select * from contabb");
				//--------------
			//cursor cuentas is (select * from contabb);
			$this->bd->actualizar("update contabb1 set totdeb=0,totcre=0,salact=0");
			//------ 06 --------
			while(!$tb06->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=coalesce('".$tb06->fields["deb"]."',0),totcre=coalesce('".$tb06->fields["cre"]."',0) where codcta=('".$tb06->fields["codcta"]."') and pereje='".$tb06->fields["mes"]."'");
			$tb06->MoveNext(); }
			//------ 05 --------
			while(!$tb05->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=coalesce('".$tb05->fields["deb"]."',0),totcre=coalesce('".$tb05->fields["cre"]."',0) where codcta=('".$tb05->fields["codcta"]."') and pereje='".$tb05->fields["mes"]."'");
			$tb05->MoveNext(); }
			//------ 04 --------
			while(!$tb04->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=coalesce('".$tb04->fields["deb"]."',0),totcre=coalesce('".$tb04->fields["cre"]."',0) where codcta=('".$tb04->fields["codcta"]."') and pereje='".$tb04->fields["mes"]."'");
			$tb04->MoveNext(); }
			//------ 03 --------
			while(!$tb03->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=coalesce('".$tb03->fields["deb"]."',0),totcre=coalesce('".$tb03->fields["cre"]."',0) where codcta=('".$tb03->fields["codcta"]."') and pereje='".$tb03->fields["mes"]."'");
			$tb03->MoveNext(); }
			//------ 02 --------
			while(!$tb02->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=coalesce('".$tb02->fields["deb"]."',0),totcre=coalesce('".$tb02->fields["cre"]."',0) where codcta=('".$tb02->fields["codcta"]."') and pereje='".$tb02->fields["mes"]."'");
			$tb02->MoveNext(); }
			//------ 01 --------
			while(!$tb01->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=coalesce('".$tb01->fields["deb"]."',0),totcre=coalesce('".$tb01->fields["cre"]."',0) where codcta=('".$tb01->fields["codcta"]."') and pereje='".$tb01->fields["mes"]."'");
			$tb01->MoveNext(); }
			//-----------------//
						//------ 00 --------
			while(!$tb00->EOF){
				$this->bd->actualizar("update contabb1 set totdeb=coalesce('".$tb00->fields["deb"]."',0),totcre=coalesce('".$tb00->fields["cre"]."',0) where codcta=('".$tb00->fields["codcta"]."') and pereje='".$tb00->fields["mes"]."'");
			$tb00->MoveNext(); }
			//-----------------//

			  while(!$cuentas->EOF){
				  $this->ActualizarSaldos($cuentas->fields["codcta"],$cuentas->fields["fecini"],$cuentas->fields["feccie"]);
				$this->MoveNext(); }
		} //Return

		//------------------------------------------------------------------------------------------------------//
		function ActualizarSaldos($codigo_cta,$fecha_ini,$fecha_cie){

  			 $tb10->$this->bd->select("SELECT *
										 FROM CONTABB1
										 WHERE CODCTA = ($codigo_cta)
												 AND FECINI = ($fecha_ini)
												 AND FECCIE = ($fecha_cie)
										 ORDER BY PEREJE");

   			 $tb11->$this->bd->select("SELECT
										    SALANT as SALDO_ANT
									   FROM CONTABB
									   WHERE CODCTA = (($codigo_cta)) AND
											FECINI = ($fecha_ini) AND
											FECCIE = ($fecha_cie)");
			$periodo_ant = '00';
			   while(!$tb10->EOF){
				   $this->bd->actualizar("UPDATE CONTABB1
						SET SALACT = ('".$tb10->fields["totdeb"]."')  + ('".$tb11->fields["saldo_ant"]."') - ('".$tb10->fields["totcre"]."')
					  WHERE CODCTA = ('".$tb10->fields["codcta"]."') AND
							PEREJE = ('".$tb10->fields["pereje"]."') AND
							FECINI = ('".$tb10->fields["fecini"]."') AND
							FECCIE = ('".$tb10->fields["feccie"]."')");


					   $periodo_ant = str_pad(to_char(to_numer($periodo_ant)+1),2,'0',STR_PAD_LEFT);

					   $tb11->$this->bd->select("SELECT SALACT as SALDO_ANT
												 FROM CONTABB1
												 WHERE CODCTA = ($codigo_cta) AND
														FECINI = ($fec_ini) AND
														FECCIE = ($fec_cie) AND
														PEREJE = $periodo_ant");
				$this->MoveNext(); }
		}		// Return


		function obtenerFecha()
		{
		  $tb3=$this->bd->select("select fecini as fechainic, forcta as forcta from contaba");
			if (!$tb3->EOF){
				$this->fechainicio=$tb3->fields["fechainic"];
				$this->forcta=$tb3->fields["forcta"];
				}

			$this->valor=instr($this->forcta,'-',0,1);
  		   $tb4=$this->bd->select("SELECT coalesce(coalesce(LENGTH(SUBSTR(FORCTA,1,$this->valor))-1, 0), 0) as LONIV1,
		   								FECINI as fecha_ini,
										FECCIE as fecha_cie
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

/////////////////////////////////////////////////////////////////////////////////////////////////////
		function PutLink($URL,$txt)
                {
                        //Escribir un hiper-enlace
                        $this->SetTextColor(0,0,255);
                        $this->SetStyle('U',true);
                        $this->Write(5,$txt,$URL);
                        $this->SetStyle('U',false);
                        $this->SetTextColor(0);
                }

		function SetStyle($tag,$enable)
            	{
                //Modificar estilo y escoger la fuente correspondiente
                $this->$tag+=($enable ? 1 : -1);
                $style='';
                foreach(array('B','I','U') as $s)
                    if($this->$s>0)
                        $style.=$s;
                $this->SetFont('',$style);
            	}
//////////////////////////////////////////////////////////////////////////////////////////////////////

		function Header()
		{
			$dir = parse_url($_SERVER["HTTP_REFERER"]);
			$parte = explode("/",$dir["path"]);
			$ubica = count($parte)-2;
			$this->cab->poner_cabecera($this,$_POST["titulo"],"l","s",$parte[$ubica]);
			$this->setFont("Arial","B",9);
			$this->fecha();
			$this->cell(40,10,"Desde: ".$this->fecperdes."  ");
			$this->cell(20,10,"Hasta: ".$this->fecperhas);
			$this->ln(4);
			$this->cell($this->anchos[1],10,"Código de Cuenta");
			$this->cell($this->anchos[4],10,"Descripción de Cuenta");
//			$this->cell(22,10," ");
			$this->cell(35,10,"Saldo Anterior",0,0,'R');
			$this->cell(35,10,"Debe",0,0,'R');
			$this->cell(35,10,"Haber",0,0,'R');
 			$this->cell(40,10,"Saldo Actual",0,0,'R');
			$this->Line(10,48,270,48);
			$this->ln();
		}


		function Cuerpo()
		{
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			/****ARCHIVO EXCEL***/
    		          $nombre_archivo="/tmp/balance_comprobacion_".strftime('%d_%m_%Y',time()).".xls";
           			 //print $nombre_archivo;
                          //chmod ("/home",0755);
   		          if (!file_exists($nombre_archivo))
    		          {
    		            fopen($nombre_archivo,"w");
    		          }
    		          chmod ($nombre_archivo,0755);


           		   $depositos = fopen($nombre_archivo,'w+');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			$tb=$this->bd->select($this->sql);
			//$sw=0;
			$acum_saldo_ant=0;
			$acum_debe=0;
			$acum_haber=0;
			$acum_saldo_act=0;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cadena="CODIGO"."\t"."DESCRIPCION"."\t"."SALDO ANTERIOR"."\t"."DEBE"."\t"."HABER"."\t"."SALDO ACTUAL".chr(13).chr(10).chr(13).chr(10);
              fputs($depositos,$cadena);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  		    $this->setFont("Arial","",8);
			while(!$tb->EOF)
			{
				if ($tb->fields["titulo"]!=" "){
 				     $this->cuenta=$tb->fields["cuenta"];
					 $this->perant = str_pad(($this->periodo-1),2,'0',STR_PAD_LEFT);
					$this->Buscar_Saldo_Anterior();

						$ym=$this->GetY();
					 	if($ym>=180)
					 	{
					 		$this->addPage();
					 	}

					 if (ltrim(rtrim($tb->fields["titulo"]))=='TOTAL')
					 {
 					    $this->Line(125,$this->GetY()+3,270,$this->GetY()+3);
						$this->cell($this->anchos[1],4," ");
						$this->setFont("Arial","B",8);
						$y=$this->GetY();
						$x=$this->GetX()+$this->anchos[4];
						$this->Multicell($this->anchos[4],4,strtoupper($tb->fields["titulo"]." ".$tb->fields["nombre"]));
						$y1=$this->GetY();
						$this->SetXY($x,$y);
						$this->cell(35,3,number_format($this->salant,2,',','.'),0,0,'R');
						$this->cell(35,3,number_format($tb->fields["debito"],2,',','.'),0,0,'R');
						$this->cell(35,3,number_format($tb->fields["credito"],2,',','.'),0,0,'R');
						$this->cell(40,3,number_format($tb->fields["saldo"],2,',','.'),0,0,'R');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cadena=$tb->fields["titulo"]."\t".$tb->fields["nombre"]."\t".$this->salant."\t".$tb->fields["debito"]."\t".$tb->fields["credito"]."\t".$tb->fields["saldo"]."\t".chr(13).chr(10);

				fputs($depositos,$cadena);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


					$this->setFont("Arial","",8);
					 }
					 else
					 {  $sw=0;
  					    $this->cell($this->anchos[1],4,$this->cuenta);
						$y=$this->GetY();
						$x=$this->GetX()+$this->anchos[4];
						$this->MultiCell($this->anchos[4],4,strtoupper($tb->fields["nombre"]));
						$y1=$this->GetY();
					 }   //EndIF

					if ($tb->fields["cargable"]=='C')
					{
						$this->SetXY($x,$y);
						$this->cell(35,4,number_format($this->salant,2,',','.'),0,0,'R');
						$this->cell(35,4,number_format($tb->fields["debito"],2,',','.'),0,0,'R');
						$this->cell(35,4,number_format($tb->fields["credito"],2,',','.'),0,0,'R');
						//$this->cell(40,10,number_format(abs($tb->fields["saldo"]),2,',','.'),0,0,'R');
						$this->cell(40,4,number_format($tb->fields["saldo"],2,',','.'),0,0,'R');


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cadena=$tb->fields["titulo"]."\t".$tb->fields["nombre"]."\t".$this->salant."\t".$tb->fields["debito"]."\t".$tb->fields["credito"]."\t".$tb->fields["saldo"]."\t".chr(13).chr(10);
fputs($depositos,$cadena);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




					}
					$this->SetY($y1);
                                        $this->ln();


					$this->SetY($y1);
					$this->ln();
				}  //EndIf
			$tb->MoveNext();
			} //End While



			$tb_temp=$this->bd->select("SELECT SUM(B.TOTDEB) AS TOTAL_DEB,
												SUM(B.TOTCRE) AS TOTAL_CRE
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
											//  print $tb_temp;
					if (!empty($tb_temp->fields["total_deb"]))
							{
							$this->setFont("Arial","B",9);
							$this->ln();
							$this->cell($this->anchos[1],10," ");
							 $this->cell($this->anchos[4],10,"TOTAL DEBITO  :");
							 $this->cell(35,10,number_format($tb_temp->fields["total_deb"],2,',','.'),0,0,'R');
							 $this->ln(4);
							 $this->cell($this->anchos[1],10," ");
							 $this->cell($this->anchos[4],10,"TOTAL CREDITO:");
							 $this->cell(35,10,number_format($tb_temp->fields["total_cre"],2,',','.'),0,0,'R');
							 $this->ln();
							 }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					 $dir = parse_url($_SERVER['HTTP_REFERER']);
            			         $parte = explode("/",$dir['path']);
					for($i=0;$i<count($parte)-1;$i++)
            			         {
            			            $agregar.=$parte[$i]."/";
             			         }
            			         $dir = $dir['scheme'].'://'.$dir['host'].$agregar;
           		        	$this->PutLink( $dir.'descargar.php?archivo='.$nombre_archivo,'Descargar Archivo');
          			          fclose($depositos);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}


	function Buscar_Saldo_Anterior(){
			  if (($this->periodo) == '01'){
					$tb999=$this->bd->select("SELECT A.SALANT as salant
												FROM
													CONTABB A, CONTABA B
												WHERE
													A.CODCTA=('".$this->cuenta."') AND
													A.FECINI = B.FECINI AND
													A.FECCIE = B.FECCIE AND
													B.CODEMP='001'");
		  	  }else{
					$tb999=$this->bd->select("SELECT B.SALACT as salant
												FROM
													CONTABB1 B, CONTABA C
												WHERE
													B.CODCTA = ('".$this->cuenta."') AND
													B.PEREJE = '".$this->perant."' AND
													B.FECINI = C.FECINI AND
													B.FECCIE = C.FECCIE AND
													C.CODEMP='001'");

													}
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
								//print $tb99;
					if (!$tb99->EOF){
							$cuenta_pasivo=$tb99->fields["cuenta_pasivo"];
							$cuenta_capital=$tb99->fields["cuenta_capital"];
							$cuenta_resultado=$tb99->fields["cuenta_resultado"];	}

		$tb990=$this->bd->select("SELECT
									(A.SALACT) as pasivo
								FROM
									CONTABB1 A,
								    CONTABA B
						   		WHERE
								 	RTRIM(A.CODCTA)=RTRIM(B.CODTESPAS) AND
								    A.PEREJE = ('".$this->periodo."') AND
									A.FECINI = B.FECINI AND
								    A.FECCIE = B.FECCIE");
									//print $tb990;
									$pasivo=$tb990->fields["pasivo"];

							if (!$tb990->EOF)
							{
								   if (rtrim($cuenta_capital)==rtrim($cuenta_pasivo)) { $capital= 0;  }
								   	else {  $tb99=$this->bd->select("SELECT
									  								A.SALACT as capital
															   FROM
															   		CONTABB1 A,
																	CONTABA B
															   WHERE
															   		A.CODCTA=(B.CODCTA) AND
																	A.PEREJE = ('".$this->periodo."') AND
																	A.FECINI = B.FECINI AND
																	A.FECCIE = B.FECCIE");
																	//print $tb99;

											$capital=$tb99->fields["capital"];
											//echo $capital;
											}
								$tb99=$this->bd->select("SELECT A.SALACT as INGRESO
														 FROM
															CONTABB1 A,
															CONTABA B
														 WHERE
															A.CODCTA=(B.CODIND) AND
															A.PEREJE = ('".$this->periodo."') AND
															A.FECINI = B.FECINI AND
															A.FECCIE = B.FECCIE");

												$ingreso=$tb99->fields["ingreso"];

								 $tb99=$this->bd->select("SELECT (A.SALACT) as EGRESO
														  FROM
															CONTABB1 A,
															CONTABA B
														  WHERE
															A.CODCTA=(B.CODEGD) AND
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
																A.CODCTA=(B.CODCTD) AND
																A.PEREJE = ('".$this->periodo."') AND
																A.FECINI = B.FECINI AND
																A.FECCIE = B.FECCIE");

												$patrimonio=$tb99->fields["resultado"]; }

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

			/*$this->total=(($Tingreso-$Tegreso*-1));
			$this->saldo=$this->saldo + (($Tingreso-$Tegreso)*-1);*/
			 $this->total=(abs((abs($Tingreso)-abs($Tegreso))*-1));
      $this->saldo=$this->saldo + ((abs($Tingreso)-abs($Tegreso))*-1);
		/*  SET SALDO = SALDO + (ABS(INGRESOS) - ABS(EGRESOS))*(-1)
		 WHERE RTRIM(CUENTA)>=SUBSTR(CUENTA_RESULTADO,1,INSTR(CUENTA_RESULTADO,'-',1,1)-1) AND
			   RTRIM(CUENTA)<=RTRIM(CUENTA_RESULTADO) AND
			   INSTR(RTRIM(CUENTA_RESULTADO),RTRIM(CUENTA))<>0;				*/

			}			//Return
	} //	Fin
?>
