<?php
// htmlspecialcharsを短くする
function h($value) {
  return htmlspecialchars($value, ENT_QUOTES);
}

// DBへの接続
function dbconnect() {
  $db = new mysqli('localhost', 'root', 'mysqlpa55', 'min_bbs');
  if (!$db) { //DB接続チェック
    die($db->error);
  }
  return $db;
}
?>