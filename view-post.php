<?php
$root = __DIR__;
$database = $root . "/data/data.sqlite";
$dsn = "sqlite:" . $database;

//connect, run, handle errors
$pdo = new PDO($dsn);
$stmt = $pdo->prepare(
	'SELECT
		title, created_at, body
	FROM
		post
	WHERE
		id = :id'
);

if ($stmt === false) {
	throw new Exception("There was a problem running prepare query.");
}

$result = $stmt->execute(
	array('id' => 1)
);	

if ($result === false) {
	throw new Exception("There was a problem running execute query");
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>A blog application | <?= htmlspecialchars($row['title'], ENT_HTML5, "UTF-8") ?></title>
	</head>
	<body>
		<h1>Blog title</h1>
		<p>A summary of the blog.</p>
		<h2>
			<?= htmlspecialchars($row['title'], ENT_HTML5, "UTF-8") ?>
		</h2>
		<div>
			<?= htmlspecialchars($row['created_at'], ENT_HTML5, "UTF-8") ?>
		</div>
		<p>
			<?= htmlspecialchars($row['body'], ENT_HTML5, "UTF-8") ?>
		</p>
	</body>
</html>
