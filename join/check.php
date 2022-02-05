<?php
session_start();
require('../library.php');
// var_dump($_SESSION['form']);

if (isset($_SESSION['form'])) {
	$form = $_SESSION['form'];
} else {
	header('Location: index.php');
	exit();
}

// データをDBに登録する
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POST送信されたらDBに接続
	$db = dbconnect(); //DB接続
	$stmt = $db->prepare('INSERT INTO members (name, email, password, picture) VALUES (?, ?, ?, ?)');
	if (!$stmt) { //SQL構文チェック
		die($db->error);
	}
	$password = password_hash($form['password'], PASSWORD_DEFAULT); //パスワードをハッシュ化
	$stmt->bind_param('ssss', $form['name'], $form['email'], $password, $form['image']); //プレースホルダーに値をバインド
	$success = $stmt->execute();
	if (!$success) { //実行結果チェック
		die($db->error);
	}

	//完了ページに遷移
	unset($_SESSION['form']);	//セッション情報を削除
	header('Location: thanks.php');
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../style.css" />
</head>

<body>
	<div id="wrap">
		<div id="head">
			<h1>会員登録</h1>
		</div>

		<div id="content">
			<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
			<form action="" method="post">
				<dl>
					<dt>ニックネーム</dt>
					<dd><?php echo h($form['name']); ?></dd>
					<dt>メールアドレス</dt>
					<dd><?php echo h($form['email']); ?></dd>
					<dt>パスワード</dt>
					<dd>
						【表示されません】
					</dd>
					<dt>写真など</dt>
					<dd>
							<img src="../member_picture/<?php echo h($form['image']); ?>" width="100" alt="" />
					</dd>
				</dl>
				<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
			</form>
		</div>

	</div>
</body>

</html>