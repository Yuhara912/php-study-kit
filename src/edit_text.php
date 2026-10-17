<?php
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
    $memo = null;
    if($pdo === null){
        $message = 'データベース接続に失敗しました。メモの取得に失敗しました。';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM memos WHERE id = :id");
        $stmt->execute(['id' => $_POST['ids'][0]]);
        $memo = $stmt->fetchAll();
    }
    

    if($_SERVER['REQUEST_METHOD'] === 'POST') { 
        $idsToEdit = $_POST['ids'] ?? [];
        if (!empty($idsToEdit)) {
            $placeholders = implode(',', array_fill(0, count($idsToEdit), '?'));
            $stmt = $pdo->prepare("UPDATE memos SET content = :content WHERE id IN ($placeholders)");
            $stmt->execute(array_merge(['content' => $_POST['content']], $idsToEdit));
            $message = '選択されたメモが編集されました。';
        } else {
            $message = '編集するメモが選択されていません。';
        }
    }
?>

<!DOCTYPE html>
    <html lang = "ja">
        <head>
            <meta charset="UTF-8">
            <title>メモ編集</title>
        </head>
        <body>
            <form method="post" accept-charset="UTF-8" action = "edit_memo.php">
                <textarea name = "content" value=><?php echo htmlspecialchars($memo['content'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                <button type = "submit">更新</button>
            </form>
        </body>
    </html>