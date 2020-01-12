<?php
require_once 'db.php';

if (isset($_POST['show'])) {
    $sql = 'UPDATE form SET skip = 0 WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['show']]);

    header('location:/admin.php');
}

if (isset($_POST['skip'])) {
    $sql = 'UPDATE form SET skip = 1 WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['skip']]);

    header('location:/admin.php');
}

if (isset($_POST['delete'])) {
    $sql = 'DELETE FROM form WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['delete']]);

    header('location:/admin.php');
}