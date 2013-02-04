<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprrescurri extends baseClases
{

    function sql($codesde, $codhasta)
    {
        $sql = "SELECT
    						distinct	A.CODEMP as codemp,
    							A.NOMEMP as nomemp,
    							A.CEDEMP as cedemp,
    							A.NUMCON as numcon, B.nomcar as nomcar,
    							(CASE WHEN A.EDOCIV='S' THEN 'Soltero' WHEN A.EDOCIV='C' THEN 'Casado' WHEN A.EDOCIV='D' THEN 'Divorciado' WHEN A.EDOCIV='V' THEN 'Viudo' ELSE '' END) as edociv,
    							(CASE WHEN A.NACEMP='V' THEN 'Venezolano' ELSE 'Extranjero' END) as nacemp,
    							(CASE WHEN A.SEXEMP='F' THEN 'Femenino' ELSE 'Masculino' END) as sexemp,
    							to_char(A.FECNAC,'dd/mm/yyyy') as fecnac,
    							Extract(year from age(now(),A.FECNAC)) as edaemp,
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
    							B.nomcat as ubica
    						FROM NPHOJINT A, NPASICAREMP B--, NPPAIS C
    						WHERE
    							A.CODEMP >= '$codesde' AND
    							A.CODEMP <= '$codhasta' AND A.codemp=B.codemp --and A.CODPAI=C.CODPAI
    						ORDER BY A.CODEMP";
    
        return $this->select($sql);
    }
    function sql2($tbcodemp)
    {
        $sql = "select antpub_e('A',codemp,date(now()),'S') as ano,
    							antpub_e('M',codemp,date(now()),'S') as mes,
    							antpub_e('D',codemp,date(now()),'S') as dias
    							from nphojint
    							where codemp='$tbcodemp'";
    
        return $this->select($sql);
    }
    function sql222($tbcodemp)
    {
        $sql = "select antpub('A',codemp,date(now()),'S') as ano,
    							antpub('M',codemp,date(now()),'S') as mes,
    							antpub('D',codemp,date(now()),'S') as dias
    							from nphojint
    							where codemp='$tbcodemp'";
    
        return $this->select($sql);
    }
    
    function tbInfFam($tbcodemp)
    {
        $sql = "SELECT A.CEDFAM as cedfam,
    							A.NOMFAM as nomfam,
    							(CASE WHEN A.SEXFAM ='F' THEN 'Femenino' ELSE 'Masculino' END) as sexfam,
    							to_char(A.FECNAC,'dd/mm/yyyy') as fecnac,
    						    Extract(year from age(now(),A.FECNAC)) as edafam,
    							A.PARFAM as parfam,
    							(CASE WHEN A.SEGHCM ='S' THEN 'SI' ELSE 'NO' END) as seghcm,
    							C.DESPAR as despar
    						FROM
    							NPINFFAM A, NPTIPPAR C
    						WHERE
    							A.PARFAM = C.TIPPAR AND
    							A.CODEMP = '$tbcodemp'
    						ORDER BY A.CEDFAM";
    
        return $this->select($sql);
    }
    
    function tbInfCurr($tbcodemp)
    {
        $sql = "SELECT
    							CODEMP as codemp,
    							NOMTIT as nomtit,
    							DESCUR as descur,
    							INSTIT as instit,
    							DURCUR as durcur,
    							anocul
    							--to_char(feccur,'dd/mm/yyyy') as feccur
    						FROM
    							NPINFCUR
    						WHERE
    							CODEMP = '$tbcodemp'
    						ORDER BY CODEMP";
    
        return $this->select($sql);
    }
    
    function tbExpLab($tbcodemp)
    {
        $sql = "SELECT  coalesce (NOMEMP,'CIDE,SA') as EMPRESA,
    						CODCAR,
    						DESCAR,
    						to_char(FECINI,'dd/mm/yyyy') as fecini,
    						to_char(FECTER,'dd/mm/yyyy') as fecter, SUBSTR(fecter,1,4) as ano,
    						SUEOBT,
    						STACAR
    						FROM
    							NPEXPLAB
    						WHERE
    							CODEMP = '$tbcodemp'  and fecter is not null
    						ORDER BY ano desc";
        return $this->select($sql);
    }
}

?>
