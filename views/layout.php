<?php use Lib\Config; ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?= $title ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
		integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?= Config::get('BASE_URL').'css/style.css' ?>">
		<link rel="stylesheet" type="text/css" href="<?= Config::get('BASE_URL').'css/style_responsive.css' ?>">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?= Config::get('BASE_URL').'js/script.js' ?>"></script>
		<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
	</head>
	<body>
		<?= $content ?>
	</body>
</html>
