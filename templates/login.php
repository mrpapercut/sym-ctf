<?php

require_once('php/db.class.php');

$loginresult = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
	$db = new DB();

	if ($id = $db->loginUser((string) $_POST['username'], (string) $_POST['password'])) {
		$_SESSION['user'] = $id;
		header('Location: /challenges');
	} else {
		$loginresult = '<h2 class="error">Error: invalid login</h2>';
	}
}

include_once('templates/header.php');
?>

<section id="content">
<?php echo $loginresult; ?>
<form action="" method="post">
	<input type="username" id="username" name="username" placeholder="Username">
	<input type="password" id="password" name="password" placeholder="Password">
	<button>Submit</button>
</form>
<h3>No account? <a href="/register">Register here</a></h3>
</section>

<?php

include_once('templates/footer.php');