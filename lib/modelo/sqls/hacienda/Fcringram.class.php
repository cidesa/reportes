<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcringram extends baseClases
{
	function sqlp($status,$caj,$fecdes,$fechas,$cajdesde,$cajhasta)
	{

					if ($status=='G' and $caj=='T' ){

				$this->sql= "select b.fueing, c.fueing as fuente, substr(b.nomfue,1,40) as nomfue, b.fueing as codprei,
						sum(case when c.numpag is null then a.monpag else c.monpag end) as monpag
						from fcpagos a,fcfuepre b,fcdecpag c
						where
						a.fecpag>=to_date('".$fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$cajhasta."')
						and coalesce(a.edopag,' ')<>'A'
						and a.numpag=c.numpag
						and coalesce(a.edopag,' ')<>'P'
						and c.fueing=b.codfue
						group by b.codprei,b.fueing,b.nomfue,c.fueing
						union
						select b.fueing, d.fueing as fuente, 'abonos a '||d.nomfue, d.codprei,
						sum(a.monpag) as monpag
						from fcpagos a right outer join fcdecpag c on (a.numpag=c.numpag) ,fcabonos b,fcfuepre d
						where
						 a.fecpag>=to_date('".$fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$fechas."','dd/mm/yyyy')
						 and rtrim(a.funpag)>=rtrim('".$cajdesde."')
						 and rtrim(a.funpag)<=rtrim('".$cajhasta."')
						 and coalesce(a.edopag,' ')<>'A'
						 and a.numpag=b.numpag2
						 and b.fueing=d.codfue
						 group by b.fueing,d.fueing,'abonos a '||d.nomfue,d.codprei";
						 //print $this->sql;exit;
			}

			if ($status=='G' and $caj=='V' ){
				$this->sql= "select b.fueing, c.fueing as fuente, substr(b.nomfue,1,40) as nomfue, b.fueing as codprei,
						sum(case when c.numpag is null then a.monpag else c.monpag end) as monpag
						from fcpagos a,fcfuepre b,fcdecpag c
						where
						a.fecpag>=to_date('".$fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$cajhasta."')
						and coalesce(a.edopag,' ')='V'
						and a.numpag=c.numpag
						and coalesce(a.edopag,' ')<>'P'
						and c.fueing=b.codfue
						group by b.codprei,b.fueing,b.nomfue,c.fueing
						union
						select b.fueing, d.fueing as fuente, 'abonos a '||d.nomfue, d.codprei,
						sum(a.monpag) as monpag
						from fcpagos a right outer join fcdecpag c on (a.numpag=c.numpag) ,fcabonos b,fcfuepre d
						where
						 a.fecpag>=to_date('".$fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$fechas."','dd/mm/yyyy')
						 and rtrim(a.funpag)>=rtrim('".$cajdesde."')
						 and rtrim(a.funpag)<=rtrim('".$cajhasta."')
						 and coalesce(a.edopag,' ')='V'
						 and a.numpag=b.numpag2
						 and b.fueing=d.codfue
						 group by b.fueing,d.fueing,'abonos a '||d.nomfue,d.codprei";
						 //print $this->sql;exit;
			}

			if ($status=='G' and $caj=='NV' ){
				$this->sql= "select b.fueing, c.fueing as fuente, substr(b.nomfue,1,40) as nomfue, b.fueing as codprei,
						sum(case when c.numpag is null then a.monpag else c.monpag end) as monpag
						from fcpagos a,fcfuepre b,fcdecpag c
						where
						a.fecpag>=to_date('".$fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$cajhasta."')
						and a.edopag IS NULL
						and a.numpag=c.numpag
						and coalesce(a.edopag,' ')<>'P'
						and c.fueing=b.codfue
						group by b.codprei,b.fueing,b.nomfue,c.fueing
						union
						select b.fueing, d.fueing as fuente, 'abonos a '||d.nomfue, d.codprei,
						sum(a.monpag) as monpag
						from fcpagos a right outer join fcdecpag c on (a.numpag=c.numpag) ,fcabonos b,fcfuepre d
						where
						a.fecpag>=to_date('".$fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$this->cajhasta."')
						and a.edopag IS NULL
						and a.numpag=b.numpag2
						and b.fueing=d.codfue
						group by b.fueing,d.fueing,'abonos a '||d.nomfue,d.codprei";
			}

			if ($this->status<>'G'){

				if($this->caj=='T'){

				$this->sql= "select b.fueing, c.fueing as fuente, substr(b.nomfue,1,40) as nomfue, b.fueing as codprei,
						sum(case when c.numpag is null then a.monpag else c.monpag end) as monpag
						from fcpagos a,fcfuepre b,fcdecpag c
						where
						a.fecpag>=to_date('".$this->fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$this->fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$this->cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$this->cajhasta."')
						and coalesce(a.edopag,' ')<>'A'
						and a.numpag=c.numpag
						and coalesce(a.edopag,' ')<>'P'
						and c.fueing=b.codfue
						and b.tipfue=('".$this->status."')
						group by b.codprei,b.fueing,b.nomfue,c.fueing
						union
						select b.fueing, d.fueing as fuente, 'abonos a '||d.nomfue, d.codprei,
						sum(a.monpag) as monpag
						from fcpagos a right outer join fcdecpag c on (a.numpag=c.numpag) ,fcabonos b,fcfuepre d
						where
						 a.fecpag>=to_date('".$this->fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$this->fechas."','dd/mm/yyyy')
						 and rtrim(a.funpag)>=rtrim('".$this->cajdesde."')
						 and rtrim(a.funpag)<=rtrim('".$this->cajhasta."')
						 and coalesce(a.edopag,' ')<>'A'
						 and a.numpag=b.numpag2
						 and b.fueing=d.codfue
						 and d.tipfue=('".$this->status."')
						 group by b.fueing,d.fueing,'abonos a '||d.nomfue,d.codprei";
						 //print $this->sql;exit;
				}
				if($this->caj=='V'){
				$this->sql= "select b.fueing, c.fueing as fuente, substr(b.nomfue,1,40) as nomfue, b.fueing as codprei,
						sum(case when c.numpag is null then a.monpag else c.monpag end) as monpag
						from fcpagos a,fcfuepre b,fcdecpag c
						where
						a.fecpag>=to_date('".$this->fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$this->fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$this->cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$this->cajhasta."')
						and coalesce(a.edopag,' ')='V'
						and a.numpag=c.numpag
						and coalesce(a.edopag,' ')<>'P'
						and c.fueing=b.codfue
						and b.tipfue=('".$this->status."')
						group by b.codprei,b.fueing,b.nomfue,c.fueing
						union
						select b.fueing, d.fueing as fuente, 'abonos a '||d.nomfue, d.codprei,
						sum(a.monpag) as monpag
						from fcpagos a right outer join fcdecpag c on (a.numpag=c.numpag) ,fcabonos b,fcfuepre d
						where
						 a.fecpag>=to_date('".$this->fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$this->fechas."','dd/mm/yyyy')
						 and rtrim(a.funpag)>=rtrim('".$this->cajdesde."')
						 and rtrim(a.funpag)<=rtrim('".$this->cajhasta."')
						 and coalesce(a.edopag,' ')='V'
						 and a.numpag=b.numpag2
						 and b.fueing=d.codfue
						 and d.tipfue=('".$this->status."')
						 group by b.fueing,d.fueing,'abonos a '||d.nomfue,d.codprei";
				}
				if($this->caj=='NV'){
				$this->sql= "select b.fueing, c.fueing as fuente, substr(b.nomfue,1,40) as nomfue, b.fueing as codprei,
						sum(case when c.numpag is null then a.monpag else c.monpag end) as monpag
						from fcpagos a,fcfuepre b,fcdecpag c
						where
						a.fecpag>=to_date('".$this->fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$this->fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$this->cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$this->cajhasta."')
						and a.edopag IS NULL
						and a.numpag=c.numpag
						and coalesce(a.edopag,' ')<>'P'
						and c.fueing=b.codfue
						and b.tipfue=('".$this->status."')
						group by b.codprei,b.fueing,b.nomfue,c.fueing
						union
						select b.fueing, d.fueing as fuente, 'abonos a '||d.nomfue, d.codprei,
						sum(a.monpag) as monpag
						from fcpagos a right outer join fcdecpag c on (a.numpag=c.numpag) ,fcabonos b,fcfuepre d
						where
						a.fecpag>=to_date('".$this->fecdes."','dd/mm/yyyy')
						and a.fecpag<=to_date('".$this->fechas."','dd/mm/yyyy')
						and rtrim(a.funpag)>=rtrim('".$this->cajdesde."')
						and rtrim(a.funpag)<=rtrim('".$this->cajhasta."')
						and a.edopag IS NULL
						and a.numpag=b.numpag2
						and b.fueing=d.codfue
						and d.tipfue=('".$this->status."')
						group by b.fueing,d.fueing,'abonos a '||d.nomfue,d.codprei";
				}
			}
		//H::PrintR($this->sql);exit;
		return $this->select($this->sql);

		}

}
?>