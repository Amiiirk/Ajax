<?php

include 'connection.php';
$id = $_POST['id'];

$result = $conn->prepare('DELETE FROM users WHERE id = ?');
$result->bindValue(1, $id);
$result->execute();