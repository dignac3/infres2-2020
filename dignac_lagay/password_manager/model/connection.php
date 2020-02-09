<?php

function getConnection()
{
    $mysqli = new mysqli("127.0.0.1", "user", "user", "password_manager") or die(mysqli_error());
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    return $mysqli;
}
?>