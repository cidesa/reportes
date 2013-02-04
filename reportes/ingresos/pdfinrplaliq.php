<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/general/funciones.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $tipo;
		var $referencia;
		var $sql;
		var $tbg;

		function pdfreporte()
		{
			$this->fpdf("p","mm","Letter");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->referencia=H::GetPost("referencia");
                        $this->referenciahas=H::GetPost("referenciahas");
                        //$this->forliq=H::GetPost("forliq");

			$this->sql="select * from cireging a, ciimping b, ciconrep c, tstipmov d
                                    where
                                    a.refing=b.refing and
                                    a.fecing=b.fecing and
                                    a.rifcon=c.rifcon and
                                    a.tipmov=d.codtip and
                                    a.refing>='$this->referencia' AND  a.refing<='$this->referenciahas' order by a.refing";
                        $arrp=$this->bd->select($this->sql);
                        if($arrp)
                            $this->arrp=$arrp->getArray();
                        else
                            $this->arrp=array();

		}

		function Header()
		{
                    $this->cab->poner_cabecera($this,$_POST["titulo"],"p","s");
                    $this->setFont("Arial","",8);
		
		}

		function Cuerpo()
		{
                    $ref="";
                    foreach($this->arrp as $r)
                    {  
                    //print " (".$ref."  -  ".$r['refing']. ")  ";    
                    if ($ref!="" and $ref!=$r['refing'])    
                    {
                      $this->AddPage();  
                    }   
                    
                    $ref=$r[refing];
                    $this->referencia=$ref;
                    $this->setX(10);
                    $this->multicell(190,4,'SECRETARÍA DE HACIENDA, ADMINISTRACIÓN Y FINANZAS',0,'B');
                    $this->multicell(190,4,'DIRECCIÓN DE TESORERÍA',0,'B');
                    $this->setX(160);
                    $this->setFont("Arial","B",11);
                    $this->multicell(40,5,'Número: '.$r['refing'],0,'C');
                    $this->setFont("Arial","",8);
                    $this->setX(160);
                    $this->multicell(40,6,'EMISIÓN',1,'C');
                    $this->setX(160);
                    $this->multicell(20,6,"\nMATURÍN,",1,'C');
                    $this->setX(180);
                    $this->multicell(20,-6,date('d/m/Y',strtotime($r['fecing']))."\nFecha",1,'C');
                    $this->setFont("Arial","B",9);
                    $this->setY(70);
                    $this->setX(30);
                    $this->multicell(150,5,"CODIGO PRESUPUESTARIO",1,'C');
                    $sqlr="select *,substr(nomabr,1,4) as nomabr  from ciniveles order by consec";
                    $rsr=$this->bd->select($sqlr);
                    $rsano=$this->bd->select("select to_char(fecini,'yyyy') as ano from contaba");
                    $rsr->getArray();
                    $tot=$rsr->recordCount();
                    $trup = 100/$tot;
                    $anchorup=array(25);
                    $rup=array('Año');
                    $t=1;                    
                    foreach($rsr as $r2)
                    {
                        $rup[]=$r2['nomabr'];
                        $anchorup[]=$trup;
                        $t++;
                    }
                    $anchorup[]=25;
                    $rup[]='Complet';
                    $this->setX(30);
                    $this->setWidths($anchorup);
                    $this->SetAligns('C');
                    $this->SetBorder(true);
                    $this->RowM($rup);
                    $this->setFont("Arial","",8);
                    $moning=0;
                    //$ref=$r['refing'];
                       
                        //$ref=$r['refing'];
                        $this->setX(30);
                        $aux=split('-',trim($r['codpre']));
                        $aux[]=trim($r['codpre']);
                        $this->rowm(array_merge(array($rsano->fields['ano']),$aux));
                        $moning+=$r['moning'];
                        $desing=$r['desing'];
                        $ctaban=$r['ctaban'];
                        $numdep=$r['numdep'];
                        $nomcon=$r['nomcon'];
                        $escheque=$r['escheque'];


                    $this->ln(5);
                    $y=$this->getY();
                    $this->ln(5);
                    $this->setX(20);
                    $this->cell(50,4,"Hemos Recibido de: ");
                    $this->setFont("Arial","BU",8);
                    $this->multicell(130,4,str_pad($nomcon,115,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->ln();
                    $this->setX(20);
                    $this->cell(50,4,"En su Caracter de: ");
                    $this->setFont("Arial","BU",8);
                    $this->multicell(130,4,str_pad("CONTRIBUYENTE",130,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->ln();
                    $this->setX(20);
                    $this->cell(50,4,"La cantidad de : ");
                    $this->setFont("Arial","BU",8);
                    $this->multicell(130,4,str_pad(trim(H::obtenermontoescrito($moning)),115,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->ln(5);
                    $this->rect(20,$y,180,$this->getY()-$y);
                    $y=$this->getY();
                    $this->ln(5);
                    $this->setX(20);
		    $this->setFont("Arial","B",8);
                    $this->cell(70,4,"Bsf.(      ".H::FormatoMonto($moning)."     )     Por Concepto de : ");
                    $this->setFont("Arial","BU",8);
                    $this->multicell(110,4,str_pad($desing,80,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->ln();
                    $this->rect(20,$y,180,$this->getY()-$y);
                    $this->ln(2);
                    $y=$this->getY();
                    $rs=$this->bd->select("select nomcue from tsdefban where numcue='$ctaban'");
                    if($escheque=='t')
                    {
                        $banche=$rs->fields['nomcue'];
                        $bandep=$rs->fields['nomcue'];
                        $numche=$numdep;
                        //$bandep='';
                        //$numdep='';
                        //$ctaban='';
                    }else
                    {
                        $bandep=$rs->fields['nomcue'];
                        $banche='';
                        $numche='';
                    }
                    $this->setX(20);
                    $this->cell(40,5,"FORMA DE LIQUIDACION",0,0,'C');
                    $this->cell(20,5,"BANCO:  ");
		    $this->cell(20,5,$r['banco']);
                    $this->setFont("Arial","BU",8);
                    //$this->cell(50,5,str_pad($banche,30,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->cell(20,5,"AGENCIA:");
		    $this->cell(20,5,$r['agencia']);
                    $this->setFont("Arial","BU",8);
                    //$this->cell(50,5,str_pad('',50,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->ln(8);
                    $this->setX(20);
                    //$this->cell(40,5,$this->forliq,0,0,'C');
                    $this->cell(40,5,$this->arrp[0]['tipliq'],0,0,'C');
                    $this->cell(20,5,"CHEQUE:");
                    $this->cell(20,5,$r['cheque']);
                    $this->setFont("Arial","BU",8);
                    //$this->cell(50,5,str_pad($numche,30,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->cell(20,5,"FECHA:");
                    $this->cell(20,5,$r['fecha']);
                    $this->setFont("Arial","BU",8);
                    //$this->cell(50,5,str_pad('',50,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->ln(8);
                    $this->setX(20);
                    $this->multicell(180,5,"DEPOSITO",1,'C');
                    $this->setX(20);
                    $this->cell(12,5,"BANCO:");
                    $this->setFont("Arial","BU",8);                    
                    $this->cell(58,5,str_pad($bandep,30,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->cell(15,5,"CTA N°:");
                    $this->setFont("Arial","BU",8);
                    $this->cell(45,5,str_pad($ctaban,30,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->cell(20,5,"DEPOSITO N°:");
                    $this->setFont("Arial","BU",8);
                    $this->cell(30,5,str_pad($numdep,20,' ',STR_PAD_RIGHT));
                    $this->setFont("Arial","",8);
                    $this->ln(8);
                    $this->rect(20,$y,180,$this->getY()-$y);
                    $this->line(60,$y,60,$this->getY()-13);
                    $this->ln(2);
                    $y=$this->getY();
                    $this->setX(20);
                    $this->cell(140,5,"DEPARTAMENTO DE TESORERIA",1,0,'C');
                    $this->multicell(40,5,"RECIBIDO POR",1,'C');
                    $this->setX(20);
                    $this->cell(45,5,"CAJERO",1,0,'C');
                    $this->cell(45,5,"TESORERO: Lcdo. Elvis Blanco",1,0,'C');
                    $this->cell(50,5,"COORDINADOR DE INGRESOS",1,0,'C');
                    $this->multicell(40,5,"NOMBRE:",1);
                    $this->setX(160);
                    $this->multicell(40,5,"",1);
                    $this->setX(160);
                    $this->multicell(40,5,"CARGO:",1);
                    $this->setX(160);
                    $this->multicell(40,5,"",1);
                    $this->setX(160);
                    $this->multicell(40,5,"C.I.:",1);
                    $this->setX(160);
                    $this->multicell(40,5,"",1);
                    $this->setX(20);
                    $this->setFont("Arial","",6);
                    $this->cell(25,3,"");
                    $this->cell(20,3,"FECHA",1,0,'C');
                    $this->cell(25,3,"");
                    $this->cell(20,3,"FECHA",1,0,'C');
                    $this->cell(25,3,"");
                    $this->cell(25,3,"FECHA",1,0,'C');
                    $this->cell(20,3,"");
                    $this->multicell(20,3,"FECHA",1,'C');
                    $this->setX(20);
                    $this->setFont("Arial","B",8);
                    $this->cell(25,5,"RECIBIDO");
                    $this->cell(20,5,"",1,0,'C');
                    $this->cell(25,5,"AUTORIZADO");
                    $this->cell(20,5,"",1,0,'C');
                    $this->cell(25,5,"REVISADO");
                    $this->cell(25,5,"",1,0,'C');
                    $this->cell(20,5,"FIRMA");
                    $this->multicell(20,5,"",1,'C');
                    $this->rect(20,$y,180,$this->getY()-$y);
                    $this->line(65,$y+10,65,$this->getY());
                    $this->line(110,$y+10,110,$this->getY());
                    }
		}
	}
?>
