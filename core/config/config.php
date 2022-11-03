<?php
#Caminhos absolutos
$pastaInterna="github/system-auto-bank/";

define('DIRPAGE',"http://{$_SERVER['HTTP_HOST']}/{$pastaInterna}");
(substr($_SERVER['DOCUMENT_ROOT'],-1)=='/')?$barra="":$barra="/";
define('DIRREQ',"{$_SERVER['DOCUMENT_ROOT']}{$barra}{$pastaInterna}");

#Atalhos
define('DIRCSS', DIRPAGE.'assets/css/');
define('DIRIMG', DIRPAGE.'assets/images/');
define('DIRJS', DIRPAGE.'assets/js/');

#Acesso ao db
define('HOST',"localhost");
define('DB',"auto-bank");
define('USER',"root");
define('PASS',"");

#Outros
define("DOMAIN",$_SERVER["HTTP_HOST"]);