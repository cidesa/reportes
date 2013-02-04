<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fctasban extends BaseClases
{

	function sqlp($CODDES,$CODHAS)
  {
  	  $sql="SELECT DISTINCT TASANO AS TASANO
	        FROM
        	   FCTASBAN
	           WHERE

	   TASANO >='".$CODDES."' AND
	   TASANO <= '".$CODHAS."'
       order by TASANO ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }

  function sqlp1($tasano)
  {
  	  $sql="SELECT  taspor AS tasa
	   FROM
	   	FCTASBAN
	   		WHERE
	   TASANO ='".$tasano."'
       order by taspor ";// H::PrintR($sql);exit;

	return $this->select($sql);
  }

}