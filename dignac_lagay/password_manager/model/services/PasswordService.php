<?php

class PasswordService
{
    protected $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function createPassword($user_id, $label, $login, $password) {
        $stmt = $this->mysqli->prepare("INSERT INTO passwords (user_id, label, login, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $user_id, $label, $login, $password);

        if (!($data = $stmt->execute())) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        return $data;
    }

    public function getPasswords($user_id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM passwords WHERE user_id = ?");

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        $data = $stmt->get_result();

        $results = [];
        while ($obj = $data->fetch_assoc()) {
            $results[] = $obj;
        }

        return $results;
    }

}