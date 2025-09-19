<?php
require_once 'classes/Post.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? null;

  if (!$id) {
    header('Location: index.php?error=Client ID not provided');
    exit();
  }

  $data = [
    'name' => trim($_POST['name'] ?? ''),
    'lastname' => trim($_POST['lastname'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'address' => trim($_POST['address'] ?? '')
  ];

  $post = new Post();
  $result = $post->edit($id, $data);

  if ($result === true) {
    header('Location: index.php?success=1');
    exit();
  } else {
    header('Location: edit.php?id=' . $id . '&error=' . urlencode($result));
    exit();
  }
} else {
  header('Location: index.php');
  exit();
}
