<?php

include 'connection.php';

$result = $conn->prepare('SELECT * FROM users');
$result->execute();
$users = $result->fetchAll(PDO::FETCH_ASSOC);
$num = 1;
?>

<?php foreach ($users as $user) { ?>
<tr>
    <th scope="row"><?= $num++ ?></th>
    <td><?= $user['username'] ?></td>
    <td><?= $user['password'] ?></td>
    <td>
        <button class="btn btn-warning" id="edit-user" data-bs-toggle="modal" data-bs-target="#exampleModal"
            value="<?= $user['id'] ?>">Edit
        </button>
        <button class="btn btn-danger" id="delete-user" value="<?= $user['id'] ?>">Delete</button>
    </td>
</tr>
<?php } ?>