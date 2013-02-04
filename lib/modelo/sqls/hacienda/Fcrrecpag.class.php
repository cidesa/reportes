<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrrecpag extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql= "select
            a.numpag,
            a.edopag,
            to_char(a.fecpag,'dd/mm/yyyy') as fecpag,
            a.rifcon,
            a.monpag,
            a.monefe,
            a.despag,
            (case when rtrim(coalesce(a.nomcon,' '))<>'' then a.nomcon
			else b.nomcon end) as nomcon,
			(case when rtrim(coalesce(a.dircon,' '))<>'' then a.dircon
            else b.dircon end) as dircon,
            b.telcon,
            sum(c.mondec) as mondec,
            sum(c.monpag) as pago,
            to_char(c.fecven,'yyyy') as fecven,
            c.numref,
            c.numdec,
            max(d.nombre) as nombre,
            sum(d.mondec) as monrec,
            sum(d.mora) as mora,
            d.fueing,
            e.nomabr,
            e.nomfue
            from fcpagos a, fcconrep b,fcdecpag c,fcdeclar d, fcfuepre e
            where    a.numpag>=lpad('".$CODDES."',10,'0') and
                     a.numpag<=lpad('".$CODHAS."',10,'0') and
			         a.numpag=c.numpag and
                     c.numdec=d.numdec and
                     c.numref=d.numref and
                     c.fecven=d.fecven and
                     c.numero=d.numero and
                     c.fueing=d.fueing and
                     d.fueing=e.codfue and
                     a.rifcon=b.rifcon and
                     d.edodec='P'
            group by
            a.numpag,
            a.edopag,
            a.fecpag,
            a.rifcon,
            a.monpag,
            a.monefe,
            a.despag,
            (case when rtrim(coalesce(a.nomcon,' '))<>'' then a.nomcon
			else b.nomcon end),
			(case when rtrim(coalesce(a.dircon,' '))<>'' then a.dircon
            else b.dircon end),
            b.telcon,
            to_char(c.fecven,'yyyy'),
            c.numref,
            c.numdec,
            d.fueing,
            e.nomabr,
            e.nomfue
            order by a.numpag,d.fueing,c.numref,to_char(c.fecven,'yyyy') ";//H::PrintR($sql);exit;

	return $this->select($sql);
  }

  	function sqlp1($CODDES,$CODHAS,$NUMPAG)
  {
  	  $sql= "select
            a.numpag,
            a.edopag,
            to_char(a.fecpag,'dd/mm/yyyy') as fecpag,
            a.rifcon,
            a.monpag,
            a.monefe,
            a.despag,
            (case when coalesce(a.nomcon,' ')<>' ' then a.nomcon
			else b.nomcon end) as nomcon,
			(case when coalesce(a.dircon,' ')<>' ' then a.dircon
            else b.dircon end) as dircon,
            b.telcon,
            sum(c.mondec) as mondec,
            sum(c.monpag) as pago,
            to_char(c.fecven,'yyyy') as fecven,
            c.numref,
            c.numdec,
            max(d.nombre) as nombre,
            sum(d.mondec) as monrec,
            sum(d.mora) as mora,
            d.fueing,
            e.nomabr,
            e.nomfue
            from fcpagos a, fcconrep b,fcdecpag c,fcdeclar d, fcfuepre e
            where   a.numpag=c.numpag and
            		a.numpag= ('".$NUMPAG."')and
                     c.numdec=d.numdec and
                     c.numref=d.numref and
                     c.fecven=d.fecven and
                     c.numero=d.numero and
                     c.fueing=d.fueing and
                     d.fueing=e.codfue and
                     a.rifcon=b.rifcon and
                     d.edodec='P' and
                     a.numpag>=lpad('".$CODDES."',10,'0') and
                     a.numpag<=lpad('".$CODHAS."',10,'0')
            group by
            a.numpag,
            a.edopag,
            a.fecpag,
            a.rifcon,
            a.monpag,
            a.monefe,
            a.despag,
            (case when coalesce(a.nomcon,' ')<>' ' then a.nomcon
			else b.nomcon end),
			(case when coalesce(a.dircon,' ')<>' ' then a.dircon
            else b.dircon end),
            b.telcon,
            to_char(c.fecven,'yyyy'),
            c.numref,
            c.numdec,
            d.fueing,
            e.nomabr,
            e.nomfue
            order by a.numpag,d.fueing,c.numref,to_char(c.fecven,'yyyy')";//H::PrintR($sql);exit;

	return $this->select($sql);
  }

}
