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
        $message = 'データベース接続に失敗しました。メモの取得に失敗しました。';
    } else {
        $stmt = $pdo->query("SELECT * FROM memos");
        $memos = $stmt->fetchAll();
    }
?>
<!DOCTYPE html>
    <html lang = "ja">
        <head>
            <meta charset="UTF-8">
            <title>メモ編集</title>
        </head>
        <body>
            <table>
                <th></th>
                <th>No</th>
                <th>メモ内容</th>
                <?php foreach($memos as $memo) : ?>
                    <tr>
                        <td>
                            <input
                            type="checkbox"
                            name="ids[]"
                            value="<?php echo $memo['id']; ?>">
                        </td>
                        <td><?php echo $memo['id']; ?></td>
                        <td><?php echo $memo['content']; ?></td>
                    </tr>
                <?php endforeach?>
            </table>
            <form action = "edit_text.php" method = "post">
                <button type = "submit" >編集</button>
            </form>
            <form action="show_memo.php" method = "get">
                <button type = "submit">戻る</button>
            </form>
        </body>
    </html>