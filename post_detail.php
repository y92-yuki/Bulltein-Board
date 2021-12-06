<?php
session_start();
require_once('content.php');

$record = $board->detail_select();

$_SESSION['id']        = $record['id'];
$_SESSION['name']      = $record['name'];
$_SESSION['message']   = $record['message'];
$_SESSION['post_date'] = $record['post_date'];


$errors = $board->comment_controller($_POST['modify_confirm_send']);
$error = ['comment_error' => $errors[1]];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>投稿ID<?= $_SESSION['id'] ?>の詳細</title>
    </head>
        <body>
            <?php if (isset($_POST['modify_send'])): ?>
                コメントID<?= $_SESSION['id'] ?>を編集します
                <form action="" method="post">
                    <textarea name="message" rows="5" cols="40"></textarea><br>
                    <button type="submit" name="modify_confirm_send">確認</button>
                    <button type="button" onclick="location.href='post_detail.php?id=<?= $_SESSION['id'] ?>'">戻る</button>
                </form>
            <?php elseif (isset($_POST['modify_confirm_send'])): ?>
                <span style="color:red;"><?php if (isset($error)) {
                    echo $error['comment_error'];
                } ?></span>
                <h1>変更内容の確認</h1>
                <form action="board.php" method="post">
                    変更後のコメント<br>
                    <?= $_POST['message'] ?>
                    <input type="hidden" name="modify_id" value="<?= $_SESSION['id'] ?>">
                    <input type="hidden" name="modify_message" value="<?= $_POST['message'] ?>"><br>
                    <?php if (isset($error['comment_error'])): ?>
                        <button type="button" onclick="location.href='post_detail.php?id=<?= $_SESSION['id'] ?>'">戻る</button>
                    <?php elseif(empty($error['comment_error'])): ?>
                            <button type="submit" name="execute_modify">確定</button> <button type="button" onclick="location.href='post_detail.php?id=<?= $_SESSION['id'] ?>'">戻る</button>
                    <?php endif ?>
                </form>
            <?php elseif (!isset($_POST['modify_send'])): ?>
                <h1>投稿ID<?= $_SESSION['id'] ?>の詳細</h1>
                <div>
                    <p style="font-size: 20px;">
                        投稿者名<br>
                        <?= $record['name'] ?>
                    </p>
                    <p style="font-size: 20px;">
                        内容<br>
                        <?= $record['message'] ?>
                    </p>
                    <p>投稿時間:<?= $record['post_date'] ?></p>
                </div>
                <div style="display: inline-flex;">
                    <form action="" method="post" class="modify_submit">
                        <button type="submit" name="modify_send">編集</button>
                    </form>
                    <div>
                        <button type="button" onclick="location.href='post_delete.php'">削除</button>
                    </div>
                    <div><button type="button" onclick="location.href='board.php'">戻る</button></div>
                </div>
            
            <?php endif ?>
        </body>
</html>
