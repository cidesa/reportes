<?php require_once("lib/yaml/Yaml.class.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Menú de Reportes</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Menu principal de los reportes del SIGA-SL" />
        <meta name="keywords" content="jquery, drop down, menu, navigation, large, mega, siga, reportes "/>
		<link rel="stylesheet" href="lib/css/style.css" type="text/css" media="screen"/>
        <style>
            *{
                padding:0;
                margin:0;
            }
			body{
                background:#f0f0f0;
                font-family:"Helvetica Neue",Arial,Helvetica,Geneva,sans-serif;
				overflow-x:hidden;

            }
            h1{
                font-size:110px;
                line-height:180px;
                text-transform: uppercase;
                color:#f9f9f9;
                position:absolute;
                text-shadow:0 1px 1px #ddd;
                top:-25px;
                left:-20px;
                white-space: nowrap;
            }
            span.reference{
                position:fixed;
                left:10px;
                bottom:10px;
                font-size:11px;
            }
            span.reference a{
                color:#DF7B61;
                text-decoration:none;
                text-transform: uppercase;
                text-shadow:0 1px 0 #fff;
            }
            span.reference a:hover{
                color:#000;
            }
            .box{
                margin-top:129px;
                height:460px;
				width:100%;
                position:relative;
                background:#fff url(click.png) no-repeat 380px 180px;
				-moz-box-shadow:0px 0px 10px #aaa;
				-webkit-box-shadow:0px 0px 10px #aaa;
				-box-shadow:0px 0px 10px #aaa;
            }
            .box h2{
				color:#f0f0f0;
				padding:40px 10px;
				text-shadow:1px 1px 1px #ccc;
            }

        </style>
    </head>
    <body>
		<h1>Menú de Reportes</h1>
		<div class="box">
			<ul id="ldd_menu" class="ldd_menu">
                          <?php $opciones = $opciones = Yaml::load("reportes/reportes.yml"); //print '<pre>';print_r($opciones); ?>
                          <?php $menu=''; $menu = isset($_GET['menu']) ? $_GET['menu'] : ''; ?>
                          <?php if($menu=='') : ?>
                                <li>
                                <span>Reportes Por Módulos</span><!-- Increases to 510px in width-->
                                <div class="ldd_submenu">
                                      <ul>
                                      <?php foreach($opciones as $index => $opc) : ?>
                                            <?php if(!strstr($index, 'urls')) : ?>
                                                    <li><a href="index.php?menu=<?php echo $index; ?>"><?php echo $index ?></a></li>
                                             <?php endif; ?>
                                      <?php endforeach; ?>
                                      </ul>
                                </div>
                                </li>
                          <?php else: ?>
                                          <li>
                                            <span><a href="index.php" >Volver</a></span><!-- Increases to 510px in width-->
                                          </li>
                            <?php foreach($opciones as $index => $opc) : ?>
                                  <?php if(strstr($index, $menu)) : ?>
                                          <li>
                                                  <span><?php echo $index ?></span><!-- Increases to 510px in width-->
                                                  <div class="ldd_submenu">
                                                  <?php foreach($opc as $i => $m) : ?>
                                                          <ul>
                                                          <?php if(is_array($m)) : ?>
                                                                  <li class="ldd_heading"><?php echo $i ?></li>
                                                                  <?php foreach($m as $ii => $mm) : ?>
                                                                        <?php if(!is_array($mm)) : ?>
                                                                              <li><a href="<?php echo 'reportes/'.$index.'/'.$mm ?>"><?php echo $ii ?></a></li>
                                                                        <?php endif; ?>
                                                                  <?php endforeach; ?>
                                                          <?php else: ?>
                                                                  <li><a href="<?php echo 'reportes/'.$index.'/'.$m; ?>"><?php echo $i ?></a></li>
                                                          <?php endif; ?>
                                                          </ul>
                                                  <?php endforeach; ?>
                                                  </div>
                                          </li>
                                  <?php endif; ?>
                            <?php endforeach; ?>

                          <?php endif; ?>

			</ul>
		</div>

        <div>
            <span class="reference">
                <a href="http://tympanus.net/codrops/2010/07/14/ui-elements-search-box/">© Codrops - back to post</a>
            </span>
        </div>
		<!-- The JavaScript -->
        <script type="text/javascript" src="lib/general/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
				/**
				 * the menu
				 */
				var $menu = $('#ldd_menu');

				/**
				 * for each list element,
				 * we show the submenu when hovering and
				 * expand the span element (title) to 510px
				 */
				$menu.children('li').each(function(){
					var $this = $(this);
					var $span = $this.children('span');
					$span.data('width',$span.width());

					$this.bind('mouseenter',function(){
						$menu.find('.ldd_submenu').stop(true,true).hide();
						$span.stop().animate({'width':'510px'},300,function(){
							$this.find('.ldd_submenu').slideDown(300);
						});
					}).bind('mouseleave',function(){
						$this.find('.ldd_submenu').stop(true,true).hide();
						$span.stop().animate({'width':$span.data('width')+'px'},300);
					});
				});
            });
        </script>
    </body>
</html>