<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: login.php');
  exit();
}

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$post_id) {
  header('Location: index.php');
  exit();
}

$db = dbconnect();
$stmt = $db->prepare('DELETE FROM posts WHERE id=? AND member_id=? limit 1'); //1件のみ削除されるはずだが事故防止のため「limit 1」
if (!$stmt) {
  die($db->error);
}
$stmt->bind_param('ii', $post_id, $id);
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}
header('Location: index.php'); exit();
?>
