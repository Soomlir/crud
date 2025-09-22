<?php
session_start();
require_once 'classes/Post.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header('Location: index.php?error=Invalid client ID');
  exit();
}

$id = (int)$_GET['id'];

$post = new Post();
$result = $post->delete($id);

if ($result === true) {
  $_SESSION['success'] = 'Client deleted successfully';
  header('Location: index.php');
  exit();
} else {
  header('Location: index.php?error=' . urlencode($result));
  exit();
}
