<?php
session_start();
require_once 'classes/Post.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'name' => trim($_POST['name'] ?? ''),
    'lastname' => trim($_POST['lastname'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'address' => trim($_POST['address'] ?? '')
  ];

  $post = new Post();
  $result = $post->create($data);

  if ($result) {
    $_SESSION['success'] = 'The client has been successfully added';
    header('Location: index.php');
    exit();
  } else {
    header('Location: create.php?error=' . urlencode($result));
    exit();
  }
} else {
  header('Location: create.php');
  exit();
}
