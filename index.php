<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head lang="es">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Persones adherides</title>
        <meta name="description" content="Apoyos Guayem Barcelona">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <link href='//fonts.googleapis.com/css?family=Volkhov:400,400italic,700italic,700' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Raleway:900,200,400' rel='stylesheet' type='text/css'>
        <link href="//fonts.googleapis.com/css?family=Droid+Serif:400italic,400,700italic,700" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">Estàs utilitzant un navegador <stong>obsolet</strong>. Prova a <a href="http://browsehappy.com/">actualitzar-ho</a>.</p>
        <![endif]-->

		<div id="pagina" class="adhesionsTotals">
			<h1>Persones adherides / Personas adheridas</h1>
<?php
include("modelo.php");
if (isset($_GET['pagina'])) {
	$pagina = intval($_GET['pagina']);
} else {
	$pagina = 1;
}
$ultimas=getApoyos('DESC','',$pagina);
$total_paginas=ceil($ultimas['num_total']/NUM_RESULTADOS_PAGINA);
echo '<h2>'.$ultimas['num_total'].' signatures / firmas</h2>';
/*
echo 'num_datos: '.$ultimas['num_datos'].'<br>';
echo 'num_total: '.$ultimas['num_total'].'<br>';
echo 'total paginas: '.ceil($ultimas['num_total']/5).'<br><br>';
*/
$ultimas = $ultimas['datos'];
echo '<table>';
echo '<tr>';
echo '<th>Nom / Nombre</th>';
echo '<th>Activitat / Actividad</th>';
echo '<th>Ciutat / Ciudad</th>';
echo '</tr>';
foreach ($ultimas as $apoyo) {
	$nombre = '****** ********';
	if ($apoyo['visible'] == 1) $nombre = $apoyo['nombre'];
	$ciudad = htmlentities(htmlspecialchars_decode($apoyo['ciudad'], ENT_QUOTES));
	if ($ciudad == "NC") $ciudad = '<span class="codigo_pais">'.$apoyo['pais'].'</span>';
	echo '<tr>';
	echo '<td>'.htmlentities(htmlspecialchars_decode($nombre, ENT_QUOTES)).'</td>';
	echo '<td>'.htmlentities(htmlspecialchars_decode($apoyo['actividad'], ENT_QUOTES)).'</td>';
	echo '<td>'.$ciudad.'</td>';
	echo '</tr>';
}
echo '</table><p></p>';
if ($pagina > 1) {
	echo '<div style="position:fixed; bottom:10px; left:10px;" class="boton"><a href="?pagina='.($pagina-1).'">Página anterior</a></div>';
}
if ($pagina < $total_paginas) {
	echo '<div style="position:fixed; bottom:10px; right:10px;" class="boton"><a href="?pagina='.($pagina+1).'">Pàgina següent/siguiente</a></div>';
}
?>
		</div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/ciudades.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-51940264-1');ga('send','pageview');
        </script>
    </body>
</html>
