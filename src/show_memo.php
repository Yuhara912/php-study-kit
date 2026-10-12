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
    $memos = [];
    if($pdo === null){
        $message = 'データベース接続に失敗しました。メモの登録に失敗しました。';
    } else {
        $stmt = $pdo->query("SELECT * FROM memos");
        $memos = $stmt->fetchAll();
    }
?>

<!DOCTYPE html>
    <html lang = 'ja'>
        <head>
            <meta charset = 'UTF-8'>
            <title>メモ一覧</title>
        </head>
        <body>
            <table>
                <th>
                    ID
                </th>
                <th>
                    メモ内容
                </th>
                <?php foreach($memos as $memo): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($memo['id'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($memo['content'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <form action="index.php" method = "get">
                <button type = "submit">戻る</button>
            </form>
            <form action="delete_memo.php" method = "get">
                <button type = "submit">メモ削除</button>
            </form>
            <form action="edit_memo.php" method = "get">
                <button type = "submit">メモ編集</button>
            </form>
        </body>