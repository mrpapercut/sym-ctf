<?php

$user = new User();

$userscores = array();

foreach ($this->db->getAllScores() as $id => $details) {
	$userscores[$id] = array(
		'name' => $details['name'],
		'score' => $user->parseScore($details['challenges'])
	);
}

usort($userscores, function($a, $b) {
	if ($a['score'] === $b['score']) {
		return $a['name'] < $b['name'] ? -1 : 1;
	} else {
		return $a['score'] > $b['score'] ? -1 : 1;
	}
});

include_once('templates/header.php');
?>

<section id="content" class="challenges scoreboard">
<div id="colhead">
	<div id="coltitle">User</div>
	<div id="colscore">Score</div>
</div>
<?php
foreach ($userscores as $id => $details) {
	echo '<div class="chall-row"><span class="name">'.$details['name'].'</span><span class="score">'.$details['score'].'</div>';
}
?>
</section>
<script>
window.setTimeout(() => {
	document.location.reload();
}, 1e4);
</script>

<?php

include_once('templates/footer.php');