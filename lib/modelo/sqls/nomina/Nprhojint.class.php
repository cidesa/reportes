<?Php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprhojint extends baseClases
{
    function sqlp($codesde,$codhasta)
    {
        $sql = "SELECT 
							A.CODEMP as codemp,          
							A.NOMEMP as nomemp,         
							A.CEDEMP as cedemp,         
							A.NUMCON as numcon,         
							(CASE WHEN A.EDOCIV='V' THEN 'Soltero' WHEN A.EDOCIV='C' THEN 'Casado' WHEN A.EDOCIV='D' THEN 'Divorciado' WHEN A.EDOCIV='V' THEN 'Viudo' ELSE 'Otros' END) as edociv,         
							(CASE WHEN A.NACEMP='V' THEN 'Venezolano' ELSE 'Extranjero' END) as nacemp,         
							(CASE WHEN A.SEXEMP='F' THEN 'Femenino' ELSE 'Masculino' END) as sexemp,         
							to_char(A.FECNAC,'dd/mm/yyyy') as fecnac,         
							A.EDAEMP as edaemp,         
							A.LUGNAC as lugnac,         
							substr(A.DIRHAB,1,45) as dirhab,         
							A.CODCIU as codciu,         
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
							A.FECADMPUB as fecadmpub,      
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
							(CASE WHEN A.TIEFID='S' THEN 'Si' ELSE 'No' END) as tipo        
						FROM NPHOJINT A
						WHERE
							A.CODEMP >= '$codesde' AND
							A.CODEMP <= '$codhasta' 
						ORDER BY A.CODEMP";
		//print "<pre>".$sql;exit;
        return $this->select($sql);
    }
}

?>
