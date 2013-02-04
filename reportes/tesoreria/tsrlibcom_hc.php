<?
require_once("../../lib/bd/basedatosAdo.php");
require_once("../../lib/general/Herramientas.class.php");
if(H::GetPost("rete")=="V")
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=/tmp/libro_compra_IVA_".date('d/m/Y').".txt");
}elseif(H::GetPost("rete")=="I")
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=/tmp/libro_compra_ISLR_".date('d/m/Y').".xls");
}elseif(H::GetPost("rete")=="C")
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=/tmp/libro_compra_todas_".date('d/m/Y').".xls");

}
else
{
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=/tmp/libro_compra_ltf_".date('d/m/Y').".xls");
}

$bd= new basedatosAdo();
$fecdes=str_replace("*","/",H::GetPost("fecdes"));
$fechas=str_replace("*","/",H::GetPost("fechas"));
$elaborado=H::GetPost("elaborado");
$autorizado=H::GetPost("autorizado");
$revisado=H::GetPost("revisado");
$rete=H::GetPost("rete");
$tipo=H::GetPost("tipo");
$titulo=H::GetPost("titulo");

	  if ($rete=="V")
      {
      	$orderby="order by lpad(b.comret,20,'0'),b.feccomret,b.cedrif,b.nomben";
      	$sqlfecha=" b.feccomret>=to_date('".$fecdes."','dd/mm/yyyy') and
              		b.feccomret<=to_date('".$fechas."','dd/mm/yyyy') and
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
      }elseif ($rete=="I")
      {
      	$orderby="";
      	$sqlfecha=" b.feccomretislr>=to_date('".$fecdes."','dd/mm/yyyy') and
              		b.feccomretislr<=to_date('".$fechas."','dd/mm/yyyy') and
              		(b.feccomretislr)<>to_date('','dd/mm/yyyy') and b.feccomretislr is not null and";
        $sqlcomret="b.comretislr is not null and";
		$sqlcom="b.comretislr,
                b.feccomretislr,";
		$fecha="b.feccomretislr";
		$compro="b.comretislr";
		$sqlimpu="to_char(a.fecfac,'dd/mm/yyyy') as fecfac,
			  a.numfac,e.codtipsen as codtip,--e.codtipxml,
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
                a.numfac,e.codtipsen,--e.codtipxml,
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
						b.fecnom>=to_date('$fecdes','dd/mm/yyy') and
						b.fecnom<=to_date('$fechas','dd/mm/yyyy') and
						a.codemp=b.codemp and
						a.rifemp<>'' and
						b.especial='N' and
						b.codcon<>'A77'
						group by
						a.rifemp,a.nomemp
						UNION ALL
						";
      }elseif ($rete=="C")
      {
      	$orderby="order by lpad(b.comret,20,'0'),b.feccomret,b.numord,b.fecemi,b.cedrif,b.nomben";
      	$sqlfecha=" b.fecemi>=to_date('".$fecdes."','dd/mm/yyyy') and
              		b.fecemi<=to_date('".$fechas."','dd/mm/yyyy') and
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
      	$orderby="order by lpad(b.comretltf,20,'0'),b.feccomretltf,b.cedrif,b.nomben";
      	$sqlfecha=" b.feccomretltf>=to_date('".$fecdes."','dd/mm/yyyy') and
              		b.feccomretltf<=to_date('".$fechas."','dd/mm/yyyy') and
              		(b.feccomretltf)<>to_date('','dd/mm/yyyy') and b.feccomretltf is not null and";
        $sqlcomret="b.comretltf is not null and";
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
       if($rete!="C")
       {
       	   	$sqlcompra="  a.numord=c.numord and
		              c.codtip=d.codret and
					  c.codtip=e.codtip and
					  d.codret=e.codtip";
	       if ($rete=="V"){
	       	$sqlreten="and trim(d.codrep)='001'";
	       	$reten='001';
	       }
	       elseif ($rete=="I"){
	       	$sqlreten="and trim(d.codrep)='002'";
	       	$reten='002';
	       }
	       elseif ($rete=="I"){
	       	$sqlreten="and trim(d.codrep)='003'";
	       	$reten='003';
	       }
	       $sqlfrom=",(select distinct numord, codtip from opretord ) c,tsrepret d, optipret e,tsrepret f";
       }else
       {
       		$sqlcompra="1=1";
       		$sqlfrom=" left outer join (select distinct numord, codtip from opretord ) c on (a.numord=c.numord)
       		           left outer join tsrepret d on (c.codtip=d.codret)
       		           left outer join optipret e on (d.codret=e.codtip)";
       }

     # $this->sql="$sqlempleado
	 if ($rete=="V")
	    {
         $sql="select
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
	      	  b.ctaban,b.valmon
            from
              opordpag b ,opfactur a $sqlfrom
            where
              a.numord=b.numord and
			  a.monret>0.00 and
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
				b.ctaban,b.valmon
				$orderby";
	    } 
		elseif ($rete=="I")
		{
		  $sql="select
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
	      	  b.ctaban,b.valmon
             from
              opordpag b ,opfactur a $sqlfrom
             where
              a.numord=b.numord and
			  
              $sqlfecha
              $sqlcomret
              $sqlcompra 
			  $sqlreten
			  and a.codislr=c.codtip	
              group by
				$sqlimpu2
                b.cedrif,
                b.nomben,
                b.numord,
                b.desord,
                B.FECEMI,
                a.rifalt,
				$sqlcom
				b.ctaban,b.valmon
				$orderby";
		}
                else
      {
                    $sql="select
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
	      	  b.ctaban,b.valmon
             from
              opordpag b ,opfactur a $sqlfrom
             where
              a.numord=b.numord and
	      c.codtip=f.codret and
              f.codrep='003' and
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
				b.ctaban,b.valmon
				$orderby";
		
                }
		//print "<pre>".$sql;exit();
		
$bd->actualizar("update opfactur  set totfac=totfac*-1,exeiva=exeiva *-1,basimp=basimp *-1,moniva=moniva *-1,monret=monret *-1,
      basltf=basltf *-1,monltf=monltf *-1,basislr=basislr *-1,monislr=monislr *-1,basirs=basirs *-1,monirs=monirs *-1
      where tiptra='03'");
$arrp=$bd->select($sql);
$cont=1;
$Tot_totfac=0;
$Tot_exeiva=0;
$Tot_baseimp=0;
$Tot_moniva=0;
$Tot_monret=0;
while(!$arrp->EOF)
{
    if ($rete=="V" || $rete=="C") //iva
    {
     	$base=$arrp->fields["basimp"];
     	$por=$arrp->fields["poriva"];
     	$retem=$arrp->fields["monret"];
     	$iva=$arrp->fields["moniva"];
     	$exe=$arrp->fields["exeiva"];
    }
	elseif($rete=="I") //islr
	{
	 	$base=$arrp->fields["basislr"];
	 	$por=$arrp->fields["porislr"];
	 	$retem=$arrp->fields["monislr"];
	 	$iva=0;
	 	$exe=0;
	}
	elseif($rete=="L") //ltf
	{
		$base=$arrp->fields["basltf"];
		$por=$arrp->fields["porltf"];
	 	$retem=$arrp->fields["monltf"];
	 	$iva=0;
	 	$exe=0;
	}

	if($arrp->fields["rifalt"]!='')
	{ $rifalterno=$arrp->fields["rifalt"]; }
    else
    { $rifalterno=$arrp->fields["cedrif"];}

    if($arrp->fields["rifalt"]!='')
    {
        $tb1=$bd->select("select nomben as benalterno from opbenefi where cedrif='".$arrp->fields["rifalt"]."'");
    	$benalterno=$tb1->fields["benalterno"];
    }
    else
    {
    	$benalterno=$arrp->fields["nomben"];
    }

	if($arrp->fields["cedrif"]!='')
				  {
				  	$tb1=$bd->select("select nomben as benalterno from opbenefi where cedrif='".$arrp->fields["cedrif"]."'");
					$ente=$tb1->fields["benalterno"]; }
                  else
                  { $ente="";}

    $nro=$arrp->fields["numfac"];
    if ($arrp->fields["tiptra"]=='01')
    {

    }
	if($rete=="V" || $rete=="C")
	{
		$auxfecha=split("/",$arrp->fields["fecfac"]);

        	echo 'G200045000'.chr(9).$arrp->fields["percompro"].chr(9).$auxfecha[2]."-".$auxfecha[1]."-".$auxfecha[0].chr(9).'C'.chr(9).$arrp->fields["tiptra"].chr(9).strtoupper(trim(str_replace(".","",str_replace("-","",$rifalterno)))).chr(9).$arrp->fields["numfac"].chr(9).$arrp->fields["numctr"].chr(9).number_format($arrp->fields["totfac"],2,'.','').chr(9).number_format($base,2,'.','').chr(9).number_format($retem,2,'.','').chr(9).$arrp->fields["facafe"].chr(9).$arrp->fields["comprobante"].chr(9).number_format($exe,2,'.','').chr(9).number_format($arrp->fields["poriva"],2,'.','').chr(9).'0'.chr(10);
                
	}
    elseif($rete=="I")
    {
		echo "<table>";
		echo "<tr>";
		echo "<td>".$cont."</td>";
		echo "<td>".strtoupper(trim(str_replace(".","",str_replace("-","",$rifalterno))))."</td>";
		echo "<td>".$arrp->fields["numfac"]."</td>";
		echo "<td>".$arrp->fields["numctr"]."</td>";
		echo "<td>".$arrp->fields["codtip"]."</td>";
		echo "<td>".H::formatoMonto($base*$arrp->fields["valmon"])."</td>";
		echo "<td>".H::formatoMonto($arrp->fields["porislr"])."</td>";
		echo "</tr>";
		echo "</table>";
   	}else
	{
		echo "<table>";
		echo "<tr>";
		echo "<td>".$cont."</td>";
		echo "<td>".strtoupper(trim(str_replace(".","",str_replace("-","",$rifalterno))))."</td>";
		echo "<td>".strtoupper(trim($benalterno))."</td>";
		echo "<td>".H::formatoMonto($base*$arrp->fields["valmon"])."</td>";
		echo "<td>".H::formatoMonto($retem*$arrp->fields["valmon"])."</td>";
		echo "<td>".$arrp->fields["feccomretltf"]."</td>";
		echo "<td>".$arrp->fields["numord"]."</td>";
		echo "<td>".strtoupper(trim($ente*$arrp->fields["valmon"]))."</td>";
		echo "</tr>";
		echo "</table>";
	}

    $Tot_totfac+=$arrp->fields["totfac"]*$arrp->fields["valmon"];
    $Tot_exeiva+=$exe*$arrp->fields["valmon"];
    $Tot_baseimp+=$base*$arrp->fields["valmon"];
    $Tot_moniva+=$iva*$arrp->fields["valmon"];
    $Tot_monret+=$retem*$arrp->fields["valmon"];
    $cont++;
    $arrp->MoveNext();
}
$bd->actualizar("update opfactur  set totfac=totfac*-1,exeiva=exeiva *-1,basimp=basimp *-1,moniva=moniva *-1,monret=monret *-1,
      basltf=basltf *-1,monltf=monltf *-1,basislr=basislr *-1,monislr=monislr *-1,basirs=basirs *-1,monirs=monirs *-1
      where tiptra='03'");  
$bd->closed();
?>
