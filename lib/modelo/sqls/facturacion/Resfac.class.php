<?php
require_once("../../lib/modelo/baseClases.class.php");

class Resfac extends baseClases
{
	function sqlp($conddes,$condhas,$fecdes,$fechas,$estatus,$caso)
	{

       //print $caso;exit;
       if ($caso == 1)
       {
       	 $sql = "SELECT A.REFFAC as reffac,
              to_char(C.FECFAC,'dd/mm/yyyy') as fecfac,
              C.FECANU as fecanu,
              E.NOMPRO as nomcli,
    (CASE WHEN C.STATUS = 'A' THEN 'Activa' WHEN C.STATUS = 'N' THEN 'Anulada' ELSE 'Ambas' END) as status,
              SUM(CASE WHEN MONRGO = 0 THEN 0 ELSE CANTOT*PRECIO END) as CONIVA,
              SUM((CASE WHEN MONRGO = 0 THEN CANTOT*PRECIO ELSE 0 END)) as SINIVA,
              COALESCE(B.DESCUENTO,0) as descuento,
              SUM(MONRGO) as IVA,
              MONFAC as monfac
FROM   FAARTFAC A LEFT OUTER JOIN (SELECT SUM(MONDESC) as DESCUENTO,REFDOC FROM FADESCART GROUP BY REFDOC) B ON A.REFFAC=B.REFDOC,
             FAFACTUR C,CACONPAG D,FACLIENTE E,CAREGART F

WHERE  A.REFFAC=C.REFFAC AND
               C.CODCONPAG=D.CODCONPAG AND
               C.CODCLI=E.CODPRO AND
                              C.FECFAC>= '".$fecdes."' AND
               C.FECFAC<= '".$fechas."' AND
               --(C.STATUS = :STA1 OR               C.STATUS = :STA2) AND
               D.CODCONPAG>= '".$conddes."' AND
               D.CODCONPAG<= '".$condhas."' AND
               A.CODART=F.CODART
GROUP BY A.REFFAC,C.FECFAC,E.NOMPRO,MONFAC,DESCONPAG,B.DESCUENTO,C.FECANU,(CASE WHEN C.STATUS = 'A' THEN 'Activa' WHEN C.STATUS = 'N' THEN 'Anulada' ELSE 'Ambas' END)
";
       }
     else
       {
       	 $sql = "SELECT A.REFFAC as reffac,
              to_char(C.FECFAC,'dd/mm/yyyy') as fecfac,
              C.FECANU as fecanu,
              E.NOMPRO as nomcli,
    (CASE WHEN C.STATUS = 'A' THEN 'Activa' WHEN C.STATUS = 'N' THEN 'Anulada' ELSE 'Ambas' END) as status,
              SUM(CASE WHEN MONRGO = 0 THEN 0 ELSE CANTOT*PRECIO END) as CONIVA,
              SUM((CASE WHEN MONRGO = 0 THEN CANTOT*PRECIO ELSE 0 END)) as SINIVA,
              COALESCE(B.DESCUENTO,0) as descuento,
              SUM(MONRGO) as IVA,
              MONFAC as monfac
FROM   FAARTFAC A LEFT OUTER JOIN (SELECT SUM(MONDESC) as DESCUENTO,REFDOC FROM FADESCART GROUP BY REFDOC) B ON A.REFFAC=B.REFDOC,
             FAFACTUR C,CACONPAG D,FACLIENTE E,CAREGART F

WHERE  A.REFFAC=C.REFFAC AND
               C.CODCONPAG=D.CODCONPAG AND
               C.CODCLI=E.CODPRO AND
                              C.FECFAC>= '".$fecdes."' AND
               C.FECFAC<= '".$fechas."' AND
               C.STATUS = '".$estatus."' AND
               D.CODCONPAG>= '".$conddes."' AND
               D.CODCONPAG<= '".$condhas."' AND
               A.CODART=F.CODART
GROUP BY A.REFFAC,C.FECFAC,E.NOMPRO,MONFAC,DESCONPAG,B.DESCUENTO,C.FECANU,(CASE WHEN C.STATUS = 'A' THEN 'Activa' WHEN C.STATUS = 'N' THEN 'Anulada' ELSE 'Ambas' END)
";
       }






		//H::PrintR($sql);exit;
		return $this->select($sql);
	}
//'".$codart."'"

    function datos($codigo){
    	$sql = "SELECT DESCONPAG AS DESPAG FROM CACONPAG WHERE CODCONPAG='".$codigo."';";
    	//H::PrintR($sql);
    	return $this->select ($sql);
    	}



}
?>