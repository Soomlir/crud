<?php
require_once 'classes/Post.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header('Location: index.php?error=Invalid client ID');
  exit();
}

$id = (int)$_GET['id'];

$post = new Post();
$result = $post->delete($id);

if ($result === true) {
  header('Location: index.php?success=Client deleted successfully');
  exit();
} else {
  header('Location: index.php?error=' . urlencode($result));
  exit();
}
