<?php
require_once "lib/common.php";

if ( isset($_GET['post_id']) ) {
	$postID = $_GET['post_id'];
} else {
	$postID = 0;
}

//connect, run, handle errors
$pdo = getPDO();
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
	array('id' => $postID)
);	

if ($result === false) {
	throw new Exception("There was a problem running execute query");
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>A blog application | <?= htmlEscape($row['title']) ?></title>
	</head>
	<body>
		<?php require 'templates/title.php' ?>
		<h2>
			<?= htmlEscape($row['title']) ?>
		</h2>
		<div>
			<?= htmlEscape($row['created_at']) ?>
		</div>
		<p>
			<?= htmlEscape($row['body']) ?>
		</p>
	</body>
</html>
