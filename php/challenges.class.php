<?php

class Challenges {

    public $db;
    public $challengeMap;
    public $challengeDetails;
	public $allChallenges;

    public function __construct() {
        $this->db = new DB();

        $this->challengeMap = array(
			'index' => 'list.php',
            'Test1' => 'http1.php',
            'Test2' => '',
			'Test3' => 'http2.php',
			'Test4' => 'http3.php'
        );
    }

    public function loadChallenge() {
		if (!isset($_SESSION) OR !isset($_SESSION['user'])) header('Location: /login');

        $this->allChallenges = $this->db->getChallenges();

        try {
            if (isset($_GET['id']) && $challengeid = intval($_GET['id'])) {
				if (!isset($this->allChallenges[$challengeid])) {
					$challenge = array('name' => 'index');
				} else {
					$challenge = $this->allChallenges[$challengeid];
				}
			} else {
				$challenge = array('name' => 'index');
			}
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $this->challengeDetails = $this->db->getChallengeDetails($challengeid, $_SESSION['user']);

        include_once('challenges/'.$this->challengeMap[$challenge['name']]);
        include_once('templates/footer.php');
    }

	public function loadScoreboard() {
		include_once('templates/scoreboard.php');
	}
}
