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
            <p class="browsehappy">Estás usando un navegador <stong>obsoleto</strong>. Prueba a <a href="http://browsehappy.com/">actualizarlo</a>.</p>
        <![endif]-->

		<div id="pagina" class="adhesiones">
	<?php if (isset($_POST['dni']) && ($error == '')) { ?> 
		<p class="aviso ok"><strong>¡Muchas gracias, tu firma ha sido registrada!</strong><br>
		Nos hemos propuesto recoger 30.000 firmas antes del 15 de septiembre. ¡Ayúdanos, te necesitamos! Pásalo y anima a todo el mundo a firmar. ¡Queremos ganar Barcelona!<br>
		<a id="fb_share_cast" href="#" class="facebook" title="facebook" rel="nofollow"><img src="https://guanyembarcelona.cat/wp-content/uploads/2014/facebook-24x24.png"></a> <a id="tw_share_cast" href="#" class="twitter" title="twitter" rel="nofollow"><img src="https://guanyembarcelona.cat/wp-content/uploads/2014/twitter-24x24.png"></a></p>
	<?php
	 	} 
		if (isset($_POST['dni']) && ($error != '')) { ?> 
		<p class="aviso error">Error en el campo <?php echo $error; ?>.</p>
	<?php
		}
	?>
        <h2>Firma el manifiesto:</h2>
        <p class="title">Para apoyar podéis validar la propuesta llenando el siguiente formulario. El proceso de validación se cerrará el 15 de septiembre. Durante este plazo, nos hemos propuesto recoger al menos 30.000 firmas electrónicas, de las cuales la mitad como mínimo tienen que ser de Barcelona ciudad.</p>
		<form id="nuevo" action="nuevo_cast.php" method="post">


                <div class="half" id="grupo_nombre">
			        <label for="nombre">Nombre completo</label>
			        <input id="nombre" name="nombre" type="text" required>
			    </div>

                <div class="half" id="grupo_dni">
                <label for="dni">DNI-NIE</label>
                <input id="dni" name="dni" type="text" placeholder="Ej: 12345678Z">
                </div>

                <div class="half" id="grupo_correo">
                    <label for="correo">Correo electrónico</label>
                    <input id="correo" name="correo" type="email" required>
                </div>

			    <div class="half" id="grupo_actividad">
                    <label for="actividad">Actividad</label>
                    <input id="actividad" name="actividad" type="text">
                </div>


                <div class="third" id="grupo_provincia">
                    <label for="provincia">Provincia</label>
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
                    <label for="ciudad">Ciudad</label>
                    <input id="ciudad" name="ciudad" type="hidden">
                    <select id="select_ciudad">
                    </select>
                </div>

                <div class="third" id="grupo_barrio">
                    <label for="barrio">Barrio</label>
                    <input id="barrio" name="barrio" type="hidden">
                    <select id="select_barrio">
                    </select>
                </div>



			<script type="text/javascript" src="captchainvisible.php"></script>

            <div class="check">
				<input id="visible" name="visible" type="hidden" value="1">
                <input id="checkbox_visible" type="checkbox">
                <label>Quiero que mi nombre no se muestre</label>
            </div>
            <div class="check">
				<input id="boletin" name="boletin" type="hidden" value="0">
                <input id="checkbox_boletin" type="checkbox">
                <label>Quiero mantenerme informado vía correo electrónico sobre la plataforma Guanyem Barcelona</label>
            </div>
            <input type="submit" value="Da tu apoyo">

			<p style="clear:both;"><em>Para validar tu correo electrónico te hemos enviado un mail con un enlace 
			que tendrás que clicar. Repasa tu carpeta de spam si no lo has recibido en las siguientes horas.</em></p>

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
