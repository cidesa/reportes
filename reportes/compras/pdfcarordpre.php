<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/Cabecera.php");
	require_once("../../lib/general/funciones.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/compras/Carordpre.class.php");


	class pdfreporte extends FPDF
	{

		var $i=0;
                var $r=0;
		var $bd;
		var $arrp=array();
                var $sw=false;
		var $cab;
		var $titulo;
		var $ordcomdes;
		var $ordcomhas;
		var $codprodes;
		var $codprohas;
		var $codartdes;
		var $codarthas;
		var $fecorddes;
		var $fecordhas;
		var $status;
		var $despacho;
		var $condicion;
		var $conf;
		var $dircon;
		var $dirgen;

		function pdfreporte()
		{
			$this->conf="p";
			$this->fpdf($this->conf,"mm","Legal");
			$this->bd = new Carordpre();


			if($_GET["ordcomdes"]!="")
			{
				$this->ordcomdes=$_GET["ordcomdes"];
				$this->ordcomhas=$_GET["ordcomdes"];
				$this->arrp=$this->bd->sqlp($this->ordcomdes,$this->ordcomhas);
			}
			else
			{
			//Recibir las variables por el Post
			$this->ordcomdes=str_replace('*',' ',H::GetPost("ordcomdes"));
			$this->ordcomhas=str_replace('*',' ',H::GetPost("ordcomhas"));
			$this->codprodes=str_replace('*',' ',H::GetPost("codprodes"));
			$this->codprohas=str_replace('*',' ',H::GetPost("codprohas"));
			$this->codartdes=str_replace('*',' ',H::GetPost("codartdes"));
			$this->codarthas=str_replace('*',' ',H::GetPost("codarthas"));
			$this->fecorddes=str_replace('*',' ',H::GetPost("fecorddes"));
			$this->fecordhas=str_replace('*',' ',H::GetPost("fecordhas"));
			$this->status=str_replace('*',' ',H::GetPost("status"));
			$this->despacho=str_replace('*',' ',H::GetPost("despacho"));
			$this->dircom=str_replace('*',' ',H::GetPost("dircom"));
			$this->dirgen=str_replace('*',' ',H::GetPost("dirgen"));
	        $this->arrp = $this->bd->sqlp2($this->ordcomdes,$this->ordcomhas,$this->codprodes,$this->codprohas,$this->codartdes,$this->codarthas,$this->fecorddes,$this->fecordhas,$this->status,$this->despacho);
			}
		}


		function Header()
		{
			$this->SetFont("Arial","B",9);
			$this->formato();
			if ($this->arrp[$this->i]["staord"]=='Anulado')
			{
				$this->SetLineWidth(1);
				$this->SetDrawColor(100,1,1);
				$this->SetFont("Arial","B",84);
				$this->SetTextColor(100,1,1);
				//$this->SetAlpha(0.5);
				$this->Rotate(45,40,160);
				$this->RoundedRect(40, 160, 150, 25, 2.5, 'D');
				$this->Text(42,183,'ANULADA');
				$this->Rotate(0);
				$this->SetDrawColor(0);
				$this->SetTextColor(0);
				//$this->SetAlpha(1);
				$this->SetLineWidth(0);
			}
			if (($this->arrp[$this->i]["afepre"]=='N') && ($this->arrp[$this->i]["staord"]=='Activo'))
                        {
                                $this->SetLineWidth(1);
                                $this->SetDrawColor(100,1,1);
                                $this->SetFont("Arial","B",60);
                                $this->SetTextColor(100,1,1);
                                //$this->SetAlpha(0.5);
                                $this->Rotate(45,40,160);
                                //$this->RoundedRect(40, 160, 150, 25, 2.5, 'D');
                                $this->Text(42,183,'SIN COMPROMETER');
                                $this->Rotate(0);
                                $this->SetDrawColor(0);
                                $this->SetTextColor(0);
                                //$this->SetAlpha(1);
                                $this->SetLineWidth(0);
                        }
//			else
//			{
//				$this->SetAlpha(1);
//			}
			/////////////////////////////////////////
			$this->SetXY(165,15);
			$this->SetFont("Arial","B",11);
			$this->Cell(20,3,$this->arrp[$this->i]["ordcom"]);
			$this->SetXY(165,25);
			$this->SetFont("Arial","",11);
			$this->Cell(20,3,$this->arrp[$this->i]["fecord"]);
			$ano= substr($this->arrp[$this->i]["fecord"],6,4);
			$this->SetFont("Arial","",8);
				$this->SetXY(30,46);
			$codarray=explode("-",trim($this->arrp[$this->i]["codpar"]));
			$numarray=count($codarray);
			$descat=$this->bd->sql_cpniveles();
			$indcat=0;
			$this->SetY(50);
			$this->SetFont("Arial","",7);
			$arrcod=array();
			foreach($descat as $cat)
			{
			 $this->SetX(12);
			 array_push($arrcod,$codarray[$indcat]);
			 if($indcat<$numarray)
			 {
			  $arrdes=$this->bd->sql_nompre(implode("-",$arrcod));
			 }
			 else
			 {
			  continue;
			 }
			 $this->Ln(4);
			 $indcat++;
			}
			$this->SetXY(33,69);
			$this->SetFont("Arial","",7);

			$this->SetFont("Arial","B",8);
                        $this->SetXY(47,55);
			$this->Cell(40,3,$this->arrp[$this->i]["uejecutora"]);
                        $this->SetXY(54,59);
			$this->Cell(40,3,$this->arrp[$this->i]["udministrativa"]);
			$this->SetXY(35,46);
			$this->Cell(120,3,$this->arrp[$this->i]["nompro"]);
			$this->SetXY(158,46);
                        $this->SetFont("Arial","B",6);
			$this->Cell(80,3,$this->arrp[$this->i]["rifpro"]);
                        $this->SetXY(170,50);
			$this->Cell(80,3,$this->arrp[$this->i]["telpro"]);
			$this->SetFont("Arial","",5);
			$this->SetXY(35,50);
			$this->MultiCell(110,2,$this->arrp[$this->i]["dirpro"]);

			//Vamosa buscar la Forma de Entrega
			$ent=$this->bd->sql_ent($this->arrp[$this->i]["ordcom"]);
			$this->SetFont("Arial","",8);
					$this->SetXY(15,68);
			$this->Cell(10,4,$ent[0]["desforent"],0,0,'');

			//Vamos a buscar la Condicion de Pago(efectivo / cheque/ otro)
			$cond=$this->bd->sql_conpag($this->arrp[$this->i]["ordcom"]);
			$this->SetXY(110,68);
			$this->Cell(5,4,$cond[0]["desconpag"],0,0,'');

                        //Vamos a buscar la Fuente de Financiamiento
			$fuente=$this->bd->sql_fuefin($this->arrp[$this->i]["ordcom"]);
			$this->SetXY(150,68);
			$this->Cell(10,4,$fuente[0]["nomfuefin"],0,0,'');

			//descripcion
			$this->SetFont("Arial","",6);
			$this->SetXY(10,240);
			$this->multicell(195,3,'DESCRIPCIÓN: '.substr($this->arrp[$this->i]["desord"],0,900));//strlen
			$this->SetFont("Arial","",8);

                        #IMPUTACIONES
                           $this->SetY(82);
                            $imput=$this->bd->sql_imp($this->arrp[$this->i]["ordcom"],$this->codref);
                            $indimp=0;
                            $numimp=count($imput);
                            if(!$this->sw){
                                $this->sw=true;
                                $this->numimp=$numimp;
                                }
                           //codigo presupuestario del gasto
                                while($indimp<$numimp and !$touch)
                                {
                                        $this->r++;
                                        $this->SetWidths(array(10,6,6,6,7,7,7,7,119,20));
                                        $this->SetAligns(array('C','C','C','C','C','C','C','C','L','R'));
                                        $codpre=explode("-",trim($imput[$indimp]["codigo"]));

                                        array_pad($codpre,9,'');
                                        $this->setBorder(false);
                                        $this->Row(array($codpre[0],$codpre[1],$codpre[2],$codpre[3],$codpre[4],$codpre[5],$codpre[6],$codpre[7],substr(trim($imput[$indimp]["nompre"]),0,48),H::FormatoMonto($imput[$indimp]["monto"])));

//                                        $indimp++;
//                                        if($indimp>=$numimp)
//                                        {
//                                                $detcat=true;
//                                        }
                                        if($this->GetY() > 114)
                                        {
                                                $aun=true;
                                                $touch=true;
                                                $this->codref=trim($imput[$indimp]["codigo"]);
//echo '<pre>';                print_r($codref);

                                        }

                                        if($this->r>=$this->numimp)
                                        {
                                            $this->codref='Z';
                                        }

                                        $indimp++;
                                        if($indimp>=$numimp)
                                        {
                                                $detcat=true;
                                        }
                               }
                           #FIN DE IMPUTACIONES
			$this->SetY(135);
		}

                function ImprimeCajaFirmas()
                {
                        // SI SON DIFERENTES DE codcat = A1549-05-001-14 DEBEN IR SIN LA CAJA DE HEBERT
			if($this->arrp[0]["codpar"]!='402-11-01-00')
                	{
                    		$this->Rect(10,243,195,85);
	                        $this->SetFont("Arial","",6.5);
				$this->SetXY(15,263);
                	        $responsable=$this->bd->sql_responsable($this->ref);
                        	$gergen=$this->bd->sql_gergen($this->ref);
	                        $elapor=$this->bd->sql_elapor($this->ref,$_SESSION['schema']);

        	                #####CAJAS D FIRMA###########
	      	                $this->SetXY(10,249+14);
	                        $this->multicell(50,2,$elapor[0]['nomuse'],0,'C');
       		                #$this->SetXY(58,249+14);
       	                 	#$this->multicell(50,2,$responsable[0]['nomjef'],0,'C');
       	                 	#$this->SetXY(106,249+14);
       	                 	#$this->multicell(50,2,$gergen[0]["nomemp"],0,'C');
	       	                #$this->SetXY(154,249+14);
       		                #$this->multicell(50,2,$responsable[0]["nomemp"],0,'C');
       	                 	$this->SetXY(75,249+15);
                        	$this->multicell(70,2,$responsable[0]['nomjef'],0,'C');
                        	$this->SetXY(145,249+15);
                        	$this->multicell(50,2,$gergen[0]["nomemp"],0,'C');


				$this->SetXY(10,266+15);
				if($this->dircom==""){
				   $this->Cell(65,3,'GUSTAVO SILVA',0,0,'C');
				}else
				   $this->Cell(50,3,$this->dircom,0,0,'C');
		                $this->SetX(75);
				if($this->dirgen==""){
				   $this->Cell(70,3,'CARLOS OSORIO',0,0,'C');
				}else
				        $this->Cell(50,3,$this->dirgen,0,0,'C');
       	        		        $this->SetXY(10,240+14);

		                        $this->multicell(48,2,'ELABORADO POR:');
		                        #$this->SetXY(58,252+14);
		                        #$this->multicell(48,2,'JEFE DE COMPRAS',0,'C');
					#$this->SetXY(106,252+14);
		                        #$this->multicell(48,2,$gergen[0]["nomcar"],0,'C');
		                        #$this->SetXY(154,252+14);
		                        #$this->multicell(51,2,$responsable[0]["nomcar"],0,'C');
		                        $this->SetXY(75,240+14);
		                        $this->multicell(48,2,'REVISADO POR:');
		                        $this->SetXY(75,252+15);
		                        $this->multicell(70,2,'JEFE DE COMPRAS',0,'C');
		                        $this->SetXY(145,240+14);
		                        $this->multicell(48,2,'CONFORMADO POR:');
					$this->SetXY(145,252+15);
		                        $this->multicell(60,2,$gergen[0]["nomcar"],0,'C');

		                        $esp=12;

        		                if($this->dircom==""){
	                	          $this->SetXY(10,252+$esp+6);
					  $this->Cell(60,3,'AUTORIZADO POR:');
					  $this->SetXY(10,269+15);
			                  $this->MultiCell(65,3,'GERENTE GENERAL DE ADMINISTRACIÓN Y FINANZAS',0,'C');
					}


					if($this->dirgen==""){
		                           $this->SetXY(75,252+$esp+6);
					   $this->Cell(60,3,'APROBADO POR:');
					   $this->SetXY(75,269+15);
			                   $this->Cell(70,3,'PRESIDENTE DE PDVAL, S.A. ',0,0,'C');
					}

					$this->SetXY(10,235);


			                $this->Line(10,235+$esp+6,205,235+$esp+6);//LINEAS VERTICALES
				        $this->SetXY(145,252+$esp+6);
					$this->Cell(60,3,'RECIBIDO PROVEEDOR:');
					$this->SetXY(145,269+15);
					$this->MultiCell(60,3,'FIRMA, SELLO DE LA CASA COMERCIAL',0,'C');

			                #$this->Line(58,235+$esp+6,58,257+$esp);//LINEAS VERTICALES
		                        #$this->Line(106,235+$esp+6,106,257+$esp);//LINEAS VERTICALES
		                        #$this->Line(154,235+$esp+6,154,257+$esp);//LINEAS VERTICALES
		                        #$this->Line(114,235+$esp+6,114,275+$esp);

                		        $this->Line(75,235+$esp+6,75,275+$esp);
		                        $this->Line(145,235+$esp+6,145,275+$esp);

		                        $this->Line(10,257+$esp,205,257+$esp);//LINEA HORIZONTALES
		                        $this->Line(10,275+$esp,205,275+$esp);

		                        #####FIN CAJAS D FIRMA###########

					$this->SetFont("Arial","B",9);
					$this->SetXY(10,276+$esp);
					$this->Cell(90,3,'OBSERVACIONES');
					$this->SetFont("Arial","",9);
					$this->SetXY(50,280+$esp);
					$this->Cell(90,4,'a) La Nota de Entrega y las Facturas deben indicar el Nro de la Orden de Compra');
					$this->ln(4);
					$this->SetX(50);
					$this->Cell(90,4,'b) El Proveedor al facturar debe anexar el Original de la Orden de Compra');
					$this->ln(4);
					$this->SetX(50);
					$this->Cell(90,4,'c) Las facturas deben ser enviadas en Original y Copia');
					$this->ln(4);
					$this->SetX(50);
					$this->Cell(90,4,'d) Las Facturas deben especificar el Monto Total a Pagar en Letras');
					$this->ln(4);
				//	$this->SetX(50);
					//$this->Cell(90,4,'e) Compromiso de Responsabilidad Social, Aporte en dinero (3%) para programas sociales');
					$this->ln(4);
					$this->SetFont("Arial","B",7);
					$this->Cell(20,4,'RESCISION: ');
					$this->SetFont("Arial","",7);
					$this->MultiCell(170,4,'LA GERENCIA GENERAL DE ADMINISTRACION Y FINANZAS, ACTUANDO EN REPRESENTACION DE PDVAL, S.A PODRA RESCINDIR ESTA ORDEN DE COMPRA, SIN PAGO DE INDEMNIZACION ALGUNA CUANDO EL "PROVEEDOR" INCUMPLIERE CUALQUIERA DE LOS TERMINOS ESTABLECIDOS EN ELLA');
        	        }
			else
			{
                   			#CAJAS
                                        $this->Rect(10,252,195,79); # Margen exterior de la orden
                                        $this->SetFont("Arial","",6);
                                        $this->SetXY(15,263);
                                        $responsable=$this->bd->sql_responsable($this->ref);
                                        $gergen=$this->bd->sql_gergen($this->ref);
                                        $elapor=$this->bd->sql_elapor($this->ref,$_SESSION['schema']);

                                        #####CAJAS D FIRMA###########
                                        $this->SetXY(10,249+14);
                                        $this->multicell(50,2,$elapor[0][''],0,'C');
                                        $this->SetXY(75,249+15);
                                        $this->multicell(70,2,$responsable[0]['nomjef'],0,'C');
                                        $this->SetXY(145,249+15);
                                        $this->multicell(50,2,$gergen[0]["nomemp"],0,'C');


                                        $this->SetXY(10,266+15);
                                        if($this->dircom==""){
                                           $this->Cell(65,3,'GUSTAVO SILVA',0,0,'C');
                                        }else
                                           $this->Cell(50,3,$this->dircom,0,0,'C');
                                        $this->SetX(75);

					// NUEVO NOMBRE PARA LA NUEVA CAJA DE FIRMA
					$this->Cell(65,3,'HEBER AGUILAR',0,0,'C');
					// $this->Cell(65,3,'             ',0,0,'C');

                                        if($this->dirgen==""){
                                           $this->Cell(70,3,'CARLOS OSORIO',0,0,'C');
                                        }else
                                           $this->Cell(50,3,$this->dirgen,0,0,'C');

					$this->SetXY(10,240+14);
                                        $this->multicell(48,2,'ELABORADO POR:');
                                        $this->SetXY(75,240+14);
                                        $this->multicell(48,2,'REVISADO POR:');
                                        $this->SetXY(75,252+15);
                                        $this->multicell(70,2,'GERENTE DE COMPRAS',0,'C');
                                       # $this->multicell(70,2,'GERENTE GENERAL DE ADMINISTRACIÓN Y FINANZAS',0,'C');
                                        $this->SetXY(145,240+14);
                                        $this->multicell(48,2,'CONFORMADO POR:');
                                        $this->SetXY(145,252+15);
                                        $this->multicell(60,2,$gergen[0]["nomcar"],0,'C');

                                        $esp=12;
                                        if($this->dircom==""){
                                          $this->SetXY(10,252+$esp+6);
                                          $this->Cell(60,3,'DISPONIBILIDAD FINANCIERA:');
                                          $this->SetXY(10,269+15);
                                          $this->MultiCell(65,3,'GERENTE GENERAL DE ADMINISTRACIÓN Y FINANZAS',0,'C');
                                        }
//
//                                        if($this->dirgen==""){
//                                          $this->SetXY(75,252+$esp+6);
//                                       	    $this->Cell(60,3,'AUTORIZADO POR:');
//                                           $this->SetXY(75,269+15);
//                                           $this->Cell(70,3,'GERENTE GENERAL DE OPERACIONES',0,0,'C');
 //                                       }

                                        $this->SetXY(10,235);

                                        $this->Line(10,235+$esp+6,205,235+$esp+6);//LINEAS VERTICALES
                                        //$this->SetXY(145,252+$esp+6);
					$this->SetXY(75,252+$esp+6);


					// SI SON DIFERENTES DE codcat = A1549-05-001-14 DEBEN IR SIN LA CAJA DE HEBERT

					// NUEVA CAJA DE FIRMA
                                        $this->Cell(60,3,'CONFORMADO POR:');
					$this->SetXY(145,252+$esp+6);
					$this->Cell(60,3,'APROBADO POR:');
					$this->SetXY(75,269+15);
					$this->MultiCell(67,3,'VICEPRESIDENTE DE PDVAL, S.A. ',0,'C');

                                        $this->SetXY(145,269+15);
					$this->MultiCell(60,3,'PRESIDENTE DE PDVAL, S.A. ',0,'C');
					// nueva caja de firma
                                        $this->SetXY(145,252+$esp+6+18);
					//$this->SetXY(145,252+$esp+6);
                                        $this->Cell(60,3,'RECIBIDO PROVEEDOR:');
                                        $this->SetXY(145,269+15+20);
					//$this->SetXY(145,269+15);
                                        $this->MultiCell(60,3,' FIRMA, SELLO DE LA CASA COMERCIAL',0,'C');

                                        $this->Line(75,235+$esp+6,75,275+$esp);
                                        $this->Line(145,235+$esp+6,145,275+$esp+21);//+21
				        //$this->Line(145,235+$esp+6,145,275+$esp);//+21

                                        $this->Line(10,257+$esp,205,257+$esp);//LINEA HORIZONTALES
                                        $this->Line(10,275+$esp,205,275+$esp);

					// linea adicional para la caja nueva
					$this->Line(145,275+$esp+21,205,275+$esp+21);

                                        #####FIN CAJAS D FIRMA###########
                                        $this->SetFont("Arial","B",7);
                                        $this->SetXY(10,286+$esp-8);
                                        $this->Cell(90,3,'OBSERVACIONES');
                                        $this->SetFont("Arial","",7);
                                        $this->SetXY(50,287+$esp-8);
                                        $this->Cell(90,4,'a) La Nota de Entrega y las Facturas deben indicar el Nro de la Orden de Compra');
                                        $this->ln(4);
                                        $this->SetX(50);
                                        $this->Cell(90,4,'b) El Proveedor al facturar debe anexar el Original de la Orden de Compra');
                                        $this->ln(4);
                                        $this->SetX(50);
                                        $this->Cell(90,4,'c) Las facturas deben ser enviadas en Original y Copia');
                                        $this->ln(4);
                                        $this->SetX(50);
                                        $this->Cell(90,4,'d) Las Facturas deben especificar el Monto Total a Pagar en Letras');
                                        $this->ln(4);
                                //	$this->SetX(50);
                                        //$this->Cell(90,4,'e) Compromiso de Responsabilidad Social, Aporte en dinero (3%) para programas sociales');
                                        $this->ln(4);
                                        $this->SetFont("Arial","B",6);
                                        $this->Cell(20,4,'RESCISION: ');
                                        $this->SetFont("Arial","",6);
                                        $this->MultiCell(170,4,'LA GERENCIA GENERAL DE ADMINISTRACION Y FINANZAS, ACTUANDO EN REPRESENTACION DE PDVAL, S.A PODRA RESCINDIR ESTA ORDEN DE COMPRA, SIN PAGO DE INDEMNIZACION ALGUNA CUANDO EL "PROVEEDOR" INCUMPLIERE CUALQUIERA DE LOS TERMINOS ESTABLECIDOS EN ELLA');
			} // fin del if else
                }// fin de la function

		function formato()
		{
			$this->Rect(10,10,195,243);
			//$this->SetXY(15,11);
			$this->SetFont("Arial","",8);
			$this->Image("../../img/logo_1.jpg",13,14,25,20);
			$this->SetXY(40,11);
			$this->Cell(10,3,'REPUBLICA BOLIVARIANA DE VENEZUELA');
			$this->ln();
			$this->SetX(40);
			$this->Cell(10,3,'MINISTERIO DEL PODER POPULAR PARA LA ALIMENTACION');
			$this->ln();
			$this->SetX(40);
			$this->Cell(10,3,'PRODUCTORA Y DISTRIBUIDORA VENEZOLANA DE ALIMENTOS, S.A');
			$this->ln();
			$this->SetX(40);
			$this->Cell(10,3,'GERENCIA GENERAL DE ADMINISTRACION Y FINANZAS');
			$this->SetFont("Arial","",7);
			$this->SetXY(35,27);
		//	$this->MultiCell(100,3,"Dirección: Av Libertador Edif Torre Este PDVSA La Campiña Piso 12 OF 01 Sector La Campiña - Caracas. RIF: J-29550641-4",0,'C',0);
		        $this->MultiCell(110,3,"Dirección:Esquina Telares,Edificio Pdval Piso 1,Oficina Mezzanina,Sector San José,Distrito Capital,Municipio Libertador,Parroquia San José,Ciudad Caracas.Teléfono 0212-5557128/0212-5557138,Fax 02125557078,Zona Postal 1010.RIF:G200100249",0,'C',0);
                	$this->Line(10,38,205,38);//LINEA HORIZONTAL
			$this->SetFont("Arial","B",12);
			$this->SetXY(55,40);
			$this->Cell(100,5,"ORDEN DE COMPRA",0,0,'C');
			$this->SetFont("Arial","",9);
			$this->Line(150,10,150,38);//LINEA VERTICAL
			$this->SetXY(155,11);
			$this->Cell(10,3,'Nro. Unidad.-Nro. Control:');
			$this->SetXY(155,22);
			$this->Cell(10,3,'Fecha:');
			$this->Line(10,45,205,45);//LINEA HORIZONTAL

			$this->SetXY(12,46);
			$this->Cell(80,3,'PROVEEDOR:');
			$this->SetXY(150,46);
			$this->Cell(80,3,'RIF:');
                        $this->SetXY(150,50);
                        $this->Cell(80,3,'TELEFONO:');
			$this->SetXY(12,50);
			$this->Cell(10,3,'DIRECCION:');
			$this->SetXY(12,58);
                        $this->Line(10,54,205,54);//LINEA HORIZONTAL
                        $this->SetXY(12,55);
			$this->Cell(40,3,'UNIDAD EJECUTORA:');
                        $this->SetXY(12,59);
			$this->Cell(40,3,'UNIDAD ADMINISTRATIVA:');
			$this->Line(10,62,205,62);//LINEA HORIZONTAL
			$this->Line(150,45,150,62);//LINEA VERTICAL

			$this->SetXY(10,63);
			$this->Cell(40,4,'TIEMPO DE ENTREGA:');
			$this->Cell(60,4,'LUGAR DE ENTREGA:');
			$this->Cell(40,4,'CONDICIONES DE PAGO:');
                        $this->Cell(40,4,'FUENTE DE FINANCIAMIENTO:');
			$this->Line(10,67,205,67);//LINEAS HORIZONTALES
			$this->Line(10,72,205,72);
			$this->Line(50,62,50,72);//LINEAS VERTICALES
			$this->Line(110,62,110,72);
                        $this->Line(150,62,150,72);

			$this->Line(10,77,205,77);//LINEA HORIZONTAL
			$this->SetY(73);
			$this->Cell(200,4,'IMPUTACIÓN PRESUPUESTARIA',0,0,'C');

			$this->Line(10,82,205,82);
			$this->SetFont("Arial","",8);
                        $this->SetXY(10,79);
			$this->Cell(90,3,'ENTEI');
			$this->Line(20,77,20,122);
			$this->SetXY(20,79);
			$this->Cell(90,3,'PR');
			$this->Line(26,77,26,122);
			$this->SetXY(26,79);
			$this->Cell(90,3,'AE');
                        $this->Line(32,77,32,122);
			$this->SetXY(32,79);
			$this->Cell(90,3,'UE');
			$this->Line(38,77,38,122);
			$this->SetXY(38,79);
			$this->Cell(90,3,'PAR');
			$this->Line(46,77,46,122);
			$this->SetXY(46,79);
			$this->Cell(90,3,'GE');
			$this->Line(53,77,53,122);
			$this->SetXY(53,79);
			$this->Cell(90,3,'ES');
			$this->Line(60,77,60,122);
			$this->SetXY(60,79);
			$this->Cell(90,3,'SE');
			$this->SetXY(67,79);
			$this->Cell(90,3,'DESCRIPCIÓN');
			$this->Line(67,77,67,122);
			$this->SetXY(185,79);
			$this->Cell(90,3,'MONTO BsF');
			$this->Line(185,77,185,122);

			$this->Line(10,122,205,122);

			$this->SetFont("Arial","",8);
			$this->SetY(123);
			$this->Cell(200,3,'PUEDE DESPACHARSE EL SIGUIENTE MATERIAL DE ACUERDO CON LAS INSTRUCCIONES ESPECIFICAS',0,0,'C');
			$this->Line(10,127,205,127);

			$this->SetXY(10,128);
			$this->Cell(30,3,'RENG');
			$this->Line(20,127,20,220);
			$this->SetXY(22,128);
			$this->Cell(30,3,'CANT');
			$this->Line(34,127,34,220);
			$this->SetXY(35,128);
			$this->Cell(90,3,'UNIDAD DE');
			$this->SetXY(36,131);
			$this->Cell(90,3,'MEDIDA');
			$this->Line(53,127,53,220);
			$this->SetXY(55,128);
			$this->Cell(90,3,'PARTIDA');
			$this->Line(76,127,76,220);
			$this->SetXY(100,128);
			$this->Cell(90,3,'DESCRIPCION');
			$this->Line(146,127,146,220);
			$this->SetXY(146,128);
			$this->Cell(90,3,'PRECIO UNITARIO');
			$this->SetXY(150,131);
			$this->Cell(90,3,'BsF.');
			$this->Line(174,127,174,240);
			$this->SetXY(178,128);
			$this->Cell(90,3,'TOTAL BsF.');

			$this->Line(10,134,205,134);//LINEAS HORIZONTALES
			$this->Line(10,220,205,220);
			$this->Line(10,225,205,225);
			$this->Line(10,240,205,240);

			$this->SetXY(11,228);
			$this->Cell(90,3,'SON:');
			$this->Line(20,225,20,240);
			$this->Line(146,220,146,240);

			}
                function footer()
                {
                    $this->ImprimeCajaFirmas();
                    $this->setAutoPageBreak(false);
                    $this->setY(330);
                    $this->cell(180,5,"Pagina ".$this->PageNo(). '/{nb} ',0,0,'C');
                }

		function Cuerpo()
		{
			$eof=count($this->arrp);
//echo '<pre>';                print_r($eof);

			$ref=$this->arrp[$this->i]["ordcom"];
			$contador=1;
			$primeravez=true;
			$subtotal=0;
			$iva=0;
			$total=0;
			$fecha=explode("/",$this->arrp[$this->i]["fecord"]);
			$detcat=false;
			$aun=false;
			$touch=false;
			$band=false;
			$rgo=0;
			$codref=0;
			$sumador=0;
			$this->subtotal=0;
			$j=0;
			$x=0;
			$van=0;
			while($this->i < $eof and $ref==$this->arrp[$this->i]["ordcom"])
			{
                                $x=$this->GetX();
				$y=$this->GetY();
				$usuario=$this->arrp[$this->i]["nomuse"];
				$this->SetXY($x,$y);
				$this->SetWidths(array(12,12,21,23,65,31,29));
				$this->SetAligns(array('C','R','L','L','J','R','R'));
                                $this->SetFont("Arial","",6);
				$this->Row(array((string)$contador."    ",H::FormatoMonto($this->arrp[$this->i]["cantot"]),"   ".$this->arrp[$this->i]["unimed"],$this->arrp[$this->i]["codpar1"],trim($this->arrp[$this->i]["desres"]),H::FormatoMonto($this->arrp[$this->i]["preart"]),H::FormatoMonto(($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"]))));
				$this->subtotal+=$this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"];
                                $this->ordcom=$this->arrp[$this->i]["ordcom"];
                                $subtotal=$subtotal+($this->arrp[$this->i]["cantot"]*$this->arrp[$this->i]["preart"]);
				if($this->GetY()>195){
				       $this->ln();
				       $this->SetFont("Arial","B",8);
			           $this->setx(150);
			           $this->Cell(20,3,"VAN...             ",0,0,"R");
			           $this->setx(163);
			           $this->Cell(40,3,H::FormatoMonto($this->subtotal),0,0,"R");
			           $this->SetFont("Arial","",8);
			           $this->subtotal2=$this->subtotal;
			           $this->subtotal=0;
			           $van=1;
					$this->AddPage();
					$this->ln();
					$this->SetX(160);
					$this->SetFont("Arial","B",8);
					$this->Cell(11,5,'VIENEN...',0,0,'');
					$this->Cell(31,5,H::FormatoMonto($this->subtotal2),0,0,"R");
					$this->SetFont("Arial","",8);
					$this->ln();
				}

				$this->i++;
				$contador++;
                                $this->ref=$ref;
				if($ref!=$this->arrp[$this->i]["ordcom"])
				{

					 $this->arrp2 = $this->bd->sql_ivas($ref);

				  $paso = 10;
//				   foreach($this->arrp2 as $registro)

//				   {

//                                        $this->recarg=round($registro["porcen"]);
//                                        $rgo=$registro["suma"];

//					$this->SetXY(150,$this->GetY()+5);
 //                                       $this->Cell(10,5,'I.V.A. '.$this->recarg.'% :');
  //                                      $this->SetX(174);
   //                                     $this->Cell(31,5,H::FormatoMonto($rgo),0,0,"R");

                                   // }

					$ref=$this->arrp[$this->i]["ordcom"];
					$this->SetFont("Arial","",8);
					$this->subtotal2=0;
					$this->subtotal=0;
					$this->SetXY(150,220);
					$this->Cell(10,5,'SUB TOTAL:',0,0,'');
					$this->SetXY(174,220);
					$this->Cell(31,5,H::FormatoMonto($subtotal),0,0,"R");

				   foreach($this->arrp2 as $registro)

                                   {

                                        $this->recarg=round($registro["porcen"]);
                                        $rgo=$registro["suma"];

                                        $this->SetXY(150,$this->GetY()+5);
                                        $this->Cell(10,5,'I.V.A. '.$this->recarg.'% :');
                                        $this->SetX(174);
                                        $this->Cell(31,5,H::FormatoMonto($rgo),0,0,"R");
					$sumador = $sumador + $rgo;
                                    }



				//	$this->SetXY(150,$this->GetY()+5);
				//	$this->Cell(10,5,'I.V.A. '.$this->recarg.'% :');
				//	$this->SetX(174);
				//	$this->Cell(31,5,H::FormatoMonto($rgo),0,0,"R");

					$this->SetXY(150,$this->GetY()+5);
					$this->Cell(10,5,'TOTAL:',0,0,'');
					$this->SetX(174);
				//	$this->Cell(31,5,H::FormatoMonto($subtotal+($rgo)),0,0,"R");
					$this->Cell(31,5,H::FormatoMonto($subtotal+($sumador)),0,0,"R");

					$this->SetXY(20,226);
				//	$this->MultiCell(105,4,H::obtenermontoescrito($subtotal+($rgo)),0,'L',0);
					$this->MultiCell(105,4,H::obtenermontoescrito($subtotal+($sumador)),0,'L',0);
					$this->SetXY(174,222);
					$this->SetXY(105,240);
					$this->Cell(90,3,$usuario);
                                        #$this->ImprimeCajaFirmas();

					if($this->i < $eof)
					{
						$this->AddPage();
						$detcat=false;
						$aun=false;

					}
					$band=false;
					$contador=1;
					$subtotal=0;
					$rgo=0;
				}
			}
                        #CAJAS   2
                        #$this->ImprimeCajaFirmas();

		}
	}
?>
