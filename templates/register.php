<?php

require_once('php/db.class.php');

$registerresult = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
	$db = new DB();

	if ($id = $db->registerUser((string) $_POST['username'], (string) $_POST['password'])) {
		$_SESSION['user'] = $id;
		header('Location: /challenges');
	} else {
		$loginresult = '<h2 class="error">Error: failed to register user</h2>';
	}
}

include_once('templates/header.php');
?>

<section id="content">
<?php echo $registerresult; ?>
<form action="" method="post">
	<input type="username" id="username" name="username" placeholder="Username">
	<input type="password" id="password" name="password" placeholder="Password">
	<button>Submit</button>
</form>
</section>

<?php

include_once('templates/footer.php');