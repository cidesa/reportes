<?
require_once ("../../lib/general/fpdf/fpdf.php");
require_once ("../../lib/bd/basedatosAdo.php");
require_once ("../../lib/general/cabecera.php");

class pdfreporte extends fpdf {
	var $rif = 'G200002395';
	var $mes = array (
		"01" => "ENERO",
		"02" => "FEBRERO",
		"03" => "MARZO",
		"04" => "ABRIL",
		"05" => "MAYO",
		"06" => "JUNIO",
		"07" => "JULIO",
		"08" => "AGOSTO",
		"09" => "SEPTIEMBRE",
		"10" => "OCTUBRE",
		"11" => "NOVIEMBRE",
		"12" => "DICIEMBRE"
	);

	function pdfreporte() {
		$this->fpdf("p", "mm", "Letter");
		$this->bd = new basedatosAdo();
		$this->titulo = $_POST["titulo"];
		//$this->codtipapodes=$_POST["codtipapodes"];
		$this->codtipapodes = "0014";
		//$this->codtipapohas=$_POST["codtipapohas"];
		$this->codempdes = $_POST["codempdes"];
		$this->codemphas = $_POST["codemphas"];
		$this->tipnom = $_POST["tipnom"];
		$this->tipnom2 = $_POST["tipnom2"];
		$this->gendis = $_POST["gendis"];
		$this->eltipo = $_POST["eltipo"];
		$this->elab = $_POST["elab"];
		$this->rev = $_POST["rev"];
		$this->auto = $_POST["auto"];
		$this->catdes = $_POST["codcatdes"];
		$this->cathas = $_POST["codcathas"];
		$this->cab1 = "1";
		$this->especial = $_POST["especial"];
		$this->tipnomesp = $_POST["tipnomesp"];
		$this->fecreg1 = $_POST["fecreg1"];
		$this->fecreg2 = $_POST["fecreg2"];

		if ($this->especial == 'S') {
			$especial = " a.especial = 'S' AND
					(A.CODNOMESP) = TRIM('" . $this->tipnomesp . "') AND
			 ";
			$this->especial2 = " a.especial = 'S' AND
					(A.CODNOMESP) = TRIM('" . $this->tipnomesp . "') AND
			 ";
		} else {
			if ($this->especial == 'N')
				$especial = " a.especial = 'N' AND --A.CODCON<>'A03' AND";
			else
				if ($this->especial == 'T')
					$especial = "A.CODCON<>'A03' AND";
		}

		$this->especial = $especial;
		$this->sql = "
		                       SELECT DISTINCT A.CODTIPAPO as codtipapo,A.DESTIPAPO as destipapo,(A.PORAPO) as porapo,(A.PORRET) as porret,B.CODNOM as CODNOMAPO, d.nomnom
								FROM NPTIPAPORTES A,NPCONTIPAPORET B, npdiaadicnom c , npnomina d WHERE
								A.CODTIPAPO=B.CODTIPAPO AND
								b.codnom=c.codnom AND b.codcon=c.codcon and
								B.CODNOM>='" . $this->tipnom . "' and B.CODNOM<='" . $this->tipnom2 . "' and B.CODNOM=D.CODNOM
								 ";
		//	print '<pre>';print $this->sql;exit;
		$this->tb = $this->bd->select($this->sql);

		//	A.fecnom >= to_date('".$this->fecreg1."','dd/mm/yyyy') AND A.fecnom <= to_date('".$this->fecreg2."','dd/mm/yyyy')

		//	A.fecnom >= to_date('".$this->fecreg1."','dd/mm/yyyy') AND A.fecnom <= to_date('".$this->fecreg2."','dd/mm/yyyy')

		//	H::PrintR($this->sql2);exit;
		//exit;

		$this->llenartitulosmaestro();
		$this->cab = new cabecera();

	}
	function CFnomnom($tipnom) {

		$tb0 = $this->bd->select("SELECT DISTINCT(NOMNOM) as nombre
											FROM NPNOMINA WHERE CODNOM = '" . $tipnom . "' ");
		return $tb0->fields["nombre"];
	}
	function CFfecha($tipnom, $num) {
		if ($num == 1) {
			$tb0 = $this->bd->select("SELECT to_char(ULTFEC,'dd/mm/yyyy') as VALOR FROM NPNOMINA WHERE CODNOM='" . $tipnom . "'");
			return $tb0->fields["valor"];
		} else {
			$tb0 = $this->bd->select("SELECT to_char(profec,'dd/mm/yyyy') as VALOR FROM NPNOMINA WHERE CODNOM='" . $tipnom . "'");
			return $tb0->fields["valor"];
		}
	}
	//IMPRIME UNA CELDA POSICIONADA
	function celda($x, $y, $mensaje, $l = 0, $r = 0, $p = 'L') {
		if ($y == '') {
			$this->setX($x);
			$this->cell(20, 3, $mensaje, $l, $r, $p);
		} else {
			$this->setXY($x, $y);
			$this->cell(20, 0, $mensaje, $l, $r, $p);
		}
	}

	function llenartitulosmaestro() {
	}

	function Header() {
		//$this->cab->poner_cabecera($this,$_POST["titulo"],"p","s");
		$this->cab->poner_cabecera($this, "", "p", "s");
		$this->setFont("Arial", "B", 9);
		$mes2 = substr($this->fecreg2, 3, 2);
		//  $this->celda(15,43,'RECURSOS HUMANOS');

		$this->setFont("Arial", "B", 9);
		$this->setXY(10, 40);
		$this->Multicell(0, 4, "LISTADO DE FUNCIONARIOS DE LA CONTRALORIA DE\nCHACAO CON LOS MONTOS A SER DEPOSITADOS INDIVIDUALMENTE\nCORRESPONDIENTE AL MES DE " . $this->mes[$mes2], 0, 'C', 0);
		$this->Multicell(0, 4, "DIAS ADICIONALES", 0, 'C', 0);
		$this->ln(10);
		$tipo = $this->CFnomnom($this->tipnom);

	}
	function PutLink($URL, $txt) {
		$this->SetTextColor(0, 0, 255);
		$this->SetStyle('U', true);
		$this->Write(5, $txt, $URL);
		$this->SetStyle('U', false);
		$this->SetTextColor(0);
	}
	function SetStyle($tag, $enable) {
		//Modificar estilo y escoger la fuente correspondiente
		$this-> $tag += ($enable ? 1 : -1);
		$style = '';
		foreach (array (
				'B',
				'I',
				'U'
			) as $s)
			if ($this-> $s > 0)
				$style .= $s;
		$this->SetFont('', $style);
	}

	function Cuerpo() {
		while (!$this->tb->EOF) {
			if ($this->cab1 == '1') {
				$this->setFont("Arial", "B", 9);
				$this->setX(20);
				$this->cell(70, 0, 'Nomina:   ' . $this->tb->fields["codnomapo"] . ' - ' . $this->tb->fields["nomnom"]);
				$this->ln(4);
				$fechades = $this->CFfecha($this->tipnom, 1);
				$fechahas = $this->CFfecha($this->tipnom, 2);
				$this->setX(20);
				if ($this->codtipapodes == '0001' or $this->codtipapodes == '0002') {
					//	$this->cell(50,0,'Fecha al: '.$fechahas);
					$this->cell(50, 0, 'Fecha desde:   ' . $this->fecreg1 . '   hasta:  ' . $this->fecreg2);
				} else
					$this->cell(50, 0, 'Fecha desde:   ' .
					$this->fecreg1 . '   hasta:  ' . $this->fecreg2);
				$this->ln(4);
				$this->setX(20);
				$this->cell(50, 0, 'Categoria desde:   ' . $this->catdes . '   hasta:  ' . $this->cathas);

				$this->setXY(20, 80);
				$this->setwidths(array (
					41,
					101,
					41
				));
				$this->setaligns(array (
					"C",
					"C",
					"C"
				));
				$this->setborder(1);
				$this->rowm(array (
					"Cedula de Identidad",
					"Funcionario",
					"Prest. Soc. Total a Depositar"
				));
				$this->setY(90);
				$this->pri = true;
				$this->line(20, 80, 20, 260);
				$this->line(61, 80, 61, 260);
				$this->line(162, 80, 162, 260);
				$this->line(203, 80, 203, 260);
				$this->line(20, 260, 203, 260);
				$this->setFont("Arial", "", 9);
			}
			$this->sql2 = "
			select codemp as codemp,cedemp,CODNOM,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV,sum(monto) as monto  ,cast(REPLACE(cedemp,'.', '') as int ) from (select distinct codemp as codemp,cedemp,CODNOM,codcar,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV,monto,cast(REPLACE(cedemp,'.', '') as int ) from ((SELECT
									DISTINCT
									A.CODEMP as codemp,
									B.CEDEMP as cedemp,
									A.CODNOM,
									A.CODCAR as codcar,
									SUM(A.monto) as MONTO,
									to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') as  FECING,
									B.NOMEMP as nomemp,
									B.NACEMP,
									to_char(B.FECNAC,'dd/mm/yyyy') as fecnac,
									B.SEXEMP as sexemp,
									B.CODNIV, cast(REPLACE(b.cedemp,'.', '') as int ), '0014' as codtipapor
									 FROM
									   nphiscon  A,NPHOJINT B, npdefcpt e, npconsalint d
									 WHERE
									 " . $this->especial . "
									B.CODEMP = A.CODEMP and A.codcon = d.codcon and A.codnom = d.codnom
									--AND e.opecon='A'
									AND  A.CODNOM = '" . $this->tb->fields["codnomapo"] . "'
									AND  B.CODEMP >=  ('" . $this->codempdes . "')
									AND  B.CODEMP <= ('" . $this->codemphas . "')
									and a.codcat >= ('" . $this->catdes . "')
									and a.codcat <= ('" . $this->cathas . "') AND
									A.fecnom >= to_date('" . $this->fecreg1 . "','dd/mm/yyyy') AND A.fecnom <= to_date('" . $this->fecreg2 . "','dd/mm/yyyy') and
			                        a.codcon=e.codcon   and ( montorethist('0014','A',A.CODNOM,B.CODEMP,A.CODCAR,'" . $this->fecreg1 . "','" . $this->fecreg2 . "') +  montorethist('0014','R',A.CODNOM,B.CODEMP,A.CODCAR,'" . $this->fecreg1 . "','" . $this->fecreg2 . "') )> 0
									GROUP BY A.CODEMP, B.CEDEMP, A.CODNOM, A.CODCAR, to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') ,
				                    B.NOMEMP , B.NACEMP, to_char(B.FECNAC,'dd/mm/yyyy') , B.SEXEMP ,B.CODNIV, a.codcat order by cast(REPLACE(b.cedemp,'.', '') as int ) )
			union all
					             (    SELECT
									DISTINCT
									A.CODEMP as codemp,
									B.CEDEMP as cedemp,
									A.CODNOM,
									A.CODCAR as codcar,
									SUM(A.monto) as MONTO,
									to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') as  FECING,
									B.NOMEMP as nomemp,
									B.NACEMP,
									to_char(B.FECNAC,'dd/mm/yyyy') as fecnac,
									B.SEXEMP as sexemp,
									B.CODNIV, cast(REPLACE(b.cedemp,'.', '') as int ), '0013' as codtipapor
									 FROM
									   nphiscon  A,NPHOJINT B, npdefcpt e, npconsalint d
									 WHERE
									  " . $this->especial . "
									B.CODEMP = A.CODEMP and A.codcon = d.codcon and A.codnom = d.codnom
									--AND e.opecon='A'
									AND  A.CODNOM = '" . $this->tb->fields["codnomapo"] . "'
									AND  B.CODEMP >=  ('" . $this->codempdes . "')
									AND  B.CODEMP <= ('" . $this->codemphas . "')
									and a.codcat >= ('" . $this->catdes . "')
									and a.codcat <= ('" . $this->cathas . "') AND
									A.fecnom >= to_date('" . $this->fecreg1 . "','dd/mm/yyyy') AND A.fecnom <= to_date('" . $this->fecreg2 . "','dd/mm/yyyy') and
			                        a.codcon=e.codcon   and ( montorethist('0013','A',A.CODNOM,B.CODEMP,A.CODCAR,'" . $this->fecreg1 . "','" . $this->fecreg2 . "') +  montorethist('0013','R',A.CODNOM,B.CODEMP,A.CODCAR,'" . $this->fecreg1 . "','" . $this->fecreg2 . "') )> 0
									GROUP BY A.CODEMP, B.CEDEMP, A.CODNOM, A.CODCAR, to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') ,
				                    B.NOMEMP , B.NACEMP, to_char(B.FECNAC,'dd/mm/yyyy') , B.SEXEMP ,B.CODNIV, a.codcat order by cast(REPLACE(b.cedemp,'.', '') as int  )
									) )a group by
									codemp,cedemp,CODNOM,codcar,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV,monto
			                      )a group by
			codemp,cedemp,CODNOM,FECING,nomemp,NACEMP,fecnac,sexemp,CODNIV  order by cast(REPLACE(cedemp,'.', '') as int )

				                    		";

			//print '<pre>'; print $this->sql2;

			$tb2 = $this->bd->select($this->sql2);
			$cs_total = 0;
			$num_emp = 0;
			$cs_ret = 0;
			$cs_apo = 0;

			{
				//DETALLE DEL TIPO DE APORTE Y RENTENCION
				$this->setFont("Arial", "B", 7);
				while (!$tb2->EOF) {
					$this->sql4 = ("SELECT SUM(monto) as ELMONTO FROM nphiscon A, NPHOJINT B, NPCONTIPAPORET C
															 WHERE
															 C.CODTIPAPO='" . $tb2->fields["codtipapor"] . "' AND
															 A.CODNOM=C.CODNOM AND
															 A.CODCON=C.CODCON AND
															 C.TIPO='R' AND
															 B.CODEMP=A.CODEMP and " . $this->especial2 . "
															 B.CODEMP='" . $tb2->fields["codemp"] . "' and
													         a.FECNOM>=to_date('" . $this->fecreg1 . "','dd/mm/yyyy') AND
													         a.FECNOM<=to_date('" . $this->fecreg2 . "','dd/mm/yyyy')
															");

					//	print '<pre>'; print $this->sql4;
					$tb4 = $this->bd->select($this->sql4);
					//condicion para quitar a los trabajadore que tengan retencion igual a cero
					//if ($this->codtipapodes=='0012' OR $this->codtipapodes=='0013' OR $this->codtipapodes=='0014' OR number_format($tb4->fields["elmonto"],2,'.',',')>0 )
					{
						$num_emp++;
						$this->celda(23, '', $tb2->fields["cedemp"]);

						$cs_ret = $cs_ret + $tb4->fields["elmonto"];
						$this->sql5_ = "SELECT SUM(monto) as ELMONTO FROM nphiscon A, NPHOJINT B, NPCONTIPAPORET C
																 WHERE
																 C.CODTIPAPO='0014'  AND
																 A.CODNOM=C.CODNOM AND
																 A.CODCON=C.CODCON AND
																 C.TIPO='A' AND
																 B.CODEMP=A.CODEMP and  " . $this->especial2 . "
																 B.CODEMP='" . $tb2->fields["codemp"] . "' ";

						$this->sql5 = "select sum (ELMONTO) as ELMONTO from (SELECT SUM(MONTO) as  ELMONTO
																 FROM NPCONTIPAPORET C, NPHOJINT B, NPHISCON A
																 WHERE
																 C.CODTIPAPO='0014' AND
																 B.CODEMP='" . $tb2->fields["codemp"] . "' AND
																 FECNOM>=to_date('" . $this->fecreg1 . "','dd/mm/yyyy') AND
														  		 FECNOM<=to_date('" . $this->fecreg2 . "','dd/mm/yyyy') AND
																 A.CODCAR='" . $tb2->fields["codcar"] . "' AND
																 A.CODNOM=C.CODNOM AND
																 A.CODCON=C.CODCON AND
																 C.TIPO='A' AND
																 B.CODEMP=A.CODEMP
																 union
																 SELECT SUM(MONTO) as  ELMONTO
																 FROM NPCONTIPAPORET C, NPHOJINT B, NPHISCON A
																 WHERE
																 (C.CODTIPAPO='0013' or C.CODTIPAPO='0014')  and
																 B.CODEMP='" . $tb2->fields["codemp"] . "' AND
																 FECNOM>=to_date('" . $this->fecreg1 . "','dd/mm/yyyy') AND
														  		 FECNOM<=to_date('" . $this->fecreg2 . "','dd/mm/yyyy') AND
															--	 A.CODCAR='" . $tb2->fields["codcar"] . "' AND
																 A.CODNOM=C.CODNOM AND
																 A.CODCON=C.CODCON AND
																 C.TIPO='A' AND
																 B.CODEMP=A.CODEMP)a

						";

						//print '<pre>'; print $this->sql5;
						$tb5 = $this->bd->select($this->sql5);
						$this->celda(180, '', number_format($tb5->fields["elmonto"], 2, '.', ',') . '', 0, 0, 'R');

						if (!$this->pri) {
							$this->line(20, $this->gety(), 203, $this->gety());
						}
						$this->pri = false;
						$cs_apo = $cs_apo + $tb5->fields["elmonto"];
						$CF_total = $tb4->fields["elmonto"] + $tb5->fields["elmonto"];
						$cs_total = $cs_total + $CF_total;
						//$this->celda(180,'',number_format($CF_total,2,'.',','),0,0,'R');
						$this->setX(63);
						$this->multicell(101, 3, $tb2->fields["nomemp"]);
						if ($this->gety() > 250) {
							$this->AddPage();
							$this->line(20, 68, 20, 260);
							$this->line(61, 68, 61, 260);
							$this->line(162, 68, 162, 260);
							$this->line(203, 68, 203, 260);
							$this->line(20, 260, 203, 260);
						}
						$this->line();
						//fin de la condicion
						$this->ln(2);
					}

					$tb2->MoveNext();
					if ($tb2->EOF) {
						$this->cab1 = "0";
						$this->AddPage();
						$this->cab1 = "1";
						$this->rect(50, 95, 100, 40);
						$this->setFont("Arial", "B", 12);
						// $this->celda(100,85,'RESUMEN');
						$this->setFont("Arial", "B", 9);
						$this->celda(85, 100, 'Total de Trabajadores:                   ' . number_format($num_emp, 2, '.', ','));
						// $this->celda(85,110,'Monto Total:                     '.number_format($cs_total,2,'.',','));
						// $this->celda(85,120,'Retenciones:                    '.number_format($cs_ret,2,'.',','));
						$this->celda(85, 130, 'Monto Total:                           ' . number_format($cs_apo, 2, '.', ','));
						$this->setFont("Arial", "B", 14);
						//	 $this->celda(57,115,'TOTAL');

						$this->setFont("Arial", "", 8);

						$this->setxy(10, 240);
						$this->cell(75, 10, "Elaborado: " . $this->elab, 0, 0, 'l');
						$this->cell(75, 10, "Revisado: " . $this->rev, 0, 0, 'l');
						$this->cell(75, 10, "Autorizado: " . $this->auto, 0, 0, 'l');
					}

				}
				$this->setFont("Arial", "B", 9);
			}
$this->tb->MoveNext();
			if (!$this->tb->EOF) {
				$this->AddPage();
			}

		}
		$this->cab1 = "0";
						$this->AddPage();
						$this->cab1 = "1";
						$this->rect(50, 95, 100, 40);
						$this->setFont("Arial", "B", 12);
						// $this->celda(100,85,'RESUMEN');
						$this->setFont("Arial", "B", 9);
						$this->celda(85, 100, 'Total de Trabajadores:                   ' . number_format($num_emp, 2, '.', ','));
						// $this->celda(85,110,'Monto Total:                     '.number_format($cs_total,2,'.',','));
						// $this->celda(85,120,'Retenciones:                    '.number_format($cs_ret,2,'.',','));
						$this->celda(85, 130, 'Monto Total:                           ' . number_format($cs_apo, 2, '.', ','));
						$this->setFont("Arial", "B", 14);
						//	 $this->celda(57,115,'TOTAL');

						$this->setFont("Arial", "", 8);

						$this->setxy(10, 240);
						$this->cell(75, 10, "Elaborado: " . $this->elab, 0, 0, 'l');
						$this->cell(75, 10, "Revisado: " . $this->rev, 0, 0, 'l');
						$this->cell(75, 10, "Autorizado: " . $this->auto, 0, 0, 'l');
		$txt = 'SI';
		if ($txt == 'SI') {
			$this->sety(150);

			$dir = parse_url($_SERVER['HTTP_REFERER']);
			$dirpath = $dir['path'];
			if (!(strrpos($dir['path'], ".php")))
				$dirpath = $dir['path'] .
				".php";
			$dir = eregi_replace(".php", "_hc.php", $dir['scheme'] . '://' . $dir['host'] . $dirpath);
			$this->PutLink(trim($dir) . '?codempdes=' . $_POST["codempdes"] . '&codemphas=' . $_POST["codemphas"] . '&tipnom=' . $_POST["tipnom"] . '&tipnom2=' . $_POST["tipnom2"] . '&codcatdes=' . $_POST["codcatdes"] . '&codcathas=' . $_POST["codcathas"] . '&especial=' . $_POST["especial"] . '&tipnomesp=' . $_POST["tipnomesp"] . '&codtipapodes=' . $_POST["codtipapodes"] . '&fec1=' . $_POST["fecreg1"] . '&fec2=' . $_POST["fecreg2"] . '&schema=' . $_SESSION["schema"], 'Descargar TXT de Dias Adicionales Prestaciones');

		} //fin del si txt
	} //cuerpo
} //clase
?>
