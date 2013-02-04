<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/general/Herramientas.class.php");

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
	var $codreqdes;
	var $codreqhas;
	var $analizado;
	var $evaluado;
	var $autorizado;
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
		$this->codreqdes=H::GetPost("codreqdes");
		$this->ela=H::GetPost("ela");
		$this->revis=H::GetPost("rev");
		$this->apro=H::GetPost("apro");


	$this->sql="	SELECT
			A.REQART as reqart,
			to_char(A.FECREQ,'dd/mm/yyyy') as fecreq,
			A.DESREQ as desreq,
			(CASE WHEN A.VALMON = 0 THEN 0 ELSE A.MONREQ/A.VALMON END) as MONREQ,
			(CASE WHEN A.VALMON = 0 THEN 0 ELSE A.MONDES/A.VALMON END) as MONDES,
			 A.MOTREQ as motreq,
			  B.CODART as codart,
			  C.CODARTsnc as codartsnc,
			  B.CODCAT as codcat,
			   B.CANREQ as canreq,
			   (CASE WHEN A.VALMON = 0 THEN 0 ELSE B.COSTO/A.VALMON END) as COSTO,
			   (CASE WHEN A.VALMON = 0 THEN 0 ELSE B.MONRGO/A.VALMON END) as MONRGO,
			   (CASE WHEN A.VALMON = 0 THEN 0 ELSE B.MONTOT/A.VALMON END) as MONTOT,
			   C.UNIMED as unimed,
			   C.DESART as desart,
			    A.VALMON as valmon,
			     A.TIPMON as tipmon, d.nomcat
			        FROM
			        CASOLART A,
			         CAARTSOL B left outer join npcatpre D on  B.CODCAT= D.CODCAT ,
			         CAREGART C
			          WHERE
			          A.REQART ='".$this->codreqdes."'
			           AND A.REQART=B.REQART
			           AND B.CODART=C.CODART
			              ORDER BY A.REQART,B.CODART";
		//echo "<pre>{$this->sql}</pre>"; exit;

		// ------------------------ DATOS REPETITIVOS -----------------------------------
		$this->tb=$this->bd->select($this->sql);
		$this->arrp=$this->tb;
		$c=$this->bd->select("SELECT NOMMON as nombre FROM TSDESMON WHERE CODMON='".$this->tb->fields["tipmon"]."'");
		$this->moneda = (!$c->EOF) ? $c->fields["nombre"] : "";
	}

	function Header()
	{
		//Borde Superior e Izquierdo
                //$this->line(10,10,270,10);
		$this->line(10,35,10,190);
		//Logo
                $this->cab->poner_cabecera_f($this,$_POST["titulo"],$this->conf,"n","n","s");
		$this->setFont("Arial","B",16);
		$this->setFont("Arial","B",9);
		$this->setx(150);
		$this->cell(70,10,'Requisición Número: ');
		$this->cell(50,10,'Fecha: ');
		$this->ln(10);
		//cuadro superior
		$this->line(15,$this->getY(),265,$this->getY());
		$this->line(15,$this->getY(),15,70);
		$this->line(40,$this->getY(),40,70);
		$this->line(200,$this->getY(),200,70);
		$this->line(265,$this->getY(),265,70);
		$this->setXY(15,$this->getY());
		$this->setFont("Arial","B",7);
		$this->cell(20,10,'Descripción:');
		$this->ln();
                $this->setXY(15,$this->getY());
		$this->cell(20,10,'Unidad Solicitante:');
		$this->setXY(15,$this->getY()+11);
		$this->setXY(200,50);
		$this->cell(20,5,'Monto');
		$this->line(200,55,265,55);
		$this->setXY(200,55);
		$this->cell(20,5,'Moneda');
		$this->line(200,60,265,60);
		$this->setXY(200,60);
		$this->cell(20,5,'Tasa');
		$this->line(200,65,265,65);
		$this->setXY(200,65);
		$this->cell(20,5,'Bolívares');
		$this->line(15,70,265,70);
		//Subtitulos
		$this->setXY(25,70);
		$this->setFont("Arial","B",6);
		$this->cell(110,4,'');
		#$this->cell(50,4,'PRIORIDAD 1');
		#$this->cell(50,4,'PRIORIDAD 2');
		#$this->cell(50,4,'PRIORIDAD 3');
		$this->setFont("Arial","B",8);
		$this->setXY(25,71);
		$this->setFont("Arial","B",8);
		$this->cell(100,10,'CUADRO COMPARATIVO DE OFERTAS DE PROVEEDORES');
		//$this->ln();

		$this->line(15,81,265,81);
		$this->setXY(15,81);
		$this->setFont("Arial","B",8);
		$this->cell(15,5,'Código');
		$this->cell(55,5,'Descripción');
		$this->cell(20,5,'Unid. Medida');
		$this->cell(10,5,'Cant.');
		$this->cell(17,5,'Prec.Unit');
		$this->cell(6,5,'Pri.');
		$this->cell(10,5,'Cant.');

		$this->cell(17,5,'Prec.Total');
		$this->cell(17,5,'Prec.Unit');

		$this->cell(6,5,'Pri.');

		$this->cell(9,5,'Cant.');
		$this->cell(18,5,'Prec.Total');
		$this->cell(17,5,'Prec.Unit');
		$this->cell(6,5,'Pri.');

		$this->cell(10,5,'Cant');

		$this->cell(17,5,'Prec.Total');
		//cuadro inferior
		$this->line(15,86,265,86);
		$this->line(30,81,30,135);
		$this->line(85,81,85,135);
		$this->line(105,81,105,135);
		$this->line(132,81,132,135);
		$this->line(138,81,138,135);
		$this->line(148,81,148,135);
		$this->line(182,81,182,135);
		$this->line(188,81,188,135);
		$this->line(198,81,198,135);
		$this->line(232,81,232,135);
		$this->line(238,81,238,135);
		$this->line(248,81,248,135);
		$this->line(15,135,265,135);
		$this->setXY(85,135);
		$this->cell(30,4,'SUB-TOTAL',0,1,'R'); $this->setX(85);
	/*	$this->cell(30,4,'DESCUENTO',0,1,'R'); $this->setX(85);
		$this->cell(30,4,'IVA',0,1,'R'); $this->setX(85);
		$this->cell(30,4,'TOTAL NETO',0,1,'R');*/
		$this->line(115,70,115,151);
		$this->line(165,70,165,151);
		$this->line(215,70,215,151);
		$this->line(265,70,265,151);
		$this->line(15,70,15,151);
		$this->line(15,151,265,151);
		//Cuadro para la firma
                //	$this->setXY(145,159);
                $this->setX(40);
                $this->setY(170);
                $this->SetWidths(array(65,65,65,65));
                $this->SetAligns(array("C","C","C","C"));
                $this->SetBorder(1);
                $this->ln();
                $this->Row(array("ELABORADO","REVISADO","CONFORMADO","CERTIFICADO UNIDAD SOLICITANTE"));
                // $this->ln();
                $this->setJump(15);
                $this->SetAligns(array("L","L","L","L"));
                $this->Row(array("Nombre: ".$this->ela,"Nombre: ".$this->revis,"Nombre: ".$this->apro,"Nombre: "));
                $this->setJump(2);
                $this->SetAligns(array("C","C","C","C"));
                $this->setFont("Arial","B",7);
                $this->Row(array("Firma","Firma","Firma","Firma"));
	
		////////////////////////////////////////////
		//Borde Inferior y Derecho
		$this->line(270,35,270,190);
		////////////////////////////////////////////
		//Datos repetitivos
		$this->setXY(185,38);
		$this->setFont("Arial","B",11);
		$this->cell(48,5,$this->tb->fields["reqart"]);
		$this->cell(50,5,date("d/m/Y"));
		$this->setXY(41,53);
		$this->setFont("Arial","B",9);
		$this->multicell(135,3,($this->tb->fields["desreq"]));
		$this->setXY(41,63);
		$this->setFont("Arial","B",9);
		$this->multicell(135,3,($this->tb->fields["nomcat"]));
		// monto
		$this->setXY(220,50);
		$this->cell(30,5,number_format($this->tb->fields["monreq"],2,',','.'));
		//moneda
		$this->setXY(220,50+5);
		$this->cell(30,5,$this->moneda);
		//tasa
		$this->setXY(220,50+10);
		$this->cell(30,5,number_format($this->tb->fields["valmon"],2,',','.'));
		//bolivares
		$this->setXY(220,50+15);
		$this->cell(30,5,number_format($tb->fields["monreq"]*$tb->fields["valmon"],2,',','.'));
                $this->setFont("Arial","B",6);
	}

	function Cuerpo()
	{
		$tb = $this->tb;
		$ref=$tb->fields["reqart"];	
		$this->setFont("Arial","B",6);
		$H = 4;
		$this->sety($Y);
                $sw=false;
                $this->setY(87);
                $this->tprec=array();
                $this->tdes=array();
                $this->tiva=array();
		while (!$tb->EOF)
		{
                        $this->setX(15);
                        $this->cell(15,4,$tb->fields["codartsnc"]);
                        $this->cell(55,4,'');
                        $this->cell(20,4,$tb->fields["unimed"]);
                        $this->cell(10,4,$tb->fields["canreq"]);
			$provee_sql = "	SELECT A.NOMPRO as proveedor, b.refcot as refcot, (coalesce(c.COSTO,0)) as precio, c.priori, totdet as totdet, canord , b.monrec FROM CAPROVEE A,CACOTIZA B, cadetcot c WHERE b.refcot=c.refcot and B.CODPRO=A.CODPRO AND B.REFSOL='".$ref."' and c.codart='".$tb->fields['codart']."' order by a.codpro";
                        $proveedores=$this->bd->select($provee_sql);
                        $ref=$tb->fields["reqart"];
                        $npro = 0;                        
			while (!$proveedores->EOF) { //PROVEEDORES

                                $Y=$this->getY();
                                if(!$sw)
                                {
                                    $this->setXY(115+50*$npro,73);
                                    $proveedor=$proveedores->fields["proveedor"];
                                    $this->multicell(50,4,$proveedor);
                                }
                                $this->setY($Y);
                                $rs=$proveedores;
                                $this->setX(115+50*$npro);
                                $this->cell(17,4,number_format($rs->fields["precio"],2,',','.'),0,0,"R");
                                $this->cell(4,4,$rs->fields["priori"],0,0,"R");
                                $this->cell(12,4,number_format($rs->fields["canord"],2,',','.'),0,0,"R");
                                $this->cell(17,4,number_format($rs->fields["totdet"],2,',','.'),0,0,"R");
                                $this->tprec[$npro]+=$rs->fields["totdet"];
                                $this->tdesc[$npro]+=$rs->fields["totdes"];
                                $this->tiva[$npro]=$rs->fields["monrec"];
                                $npro++;
				$proveedores->moveNext();				
			}//PROVEEDORES
                        $this->setX(30);
                        $this->multicell(55,4,$tb->fields["desart"],0,'L');
                        if($this->getY()>=130)
                        {
                            $this->addPage();
                            $sw=false;
                            $this->setY(87);
                        }else
                            $sw=true;
                        $tb->moveNext();
		}
                $this->setFont("Arial","B",8);
                $this->setXY(85,139);
                $this->setX(85);$this->cell(30,4,'DESCUENTO',0,0,'R');
                $this->cell(50,4,number_format($this->tdes[0],2,',','.'),0,0,"R");//DESCUENTO
                $this->cell(50,4,number_format($this->tdes[1],2,',','.'),0,0,"R");//DESCUENTO
                $this->cell(50,4,number_format($this->tdes[2],2,',','.'),0,1,"R");//DESCUENTO
                $this->setX(85);$this->cell(30,4,'IVA',0,0,'R');
                $this->cell(50,4,number_format($this->tiva[0],2,',','.'),0,0,"R");//IVA
                $this->cell(50,4,number_format($this->tiva[1],2,',','.'),0,0,"R");//IVA
                $this->cell(50,4,number_format($this->tiva[2],2,',','.'),0,1,"R");//IVA
                $this->setX(85);$this->cell(30,4,'TOTAL NETO',0,0,'R');
                $this->cell(50,4,number_format(($this->tprec[0]-$this->tdes[0])+$this->tiva[0],2,',','.'),0,0,"R");//NETO
                $this->cell(50,4,number_format(($this->tprec[1]-$this->tdes[1])+$this->tiva[1],2,',','.'),0,0,"R");//NETO
                $this->cell(50,4,number_format(($this->tprec[2]-$this->tdes[2])+$this->tiva[2],2,',','.'),0,1,"R");//NETO
	}
        function Footer()
        {
            $this->setFont("Arial","B",8);
            $this->setXY(85,135);
            $this->cell(80,4,number_format($this->tprec[0],2,',','.'),0,0,"R");//SUB-TOTAL
            $this->cell(50,4,number_format($this->tprec[1],2,',','.'),0,0,"R");//SUB-TOTAL
            $this->cell(50,4,number_format($this->tprec[2],2,',','.'),0,1,"R");//SUB-TOTAL
            
        }
}
?>