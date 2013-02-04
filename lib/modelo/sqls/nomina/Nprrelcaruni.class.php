<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprrelcaruni extends baseClases
{

    function sql1($emp1,$emp2,$cod1,$cod2,$nom)
    {
        $sql = "select distinct(b.codcat) as codpre, d.nomcat as nompre
						from npnomcal a,npasicaremp b,npdefcpt c,npcatpre d
						where
						d.codcat=b.codcat and
						a.codemp >= '$emp1' and a.codemp <= '$emp2' and
						a.codcon >= '$cod1' and a.codcon <= '$cod2' and
						a.codnom = '$nom' and
						b.codemp=a.codemp and b.codcar=a.codcar and c.codcon=a.codcon and
						b.status='V' and
						impcpt = 'S' and opecon <> 'P' and a.saldo>0 and a.codcon<>'XXX'
						and a.codcon not in (select codcon from npconceptoscategoria)
						order by b.codcat";
        //print "<pre>".$sql;exit;
        return $this->select($sql);
    }

    function sql2($codcar,$codpre,$emp1,$emp2,$cod1,$cod2,$nom)
    {
        $sql = "select distinct(b.codemp) as codemp
						from npnomcal a,npasicaremp b,npdefcpt c,npcatpre d
						where
						b.codcar='$codcar' and
						b.codcat='$codpre' and
						d.codcat=b.codcat and
						a.codemp >= '$emp1' and a.codemp <= '$emp2' and
						a.codcon >= '$cod1' and a.codcon <= '$cod2' and
						a.codnom = '$nom' and
						b.codemp=a.codemp and b.codcar=a.codcar and c.codcon=a.codcon and
						b.status='V' and
						impcpt = 'S' and opecon <> 'P' and a.saldo>0 and a.codcon<>'XXX'
						and a.codcon not in (select codcon from npconceptoscategoria)
						order by b.codemp";
        //print "<pre>".$sql;exit;
        return $this->select($sql);
    }
	
	function sql3($nom)
    {
        $sql = "select codnom, nomnom, to_char(ultfec,'dd/mm/yyyy') as ultfec,
						 to_char(profec,'dd/mm/yyyy') as profec
						 from npnomina
						 where codnom='$nom'";
        //print "<pre>".$sql;exit;
        return $this->select($sql);
    }

    function sql4($codpre,$emp1,$emp2,$cod1,$cod2,$nom)
    {
        $sql = "select distinct(b.codemp) as codemp
								from npnomcal a,npasicaremp b,npdefcpt c,npcatpre d
								where

								b.codcat='$codpre' and
								d.codcat=b.codcat and
								a.codemp >= '$emp1' and a.codemp <= '$emp2' and
								a.codcon >= '$cod1' and a.codcon <= '$cod2' and
								a.codnom = '$nom' and
								b.codemp=a.codemp and b.codcar=a.codcar and c.codcon=a.codcon and
								b.status='V' and
								impcpt = 'S' and opecon <> 'P' and a.saldo>0 and a.codcon<>'XXX'
								and a.codcon not in (select codcon from npconceptoscategoria)
								order by b.codemp";
        //print "<pre>".$sql;exit;
        return $this->select($sql);
    }

    function sql5($codpre,$emp1,$emp2,$cod1,$cod2,$nom)
    {
        $sql = "select distinct(b.codcar) as codcar,b.nomcar as nomcar
						from npnomcal a,npasicaremp b,npdefcpt c,npcatpre d
						where
						b.codcat='$codpre' and
						d.codcat=b.codcat and
						a.codemp >= '$emp1' and a.codemp <= '$emp2' and
						a.codcon >= '$cod1' and a.codcon <= '$cod2' and
						a.codnom = '$nom' and
						b.codemp=a.codemp and b.codcar=a.codcar and c.codcon=a.codcon and
						b.status='V' and
						impcpt = 'S' and opecon <> 'P' and a.saldo>0 and a.codcon<>'XXX'
						and a.codcon not in (select codcon from npconceptoscategoria)
						order by b.codcar";
        //print "<pre>".$sql;exit;
        return $this->select($sql);
    }
}
?>
