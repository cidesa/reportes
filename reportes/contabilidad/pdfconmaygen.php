<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $anchos2;
		var $campos;
		var $sql;
		var $sql2;
		var $rep;
		var $numero;
		var $cab;
		var $codctades;
		var $codctahas;
		var $feccom1;
		var $feccom2;

		function pdfreporte()
		{
			$this->fpdf("l","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->codctades=$_POST["codctades"];
			$this->codctahas=$_POST["codctahas"];
			$this->feccom1=$_POST["feccom1"];
			$this->feccom2=$_POST["feccom2"];
			$this->estado=strtoupper($_POST["estado"]);
			if($this->estado=='T')
				$sqlestado="";
			else
				$sqlestado="AND (c.stacom='".$this->estado."')";

			$this->sql="SELECT
 							A.CODCTA as codcta,
							A.DESCTA as descta,
							to_char(B.FECCOM,'dd/mm/yyyy') as feccom,
							B.NUMCOM as numcom,
							B.REFASI as refasi,
							C.DESCOM as descom,
							(CASE WHEN B.DEBCRE='D' THEN B.MONASI ELSE 0 END) as DEBITOS,
							(CASE WHEN B.DEBCRE='C' THEN B.MONASI ELSE 0 END) as CREDITOS
						FROM
							CONTABB A,
							CONTABC1 B,
							CONTABC C
						WHERE
							A.CODCTA = B.CODCTA AND
							B.NUMCOM = C.NUMCOM AND
							B.FECCOM = C.FECCOM AND
            				(A.CODCTA) >= ('".$this->codctades."') AND
            				(A.CODCTA) <= ('".$this->codctahas."')  AND
            				B.FECCOM >= to_date('".$this->feccom1."','dd/mm/yyyy') AND
							B.FECCOM <= to_date('".$this->feccom2."','dd/mm/yyyy') and
							C.STACOM <> 'N' AND
        					C.STACOM <> 'R'
							$sqlestado
						ORDER BY A.CODCTA,B.CODCTA,B.FECCOM,B.DEBCRE desc,B.NUMCOM";
					//print $this->sql;
			$this->cab=new cabecera();

		}

		function Header()
		{
			$this->cab->poner_cabecera($this,$_POST["titulo"],"1","s","s");
			$this->setFont("Arial","B",9);
			$this->cell(100,5,'                                                                                                                                     Expresado en Bolivares');
			$this->setFont("Arial","B",9);
			$this->ln(8);
		}
		function Cuerpo()
		{


			$tb=$this->bd->select($this->sql);
		    $tb2=$this->bd->select($this->sql);
			$ref="";
			$acum1=0;
			$acum2=0;
			$acum3=0;
			$x=0;
			$y=0;
			if(!$tb2->EOF)
			{
				$ref=$tb2->fields["codcta"];
				 $this->setFont("Arial","B",8);
				 $acunSaldoActual=0;
				  $cuenta_padre=substr($tb2->fields["codcta"],0,13);
				  $bb=$this->bd->select("SELECT DESCTA as cuenta FROM CONTABB WHERE CODCTA=('".$cuenta_padre."')");
				  if(!$bb->EOF)
				  {
				  	$cuentaMayor=$bb->fields["cuenta"];
				  }
				  $this->ln(2);
				 $this->cell(50,10,'													Cuenta Mayor: '.$cuentaMayor);
				 $this->ln(4);
				 $this->cell(50,10,'													Codigo Cuenta: '.$tb2->fields["codcta"]);
				 $this->ln(4);
				 $this->cell(50,10,'													Descripcion Cuenta: '.$tb2->fields["descta"]);
				 $this->ln(8);
				 $this->line(10,$this->getY(),270,$this->getY());
				 $this->ln(2);
				 $this->cell(20,5,'Fecha');
				 $this->cell(35,5,'Nro de Comprobante');
				 $this->cell(70,5,'Descripcion del Asiento');
     			 $this->cell(30,5,'Referencia');
				 $this->cell(30,5,'Debitos');
				 $this->cell(30,5,'Creditos');
				 $this->cell(40,5,'Saldo Actual');
				 $this->ln(4);
				 $this->line(10,$this->getY(),270,$this->getY());
				 $rs=$this->bd->select("SELECT SALANT as salant FROM CONTABB WHERE CODCTA=('".$tb2->fields["codcta"]."')");
				 if(!$rs->EOF)
				 {
				 	$saldoant=$rs->fields["salant"];
				 }
				 $res=$this->bd->select("SELECT 	sum((CASE WHEN C.DEBCRE='D' THEN C.MONASI ELSE 0 END)) as debitoant,
													sum((CASE WHEN C.DEBCRE='C' THEN C.MONASI ELSE 0 END)) as creditoant
											FROM 	CONTABB A,CONTABC B,CONTABC1 C
											WHERE 	A.CODCTA = C.CODCTA AND
												RTRIM(A.CODCTA) = RTRIM('".$tb2->fields["codcta"]."') AND
												A.CARGAB = 'C' AND
												B.NUMCOM = C.NUMCOM AND
												B.FECCOM = C.FECCOM AND
												C.FECCOM < to_date('".$this->feccom1."','dd/mm/yyyy') AND
												B.STACOM <> 'N' AND B.STACOM <> 'R' AND (b.stacom='A')");

				 if(!$res->EOF)
				 {
				 	$debitoanterior=$res->fields["debitoant"];
					$creditoanterior=$res->fields["creditoant"];
				 }
				 $saldoAnterior=$saldoant+$debitoanterior-$creditoanterior;
				 $this->ln(2);
				 $this->cell(20,5,'');
				 $this->cell(35,5,'');
				 $this->cell(70,5,'');
				 $this->cell(25,5,'');
				 $this->cell(40,5,'');
				 $this->cell(28,5,'');
				 if($saldoAnterior < 0)
				 {
				 	$this->cell(40,5,'Saldo Anterior... '.number_format(($saldoAnterior),2,'.',','));
				 }
				 else
				 {
				 	$this->cell(40,5,'Saldo Anterior... '.number_format($saldoAnterior,2,'.',','));
				 }
				  $acunSaldoActual=$saldoAnterior;
				 $this->ln(4);
			}
			while(!$tb->EOF)
			{
				if($tb->fields["codcta"]!=$ref)
				{
				 $this->setFont("Arial","B",8);
				  $cuenta_padre=substr($tb->fields["codcta"],0,13);
				  $bb=$this->bd->select("SELECT DESCTA as cuenta FROM CONTABB WHERE CODCTA=('".$cuenta_padre."')");
				  if(!$bb->EOF)
				  {
				  	$cuentaMayor=$bb->fields["cuenta"];
				  }
				  //Totales
					$this->ln(2);
					$this->line(10,$this->getY(),270,$this->getY());
					$this->ln(3);
					$this->cell(20,5,'');
					$this->cell(35,5,'');
					$this->cell(75,5,'');
					$this->cell(30,5,'');
					//$this->cell(25,5,'');
					$this->cell(30,5,number_format($acum1,2,'.',','));
					$this->cell(30,5,number_format($acum2,2,'.',','));
					if($acunSaldoActual < 0)
					{
						$this->cell(40,5,number_format(($acunSaldoActual),2,'.',','));
					}
					else
					{
						$this->cell(40,5,number_format($acunSaldoActual,2,'.',','));
					}
					$this->ln(4);
					$this->line(10,$this->getY(),270,$this->getY());
					$this->ln(4);
					$acum1=0;
					$acum2=0;
				    $acunSaldoActual=0;
				  ////
				 $this->cell(60,10,'													Cuenta Mayor: '.$cuentaMayor);
				 $this->ln(4);
				 $this->cell(50,10,'													Codigo Cuenta: '.$tb->fields["codcta"]);
				 $this->ln(4);
				 $this->cell(50,10,'													Descripcion Cuenta: '.$tb->fields["descta"]);
				 $this->ln(8);
				 $this->line(10,$this->getY(),270,$this->getY());
				 $this->ln(2);
				 $this->cell(20,5,'Fecha');
				 $this->cell(35,5,'Nro de Comprobante');
				 $this->cell(70,5,'Descripcion del Asiento');
				 $this->cell(30,5,'Referencia');
				 $this->cell(30,5,'Debitos');
				 $this->cell(30,5,'Creditos');
				 $this->cell(40,5,'Saldo Actual');
				 //$this->cell(20,5,$this->getY().' -- '.$this->getX());
				 $this->ln(4);
				 $this->line(10,$this->getY(),270,$this->getY());
				 $rs=$this->bd->select("SELECT SALANT as salant FROM CONTABB WHERE CODCTA=('".$tb->fields["codcta"]."')");
				 if(!$rs->EOF)
				 {
				 	$saldoant=$rs->fields["salant"];
				 }
				 $res=$this->bd->select("SELECT c.refasi as refasi,	sum((CASE WHEN C.DEBCRE='D' THEN C.MONASI ELSE 0 END)) as debitoant,
													sum((CASE WHEN C.DEBCRE='C' THEN C.MONASI ELSE 0 END)) as creditoant
											FROM 	CONTABB A,CONTABC B,CONTABC1 C
											WHERE 	A.CODCTA = C.CODCTA AND
												RTRIM(A.CODCTA) = RTRIM('".$tb2->fields["codcta"]."') AND
												A.CARGAB = 'C' AND
												B.NUMCOM = C.NUMCOM AND
												B.FECCOM = C.FECCOM AND
												C.FECCOM < to_date('".$this->feccom1."','dd/mm/yyyy') AND
												B.STACOM <> 'N' AND B.STACOM <> 'R' AND (b.stacom='A')");

				 if(!$res->EOF)
				 {
				 	$refasi=$res->fields["refasi"];
					$debitoanterior=$res->fields["debitoant"];
					$creditoanterior=$res->fields["creditoant"];
				 }
				 $saldoAnterior=$saldoant+$debitoanterior-$creditoanterior;
				 $this->ln(2);
				 $this->cell(20,5,'');
				 $this->cell(35,5,'');
				 $this->cell(70,5,'');
				 $this->cell(30,5,'');
				 $this->cell(30,5,'');
				 $this->cell(30,5,'');
				 if($saldoAnterior < 0)
				 {
				 	$this->cell(40,5,'Saldo Anterior... '.number_format(($saldoAnterior),2,'.',','));
				 }
				 else
				 {
				 	$this->cell(40,5,'Saldo Anterior... '.number_format($saldoAnterior,2,'.',','));
				 }
				  $acunSaldoActual=$saldoAnterior;
				 $this->ln(4);
		        }
				$ref=$tb->fields["codcta"];
				$this->setFont("Arial","",8);
				//Detalle
				 $this->cell(20,3,$tb->fields["feccom"]);
				 $this->cell(35,3,$tb->fields["numcom"]);
				 $x=$this->GetX();
				 $this->setFont("Arial","",7);
				 $this->cell(70);
				 $this->setFont("Arial","",8);
				 $this->cell(15,3,$tb->fields["refasi"],0,0,'R');
				 $this->cell(15);
				 $this->cell(13,3,number_format($tb->fields["debitos"],2,'.',','),0,0,'R');
				 $this->cell(30,3,number_format($tb->fields["creditos"],2,'.',','),0,0,'R');
				 $acunSaldoActual=$acunSaldoActual+$tb->fields["debitos"]-$tb->fields["creditos"];
				 if($acunSaldoActual < 0)
				 {
				 	$this->cell(38,3,number_format($acunSaldoActual,2,'.',','),0,0,'R');
				 }
				 else
				 {
				 	$this->cell(38,3,number_format($acunSaldoActual,2,'.',','),0,0,'R');
				 }
				 $acum1=$acum1+$tb->fields["debitos"];
				 $acum2=$acum2+$tb->fields["creditos"];
				 $this->SetX($x);
				 $this->setFont("Arial","",7);
				 $this->Multicell(65,3,$tb->fields["descom"]);
				 //$acum3=$acum3+$acunSaldoActual;
			     $this->ln(3);
				$tb->MoveNext();
			}
			$this->ln(5);
			$this->line(10,$this->getY(),270,$this->getY());
			$this->ln(4);
			$this->setFont("Arial","",8);
			$this->cell(20,5,'');
			$this->cell(35,5,'');
			$this->cell(75,5,'');
			$this->cell(30,5,'');
			//$this->cell(25,5,'');
			$this->cell(30,5,number_format($acum1,2,'.',','));
			$this->cell(30,5,number_format($acum2,2,'.',','));
			if($acunSaldoActual < 0)
			{
				$this->cell(40,5,number_format($acunSaldoActual,2,'.',','));
			}
			else
			{
				$this->cell(40,5,number_format($acunSaldoActual,2,'.',','));
			}
			$this->ln(4);
			$this->line(10,$this->getY(),270,$this->getY());
		}
	}
?>