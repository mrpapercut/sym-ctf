<?php

// require_once('config/home-laptop.config.php');
require_once('config/ubuntu-server.config.php');

class DB {
    public $db;

    private $db_user;
    private $db_pass;
    private $db_database;

    public $conn;

    public function __construct() {

        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;
        $this->db_database = DB_NAME;
        $this->db_host = DB_HOST;

        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_database);

    }

    public function registerUser($username, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $password);

        try {

            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }

            $id = $stmt->insert_id;

            if (!$id) {
                throw new Exception('Error: failed to retrieve userid');
            }

            $stmt->close();

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $id;
    }

    public function loginUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE name = ? AND password = ?");
        $stmt->bind_param('ss', $username, $password);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id);

        while ($stmt->fetch());

        $stmt->close();

        return $id;
    }

	public function getUsername($userid) {
		$stmt = $this->conn->prepare("SELECT name FROM users WHERE id = ?");
		$stmt->bind_param('i', $userid);

		try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($name);

        while ($stmt->fetch());

        $stmt->close();

        return $name;
	}

    public function getChallenges() {
        $stmt = $this->conn->prepare("SELECT id, name, score FROM challenges WHERE active = 1");

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id, $name, $score);

        $out = array();

        while ($stmt->fetch()) {
            $out[$id] = array(
                'name' => $name,
                'score' => $score
            );
        }

        $stmt->close();

        return $out;
    }

    public function getChallengeDetails($challengeid, $userid) {
        $stmt = $this->conn->prepare("SELECT C.id, C.score, COUNT(S.challengeid) AS passed FROM challenges AS C INNER JOIN score AS S ON C.id = S.challengeid WHERE C.id = ? AND S.userid = ?");
        $stmt->bind_param('ii', $challengeid, $userid);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id, $score, $passed);

        while ($stmt->fetch());

        $stmt->close();

        return array(
			'id' => $id,
            'score' => $score,
            'passed' => $passed
        );
    }

    public function setCompleted($userid, $challengeid) {
        $stmt = $this->conn->prepare("INSERT INTO score (userid, challengeid) VALUES (?, ?)");
        $stmt->bind_param('ii', $userid, $challengeid);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }

            $id = $stmt->insert_id;

            if (!$id) {
                throw new Exception('Error: failed to get id');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->close();

        return $id;
    }

    public function getCompleted($userid) {
        $stmt = $this->conn->prepare("SELECT C.id, C.name, C.score FROM challenges AS C INNER JOIN score AS S ON C.id = S.challengeid WHERE S.userid = ? AND C.active = 1");
        $stmt->bind_param('i', $userid);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id, $name, $score);

        $out = array();

        while ($stmt->fetch()) {
            $out[$id] = array(
                'name' => $name,
                'score' => $score
            );
        }

        $stmt->close();

        return $out;
    }

    public function getAnswer($challengeid) {
        $stmt = $this->conn->prepare("SELECT answer FROM challenges WHERE id = ?");
        $stmt->bind_param('i', intval($challengeid));

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($answer);

        while ($stmt->fetch());

        $stmt->close();

        return $answer;
    }

    public function getHint($challengeid) {
        $stmt = $this->conn->prepare("SELECT hint FROM challenges WHERE id = ?");
        $stmt->bind_param('i', intval($challengeid));

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($hint);

        while ($stmt->fetch());

        $stmt->close();

        return $hint;
    }

	public function getAllScores() {
		$stmt = $this->conn->prepare("SELECT id, name FROM users WHERE id > 1");

		try {
			if (!$stmt->execute()) {
				throw new Exception('Error: failed to execute query');
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}

		$users = array();

		$stmt->store_result();
		$stmt->bind_result($id, $name);

		while ($stmt->fetch()) {
			$users[$id] = array(
				'name' => $name
			);
		}

		$stmt->close();

		foreach ($users as $id => $user) {
			$users[$id]['challenges'] = $this->getCompleted($id);
		}

		return $users;
	}
}