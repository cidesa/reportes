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
    var $campos;
    var $sql;
    var $rif = 'G200090685';

    var $fecdes;
    var $fechas;
    var $benalterno;
    var $rifalterno;
    var $rete;
    var $notit=true;


    function pdfreporte()
    {
      $pag= array(280,395);
      $this->fpdf("l","mm",$pag);
      $this->bd=new basedatosAdo();
      $this->bd->validar();
      $this->titulos=array();
      $this->titulos2=array();
      $this->campos=array();
      $this->anchos=array();
      $this->ancho=array();
      $this->fecdes=$_POST["fecdes"];
      $this->fechas=$_POST["fechas"];
      #$this->elaborado=$_POST["elaborado"];
      #$this->autorizado=$_POST["autorizado"];
      #$this->revisado=$_POST["revisado"];
      $this->rete=$_POST["rete"];

	  $sqlempleado="";
      if ($this->rete=="V")
      {
      	$orderby="order by b.comret,b.feccomret,b.cedrif,b.nomben";
      	$sqlfecha=" b.feccomret>=to_date('".$this->fecdes."','dd/mm/yyyy') and
              		b.feccomret<=to_date('".$this->fechas."','dd/mm/yyyy') and
              		(b.feccomret)<>to_date('','dd/mm/yyyy') and b.feccomret is not null and";
        $sqlcomret="b.comret is not null and";
		$sqlcom="b.comret,
                b.feccomret,";
		$fecha="b.feccomret";
		$compro="b.comret";
		$sqlimpu="to_char(a.fecfac,'dd/mm/yyyy') as fecfac,
			  a.numfac,
              a.numctr,a.tiptra,case when a.facafe is null or trim(a.facafe)='' then '0' else a.facafe end as facafe ,
              a.totfac,
              a.exeiva,
              a.basimp,
              a.poriva,
              moniva,
              a.monret,
			  porislr,
              monislr,
              basislr,";
		$sqlimpu2="a.fecfac,
                a.numfac,
                a.tiptra,
                a.facafe,
                a.numctr,
				a.totfac,
                a.exeiva,
                a.basimp,
                a.poriva,
                moniva,
                a.monret,
				porislr,
                monislr,
                basislr,";
      }elseif ($this->rete=="I")
      {
      	$orderby="";
      	$sqlfecha=" b.feccomretislr>=to_date('".$this->fecdes."','dd/mm/yyyy') and
              		b.feccomretislr<=to_date('".$this->fechas."','dd/mm/yyyy') and
              		(b.feccomretislr)<>to_date('','dd/mm/yyyy') and b.feccomretislr is not null and";
        $sqlcomret="b.comretislr is not null and";
		$sqlcom="b.comretislr,
                b.feccomretislr,";
		$fecha="b.feccomretislr";
		$compro="b.comretislr";
		$sqlimpu="to_char(a.fecfac,'dd/mm/yyyy') as fecfac,
			  a.numfac,e.codtip,--e.codtipxml,
              a.numctr,a.tiptra,case when a.facafe is null or trim(a.facafe)='' then '0' else a.facafe end as facafe ,
              a.totfac,
              a.exeiva,
              a.basimp,
              a.poriva,
              moniva,
              a.monret,
			  porislr,
              monislr,
              basislr,";
		$sqlimpu2="a.fecfac,
                a.numfac,e.codtip,--e.codtipxml,
                a.tiptra,
                a.facafe,
                a.numctr,
				a.totfac,
                a.exeiva,
                a.basimp,
                a.poriva,
                moniva,
                a.monret,
				porislr,
                monislr,
                basislr,";

		$sqlempleado="select '' as fecfac,'0' as numfac,'001' as codtipxml,'NA' as numctr,'01' as tiptra,'0' as facafe,
						'0' as totfac,'0' as exeiva,'0' as basimp,'0' as poriva,'0' as moniva,'0' as monret,
						max(case when (b.codcon in ('D43','D44','D45','D22','D23','D24','D25','D27','D28','D29','D30','D31','D32','D33','D36')) then b.cantidad else 0 end) as porislr,
						'0' as monislr,
						sum(case when (codcon in (select codcon from npconsalint where codnom=b.codnom)) then monto else 0 end) as basislr,
						a.rifemp as cedrif,a.nomemp as nomben,'0' as numord,'' as desord,'' as fecemi,'0' as comprobante,'0' as percompro,'' as fecret,'' as rifalt,'' as cedrifres,'' as ctaban,''
						from
						nphojint a, nphiscon b
						where
						b.fecnom>=to_date('$this->fecdes','dd/mm/yyy') and
						b.fecnom<=to_date('$this->fechas','dd/mm/yyyy') and
						a.codemp=b.codemp and
						a.rifemp<>'' and
						b.especial='N' and
						b.codcon<>'A77'
						group by
						a.rifemp,a.nomemp
						UNION ALL
						";
      }elseif ($this->rete=="C")
      {
      	$orderby="order by b.numord,b.fecemi,b.comret,b.feccomret,b.cedrif,b.nomben";
      	$sqlfecha=" b.fecemi>=to_date('".$this->fecdes."','dd/mm/yyyy') and
              		b.fecemi<=to_date('".$this->fechas."','dd/mm/yyyy') and
              		(b.fecemi)<>to_date('','dd/mm/yyyy') and b.fecemi is not null and";
        $sqlcomret="";#"b.comret is not null and";
		$sqlcom="b.comret,
                b.feccomret,";
		$fecha="b.fecemi";
		$compro="b.comret";
		$sqlimpu="to_char(a.fecfac,'dd/mm/yyyy') as fecfac,
			  a.numfac,
              a.numctr,a.tiptra,case when a.facafe is null or trim(a.facafe)='' then '0' else a.facafe end as facafe ,
              a.totfac,
              a.exeiva,
              a.basimp,
              a.poriva,
              moniva,
              a.monret,
			  porislr,
              monislr,
              basislr,";
		$sqlimpu2="a.fecfac,
                a.numfac,
                a.tiptra,
                a.facafe,
                a.numctr,
				a.totfac,
                a.exeiva,
                a.basimp,
                a.poriva,
                moniva,
                a.monret,
				porislr,
                monislr,
                basislr,";
      }else
      {
      	$orderby="order by b.comretltf,b.feccomretltf,b.cedrif,b.nomben";
      	$sqlfecha=" b.feccomretltf>=to_date('".$this->fecdes."','dd/mm/yyyy') and
              		b.feccomretltf<=to_date('".$this->fechas."','dd/mm/yyyy') and
              		(b.feccomretltf)<>to_date('','dd/mm/yyyy') and b.feccomretltf is not null and";
        $sqlcomret="b.comretltf is not null and d.codrep='003' and";
		$sqlcom="b.comretltf,
                b.feccomretltf,";
		$fecha="b.feccomretltf";
		$compro="b.comretltf";
		$sqlimpu="sum(porltf) as porltf,
              sum(monltf) as monltf,
              sum(basltf) as basltf,";
		$sqlimpu2="";
      }
      
       $sqlreten="";       	
       $reten='';
       if($this->rete!="C")
       {
       	   	$sqlcompra="  a.numord=c.numord and
		              c.codtip=d.codret and
					  c.codtip=e.codtip and
					  d.codret=e.codtip";
	       if ($this->rete=="V"){
	       	$sqlreten="and trim(d.codrep)='001'";       	
	       	$reten='001';
	       }
	       elseif ($this->rete=="I"){
	       	$sqlreten="and trim(d.codrep)='002'";       	
	       	$reten='002';
	       }
	       elseif ($this->rete=="I"){
	       	$sqlreten="and trim(d.codrep)='003'";       	
	       	$reten='003';
	       }
	       $sqlfrom=",(select distinct numord, codtip from opretord ) c,tsrepret d, optipret e";
       }else
       {
       		$sqlcompra="1=1";
       		$sqlfrom=" left outer join (select distinct numord, codtip from opretord ) c on (a.numord=c.numord)
       		           left outer join tsrepret d on (c.codtip=d.codret)
       		           left outer join optipret e on (d.codret=e.codtip)";
       }

     # $this->sql="$sqlempleado
      $this->sql="select
              $sqlimpu
              b.cedrif,
              b.nomben,
	          b.numord,
	          b.desord,
              to_char(b.fecemi,'dd/mm/yyyy') as fecemi,
              TO_CHAR($fecha,'yyyymm')||LPAD($compro,8,'0') as COMPROBANTE,
              TO_CHAR($fecha,'yyyymm') as PERCOMPRO,
              TO_CHAR($fecha,'dd/mm/yyyy') as fecret,
              a.rifalt,
	      	  b.ctaban
            from
              opordpag b ,opfactur a $sqlfrom
            where
              a.numord=b.numord and
              $sqlfecha
              $sqlcomret
              $sqlcompra 
			  $sqlreten
              group by
				$sqlimpu2
                b.cedrif,
                b.nomben,
                b.numord,
                b.desord,
                B.FECEMI,
                a.rifalt,
				$sqlcom
				b.ctaban
				$orderby";

			//print "<pre>".$this->sql;exit();

   if ($this->rete=="V" || $this->rete=="C")
      {
      	$this->xx=10;
		$this->imp="IVA";
		$this->tit="Impuesto al Valor Agregado(IVA)";

      }
      elseif($this->rete=="I"){
      	$this->xx=20;
      	$this->imp="ISLR";
		$this->tit="Impuesto Sobre la Renta(ISLR)";
      }
      else if ($this->rete=="L"){
      	$this->xx=25;
      	$this->imp="LTF";
		$this->tit="Impuesto Ley de Timbre Fiscal(LTF)";
      }
      $this->llenartitulos();

    }

	function llenartitulos()
	{
		if($this->rete=="I")
		{
			$this->titulos[]="Nro de Operacion";
			$this->anchos[]=13;
			$this->aliniacion[]='C';
			$this->titulos[]="Rif del Retenido";
			$this->anchos[]=19;
			$this->aliniacion[]='C';
			$this->titulos[]="Nombre del Retenido";
			$this->anchos[]=101;
			$this->aliniacion[]='C';
	        $this->titulos[]="Nro de Factura";
			$this->anchos[]=16;
			$this->aliniacion[]='C';
	        $this->titulos[]="Nro control de Factura";
			$this->anchos[]=16;
			$this->aliniacion[]='C';
	        $this->titulos[]="Codigo de Concepto";
			$this->anchos[]=30;
			$this->aliniacion[]='L';
			$this->titulos[]="Monto Operacion	";
			$this->anchos[]=35;
			$this->aliniacion[]='R';
	        $this->titulos[]="Porcentaje de Rentencion";
			$this->anchos[]=30;
			$this->aliniacion[]='R';
			$this->titulos[]="Numero/Orden";
			$this->anchos[]=30;
			$this->aliniacion[]='R';
				$this->titulos[]="Comprobante";
			$this->anchos[]=30;
			$this->aliniacion[]='C';
				$this->titulos[]="Monto";
			$this->anchos[]=30;
			$this->aliniacion[]='R';

		}
		elseif($this->rete=="V" || $this->rete=="C")
		{
			$this->titulos[]="Item";
			$this->anchos[]=10;
			$this->aliniacion[]='C';

			$this->titulos[]="PERIODO";
			$this->anchos[]=19;
			$this->aliniacion[]='C';
	        $this->titulos[]="FECHA DOC.";
			$this->anchos[]=25;
			$this->aliniacion[]='C';
			$this->titulos[]="TIPO OPER";
			$this->anchos[]=16;
			$this->aliniacion[]='C';
	        $this->titulos[]="TIPO DOC";
			$this->anchos[]=16;
			$this->aliniacion[]='C';
			$this->titulos[]="RIF COMPR";
			$this->anchos[]=25;
			$this->aliniacion[]='C';
	        $this->titulos[]="NRO. DOC.";
			$this->anchos[]=25;
			$this->aliniacion[]='C';
			$this->titulos[]="NRO.CONTR";
			$this->anchos[]=25;
			$this->aliniacion[]='C';
	        $this->titulos[]="MTO. DOC.";
			$this->anchos[]=25;
			$this->aliniacion[]='R';
	        $this->titulos[]="BASE IMP.";
			$this->anchos[]=25;
			$this->aliniacion[]='R';
	        $this->titulos[]="MTO. IVA";
			$this->anchos[]=25;
			$this->aliniacion[]='R';
	        $this->titulos[]="MTO. RET";
			$this->anchos[]=24;
			$this->aliniacion[]='R';
			$this->titulos[]="NRO. COMPR";
			$this->anchos[]=25;
			$this->aliniacion[]='C';
			$this->titulos[]="MTO. EXENT";
			$this->anchos[]=25;
			$this->aliniacion[]='R';
			$this->titulos[]="ALICUOTA";
			$this->anchos[]=16;
			$this->aliniacion[]='C';
			$this->titulos[]="NRO. ORDEN";
			$this->anchos[]=16;
			$this->aliniacion[]='C';
			$this->anchos[]=35;
			$this->aliniacion[]='C';
			$this->titulos[]="PROVEEDOR";
		}
		else{
			$this->titulos[]="ITEM";
			$this->anchos[]=15;
			$this->aliniacion[]='C';
			$this->titulos[]="Rif del Proveedor";
			$this->anchos[]=30;
			$this->aliniacion[]='C';
	        $this->titulos[]="Nombre del Proveedor";
			$this->anchos[]=80;
			$this->aliniacion[]='L';
			$this->titulos[]="Base Imponible";
			$this->anchos[]=30;
			$this->aliniacion[]='R';
			$this->titulos[]="Monto del Impuesto 1/1000";
			$this->anchos[]=25;
			$this->aliniacion[]='R';
	        $this->titulos[]="Fecha de la Orden";
			$this->anchos[]=25;
			$this->aliniacion[]='C';
	        $this->titulos[]="Nro de Orden";
			$this->anchos[]=50;
			$this->aliniacion[]='C';
	        $this->titulos[]="ENTE EJECUTOR";
			$this->anchos[]=80;
			$this->aliniacion[]='C';
			$this->titulos[]="Numero/Orden";
			$this->anchos[]=30;
			$this->aliniacion[]='C';

		}
	}


    function Header()
    {

      $this->setFont("Arial","B",8);
      //Logo de la Empresa
      $this->Image("../../img/logo_1.jpg",10,8,33);
      //fecha actual
      $fecha=date("d/m/Y");
      $this->Cell(370,10,'Fecha: '.$fecha,0,0,'R');
      $this->ln(5);
      //Paginas
      $this->Cell(370,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R');

      $this->Ln(-5);
        $this->Cell(270,5,'',0,0,'C');
      $this->Ln(3);
        $this->Cell(270,5,'',0,0,'C');
      $this->Ln(3);
        $this->Cell(270,5,'',0,0,'C');
      $this->Ln(3);
        $this->Cell(270,5,'',0,0,'C');
        $this->Ln(8);
      //Titulo del Reporte
      $this->setFont("Arial","B",12);
      $this->Cell(395,10,$_POST["titulo"]." del ".$this->tit,0,0,'C',0);
      $this->ln(10);
      $this->Line(10,35,385,35);
      $this->setFont("Arial","B",9);
      $this->L1();
      $this->cell(15,10,"Desde :");$this->L2();$this->cell(25,10,$this->fecdes);
      $this->Ln(4);
      $this->L1();
      $this->cell(15,10,"Hasta :");$this->L2();$this->cell(25,10,$this->fechas);
      $this->Ln(4);
      $tb1=$this->bd->select("SELECT NOMEMP as NOMEMPRESA FROM EMPRESA");
      $this->L1();
      $this->cell(15,10,"Oficina :");$this->L2();$this->cell(25,10,strtoupper($tb1->fields["nomempresa"]));
	  $this->ln();

	      $this->SetWidths($this->anchos);
	      $this->SetAligns('C');
	      $this->SetBorder(true);
		  $this->SetJump(5);
	      $this->setFont("Arial","B",8);
		  $this->setX($this->xx);
	      $this->RowM($this->titulos);
	      $this->SetAligns($this->aliniacion);
		  $this->setX($this->xx);

    }

    function L1()
    {
    $this->setFont("Arial","B",9);
    }
    function L2()
    {
    $this->setFont("Arial","",9);
    }
    function PutLink($URL,$txt)
    {
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
    function SetStyle($tag,$enable)
    {
        //Modificar estilo y escoger la fuente correspondiente
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }
    function Cuerpo()
    {
      $tb=$this->bd->select($this->sql);
      $this->tb2=$tb;
      $Inicio=$this->GetY();
      $this->setFont("Arial","",7);
      $txt=$_POST["txt"];
      $rif=$this->rif;
      $cont=1;
      $existe=false;
      $numret=0;
      $this->montoislr=0;
              while (!$tb->EOF)
              {
              	$numret++;

              	  if ($this->rete=="V" || $this->rete=="C") //iva
     			  {
     			  	$this->x=10;
     			  	$base=$tb->fields["basimp"];
     			 	$por=$tb->fields["poriva"];
     			 	$rete=$tb->fields["moniva"];
     			 	$iva=$tb->fields["monret"];
     			 	$exe=$tb->fields["exeiva"];
     			  }
			      elseif($this->rete=="I") //islr
			      {
			      	$this->x=20;
			      	$base=$tb->fields["basislr"];
			      	$por=$tb->fields["porislr"];
			      	$rete=$tb->fields["monislr"];
			      	$iva=0;
			      	$exe=0;
			      }
			      elseif($this->rete=="L") //ltf
			      {
			      	$this->x=25;
			      	$base=$tb->fields["basltf"];
			      	$por=$tb->fields["porltf"];
			      	$rete=$tb->fields["monltf"];
			      	$iva=0;
			      	$exe=0;
			      }

				  if($tb->fields["rifalt"]!='')
				  { $this->rifalterno=$tb->fields["rifalt"]; }
                  else
                  { $this->rifalterno=$tb->fields["cedrif"];}

                  if($tb->fields["rifalt"]!='')
                  {
                    $tb1=$this->bd->select("select nomben as benalterno from opbenefi where cedrif='".$tb->fields["rifalt"]."'");
                    $this->benalterno=$tb1->fields["benalterno"];
                  }else
                  {
                    $this->benalterno=$tb->fields["nomben"];
                  }

				  if($tb->fields["cedrif"]!='')
				  {
				  	$tb1=$this->bd->select("select nomben as benalterno from opbenefi where cedrif='".$tb->fields["cedrif"]."'");
					$this->ente=$tb1->fields["benalterno"]; }
                  else
                  { $this->ente="";}

                  $nro=$tb->fields["numfac"];
                  if ($tb->fields["tiptra"]=='01')
                  {

                  }
				  if($this->rete=="V" || $this->rete=="C")
				  {
				  	$this->setX($this->x);
	              	$this->RowM(array($cont,$tb->fields["percompro"],$tb->fields["fecfac"],"C",$tb->fields["tiptra"],strtoupper(trim($this->rifalterno)),trim($tb->fields["numfac"]),trim($tb->fields["numctr"]),H::FormatoMonto($tb->fields["totfac"]),H::FormatoMonto($base),H::FormatoMonto($rete),$tb->fields["monret"],$tb->fields["comprobante"],$tb->fields["exeiva"],H::FormatoMonto($por),$tb->fields["numord"],strtoupper(trim($this->benalterno))));
				  }
	              elseif($this->rete=="I")
	              {
	              	$this->setX($this->x);
	            	$this->RowM(array($cont,strtoupper(trim($this->rifalterno)),trim($this->benalterno),trim($tb->fields["numfac"]),trim($tb->fields["numctr"]),trim($tb->fields["codtip"]),H::FormatoMonto($base),H::FormatoMonto($por),$tb->fields["numord"],$tb->fields["comprobante"],H::FormatoMonto($tb->fields["monislr"])));
	            	$this->montoislr+=$tb->fields["monislr"];
	              }
				  else
	              {
	              	$this->setX($this->x);
	            	$this->RowM(array($cont,strtoupper(trim($this->rifalterno)),trim($this->benalterno),H::FormatoMonto($base),H::FormatoMonto($rete),trim($tb->fields["fecemi"]),trim($tb->fields["numord"]),$this->ente,$tb->fields["numord"]));
	              }


                $Tot_totfac=$Tot_totfac + $tb->fields["totfac"];
                $Tot_exeiva=$Tot_exeiva + $exe;
                $Tot_baseimp=$Tot_baseimp + $base;
                $Tot_moniva=$Tot_moniva + $iva;
                $Tot_monret=$Tot_monret + $rete;

                $cont=$cont+1;
              $tb->MoveNext();
            } //------------------------------ fin while EOF

          $this->Ln(4);

          $this->setFont("Arial","B",8);
          if($this->rete=="V" || $this->rete=="C")
          {
			  $this->rowm(array("","","","","","","","TOTALES",H::FormatoMonto($Tot_totfac),H::FormatoMonto($Tot_baseimp),H::FormatoMonto($Tot_monret),H::FormatoMonto($Tot_moniva),"",H::FormatoMonto($Tot_exeiva),"","",""));
          }
          elseif($this->rete=="I")
          {
          	$this->setX(20);
			  $this->rowm(array("","","","","","TOTALES",H::FormatoMonto($Tot_baseimp),"","","",H::FormatoMonto($this->montoislr)));
          }else
		  {
		  	$this->setX(25);
			 $this->rowm(array("","","TOTALES",H::FormatoMonto($Tot_baseimp),H::FormatoMonto($Tot_monret),"","",""));
		  }
          $this->Ln(7);
		  $this->setautoPagebreak(false);
          $this->cell(60,10,"Total Retencion del Periodo",0,0,'R');
          $this->cell(30,10,number_format($numret,2,'.',','),0,0,'R');
          $this->Ln(10);
          $y=$this->GetY();
          //$this->Line(106,$y,370,$y);
          //$this->Line(106,$y+1,370,$y+1);
          $this->setautoPagebreak(true,20);
          if($this->GetY()>160)
		  {
		  	$this->notit=false;
			$this->AddPage();
		  }

      $this->setFont("Arial","B",8);
      $this->Ln(20);
      $this->SetX(10);
      $this->Cell(100,5,'Creditos Fiscales');
      $this->Ln();
      $y=$this->GetY();
      $y1=$y;
      $this->setFont("Arial","B",8);
      $this->Rect(10,$y,160,65);
      $this->Line(106,$y,106,$y+65);//1-48
      $this->Line(138,$y,138,$y+65);//5-16
      $this->Line(10,$y+10,170,$y+10);
      $y+=10;
      for ($i=0;$i<11;$i++){
        $y+=5;
        $this->Line(10,$y,170,$y);
      }
      $this->SetXY(10,$y1);
      $this->Cell(96,10,'RESUMEN DEL PERIODO',0,0,'C');
      $this->Cell(32,10,'BASE IMPONIBLE',0,0,'C');
      $this->Cell(32,10,'CREDITO FISCAL',0,0,'C');
      $this->setFont("Arial","B",7);
      $y1+=10;
      $this->SetXY(10,$y1);
      $this->Cell(96,5,'TOTAL COMPRAS INTERNAS AFECTADAS EN ALICUOTA GENERAL',0,0,'L');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->setFont("Arial","B",6.5);
      $this->Cell(96,5,'TOTAL COMPRAS INTERNAS AFECTADAS EN ALICUOTA GENERAL + ADICIONAL',0,0,'L');
      $this->setFont("Arial","B",7);
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96,5,'TOTAL COMPRAS INTERNAS AFECTADAS EN ALICUOTA REDUCIDA',0,0,'L');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96,5,'TOTAL EXENTAS COMPRAS INTERNAS',0,0,'L');
      $this->cell(32,5,number_format($Tot_exeiva,2,'.',','),0,0,'R');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96);
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96,5,'TOTALES GENERALES',0,0,'L');
      $this->cell(32);
      $this->cell(32,5,number_format($Tot_totfac,2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96,5,'Creditos Fiscales Totalmente Deducible',0,0,'L');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $this->cell(32,5,number_format( $Tot_moniva,2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96,5,'Creditos Fiscales Parcialmente Deducible',0,0,'L');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96,5,'Total Creditos Fiscales Deducibles',0,0,'L');
      $this->cell(32,5,number_format('0',2,'.',','),0,0,'R');
      $this->cell(32,5,number_format( $Tot_moniva,2,'.',','),0,0,'R');
      $y1+=5;
      $this->SetXY(10,$y1);
      $this->Cell(96);
      $y1+=5;
//      $this->SetXY(10,$y1);
//      $this->Cell(96,5,'Total ' .$this->imp. ' Retenido al Vendedor',0,0,'L');
//      $this->cell(32);
//      $this->cell(32,5,number_format('5',2,'.',','),0,0,'R');

	  //-----------------------------------------------------------------------------------------------------------------------------//
      if ($txt=='SI')
      {
      	    if ($this->rete=="V" || $this->rete=="C")
      	    {
      	    	$dir = parse_url($_SERVER['HTTP_REFERER']);
				$dirpath=$dir['path'];
				if(!(strrpos($dir['path'],".php")))
					$dirpath=$dir['path'].".php";
				$dir = eregi_replace(".php","_hc.php",$dir['scheme'].'://'.$dir['host'].$dirpath);
				#$direccion= eregi_replace(" ","@#@",trim($dir).'?fecdes='.$this->fecdes.'&fechas='.$this->fechas.'&elaborado='.$this->elaborado.'&autorizado='.$this->autorizado.'&revisado='.$this->revisado.'&rete='.$this->rete);
				$this->PutLink(trim($dir).'?fecdes='.str_replace("/","*",$this->fecdes).'&fechas='.str_replace("/","*",$this->fechas).'&elaborado='.$this->elaborado.'&autorizado='.$this->autorizado.'&revisado='.$this->revisado.'&rete='.$this->rete.'&tipo='.$this->tipo.'&schema='.$_SESSION["schema"],'Txt Impuesto al Valor Agregado(IVA)');

      	    }elseif ($this->rete=="I")
      	    {
				$dir = parse_url($_SERVER['HTTP_REFERER']);
				$dirpath=$dir['path'];
				if(!(strrpos($dir['path'],".php")))
					$dirpath=$dir['path'].".php";
				$dir = eregi_replace(".php","_hc.php",$dir['scheme'].'://'.$dir['host'].$dirpath);
				#$direccion= eregi_replace(" ","@#@",trim($dir).'?fecdes='.$this->fecdes.'&fechas='.$this->fechas.'&elaborado='.$this->elaborado.'&autorizado='.$this->autorizado.'&revisado='.$this->revisado.'&rete='.$this->rete);
				$this->PutLink(trim($dir).'?fecdes='.str_replace("/","*",$this->fecdes).'&fechas='.str_replace("/","*",$this->fechas).'&elaborado='.$this->elaborado.'&autorizado='.$this->autorizado.'&revisado='.$this->revisado.'&rete='.$this->rete.'&tipo='.$this->tipo.'&schema='.$_SESSION["schema"],'Excel Impuesto Sobre la Renta(ISLR)');
      	    }
			else
      	    {
				$dir = parse_url($_SERVER['HTTP_REFERER']);
				$dirpath=$dir['path'];
				if(!(strrpos($dir['path'],".php")))
					$dirpath=$dir['path'].".php";
				$dir = eregi_replace(".php","_hc.php",$dir['scheme'].'://'.$dir['host'].$dirpath);
				#$direccion= eregi_replace(" ","@#@",trim($dir).'?fecdes='.$this->fecdes.'&fechas='.$this->fechas.'&elaborado='.$this->elaborado.'&autorizado='.$this->autorizado.'&revisado='.$this->revisado.'&rete='.$this->rete);
				$this->PutLink(trim($dir).'?fecdes='.str_replace("/","*",$this->fecdes).'&fechas='.str_replace("/","*",$this->fechas).'&elaborado='.$this->elaborado.'&autorizado='.$this->autorizado.'&revisado='.$this->revisado.'&rete='.$this->rete.'&tipo='.$this->tipo.'&schema='.$_SESSION["schema"],'Excel Impuesto Ley de Timbre Fiscall(LTF)');
      	    }

      }
	  //-----------------------------------------------------------------------------------------------------------------------------//
    $this->bd->closed();

    }
}
?>
