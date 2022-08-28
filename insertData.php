<?php

include 'connection.php';

$result = $conn->prepare('INSERT INTO users SET username=?, password=?');
$result->bindValue(1, $_POST['username']);
$result->bindValue(2, $_POST['password']);
$result->execute();