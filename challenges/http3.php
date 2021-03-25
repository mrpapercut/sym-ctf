<?php

$answer = 'John';
$successMsg = '';

if ($this->challengeDetails) {
	$challengeid = $this->challengeDetails['id'];
	$score       = $this->challengeDetails['score'];
	$passed      = (bool) $this->challengeDetails['passed'];
}

if (isset($_POST['flag']) && $_POST['flag'] === $answer) {
	if (!$passed) $this->db->setCompleted($_SESSION['user'], $challengeid);
    $successMsg = '<h2 class="success">Success!</h2><h3 class="nextchallenge">Continue to the <a href="/challenges">next challenge</a></h3>';
}

include('templates/header.php');

?>

<section id="content" class="challenges">
<?php echo $successMsg; ?>
<?php if ($passed) echo '<h3 class="passed">You already passed this challenge</h3>'; ?>
<form action="" method="post">
	<div class="description">Log in as username John</div>
    <select id="flag" name="flag">
		<option value="James">James</option>
		<option value="Jane">Jane</option>
		<option value="Joanna">Joanna</option>
		<option value="June">June</option>
	</select>
    <button>Submit</button>
</form>
</section>

<?php
include_once('templates/footer.php');