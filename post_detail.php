<?php
session_start();
require_once('pdo_controller.php');

$_SESSION['id'] = $_GET['id'];
if (isset($_POST['modify_confirm_send'])) {
    $_SESSION['messge'] = $_POST['message'];
}

$error = $board->comment_controller($_POST['modify_confirm_send']);

$record = $board->detail_select();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>投稿ID<?= $_SESSION['id'] ?>の詳細</title>
    </head>
        <body>
            <?php if (isset($_POST['modify_send'])): ?>
                コメントID<?= $_GET['id'] ?>を編集します
                <form action="" method="post">
                    <textarea name="message" rows="5" cols="40"></textarea><br>
                    <button type="submit" name="modify_confirm_send">確認</button>
                </form>
            <?php elseif (isset($_POST['modify_confirm_send'])): ?>
                <span style="color:red;"><?php if (isset($error)) {
                    echo $error[1];
                } ?></span>
                <h1>変更内容の確認</h1>
                <form action="board.php" method="post">
                    変更後のコメント<br>
                    <?= $_POST['message'] ?>
                    <input type="hidden" name="modify_id" value="<?= $_SESSION['id'] ?>">
                    <input type="hidden" name="modify_message" value="<?= $_POST['message'] ?>"><br>
                    <?php if (isset($error[1])): ?>
                        <button type="button" onclick="location.href='post_detail.php?id=<?= $_SESSION['id'] ?>'">戻る</button>
                    <?php elseif(empty($error[1])): ?>
                            <button type="submit" name="execute_modify">確定</button> <button type="button" onclick="location.href='post_detail.php?id=<?= $_SESSION['id'] ?>'">戻る</button>
                    <?php endif ?>
                </form>
            <?php elseif (!isset($_POST['modify_send'])): ?>
                <h1>投稿ID<?= $_SESSION['id'] ?>の詳細</h1>
                <div>
                    <p class="detail_name">
                        投稿者名<br>
                        <?= $record['name'] ?>
                    </p>
                    <p>
                        内容<br>
                        <?= $record['message'] ?>
                    </p>
                    <p>投稿時間:<?= $record['post_date'] ?></p>
                </div>
                <form action="" method="post">
                    <button type="submit" name="modify_send">編集</button>
                    <button type="button" onclick="location.href='board.php'">戻る</button>
                </form>
            
           
            
            <?php endif ?>
        </body>
</html>
