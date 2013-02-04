<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $titulos2;
		var $titulos3;
		var $anchos;
		var $anchos2;
		var $anchos3;
		var $campos;
		var $sql1;
		var $sql2;
		var $rep;
		var $numero;
		var $cab;
		var $per1;
		var $per2;
		var $codmundes;
		var $codmunhas;
		var $estado;
		var $auxd=0;
		var $car;
		var $salant=0;
		var $salact=0;

		function pdfreporte()
		{
			$this->fpdf("p","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->titulos3=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->anchos3=array();
			$this->codmundes=$_POST["codmundes"];
			$this->codmunhas=$_POST["codmunhas"];
			$this->codpaides=$_POST["codpaides"];
			$this->codpaihas=$_POST["codpaihas"];


			$this->sql="select a.codpai, rtrim(a.nompai) as nompai, b.codedo, b.nomedo, c.codciu, c.nomciu
			from nppais a, npestado b, npciudad c
			where
			(B.codedo) >= ('".$this->codmundes."') and (B.codedo) <= ('".$this->codmunhas."') and
			(B.codpai) >= ('".$this->codpaides."') and (B.codpai) <= ('".$this->codpaihas."') and
			(a.codpai) = (b.codpai) and
			(a.codpai) = (c.codpai) and
			(b.codedo) = (c.codedo)
			order by a.codpai,b.codedo,c.codciu";//H::PrintR($this->sql);exit;
	//	print '<pre>'; print $this->sql; exit;
			$this->llenartitulosmaestro();
			$this->llenartitulosmaestro2();
			$this->llenartitulosmaestro3();
			$this->cab=new cabecera();

		}
		function llenartitulosmaestro()
		{
				$this->titulos[0]=" ";
				$this->titulos[1]="Codigo Estado";
				$this->titulos[2]="Descripcion Estado";
		}
		function llenartitulosmaestro2()
		{
				$this->titulos2[0]=" ";
				$this->titulos2[1]="Codigo Municipio";
				$this->titulos2[2]="Descripcion Municipio";
		}
		function llenartitulosmaestro3()
		{
				$this->titulos3[0]=" ";
				$this->titulos3[1]="Codigo Parroquia";
				$this->titulos3[2]="Descripcion Parroquia";
		}

		function Header()
		{
			$this->cab->poner_cabecera($this,$_POST["titulo"],"p","s");
			$this->setFont("Arial","B",9);

			$this->SetX(10);




		}
		function Cuerpo()
		{

		    $tb=$this->bd->select($this->sql);
			$tb2=$this->bd->select($this->sql);
			$this->setFont("Arial","",8);
			$ncampos=count($this->titulos);
			$refciudad='';
	        $ncampos=count($this->titulos);
			$ncampos2=count($this->titulos2);
			$ncampos3=count($this->titulos3);
			if (!$tb2->EOF)
			{
				$this->setFont("Arial","B",9);
				  $this->settextcolor(0,0,215);
				for($i=0;$i<$ncampos;$i++)
			{
				$this->cell($this->anchos[$i],6,$this->titulos[$i]);
			}
			  $this->settextcolor(0,0,0);
			    $this->ln();
			    $this->SetLineWidth(0.4);
				$this->Line(30,$this->GetY(),120,$this->GetY());
				$this->setFont("Arial","",8);
				$ref=$tb2->fields["codpai"];
				$this->cell($this->anchos[0],5," ");
				$this->cell($this->anchos[1],5,"".$tb2->fields["codpai"]);
				$this->cell($this->anchos[2],5,substr($tb->fields["nompai"],0,120));
				$this->ln();


			}
			while (!$tb->EOF)
			{
				if($tb->fields["codpai"]!=$ref)
				{
					$this->setFont("Arial","B",9);
					  $this->settextcolor(0,0,215);
					for($i=0;$i<$ncampos;$i++)
					{
						$this->cell($this->anchos[$i],6,$this->titulos[$i]);
					}
					  $this->settextcolor(0,0,0);
			    $this->ln();
			    $this->SetLineWidth(0.4);
			    $this->Line(30,$this->GetY(),120,$this->GetY());
				$this->setFont("Arial","",8);
				$this->cell($this->anchos[0],5," ");
				$this->cell($this->anchos[1],5,"".$tb->fields["codpai"]);
				$this->cell($this->anchos[2],5,substr($tb->fields["nompai"],0,120));
				$this->ln();
				}
				//Detalle
				$this->setFont("Arial","",8);
				$ref=$tb->fields["codpai"];
				if($refciudad!=$tb->fields["codedo"]){

								if ($this->gety()>220){
					$this->addpage();

				}


					$this->setFont("Arial","B",9);
					  $this->settextcolor(225,0,0);
					for($i=0;$i<$ncampos2;$i++)
					{
						$this->cell($this->anchos2[$i],6,$this->titulos2[$i]);
					}
					  $this->settextcolor(0,0,0);
			    $this->ln();
			    $this->setFont("Arial","",8);
			    $this->Line(30,$this->GetY(),120,$this->GetY());
				$this->cell($this->anchos2[0],5," ");
				$this->cell($this->anchos2[1],5,"".$tb->fields["codedo"]);
 				$this->cell($this->anchos2[2],5,substr($tb->fields["nomedo"],0,120));
				$this->ln();

				$this->setFont("Arial","B",9);
			    $this->settextcolor(0,115,0);
					for($i=0;$i<$ncampos3;$i++)
					{
						$this->cell($this->anchos3[$i],6,$this->titulos3[$i]);
					}
					  $this->settextcolor(0,0,0);
				$this->ln();
				$this->Line(30,$this->GetY(),120,$this->GetY());
				}
				$this->setFont("Arial","",8);
				$refciudad=$tb->fields["codedo"];
				$this->cell($this->anchos3[0],5," ");
				$this->cell($this->anchos3[1],5,"".$tb->fields["codciu"]);
				$this->cell($this->anchos3[2],5,substr($tb->fields["nomciu"],0,120));
				if ($this->gety()>230){
					$this->addpage();
					  $this->settextcolor(0,115,0);
					$this->setFont("Arial","B",9);
					for($i=0;$i<$ncampos3;$i++)
					{
						$this->cell($this->anchos3[$i],6,$this->titulos3[$i]);
					}
					  $this->settextcolor(0,0,0);
			    $this->ln();
			    $this->setFont("Arial","",8);
			       $this->Line(30,$this->GetY(),120,$this->GetY());
				}
				$this->ln();
				$tb->MoveNext();
			}
		}
	}
?>
