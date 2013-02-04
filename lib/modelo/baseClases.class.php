<?php
/**
 * Clase Base para conexión a base de datos.
 *
 * @author     Grupo Desarrollo Cidesa <desarrollo@cidesa.com.ve>
 * @version    SVN: $Id: $
 * @copyright  Copyright 2008, Cidesa C.A.
 *
 */
 require_once("../../lib/bd/basedatosAdo.php");

 class baseClases
 {
 	protected $bd="";

     function __construct()
     {
        $this->bd=new basedatosAdo();

     }

   function __destruct() {
          $this->bd->closed();
   }

   function select($sql)
	{
		 $rs=$this->bd->select($sql);
		 if ($rs)
		 {
                     if(get_class($rs)=='ADORecordSet_empty') return array();
		 	else return $rs->GetArray();
		 }else{
		 	return array();
		 }
	}
        
   function selectrecordset($sql)
	{
		 $rs=$this->bd->select($sql);
		 if ($rs)
		 {
		 	return $rs;
		 }else{
		 	return null;
		 }
	}     

   function actualizar($sql)
    {
      $rs=$this->bd->actualizar($sql);
    }
}
 
