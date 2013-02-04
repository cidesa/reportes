<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SIGA Reportes</title>
<link href="../../lib/css/siga.css" rel="stylesheet" type="text/css">
<link href="../../lib/css/datepickercontrol.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../../lib/general/datepickercontrol.js"></script>
</head>
<body>
<?
require_once("../../lib/bd/basedatosAdo.php");
$bd=new basedatosAdo();

function LlenarTextoSql($sql,$campo1,$con)
  {
     $tb=$con->select($sql);
	 if (!$tb->EOF)
	 {
	   print $tb->fields[$campo1];    
	 }
	 else
	 {
	   print "";  
	 }
  }
?>
     

<form name="form1" method="post" action="">
  <table width="760" height="40"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
    <tr> 
      <td width="190" rowspan="2" bgcolor="#003399" class="cell_left_line02"><img src="../../img/tl_logo_01.gif" width="190" height="40" border="0"></a></td>
      <td colspan="2" class="cell_date" align="right">
		<? 
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
		$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$me=$mes[date('n')];
		echo $dias[date('w')].strftime(", %d de $me del %Y")."<br>"; 
		?>          
		</td>
    </tr>
    <tr> 
      <td width="313">&nbsp; </td>
      <td width="257" align="right" valign="middle" class="cell_logout">&nbsp;</td>
    </tr>
  </table>
  <table width="760"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr> 
      <td width="6" align="left" valign="top" class="cell_left_line02"><img src="../../img/center02_tl.gif" width="6" height="6"></td>
      <td rowspan="2" valign="top" class="cell_padding_01"> <p class="breadcrumb">Reportes 
        </p>
        <fieldset>
       
        <div align="left">&nbsp; 
          <table width="670"  border="0" align="center" cellspacing="0" bordercolor="#6699CC" class="grid_line01_tl">
            <tr bordercolor="#FFFFFF"> 
              <td colspan="3" class="form_label_01"> <div align="center"> <font color="#000066" size="4"><strong>APORTES 
                  PATRONALES x CATEGORIA 
                  <input name="titulo" type="hidden" id="titulo">
                  </strong></font></div></td>
            </tr>
            <tr bordercolor="#FFFFFF"> 
              <td class="form_label_01">&nbsp;</td>
              <td>&nbsp;</td>
              <td><font color="#00FFCC">&nbsp; </font></td>
            </tr>
            <tr bordercolor="#6699CC"> 
              <td width="300" class="form_label_01" ><strong>Tama&ntilde;o Hoja:</strong></td>
              <td width="166"> <input name="tamano" type="text" class="breadcrumb" id="tamano" readonly="true"></td>
              <td width="197">&nbsp;</td>
            </tr>
            <tr bordercolor="#6699CC"> 
              <td height="24" class="form_label_01"><strong>Orientaci&oacute;n:</strong></td>
              <td> <input name="orientacion" type="text" class="breadcrumb" id="orientacion" readonly="true"></td>
              <td> <div align="right"> </div></td>
            </tr>
            <tr bordercolor="#6699CC"> 
              <td class="form_label_01"> <div align="left"><strong>Salida del 
                  Reporte:</strong></div></td>
              <td> <div align="left"> </div>
                <div align="left"> <strong> 
                  <input name="radiobutton" type="radio" class="breadcrumb" value="radiobutton" checked>
                  PANTALLA</strong></div></td>
              <td> <strong> 
                <input name="radiobutton" type="radio" class="breadcrumb" value="radiobutton">
                IMPRESORA</strong></td>
            </tr>
            <tr bordercolor="#FFFFFF"> 
              <td class="form_label_01">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr bordercolor="#FFFFFF"> 
              <td colspan="3" class="form_label_01"> <div align="center"><font color="#000066" size="3"><strong><em>Criterios 
                  de Selecci&oacute;n</em></strong></font></div></td>
            </tr>
            <tr bordercolor="#6699CC"> 
              <td bordercolor="#FFFFFF" class="form_label_01">&nbsp;</td>
              <td><strong>DESDE</strong></td>
              <td><strong>HASTA</strong></td>
            </tr>
            
            <tr> 
                       
               <tr> 
              <td class="form_label_01"> <div align="left"><strong>Tipo: Aporte/Retencion: </strong> </div></td>
               <td> <div align="left">
                 	<input name="apor1" type="text" class="breadcrumb" id="apor1" 
                value="<?$sql="select min(codtipapo) as codtipapo from nptipaportes";
 					LlenarTextoSql($sql,"codtipapo",$bd); ?>" size ="20">
 					 <input type="button" name="Button1" value="..." onClick="catalogo('apor1');">
                </div></td>
                
       			<td > <div align="left">
                 	<input name="apor2" type="text" class="breadcrumb" id="apor2" 
                value="<?$sql="select max(codtipapo) as codtipapo from nptipaportes";
 					LlenarTextoSql($sql,"codtipapo",$bd); ?>" size ="20">
 					 <input type="button" name="Button2" value="..." onClick="catalogo('apor2');">
                </div></td>              
            </tr>
            
            
             </tr>
            <tr> 
              <td class="form_label_01"> <div align="left"><strong>Codigo Empleado:</strong></div></td>
                <td > <div align="left">
                   	<input name="emp1" type="text" class="breadcrumb" id="emp1" 
                value="<?$sql="select min(codemp) as codemp from NPASICAREMP";
 					LlenarTextoSql($sql,"codemp",$bd); ?>" size ="20">
 					 <input type="button" name="Button3" value="..." onClick="catalogo3('emp1');">
                </div></td>
                
               <td >  <div align="left">
                   	<input name="emp2" type="text" class="breadcrumb" id="emp2" 
                value="<?$sql="select max(codemp) as codemp from NPASICAREMP";
 					LlenarTextoSql($sql,"codemp",$bd); ?>" size ="20">
 					 <input type="button" name="Button4" value="..." onClick="catalogo3('emp2');">
                </div></td>
            </tr>
            
            
            
            </tr>
            <tr> 
              <td class="form_label_01"> <div align="left"><strong>Codigo Categoria:</strong></div></td>
                <td > <div align="left">
                   	<input name="cat1" type="text" class="breadcrumb" id="cat1" 
                value="<?$sql="select min(codcat) as codcat from npcatpre";
 					LlenarTextoSql($sql,"codcat",$bd); ?>" size ="20">
 					 <input type="button" name="Button9" value="..." onClick="catalogo5('cat1');">
                </div></td>
                
               <td >  <div align="left">
                   	<input name="cat2" type="text" class="breadcrumb" id="cat2" 
                value="<?$sql="select max(codcat) as codcat from npcatpre";
 					LlenarTextoSql($sql,"codcat",$bd); ?>" size ="20">
 					 <input type="button" name="Button10" value="..." onClick="catalogo5('cat2');">
                </div></td>
            </tr>
                    
             <td class="form_label_01"> <div align="left"><strong>Tipo Nomina:</strong></div></td>
              <td>  <div align="left">
                   	<input name="nom" type="text" class="breadcrumb" id="nom" 
                value="<?$sql="select min(codnom) as codnom from npnomina";
 					LlenarTextoSql($sql,"codnom",$bd); ?>" size ="20">
 					 <input type="button" name="Button5" value="..." onClick="catalogo4('nom');">
                </div></td>
                
            </tr>
           
                      
            <tr bordercolor="#FFFFFF"> 
              <td class="form_label_01"><input name="sqls" type="hidden" id="sqls"></td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr bordercolor="#FFFFFF"> 
              <td class="form_label_01">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
          </table>
        </div>
        <div align="left">&nbsp; </div>
        </fieldset>
        <table width="356"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
          <tr> 
            <td width="38" rowspan="3" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="258"><img src="../../img/box01_tl.gif" width="6" height="6"></td>
            <td width="60" align="right"><img src="../../img/box01_tr.gif" width="6" height="6"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><input name="Button" type="button" class="form_button01" value="Generar" onClick="enviar()"> 
              <input name="Button" type="button" class="form_button01" value="   Salir    " onClick="cerrar()"> </td>
          </tr>
          <tr> 
            <td><img src="../../img/box01_bl.gif" width="6" height="6"></td>
            <td align="right"><img src="../../img/box01_br.gif" width="6" height="6"></td>
          </tr>
        </table></td>
      <td width="6" align="right" valign="top"><img src="../../img/center01_tr.gif" width="6" height="6"></td>
      <td width="40" rowspan="2" align="center" bgcolor="#EEEEEE">&nbsp;</td>
    </tr>
    <tr> 
      <td align="left" valign="bottom" class="cell_left_line02"><img src="../../img/center02_bl.gif" width="6" height="6"></td>
      <td align="right" valign="bottom"><img src="../../img/center01_br.gif" width="6" height="6"></td>
    </tr>
  </table>
</form>
</body>
<script language="javascript">
function enviar()
{
	f=document.form1;
	f.titulo.value="RELACION DE APORTES POR CATEGORIA";
	f.action="rNPAPORTESxCATEGORIA.php";
	f.submit();
}
function cerrar()
{
	window.close();
}

function catalogo5(campo)
   {
      mysql='select distintc codcat as CODIGO ,nomcat as DESRIPCION from npcatpre order by codcat';
	  pagina="../../lib/general/catalogoobj.php?sql="+mysql+"&campo="+campo;
	  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,height=400,resizable=yes,left=50,top=50");
   }

function catalogo4(campo)
   {
      mysql='select distinct codnom as CODIGO, nomnom as DESCRIPCION from npnomina order by codnom';
	  pagina="../../lib/general/catalogoobj.php?sql="+mysql+"&campo="+campo;
	  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,height=400,resizable=yes,left=50,top=50");
   }

function catalogo3(campo)
   {
      mysql='select distinct codemp as CODIGO ,nomemp as DESCRIPCION from NPASICAREMP order by codemp';
	  pagina="../../lib/general/catalogoobj.php?sql="+mysql+"&campo="+campo;
	  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,height=400,resizable=yes,left=50,top=50");
   }
   
function catalogo(campo)
   {	
      mysql='select distinct codtipapo as CODIGO ,destipapo as DESCRIPCION from nptipaportes  order by codtipapo';
	  pagina="../../lib/general/catalogoobj.php?sql="+mysql+"&campo="+campo;
	  window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,height=400,resizable=yes,left=50,top=50");
   }

function catalogo1()
{
 	pagina="catalogoform.php?campo=codpre1&sql=select codpre as campo1 from cpimpcom order by codpre asc";
	window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=300,height=200,rezizable=yes, left=100,top=100");
}
function catalogo2()
{
 	pagina="catalogoform.php?campo=codpre2&sql=select codpre as campo1 from cpimpcom order by codpre desc";
	window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=300,height=200,rezizable=yes, left=100,top=100");
}
</script>
</html>
