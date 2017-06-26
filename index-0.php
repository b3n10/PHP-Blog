<?php
//Work out the path to the database, so SQLite/PDO can connect
$root = __DIR__;
$database = $root . "/data/data.sqlite";
$dsn = "sqlite:" . $database;

//Connect to the databse, run query, handle errors
$pdo = new PDO($dsn);
$stmt = $pdo->query(
	'SELECT
		title, created_at, body
	FROM
		post
	ORDER BY
		created_at DESC'
);

if ($stmt === false) {
	throw new Exception("There was a problem running this query.");
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Index</title>
	</head>
	<body>
		<h1>Blog title</h1>
		<p>This is the title paragraph..</p>

		<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
		<h2><?= htmlspecialchars($row['title'], ENT_HTML5, "UTF-8") ?></h2>
		<div>
			<?= htmlspecialchars($row['created_at'], ENT_HTML5, "UTF-8") ?>
		</div>
		<p>
			<?= htmlspecialchars($row['body'], ENT_HTML5, "UTF-8") ?>
		</p>
		<p>
			<a href="#">Read more..</a>
		</p>
		<?php endwhile ?>
	</body>
</html>
