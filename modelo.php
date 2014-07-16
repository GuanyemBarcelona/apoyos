<?php

include("config.php");

// Conecta a la base de datos
$mi_conf['link'] = mysql_connect ( $mi_conf['bd_host'], $mi_conf['bd_login'], $mi_conf['bd_password'] ) or die(mysql_error());
mysql_select_db( $mi_conf['bd_database'] ) or die(mysql_error());
// Nos aseguramos que no hay problemas de codificación, todo UTF-8
@mysql_query("SET NAMES 'utf8'");

// Obtiene todos los campos de la $tabla, donde se cumpla el $where
// Devuelve un array ['num_datos'], ['num_total'] y ['datos']
function bd_select($tabla, $campos='*', $where='', $limit='') {
	$sql = 'SELECT '.$campos.' FROM '.$tabla.' '.$where.' '.$limit;
	$result = mysql_query($sql) or die(mysql_error());
	//$sql = 'SELECT FOUND_ROWS() as total';
	/*$sql = 'SELECT COUNT(*) AS total FROM '.$tabla.' '.$where;
	$total = mysql_query($sql) or die(mysql_error());
	$row['num_total'] = mysql_fetch_assoc($total)['total'];
	mysql_free_result($total);*/
	$row['num_total'] = bd_count();
	$row['num_datos'] = mysql_num_rows($result);
	$aResults = array();
	while ($datos = mysql_fetch_array($result))
		array_push($aResults, $datos);
	$row['datos'] = $aResults;
	mysql_free_result($result);

	return $row;
}

function bd_count ($tabla='apoyos', $where='') {
	$sql = 'SELECT COUNT(*) AS total FROM '.$tabla.' '.$where;
	$totales = mysql_query($sql) or die(mysql_error());
	$total = mysql_fetch_assoc($totales)['total'];
	mysql_free_result($totales);
	return intval($total);
}
/*
 * APOYOS:
 */

function instalar() {
	$sql = 'CREATE  TABLE IF NOT EXISTS `apoyos` ('.
	'  `id_apoyo` INT NULL AUTO_INCREMENT ,'.
	'  `nombre` VARCHAR(150) NOT NULL ,'.
	'  `dni` VARCHAR(10) NOT NULL ,'.
	'  `tiempo` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,'.
	'  `actividad` VARCHAR(150) NOT NULL ,'.
	'  `provincia` VARCHAR(150) NOT NULL ,'.
	'  `pais` VARCHAR(2) NOT NULL ,'.
	'  `ciudad` VARCHAR(150) NOT NULL ,'.
	'  `barrio` VARCHAR(150) NOT NULL ,'.
	'  `correo` VARCHAR(150) NOT NULL ,'.
	'  `estado` TINYINT NOT NULL ,'.
	'  `visible` TINYINT NOT NULL DEFAULT 0 ,'.
	'  `boletin` TINYINT NOT NULL DEFAULT 0 ,'.
	'  `codigo_validacion` VARCHAR(32) NOT NULL ,'.
	'  PRIMARY KEY (`id_apoyo`) )'.
	' ENGINE = InnoDB'.
	' DEFAULT CHARACTER SET = utf8'.
	' COLLATE = utf8_general_ci;';
	mysql_query($sql) or die(mysql_error());
}

function getApoyos($desc='', $where='',$n_pagina=1) {
	$n_pagina = intval($n_pagina);
	if ($n_pagina < 1) $n_pagina = 1;
	$offset = ($n_pagina - 1) * NUM_RESULTADOS_PAGINA;
	//echo "offset: ".$offset." pag:".$n_pagina;
	//$where .= ' ORDER BY tiempo DESC LIMIT '.$mi_conf['num_resultados_pagina'].', '.$offset;
	//echo "<br><br>num_resultados_pagina: ".$mi_conf['num_resultados_pagina']."<br>";
	$where .= ' ORDER BY tiempo '.$desc;
	$limit = ' LIMIT '.$offset.','.NUM_RESULTADOS_PAGINA;
	return bd_select('apoyos', 'nombre,actividad,ciudad,pais,visible', $where, $limit);
}


// OJO: Considera todo válido
function nuevoApoyo($apoyo) {
	$codigo_validacion=md5( rand( 0, 100000 ) );

	$sql='INSERT INTO apoyos (nombre, dni, actividad, provincia, pais, ciudad, barrio, correo, estado, visible, boletin, codigo_validacion) '.
	'VALUES ('.
	'"'.$apoyo['nombre'].'", '.
	'"'.$apoyo['dni'].'", '.
	'"'.$apoyo['actividad'].'", '.
	'"'.$apoyo['provincia'].'", '.
	'"'.$apoyo['pais'].'", '.
	'"'.$apoyo['ciudad'].'", '.
	'"'.$apoyo['barrio'].'", '.
	'"'.$apoyo['correo'].'", '.
	'0,'.
	'"'.$apoyo['visible'].'", '.
	'"'.$apoyo['boletin'].'", '.
	'"'.$codigo_validacion.'"'.
	');';

	mysql_query($sql) or die(mysql_error());

	// Enviamos mail con el código
	$id_apoyo=mysql_insert_id();

	$dominio	= 'guanyembarcelona.cat';
	$url		= 'https://'.$dominio.'/apoyos/validar.php?id_apoyo='.$id_apoyo.'&codigo_validacion='.$codigo_validacion;
	$destino 	= $apoyo['correo'];
	$remite 	= 'info@'.$dominio;
	$cabeceras 	= "From: $remite\nReply-To: $remite\n";
	$asunto		= "Guanyem Barcelona";
	$contenido	= "\n\n[CA]\nHola.\n\n".
		"Reps aquest correu perquè has donat suport a la plataforma ciutadana Guanyem Barcelona."."\n\n".
		"Per tal de validar el teu correu electrònic et demanem, com a últim pas, que cliquis al següent enllaç:"."\n\n".
		$url."\n\n".
		"Benvingut/da a la revolució democràtica!".
		"\n\n[ES]\nHola.\n\n".
		"Recibes este correo porque has dado tu apoyo a la plataforma ciudadana Guanyem Barcelona."."\n\n".
		"Para poder validar tu correo electrónico te pedimos, cómo último paso, que hagas clic en el siguiente enlace:"."\n\n".
		$url."\n\n".
		"¡Bienvenido/a a la revolución democrática!";

	if (mail($destino, $asunto ,$contenido ,$cabeceras)) {
		setEstado($id_apoyo, 1);
	} else {
		setEstado($id_apoyo, -1);
	}
}

function setEstado($id_apoyo, $estado) {
	//TODO mysql_insert_id()
	$sql='UPDATE apoyos SET estado='.$estado.' WHERE id_apoyo='.$id_apoyo;
	mysql_query($sql) or die(mysql_error());
}
