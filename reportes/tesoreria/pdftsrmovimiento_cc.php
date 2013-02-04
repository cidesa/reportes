<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/general/funciones.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/tesoreria/Tsrmovimiento_cc.class.php");

	class pdfreporte extends fpdf
	{
		var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $anchos2;
		var $campos;
		var $sql;
		var $sql1;
		var $sql1b;
		var $sql1c;
		var $sql2;
		var $sql3;
		var $sqlb;
		var $che1;
		var $che2;
		var $hecho;
		var $revi;
		var $conta;
		var $audi;
		var $mes;
		var $ano;
		var $apro;
		var $ela;
		var $cod1;
		var $cod2;
		var $deb;
		var $cre;
		var $status;
		var $auxd=0;
		var $car;
		var $acumsalant=0;
		var $acumdeb=0;
		var $acumlib=0;
		var $acumban=0;
		var $acumlib2=0;
		var $acumban2=0;
		var $sal=0;
		var $fecha;

		function pdfreporte()
		{
			$this->fpdf("l","mm","Letter");
			//$this->bd=new basedatosAdo();
			$this->bd=new Tsrmovimiento_cc();
			$this->cab=new cabecera();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->numchedes=str_replace('*',' ',H::GetPost("numchedes"));
			$this->numchehas=str_replace('*',' ',H::GetPost("numchehas"));
			$this->numcuedes=str_replace('*',' ',H::GetPost("numcuedes"));
			$this->numcuehas=str_replace('*',' ',H::GetPost("numcuehas"));
			$this->bendes=str_replace('*',' ',H::GetPost("bendes"));
			$this->benhas=str_replace('*',' ',H::GetPost("benhas"));
			$this->fechades=str_replace('*',' ',H::GetPost("fechades"));
			$this->fechahas=str_replace('*',' ',H::GetPost("fechahas"));
			$this->arrp=$this->bd->sqlp($this->numchedes,$this->numchehas,$this->bendes,$this->benhas,$this->fechades,$this->fechahas,$this->numcuedes,$this->numcuehas);
            $this->i=0;
		}



		function Header()
		{
				$this->cab->poner_cabecera_f($this,$_POST["titulo"].' DESDE '.$this->fechades.' HASTA '.$this->fechahas,"l","s","n");


		}

		function Footer()
		{
			$this->sety(-5);
				$this->cell(0,4,"Nota: los montos estan agrupados por partida");


		}

		function Cuerpo()
		{
			$contador=1;
			$this->setFont("Arial","B",9);
			$this->setWidths(array(0,13,25,26,23,20,65,25,25,25));
			$this->setAligns(array("L","C","R","R","R","C","L","R","R","R"));
			$ref="";
			$cue="";
			$ref2=$this->arrp[$this->i]["numcue"];
			$prim=true;
			$this->monret=0;
			foreach($this->arrp as $op)
			{
                $this->i++;
              	if($cue!=$op["numcue"])  {
              			if (!$prim)
              		   {
              			$this->ln();
						$this->setFont("Arial","B",10);
						$this->Row(array('',"","TOTAL: ",H::FormatoMonto($this->monret)));
						$this->ln();
						$this->setx(32);
						$this->Cell(0,5,'CUENTA:    '.$cue,0,0,'L');
					//	$this->Cell(0,5,'TOTAL CUENTA:    '.$cue.'           '.H::FormatoMonto($this->monret),0,0,'C');
						$this->monret=0;
						$this->ln(25);
						$this->AddPage();
              			}
                    $cue=$op["numcue"];
              		$this->setFont("Arial","B",9);
                //	$this->Cell(20,4,'MOVIMIENTO DEL '.$this->fechades.' AL '.$this->fechahas); //$this->y=$this->GetY();
		         //	$this->ln();
					$this->Cell(200,4,'CUENTA Nro.:  '.$this->arrp[$this->i]["numcue"]);
					$this->ln();
				    $this->Cell(20,4,'DESCRIPCION : '.$this->arrp[$this->i]["nomcue"] );
					$this->ln();
					$this->line(10,$this->GetY(),270,$this->GetY());
					$this->ln();
					$this->setFont("Arial","B",9);
					$this->Cell(20,5,'Número',0,0,'C');
					$this->Cell(28,5,'Imputacion');
					$this->Cell(22,5,'Monto');
					$this->Cell(20,5,'Fecha');
					$this->Cell(30,5,'Cheque');
					$this->Cell(60,5,'Descripcion');
					$this->Cell(30,5,'Asignación');
					$this->Cell(30,5,'Monto Total',0,0,'l');
					$this->Cell(25,5,'Saldo');
						$this->ln();
				//	$this->line(10,$this->GetY()+2,270,$this->GetY()+2);
					$this->setFont("Arial","",9);

              		$prim=false;
                }
                $acum=0;
                $acummon=0;
				if($ref!=$op["numche"])
				{
					$this->arrpcod=$this->bd->sqlcodpre($op["numche"]);
					foreach($this->arrpcod as $cod)
			         {
			         	$this->arrpasig=$this->bd->sqlasi($cod["codpre"]);
			         	foreach($this->arrpasig as $asi)
			             {$acum+=$asi["asig"];}

			             $acummon+=$cod["monimp"];

			         }

					$this->setFont("Arial","B",8);
					$this->line(10,$this->GetY()+3,270,$this->GetY()+3);
					$this->SetXY(75,$this->GetY()+5);
					$this->Cell(23,3,date("d/m/Y",strtotime($op["feclib"])),0,0,'C');
					$this->SetX(95);
					$this->Cell(25,3,$op["numche"],0,0,'C');
					$this->SetX(182);
					$this->Cell(25,3,H::FormatoMonto($acum),0,0,'R');
					$this->SetX(210);
					$this->Cell(25,3,H::FormatoMonto($acummon),0,0,'R');
					$this->SetX(235);
					$this->Cell(25,3,H::FormatoMonto($acum-acummon),0,0,'R');
					$this->SetX(116);
					$this->multiCell(65,3,trim($op["nomben"]),0,'J',0);
					$this->ln();
					$this->SetY($this->GetY()-3);
				}

			  	$this->setFont("Arial","",8);
				$this->Row(array('',(string)$contador,$op["partida"],H::FormatoMonto($op["monimp"])));
				$this->monret=$this->monret+$op["monimp"];
				$y=$this->GetY();
				$contador++;
				if($y>=180)
				{
					$this->AddPage();
					$this->setFont("Arial","B",9);
					$this->Cell(20,5,'Número',0,0,'C');
					$this->Cell(28,5,'Imputacion');
					$this->Cell(22,5,'Monto');
					$this->Cell(20,5,'Fecha');
					$this->Cell(30,5,'Cheque');
					$this->Cell(60,5,'Descripcion');
					$this->Cell(30,5,'Asignación');
					$this->Cell(30,5,'Monto Total',0,0,'l');
					$this->Cell(25,5,'Saldo');
					$this->ln();
					$this->line(10,$this->GetY(),270,$this->GetY());
					$this->ln();
				}
				$ref=$op["numche"];
			}
            $this->ln();
			$this->setFont("Arial","B",10);
	        $this->Row(array('',"","TOTAL: ",H::FormatoMonto($this->monret)));
			$this->ln();
			$this->setx(32);
			$this->Cell(0,5,'CUENTA:    '.$cue,0,0,'L');

		}
	}
?>
