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
	$date = DateTime::createFromFormat("Y-m-d", $key);
	return $date->format("d M Y");
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
