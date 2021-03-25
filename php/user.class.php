<?php

class User {

    public $db;

    public function __construct() {
        $this->db = new DB();
	}

	public function loadLogin() {
		include_once('templates/login.php');
	}

	public function logout() {
		unset($_SESSION['user']);
		header('Location: /');
	}

	public function loadRegister() {
		include_once('templates/register.php');
	}

	public function parseScore($completed) {
		$score = 0;

		foreach ($completed as $chall) {
			$score += $chall['score'];
		}

		return $score;
	}
}