<?php

class UserService
{
    protected $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getUsers()
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users");
        if (!$stmt->execute()) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        $data = $stmt->get_result();

        return $data;
    }

    public function getUserByMail($mail) {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE mail = ?");
        $stmt->bind_param('s', $mail);

        if (!$stmt->execute()) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        $data = $stmt->get_result();

        return $data->fetch_object();
    }

    public function getUserIdByUUID($uuid)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE uuid = ?");
        $stmt->bind_param('s', $uuid);

        if (!$stmt->execute()) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        $data = $stmt->get_result();

        return $data->fetch_object();
    }

    public function register($mail, $master_password) {
        $stmt = $this->mysqli->prepare("INSERT INTO users (mail, master_password) VALUES (?, ?)");
        $stmt->bind_param('ss', $mail, $master_password);

        if (!($data = $stmt->execute())) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        return $data;
    }

    public function login($mail, $master_password)
    {
        $stmt = $this->mysqli->prepare("SELECT COUNT(1) AS authenticated FROM users WHERE mail = ? AND master_password = ?");
        $stmt->bind_param('ss', $mail, $master_password);
        if (!$stmt->execute()) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        $data = $stmt->get_result();

        return $data->fetch_assoc();
    }

    public function updateUUID($uuid, $mail) {
        $stmt = $this->mysqli->prepare("UPDATE users SET uuid = ? WHERE mail = ?");
        $stmt->bind_param('ss', $uuid, $mail);

        if (!($data = $stmt->execute())) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        return $data;
    }
}