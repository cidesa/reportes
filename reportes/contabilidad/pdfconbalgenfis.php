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

		var $codctades;
		var $codctahas;
		var $periodo;
		var $jefecont;
		var $contmunicipal;
		var $comodin;
		var $titulo;

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
			$this->codctades=$_POST["codctades"];
			$this->codctahas=$_POST["codctahas"];
			$this->periodo=$_POST["periodo"];
			$this->jefecont=$_POST["jefecont"];
			$this->contmunicipal=$_POST["contmunicipal"];
			$this->comodin=$_POST["comodin"];
			$this->titulo=$_POST["titulo"];

			$this->acttes="select substr(a.codcta,5,3) as codctaacttes,
						b.descta as desctaacttes,
						a.salact as salactacttes
						from contabb1 a,contabb b
						where
						b.debcre='D' and
						rtrim(a.codcta)=rtrim(b.codcta) and
						substr(a.codcta,1,7) >= rtrim('".$this->codctades."') and
						substr(a.codcta,1,7) <= rtrim('".$this->codctahas."') and
						rtrim(a.codcta) like rtrim('1-1')||'%'  and
						a.pereje='".$this->periodo."' and
						length(rtrim(a.codcta))=7  and
						salact <> 0
						order by a.codcta";


			$this->pastes="select substr(a.codcta,5,3) as codctapastes,
							b.descta as desctapastes,
							a.salact*-1 as salactpastes
							from contabb1 a,contabb b,contaba c
							where
							c.codemp='001' and
							b.debcre='C' and
							rtrim(a.codcta)=rtrim(b.codcta) and
							substr(a.codcta,1,7) >= rtrim('".$this->codctades."') and
							substr(a.codcta,1,7) <= rtrim('".$this->codctahas."') and
							rtrim(a.codcta) like rtrim('1-2')||'%'  and
							a.pereje='".$this->periodo."' and
							a.fecini =c.fecini and
							a.feccie=c.feccie and
							length(rtrim(a.codcta))=7
							order by a.codcta";

			$this->acthac="select substr(a.codcta,5,3) as codctaacthac,
							b.descta as desctaacthac,
							a.salact as salactacthac
							from contabb1 a,contabb b,contaba c
							where
							c.codemp='001' and
							b.debcre='D' and
							rtrim(a.codcta)=rtrim(b.codcta) and
							substr(a.codcta,1,7) >= rtrim('".$this->codctades."') and
							substr(a.codcta,1,7) <= rtrim('".$this->codctahas."') and
							rtrim(a.codcta) like rtrim('2-1-')||'%'  and
							a.pereje='".$this->periodo."' and
							a.fecini =c.fecini and
							a.feccie=c.feccie and
							length(rtrim(a.codcta))=7
							order by a.codcta";

			$this->pashac="select substr(a.codcta,5,3) as codctapashac,
							b.descta as desctapashac,
							a.salact*-1 as salactpashac
							from contabb1 a,contabb b,contaba c
							where
							c.codemp='001' and
							b.debcre='C' and
							rtrim(a.codcta)=rtrim(b.codcta) and
							substr(a.codcta,1,7) >= rtrim('".$this->codctades."') and
							substr(a.codcta,1,7) <= rtrim('".$this->codctahas."') and
							rtrim(a.codcta) like rtrim('2-3-')||'%'  and
							a.pereje='".$this->periodo."' and
							a.fecini =c.fecini and
							a.feccie=c.feccie and
							length(rtrim(a.codcta))=7
							order by a.codcta";

			$this->actpre = "select substr(a.codcta,5,3) as codctaactpre,
							b.descta as desctaactpre,
							a.salact as salactactpre
							from contabb1 a,contabb b,contaba c
							where
							c.codemp='001' and
							b.debcre='D' and
							rtrim(a.codcta)=rtrim(b.codcta) and
							substr(a.codcta,1,7) >= rtrim('".$this->codctades."') and
							substr(a.codcta,1,7) <= rtrim('".$this->codctahas."') and
							rtrim(a.codcta) like rtrim('3-1-')||'%'  and
							a.pereje='".$this->periodo."' and
							a.fecini =c.fecini and
							a.feccie=c.feccie and
							length(rtrim(a.codcta))=7
							order by a.codcta";

			$this->paspre = "select substr(a.codcta,5,3) as codctaingpre,
							b.descta as desctaingpre,
							a.salact*-1 as salactingpre
							from contabb1 a,contabb b,contaba c
							where
							c.codemp='001' and
							b.debcre='C' and
							rtrim(a.codcta)=rtrim(b.codcta) and
							substr(a.codcta,1,7) >= rtrim('".$this->codctades."') and
							substr(a.codcta,1,7) <= rtrim('".$this->codctahas."') and
							rtrim(a.codcta) like rtrim('3-2-')||'%'  and
							a.pereje='".$this->periodo."' and
							a.fecini =c.fecini and
							a.feccie=c.feccie and
							length(rtrim(a.codcta))=7
							order by a.codcta";


			$this->llenartitulosmaestro();
			$this->cab=new cabecera();
		}

		function llenartitulosmaestro()
		{
				$this->anchos[0]=140;
				$this->anchos[1]=40;
				$this->anchos[2]=40;
				$this->anchos[3]=120;
		}

		function Header()
		{

			$this->Image("../../img/logo_1.jpg",10,8,33);
			$this->setFont("Arial","",9);
			$fecha=date("d/m/Y");
			$this->Cell(470,15,' Fecha: '.$fecha,0,0,'C');
			$this->ln(5);
			$this->Cell(470,15,'Pagina: '.$this->PageNo().' de {nb}',0,0,'C');
			$this->setFont("Arial","B",11);
			$this->SetTextColor(0,0,128);
			$this->ln(10);
			$this->Cell(270,10,'BALANCE GENERAL',0,0,'C',0);
			$this->ln(5);
			$this->setFont("Arial","B",9);
			$this->Cell(270,10,'(Periodo  '.$this->periodo.')',0,0,'C',0);
			$this->ln(10);
			$this->Line(10,40,270,40);


			$this->setFont("Arial","BU",9);
			$this->SetXY(40,43);
			$this->cell(40,5,"ACTIVOS");
			$this->SetXY(190,43);
			$this->cell(40,5,"PASIVOS");
			$this->Line(10,48,270,48);
			$this->ln();
		}


		function Cuerpo()
		{

			$tb=$this->bd->select($this->acttes);
			$tb2=$this->bd->select($this->pastes);
				$this->setFont("Arial","B",10);
				$this->SetTextColor(0,0,128);
				$this->ln(10);
				$this->cell(270,5,"CUENTAS DEL TESORO",0,0,'C',0);
				$this->SetTextColor(0,0,0);
				$this->setFont("Arial","B",8);
				$this->ln(5);
				$y= $this->GetY();
				$act=0;
				$pas=0;

			while (!$tb->EOF ||  !$tb2->EOF){

				while  (!$tb->EOF){
					$this->SetX(100);
					$this->Cell(30,3,number_format($tb->fields["salactacttes"],2,'.',','),0,'R',0);
					$act+=$tb->fields["salactacttes"];
					$this->SetX(12);
					$this->MultiCell(70,3,$tb->fields["desctaacttes"]);
					$this->ln();
					$y1=$this->GetY();
					$tb->MoveNext();
				}

				$this->SetY($y);
				while (!$tb2->EOF){
					$this->SetX(235);
					$this->Cell(30,3,number_format($tb->fields["salactpastes"],2,'.',','),0,'R',0);
					$pas+=$tb->fields["salactpastes"];
					$this->SetX(150);
					$this->MultiCell(70,3,$tb->fields["desctapastes"]);
					$this->ln();
					$y2=$this->GetY();
					$tb2->MoveNext();
				}
				//Totales
				if ($y1>=$y2) { $y=$y1; }
				else {$y=$y2;}

			} // fin de tesoro

				$this->Line(100,$y,130,$y);
				$this->Line(100,$y+6,130,$y+6);
				$this->Line(235,$y,265,$y);
				$this->Line(235,$y+6,265,$y+6);
				$this->SetLineWidth(0.5);
				$this->Line(100,$y+7,130,$y+7);
				$this->Line(235,$y+7,265,$y+7);
				$this->SetY($y);
				$this->SetX(100);
				$this->Cell(30,5,number_format($act,2,'.',','),0,'R',0);
				$this->SetX(235);
				$this->Cell(30,5,number_format($pas,2,'.',','),0,'R',0);

				//////////////////// HACIENDA /////////////////////////
			$tact=0;
			$tpas=0;

			$tb=$this->bd->select($this->acthac);
			$tb2=$this->bd->select($this->pashac);
				$this->setFont("Arial","B",10);
				$this->SetTextColor(0,0,128);
				$this->ln(10);
				$this->cell(270,5,"CUENTAS DE HACIENDA",0,0,'C',0);
				$this->SetTextColor(0,0,0);
				$this->setFont("Arial","B",8);
				$this->ln(5);
				$y= $this->GetY();
				$act=0;
				$pas=0;

			while (!$tb->EOF ||  !$tb2->EOF){

				while  (!$tb->EOF){
					$this->SetX(100);
					$this->Cell(30,3,number_format($tb->fields["salactacthac"],2,'.',','),0,'R',0);
					$act+=$tb->fields["salactacthac"];
					$this->SetX(12);
					$this->MultiCell(70,3,$tb->fields["desctaacthac"]);
					$this->ln();
					$y1=$this->GetY();
					$tb->MoveNext();
				}

				$this->SetY($y);
				while (!$tb2->EOF){
					$this->SetX(235);
					$this->Cell(30,3,number_format($tb->fields["salactpashac"],2,'.',','),0,'R',0);
					$pas+=$tb->fields["salactpashac"];
					$this->SetX(150);
					$this->MultiCell(70,3,$tb->fields["desctapashac"]);
					$this->ln();
					$y2=$this->GetY();
					$tb2->MoveNext();
				}
				//Totales
				if ($y1>=$y2) { $y=$y1; }
				else {$y=$y2;}

			} // fin de hacienda

				$this->SetLineWidth(0);
				$this->Line(100,$y,130,$y);
				$this->Line(100,$y+6,130,$y+6);
				$this->Line(235,$y,265,$y);
				$this->Line(235,$y+6,265,$y+6);
				$this->SetLineWidth(0.5);
				$this->Line(100,$y+7,130,$y+7);
				$this->Line(235,$y+7,265,$y+7);
				$this->SetY($y);
				$this->SetX(100);
				$this->Cell(30,5,number_format($act,2,'.',','),0,'R',0);
				$this->SetX(235);
				$this->Cell(30,5,number_format($pas,2,'.',','),0,'R',0);
				$tact=$act;
				$tpas=$pas;

				//////////////////// PRESUPUESTO /////////////////////////

			$tb=$this->bd->select($this->actpre);
			$tb2=$this->bd->select($this->paspre);
				$this->setFont("Arial","B",10);
				$this->SetTextColor(0,0,128);
				$this->ln(10);
				$this->cell(270,5,"CUENTAS DEL PRESUPUESTO",0,0,'C',0);
				$this->SetTextColor(0,0,0);
				$this->setFont("Arial","B",8);
				$this->ln(5);
				$y= $this->GetY();
				$act=0;
				$pas=0;

			while (!$tb->EOF ||  !$tb2->EOF){

				while  (!$tb->EOF){
					$this->SetX(100);
					$this->Cell(30,3,number_format($tb->fields["salactactpre"],2,'.',','),0,'R',0);
					$act+=$tb->fields["salactactpre"];
					$this->SetX(12);
					$this->MultiCell(70,3,$tb->fields["desctaactpre"]);
					$this->ln();
					$y1=$this->GetY();
					$tb->MoveNext();
				}

				$this->SetY($y);
				while (!$tb2->EOF){
					$this->SetX(235);
					$this->Cell(30,3,number_format($tb->fields["salactingpre"],2,'.',','),0,'R',0);
					$pas+=$tb->fields["salactingpre"];
					$this->SetX(150);
					$this->MultiCell(70,3,$tb->fields["desctaingpre"]);
					$this->ln();
					$y2=$this->GetY();
					$tb2->MoveNext();
				}
				//Totales
				if ($y1>=$y2) { $y=$y1; }
				else {$y=$y2;}

			} // fin de hacienda

				$this->SetLineWidth(0);
				$this->Line(100,$y,130,$y);
				$this->Line(100,$y+6,130,$y+6);
				$this->Line(235,$y,265,$y);
				$this->Line(235,$y+6,265,$y+6);
				$this->SetLineWidth(0.5);
				$this->Line(100,$y+7,130,$y+7);
				$this->Line(235,$y+7,265,$y+7);
				$this->SetY($y);
				$this->SetX(100);
				$this->Cell(30,5,number_format($act,2,'.',','),0,'R',0);
				$this->SetX(235);
				$this->Cell(30,5,number_format($pas,2,'.',','),0,'R',0);
				$tact+=$act;
				$tpas+=$pas;
				$this->ln(10);
				$y=$this->GetY();

			/////////////// totales ///////////////////////////////////
			$this->SetLineWidth(0);
			$this->Line(100,$y,130,$y);
			$this->Line(100,$y+6,130,$y+6);
			$this->Line(235,$y,265,$y);
			$this->Line(235,$y+6,265,$y+6);
			$this->SetLineWidth(0.5);
			$this->Line(100,$y+7,130,$y+7);
			$this->Line(235,$y+7,265,$y+7);
			$this->SetY($y);
			$this->SetX(100);
			$this->Cell(30,5,number_format($tact,2,'.',','),0,'R',0);
			$this->SetX(235);
			$this->Cell(30,5,number_format($tpas,2,'.',','),0,'R',0);

			$this->Ln(15);
			$this->setFont("Arial","BI",8);
			$y=$this->GetY();
			$this->SetXY(40,$y);
			$this->Cell(10,4,'JEFE DE CONTABILIDAD');
			$this->SetX(190);
			$this->Cell(10,4,'CONTADOR MUNICIPAL');
			$this->SetXY(40,$y+6);
			$this->Cell(10,4,$this->jefecont);
			$this->SetX(190);
			$this->Cell(10,4,$this->contmunicipal);





		}
	}
?>