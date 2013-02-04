<?php
require_once("../../lib/modelo/baseClases.class.php");

class Carcatart extends baseClases
{
	function sqlp($coddes,$codhas,$coddesex,$codhasex)
	{

$sql= "SELECT
A.CODART,
A.DESART,
A.CODCTA,
A.CODPAR,
A.EXITOT,
A.UNIMED,
A.PREART
FROM CAREGART A
WHERE
A.CODART >= '".$coddes."' AND
A.CODART <= '".$codhas."' AND
A.EXITOT >= ".$coddesex." AND
A.EXITOT <= ".$codhasex."
ORDER BY A.CODART";
//H::PrintR($sql);
return $this->select($sql);
	}

}
?>
