<?php

include 'connection.php';

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];

$result = $conn->prepare('UPDATE users SET username = ?, password = ? WHERE id = ?');
$result->bindValue(1, $username);
$result->bindValue(2, $password);
$result->bindValue(3, $id);
$result->execute();