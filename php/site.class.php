<?php

require_once('php/db.class.php');
require_once('php/user.class.php');
require_once('php/challenges.class.php');

class Site {

    public function __construct() {
        if (!isset($_SESSION)) session_start();
    }

    public function getPage() {
        try {
            if (!$page = $_GET['page']) {
                throw new Exception('Error: page not found');
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        switch ($page) {
            case 'challenge':
                $challenges = new Challenges();
				$challenges->loadChallenge();
                break;

			case 'score':
				$challenges = new Challenges();
				$challenges->loadScoreboard();
				break;

            case 'login':
				$user = new User();
				$user->loadLogin();
				break;

			case 'logout':
				$user = new User();
				$user->logout();
				break;

            case 'register':
				$user = new User();
				$user->loadRegister();
				break;

            case 404:
            default:
                include_once('templates/404.php');
                break;
        }
    }
}
