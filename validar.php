<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head lang="es">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Validación de correo</title>
        <meta name="description" content="Apoyos Guayem Barcelona">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <link href='//fonts.googleapis.com/css?family=Volkhov:400,400italic,700italic,700' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Raleway:900,200,400' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=IM+Fell+Great+Primer:400,400italic' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">Estás usando un navegador <stong>obsoleto</strong>. Prueba a <a href="http://browsehappy.com/">actualizarlo</a>.</p>
        <![endif]-->

		<div id="pagina">
			<h1>Validación de correo</h1>
<?php
include("modelo.php");

$contenido['ca']['exito'] = '<section lang="ca"><h2>Validació completada amb èxit</h2>'.
	'<p>La teva validació s\'ha realitzat amb èxit. Moltes gràcies pel teu suport a Guanyem Barcelona.</p>'.
	'<p>Per sol·licitar la baixa o rectificació de les dades de la teva adhesió, envia\'ns un mail a '.
	'<a href="mailto:info@guanyembarcelona.cat">info@guanyembarcelona.cat</a></p></section>';

$contenido['es']['exito'] = '<section lang="es"><h2>Validación completada con éxito</h2>'.
	'<p>Tu validación se ha realizado con éxito. Muchas gracias por tu apoyo a Guanyem Barcelona.</p>'.
	'<p>Para solicitar la baja o rectificación de los datos de tu adhesión, envíanos un mail a '.
	'<a href="mailto:info@guanyembarcelona.cat">info@guanyembarcelona.cat</a></p></section>';

$contenido['ca']['fallo'] = '<section lang="ca"><h2>Enllaç no vàlid.</h2></section>'.
	'<p>Si necessita ajuda amb el procés d\'adhesió a Guanyem Barcelona, escrigui a '.
	'<a href="mailto:info@guanyembarcelona.cat">info@guanyembarcelona.cat</a></p></section>';

$contenido['es']['fallo'] = '<section lang="es"><h2>Enlace no válido</h2>'.
	'<p>Si necesita ayuda con el proceso de adhesión a Guanyem Barcelona, escriba a '.
	'<a href="mailto:info@guanyembarcelona.cat">info@guanyembarcelona.cat</a></p></section>';


if (!isset($_GET['id_apoyo']) || !isset($_GET['codigo_validacion'])) {
	echo $contenido['ca']['fallo'].$contenido['es']['fallo'];
} else {
	$id_apoyo=intval($_GET['id_apoyo']);
	$codigo_validacion=$_GET['codigo_validacion'];
	$apoyo=bd_select('apoyos', 'id_apoyo,codigo_validacion', 'WHERE id_apoyo='.$id_apoyo, 'LIMIT 1');
	$apoyo=$apoyo['datos'][0];
	if ($apoyo['codigo_validacion'] == $codigo_validacion) {
		setEstado($id_apoyo,2);
		echo $contenido['ca']['exito'].$contenido['es']['exito'];
	} else {
		echo $contenido['ca']['fallo'].$contenido['es']['fallo'];
	}
}

?>
		</div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>

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
