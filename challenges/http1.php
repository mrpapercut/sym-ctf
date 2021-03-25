<?php

$answer = 'supersecretpassword';
$successMsg = '';

if ($this->challengeDetails) {
	$challengeid = $this->challengeDetails['id'];
	$score = $this->challengeDetails['score'];
	$passed = (bool) $this->challengeDetails['passed'];
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
    <input id="flag" name="flag" type="text" autofocus>
    <button>Submit</button>
</form>
</section>

<script>
document.forms[0].addEventListener('submit', function(e) {
    e.preventDefault();

    if (document.getElementById('flag').value === '<?php echo $answer; ?>') {
        this.submit();
    } else {
        document.location.reload();
    }
});
</script>

<?php
include_once('templates/footer.php');