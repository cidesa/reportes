<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");

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

var $ini;
var $inv;
		var $codctades;
		var $codctahas;
		var $periodo;
 		var $auxnivel;
		var $comodin;

		var $loniv1;
		var $fecha_ini;
		var $fecha_cie;
		var $nivel;
		var $fechainicio;
		var $total;

		function pdfreporte()
		{
			$this->fpdf("p","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->campos=array();
			$this->anchos=array();
			$this->titulos=array();
			$this->codctades=$_POST["codctades"];
			$this->codctahas=$_POST["codctahas"];
			$this->periodo=$_POST["periodo"];
			$this->auxnivel=$_POST["auxnivel"];
			$this->comodin=$_POST["comodin"];

			$n= $this->bd->select("select numrup as nrorup from contaba");
			$nrorup = $n->fields["nrorup"];

			if ($this->auxnivel==$nrorup) {
			      $n=$this->bd->select("SELECT LENGTH(RTRIM(FORCTA)) as nivel FROM CONTABA");
				}
			    else {
			    	$n=$this->bd->select("select forcta from contaba");
			    	$niv= 0;
			    	$pos=0;
			    	/*while ($niv < $this->auxnivel){
			    		$pos= stripos($n->fields["forcta"],'-',$pos+1);
			    		$niv+=1;
			    	}*/
			    	$pos= instr($n->fields["forcta"],'-',1,$this->auxnivel);
			      $n=$this->bd->select("SELECT LENGTH(SUBSTR(FORCTA,1,".$pos."-1)) as nivel FROM CONTABA");
			   }

			$this->sql="select orden,
						a.titulo,
						a.cuenta,
						a.nombre,
						a.debito,
						a.credito,
						a.saldo,
						a.cargable
						from cfbalcom a, contaba b
						where
						length(rtrim(a.cuenta))<= '".$n->fields["nivel"]."'  and
						rtrim( a.cuenta) >= rtrim('".$this->codctades."') and
						rtrim(a.cuenta) <= rtrim('".$this->codctahas."')  and
						rtrim(a.cuenta) like rtrim('".$this->comodin."') and
						((a.cargable='C' and a.saldo <> 0) or a.cargable<>'C') and
						( a.cuenta like (rtrim(b.codind)||'%')  or
						a.cuenta like (rtrim(b.codegd)||'%'))
						group by orden, a.titulo, a.cuenta,
						a.nombre, a.debito, a.credito, a.saldo,
						a.cargable
						order by a.orden";

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



		function llenartitulosmaestro()
		{

				$this->anchos[0]=120;
				$this->anchos[1]=30;
				$this->anchos[2]=35;
				$this->anchos[4]=30;
				$this->anchos[3]=120;

		}

		function Header()
		{
			//$this->cab->poner_cabecera($this,$_POST["titulo"],"l","s");

			$this->Image("../../img/logo_1.jpg",10,8,33);
			$this->setFont("Arial","",9);
			$fecha=date("d/m/Y");
			$this->SetX(178);
			$this->Cell(30,15,'Fecha: '.$fecha);
			$this->ln(5);
			$this->SetX(178);
			$this->Cell(30,15,'Pagina: '.$this->PageNo().' de {nb}');
			$this->setFont("Arial","B",10);
			$this->SetTextColor(0,0,128);
			$this->SetXY(10,40);
			$this->Cell(170,5,'Sistema de Contabilidad Financiera');
			$this->ln(5);
			$this->setFont("Arial","B",12);
			$this->Cell(170,5,'ESTADO DE RESULTADOS');

			$f=$this->bd->select("select b.fecdes as fecperdes, b.fechas as fecperhas from contaba a, contaba1 b
  								where a.fecini = b.fecini and a.feccie = b.feccie and b.pereje = '".$this->periodo."'");

			$this->SetTextColor(0,0,0);
			$this->setFont("Arial","B",10);
			$this->SetXY(10,48);
			$this->Cell(270,10,'Del '.$f->fields["fecperdes"].' Al '.$f->fields["fecperhas"].'  (Periodo  '.$this->periodo.')');
			$this->Line(10,55,205,55);
			$this->ln();

		}

		function Cuerpo()
		{
			$n= $this->bd->select("select numrup as nrorup from contaba");
			$nrorup = $n->fields["nrorup"];
			$tb=$this->bd->select($this->sql);
			$this->SetFont("Arial","",8);
			$this->SetY(57);
			while(!$tb->EOF)
			{
				$y=$this->GetY();
				if ($y>=255) {
					$this->AddPage();
					$y=57;
				}
				$this->SetY($y);

				if (ltrim(rtrim($tb->fields["titulo"])) == 'TOTAL') {
			      $titulo= $tb->fields["titulo"].' '.$tb->fields["nombre"];
				}
			   else {
			   	$titulo= $tb->fields["nombre"];
			   }

				// Primera linea //
				$niv= count(explode('-',$tb->fields["cuenta"]));
				$m= $this->bd->select("select cargab as movimiento from contabb
						where rtrim(codcta)=rtrim('".$tb->fields["cuenta"]."')");

				if (((trim($tb->fields["titulo"]))=='TOTAL') && ($niv == ($nrorup-1)) && (($nrorup - 1) > 0) && ($m->fields["movimiento"] <> 'C')) {
				     $si= 1;
				     $this->Line(85,$y,115,$y); }
				  else {
				     $si= 0;
				  }

				// Segunda linea //
				 if (((trim($tb->fields["titulo"]))=='TOTAL') and
				  	($niv == ($nrorup-3)) && (($nrorup - 3) > 0) and
				  	($m->fields["movimiento"] <> 'C')) {
				     $si= 1;
				     $this->Line(145,$y,175,$y); }
				  else {
				     $si= 0;
				  }

				// Tercera linea //
				 if (((trim($tb->fields["titulo"]))=='TOTAL') && ($niv == ($nrorup-2)) && (($nrorup - 2) > 0) && ($m->fields["movimiento"] <> 'C')) {
				     $si= 1;
				     $this->Line(115,$y,145,$y);}
				  else {
				     $si= 0;}

				// Cuarta linea //
				 if (((trim($tb->fields["titulo"]))=='TOTAL') and
				 (($niv == ($nrorup-4)) or (($nrorup - 4) > 0)) and
				 (($niv == ($nrorup-5)) or (($nrorup - 5) > 0)) and
				 (($niv == ($nrorup-6)) or (($nrorup - 6) > 0)) and
				 ($m->fields["movimiento"] <> 'C')) {
				     $si= 1;
				     $this->Line(175,$y,205,$y);}
				  else {
				     $si= 0;}

				// primer saldo //
				  if (($niv == $nrorup) && ($tb->fields["cargable"] == 'C')) {
				     $si= 1;
				     $this->SetXY(85,$y);
				     $this->Cell(30,3,number_format($tb->fields["saldo"],2,'.',','),0,'R',0); }
				  else {
				     $si= 0;}

				// Segunda linea //
				 if (($niv == ($nrorup-1)) and (($nrorup - 1) > 0) and ($tb->fields["cargable"] == 'C')) {
				     $si= 1;
				     $this->SetXY(115,$y);
				     $this->Cell(30,3,number_format($tb->fields["saldo"],2,'.',','),0,'R',0); }
				  else {
				     $si= 0;
				  }

				// Tercer saldo //
				 if (($niv == ($nrorup-2)) and (($nrorup - 2) > 0) and ($tb->fields["cargable"] == 'C')) {
				     $si= 1;
				     $this->SetXY(145,$y);
				     $this->Cell(30,3,number_format($tb->fields["saldo"],2,'.',','),0,'R',0);}
				  else {
				     $si= 0;}

				// Cuarta linea //
				 if ((($niv == ($nrorup-3) and ($nrorup - 3) > 0) or
				      ($niv == ($nrorup-4) and ($nrorup - 4) > 0) or
				      ($niv == ($nrorup-5) and ($nrorup - 5) > 0) or
				      ($niv == ($nrorup-6) and ($nrorup - 6) > 0))  and ($tb->fields["cargable"] == 'C')) {
				     $si= 1;
				     $this->SetXY(175,$y);
				     $this->Cell(30,3,number_format($tb->fields["saldo"],2,'.',','),0,'R',0);}
				  else {
					$si= 0;}

				$this->SetXY(10,$y);
				$this->MultiCell(70,3,$titulo);
				$this->ln(2);
				$tb->MoveNext();
			}

			$i=$this->bd->select("SELECT A.SALACT as ingreso
				    FROM CONTABB1 A,
				         CONTABA B
				   WHERE A.CODCTA = B.CODIND AND
				         A.PEREJE = '".$this->periodo."' AND
				         A.FECINI = B.FECINI AND
				         A.FECCIE = B.FECCIE");
			$e=$this->bd->select("SELECT A.SALACT as egreso
				    FROM CONTABB1 A,
				         CONTABA B
				   WHERE A.CODCTA=B.CODEGD AND
				         A.PEREJE = '".$this->periodo."' AND
				         A.FECINI = B.FECINI AND
				         A.FECCIE = B.FECCIE");

			$resultado= abs($i->fields["ingreso"]) - abs($e->fields["egreso"]) * -1;

			$this->Ln();
			$this->SetFont("Arial","B",12);
			$this->Cell(30,3,'TOTAL RESULTADO DEL EJERCICIO');
			$this->SetX(175);
			$this->Cell(30,3,number_format($resultado,2,'.',','),0,'R',0);

		}


	}
?>