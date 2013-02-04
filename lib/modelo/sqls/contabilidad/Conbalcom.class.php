<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Conbalcom extends BaseClases {

	public function SQLP($periodo, $fecha_ini, $fecha_cie, $nivel, $codcta1, $codcta2, $comodin) {
		$sql = "SELECT ORDEN,
									RTRIM(TITULO) as TITULO,
									RTRIM(CUENTA) as CUENTA,
									RTRIM(NOMBRE) as NOMBRE,
									DEBITO,
									CREDITO,
									SALDO,
									(DEBITO-CREDITO) AS SALPER,
									CARGABLE
							FROM
								(SELECT RTRIM(A.CODCTA) AS ORDEN,
										A.CODCTA AS TITULO,
										A.CODCTA AS CUENTA,
										B.DESCTA AS NOMBRE,
										A.TOTDEB AS DEBITO,
										A.TOTCRE AS CREDITO,
										 A.SALACT AS SALDO,
										B.CARGAB AS CARGABLE,'C'
									 FROM
										CONTABB1 A,
										CONTABB B
									 WHERE
										A.CODCTA=B.CODCTA AND
										A.PEREJE = ('" . $periodo . "') AND
										A.FECINI = ('" . $fecha_ini . "') AND
										A.FECCIE = ('" . $fecha_cie . "')
									UNION ALL
									SELECT RTRIM(A.CODCTA)||'T' AS ORDEN,'TOTAL' AS TITULO,
										A.CODCTA AS CUENTA,
										B.DESCTA AS NOMBRE,
										A.TOTDEB AS DEBITO,
										A.TOTCRE AS CREDITO,
										 A.SALACT AS SALDO,
										B.CARGAB AS CARGABLE,'C'
									 FROM
										CONTABB1 A,
										CONTABB B

									 WHERE A.CODCTA=B.CODCTA AND
										   A.PEREJE = ('" . $periodo . "') AND
										   A.FECINI = ('" . $fecha_ini . "') AND
										   A.FECCIE = ('" . $fecha_cie . "') AND
										   B.CARGAB<>'C') as A
							WHERE
									LENGTH(RTRIM(SUBSTR(CUENTA,1,32))) <= ('" . $nivel . "')  AND
									RTRIM(SUBSTR(CUENTA,1,32)) >= RTRIM('" . $codcta1 . "') AND
									RTRIM(SUBSTR(CUENTA,1,32)) <=RTRIM('" . $codcta2 . "')  AND
									RTRIM(SUBSTR(CUENTA,1,32)) LIKE RTRIM('" . $comodin . "')
                                                             AND
									(((SALDO<>0  OR DEBITO<>0 OR CREDITO<> 0) AND CUENTA NOT LIKE '7%') OR CUENTA LIKE '7%')
									ORDER BY ORDEN";
//H::PrintR($sql);exit;
		return $this->select($sql);
	}

	public function SQLContabb($periodo, $codcta1, $codcta2) {
		$sql = "SELECT SUM(B.TOTDEB)
											 AS TOTAL_DEB, SUM(B.TOTCRE) AS TOTAL_CRE
											 FROM CONTABB A,
												  CONTABB1 B,
												  CONTABA C
											WHERE A.CODCTA = B.CODCTA AND
												  A.CARGAB = 'C' AND
												  B.PEREJE = '" . $periodo . "' AND
												  B.FECINI = C.FECINI AND
												  B.FECCIE = C.FECCIE AND
												  TRIM(A.CODCTA) >= '" . $codcta1 . "' AND
												  TRIM(A.CODCTA) <= '" . $codcta2 . "'";
		//H::PrintR($sql);exit;
                return $this->select($sql);
	}

	public function SQLContabb2($cuenta) {
		$sql = "SELECT A.SALANT as salant
					FROM
						CONTABB A, CONTABA B
					WHERE
						A.CODCTA='" . $cuenta . "' AND
						A.FECINI = B.FECINI AND
						A.FECCIE = B.FECCIE AND
						B.CODEMP='001'";
		return $this->select($sql);
	}

	public function SQLContabb1($cuenta, $perant) {
		$sql = "SELECT B.SALACT as salant
					FROM
						CONTABB1 B, CONTABA C
					WHERE
						B.CODCTA = '" . $cuenta . "' AND
						B.PEREJE = '" . $perant . "' AND
						B.FECINI = C.FECINI AND
						B.FECCIE = C.FECCIE AND
						C.CODEMP='001'";

		return $this->select($sql);
	}

	public function SQLContaba() {
		$sql = "SELECT
					CODTESPAS as CUENTA_PASIVOS,
			        CODCTA as CUENTA_CAPITAL,
					CODRESANT as CUENTA_RESULTADO,
	                fecini as fechainic,
	                forcta as forcta
				FROM
					CONTABA
			   WHERE
			   		CODEMP= '001'";

		return $this->select($sql);
	}

	public function SQLContabb11($periodo) {
		echo $sql = "SELECT
					(A.SALACT) as PASIVO
				FROM
					CONTABB1 A,
				    CONTABA B
		   		WHERE
				 	RTRIM(A.CODCTA)=RTRIM(B.CODTESPAS) AND
				    A.PEREJE = ('" . $periodo . "') AND
					A.FECINI = B.FECINI AND
				    A.FECCIE = B.FECCIE";

		return $this->select($sql);
	}

	public function SQLContabb1_Capital($periodo) {
		$sql = "SELECT
					A.SALACT as capital
			   FROM
			   		CONTABB1 A,
					CONTABA B
			   WHERE
			   		A.CODCTA=(B.CODCTA) AND
					A.PEREJE = ('" . $periodo . "') AND
					A.FECINI = B.FECINI AND
					A.FECCIE = B.FECCIE";

		return $this->select($sql);
	}

	public function SQLContabb1_Ingreso($periodo) {
		$sql = "SELECT A.SALACT as INGRESO
				 FROM
					CONTABB1 A,
					CONTABA B
				 WHERE
					A.CODCTA=(B.CODIND) AND
					A.PEREJE = ('" . $periodo . "') AND
					A.FECINI = B.FECINI AND
					A.FECCIE = B.FECCIE";

		return $this->select($sql);
	}

	public function SQLContabb1_Egreso($periodo) {
		$sql = "SELECT (A.SALACT) as EGRESO
				  FROM
					CONTABB1 A,
					CONTABA B
				  WHERE
					A.CODCTA=(B.CODEGD) AND
					A.PEREJE = ('" . $periodo . "') AND
					A.FECINI = B.FECINI AND
					A.FECCIE = B.FECCIE";

		return $this->select($sql);
	}

	public function SQLContabb1_Resultado($periodo) {
		$sql = "SELECT A.SALACT as resultado
					   FROM
						 CONTABB1 A,
						 CONTABA B
					   WHERE
							A.CODCTA=(B.CODCTD) AND
							A.PEREJE = ('" . $periodo . "') AND
							A.FECINI = B.FECINI AND
							A.FECCIE = B.FECCIE";

		return $this->select($sql);
	}

	public function SQLContaba_loniv1($valor) {
		$sql = "SELECT coalesce(coalesce(LENGTH(SUBSTR(FORCTA,1,$valor))-1, 0), 0) as LONIV1,
					FECINI as fecha_ini,
					FECCIE as fecha_cie
			   FROM
					CONTABA";

		return $this->select($sql);
	}

	public function SQLContaba_nivel() {
		$sql = "SELECT coalesce(LENGTH(RTRIM(FORCTA)), 0) as nivel FROM contaba";
		return $this->select($sql);
	}

	public function SQLContaba_Fecperdes($periodo) {
		$sql = "SELECT to_char(B.FECDES,'dd/mm/yyyy') as fecperdes
					  FROM
					  	CONTABA A, CONTABA1 B
					  WHERE A.FECINI = B.FECINI AND
							A.FECCIE = B.FECCIE AND
							B.PEREJE = '" . $periodo . "'";
		return $this->select($sql);
	}

	public function SQLContaba_Fecperhas($periodo) {
		$sql = "SELECT to_char(B.FECHAS,'dd/mm/yyyy') as fecperhas
					FROM CONTABA A, CONTABA1 B
					WHERE A.FECINI = B.FECINI AND
							A.FECCIE = B.FECCIE AND
							B.PEREJE = '" . $periodo . "'";

		return $this->select($sql);
	}

	public function SQLContaba1() {
		$sql = "select fecini as fechainic, forcta as forcta from contaba";

		return $this->select($sql);
	}

	public function SQLContaba_nivel2($valor) {
		$sql = "SELECT coalesce(coalesce(LENGTH(SUBSTR(FORCTA,1,'".$valor."'))-1, 0), 0) as nivel FROM contaba";
		return $this->select($sql);
	}

        public function actualizar_balance()
        {

		$this->ReactualizarSaldosAnteriores();
                //$this->ActualizarMaestro();

	}

    function ReactualizarSaldosAnteriores(){

		$this->actualizar("
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
			WHERE CUENTA=(CONTABB.CODCTA);

			UPDATE CONTABB1
			SET SALACT=CONTABB.SALANT
			FROM CONTABB
			WHERE CONTABB.CODCTA=CONTABB1.CODCTA;

			UPDATE CONTABB1
			SET TOTDEB=SALDOS_DEBCRE.DEBITO,
			TOTCRE=SALDOS_DEBCRE.CREDITO
			FROM SALDOS_DEBCRE
			WHERE (SALDOS_DEBCRE.Cuenta)=(CONTABB1.CODCTA)  AND
			SALDOS_DEBCRE.PERIODO=CONTABB1.PEREJE;

			--update contabb1
			--set salact=salact+totdeb-totcre;
                        
                        UPDATE CONTABB1
			SET SALACT=CONBB1.SALACT+CONTABB1.TOTDEB-CONTABB1.TOTCRE
			FROM CONBB1
			WHERE CONBB1.CODCTA=CONTABB1.CODCTA  AND
			CONTABB1.PEREJE='01';


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
                                
                    


		function ActualizarMaestro(){
			$tb05=$this->select("select substr(codcta,1,16) as codcta, (to_char(a.feccom,'MM')) as mes,
						sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
						sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
						from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,16),(to_char(a.feccom,'MM'))");
				//--------------
			$tb04=$this->select("select substr(codcta,1,11) as codcta, (to_char(a.feccom,'MM')) as mes,
						sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
						sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
						from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,11),(to_char(a.feccom,'MM'))");
				//--------------
			$tb03=$this->select("select substr(codcta,1,8) as codcta, (to_char(a.feccom,'MM')) as mes,
						sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
						sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
						from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,8),(to_char(a.feccom,'MM'))");
				//--------------
			$tb02=$this->select("select substr(codcta,1,5) as codcta, (to_char(a.feccom,'MM')) as mes,
						sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
						sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
						from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,5),(to_char(a.feccom,'MM'))");
				//--------------
			$tb01=$this->select("select substr(codcta,1,3) as codcta, (to_char(a.feccom,'MM')) as mes,
						sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
						sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
						from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,3),(to_char(a.feccom,'MM'))");
			$tb00=$this->select("select substr(codcta,1,1) as codcta, (to_char(a.feccom,'MM')) as mes,
						sum((case when a.debcre='D' then a.monasi else 0 end)) AS DEB,
						sum((case when a.debcre='C' then a.monasi else 0 end )) as CRE
						from contabc1 a, contabc b where a.feccom = b.feccom and b.stacom='A' group by substr(codcta,1,1),(to_char(a.feccom,'MM'))");
				//--------------
			$cuentas=$this->select("select * from contabb");
				//--------------
			//cursor cuentas is (select * from contabb);
			$this->actualizar("update contabb1 set totdeb=0,totcre=0,salact=0");
			//------ 05 --------
			foreach($tb05 as $tb){
				$this->actualizar("update contabb1 set totdeb=coalesce('".$tb["deb"]."',0),totcre=coalesce('".$tb["cre"]."',0) where codcta=('".$tb["codcta"]."') and pereje='".$tb["mes"]."'");
			}
			//------ 04 --------
			foreach($tb04 as $tb){
				$this->actualizar("update contabb1 set totdeb=coalesce('".$tb["deb"]."',0),totcre=coalesce('".$tb["cre"]."',0) where codcta=('".$tb["codcta"]."') and pereje='".$tb["mes"]."'");
			}
			//------ 03 --------
			foreach($tb03 as $tb){
				$this->actualizar("update contabb1 set totdeb=coalesce('".$tb["deb"]."',0),totcre=coalesce('".$tb["cre"]."',0) where codcta=('".$tb["codcta"]."') and pereje='".$tb["mes"]."'");
			}
			//------ 02 --------
			foreach($tb02 as $tb){
				$this->actualizar("update contabb1 set totdeb=coalesce('".$tb["deb"]."',0),totcre=coalesce('".$tb["cre"]."',0) where codcta=('".$tb["codcta"]."') and pereje='".$tb["mes"]."'");
			}
			//------ 01 --------
			foreach($tb01 as $tb){
				$this->actualizar("update contabb1 set totdeb=coalesce('".$tb["deb"]."',0),totcre=coalesce('".$tb["cre"]."',0) where codcta=('".$tb["codcta"]."') and pereje='".$tb["mes"]."'");
			}
			//-----------------//
			//------ 00 --------
			foreach($tb00 as $tb){
				$this->actualizar("update contabb1 set totdeb=coalesce('".$tb["deb"]."',0),totcre=coalesce('".$tb["cre"]."',0) where codcta=('".$tb["codcta"]."') and pereje='".$tb["mes"]."'");
			}
			//-----------------//

			foreach($cuentas as $tb){
				$this->ActualizarSaldos($tb["codcta"],$tb["fecini"],$tb["feccie"]);
			       
                                
                        }

		} //Return


	function ActualizarSaldos($codigo_cta,$fecha_ini,$fecha_cie){

		 $tb10=$this->select("SELECT *
					 FROM CONTABB1
					 WHERE CODCTA = '".$codigo_cta."'
							 AND FECINI = '".$fecha_ini."'
							 AND FECCIE = '".$fecha_cie."'
					 ORDER BY PEREJE");
                 
                 

		 $tb11=$this->select("SELECT
					    SALANT as SALDO_ANT
				   FROM CONTABB
				   WHERE CODCTA = '".$codigo_cta."') AND
						FECINI = '".$fecha_ini."' AND
						FECCIE = '".$fecha_cie."'");
		$periodo_ant = '00';
		   foreach($tb10 as $tb){
			   $this->actualizar("UPDATE CONTABB1
					SET SALACT = ('".$tb["totdeb"]."')  + ('".$tb11[0]["saldo_ant"]."') - ('".$tb["totcre"]."')
				  WHERE CODCTA = ('".$tb["codcta"]."') AND
						PEREJE = ('".$tb["pereje"]."') AND
						FECINI = ('".$tb["fecini"]."') AND
						FECCIE = ('".$tb["feccie"]."')");


				   //$periodo_ant = str_pad(to_char(to_number($periodo_ant)+1),2,'0',STR_PAD_LEFT);
                                   
				   $tb11=$this->select("SELECT SALACT as SALDO_ANT
				 FROM CONTABB1
				 WHERE CODCTA = '".$codigo_cta."' AND
						FECINI = '".$fecha_ini."' AND
						FECCIE = '".$fecha_cie."' AND
						PEREJE = '".$periodo_ant."'");
			}
	}		// Return

}
?>
