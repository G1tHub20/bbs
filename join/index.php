<?php
session_start(); //セッションの開始
require('../library.php'); //外部ファイルの読み込み

// 書き直すリンクがクリックされたとき
if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) { //URLパラメータとセッションをチェック
  $form = $_SESSION['form']; //フォームに値をセット
} else {
  // 変数を初期化 ※エラー防止のため
  $form = [
  'name' => '',
  'email' => '',
  'password' => '',
  'image' => ''
  ];
}
$error = [];


// フォームの内容をチェック
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POST送信されたら
  $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); //外部変数をフィルタリングして取得
  if ($form['name'] === '') { //内容に応じたエラーを設定
    $error['name'] = 'blank';
  }
  $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  if ($form['email'] === '') {
    $error['email'] = 'blank';
  } else {
    // メールアドレスの重複チェック
    $db = dbconnect();
    $stmt = $db->prepare('SELECT COUNT(*) FROM members WHERE email=?'); //同一メールアドレスの件数を取得
    if (!$stmt) {
      die($db->error);
    }
    $stmt->bind_param('s', $form['email']);
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }
    $stmt->bind_result($cnt);
    $stmt->fetch();
    if ($cnt > 0) { //メールアドレスの重複があるなら
      $error['email'] = 'duplicate';
    }
    // var_dump($cnt);
  }
  $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  if ($form['password'] === '') {
    $error['password'] = 'blank';
  } else if (strlen($form['password']) < 4) {
    $error['password'] = 'length';
  }
  
  // 画像のチェック
  $image = $_FILES['image'];
  if ($image['name'] !== '' && $image['error'] === 0) {  //画像が指定されており、エラー無しなら
    $type = mime_content_type($image['tmp_name']); //画像のファイル形式を取得
    if ($type !== 'image/png' && $type !== 'image/jpeg') { //ファイル形式チェック
      $error['image'] = 'type';
    }
    // var_dump($type);
  }
  
  if (empty($error)) { //すべてエラー無しなら
    $_SESSION['form'] = $form; //セッションに保存

    // 画像のアップロード
    if ($image['name'] !== '') { //画像が指定されているなら
      $filename = date('YmdHis') . '_' . $image['name']; //ユニークなファイル名を設定
      if (!move_uploaded_file($image['tmp_name'], '../member_picture/' . $filename)) { //テンポラリから正規フォルダにアップロード
        die('ファイルのアップロードに失敗しました');
      }
      // echo $filename;
      $_SESSION['form']['image'] = $filename; //ファイル名をセッションに保存
    }
    //確認ページに遷移
    header('Location: check.php');
    exit();
  }
  } else {
    $_SESSION['form']['image'] = '';
  }

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>会員登録</title>
  <link rel="stylesheet" href="../style.css"/>
</head>

<body>
<div id="wrap">
  <div id="head">
  <h1>会員登録</h1>
  </div>

  <div id="content">
  <p>次のフォームに必要事項をご記入ください。</p>
  <form action="" method="post" enctype="multipart/form-data"> <!-- action属性を空にして自分自身を再度呼び出す -->
    <dl>
    <dt>ニックネーム<span class="required">必須</span></dt>
    <dd>
      <input type="text" name="name" size="35" maxlength="255" value="<?php echo h($form['name']); ?>"/>
      <?php if (isset($error['name']) && $error['name'] === 'blank'): ?> <!-- エラーに応じてメッセージを出力 -->
        <p class="error">* ニックネームを入力してください</p>
      <?php endif; ?>
    </dd>
    <dt>メールアドレス<span class="required">必須</span></dt>
    <dd>
      <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($form['email']); ?>"/>
      <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
        <p class="error">* メールアドレスを入力してください</p>
      <?php endif; ?>
      <?php if (isset($error['email']) && $error['email'] ==='duplicate'): ?> 
        <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
      <?php endif; ?>
    <dt>パスワード<span class="required">必須</span></dt>
    <dd>
      <input type="password" name="password" size="10" maxlength="20" value="<?php echo h($form['password']); ?>"/>
      <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
        <p class="error">* パスワードを入力してください</p>
      <?php endif; ?>
      <?php if (isset($error['password']) && $error['password'] === 'length'): ?>
        <p class="error">* パスワードは4文字以上で入力してください</p>
      <?php endif; ?>
    </dd>
    <dt>写真など</dt>
    <dd>
      <input type="file" name="image" size="35" value=""/>
      <?php if (isset($error['image']) && $error['image'] === 'type'): ?>
        <p class="error">* 写真などは「.png」または「.jpg」の画像を指定してください</p>
      <?php endif; ?>
      <p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
    </dd>
    </dl>
    <div><input type="submit" value="入力内容を確認する"/></div>
  </form>
  </div>
</body>

</html>

<!-- http://localhost/bbs/ -->