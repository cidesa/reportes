<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SIGA Reportes</title>
<link  href="../../lib/css/siga.css" rel="stylesheet" type="text/css">
<link  href="../../lib/css/datepickercontrol.css" rel="stylesheet" type="text/css">


</head>
<body>
<?php session_start();
include_once("../../lib/general/headhtml.php");
require_once("../../lib/modelo/business/presupuesto.class.php");
include_once("../../lib/general/funciones.php");
require_once("../../lib/bd/basedatosAdo.php");
$bd=new basedatosAdo();

//AQUI SE CONFIGURAN LOS CATALOGOS PREGUNTAR A CARLOS
//OBJETO CODIGO EMPLEADO
$catalogo[] = presupuesto::catalogo_cpcomproext('refcomdes');
$catalogo[] = presupuesto::catalogo_cpcomproext('refcomhas');

$_SESSION['cprcompromisoext'] = $catalogo;
?>
<?php include_once("../../lib/general/formtop.php")?>    
<form name="form1" method="post" action="rpredetcom.php">
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
          <table width="612" align="center" cellspacing="0" bordercolor="#6699CC" class="grid_line01_tl">
            <!--DWLayoutTable-->
            <tr>
              <td width="179" height="10"></td>
              <td width="160"></td>
              <td width="252"></td>
              <td width="4"></td>
            </tr>
            <!--DWLayoutTable-->
            <tr bordercolor="#FFFFFF">
              <td colspan="3" class="form_label_01"> <div align="center"> <font color="#000066" size="4"><strong>DETALLE DE COMPROMISOS EN MONEDA EXTRANJERA A LA FECHA
                      <input name="titulo" type="hidden" id="titulo">
</strong></font></div></td>
              <td></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="15"></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="25" valign="top" class="form_label_01"> <div align="left"><strong>Salida del
              Reporte:</strong></div></td>
              <td valign="top"> <div align="left"> </div>                <div align="left"> <strong>
                  <input name="radiobutton" type="radio" class="breadcrumb" value="radiobutton" checked>
              PANTALLA</strong></div></td>
              <td valign="top"> <strong>
                <input name="radiobutton" type="radio" class="breadcrumb" value="radiobutton">
              IMPRESORA</strong></td>
              <td></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td height="20" colspan="3" valign="top" class="form_label_01"> <div align="center"><font color="#000066" size="3"><strong><em>Criterios
              de Selecci&oacute;n</em></strong></font></div></td>
              <td></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td height="20"></td>
              <td valign="top"><strong>DESDE</strong></td>
              <td valign="top"><strong>HASTA</strong></td>
              <td></td>
            </tr>
              <tr bordercolor="#6699CC">
                <td class="form_label_01"><strong>Referencia: </strong></td>
              <td>
			<input name="refcomdes" type="text" class="breadcrumb" id="refcomdes"
                   value="<?$sql="select min(refcomext) as cod from cpcomext";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="15">
  			<a href="#"><img src="../../img/search.gif" align="top" onclick="catalogo('cprcompromisoext',0); "></a>
		      </td>
              <td>
			<input name="refcomhas" type="text" class="breadcrumb" id="refcomhas"
                   value="<?$sql="select max(refcomext) as cod from cpcomext";
           LlenarTextoSql($sql,"cod",$bd); ?>" size ="15">
  			<a href="#"><img src="../../img/search.gif" align="top" onclick="catalogo('cprcompromisoext',1); "></a>
		      </td>              
            </tr>

             <tr bordercolor="#6699CC">
              <td height="26" valign="top" class="form_label_01"><strong>Fecha del Compromiso :</strong></td>
              <td valign="top">
			  <?
			  $tb1=$bd->select("SELECT to_char(MIN(feccom),'DD/MM/YYYY')  as feccom FROM cpcomext");
			  ?>
			  <input name="fechcomp1" class="breadcrumb" id="fechcomp1" datepicker="true" size="12" value="<? print $tb1->fields["feccom"];?>"/>
			  </td>
              <td valign="top">

                  <?
			  $tb1=$bd->select("SELECT to_char(max(feccom),'DD/MM/YYYY') as feccom FROM cpcomext");
                      //  $tb1=$bd->select("SELECT max(feccom) as feccom FROM cpcomext");

			  ?>
                  <input name="fechcomp2" class="breadcrumb" id="fechcomp2" datepicker="true" size="12" value="<? print $tb1->fields["feccom"];?>"/>
			  </td>
              <td></td>
            </tr>

            <tr bordercolor="#6699CC">
              <td height="28" valign="top" bordercolor="#FFFFFF" class="form_label_01"> <div align="left"><strong>Tipo de Compromiso:</strong></div></td>
              <td valign="top"> <div align="left">
			    <?
			  	$tb5=$bd->select("select tipo as tipcom from (select distinct(tipcom) as tipo from cpdoccom
	union select distinct(tipcau) as tipo from cpdoccau where afecom<>'N'
	union select distinct(tippag) as tipo from cpdocpag where afecom<>'N') as j ORDER BY tipo  ASC");
			  ?>
                  <select name="tipcomp1" class="breadcrumb" id="tipcomp1">
                  <?
				  	while(!$tb5->EOF)
					{
				  ?>
                    <option value="<? print $tb5->fields["tipcom"];?>"><? print $tb5->fields["tipcom"];?></option>
                    <?
					$tb5->MoveNext();
					}
				?>
                  </select>
              </div></td>
              <td valign="top"> <div align="left">
			   <?
			  	$tb6=$bd->select("select tipo as tipcom from (select distinct(tipcom) as tipo from cpdoccom
	union select distinct(tipcau) as tipo from cpdoccau where afecom<>'N'
	union select distinct(tippag) as tipo from cpdocpag where afecom<>'N') as j ORDER BY tipo DESC");
			  ?>
                  <select name="tipcomp2" class="breadcrumb" id="tipcomp2">
                    <?
				  	while(!$tb6->EOF)
					{
				  ?>
                    <option value="<? print $tb6->fields["tipcom"];?>"><? print $tb6->fields["tipcom"];?></option>
                    <?
					$tb6->MoveNext();
					}
				?>
                  </select>

              </div></td>
              <td></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td height="28" valign="top"><strong class="form_label_01">Status:</strong></td>
              <td valign="top">
			  <?
			  $tb7=$bd->select("SELECT DISTINCT(stacom), case when stacom='A' then 'Activo' else 'Anulado' end FROM cpcomext");
			  ?>
			  <select name="status" class="breadcrumb" id="status">
			  <?
			  while(!$tb7->EOF)
			  {
			  	?>
				<option value="<? print $tb7->fields["stacom"];?>"><? print $tb7->fields["case"];?></option>
				<?
				$tb7->MoveNext();
			  }
			  ?>
              </select></td>
              <td>&nbsp;</td>
              <td></td>
            </tr>
             <tr bordercolor="#6699CC">
                 <td class="form_label_01">
                <div align="left"><strong>C&oacute;digo Presupuestario Desde:</strong></div></td>
              <td colspan=]"2">
                <div align="left">
                  <?
			  	$tb=$bd->select("select min(codpre) as valor from CPIMPCOM");
			  ?>
			  	<input size="40" type="text" name="codpresu1" class="breadcrumb" id="codpresu1" value="<? print $tb->fields["valor"];?>"
				<input type="button" name="Button" value="..." onclick="catalogo2('codpredesde')"/>

              </div></td>
              </tr>
              <tr>
              <td class="form_label_01">
                <div align="left"><strong>C&oacute;digo Presupuestario Hasta:</strong></div></td>
              <td colspan="2">
                <div align="left">
                       <?
			  	$tb=$bd->select("select max(codpre) as valor from CPIMPCOM");
			  ?>
			  	<input size="40" type="text" name="codpresu2" class="breadcrumb" id="codpresu2" value="<? print $tb->fields["valor"];?>"
				<input type="button" name="Button" value="..." onclick="catalogo2('codprehasta')"/>
              </div></td>
            </tr>
            <tr bordercolor="#6699CC">
                 <td class="form_label_01">
                <div align="left"><strong>C&oacute;digo Moneda Desde:</strong></div></td>
              <td colspan=]"2">
                <div align="left">
                  <?
			  	$tb=$bd->select("select min(codmon) as valor from CPCOMEXT");
			  ?>
			  	<input size="5" type="text" name="codmon1" class="breadcrumb" id="codmon1" value="<? print $tb->fields["valor"];?>"
				<input type="button" name="Button" value="..." onclick="catalogo3('codmondesde')"/>

              </div></td>
              </tr>
              <tr>
              <td class="form_label_01">
                <div align="left"><strong>C&oacute;digo Moneda Hasta:</strong></div></td>
              <td colspan="2">
                <div align="left">
                       <?
			  	$tb=$bd->select("select max(codmon) as valor from CPCOMEXT");
			  ?>
			  	<input size="5" type="text" name="codmon2" class="breadcrumb" id="codmon2" value="<? print $tb->fields["valor"];?>"
				<input type="button" name="Button" value="..." onclick="catalogo3('codmonhasta')"/>
              </div></td>
            </tr>

            <tr bordercolor="#6699CC">
              <td class="form_label_01"> <div align="left"><strong>Filtro:</strong></div></td>
              <td colspan="2"> <div align="left"></div>
                <div align="left">
                  <input name="comodin" type="text" class="breadcrumb" id="comodin" value="" size="75">
                  <input name="sqls" type="hidden" id="sqls">
                </div></td>
              <td></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td colspan="3" class="form_label_01">Orientaci&oacute;n del Reporte: Carta/Horizontal </td>
              <td></td>
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
	f.titulo.value=" DETALLE DE COMPROMISOS EN MONEDA EXTRANJERA A LA FECHA";
	f.action="rpredetcomext.php";
	f.submit();
}
function cerrar()
{
	window.close();
}
function catalogo1(campo)
{

    pagina="../../lib/general/catalogoobj.php?campo="+campo+"&sql=SELECT distinct(refcomext) as referencia FROM cpcomext order by refcomext asc";
	window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,heigth=400,resizable=yes,left=50,top=50");
}
function catalogo2(campo)
{
		pru='00';
    pagina="../../lib/general/catalogoobj.php?campo="+campo+"&sql=select codpre as codigo, nompre as nombre from cpasiini where perpre=*00*";
	window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,heigth=400,resizable=yes,left=50,top=50");
}
function catalogo3(campo)
{
		pru='00';
    pagina="../../lib/general/catalogoobj.php?campo="+campo+"&sql=select codmon as codigo, nommon as nombre from TSDEFMON order by codmon asc";
	window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,heigth=400,resizable=yes,left=50,top=50");
}

</script>
</html>
