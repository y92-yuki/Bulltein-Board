<?php
session_start();
require_once('pdo_controller.php');
$rows = [];



if (isset($_POST['confirm_send']) && empty($_SESSION['error'])) {
    $success = $board->insert();
}

$rows = $board->select();

?>
<style>
    .content {
        margin: 0px 10px;
        padding: 10px;
        background-color: beige;
        border: 1px solid #ccc;
    }

    .index {
        text-align: center;
        font-size: 20px;
    }

    span {
        color: green;
    }
</style>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    </head>
    <body>
        <span><?php if (isset($success)) {
            echo $success;
        } ?></span>
        <h1>ひと言掲示板</h1>
        <button type="button" onclick="location.href='post.php'">投稿画面へ</button>
        <?php if (isset($rows)): ?>
            <p class="index">投稿内容</p>
            <?php foreach ($rows as $row): ?>
                <div class="content">
                    <p>名前:<?= $row['name'] ?> <?= $row['post_date'] ?><p></p>
                    <?= $row['message'] ?>
                </div>
                <br>
            <?php endforeach ?>
        <?php endif ?>
    </body>
</html>