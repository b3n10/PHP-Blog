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

$bodyText = htmlEscape($row['body']);
$paragraph = str_replace("\n", "<p></p>", $bodyText);
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
			<?= convertSQLDate($row['created_at']) ?>
		</div>
		<p>
			<?= $paragraph ?>
		</p>
		<h3><?= countCommentsForPost($postID); ?> comments</h3>
		<div>
			<?php foreach (getCommentsForPost($postID) as $comments): ?>
				Comment from <?= $comments['name'] ?> on <?= convertSQLDate($comments['created_at']) ?>
				<p>
					<?= $comments['text'] ?>
				</p>
			<?php endforeach ?>
		</div>
	</body>
</html>
