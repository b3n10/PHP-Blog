<?php

function getRootPath() {
	return $root = realpath(__DIR__ . "/..");
}

function getDatabasePath() {
	return $database = getRootPath() . "/data/data.sqlite";
}

function getPDO() {
	return $pdo = new PDO( "sqlite:" . getDatabasePath() );
}

function htmlEscape($key) {
	return htmlspecialchars($key, ENT_HTML5, "UTF-8"); 
}
