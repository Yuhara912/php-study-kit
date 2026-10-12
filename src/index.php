<?php
$message = '';
$content = '';

try{
    // データベース接続
    $host = 'db';
    $dbname = 'php_study';
    $user = 'php_user';
    $password = 'php_password';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // 確実に接続文字セットを設定するための初期コマンド
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
        ];
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $password,
            $options
        );
} catch (PDOException $e) {
    $message = 'データベース接続に失敗しました: ' . $e->getMessage();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $content = $_POST['content'] ?? '';
    if(trim($content) === ''){
        $message = 'メモが入力されていません。';
    } else {
        if($pdo === null){
            $message = 'データベース接続に失敗しました。メモの登録に失敗しました。';
        } else {
            $stmt = $pdo->prepare("INSERT INTO memos (content) VALUES (:content)");
            $stmt->execute(['content' => $content]);
            $message = 'メモが登録されました。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メモ登録</title>
</head>
<body>
    <h1>メモ登録</h1>
    <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <form method="post" accept-charset="UTF-8">
        <textarea name = "content"></textarea>
        <button type = "submit">登録</button>
    </form>
    <form action="show_memo.php" method="get">
        <button type = "submit">メモ一覧</button>
    </form>
</body>
</html>