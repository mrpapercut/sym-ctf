<?php
$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$prot = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on' ? 'https' : 'http';
$base = $prot.'://'.$host.$path.'/';

require_once('php/user.class.php');

if (isset($_SESSION) && isset($_SESSION['user'])) {
	$user = new User();

	$score = 0;
	$username = '';
	$loggedin = false;

	try {
		$score = $user->parseScore($user->db->getCompleted($_SESSION['user']));

		if ($score === false) {
			throw new Exception('Error loading user challenges');
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}

	$loggedin = true;
	$score = $score;
	$username = $user->db->getUsername($_SESSION['user']);
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">

<base href="<?php echo $base; ?>">

<link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<title>Capture the Flag</title>
<link rel="shortcut icon" href="favicon.png" type="image/png" />
</head>
<body>
<section id="header">
	<div id="logo"><a href="/"></a></div>
<?php if ($loggedin) { ?>
	<div id="user">
		<div id="username"><?php echo $username; ?></div>
		<div id="userscore"><?php echo $score; ?></div>
		<a href="/logout">log out</a>
	</div>
<?php } ?>
</section>
