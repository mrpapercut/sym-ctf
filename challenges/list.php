<?php

// Index file for challenges

include_once('templates/header.php');

$completed = $this->db->getCompleted($_SESSION['user']);

?>

<section id="content" class="challenges index">
<div id="colhead">
	<div id="coltitle">Challenge</div>
	<div id="colscore">Score</div>
</div>
<?php
foreach ($this->allChallenges as $id => $chall) {
	$class = 'chall-row';
	if (in_array($chall, $completed)) $class .= ' completed';
	echo '<div class="'.$class.'"><a class="name" href="/challenges/'.$id.'">'.$chall['name'].'</a><span class="score">'.$chall['score'].'</div>';
}
?>
</section>

<?php
include_once('templates/footer.php');