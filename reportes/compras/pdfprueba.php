<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");

	class pdfreporte extends fpdf
	{

		var $bd;

		function pdfreporte()
		{
			$this->conf="l";
			$this->fpdf($this->conf,"mm","Letter");
            $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->rifdesde=H::GetPost("rifdesde");
			$this->rifhasta=H::GetPost("rifhasta");

			$this->sql="SELECT
							rtrim(A.CODPRO) as codpro,
							rtrim(A.NOMPRO) as nompro,
							rtrim(A.RIFPRO) as rif,
							rtrim(A.DIRPRO) as dir,
							rtrim(A.TELPRO) as telf
						FROM CAPROVEE A
						WHERE
							(A.RIFPRO) >= ('".$this->rifdesde."') AND
							(A.RIFPRO) <= ('".$this->rifhasta."')

						ORDER BY A.CODPRO ";
					//print '<pre>'; print $this->sql;


		}


		function Header()
		{
			$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s");
			$this->setFont("Arial","B",9);
			$this->SetFillColor(150,150,150);
			$this->cell(50,5,"Cod. Proveedor",1,0,"C",1);
			$this->cell(50,5,"Nom. Proveedor");
			$this->cell(50,5,"R.I.F Provedor");
			$this->cell(50,5,"Direccion");
			$this->cell(50,5,"Telefono",0,1);

		}

		function Cuerpo()
		{
			$this->setFont("Arial","B",8);
		    $tb=$this->bd->select($this->sql);
			while(!$tb->EOF)
			{
			/*	$this->setFont("Arial","B",8);
				$this->cell(50,5,$tb->fields["codpro"]);
				$this->setFont("Arial","",8);
				$y=$this->gety();$x=$this->getx();
				$this->cell(50,5,'');
				$this->cell(50,5,$tb->fields["rif"]);
				$x2=$this->getx();
				$this->cell(50,5,'');

				$this->cell(50,5,$tb->fields["telf"]);
				$this->setxy($x,$y);
				$this->multicell(50,5,$tb->fields["nompro"]);
				$this->setxy($x2,$y);
				$this->multicell(50,5,$tb->fields["dir"]);

				$this->ln();*/

				  $this->SetWidths(array(50,50,50,50,50));
  $this->SetAligns(array("C","C","C","C","C"));
  $this->SetBorder(1);
  $this->Row(array($tb->fields["codpro"],$tb->fields["nompro"],$tb->fields["rif"],$tb->fields["dir"],$tb->fields["telf"]));
				if ($this->gety()>100){
					$this->ln();
				$this->sety(120);
			$this->cell(20,5,'Firma');
					$this->addpage();
				}
				$tb->MoveNext();


			}//fin del while

		}//fin del cuerpo

	}//fin pdf reporte
?>