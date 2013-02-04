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
		var $sql1;
		var $sql2;
		var $sql3;
		var $sqla;
		var $sqlb;
		var $sqlc;
		var $sqlx;
		var $rep;
		var $numero;
		var $cab;
		var $con1;
		var $con2;
		var $emp1;
		var $emp2;
		var $nom;
		var $niv2;
		var $fecha1;
		var $fecha2;
		var $fechae1;
		var $fechae2;
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
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();


			$this->emp1=$_POST["emp1"];
			$this->emp2=$_POST["emp2"];
                     $this->codniv1=$_POST["codnivdes"];
                     $this->codniv2=$_POST["codnivhas"];
			$this->fec1=$_POST["fec1"];
			$this->fec2=$_POST["fec2"];
			$this->nom=$_POST["nom"];
			$this->cod1=$_POST["cod1"];
			$this->cod2=$_POST["cod2"];



			$this->sql="select a.codemp, a.codcar, a.codnom, a.paso, a.grado, a.codcat, to_char(b.fecing,'dd/mm/yyyy') 
                                   as fecasi, a.nomemp, a.nomcar, a.nomnom, a.nomcat, a.unieje,
					a.sueldo,b.codniv,c.desniv,
					(CASE WHEN a.status='v' THEN 'VIGENTE' ELSE 'NO VIGENTE' END)
					from npasicaremp a, nphojint b LEFT OUTER JOIN npestorg c ON (b.codniv=c.codniv)  
					where
					a.codemp=b.codemp and 
					b.codniv=c.codniv and
					a.status='V' and
                                   b.staemp='A' and
                                 
					rtrim(a.codemp) >= rtrim('".$this->emp1."') and 
					rtrim(a.codemp) <= rtrim('".$this->emp2."') and

                                   rtrim(a.codcar) >= rtrim('".$this->cod1."') and 
					rtrim(a.codcar) <= rtrim('".$this->cod2."') and

                                   rtrim(c.codniv) >= rtrim('".$this->codniv1."') and 
					rtrim(c.codniv) <= rtrim('".$this->codniv2."') and
					a.codnom='".$this->nom."'  
                                 	order by b.codniv,a.codcar,a.codemp";





        //  print '<pre>'; print $this->sql;
			$this->llenartitulosmaestro();
			$this->llenartitulosmaestro2();
			$this->cab=new cabecera();

		}
		function llenartitulosmaestro()
		{
				$this->titulos[0]="Cdigo";
				$this->titulos[1]="Nombre Empleado";
				$this->titulos[2]="Fecha";
				$this->titulos[3]="Nmina";
				$this->titulos[4]="Cargo";
				$this->titulos[5]="Nivel Organizacional";
		}

		function llenartitulosmaestro2()
		{
				$this->titulos2[0]="Empleado";
				$this->titulos2[1]="";
				$this->titulos2[2]="Ingreso";
				$this->titulos2[3]="";
				$this->titulos2[4]="";
				$this->titulos2[5]="";
		}
		function Header()
		{
			$this->SetTextColor(0,0,0);
			$this->cab->poner_cabecera($this,$_POST["titulo"],"p","s");
			$this->setFont("Arial","B",9);
			$ncampos=count($this->titulos);
			$ncampos2=count($this->titulos2);
			$this->setFont("Arial","B",9);
				$this->SetTextColor(0,0,128);
				$this->cell(20,5,"Al  ".date('d/m/Y'));
				$this->SetTextColor(0,0,0);
				$this->ln();
				$this->ln();
				$this->Line(10,$this->GetY(),200,$this->GetY());
				$this->Line(10,$this->GetY()+5,200,$this->GetY()+5);
			/*for($i=0;$i<$ncampos;$i++)
			{
				$this->cell($this->anchos[$i],5,$this->titulos[$i]);
			}
			$this->ln();
			for($i=0;$i<$ncampos2;$i++)
			{
				$this->cell($this->anchos2[$i],5,$this->titulos2[$i]);
			}
			$this->ln();
			$this->Line(10,50,270,50);*/


		}
		function Cuerpo()
		{

		    $tb=$this->bd->select($this->sql);
		    $this->codniv='';

				while (!$tb->EOF)
				{
				if ($this->GetY()>230)
				{
					$this->ln(100);
				}
				if ( $this->codniv!=$tb->fields["codniv"]){
						$this->setFont("Arial","B",8);
					$this->Line(10,$this->GetY(),200,$this->GetY());
					$this->ln();
					$this->cell(29,5,"Nivel Organizacional: ".$tb->fields["desniv"]);
						$this->setFont("Arial","",8);
					$this->ln();
				}
				$this->codniv=$tb->fields["codniv"];
				$this->Line(10,$this->GetY(),200,$this->GetY());
				$this->Line(10,$this->GetY()+5,200,$this->GetY()+5);
				$this->setFont("Arial","B",8);
				$this->cell(29,5,"Código Empleado: ");
				$this->setFont("Arial","",8);
				$this->cell(35,5,$tb->fields["codemp"]);
				$this->setFont("Arial","B",8);
				$this->cell(15,5,"Nombre: ");
				$this->setFont("Arial","",8);
				$this->cell(20,5,$tb->fields["nomemp"]);
				$this->ln(6);
				//---
				$this->setFont("Arial","B",8);
				$this->cell(25,5,"Código Nómina: ");
				$this->setFont("Arial","",8);
				$this->cell(15,5,$tb->fields["codnom"]);
				$this->setFont("Arial","B",8);
				$this->cell(10,5,"Cargo: ");
				$this->setFont("Arial","",8);
				$this->cell(13,5,$tb->fields["codcar"]);
				$y=$this->getY();
				$x=$this->getX();
				$this->multicell(80,3,$tb->fields["nomcar"]);
				$this->setFont("Arial","B",8);
				$this->setY($y);
				$this->setX($x+90);
				$this->cell(22,5,"Fecha Ingreso: ");
				$this->setFont("Arial","",8);
				$this->cell(20,5,$tb->fields["fecasi"]);
				$this->ln();
				//---
				$this->setFont("Arial","B",8);
				$this->cell(35,5,"Categoria Presupuestaria: ");
				$this->setFont("Arial","",8);
				$this->cell(29,5,$tb->fields["codcat"]);
				$this->cell(40,5,$tb->fields["nomcat"]);
				$this->ln();
				//---
				$this->setFont("Arial","B",8);
				$this->cell(35,5,"Ubicación Administrativa: ");
				$this->setFont("Arial","",8);
				$this->cell(29,5,$tb->fields["codniv"]);
				$this->cell(40,5,$tb->fields["desniv"]);
				$this->ln();
				//--- sql tabla grados y pasos

                        	$this->sql99="select a.pascar, a.gracar, a.suecar, b.codemp, b.paso, b.grado
						from npcomocp a, npasicaremp b
						where b.codemp='".$tb->fields["codemp"]."' and
                                          b.paso=a.pascar and
                                          b.grado=a.gracar and
                                          a.fecdes='12-31-2010' ";
				$tb99=$this->bd->select($this->sql99);
                            


                            //-----------
				$this->setFont("Arial","B",8);
				$this->cell(35,5,"Sueldo: ".H::FormatoMonto( $tb99->fields["suecar"]));
				$this->setFont("Arial","",8);
				//------------------
				$this->sql2="select codpai as pais,codest as estado,codciu as ciudad
						from nphojint
						where codemp=rpad('".$tb->fields["codemp"]."',16,' ')";
				$tb2=$this->bd->select($this->sql2);
				$pais=$tb2->fields["pais"];
				$estado=$tb2->fields["estado"];
				$ciudad=$tb2->fields["ciudad"];
				

				$this->sql3="select nomciu as ubicacion
					     from npciudad where rtrim(codpai)=rtrim('".$pais."') and
     				     rtrim(codciu)=rtrim($ciudad) and
     				     rtrim(codedo)=rtrim($estado)";
				$tb3=$this->bd->select($this->sql3);
				//$this->cell(26,5,$tb3->fields["ubicacion"]);
				//------------------

				$this->ln();
				$this->ln();
				$tb->MoveNext();
				}
                                   $this->sqlt="select count ( a.codcar) as cant,sum (a.sueldo) as sueldo
					from npasicaremp a, nphojint b LEFT OUTER JOIN npestorg c ON (b.codniv=c.codniv)
					where
					a.codemp=b.codemp and 
					b.codniv=c.codniv and 
					a.status='V' and
                                   b.staemp='A' and 
					rtrim(a.codemp) >= rtrim('".$this->emp1."') and 	
					rtrim(a.codemp) <= rtrim('".$this->emp2."') and
  					rtrim(a.codcar) >= rtrim('".$this->cod1."') and 
					rtrim(a.codcar) <= rtrim('".$this->cod2."') and

                                   rtrim(c.codniv) >= rtrim('".$this->codniv1."') and 
					rtrim(c.codniv) <= rtrim('".$this->codniv2."') and
				       a.codnom='".$this->nom."'"; 

			$tbt=$this->bd->select($this->sqlt);
               $this->setFont("Arial","B",8);

	        $this->cell(40,5,"TOTAL DE CARGOS ASIGNADOS: ".($tbt->fields["cant"]));
	        $this->ln();
	        //$this->cell(40,5,"TOTAL DE SUELDOS ASIGNADOS: ".H::FormatoMonto($tbt->fields["sueldo"]));

		}
	}
?>
