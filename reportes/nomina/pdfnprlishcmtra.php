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
		var $sql;
		var $sql2;
		var $sql3;
		var $sqla;
		var $sqlax;
		var $sqlb;
		var $sqlc;
		var $sqlx;
		var $sqlt;
		var $rep;
		var $numero;
		var $cab;
		var $con1;
		var $con2;
		var $edad1;
		var $edad2;
		var $cat1;
		var $cat2;
		var $niv1;
		var $niv2;
		var $per1;
		var $per2;
		var $emp1;
		var $emp2;
		var $nom;
		var $nomesp;
		var $nombre;
		var $elab;
		var $rev;
		var $auto;
		var $tipcon;
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
			$this->fpdf("P","mm","Letter");
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->emp1=$_POST["emp1"];
			$this->emp2=$_POST["emp2"];
			$this->cat1=$_POST["cat1"];
			$this->cat2=$_POST["cat2"];
			$this->per1=$_POST["per1"];
			$this->per2=$_POST["per2"];
			$this->codnomi=$_POST["nom"];
			$this->nomesp=$_POST["nomesp"];
			
			
			$this->sql="SELECT DISTINCT
				C.CODEMP as codemp,
                            C.STAEMP,
                            C.SEXEMP,
                            C.EDAEMP,
                            E.CODCAR,
				E.CODNOM,
				E.NOMNOM,
				E.NOMEMP,
				C.CEDEMP,
				E.NOMCAR,
                            E.GRADO,
                            E.PASO,
				C.NUMCUE,
				F.CODNIV, 
				F.DESNIV,
               		B.NOMFAM,
				B.sexfam as sexo,
                            b.edafam,
                            b.seghcm,
                            B.parfam
				FROM
					NPINFFAM B,NPHOJINT C,NPASICAREMP E,NPESTORG F, NPTIPPAR G
			     	WHERE
					TRIM(C.CODEMP) >= TRIM('".$this->emp1."') AND
					TRIM(C.CODEMP) <= TRIM('".$this->emp2."') AND
					C.CODEMP=E.CODEMP AND
                            	C.STAEMP='A' AND
                            	TRIM(F.CODNIV) >= TRIM('".$this->cat1."') AND
					TRIM(F.CODNIV) <= TRIM('".$this->cat2."') AND
					E.STATUS='V' and
                            	
					C.CODNIV=F.CODNIV AND
				       C.CODEMP=B.CODEMP AND
				       E.CODNOM=RTRIM('".$this->codnomi."') 
			     	ORDER BY C.CODEMP";

			$this->cab=new cabecera();

		}

		function Header()
		{
			$this->SetTextColor(0,0,0);
			$this->cab->poner_cabecera($this,$_POST["titulo"],"p","s");
			$this->setFont("Arial","B",8);
       	}

		function Cuerpo()
		{
			$tbg=$this->bd->select($this->sql);
			$this->setFont("Arial","B",7);
			$refemp="";
			$conthijo=0;
			$cont=0;
			$this->sw=false;
			$fem=0;
			$mas=0;
			while(!$tbg->EOF)
			{
				if($refemp!=$tbg->fields["codemp"])
				{
					//TOTALES
					if($this->sw)
						{
							$this->ln(3);
							$this->cell(80);
							$conthijo=0;
                                                 $this->cell (75,4,' SUB-TOTAL BENEFICIARIOS:                      ');

                                                 $this->cell(21,4,number_format($montot1,2,'.',','),0,0,'L');
      							
 							$this->cell(20,4,number_format($montot2,2,'.',','),0,0,'L');

                                                 $this->ln(4);
							$this->cell(80);
                                                 $this->cell (60,6,' DOCEAVA APORTE PATRONAL TITULAR:                                   '.$montoap);
                                                 $this->ln(6);
							$this->cell(80);
                                                 $this->SetTextColor(128,0,0);
                                                 $this->Cell (60,6,' TOTAL RETENCION EMPLEADO:                    ');
                                                 $this->Cell (60,6,number_format($montot1,2,'.',','),0,0,'L');
                                                 $this->ln(7);
							$this->cell(80);
                                                 $totfin=$montoap+$montot2;
                                                 $this->cell (60,6,' TOTAL  APORTE  PATRONAL:                     ');
							$this->Cell (60,6,number_format($totfin,2,'.',','),0,0,'L');
                                                 $this->ln(8);
							$this->cell(80);
                                                 $rettri=$montot1;
                                                    
                                                 $tottri=$totfin+$rettri;

                                                 $this->cell (60,6,' TOTAL MENSUAL EMPLEADO:                      ');
                                                 $this->Cell (60,6,number_format($tottri,2,'.',','),0,0,'L');
 

                                                 $totgen=$totgen+$tottri;
							$this->ln(9);
							$this->Line(10,$this->GetY(),200,$this->GetY());
							$this->ln(2);
                                                 $montot1=0;
                                                 $montot2=0;

                                           }
					$this->sw=true;
					$this->setFont("Arial","B",9);
					$this->SetTextColor(0,0,128);
                                   $this->cell(-1);

					$this->Cell(15,4,"Cedula:",0,0,'C');
					
					$this->SetTextColor(0,0,0);
					$this->Cell(15,4,$tbg->fields["codemp"],0,0,'C');
						
					                                 
                                  $this->SetTextColor(0,0,128);
					$this->Cell(32,4,"        Edad Empleado: ",0,0,'C');

                                   $this->SetTextColor(0,0,0);
					$this->Cell(10,4,$tbg->fields["edaemp"]);

                                   $this->SetTextColor(0,0,128);
					$this->Cell(25,4,"Sexo Empleado:",0,0,'C');

                                   $this->SetTextColor(0,0,0);
					$this->Cell(8,4,$tbg->fields["sexemp"]);

					
                                   $this->SetTextColor(0,0,128);
					$this->Cell(30,4,"Nombre Empleado:",0,0,'C');
					
					$this->SetTextColor(0,0,0);
					$this->multiCell(80,4,$tbg->fields["nomemp"]);

                                
					$this->SetTextColor(0,0,128);
                                   $this->Cell(9,4,"Tipo:",0,0,'');
					$this->SetTextColor(0,0,0);
					$this->Cell(50,4,ucfirst(strtolower($tbg->fields["nomnom"])));



					$this->SetTextColor(0,0,128);
  					$this->Cell(18,4,"Ubicacion:");
					$this->SetTextColor(0,0,0);
					$y=$this->gety();
					$x=$this->getx();
					$this->setxy($x,$y);
					$this->multicell(100,4,(($tbg->fields["desniv"])));
                                  

				       $this->SetTextColor(0,0,128);
					$this->Cell(27,4,"Cargo Empleado:",0,0,'C');

					$this->SetTextColor(0,0,0);
					$this->Cell(70,4,$tbg->fields["nomcar"]);

                       

                                   $this->SetTextColor(0,0,128);
					$this->Cell(27,4,"Grado Cargo:",0,0,'C');

					$this->SetTextColor(0,0,0);
					$this->Cell(25,4,$tbg->fields["grado"]);

                                   $this->SetTextColor(0,0,128);
					$this->Cell(27,4,"Paso Cargo:",0,0,'C');

					$this->SetTextColor(0,0,0);
					$this->Cell(25,4,$tbg->fields["paso"]);







					$this->Line(10,$this->GetY()+5,200,$this->GetY()+5);
					$this->SetTextColor(0,0,0);
					$this->Ln(4);
				       $this->SetTextColor(128,0,0);
					$this->Ln(4);
                                   $this->Cell(10);
					$this->Cell(54,5,"Nombres Familiar ",0,0,'C');
					$this->Cell(15,5,"Edad ",0,0,'C');
					$this->Cell(15,5,"Sexo ",0,0,'C');
                                   $this->Cell(17,5,"H.C.M. ",0,0,'C');
                                   $this->Cell(22,5,"Doceava",0,0,'C');
					$this->Cell(18,5,"Anual",0,0,'C');
                                   $this->Cell(22,5,"Retencion",0,0,'C');
 					$this->Cell(15,5,"Aporte",0,0,'C');
                                   $this->SetTextColor(0,0,0);
					$this->ln(4);
				}

				//DETALLE
                            if ($tbg->fields["seghcm"]=='S')
                            {
				$this->Cell(5);
                            $this->Cell(62,5,$tbg->fields["nomfam"]);
			       $this->Cell(10,5,$tbg->fields["edafam"],0,0,'C');
			       if ($tbg->fields["sexo"]=='F') 
                                    { $tbg->fields["sexo"]='Femenino'; $fem++;} 
                                     else 
                                    { $tbg->fields["sexo"]='Masculino'; $mas++;}
			       $this->Cell(22,5,$tbg->fields["sexo"],0,0,'');
                            $this->Cell(17,5,$tbg->fields["seghcm"],0,0,'');
                        
                            $this->sql222="SELECT  edaddes, edadhas, monto	
                                 from
         			     npseghcm
    		 	            where
                                     edadDES <=  '".$tbg->fields["edafam"]."' and
                                     edadhas >=  '".$tbg->fields["edafam"]."' and
                                     RTRIM(TIPPAR)  =  '".$tbg->fields["parfam"]."' and
                                     RTRIM(codnom) =  '".$tbg->fields["codnom"]."' ";
					  $tb222=$this->bd->select($this->sql222); 
                                     $monto1=($tb222->fields["monto"])*0.30;
      					  $monto2=($tb222->fields["monto"])*0.70;
                                     $monto3=($tb222->fields["monto"])*12;

			       $this->cell(20,5,number_format($tb222->fields["monto"],2,'.',','),0,0,'');

/////////
                            $this->cell(20,5,number_format($monto3,2,'.',','),0,0,'L');

/////

                            $this->cell(20,5,number_format($monto1,2,'.',','),0,0,'L');


                          
                            $this->cell(10,5,number_format($monto2,2,'.',','),0,0,'L');
                            $montot1=$montot1+$monto1;
                            $montot2=$montot2+$monto2;
     				$this->ln(4);
                      };

                                              if ($tbg->fields["sexemp"]=='F') 
                                                         { $tbg->fields["sexemp"]='001'; $fem++;} 
                                                          else 
                                                         { $tbg->fields["sexemp"]='000'; $mas++;}


                                                ///TITULAR
                                                $this->sql333="SELECT  edaddes, edadhas, monto	
                                                      from
         			                    npseghcm
    		 	                           where
                                                edadDES <=  '".$tbg->fields["edaemp"]."' and
                                                edadhas >=  '".$tbg->fields["edaemp"]."' and
                                                RTRIM(TIPPAR)  =  '".$tbg->fields["sexemp"]."' and
                                                RTRIM(codnom) =  '".$tbg->fields["codnom"]."' ";
					             $tb333=$this->bd->select($this->sql333); 
                                                $montoap=($tb333->fields["monto"]);

 
 
                            $refemp=$tbg->fields["codemp"];
				$tbg->MoveNext();
		}
              /// ultimo registro y total
							$this->ln(3);
							$this->cell(80);


                                                 $this->cell (76,4,' SUB-TOTAL BENEFICIARIOS:                            ');
                                                 $this->cell(20,4,number_format($montot1,2,'.',','),0,0,'L');

 							$this->cell(10,4, number_format($montot2,2,'.',','),0,0,'L');

                                                 $this->ln(4);
							$this->cell(80);
                                                 $this->cell (60,6,' DOCEAVA APORTE PATRONAL TITULAR:                                   '.$montoap);
                                                 $this->ln(6);
							$this->cell(80);
                                                 $this->SetTextColor(128,0,0);
                                                 $this->Cell (60,6,' TOTAL RETENCION EMPLEADO:                       ');
                                                 $this->cell(40,6,number_format($montot1,2,'.',','),0,0,'L');
                                                 $this->ln(7);
							$this->cell(80);
                                                 $totfin=$montoap+$montot2;
                                                 $this->cell (60,6,' TOTAL  APORTE  PATRONAL:                        ');
                                                 $this->cell(60,6,number_format($totfin,2,'.',','),0,0,'L');
                                                 $this->ln(8);
							$this->cell(80);
                                                 $rettri=$montot1;
                                                    
                                                 $tottri=$totfin+$rettri;

                                                 $this->cell (60,6,' TOTAL MENSUAL EMPLEADO:              '.$tottri);
 

                                                 $totgen=$totgen+$tottri;
							$this->ln(9);
							$this->Line(10,$this->GetY(),200,$this->GetY());
							$this->ln(2);
                                                 $montot1=0;
                                                 $montot2=0;









              $this->setFont("Arial","B",12);

             
              $this->Cell(54,15,'TOTAL GENERAL HCM MENSUAL ');
              

              $this->cell(54,15,number_format($totgen,2,'.',','),0,0,'R');





              }
		

              }

?>
