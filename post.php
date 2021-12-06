<?php
require_once('content.php');


$error = $board->comment_controller($_POST['message_send']);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>投稿登録画面</title>
    </head>
    <body>
        <?php if (!isset($_POST['message_send'])): ?>
            <form action="" method="post">
                <h1>コメントを入力します</h1>
                <div>
                    名前<br> 
                    <input type="text" name="name"> 
                </div>
                <div>
                    コメント<br>
                    <textarea name="message" rows="5" cols="40"></textarea>
                </div>
                <button type="submit" name="message_send">確認</button> <button type="button" onclick="location.href='board.php'">戻る</button>
            </form>
        <?php elseif(isset($_POST['message_send'])): ?>
            <?php if (isset($error)): ?>
                <ul>
                    <?php foreach($error as $value): ?>
                        <li><span style="color:red;"><?= $value ?></span></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <p>投稿内容確認</p>
            <div>
                名前<br>
                <?= $_POST['name'] ?><br>
            </div>
            <br>
            <div>
                内容<br>
                <?= $_POST['message'] ?><br>
            </div>
            <form action="board.php" method="post">
                <input type="hidden" name="name" value="<?php echo $_POST['name'] ?>">
                <input type="hidden" name="message" value="<?php echo $_POST['message'] ?>">
                <?php if (empty($error)): ?><br>
                    <button type="submit" name='confirm_send'>投稿する</button> <button type="button" onclick="history.back()">戻る</button>
                <?php elseif (isset($error)): ?>
                    <button type="button" onclick="location.href='post.php'">戻る</button>
                <?php endif ?>
            </form>
        <?php endif ?>

    </body>
</html>
