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

function convertSQLDate($key) {
	$date = DateTime::createFromFormat("Y-m-d H:i:s", $key);
	//return $key;
	return $date->format("d M Y, H:i:s");
}

function redirectAndExit($script) {
	// Get the domain-relative URL (e.g. /blog/whatever.php or /whatever.php) and work
	// out the folder (e.g. /blog/ or /).
	$relativeUrl = $_SERVER['PHP_SELF'];
	$urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, '/') + 1);

	// Redirect to the full URL (http://myhost/blog/script.php)
	$host = $_SERVER['HTTP_HOST'];
	$fullUrl = 'http://' . $host . $urlFolder . $script;
	header('Location: ' . $fullUrl);

	exit();
}

function countCommentsForPost($postId) {
	$pdo = getPDO();
	$sql = "
	SELECT
		COUNT(*) c
	FROM
		comment
	WHERE
		post_id = :post_id
	";

	$stmt = $pdo->prepare($sql);
	$stmt->execute(
		array('post_id' => $postId, )
	);

	return (int) $stmt->fetchColumn();
}

function getCommentsForPost($postId) {
	$pdo = getPDO();

	$sql = "
	SELECT
		id, name, text, created_at, website
	FROM
		comment
	WHERE
		post_id = :post_id
	";

	$stmt = $pdo->prepare($sql);
	$stmt->execute(
		array('post_id' => $postId, )
	);

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
