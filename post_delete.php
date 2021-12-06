<?php
session_start();
require_once('content.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>投稿削除</title>
</head>
    <body>
        <h1>コメントID<?= $_SESSION['id'] ?>を削除します</h1>
            <div>
                <p style="font-size: 20px;">
                    投稿者名<br>
                    <?= $_SESSION['name'] ?>
                </p>
                <p style="font-size: 20px;">
                    内容<br>
                    <?= $_SESSION['message'] ?>
                </p>
                <p>投稿時間:<?= $_SESSION['post_date'] ?></p>
            </div>
        <form action="board.php" method="post">
            <button type="submit" name="id" value="<?= $_SESSION['id'] ?>">確定</button>
            <button type="button" onclick="location.href='post_detail.php?id=<?=$_SESSION['id'] ?>'">戻る</button>
        </form>
    </body>
</html>