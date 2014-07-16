<?php
	$error = '';

	if (isset($_POST['dni'])) {
		// Recibido apoyo por post
		// Validemos CAPTCHA
		session_start();
		if (!isset($_SESSION['captchainvisible']) || ($_SESSION['captchainvisible'] != $_POST['captchainvisible'])) {
			$error = 'CAPTCHA';
		} else {
			// Validamos POST
			$argumentos = array(
				'nombre'				=> FILTER_SANITIZE_STRING,
				'dni'				=> array(
										'filter'		=> FILTER_VALIDATE_REGEXP,
										'options'	=> array ('regexp' => '/^$|^[A-Z0-9]{9}$/')
				),
				'actividad'				=> FILTER_SANITIZE_STRING,
				'provincia'				=> array(
										'filter'		=> FILTER_VALIDATE_REGEXP,
										'options'	=> array ('regexp' => '/^[\w ñÑáéíóúàèìòùÁÉÍÓÚÀÈÌÒÙäëïöüÄËÏÖÜâêîôûÂÊÎÔÛ,\/]{4,150}$/')
				),
				'pais'				=> array(
										'filter'		=> FILTER_VALIDATE_REGEXP,
										'options'	=> array ('regexp' => '/^[A-Z]{2}$/')
				),/*
				'ciudad'				=> array(
										'filter'		=> FILTER_VALIDATE_REGEXP,
										'options'	=> array ('regexp' => '/^[\w ñÑáéíóúàèìòùÁÉÍÓÚÀÈÌÒÙäëïöüÄËÏÖÜâêîôûÂÊÎÔÛ\',çÇ]{2,150}$/')
				),*/
				'ciudad'				=> FILTER_SANITIZE_STRING,
				'barrio'				=> FILTER_SANITIZE_STRING,
				'correo'				=> array(
										'filter'		=> FILTER_VALIDATE_REGEXP,
										'options'	=> array ('regexp' => '/^\w[\w\d\.\-_]+@\w[\w\d\.\-_]+$/')
				),
				'visible'			=> FILTER_VALIDATE_INT,
				'boletin'			=> FILTER_VALIDATE_INT
			);
			$apoyo = filter_input_array(INPUT_POST, $argumentos);

			foreach ($apoyo as $campo => $valor) {
				if (($valor === NULL) || ($valor === false)) $error = $campo;
			}
			// Si no hay error, guardamos en la base de datos
			if ($error == '') {
				// Conectamos a la base de datos
				include ("modelo.php");
				nuevoApoyo($apoyo);
			}
		}
	}
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head lang="es">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Apoyos Guayem Barcelona</title>
        <meta name="description" content="Apoyos Guayem Barcelona">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link href='//fonts.googleapis.com/css?family=Volkhov:400,400italic,700italic,700' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Raleway:900,200,400' rel='stylesheet' type='text/css'>
        <link href="//fonts.googleapis.com/css?family=Droid+Serif:400italic,400,700italic,700" rel="stylesheet" type="text/css">

<!-- include the core styles -->
<link rel="stylesheet" href="css/alertify.core.css" />
<!-- include a theme, can be included into the core instead of 2 separate files -->
<link rel="stylesheet" href="css/alertify.default.css" />

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">Estás usand un navegador <stong>obsoleto</strong>. Prueba a <a href="http://browsehappy.com/">actualizarlo</a>.</p>
        <![endif]-->

		<div id="pagina" class="adhesiones">
	<?php if (isset($_POST['dni']) && ($error == '')) { ?> 
		<p class="aviso ok"><strong>Registrat amb èxit. Moltes gràcies!</strong><br>
		Per poder tirar endavant aquest projecte necessitem reunir 30.000 signatures, aconseguim-ho entre totes! Ara et toca a tu animar a les teves amistats a signar per Guanyem Barcelona.<br>
		<a href="#" onClick="window.open('http://www.facebook.com/sharer.php?u=https://guanyembarcelona.cat/signa/&t=Signa per a Guanyem Barcelona', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');" class="facebook" title="facebook" rel="nofollow"><img src="https://guanyembarcelona.cat/wp-content/uploads/2014/facebook-24x24.png"></a> <a href="#" onClick="window.open('https://twitter.com/intent/tweet?original_referer=https://guanyembarcelona.cat/signa/&text=Perquè el projecte Guanyem Barcelona es faci realitat es necessiten 30.000 signatures. Jo acabo de signar, i tu?&url=https://guanyembarcelona.cat/signa/', 'twitter_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');" class="twitter" title="twitter" rel="nofollow"><img src="https://guanyembarcelona.cat/wp-content/uploads/2014/twitter-24x24.png"></a></p>
	<?php
	 	} 
		if (isset($_POST['dni']) && ($error != '')) { ?> 
		<p class="aviso error">Error en el camp <?php echo $error; ?>.</p>
	<?php
		}
	?>
        <h2>Signa el manifest:</h2>
        <p class="title">Per donar suport podeu validar la proposta omplint el següent formulari. El procés de validació es tancarà el 15 de setembre. Durant aquest termini, ens hem proposat recollir almenys 30.000 signatures electròniques, de les quals la meitat com a mínim han de ser de Barcelona ciutat.</p>
		<form id="nuevo" action="nuevo_share.php" method="post">


                <div class="half" id="grupo_nombre">
			        <label for="nombre">Nom complet</label>
			        <input id="nombre" name="nombre" type="text" required>
			    </div>

                <div class="half" id="grupo_dni">
                <label for="dni">DNI-NIE</label>
                <input id="dni" name="dni" type="text" placeholder="Ej: 12345678Z">
                </div>

                <div class="half" id="grupo_correo">
                    <label for="correo">Correu electrònic</label>
                    <input id="correo" name="correo" type="email" required>
                </div>

			    <div class="half" id="grupo_actividad">
                    <label for="actividad">Activitat</label>
                    <input id="actividad" name="actividad" type="text">
                </div>


                <div class="third" id="grupo_provincia">
                    <label for="provincia">Província</label>
                    <input id="provincia" name="provincia" type="hidden">
                    <select id="select_provincia">
                    </select>
                </div>

                <div class="third" id="grupo_pais">
                    <label for="pais">País</label>
                    <input id="pais" name="pais" type="hidden">
                    <select id="select_pais">
                    </select>
                </div>

                <div class="third" id="grupo_ciudad">
                    <label for="ciudad">Ciutat</label>
                    <input id="ciudad" name="ciudad" type="hidden">
                    <select id="select_ciudad">
                    </select>
                </div>

                <div class="third" id="grupo_barrio">
                    <label for="barrio">Barri</label>
                    <input id="barrio" name="barrio" type="hidden">
                    <select id="select_barrio">
                    </select>
                </div>



			<script type="text/javascript" src="captchainvisible.php"></script>

            <div class="check">
				<input id="visible" name="visible" type="hidden" value="1">
                <input id="checkbox_visible" type="checkbox" checked>
                <label>Vull que el meu suport sigui visible</label>
            </div>
            <div class="check">
				<input id="boletin" name="boletin" type="hidden" value="1">
                <input id="checkbox_boletin" type="checkbox" checked>
                <label>Vull mantenir-me informat via correu electrònic sobre la plataforma Guanyem Barcelona</label>
            </div>

            <input type="submit" value="Dóna el teu suport">

			<p style="clear:both;"><em>Per validar el teu correu electrònic t'hem enviat un mail amb un enllaç 
			que hauràs de clicar. Repassa la teva carpeta de spam (correu brossa) si no ho has rebut en les següents hores.</em></p>
		</form>
		</div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
		<!--<script src="js/vendor/js-webshim/minified/polyfiller.js"></script>-->
        <script src="js/ciudades.js"></script>

<script src="js/vendor/alertify.min.js"></script>

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
