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
		var $rep;
		var $numero;
		var $cab;
		var $codesde;
		var $codhasta;
		var $estado;
		var $conf;
              

		function pdfreporte()
		{
			$this->conf="l";
                     $this->fpdf($this->conf,"mm","Letter");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->codesde=$_POST["coddesde"];
			$this->codhasta=$_POST["codhasta"];
                     $this->edadesde=$_POST["edadesde"];
                     $this->edahasta=$_POST["edahasta"];
                     $this->sexemp=$_POST["sexemp"];

                     $this->codnomi=$_POST["nom"];
			$this->estado=$_POST["estado"];

			$this->sql="SELECT
						distinct	A.CODEMP as codemp,
							A.NOMEMP as nomemp,
							A.CEDEMP as cedemp,
							A.NUMCON as numcon, 
                                                 B.nomcar as nomcar,
							(CASE WHEN A.EDOCIV='S' THEN 'Soltero' WHEN A.EDOCIV='C' THEN 'Casado' WHEN A.EDOCIV='D' THEN 'Divorciado' WHEN A.EDOCIV='V' THEN 'Viudo' ELSE '' END) as edociv,
							(CASE WHEN A.NACEMP='V' THEN 'Venezolano' ELSE 'Extranjero' END) as nacemp,
							(CASE WHEN A.SEXEMP='F' THEN 'Femenino' ELSE 'Masculino' END) as sexemp,
							to_char(A.FECNAC,'dd/mm/yyyy') as fecnac,
							Extract(year from age(now(),A.FECNAC)) as edaemp,
                                                 A.edaemp as edaemp,
							A.LUGNAC as lugnac,
							substr(A.DIRHAB,1,45) as dirhab,
							A.CODCIU as codciu,
							--C.nompai AS codpai,
								A.CODPAI AS codpai,
							A.TELHAB as telhab,
							A.CELEMP as celemp,
							A.EMAEMP as emaemp,
							A.CODPOS as codpos,
							A.TALPAN as talpan,
							A.TALCAM as talcam,
							A.TALCAL as talcal,
							(CASE WHEN A.DERZUR='D' THEN 'Derecho' ELSE 'Izquierdo' END) as derzur,
							to_char(A.FECING,'dd/mm/yyyy') as fecing,
							A.FECRET as fecret,
							A.FECREI as fecrei,
							to_char(A.FECADMPUB,'dd/mm/yyyy') as fecadmpub,
							A.STAEMP as staemp,
							A.FOTEMP as fotemp,
							A.NUMSSO as numsso,
							A.NUMPOLSEG as numpolseg,
							to_char(A.FECCOTSSO,'dd/mm/yyyy') as feccotsso,
							A.ANOADMPUB as anoadmpub,
							A.CODTIPPAG as codtippag,
							A.CODBAN as codban,
							A.TIPCUE as tipcue,
							A.NUMCUE as numcue,
							A.OBSEMP as obsemp,
							(CASE WHEN A.TIEFID='S' THEN 'Si' ELSE 'No' END) as tipo,
							c.desniv as ubica                                                 
                                              
                      
                                                  
						FROM NPHOJINT A, NPASICAREMP B, npestorg c
						WHERE
							RTRIM(A.CODEMP) >= RTRIM('".$this->codesde."') AND
							RTRIM(A.CODEMP) <= RTRIM('".$this->codhasta."') AND 
     							RTRIM(A.edaemp) >= RTRIM('".$this->edadesde."') AND
							RTRIM(A.edaemp) <= RTRIM('".$this->edahasta."') AND
                                                 a.sexemp=RTRIM('".$this->sexemp."') and

                                                 a.staemp='A' and
                                                 A.codemp=B.codemp and 
                                                 c.codniv=a.codniv and 
                                                 b.codnom=RTRIM('".$this->codnomi."') and
                                                 b.status='V'
                                                 --and A.CODPAI=C.CODPAI
						ORDER BY A.CODEMP";






						//print '<pre>';print $this->sql;
       


           
		}

		function Header()
		{
			$dir = parse_url($_SERVER["HTTP_REFERER"]);
			$parte = explode("/",$dir["path"]);
			$ubica = count($parte)-2;
			$this->cab->poner_cabecera($this,$_POST["titulo"],$this->conf,"s",$parte[$ubica]);
			$this->setFont("Arial","B",9);
		}
		function Cuerpo()
		{
                $salto=0;
			$this->setFont("Arial","B",8);
		    $tb=$this->bd->select($this->sql);
			//Marco de la P�gina

			while(!$tb->EOF)
			{
			    //$this->Rect(10,35,260,4);
				 
				 //$this->SetY(25);
				 $this->setFont("Arial","B",8);
				 //$this->Cell(270,10,"ANTIGUEDAD",0,0,'C',0);
 				 $this->ln(0);
 				 $this->setFont("Arial","B",8);
				 $this->cell(15,10,'Cedula');
				 $this->cell(65,10,'Nombres Y Apellidos');
				 $this->cell(15,10,'Sexo');
                             $this->cell(15,10,'Edad');
				 $this->cell(80,10,'Ubicacion/Cargo');
				 $this->cell(25,10,'Antiguedad A.P.');
				 $this->cell(28,10,'Antiguedad dentro');
				 $this->cell(25,10,'Sueldo');
                      
				 $this->ln(3);
				 $this->setFont("Arial","",8);
				 $this->cell(15,10,$tb->fields["codemp"]);
				 
				 $this->cell(65,10,$tb->fields["nomemp"]);
				
				 $this->cell(15,10,$tb->fields["sexemp"]);
                             $this->cell(15,10,$tb->fields["edaemp"]);

				 $this->cell(80,10,$tb->fields["ubica"]);
				 
                             //$this->cell(30,10,$tb999->fields["suecar"]);
				 //$this->cell(35,10,$tb->fields["nacemp"]);
				 //$this->cell(25,10,$tb->fields["sexemp"]);
				 
				 //$this->setFont("Arial","B",8);
											 
				 
				 //años en la contraloria o en la empresa
				 $this->sql2="select antpub_e('A',codemp,date(now()),'S') as ano,
							antpub_e('M',codemp,date(now()),'S') as mes,
							antpub_e('D',codemp,date(now()),'S') as dias
							from nphojint
							where codemp=RTRIM('".$tb->fields["codemp"]."') ";//H::PrintR($this->sql2);exit;
							 $tb2=$this->bd->select($this->sql2);

							 //print '<pre>'; print  $this->sql2;
				
                              //años en la administracion publica
							$this->sql222="select antpub('A',codemp,date(now()),'S') as ano,
							antpub('M',codemp,date(now()),'S') as mes,
							antpub('D',codemp,date(now()),'S') as dias
							from nphojint
							where codemp=RTRIM('".$tb->fields["codemp"]."') ";//H::PrintR($this->sql2);exit;
						       $tb222=$this->bd->select($this->sql222);
////////////////////////// sueldo 

                            $this->sql999="select c.suecar
             		from
                     	  nphojint a, npasicaremp b, npcomocp c
                     where
				a.codemp=RTRIM('".$tb->fields["codemp"]."') and
                     	a.codemp=b.codemp and
                       	a.staemp='A' and
                       	b.status='V' and
                       	c.fecdes='12/31/2010' and
                       	b.codnom=RTRIM('".$this->codnomi."') and
                            
                       	b.codnom=c.codtipcar and
                       	b.paso=c.pascar and
                       	b.grado=c.gracar
                       	";
                            $tb999=$this->bd->select($this->sql999);


                	


 	$this->cell(25,10,'A:'.$tb222->fields["ano"].'/M:'.$tb222->fields["mes"].'/D:'.$tb222->fields["dias"]);
				
 	$this->cell(30,10,'A:'.$tb2->fields["ano"].'/M:'.$tb2->fields["mes"].'/D:'.$tb2->fields["dias"]);

	$this->cell(10,10,number_format($tb999->fields["suecar"],2,'.',','),0,0,'R');

       
	
        // $this->cell(30,10,"");
				 
				 $this->setFont("Arial","B",8);
				 
				 $this->cell(38,10,'');
				 //$this->cell(35,10,'Ubicación Administrativa:');
				 $this->ln(3);
                             $this->cell(80);
				$this->setFont("Arial","",8);
				 
                             $y=$this->gety();
				 $this->setxy(125,$y+3);
				 $this->multicell(60,3,$tb->fields["nomcar"]);
				 $this->cell(35,10,'');
				 $this->cell(30,10,"");
				 $this->setxy(185,$y+3);
			
				 $this->ln(2);
				 $this->setFont("Arial","B",8);
                    	        $salto=$salto+1;
				
			
				 //$this->setFont("Arial","",8);
				 //$this->cell(35,10,$tb999->fields["suecar"]);


				 //$this->cell(45,10,$tb->fields["numpolseg"]);
				 //$this->cell(30,10,'');
			//	 $this->cell(60,10,$tb->fields["codtippag"]);
				// $this->cell(30,10,$tb->fields["codban"]);
				$this->cell(60,10,'');
				$this->cell(30,10,'');
				 //$this->cell(35,10,$tb->fields["numcue"]);
				 //$this->cell(25,10,$tb->fields["tipcue"]);
				 //$this->ln(1);
				 //$this->line(10,$this->getY(),270,$this->getY());

				

							  
				 				 

				 $tb->MoveNext();
				 if ($salto==11)
                                     {$this->AddPage();
                                     $salto=0;}
			   
			}
		}
	}
?>