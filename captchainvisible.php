<?php

session_start();
$_SESSION['captchainvisible'] = md5( rand( 0, 100000 ) );
header( 'Content-type: text/javascript' );
echo ('document.write("<input type=\'hidden\' name=\'captchainvisible\' value=\''.$_SESSION['captchainvisible'].'\' />");');
