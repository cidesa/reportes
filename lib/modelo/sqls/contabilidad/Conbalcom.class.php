<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Conbalcom extends BaseClases {
/*
 * 	SUBSTR(H.CODPRE,1,2) as SECTOR,
	SUBSTR(H.CODPRE,4,2) as PROGRAMA,
	SUBSTR(H.CODPRE,7,2) as SUBPROGRAMA,
	SUBSTR(H.CODPRE,10,3) as PROYECTO,
	SUBSTR(H.CODPRE,14,2) as ACTIVIDAD,
	SUBSTR(H.CODPRE,17,3) as PARTIDA,
	SUBSTR(H.CODPRE,21,2) as GENERICA,
	SUBSTR(H.CODPRE,24,2) as ESPECIFICA,
	SUBSTR(H.CODPRE,27,2) as SUBESPECIFICA1,
	SUBSTR(H.CODPRE,30,2) as SUBESPECIFICA2,
	SUBSTR(H.CODPRE,33,2) as SECTOR,
	SUBSTR(H.CODPRE,36,2) as PROGRAMA,
	SUBSTR(H.CODPRE,39,2) as SUBPROGRAMA,
	SUBSTR(H.CODPRE,42,3) as PROYECTO,
	SUBSTR(H.CODPRE,46,2) as ACTIVIDAD,
	SUBSTR(H.CODPRE,49,3) as PARTIDA,
        SUBSTR(H.CODPRE,53,2) as GENERICA,
        SUBSTR(H.CODPRE,56,2) as ESPECIFICA,
	SUBSTR(H.CODPRE,59,2) as SUBESPECIFICA1,
	SUBSTR(H.CODPRE,62,2) as SUBESPECIFICA2,
 *
 * */

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
									RTRIM(SUBSTR(CUENTA,1,32)) LIKE RTRIM('" . $comodin . "')  AND
									(((SALDO<>0  OR DEBITO<>0 OR CREDITO<> 0) AND CUENTA NOT LIKE '7%') OR CUENTA LIKE '7%')
									ORDER BY ORDEN";//H::PrintR($sql);exit;
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

}
?>