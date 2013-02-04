<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprdefcpt extends baseClases
{
    function sql($codcon1,$codcon2)
    {
        $sql = "SELECT codcon,
									(CASE WHEN trim(opecon)='A' THEN 'ASIGNACION' WHEN trim(opecon)='D' THEN 'DEDUCCION' WHEN trim(opecon)='P' THEN 'APORTE' END)  as opecon,
									nomcon,
									codpar,
									(CASE WHEN acuhis='S' THEN 'SI' WHEN acuhis='N' THEN 'NO' END) as acuhis,
									(CASE WHEN inimon='S' THEN 'SI' WHEN inimon='N' THEN 'NO' END) as inimon,
									(CASE WHEN conact='S' THEN 'SI' WHEN conact='N' THEN 'NO' END) as conact,
									(CASE WHEN impcpt='S' THEN 'SI' WHEN impcpt='N' THEN 'NO' END) as impcpt,
									(CASE WHEN afepre='S' THEN 'SI' WHEN afepre='N' THEN 'NO' END) as afepre,									ordpag,
									nrocta
									FROM npdefcpt
						      WHERE
							        codcon Between  '$codcon1' AND '$codcon2'
							  ORDER BY
							  codcon";

        return $this->select($sql);

    }
}
?>
